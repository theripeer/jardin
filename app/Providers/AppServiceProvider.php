<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use BezhanSalleh\FilamentLanguageSwitch\Enums\Placement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->visible(outsidePanels: true)
                ->circular()
                ->locales(['es', 'en','fr','pt_BR'])
                ->labels([
                    'es' => 'Español',
                    'pt_BR' => 'Portugues',
                    'fr' => 'Frances',
                    'en' => 'Ingles'
                    // Other custom labels as needed
                ])
                ->outsidePanelRoutes([
                    'Dashboard',
                    'Contrato',
                    'Empresa',
                    'Fundo'
                    // Additional custom routes where the switcher should be visible outside panels
                ])
                ->outsidePanelPlacement(Placement::BottomRight);
        });
    }
}
