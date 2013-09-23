<?php

/**
 *  Error and exception handling
 * 
 *  This file defines handling functions for error and exception handling
 * 
 * @filename config/errors.php
 * @package Configuration
 * @version 0.1
 * @author Sunnefa Lind <sunnefa_lind@hotmail.com>
 * @copyright Sunnefa Lind 2013
 * @license http://opensource.org/licenses/gpl-3.0.html GNU Public License 3.0
 * @todo Implement this
 */

function center_die($error_message, $database_error = false) {
    global $settings;
    global $sql;
    @ob_clean();
    
    require_once MODULES . 'core/errors.php';
    //echo $error_message;
    exit;
}

?>
