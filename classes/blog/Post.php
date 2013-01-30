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
     * The total number of posts
     * @var int
     */
    public $total_posts;
    
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

    /**
     * Constructor
     * @param DBWrapper $sql
     * @param mixed $post
     */
    public function __construct(DBWrapper $sql, $post = null){
        $this->db_wrapper = $sql;
        
        $this->total_posts = $this->get_post_count();
        
        if($post) {
            $this->select_post($post);
        }
    }
    
    /**
     * Selects a post based on the identifier which can be either an id or a string
     * @param mixed $post_identifier
     * @throws InvalidArgumentException
     * @throws Exception
     */
    private function select_post($post_identifier) {
        if(is_numeric($post_identifier)) {
            $where = 'post_id = ' . $post_identifier;
        } elseif(is_string($post_identifier)) {
            $where = "post_slug = '$post_identifier'";
        } else {
            throw new InvalidArgumentException('Post must be identified by a numer (id) or a string (slug)');
        }
        
        $fields = array(
                'p.post_id',
                'p.post_title',
                'p.post_content',
                'p.post_date',
                'p.post_slug',
                '(SELECT status_name FROM blog__post_statuses WHERE status_id = p.post_status) AS post_status_name',
            );
        
        $results = $this->db_wrapper->select($this->table_name . ' AS p', $fields, $where);
        
        if($results === false) {
            throw new Exception('No post with identifier (id or slug) ' . $post_identifier . ' was found');
        } else {
            $results = Functions::array_flat($results);
            
            $results['post_tags'] = $this->get_post_tags($results['post_id']);
            
            $this->set_post_variables($results);
        }
        
    }
    
    /**
     * Assigns elements of post array to the object variables
     * @param array $post
     * @throws InvalidArgumentException
     */
    private function set_post_variables($post) {
        if(!is_array($post)) {
            throw new InvalidArgumentException('Post must be an array');
        } else {
            $this->post_id = $post['post_id'];
            $this->post_title = $post['post_title'];
            $this->post_content = html_entity_decode($post['post_content']);
            $this->post_date = $post['post_date'];
            $this->post_slug = $post['post_slug'];
            $this->post_status = $post['post_status_name'];
            $this->post_tags = $post['post_tags'];
            
        }
    }
    
    /**
     * Returns an array of tags based on the post's id
     * @param int $post_id
     * @return array
     * @throws InvalidArgumentException
     */
    private function get_post_tags($post_id) {
        if(!is_numeric($post_id)) {
            throw new InvalidArgumentException('Post id must be a number');
        } else {
            $joins = $this->db_wrapper->build_joins('blog__posts_tags AS pt', array('pt.tag_id', 't.tag_id'), 'left');
            
            $results = $this->db_wrapper->select('blog__tags AS t', 't.tag_name', 'pt.post_id = ' . $post_id, null, null, null, $joins);
            
            if($results === false) {
                return array();
            } else {
                $tags = array();
                foreach($results as $tag) {
                    $tags[] = $tag['tag_name'];
                }
                return $tags;
            }
        }
    }
    
    /**
     * Returns the total number of posts
     * @return int
     */
    private function get_post_count() {
        $results = $this->db_wrapper->select($this->table_name, 'COUNT(post_id) AS num');
        
        if($results === false) {
            return 0;
        } else {
            return $results[0]['num'];
        }
        
    }
    
    /**
     * Returns all post ids
     * @param int $limit
     * @param int $start
     * @return array
     */
    public function get_all_post_ids($limit, $start) {
        $results = $this->db_wrapper->select($this->table_name, 'post_id', NULL, $start . ', ' . $limit);
        
        if($results === false) {
            return array();
        } else {
            $ids = array();
            foreach($results as $post) {
                $ids[] = $post['post_id'];
            }
            return $ids;
            
        }
    }
    
    /**
     * Returns all tags in the database, along with their post count
     * @return array
     */
    public function get_all_tags() {
        $joins = $this->db_wrapper->build_joins('blog__posts_tags AS pt', array('pt.tag_id', 't.tag_id'), 'left');
        
        $results = $this->db_wrapper->select('blog__tags AS t', array('t.tag_name', '(SELECT COUNT(post_id) FROM blog__posts_tags WHERE t.tag_id = tag_id) AS post_count'), null, null, null, 't.tag_id', $joins);
        
        return $results;
        
    }
    
    /**
     * Removes a post from the database
     * @return boolean
     */
    private function remove_post() {
        
    }
    
    /**
     * Adds a post to the database
     * @return boolean
     */
    private function add_post() {
        
    }
    
    /**
     * Adds a tag to the database
     * @return boolean
     */
    private function add_tag() {
        
    }
    
    /**
     * Updates a tag in the database
     * @return boolean
     */
    private function update_tag() {
        
    }
    
    /**
     * Removes a tag from the database
     * @return boolean
     */
    private function remove_tag() {
        
    }
    
    /**
     * Updates the relationship between a tag and a post in the database
     * @return boolean
     */
    private function update_tag_post_relationship() {
        
    }
    
    /**
     * Removes the relationship between a tag and a post form the database
     * @return boolean
     */
    private function remove_tag_post_relationship() {
        
    }
    
    /**
     * Adds a relationship between posts and tags to the database
     * @return boolean
     */
    private function add_tag_post_relationship() {
        
    }
    
    /**
     * Check if a tag and a post have a relationship
     * @return boolean
     */
    private function check_tag_post_relationship() {
        
    }

}

?>