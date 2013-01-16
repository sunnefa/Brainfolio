<?php
/**
 *  Footer module
 * 
 *  The controller for the footer module
 * 
 * @filename modules/core/footer.php
 * @package Core Modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

$pages_to_include = json_decode($settings->pages_in_footer);

include 'navigation.php';

$tokens = array(
    'NAVIGATION' => $navigation_template->return_parsed_template()
);

$footer_template = new Template(TEMPLATES . 'core/footer.html', $tokens);

echo $footer_template->return_parsed_template();

?>
