<?php

namespace App\Filament\Resources\EspecieResource\Pages;

use App\Filament\Resources\EspecieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEspecie extends EditRecord
{
    protected static string $resource = EspecieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
