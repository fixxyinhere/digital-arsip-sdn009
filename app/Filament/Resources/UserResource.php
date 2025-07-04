<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $modelLabel = 'Pengguna';
    protected static ?string $pluralModelLabel = 'Pengguna';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Manajemen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Personal')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('employee_id')
                            ->label('NIP/ID Pegawai')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\Select::make('position')
                            ->label('Jabatan')
                            ->required()
                            ->options([
                                'operator' => 'Operator',
                                'kepala_sekolah' => 'Kepala Sekolah',
                                'guru' => 'Guru',
                            ])
                            ->default('guru'),

                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3),

                        Forms\Components\FileUpload::make('avatar')
                            ->label('Foto Profil')
                            ->image()
                            ->directory('avatars'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Keamanan')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->maxLength(255),

                        Forms\Components\Select::make('roles')
                            ->label('Peran')
                            ->relationship('roles', 'name')
                            ->options(Role::all()->pluck('name', 'name'))
                            ->multiple()
                            ->preload(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Foto')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('employee_id')
                    ->label('NIP/ID')
                    ->searchable()
                    ->badge(),

                Tables\Columns\TextColumn::make('position_label')
                    ->label('Jabatan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Operator' => 'danger',
                        'Kepala Sekolah' => 'warning',
                        'Guru' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Peran')
                    ->badge()
                    ->separator(','),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('position')
                    ->label('Jabatan')
                    ->options([
                        'operator' => 'Operator',
                        'kepala_sekolah' => 'Kepala Sekolah',
                        'guru' => 'Guru',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn() => auth()->user()->can('edit_users')),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->can('delete_users')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->can('delete_users')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    // Permission checks
    public static function canAccess(): bool
    {
        return auth()->user()->can('view_users');
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_users');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit_users');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete_users');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete_users');
    }
}
