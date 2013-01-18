<?php
/**
 *  Controller for showing all projects
 * 
 *  Shows all projects in the portfolio
 * 
 * @filename modules/portfolio/projects.php
 * @package Portfolio modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

try {
    $project_object = new Project($sql);
    
    $project_ids = $project_object->return_all_project_ids();
    
    $projects_html = '';
    
    foreach($project_ids as $project_id) {
        ob_start();
        include 'show_single_project.php';
        $projects_html .= ob_get_clean();
    }
    
    $all_projects_template = new Template(TEMPLATES . 'portfolio/all_projects.html', array('ALL_PROJECTS' => $projects_html));
    echo $all_projects_template->return_parsed_template();
    
} catch(Exception $e) {
    echo $e->getMessage();
}

?>
