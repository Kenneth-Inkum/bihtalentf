<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Recruit;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RecruitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RecruitResource\RelationManagers;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\TrashedFilter;

class RecruitResource extends Resource
{
    protected static ?string $model = Recruit::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static?string $navigationGroup = 'Talent Factory';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('other_name'),
                DatePicker::make('date_of_birth')
                    ->maxDate(now()),
                TextInput::make('phone_number'),
                Select::make('location_id')
                    ->Relationship('location', 'location_name'),
                Select::make('country_id')
                    ->Relationship('country', 'country_name'),
                Select::make('region_id')
                    ->Relationship('region', 'region_name'),
                Select::make('course_id')
                    ->Relationship('course', 'course_name'),
                Select::make('industry_id')
                    ->Relationship('industry', 'industry_name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('last_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('other_name'),
                // TextColumn::make('date_of_birth'),
                TextColumn::make('phone_number')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('location.location_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('country.country_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('region.region_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('course.course_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('industry.industry_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('D dS M Y H:i:s'),
                TextColumn::make('updated_at')
                    ->dateTime('D dS M Y H:i:s'),
                TextColumn::make('deleted_at')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecruits::route('/'),
            'create' => Pages\CreateRecruit::route('/create'),
            'edit' => Pages\EditRecruit::route('/{record}/edit'),
        ];
    }
}
