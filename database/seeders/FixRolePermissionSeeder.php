<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class FixRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear existing data
        DB::table('role_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        Permission::query()->delete();
        Role::query()->delete();

        // Create permissions
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
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $operatorRole = Role::create(['name' => 'operator', 'guard_name' => 'web']);
        $operatorRole->givePermissionTo(Permission::all());

        $kepalaSekolahRole = Role::create(['name' => 'kepala_sekolah', 'guard_name' => 'web']);
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

        $guruRole = Role::create(['name' => 'guru', 'guard_name' => 'web']);
        $guruRole->givePermissionTo([
            'view_dashboard',
            'view_categories',
            'view_document_types',
            'view_documents',
            'download_documents',
        ]);

        echo "✅ Fixed! Operator: " . $operatorRole->permissions->count() . " permissions\n";
    }
}
