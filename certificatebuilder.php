<?php

/*
Plugin Name: Certificate Builder
Plugin URI: http://noiaa.com/
Description: To generate certificates of trainees who have completed training programs
Version: 1.0
Author: Powered by Djouonang Landry
Author URI: http://noiaa.com/

*/

defined( 'ABSPATH' ) or die( 'Access denied buddy!' );


/**
 * Define some useful constants for shortening of path URLs
 **/
define('NOIAA_CERTIFICATE_VERSION', '1.0');
define('NOIAA_CERTIFICATE_DIR', plugin_dir_path(__FILE__));


/**
 * Load files
 * 
 **/
 
 function noiaa_files_loader(){
		
    if(is_admin()){ //load admin files only in admin
        require_once(NOIAA_CERTIFICATE_DIR.'admin/dashboard.php');
    }    
}

noiaa_files_loader();







?>