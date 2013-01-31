<?php

/**
 *  Shows an error page
 * 
 *  When there is an error, this module is included, which will show an error message while still
 *  using the header and footer templates to keep the styles. The information the header and footer modules normally
 *  get from the database will here be manually inserted (things like page title, navigation etc.)
 * 
 * @filename modules/core/errors.php
 * @package 
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

//the error message template is going to be the same regardless of what type of error occurred
$error_tokens = array(
    'ERROR_MESSAGE' => (isset($error_message)) ? $error_message : 'Unknown error occurred.'
);

$error_template = new Template(TEMPLATES . 'core/errors.html', $error_tokens);

//if the error is with the database or database connection we don't want to include the header and footer modules
//because they require the database to show certain details such as page title and navigation
if(isset($database_error)) {
    if($database_error === true) {
        $error_header_tokens = array(
            'TAGLINE' => 'Error',
            'PAGE_TITLE' => 'An error has occurred',
            'BASE' => Functions::get_base_url(),
            'NAVIGATION' => ''
        );

        $error_header_template = new Template(TEMPLATES . 'core/header.html', $error_header_tokens);

        echo $error_header_template->return_parsed_template();

        echo $error_template->return_parsed_template();

        $footer_tokens = array('NAVIGATION' => '');

        $footer_template = new Template(TEMPLATES . 'core/footer.html', $footer_tokens);

        echo $footer_template->return_parsed_template();
    } else {
        //if the error was something else we can include the header and footer modules but we need to manually
        //create a $page object with the right variables that header, footer and navigation use
        $page = (object) array('page_title' => 'An error has occurred', 'page_description' => 'It seems some kind of error has occurred', 'page_slug' => 'errors');
        
        include MODULES . 'core/header.php';
        echo $error_template->return_parsed_template();
        include MODULES . 'core/footer.php';
    }
}

?>