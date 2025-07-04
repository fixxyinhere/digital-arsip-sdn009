<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DocumentsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Dokumen Upload per Bulan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::model(Document::class)
            ->between(
                start: now()->subMonths(11),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Dokumen',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#3B82F6',
                    'borderColor' => '#1D4ED8',
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
