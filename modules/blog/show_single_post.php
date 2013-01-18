<?php
/**
 *  Controller for showing single post module
 * 
 *  Shows a single post from the blog
 * 
 * @filename modules/blog/show_single_post.php
 * @package Blog modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

try {
    $post = new Post($sql, $blog_slug);
    
    $tokens = array(
        'POST_TITLE' => $post->post_title,
        'POST_CONTENT' => $post->post_content,
        'POST_DATE' => $post->post_date,
    );
    
    $post_template = new Template(TEMPLATES . 'blog/show_single_post.html');
    
} catch(Exception $e) {
    
}

?>