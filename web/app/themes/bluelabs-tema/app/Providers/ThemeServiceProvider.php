<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;

/**
 * Corretto dopo verifica sulla documentazione ufficiale Acorn:
 * deve estendere SageServiceProvider (non il ServiceProvider base di
 * Illuminate) e richiamare i metodi parent, altrimenti mancano i
 * binding specifici di Sage (es. "sage.view") e Blade non si avvia.
 */
class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Registra eventuali binding/servizi del tema.
     */
    public function register(): void
    {
        parent::register();
    }

    /**
     * Punto in cui, più avanti, registreremo i View Composer
     * (es. per passare i "Progetti" alle view Blade) e altre
     * inizializzazioni che richiedono l'app già avviata.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
