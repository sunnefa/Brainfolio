<?php
/**
 *  The class model for the projects table
 * 
 *  This class represents a single project from the projects table. It can also update, add and delete a project.
 * 
 * @filename classes/portfolio/Project.php
 * @package Portfolio
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

/**
 * Model for projects table
 * @since 0.1
 */
class Project {
    
    /**
     * The id of a project
     * @var int 
     */
    public $project_id;
    
    /**
     * The title of a project
     * @var string
     */
    public $project_title;
    
    /**
     * A tagline describing the project in a few words
     * @var string 
     */
    public $project_tagline;
    
    /**
     * The description of a project
     * @var string 
     */
    public $project_description;
    
    /**
     * The thumbnail image to accompany the project
     * @var type 
     */
    public $project_thumbnail;
    
    /**
     * The url to a demo of the project
     * @var string 
     */
    public $project_demo_url;
    
    /**
     * The url to the project's github repo
     * @var string 
     */
    public $project_github_url;
    
    /**
     * The development time
     * @var string 
     */
    public $project_dev_time;
    
    /**
     * The year the project was made
     * @var int 
     */
    public $project_year;
    
    /**
     * The languages used in the project
     * @var array 
     */
    public $project_languages;
    
    /**
     * The tools used in the project
     * @var array
     */
    public $project_tools;
    
    /**
     * The projects table
     * @var string 
     */
    private $table_name = 'portfolio__projects';
    
    /**
     * The database wrapper
     * @var DBWrapper 
     */
    private $db_wrapper;
    
    /**
     * Constructor
     * @param DBWrapper $sql
     * @param int $project_id 
     */
    function __construct(DBWrapper $sql, $project_id = 0){
        $this->db_wrapper = $sql;
        
        if($project_id) {
            $this->select_project_by_id($project_id);
        }
    }
    
    /**
     * Gets a single project from the database
     * @param int $project_id
     * @throws InvalidArgumentException 
     */
    private function select_project_by_id($project_id) {
        if(!is_numeric($project_id)) {
            throw new InvalidArgumentException("Project id should be numeric");
        } else {
            $results = $this->db_wrapper->select($this->table_name, '*', 'project_id = ' . $project_id);
            if($results === false) {
                throw new Exception('No records found');
            } else {
                $results = Functions::array_flat($results);
                
                $this->project_id = $results['project_id'];
                $this->project_title = $results['project_title'];
                $this->project_tagline = $results['project_tagline'];
                $this->project_description = $results['project_description'];
                $this->project_thumbnail = $results['project_thumbnail'];
                $this->project_demo_url = $results['project_demo_url'];
                $this->project_github_url = $results['project_github_url'];
                $this->project_year = $results['project_year'];
                $this->project_dev_time = $results['project_dev_time'];
                
                try {
                    $this->project_tools = $this->get_project_tools($results['project_id']);
                    $this->project_languages = $this->get_project_languages($results['project_id']);
                } catch(InvalidArgumentException $e) {
                    throw new InvalidArgumentException($e->getMessage());
                }
                
            }
        }
    }
    
    /**
     * Gets the projects tools from the database
     * @param int $project_id
     * @return array
     * @throws InvalidArgumentException 
     */
    private function get_project_tools($project_id) {
        if(!is_numeric($project_id)) {
            throw new InvalidArgumentException('Project id should be numeric');
        } else {
            $joins = $this->db_wrapper->build_joins('portfolio__projects_tools AS pt', array('pt.tool_id', 't.tool_id'), 'left');
            $results = $this->db_wrapper->select(
                    'portfolio__tools AS t',
                    'tool_name',
                    'pt.project_id = ' . $project_id, null, 'tool_name', null, $joins
            );
            if($results === false) {
                return array();
            } else {
                $tools = array();
                foreach($results as $tool) {
                    $tools[] = $tool['tool_name'];
                }
                return $tools;
            }
        }
    }
    
    /**
     * Gets the project languages from the database
     * @param int $project_id
     * @return array
     * @throws InvalidArgumentException 
     */
    private function get_project_languages($project_id) {
        if(!is_numeric($project_id)) {
            throw new InvalidArgumentException('Project id should be numeric');
        } else {
            $joins = $this->db_wrapper->build_joins('portfolio__projects_languages AS pl', array('pl.language_id', 'l.language_id'), 'left');
            $results = $this->db_wrapper->select('portfolio__languages AS l', 
                    'language_name', 
                    'pl.project_id = ' . $project_id, 
                    null, 'l.language_name', null, $joins
            );
            if($results === false) {
                return array();
            } else {
                $langs = array();
                foreach($results as $lang) {
                    $langs[] = $lang['language_name'];
                }
                return $langs;
            }
        }
    }
    
    /**
     * Selects only project id's from the database which can then be used to create 
     * separate Project objects for each project
     * @return array
     * @throws Exception 
     */
    public function return_all_project_ids() {
        $results = $this->db_wrapper->select($this->table_name, 'project_id');
        
        if($results === false) {
            throw new Exception('No project ids were found');
        } else {
            $ids = array();
            foreach($results as $project) {
                $ids[] = $project['project_id'];
            }
            return $ids;
        }
        
    }

}

?>