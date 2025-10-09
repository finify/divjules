<?php

namespace App\Filament\Admin\Resources\ApplicationStageResource\Pages;

use App\Filament\Admin\Resources\ApplicationStageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApplicationStage extends EditRecord
{
    protected static string $resource = ApplicationStageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
