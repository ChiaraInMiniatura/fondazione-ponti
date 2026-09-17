<?php

/**
 * Theme bootstrap.
 *
 * Carica l'autoload di Composer e avvia Acorn (il ponte che porta
 * Blade, le facade Illuminate e i service provider dentro WordPress).
 */

if (! file_exists($composer = __DIR__.'/vendor/autoload.php')) {
    wp_die(
        __('Errore: autoloader non trovato. Esegui <code>composer install</code> dentro la cartella del tema.', 'bluelabs-tema')
    );
}

require $composer;

use Roots\Acorn\Application;

/**
 * Bootstrap dell'applicazione Acorn.
 *
 * Corretto dopo verifica sulla documentazione ufficiale Acorn 5.x:
 * Roots\bootloader() da solo non basta più — va registrato esplicitamente
 * il ThemeServiceProvider tramite Application::configure(), altrimenti
 * mancano i binding specifici di Sage (es. "sage.view").
 */
add_action('after_setup_theme', function () {
    Application::configure()
        ->withProviders([
            App\Providers\ThemeServiceProvider::class,
        ])
        ->boot();
}, 0);

/**
 * Carica i file del tema (setup, filters, cpt, ...).
 *
 * Nota: questo blocco mancava — setup.php e filters.php esistevano già
 * nel tema ma non venivano mai eseguiti, perché l'autoload PSR-4 di
 * Composer carica solo classi, non file procedurali come questi (che
 * si limitano a chiamare add_action()/add_filter() a livello di file).
 * Vanno richiesti esplicitamente, come fa lo scaffold ufficiale di Sage.
 */
collect(['setup', 'filters', 'cpt', 'candidature'])
    ->each(function ($file) {
        if (! locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
                /* translators: %s è il percorso del file mancante */
                sprintf(__('Errore nel caricamento di <code>%s</code>.', 'bluelabs-tema'), $file)
            );
        }
    });
