<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard SDN 009';
    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverviewWidget::class,
            \App\Filament\Widgets\DocumentsChartWidget::class,
            \App\Filament\Widgets\RecentDocumentsWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('view_dashboard');
    }
}
