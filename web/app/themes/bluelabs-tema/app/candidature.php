<?php

/**
 * Custom Post Type "Candidatura" + endpoint REST pubblico per il form
 * "Candidati come volontario" (Fase 5).
 *
 * Le candidature NON sono un contenuto pubblico del sito (nessuna pagina
 * singola, nessun archivio): servono solo a chi gestisce la Fondazione,
 * da bacheca WordPress. Per questo il post type ha 'public' => false e
 * non usiamo il REST core di WordPress (che richiederebbe un utente
 * autenticato con permesso di scrittura) ma una rotta REST custom con
 * un permission_callback pubblico, che internamente valida e salva i
 * dati in modo controllato.
 */

namespace App;

/**
 * Registra il Custom Post Type "Candidatura".
 *
 * @return void
 */
add_action('init', function () {
    register_post_type('candidatura', [
        'labels' => [
            'name' => __('Candidature', 'bluelabs-tema'),
            'singular_name' => __('Candidatura', 'bluelabs-tema'),
            'edit_item' => __('Rivedi candidatura', 'bluelabs-tema'),
            'view_item' => __('Visualizza candidatura', 'bluelabs-tema'),
            'search_items' => __('Cerca candidature', 'bluelabs-tema'),
            'not_found' => __('Nessuna candidatura ricevuta', 'bluelabs-tema'),
            'not_found_in_trash' => __('Nessuna candidatura nel cestino', 'bluelabs-tema'),
            'all_items' => __('Candidature volontari', 'bluelabs-tema'),
            'menu_name' => __('Candidature', 'bluelabs-tema'),
        ],
        'public' => false, // non genera pagine pubbliche: contenuto solo per l'admin
        'show_ui' => true, // ma resta visibile e gestibile da bacheca
        'show_in_menu' => true,
        'show_in_rest' => false, // scriviamo via rotta custom, non via REST core
        'menu_icon' => 'dashicons-businessperson',
        'menu_position' => 6,
        'supports' => ['title'],
        'capability_type' => 'post',
        'hierarchical' => false,
    ]);
});

/**
 * Colonne custom nella lista "Candidature" in bacheca, per vedere i dati
 * principali senza dover aprire ogni candidatura.
 */
add_filter('manage_candidatura_posts_columns', function ($columns) {
    $columns['candidatura_email'] = __('Email', 'bluelabs-tema');
    $columns['candidatura_telefono'] = __('Telefono', 'bluelabs-tema');
    $columns['candidatura_disponibilita'] = __('Disponibilità', 'bluelabs-tema');

    return $columns;
});

add_action('manage_candidatura_posts_custom_column', function ($column, $post_id) {
    if ($column === 'candidatura_email') {
        echo esc_html(get_post_meta($post_id, 'candidatura_email', true));
    }

    if ($column === 'candidatura_telefono') {
        echo esc_html(get_post_meta($post_id, 'candidatura_telefono', true) ?: '—');
    }

    if ($column === 'candidatura_disponibilita') {
        echo esc_html(get_post_meta($post_id, 'candidatura_disponibilita', true));
    }
}, 10, 2);

/**
 * Rotta REST pubblica per il form volontari: POST /wp-json/bluelabs/v1/candidature
 *
 * @return void
 */
add_action('rest_api_init', function () {
    register_rest_route('bluelabs/v1', '/candidature', [
        'methods' => 'POST',
        'callback' => __NAMESPACE__ . '\\gestisci_candidatura',
        'permission_callback' => '__return_true', // pubblico: chiunque può candidarsi
        'args' => [
            'nome' => ['required' => true],
            'email' => ['required' => true],
            'disponibilita' => ['required' => true],
        ],
    ]);
});

/**
 * Valida, sanifica e salva una candidatura ricevuta dal form pubblico.
 *
 * @param  \WP_REST_Request  $request
 * @return \WP_REST_Response|\WP_Error
 */
function gestisci_candidatura(\WP_REST_Request $request)
{
    // Honeypot anti-spam: campo nascosto via CSS, invisibile agli umani.
    // Se arriva compilato è quasi certamente un bot: rispondiamo "ok" senza
    // salvare nulla, per non dare a chi lo invia un segnale utile.
    if (! empty($request->get_param('sito_web'))) {
        return new \WP_REST_Response(['ok' => true], 200);
    }

    $nome = sanitize_text_field($request->get_param('nome'));
    $email = sanitize_email($request->get_param('email'));
    $telefono = sanitize_text_field($request->get_param('telefono'));
    $disponibilita = sanitize_text_field($request->get_param('disponibilita'));
    $messaggio = sanitize_textarea_field($request->get_param('messaggio'));

    if (empty($nome) || empty($disponibilita)) {
        return new \WP_Error(
            'candidatura_incompleta',
            __('Nome e disponibilità sono obbligatori.', 'bluelabs-tema'),
            ['status' => 400]
        );
    }

    if (empty($email) || ! is_email($email)) {
        return new \WP_Error(
            'email_non_valida',
            __("L'indirizzo email non è valido.", 'bluelabs-tema'),
            ['status' => 400]
        );
    }

    $post_id = wp_insert_post([
        'post_type' => 'candidatura',
        'post_title' => sprintf('%s — %s', $nome, wp_date('d/m/Y H:i')),
        'post_status' => 'pending', // "da rivedere": non pubblico, in attesa di lettura
    ], true);

    if (is_wp_error($post_id)) {
        return new \WP_Error(
            'salvataggio_fallito',
            __('Non è stato possibile salvare la candidatura. Riprova.', 'bluelabs-tema'),
            ['status' => 500]
        );
    }

    update_post_meta($post_id, 'candidatura_email', $email);
    update_post_meta($post_id, 'candidatura_telefono', $telefono);
    update_post_meta($post_id, 'candidatura_disponibilita', $disponibilita);
    update_post_meta($post_id, 'candidatura_messaggio', $messaggio);

    return new \WP_REST_Response(['ok' => true], 201);
}
