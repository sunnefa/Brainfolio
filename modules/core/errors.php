<?php

/**
 *  Shows an error page
 * 
 *  When there is an error, this module is included, which will show an error message while still
 *  using the header and footer templates to keep the styles. The information the header and footer modules normally
 *  get from the database will here be manually inserted (things like page title, navigation etc.)
 * 
 * @filename modules/core/errors.php
 * @package Core modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

$template_file = TEMPLATES . 'core/errors.html';

$tokens = array(
    'TAGLINE' => ($database_error == false) ? $settings->tagline : '',
    'BASE' => Functions::get_base_url()
);
try {
    $template = new Template($template_file, $tokens);

    echo $template->return_parsed_template();
} catch(Exception $e) {
    
}

//todo: log the error here

?>