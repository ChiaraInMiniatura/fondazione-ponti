<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Aggiunge "… Continua a leggere" all'estratto generato automaticamente
 * da WordPress quando un progetto non ha un Riassunto scritto a mano.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continua a leggere', 'bluelabs-tema'));
});
