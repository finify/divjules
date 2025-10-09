<?php

namespace App\Filament\Admin\Resources\VideoTestimonialResource\Pages;

use App\Filament\Admin\Resources\VideoTestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoTestimonial extends EditRecord
{
    protected static string $resource = VideoTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
