<?php
/**
 *  Controller for featured project
 * 
 *  The controller that shows the featured project
 * 
 * @filename modules/portfolio/featured.php
 * @package Portfolio modules
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 */

$project_id = $settings->featured_project;

$project = new Project($sql, $project_id);

$tokens = array(
    'PROJECT_TITLE' => $project->project_title,
    'PROJECT_TAGLINE' => $project->project_tagline,
    'PROJECT_THUMBNAIL' => $project->project_thumbnail
);

$featured_template = new Template(TEMPLATES . 'portfolio/featured.html', $tokens);
echo $featured_template->return_parsed_template();

?>
