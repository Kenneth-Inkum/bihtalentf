<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use App\Models\Country;
use App\Models\Location;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LocationResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Factories\Relationship;
use App\Filament\Resources\LocationResource\RelationManagers;

class LocationResource extends Resource
{
    protected static ?string $model = Location::class;

    protected static ?string $navigationIcon = 'heroicon-o-location-marker';

    protected static?string $navigationGroup = 'Talent Factory';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('location_name')
                    ->label('Location')
                    ->required()
                    ->maxLength(255),
                Select::make('country_id',)
                    ->options(Country::all()->pluck('country_name','id')->toArray())
                    // ->Relationship('country', 'country_name')
                    ->label('Country')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('region_id', null,)),
                Select::make('region_id',)
                    // ->Relationship('region', 'region_name')
                    ->label('Region')
                    ->options(function (callable $get){
                        $country = Country::find($get('country_id'));
                        if(!$country){
                            return Region::all()->pluck('region_name','id');
                        }
                        return $country->region->pluck('region_name','id');
                    })
                    ->reactive()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('location_name')
                    ->label('Location')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('region.region_name')
                    ->label('Region')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('country.country_name')
                    ->label('Country')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime('d-M-Y h:m:s')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->dateTime('d-M-Y h:m:s')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListLocations::route('/'),
            'create' => Pages\CreateLocation::route('/create'),
            'edit' => Pages\EditLocation::route('/{record}/edit'),
        ];
    }
}
