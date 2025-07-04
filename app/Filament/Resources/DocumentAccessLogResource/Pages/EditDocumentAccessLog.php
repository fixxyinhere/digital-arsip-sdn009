<?php

namespace App\Filament\Resources\DocumentAccessLogResource\Pages;

use App\Filament\Resources\DocumentAccessLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocumentAccessLog extends EditRecord
{
    protected static string $resource = DocumentAccessLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
