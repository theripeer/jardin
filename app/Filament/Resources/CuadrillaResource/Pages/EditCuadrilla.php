<?php

namespace App\Filament\Resources\CuadrillaResource\Pages;

use App\Filament\Resources\CuadrillaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCuadrilla extends EditRecord
{
    protected static string $resource = CuadrillaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
