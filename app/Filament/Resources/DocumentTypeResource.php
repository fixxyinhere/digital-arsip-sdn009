<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentTypeResource\Pages;
use App\Models\DocumentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentTypeResource extends Resource
{
    protected static ?string $model = DocumentType::class;
    protected static ?string $navigationIcon = 'heroicon-o-document';
    protected static ?string $navigationLabel = 'Tipe Dokumen';
    protected static ?string $modelLabel = 'Tipe Dokumen';
    protected static ?string $pluralModelLabel = 'Tipe Dokumen';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tipe Dokumen')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Tipe')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TagsInput::make('allowed_extensions')
                            ->label('Ekstensi yang Diizinkan')
                            ->required()
                            ->placeholder('pdf, doc, docx'),

                        Forms\Components\TextInput::make('max_file_size_mb')
                            ->label('Ukuran Maksimal (MB)')
                            ->required()
                            ->numeric()
                            ->default(10)
                            ->minValue(1)
                            ->maxValue(100),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3),

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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tipe')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('allowed_extensions_string')
                    ->label('Ekstensi Diizinkan')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('max_file_size_mb')
                    ->label('Ukuran Max (MB)')
                    ->sortable()
                    ->suffix(' MB'),

                Tables\Columns\TextColumn::make('documents_count')
                    ->label('Jumlah Dokumen')
                    ->counts('documents')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()->can('edit_document_types')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->can('delete_document_types')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete_document_types')),
                ]),
            ]);
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
            'index' => Pages\ListDocumentTypes::route('/'),
            'create' => Pages\CreateDocumentType::route('/create'),
            // 'view' => Pages\ViewDocumentType::route('/{record}'),
            'edit' => Pages\EditDocumentType::route('/{record}/edit'),
        ];
    }

    // Permission checks
    public static function canAccess(): bool
    {
        return auth()->user()->can('view_document_types');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_document_types');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_document_types');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_document_types');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete_document_types');
    }
}
