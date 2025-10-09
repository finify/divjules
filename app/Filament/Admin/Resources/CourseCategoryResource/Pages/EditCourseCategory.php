<?php

namespace App\Filament\Admin\Resources\CourseCategoryResource\Pages;

use App\Filament\Admin\Resources\CourseCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseCategory extends EditRecord
{
    protected static string $resource = CourseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
