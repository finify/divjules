<?php

namespace App\Filament\Admin\Resources\VideoTestimonialResource\Pages;

use App\Filament\Admin\Resources\VideoTestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideoTestimonials extends ListRecords
{
    protected static string $resource = VideoTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
