<?php

namespace App\Filament\Resources\ContactlistResource\Pages;

use App\Filament\Resources\ContactlistResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactlist extends EditRecord
{
    protected static string $resource = ContactlistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array {
        $contact = Contact::find($data['contact_id']);
        $data['number'] = $contact->number;

        return $data;
    }
}
