<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentDocumentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Dokumen Terbaru';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Document::query()
                    ->with(['category', 'uploader', 'documentType'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Dokumen')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('confidentiality_level')
                    ->label('Tingkat Kerahasiaan')
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
                    ->label('Diupload oleh'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ]);
    }
}
