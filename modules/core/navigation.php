<?php
/**
 *  Controller for the navigation
 * 
 *  Loads the navigation
 * 
 * @filename modules/core/navigation.php
 * @package Core modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

try {
    
    $navigation_html = '';
    
    foreach($pages_to_include as $num => $slug) {
        $page_object = new Page($sql, $slug);
        
        if($page_object->page_status != 0) {
        
            if($page->page_slug == $slug) {
                $class = 'current';
            } elseif($num == count($pages_to_include) - 1) {
                $class = 'last';
            } else {
                $class = '';
            }

            $page_tokens = array(
                'PAGE_SLUG' => $page_object->page_slug,
                'PAGE_TITLE' => $page_object->page_title,
                'BASE' => Functions::get_base_url(),
                'CLASS' => $class
            );

            $nav_item_template = new Template(TEMPLATES . 'core/nav_item.html', $page_tokens);
            $navigation_html .= $nav_item_template->return_parsed_template();
        }
        
    }
    
    $navigation_template = new Template(TEMPLATES . 'core/navigation.html', array('NAV_ITEMS' => $navigation_html));
    
} catch(Exception $e) {
    echo $e->getMessage();
}

?>
