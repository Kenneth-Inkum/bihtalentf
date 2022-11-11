<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static?string $navigationGroup = 'Admin Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_admin')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                // Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->dehydrateStateUsing(static fn(null|string $state):
                        null|string => filled($state) ? Hash::make($state): null)
                    ->required(static fn(Page $livewire):
                        string => $livewire instanceof CreateUser)
                    ->dehydrated(static fn(null|string $state):
                        bool => filled($state))
                    ->label(static fn(Page $livewire):
                        string => ($livewire instanceof EditUser) ? 'New Password' : 'Password'),
                // Forms\Components\Textarea::make('two_factor_secret')
                //     ->maxLength(65535),
                // Forms\Components\Textarea::make('two_factor_recovery_codes')
                //     ->maxLength(65535),
                // Forms\Components\DateTimePicker::make('two_factor_confirmed_at'),
                // Forms\Components\TextInput::make('current_team_id'),
                // Forms\Components\TextInput::make('profile_photo_path')
                //     ->maxLength(2048),
                CheckboxList::make('roles')
                    ->relationship('roles', 'name')
                    ->columns(2)
                    ->helperText('Only choose one of the following roles')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->dateTime('D dS M Y H:i:s'),
                // Tables\Columns\TextColumn::make('two_factor_secret'),
                // Tables\Columns\TextColumn::make('two_factor_recovery_codes'),
                // Tables\Columns\TextColumn::make('two_factor_confirmed_at')
                //     ->dateTime('D dS M Y H:i:s'),
                // Tables\Columns\TextColumn::make('current_team_id'),
                // Tables\Columns\TextColumn::make('profile_photo_path'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('D dS M Y H:i:s'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('D dS M Y H:i:s'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime('D dS M Y H:i:s'),
                ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RolesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
