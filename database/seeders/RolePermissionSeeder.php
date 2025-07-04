<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view_dashboard',
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            'view_document_types',
            'create_document_types',
            'edit_document_types',
            'delete_document_types',
            'view_documents',
            'create_documents',
            'edit_documents',
            'delete_documents',
            'download_documents',
            'view_all_documents',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',
            'view_access_logs',
            'manage_backup',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Operator - Full access
        $operatorRole = Role::create(['name' => 'operator']);
        $operatorRole->givePermissionTo(Permission::all());

        // Kepala Sekolah - Limited admin access
        $kepalaSekolahRole = Role::create(['name' => 'kepala_sekolah']);
        $kepalaSekolahRole->givePermissionTo([
            'view_dashboard',
            'view_categories',
            'view_document_types',
            'view_documents',
            'create_documents',
            'edit_documents',
            'download_documents',
            'view_all_documents',
            'view_users',
            'view_access_logs',
        ]);

        // Guru - Basic access
        $guruRole = Role::create(['name' => 'guru']);
        $guruRole->givePermissionTo([
            'view_dashboard',
            'view_categories',
            'view_document_types',
            'view_documents',
            'download_documents',
        ]);
    }
}
