<?php
/**
 *  Controller for the blog module
 * 
 *  Handles the entire blog module
 * 
 * @filename blog.php
 * @package 
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

if(isset($_GET['parts'])) {
    $parts = explode('/', $_GET['parts']);
    
    $showing = $parts[0];
    $blog_slug = (isset($parts[1])) ? $parts[1] : '';
} else {
    $showing = 'all';
    $blog_slug = '1';
}

switch($showing) {
    case 'all':
    case 'page':
        //include show_all_posts
        include 'show_all_posts.php';
        break;
        
    case 'tags':
        if(!empty($blog_slug)) {
            //include show_single_tag.php
            echo 'Showing the ' . $blog_slug . ' tag';
        } else {
            //include show_all_tags.php
            include 'show_all_tags.php';
        }
        break;
        
    case 'post':
        if(empty($blog_slug)) {
            //include 404 page
            echo 'No post found';
        } else {
            //include show_single_post.php
            include 'show_single_post.php';
        }
        break;
        
    default:
        //include 404 page
        echo 'Not found';
        break;
}

?>