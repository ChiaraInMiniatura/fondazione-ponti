<?php

/**
 * Custom Post Type "Progetti" e tassonomia "Area di intervento".
 *
 * Fase 1 del progetto dimostrativo Fondazione Ponti.
 */

namespace App;

/**
 * Registra il Custom Post Type "Progetto".
 *
 * @return void
 */
add_action('init', function () {
    register_post_type('progetto', [
        'labels' => [
            'name' => __('Progetti', 'bluelabs-tema'),
            'singular_name' => __('Progetto', 'bluelabs-tema'),
            'add_new' => __('Aggiungi nuovo', 'bluelabs-tema'),
            'add_new_item' => __('Aggiungi nuovo progetto', 'bluelabs-tema'),
            'edit_item' => __('Modifica progetto', 'bluelabs-tema'),
            'new_item' => __('Nuovo progetto', 'bluelabs-tema'),
            'view_item' => __('Visualizza progetto', 'bluelabs-tema'),
            'view_items' => __('Visualizza progetti', 'bluelabs-tema'),
            'search_items' => __('Cerca progetti', 'bluelabs-tema'),
            'not_found' => __('Nessun progetto trovato', 'bluelabs-tema'),
            'not_found_in_trash' => __('Nessun progetto nel cestino', 'bluelabs-tema'),
            'all_items' => __('Tutti i progetti', 'bluelabs-tema'),
            'archives' => __('Archivio progetti', 'bluelabs-tema'),
            'menu_name' => __('Progetti', 'bluelabs-tema'),
        ],
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true, // necessario per il componente Vue (Fase 4) e per Gutenberg
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions'],
        'rewrite' => [
            'slug' => 'progetti',
            'with_front' => false,
        ],
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 5,
    ]);
});

/**
 * Registra la tassonomia "Area di intervento", collegata a "Progetto".
 *
 * Termini previsti (da creare da wp-admin > Progetti > Aree di intervento):
 * Sanità, Istruzione, Emergenza, Ambiente.
 *
 * @return void
 */
add_action('init', function () {
    register_taxonomy('area_intervento', ['progetto'], [
        'labels' => [
            'name' => __('Aree di intervento', 'bluelabs-tema'),
            'singular_name' => __('Area di intervento', 'bluelabs-tema'),
            'add_new_item' => __('Aggiungi nuova area', 'bluelabs-tema'),
            'edit_item' => __('Modifica area', 'bluelabs-tema'),
            'search_items' => __('Cerca aree', 'bluelabs-tema'),
            'all_items' => __('Tutte le aree', 'bluelabs-tema'),
            'menu_name' => __('Aree di intervento', 'bluelabs-tema'),
        ],
        'hierarchical' => true, // si comporta come le categorie, non come i tag
        'public' => true,
        'show_in_rest' => true, // necessario per filtrare i progetti via REST/Vue
        'rewrite' => [
            'slug' => 'aree-intervento',
            'with_front' => false,
        ],
    ]);
});
