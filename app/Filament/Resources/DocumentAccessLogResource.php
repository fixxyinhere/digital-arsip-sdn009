<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentAccessLogResource\Pages;
use App\Models\DocumentAccessLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DocumentAccessLogResource extends Resource
{
    protected static ?string $model = DocumentAccessLog::class;
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationLabel = 'Log Akses';
    protected static ?string $modelLabel = 'Log Akses';
    protected static ?string $pluralModelLabel = 'Log Akses';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Monitoring';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('accessed_at')
                    ->label('Waktu Akses')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('document.title')
                    ->label('Dokumen')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('document.document_number')
                    ->label('No. Dokumen')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('action_label')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Lihat' => 'info',
                        'Unduh' => 'success',
                        'Unggah' => 'warning',
                        'Update' => 'primary',
                        'Hapus' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable()
                    ->copyable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('action')
                    ->label('Aksi')
                    ->options([
                        'view' => 'Lihat',
                        'download' => 'Unduh',
                        'upload' => 'Unggah',
                        'update' => 'Update',
                        'delete' => 'Hapus',
                    ]),

                Tables\Filters\Filter::make('accessed_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('accessed_at', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('accessed_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->defaultSort('accessed_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['user', 'document']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentAccessLogs::route('/'),
            'view' => Pages\ViewDocumentAccessLog::route('/{record}'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_access_logs');
    }

    public static function canCreate(): bool
    {
        return false; // Logs tidak bisa dibuat manual
    }

    public static function canEdit($record): bool
    {
        return false; // Logs tidak bisa diedit
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('manage_backup'); // Hanya operator
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('manage_backup');
    }
}
