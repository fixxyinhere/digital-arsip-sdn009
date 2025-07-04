{{-- resources/views/filament/pages/backup-manager.blade.php --}}

<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Backup Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Backup Card -->
            <div class="fi-sta-overview-stat-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="grid gap-y-2">
                    <div class="flex items-center gap-2">
                        <span class="fi-sta-overview-stat-icon flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                            <x-heroicon-o-circle-stack class="h-4 w-4" />
                        </span>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Backup</span>
                    </div>
                    <span class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">
                        {{ count($this->getBackupsList()) }}
                    </span>
                </div>
            </div>

            <!-- Database Backup Card -->
            <div class="fi-sta-overview-stat-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="grid gap-y-2">
                    <div class="flex items-center gap-2">
                        <span class="fi-sta-overview-stat-icon flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 text-green-600 dark:bg-green-500/10 dark:text-green-400">
                            <x-heroicon-o-server class="h-4 w-4" />
                        </span>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Database Backup</span>
                    </div>
                    <span class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">
                        {{ count(array_filter($this->getBackupsList(), fn($b) => $b['type'] === 'Database')) }}
                    </span>
                </div>
            </div>

            <!-- Files Backup Card -->
            <div class="fi-sta-overview-stat-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="grid gap-y-2">
                    <div class="flex items-center gap-2">
                        <span class="fi-sta-overview-stat-icon flex h-8 w-8 items-center justify-center rounded-lg bg-orange-50 text-orange-600 dark:bg-orange-500/10 dark:text-orange-400">
                            <x-heroicon-o-folder class="h-4 w-4" />
                        </span>
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Files Backup</span>
                    </div>
                    <span class="text-3xl font-semibold tracking-tight text-gray-950 dark:text-white">
                        {{ count(array_filter($this->getBackupsList(), fn($b) => $b['type'] === 'Files')) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Backup List Table -->
        <div class="fi-ta-ctn divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-gray-700 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-ta-header-ctn px-6 py-4">
                <div class="fi-ta-header-heading-ctn">
                    <h3 class="fi-ta-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Daftar Backup
                    </h3>
                    <p class="fi-ta-header-description text-sm text-gray-500 dark:text-gray-400">
                        Kelola file backup database dan dokumen
                    </p>
                </div>
            </div>
            
            <div class="fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-gray-700">
                <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-gray-700">
                    <thead class="divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="bg-gray-50 dark:bg-gray-800/50">
                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">
                                    <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">
                                        Nama File
                                    </span>
                                </span>
                            </th>
                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">
                                    <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">
                                        Tipe
                                    </span>
                                </span>
                            </th>
                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">
                                    <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">
                                        Ukuran
                                    </span>
                                </span>
                            </th>
                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">
                                    <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">
                                        Tanggal Dibuat
                                    </span>
                                </span>
                            </th>
                            <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6">
                                <span class="group flex w-full items-center gap-x-1 whitespace-nowrap justify-start">
                                    <span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">
                                        Aksi
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-gray-700">
                        @forelse($this->getBackupsList() as $backup)
                            <tr class="fi-ta-row [@media(hover:hover)]:transition [@media(hover:hover)]:duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                    <div class="fi-ta-col-wrp px-3 py-4">
                                        <div class="flex items-center gap-x-3">
                                            <div class="fi-ta-icon-ctn flex h-8 w-8 items-center justify-center rounded-full">
                                                @if($backup['type'] === 'Database')
                                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-50 dark:bg-green-500/10">
                                                        <x-heroicon-m-server class="h-4 w-4 text-green-600 dark:text-green-400" />
                                                    </div>
                                                @else
                                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-orange-50 dark:bg-orange-500/10">
                                                        <x-heroicon-m-folder class="h-4 w-4 text-orange-600 dark:text-orange-400" />
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col justify-center">
                                                <div class="fi-ta-text-item inline-flex items-center gap-1.5 font-medium text-gray-950 dark:text-white">
                                                    <span class="text-sm">{{ $backup['name'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                    <div class="fi-ta-col-wrp px-3 py-4">
                                        <div class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-h-6 py-1 
                                            {{ $backup['type'] === 'Database' 
                                                ? 'fi-color-success bg-green-50 text-green-700 ring-green-600/10 dark:bg-green-400/10 dark:text-green-400 dark:ring-green-400/30' 
                                                : 'fi-color-warning bg-orange-50 text-orange-700 ring-orange-600/10 dark:bg-orange-400/10 dark:text-orange-400 dark:ring-orange-400/30' }}">
                                            <span class="grid">
                                                <span class="truncate">{{ $backup['type'] }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                    <div class="fi-ta-col-wrp px-3 py-4">
                                        <div class="fi-ta-text text-sm leading-6 text-gray-950 dark:text-white">
                                            {{ $backup['size'] }}
                                        </div>
                                    </div>
                                </td>
                                <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                    <div class="fi-ta-col-wrp px-3 py-4">
                                        <div class="fi-ta-text text-sm leading-6 text-gray-950 dark:text-white">
                                            {{ $backup['created_at'] }}
                                        </div>
                                    </div>
                                </td>
                                <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3">
                                    <div class="fi-ta-col-wrp px-3 py-4">
                                        <div class="fi-ta-actions flex shrink-0 items-center gap-3 justify-start">
                                            <!-- Download Button -->
                                            <a href="{{ route('backup.download', $backup['path']) }}" 
                                               class="fi-ac-btn-action relative flex items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-gray fi-btn-color-gray fi-size-sm fi-btn-size-sm gap-1.5 px-3 py-2 text-sm bg-white text-gray-950 hover:bg-gray-50 focus-visible:ring-gray-500/50 dark:bg-white/5 dark:text-white dark:hover:bg-white/10 dark:focus-visible:ring-gray-400/50 fi-ac-action fi-ac-btn-action shadow-sm ring-1 ring-gray-950/10 dark:ring-white/20"
                                               title="Download">
                                                <x-heroicon-m-arrow-down-tray class="fi-btn-icon h-4 w-4" />
                                                <span class="fi-btn-label">Download</span>
                                            </a>

                                            <!-- Delete Button -->
                                            <button wire:click="deleteBackup('{{ $backup['path'] }}')" 
                                                    class="fi-ac-btn-action relative flex items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-danger fi-btn-color-danger fi-size-sm fi-btn-size-sm gap-1.5 px-3 py-2 text-sm bg-white text-red-600 hover:bg-red-50 focus-visible:ring-red-500/50 dark:bg-white/5 dark:text-red-400 dark:hover:bg-red-500/10 dark:focus-visible:ring-red-400/50 fi-ac-action fi-ac-btn-action shadow-sm ring-1 ring-red-600/20 dark:ring-red-400/30"
                                                    title="Hapus"
                                                    onclick="return confirm('Yakin ingin menghapus backup ini?')">
                                                <x-heroicon-m-trash class="fi-btn-icon h-4 w-4" />
                                                <span class="fi-btn-label">Hapus</span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="fi-ta-empty-state px-6 py-12">
                                    <div class="fi-ta-empty-state-content mx-auto grid max-w-lg justify-items-center text-center">
                                        <div class="fi-ta-empty-state-icon-ctn mb-4 rounded-full bg-gray-100 p-3 dark:bg-gray-500/20">
                                            <x-heroicon-o-archive-box class="fi-ta-empty-state-icon h-6 w-6 text-gray-500 dark:text-gray-400" />
                                        </div>
                                        
                                        <h4 class="fi-ta-empty-state-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                            Belum ada backup
                                        </h4>
                                        
                                        <p class="fi-ta-empty-state-description text-sm text-gray-500 dark:text-gray-400">
                                            Mulai dengan membuat backup pertama Anda menggunakan tombol di atas.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Info Card -->
        <div class="fi-in rounded-xl bg-blue-50 p-4 ring-1 ring-blue-200 dark:bg-blue-950/50 dark:ring-blue-900">
            <div class="flex gap-3">
                <x-heroicon-s-information-circle class="fi-in-icon mt-1 h-5 w-5 flex-shrink-0 text-blue-400 dark:text-blue-500" />
                
                <div class="grid gap-1 flex-1">
                    <p class="fi-in-heading text-sm font-medium text-blue-800 dark:text-blue-200">
                        Informasi Backup
                    </p>
                    
                    <div class="fi-in-text text-sm text-blue-700 dark:text-blue-300">
                        <ul class="list-disc space-y-1 pl-4">
                            <li>Backup database berisi semua data sistem (users, roles, documents, dll.)</li>
                            <li>Backup files berisi semua file dokumen yang diupload</li>
                            <li>Disarankan untuk melakukan backup secara berkala</li>
                            <li>Simpan backup di tempat yang aman dan terpisah dari server</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        window.deleteBackup = function(path) {
            if (confirm('Yakin ingin menghapus backup ini?')) {
                @this.call('deleteBackup', path);
            }
        }
    </script>
    @endpush
</x-filament-panels::page>