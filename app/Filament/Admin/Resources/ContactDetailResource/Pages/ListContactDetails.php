<?php

namespace App\Filament\Admin\Resources\ContactDetailResource\Pages;

use App\Filament\Admin\Resources\ContactDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactDetails extends ListRecords
{
    protected static string $resource = ContactDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
