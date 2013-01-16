<?php
/**
 *  The featured post module
 * 
 *  Controller for showing the featured post
 * 
 * @filename modules/blog/featured_post.php
 * @package Blog modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

$post_id = $settings->featured_post;

$post = new Post($sql, $post_id);

$tokens = array(
    'POST_SLUG' => $post->post_slug,
    'POST_TITLE' => $post->post_title,
    'POST_EXCERPT' => Functions::truncate($post->post_content, 50)
);

$featured_post_template = new Template(TEMPLATES . 'blog/featured_post.html', $tokens);
echo $featured_post_template->return_parsed_template();
?>