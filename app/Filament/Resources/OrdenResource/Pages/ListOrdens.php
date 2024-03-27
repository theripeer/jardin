<?php

namespace App\Filament\Resources\OrdenResource\Pages;

use App\Filament\Resources\OrdenResource;
use App\Filament\Resources\OrdenResource\Widgets\OrdenOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdens extends ListRecords
{
    protected static string $resource = OrdenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrdenOverview::class
        ];
    }
}
