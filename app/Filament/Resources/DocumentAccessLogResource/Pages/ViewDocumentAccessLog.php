<?php

namespace App\Filament\Resources\DocumentAccessLogResource\Pages;

use App\Filament\Resources\DocumentAccessLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDocumentAccessLog extends ViewRecord
{
    protected static string $resource = DocumentAccessLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
