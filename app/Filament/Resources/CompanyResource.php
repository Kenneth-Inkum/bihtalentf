<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Region;
use App\Models\Company;
use App\Models\Country;
use App\Models\Location;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CompanyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompanyResource\RelationManagers;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static?string $navigationGroup = 'Talent Factory';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('company_name')
                    ->label('Company')
                    ->unique()
                    ->required(),
                TextInput::make('company_size')
                    ->numeric()
                    ->label('Company Size')
                    ->minValue(1)
                    ->maxValue(9999)
                    ->required()
                    ->helperText('Enter a number not less than 1'),
                Select::make('industry_id',)
                    ->Relationship('industry','industry_name')
                    ->required(),

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
                    ->required()
                    ->afterStateUpdated(fn (callable $set) => $set('location_id', null,)),
                Select::make('location_id')
                    ->label('Location')
                    ->required()
                    ->options(function (callable $get){
                        $region = Region::find($get('region_id'));
                        if(!$region){
                            return Location::all()->pluck('location_name','id');
                        }
                        return $region->location->pluck('location_name','id');
                    })
                    ->reactive(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('company_name')->sortable(),
                TextColumn::make('company_size')->sortable(),
                TextColumn::make('industry.industry_name')->sortable(),
                TextColumn::make('location.location_name')->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('D d-M-Y h:i:s')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->dateTime('D d-M-Y h:i:s')
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
