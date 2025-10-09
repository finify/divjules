<?php

namespace App\Filament\Admin\Resources\ApplicationStageResource\Pages;

use App\Filament\Admin\Resources\ApplicationStageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApplicationStages extends ListRecords
{
    protected static string $resource = ApplicationStageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
