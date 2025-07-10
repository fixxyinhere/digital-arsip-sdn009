<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use App\Models\DocumentAccessLog;
use App\Models\Category;
use App\Models\DocumentType;
use App\Services\DocumentAccessLogger;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Dokumen';
    protected static ?string $modelLabel = 'Dokumen';
    protected static ?string $pluralModelLabel = 'Dokumen';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Arsip Digital';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Dokumen')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('document_number')
                            ->label('Nomor Dokumen')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->default(fn() => 'DOC-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT)),

                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->options(Category::where('is_active', true)->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('document_type_id')
                            ->label('Tipe Dokumen')
                            ->options(DocumentType::where('is_active', true)->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),

                        Forms\Components\DatePicker::make('document_date')
                            ->label('Tanggal Dokumen')
                            ->required()
                            ->default(now()),

                        Forms\Components\Select::make('confidentiality_level')
                            ->label('Tingkat Kerahasiaan')
                            ->required()
                            ->options([
                                'public' => 'Publik',
                                'internal' => 'Internal',
                                'confidential' => 'Rahasia',
                                'secret' => 'Sangat Rahasia',
                            ])
                            ->default('internal'),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('file_path')
                            ->label('File Dokumen')
                            ->required()
                            ->directory('documents')
                            ->preserveFilenames()
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $set('original_name', $state->getClientOriginalName());
                                    $set('file_name', $state->hashName());
                                    $set('mime_type', $state->getMimeType());
                                    $set('file_size', $state->getSize());
                                }
                            })
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('original_name'),
                        Forms\Components\Hidden::make('file_name'),
                        Forms\Components\Hidden::make('mime_type'),
                        Forms\Components\Hidden::make('file_size'),
                        Forms\Components\Hidden::make('uploaded_by')
                            ->default(auth()->id()),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('document_number')
                    ->label('No. Dokumen')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('documentType.name')
                    ->label('Tipe')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('confidentiality_level')
                    ->label('Kerahasiaan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'public' => 'success',
                        'internal' => 'info',
                        'confidential' => 'warning',
                        'secret' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'public' => 'Publik',
                        'internal' => 'Internal',
                        'confidential' => 'Rahasia',
                        'secret' => 'Sangat Rahasia',
                    }),

                Tables\Columns\TextColumn::make('uploader.name')
                    ->label('Diupload oleh')
                    ->sortable(),

                Tables\Columns\TextColumn::make('document_date')
                    ->label('Tgl Dokumen')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->options(Category::where('is_active', true)->pluck('name', 'id')),

                Tables\Filters\SelectFilter::make('document_type_id')
                    ->label('Tipe Dokumen')
                    ->options(DocumentType::where('is_active', true)->pluck('name', 'id')),

                Tables\Filters\SelectFilter::make('confidentiality_level')
                    ->label('Tingkat Kerahasiaan')
                    ->options([
                        'public' => 'Publik',
                        'internal' => 'Internal',
                        'confidential' => 'Rahasia',
                        'secret' => 'Sangat Rahasia',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Unduh')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->color('info')
                    ->action(function (Document $record) {
                        // Log download menggunakan service
                        DocumentAccessLogger::logDownload($record->id, [
                            'document_title' => $record->title,
                            'document_number' => $record->document_number,
                            'file_name' => $record->original_name,
                            'file_size' => $record->file_size,
                            'download_method' => 'filament_action',
                        ]);

                        if (!Storage::exists($record->file_path)) {
                            Notification::make()
                                ->title('File tidak ditemukan!')
                                ->danger()
                                ->send();
                            return;
                        }

                        return Storage::download($record->file_path, $record->original_name);
                    })
                    ->visible(fn() => auth()->user()->can('download_documents')),

                Tables\Actions\ViewAction::make()
                    ->before(function (Document $record) {
                        // Log view action
                        DocumentAccessLogger::logView($record->id, [
                            'document_title' => $record->title,
                            'document_number' => $record->document_number,
                            'view_type' => 'filament_view_action',
                        ]);
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()->can('edit_documents')),

                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->can('delete_documents')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete_documents')),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $user = auth()->user();

                if ($user->can('view_all_documents')) {
                    return $query;
                }

                if ($user->hasRole('guru')) {
                    return $query->whereIn('confidentiality_level', ['public', 'internal']);
                }

                return $query;
            });
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'view' => Pages\ViewDocument::route('/{record}'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }

    // Permission checks
    public static function canAccess(): bool
    {
        return auth()->user()->can('view_documents');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_documents');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_documents');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_documents');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete_documents');
    }
}
