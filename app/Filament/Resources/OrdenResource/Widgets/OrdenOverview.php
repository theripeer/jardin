<?php

namespace App\Filament\Resources\OrdenResource\Widgets;

use App\Models\Orden; // Ensure the Orden model is imported
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OrdenOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $createdOrdersCount = DB::table('ordens')
                                ->where('estados', 'CREADA')
                                ->count();

        $procesoOrdersCount = DB::table('ordens')
                                ->where('estados', 'EN PROCESO')
                                ->count();
        
        $cerradasOrdersCount = DB::table('ordens')
                                ->where('estados', 'REALIZADA')
                                ->count();

        $rechazadasOrdersCount = DB::table('ordens')
                                ->where('estados', 'RECHAZADA')
                                ->count();

        $stats = [
            Stat::make('Órdenes creadas', $createdOrdersCount),
            Stat::make('En proceso', $procesoOrdersCount),
            Stat::make('Finalizadas', $cerradasOrdersCount),
            Stat::make('Rechazadas', $rechazadasOrdersCount)
        ];

        // Removed the unnecessary loop (no results from $ordenes)

        return $stats;
    }
}