<?php
/**
 *  Text module
 * 
 *  Controller for the text module
 * 
 * @filename modules/core/text.php
 * @package Core modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

$page_data = array('page_id' => $page->page_id, 'display_order' => $display_order);
try {
    $text_object = new Text($sql, $page_data);
    if($text_object->text_is_active == 1) {
        echo $text_object->text;
    }
} catch(Exception $e) {
    echo $e->getMessage();
}

?>