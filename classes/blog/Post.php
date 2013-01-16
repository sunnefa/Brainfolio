<?php
/**
 *  Represents the posts table
 * 
 *  CRUD of posts table + represents a single post
 * 
 * @filename classes/blog/Post.php
 * @package Blog
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

/**
 * Posts table
 * @since 0.1
 */
class Post {
    
    /**
     * The id of the post
     * @var int 
     */
    public $post_id;
    
    /**
     * The title of the post
     * @var string
     */
    public $post_title;
    
    /**
     * The content of the post
     * @var string 
     */
    public $post_content;
    
    /**
     * The date of the post
     * @var string
     */
    public $post_date;
    
    /**
     * The status of the post
     * @var string 
     */
    public $post_status;
    
    /**
     * The slug of the post
     * @var string
     */
    public $post_slug;
    
    /**
     * The tags of the post
     * @var array
     */
    public $post_tags;
    
    /**
     * The posts table
     * @var string
     */
    private $table_name = 'blog__posts';
    
    /**
     * DBWrapper
     * @var DBWrapper 
     */
    private $db_wrapper;

    public function __construct(DBWrapper $sql, $post = null){
        $this->db_wrapper = $sql;
        
        if($post) {
            if(is_numeric($post)) {
                $this->select_post_by_id($post);
            } elseif(is_string($post)) {
                $this->select_post_by_slug($post);
            }
        }
    }
    
    private function select_post_by_slug($slug) {
        if(!is_string($slug)) {
            throw new InvalidArgumentException('Post slug must a string');
        } else {
            $fields = array(
                'p.post_id',
                'p.post_title',
                'p.post_content',
                'p.post_date',
                'p.post_slug',
                '(SELECT status_name FROM blog__post_statuses WHERE status_id = p.post_status) AS post_status_name',
                '(SELECT GROUP_CONCAT(t.tag_name) FROM blog__tags AS t LEFT JOIN blog__posts_tags AS pt ON pt.post_id = post_id) AS post_tags'
            );
            
            $results = $this->db_wrapper->select($this->table_name . ' AS p', $fields, "post_slug = '$slug'");
            
            if($results === false) {
                throw new Exception('No post with slug ' . $slug . ' was found');
            } else {
                $results = Functions::array_flat($results);
                
                $this->set_post_variables($results);
            }
            
        }
    }
    
    private function select_post_by_id($id) {
        if(!is_numeric($id)) {
            throw new InvalidArgumentException('Post id must be a number');
        } else {
            $fields = array(
                'p.post_id',
                'p.post_title',
                'p.post_content',
                'p.post_date',
                'p.post_slug',
                '(SELECT status_name FROM blog__post_statuses WHERE status_id = p.post_status) AS post_status_name',
                '(SELECT GROUP_CONCAT(t.tag_name) FROM blog__tags AS t LEFT JOIN blog__posts_tags AS pt ON pt.post_id = post_id) AS post_tags'
            );
            
            $results = $this->db_wrapper->select($this->table_name . ' AS p', $fields, 'post_id = ' . $id);
            
            if($results === false) {
                throw new Exception('No post with id ' . $id . ' was found');
            } else {
                $results = Functions::array_flat($results);
                
                $this->set_post_variables($results);
            }
        }
    }
    
    private function set_post_variables($post) {
        if(!is_array($post)) {
            throw new InvalidArgumentException('Post must be an array');
        } else {
            $this->post_id = $post['post_id'];
            $this->post_title = $post['post_title'];
            $this->post_content = html_entity_decode($post['post_content']);
            $this->post_date = $post['post_date'];
            $this->post_status = $post['post_status_name'];
            $this->post_tags = explode(',', $post['post_tags']);
            
        }
    }

}

?>