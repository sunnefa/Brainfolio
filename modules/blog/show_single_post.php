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
    
    if(isset($show_excerpt)) {
        $post_content = Functions::truncate($post->post_content, $settings->post_excerpt_length);
        $template = 'show_excerpt.html';
    } else {
        $post_content = $post->post_content;
        $template = 'show_single_post.html';
    }
    
    $post_tags = '';
    foreach($post->post_tags as $num => $tag) {
        $tokens = array(
            'TAG' => $tag,
            'CLASS' => '',
            'TAG_LINK' => ucwords($tag),
            'SEPARATE' => (count($post->post_tags) - 1 == $num) ? '' : ', '
        );
        $tag_template = new Template(TEMPLATES . 'blog/tag_link.html', $tokens);
        $post_tags .= $tag_template->return_parsed_template();
    }
    
    $tokens = array(
        'POST_TITLE' => $post->post_title,
        'POST_CONTENT' => $post_content,
        'POST_DATE' => date($settings->date_format, strtotime($post->post_date)),
        'POST_SLUG' => $post->post_slug,
        'POST_TAGS' => $post_tags
    );
    
    $post_template = new Template(TEMPLATES . 'blog/' . $template, $tokens);
    
    echo $post_template->return_parsed_template();
    
} catch(Exception $e) {
    
}

?>