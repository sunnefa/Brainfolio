<?php
/**
 *  Controller for get requests
 * 
 *  Loads the correct page and corresponding modules based on the parameters of the get request
 * 
 * @filename controllers/get.php
 * @package Controllers
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

$queries = Functions::get_query_strings();

if($settings->maintenance_mode == 1) {
    $page_slug = 'maintenance';
} elseif(empty($queries)) {
    $page_slug = 'portfolio';
} else {
    $page_slug = $queries[0];
}

try {
    $page = new Page($sql, $page_slug);
    if($page->page_status != 0) {
        foreach($page->page_modules as $display_order => $module) {
            if($module->module_is_active == 1) {
                include MODULES . $module->module_path;
            }
        }
    } else {
        center_die('Page not found');
    }
    
} catch(Exception $e) {
    center_die($e->getMessage());
}
?>