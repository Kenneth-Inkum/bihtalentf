<?php

namespace App\Filament\Resources\RecruitResource\Pages;

use App\Filament\Resources\RecruitResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecruits extends ListRecords
{
    protected static string $resource = RecruitResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
