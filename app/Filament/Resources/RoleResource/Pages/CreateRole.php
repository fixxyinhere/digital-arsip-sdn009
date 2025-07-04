<?php

// app/Filament/Resources/RoleResource/Pages/CreateRole.php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\CreateRecord;
use Spatie\Permission\Models\Permission;
use Filament\Notifications\Notification;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Extract permission data
        $permissionIds = $data['permission_ids'] ?? [];
        $permissionNames = $data['permission_names'] ?? [];

        // Remove permission data from role data
        unset($data['permission_ids'], $data['permission_names']);

        // Create role
        $record = static::getModel()::create($data);

        // Assign permissions
        if (!empty($permissionIds)) {
            $permissions = Permission::whereIn('id', $permissionIds)->get();
            $record->syncPermissions($permissions);
        } elseif (!empty($permissionNames)) {
            $permissions = Permission::whereIn('name', $permissionNames)->get();
            $record->syncPermissions($permissions);
        }

        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        return Notification::make()
            ->success()
            ->title('Peran berhasil dibuat')
            ->body('Peran baru telah dibuat dengan izin yang dipilih.');
    }
}
