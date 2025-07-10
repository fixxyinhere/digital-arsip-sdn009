<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    /**
     * Modify data sebelum disimpan
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set user yang mengupload
        $data['uploaded_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        return $data;
    }

    /**
     * Redirect setelah berhasil create
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
