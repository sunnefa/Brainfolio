<?php
/**
 *  Controller for showing all posts in the blog
 * 
 *  Show all the posts in the blog
 * 
 * @filename modules/blog/show_all_posts.php
 * @package Blog modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

if(!is_numeric($blog_slug)) {
    echo 'Not found';
} else {
    try {
        $post_object = new Post($sql);
        
        $start = ceil($blog_slug - 1) * $settings->posts_per_page;
        
        $post_ids = $post_object->get_all_post_ids($settings->posts_per_page, $start);
        
        $posts_html = '';
        
        $show_excerpt = true;
        
        foreach($post_ids as $blog_slug) {
            ob_start();
            include 'show_single_post.php';
            $posts_html .= ob_get_clean();
        }
        
        $all_posts_template = new Template(TEMPLATES . 'blog/all_posts.html', array('ALL_POSTS' => $posts_html));
        echo $all_posts_template->return_parsed_template();
        
    } catch(Exception $e) {

    }
}

?>