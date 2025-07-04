<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Peran & Izin';
    protected static ?string $modelLabel = 'Peran';
    protected static ?string $pluralModelLabel = 'Peran';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationGroup = 'Manajemen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Peran')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Peran')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('guard_name')
                            ->label('Guard Name')
                            ->default('web')
                            ->required()
                            ->hidden(),
                    ]),

                Forms\Components\Section::make('Izin Akses')
                    ->description('⚠️ PENTING: Centang izin yang ingin diberikan. Perubahan akan langsung berlaku setelah disimpan.')
                    ->schema([
                        Forms\Components\CheckboxList::make('permission_list')
                            ->label('Pilih Izin yang Diberikan')
                            ->options(self::getPermissionOptions())
                            ->columns(3)
                            ->searchable()
                            ->bulkToggleable()
                            ->afterStateHydrated(function (Forms\Components\CheckboxList $component, $state, $record) {
                                if ($record && $record->exists) {
                                    $existingPermissions = $record->permissions->pluck('name')->toArray();
                                    $component->state($existingPermissions);
                                }
                            })
                            ->live()
                            ->helperText(function ($get) {
                                $selected = $get('permission_list') ?? [];
                                $total = count(self::getPermissionOptions());
                                return 'Dipilih: ' . count($selected) . ' dari ' . $total . ' izin tersedia';
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Peran')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'operator' => 'danger',
                        'kepala_sekolah' => 'warning',
                        'guru' => 'success',
                        default => 'primary',
                    }),

                Tables\Columns\TextColumn::make('permissions_count')
                    ->label('Jumlah Izin')
                    ->counts('permissions')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('permissions.name')
                    ->label('Contoh Izin')
                    ->limit(15)
                    ->listWithLineBreaks()
                    ->limitList(1)
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('users_count')
                    ->label('Jumlah Pengguna')
                    ->counts('users')
                    ->badge()
                    ->color('info'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()->can('edit_roles')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->can('delete_roles')),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    // RESTORE PERMISSION CHECKS
    public static function canAccess(): bool
    {
        return auth()->user()->can('view_roles');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_roles');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_roles');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_roles');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete_roles');
    }

    private static function getPermissionOptions(): array
    {
        return [
            // Dashboard
            'view_dashboard' => '📊 Lihat Dashboard',

            // Categories
            'view_categories' => '📁 Lihat Kategori',
            'create_categories' => '📁➕ Buat Kategori',
            'edit_categories' => '📁✏️ Edit Kategori',
            'delete_categories' => '📁🗑️ Hapus Kategori',

            // Document Types
            'view_document_types' => '📄 Lihat Tipe Dokumen',
            'create_document_types' => '📄➕ Buat Tipe Dokumen',
            'edit_document_types' => '📄✏️ Edit Tipe Dokumen',
            'delete_document_types' => '📄🗑️ Hapus Tipe Dokumen',

            // Documents
            'view_documents' => '📋 Lihat Dokumen',
            'create_documents' => '📋➕ Upload Dokumen',
            'edit_documents' => '📋✏️ Edit Dokumen',
            'delete_documents' => '📋🗑️ Hapus Dokumen',
            'download_documents' => '📋⬇️ Download Dokumen',
            'view_all_documents' => '📋🔓 Lihat Semua Dokumen (Termasuk Rahasia)',

            // Users
            'view_users' => '👥 Lihat Pengguna',
            'create_users' => '👥➕ Buat Pengguna',
            'edit_users' => '👥✏️ Edit Pengguna',
            'delete_users' => '👥🗑️ Hapus Pengguna',

            // Roles
            'view_roles' => '🛡️ Lihat Peran',
            'create_roles' => '🛡️➕ Buat Peran',
            'edit_roles' => '🛡️✏️ Edit Peran',
            'delete_roles' => '🛡️🗑️ Hapus Peran',

            // System
            'view_access_logs' => '👁️ Lihat Log Akses',
            'manage_backup' => '💾 Kelola Backup Sistem',
        ];
    }
}
