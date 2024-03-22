<?php

namespace App\Filament\Resources\EspecieResource\Pages;

use App\Filament\Resources\EspecieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEspecies extends ListRecords
{
    protected static string $resource = EspecieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
