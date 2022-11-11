<?php

namespace App\Filament\Resources\JobTitleResource\Pages;

use App\Filament\Resources\JobTitleResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobTitle extends EditRecord
{
    protected static string $resource = JobTitleResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
