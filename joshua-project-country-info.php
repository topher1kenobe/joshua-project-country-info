<?php
/*
Plugin Name: The Joshua Project, Nation Info
Description: Creates a widget and shortcode for rendering nation data from the <a href="http://joshuaproject.net/">Joshua Project</a>.
Author: Topher
Author URI: http://topher1kenobe.com
Text Domain: jp-nation-info
Version: 1.0
License: GPL
*/

/**
 * include the file that has the data fetcher
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/joshua-project-data.class.php'; 

/**
 * include the file that has the widget class
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/country-widget.class.php';

// register Joshua_Project_Country_Widget widget
function register_joshua_project_country_widget() {
	register_widget( 'Joshua_Project_Country_Widget' );
}
add_action( 'widgets_init', 'register_joshua_project_country_widget' );
