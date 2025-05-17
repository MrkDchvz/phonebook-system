<?php

namespace App\Filament\Resources\ContactlistResource\Pages;

use App\Filament\Resources\ContactlistResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactlists extends ListRecords
{
    protected static string $resource = ContactlistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add new contact'),
        ];
    }
}
