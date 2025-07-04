<?php
// app/Filament/Resources/RoleResource/Pages/EditRole.php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\Permission;
use Filament\Notifications\Notification;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // IMPORTANT: Load existing permissions
        $data['permission_list'] = $this->record->permissions->pluck('name')->toArray();

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Extract permission data
        $selectedPermissions = $data['permission_list'] ?? [];

        // Remove permission data from role data
        unset($data['permission_list']);

        // Update role basic info
        $record->update($data);

        // Sync permissions
        if (!empty($selectedPermissions)) {
            $permissions = Permission::whereIn('name', $selectedPermissions)->get();
            $record->syncPermissions($permissions);
        } else {
            // If no permissions selected, remove all permissions
            $record->syncPermissions([]);
        }

        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return $record;
    }

    protected function getSavedNotification(): ?\Filament\Notifications\Notification
    {
        $permissionCount = $this->record->fresh()->permissions->count();

        return Notification::make()
            ->success()
            ->title('Peran berhasil diperbarui!')
            ->body("Peran '{$this->record->name}' sekarang memiliki {$permissionCount} izin.")
            ->duration(5000);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
