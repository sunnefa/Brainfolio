<?php
/**
 *  Controller for header module
 * 
 *  Loads the template for the header and replaces the tokens
 * 
 * @filename modules/core/header.php
 * @package Core modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

$pages_to_include = json_decode($settings->pages_in_header);

include 'navigation.php';

$tokens = array(
    'TAGLINE' => $settings->tagline,
    'PAGE_TITLE' => $page->page_title,
    'PAGE_DESCRIPTION' => $page->page_description,
    'BASE' => Functions::get_base_url(),
    'NAVIGATION' => $navigation_template->return_parsed_template()
);

$header_template = new Template(TEMPLATES . 'core/header.html', $tokens);
echo $header_template->return_parsed_template();

?>
