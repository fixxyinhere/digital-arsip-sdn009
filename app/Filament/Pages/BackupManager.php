<?php

// Fix for BackupManager - Update getBackupsList() method

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupManager extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static string $view = 'filament.pages.backup-manager';
    protected static ?string $title = 'Manajemen Backup';
    protected static ?string $navigationLabel = 'Backup System';
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationGroup = 'Sistem';

    // ... keep all other methods as they are ...

    // FIX: Update getBackupsList method to read from physical directory
    public function getBackupsList()
    {
        $backupPath = storage_path('app/backups');

        // Ensure directory exists
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
            return [];
        }

        // Get files from physical directory
        $files = glob($backupPath . '/*');
        $backupList = [];

        foreach ($files as $file) {
            if (is_file($file)) {
                $filename = basename($file);
                $size = filesize($file);
                $lastModified = filemtime($file);

                $backupList[] = [
                    'name' => $filename,
                    'size' => $this->formatBytes($size),
                    'created_at' => Carbon::createFromTimestamp($lastModified)->format('d M Y H:i'),
                    'type' => str_contains($filename, 'database') ? 'Database' : 'Files',
                    'path' => 'backups/' . $filename, // Relative path for Storage operations
                ];
            }
        }

        // Sort by creation time (newest first)
        usort($backupList, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $backupList;
    }

    // FIX: Update deleteBackup method to work with physical files
    public function deleteBackup($path)
    {
        try {
            $fullPath = storage_path('app/' . $path);

            if (file_exists($fullPath)) {
                unlink($fullPath);

                Notification::make()
                    ->title('Backup berhasil dihapus!')
                    ->body('File backup telah dihapus dari sistem.')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('File tidak ditemukan!')
                    ->body('Backup mungkin sudah dihapus sebelumnya.')
                    ->warning()
                    ->send();
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Gagal menghapus backup!')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    // FIX: Update download methods to work with physical files
    private function getLatestDatabaseBackup()
    {
        $backupPath = storage_path('app/backups');
        $files = glob($backupPath . '/backup-database-*.sql');

        if (empty($files)) {
            return null;
        }

        // Sort by modification time (newest first)
        usort($files, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        return 'backups/' . basename($files[0]);
    }

    private function getLatestFilesBackup()
    {
        $backupPath = storage_path('app/backups');
        $files = glob($backupPath . '/backup-files-*.zip');

        if (empty($files)) {
            return null;
        }

        // Sort by modification time (newest first)
        usort($files, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        return 'backups/' . basename($files[0]);
    }

    // Keep all other methods the same...
    public function getHeaderActions(): array
    {
        return [
            Action::make('create_backup')
                ->label('Buat Backup Baru')
                ->icon('heroicon-o-plus')
                ->color('success')
                ->visible(fn() => auth()->user()->can('manage_backup'))
                ->action(function () {
                    try {
                        $this->ensureBackupDirectoryExists();

                        $dbSuccess = $this->createDatabaseBackup();
                        $filesSuccess = $this->createFilesBackup();

                        if ($dbSuccess && $filesSuccess) {
                            Notification::make()
                                ->title('Backup berhasil dibuat!')
                                ->body('Database dan files telah di-backup.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        } elseif ($dbSuccess) {
                            Notification::make()
                                ->title('Database backup berhasil!')
                                ->body('Files backup gagal, tapi database berhasil di-backup.')
                                ->warning()
                                ->duration(5000)
                                ->send();
                        } elseif ($filesSuccess) {
                            Notification::make()
                                ->title('Files backup berhasil!')
                                ->body('Database backup gagal, tapi files berhasil di-backup.')
                                ->warning()
                                ->duration(5000)
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Backup gagal!')
                                ->body('Kedua backup gagal dibuat. Periksa log untuk detail.')
                                ->danger()
                                ->duration(8000)
                                ->send();
                        }
                    } catch (\Exception $e) {
                        \Log::error('Backup error: ' . $e->getMessage());

                        Notification::make()
                            ->title('Gagal membuat backup!')
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->duration(8000)
                            ->send();
                    }
                }),

            Action::make('download_database')
                ->label('Download DB Backup Terbaru')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('info')
                ->visible(fn() => auth()->user()->can('manage_backup'))
                ->action(function () {
                    $latestBackup = $this->getLatestDatabaseBackup();
                    if ($latestBackup) {
                        $fullPath = storage_path('app/' . $latestBackup);
                        if (file_exists($fullPath)) {
                            return response()->download($fullPath);
                        }
                    }

                    Notification::make()
                        ->title('Tidak ada backup database!')
                        ->body('Silakan buat backup terlebih dahulu.')
                        ->warning()
                        ->send();
                }),

            Action::make('download_files')
                ->label('Download Files Backup Terbaru')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->visible(fn() => auth()->user()->can('manage_backup'))
                ->action(function () {
                    $latestBackup = $this->getLatestFilesBackup();
                    if ($latestBackup) {
                        $fullPath = storage_path('app/' . $latestBackup);
                        if (file_exists($fullPath)) {
                            return response()->download($fullPath);
                        }
                    }

                    Notification::make()
                        ->title('Tidak ada backup files!')
                        ->body('Silakan buat backup terlebih dahulu.')
                        ->warning()
                        ->send();
                }),
        ];
    }

    private function ensureBackupDirectoryExists()
    {
        $backupPath = storage_path('app/backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
    }

    private function createDatabaseBackup(): bool
    {
        try {
            $filename = 'backup-database-' . date('Y-m-d-H-i-s') . '.sql';
            $path = storage_path('app/backups/' . $filename);

            return $this->exportDatabaseUsingLaravel($path);
        } catch (\Exception $e) {
            \Log::error("Database backup failed: " . $e->getMessage());
            return false;
        }
    }

    private function exportDatabaseUsingLaravel($path): bool
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');

            $sql = "-- Laravel Database Backup\n";
            $sql .= "-- Database: {$dbName}\n";
            $sql .= "-- Created: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $tableName = array_values((array)$table)[0];

                // Get CREATE TABLE statement
                $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
                $sql .= "-- Table structure for `{$tableName}`\n";
                $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

                // Get table data
                $rows = DB::table($tableName)->get();
                if ($rows->count() > 0) {
                    $sql .= "-- Data for table `{$tableName}`\n";
                    $sql .= "INSERT INTO `{$tableName}` VALUES\n";

                    $values = [];
                    foreach ($rows as $row) {
                        $rowData = array_map(function ($value) {
                            return $value === null ? 'NULL' : "'" . addslashes($value) . "'";
                        }, (array)$row);
                        $values[] = "(" . implode(',', $rowData) . ")";
                    }
                    $sql .= implode(",\n", $values) . ";\n\n";
                }
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            file_put_contents($path, $sql);

            $success = file_exists($path) && filesize($path) > 100;
            if ($success) {
                \Log::info("Database backup created successfully: " . basename($path));
            }

            return $success;
        } catch (\Exception $e) {
            \Log::error("Laravel DB export failed: " . $e->getMessage());
            return false;
        }
    }

    private function createFilesBackup(): bool
    {
        try {
            $filename = 'backup-files-' . date('Y-m-d-H-i-s') . '.zip';
            $path = storage_path('app/backups/' . $filename);

            $zip = new \ZipArchive();
            if ($zip->open($path, \ZipArchive::CREATE) === TRUE) {
                $documentsPath = storage_path('app/public/documents');

                if (is_dir($documentsPath)) {
                    $this->addDirectoryToZip($zip, $documentsPath, 'documents');
                } else {
                    $zip->addEmptyDir('documents');
                }

                $zip->close();

                $success = file_exists($path);
                if ($success) {
                    \Log::info("Files backup created successfully: " . basename($path));
                }

                return $success;
            }

            return false;
        } catch (\Exception $e) {
            \Log::error("Files backup failed: " . $e->getMessage());
            return false;
        }
    }

    private function addDirectoryToZip($zip, $dir, $base = '')
    {
        if (!is_dir($dir)) return;

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = $base . '/' . substr($filePath, strlen($dir) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
    }

    private function formatBytes($size, $precision = 2)
    {
        if ($size <= 0) return '0 B';

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $base = log($size, 1024);
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $units[floor($base)];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('manage_backup');
    }
}
