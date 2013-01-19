<?php
/**
 *  Showing a tag cloud
 * 
 *  Shows a tag cloud where the more popular tags are larger than the others
 * 
 * @filename modules/blog/show_all_tags.php
 * @package Blog modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

try {
    $post_object = new Post($sql);
    
    $all_tags = $post_object->get_all_tags();
    
    echo '<pre>';
    print_r($all_tags);
    
} catch(Exception $e) {
    
}

?>