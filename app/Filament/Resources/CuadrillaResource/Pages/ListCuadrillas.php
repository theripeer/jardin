<?php

namespace App\Filament\Resources\CuadrillaResource\Pages;

use App\Filament\Resources\CuadrillaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCuadrillas extends ListRecords
{
    protected static string $resource = CuadrillaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
