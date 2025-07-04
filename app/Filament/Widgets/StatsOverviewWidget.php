<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use App\Models\User;
use App\Models\Category;
use App\Models\DocumentAccessLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Dokumen', Document::count())
                ->description('Semua dokumen dalam sistem')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Dokumen Aktif', Document::where('is_active', true)->count())
                ->description('Dokumen yang aktif')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Kategori', Category::where('is_active', true)->count())
                ->description('Kategori yang tersedia')
                ->descriptionIcon('heroicon-m-folder')
                ->color('warning'),

            Stat::make('Total Pengguna', User::where('is_active', true)->count())
                ->description('Pengguna aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Akses Hari Ini', DocumentAccessLog::whereDate('accessed_at', today())->count())
                ->description('Akses dokumen hari ini')
                ->descriptionIcon('heroicon-m-eye')
                ->color('primary'),

            Stat::make('Total Storage', $this->getStorageSize())
                ->description('Total ukuran file')
                ->descriptionIcon('heroicon-m-server')
                ->color('gray'),
        ];
    }

    private function getStorageSize(): string
    {
        $totalBytes = Document::sum('file_size') ?: 0;

        if ($totalBytes >= 1073741824) {
            return number_format($totalBytes / 1073741824, 2) . ' GB';
        } elseif ($totalBytes >= 1048576) {
            return number_format($totalBytes / 1048576, 2) . ' MB';
        } elseif ($totalBytes >= 1024) {
            return number_format($totalBytes / 1024, 2) . ' KB';
        } else {
            return $totalBytes . ' bytes';
        }
    }
}
