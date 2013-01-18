<?php
/**
 *  Shows a single project from the database
 * 
 *  Controller for showing a single project from the database
 * 
 * @filename modules/portfolio/show_single_project.php
 * @package Portfolio
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 * @todo Add logging of exceptions
 */

try {
    $project = new Project($sql, $project_id);
    
    $tokens = array(
        'PROJECT_TITLE' => $project->project_title,
        'PROJECT_SLUG' => strtolower($project->project_title),
        'PROJECT_TAGLINE' => $project->project_tagline,
        'PROJECT_YEAR' => $project->project_year,
        'PROJECT_DEV_TIME' => $project->project_dev_time,
        'PROJECT_THUMBNAIL' => $project->project_thumbnail,
        'PROJECT_DESCRIPTION' => $project->project_description,
        'PROJECT_DEMO_URL' => $project->project_demo_url,
        'PROJECT_DEMO_LINK' => str_replace('/', '', str_replace('http://', '', $project->project_demo_url)),
        'PROJECT_GITHUB_URL' => $project->project_github_url,
        'PROJECT_LANGUAGES' => Functions::implode_with_tag($project->project_languages, '<b>', true),
        'PROJECT_TOOLS' => Functions::implode_with_tag($project->project_tools, '<b>', true)
    );
    
    $project_template = new Template(TEMPLATES . 'portfolio/single_project.html', $tokens);
    
    echo $project_template->return_parsed_template();
    
} catch(Exception $e) {
    echo $e->getMessage();
}

?>
