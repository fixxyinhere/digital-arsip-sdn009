<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRole extends ViewRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->visible(fn() => auth()->user()->can('edit_roles')),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Show permissions in view mode
        $data['permission_ids'] = $this->record->permissions->pluck('id')->toArray();
        $data['permission_names'] = $this->record->permissions->pluck('name')->toArray();

        return $data;
    }
}