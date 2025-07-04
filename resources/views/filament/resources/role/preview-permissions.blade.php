{{-- resources/views/filament/resources/role/preview-permissions.blade.php --}}

<div class="space-y-4">
    @if($permissions->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
                $groupedPermissions = $permissions->groupBy(function($permission) {
                    $parts = explode('_', $permission->name);
                    return implode('_', array_slice($parts, 1));
                });
            @endphp

            @foreach($groupedPermissions as $group => $perms)
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3 capitalize">
                        {{ str_replace('_', ' ', $group) }}
                    </h4>
                    <div class="space-y-2">
                        @foreach($perms as $permission)
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">
                                    @php
                                        $labels = [
                                            'view_dashboard' => 'Lihat Dashboard',
                                            'view_categories' => 'Lihat Kategori',
                                            'create_categories' => 'Buat Kategori',
                                            'edit_categories' => 'Edit Kategori',
                                            'delete_categories' => 'Hapus Kategori',
                                            'view_document_types' => 'Lihat Tipe Dokumen',
                                            'create_document_types' => 'Buat Tipe Dokumen',
                                            'edit_document_types' => 'Edit Tipe Dokumen',
                                            'delete_document_types' => 'Hapus Tipe Dokumen',
                                            'view_documents' => 'Lihat Dokumen',
                                            'create_documents' => 'Buat Dokumen',
                                            'edit_documents' => 'Edit Dokumen',
                                            'delete_documents' => 'Hapus Dokumen',
                                            'download_documents' => 'Download Dokumen',
                                            'view_all_documents' => 'Lihat Semua Dokumen (Termasuk Rahasia)',
                                            'view_users' => 'Lihat Pengguna',
                                            'create_users' => 'Buat Pengguna',
                                            'edit_users' => 'Edit Pengguna',
                                            'delete_users' => 'Hapus Pengguna',
                                            'view_roles' => 'Lihat Peran',
                                            'create_roles' => 'Buat Peran',
                                            'edit_roles' => 'Edit Peran',
                                            'delete_roles' => 'Hapus Peran',
                                            'view_access_logs' => 'Lihat Log Akses',
                                            'manage_backup' => 'Kelola Backup',
                                        ];
                                        echo $labels[$permission->name] ?? ucfirst(str_replace('_', ' ', $permission->name));
                                    @endphp
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="text-sm font-medium text-blue-800">
                        Total: {{ $permissions->count() }} izin aktif
                    </h3>
                    <div class="mt-1 text-sm text-blue-700">
                        Peran ini memiliki akses ke {{ $groupedPermissions->count() }} area sistem yang berbeda.
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada izin</h3>
            <p class="mt-1 text-sm text-gray-500">Peran ini belum memiliki izin apapun.</p>
        </div>
    @endif
</div>