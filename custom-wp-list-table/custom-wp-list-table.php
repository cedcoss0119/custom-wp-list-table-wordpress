<?php

/**
 * Plugin Name:       WP List Table Plugins
 * Plugin URI:        https://example.com/plugins/meta-box/
 * Description:       This is my custom menu in admin tab
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Abdullah
 * Author URI:        https://facebook.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */
?>




<?php

// echo plugins_url();		die;				// -> 	http://localhost/wordpress/wp-content/plugins
// echo plugin_dir_path(__FILE__);			->  /opt/lampp/htdocs/wordpress/wp-content/plugins/custom-plugins/
 

// Global file page structure 
define('PLUGIN_DIR_PATH', plugin_dir_path(__FILE__) );
define('PLUGIN_URL', plugins_url(__FILE__) ); 

//echo PLUGIN_DIR_PATH."<br>".PLUGIN_URL;
//die;

/**
 * Create admin Page to list unsubscribed emails.
 */
 // Hook for adding admin menus
 add_action('admin_menu', 'wpdocs_unsub_add_table');
 
 // action function for above hook
 
/**
 * Adds a new top-level page to the administration menu.
 */
function wpdocs_unsub_add_table() {
     add_menu_page(
        __( 'Admin Menu', 'Admin Custom Menu' ),
        __( 'List Data'),
        'manage_options',
        'wpdocs-unsub-list',	// parent slug
        'all_page_function_table',

        
    );

    // all page 
    add_submenu_page(
     	'wpdocs-unsub-list',
     	'Show Table',
     	'Show Table',
     	'manage_options',
     	'show-table',
     	'all_page_function_table'
    );


    /* add new page
    add_submenu_page(
    	'wpdocs-unsub-list',
     	'Add New',
     	'Add New',
     	'manage_options',
     	'add-new',
     	'add_new_page'
    );
    */
}
 
/**
 * Disply callback for the Unsub page.
 */

function add_new_page(){
	include_once PLUGIN_DIR_PATH."wp-list-table-view/wp-list-table.php";
}


function all_page_function_table() {
    include_once PLUGIN_DIR_PATH."wp-list-table-view/wp-list-table.php";
}
 

// Attach our css file with wp_enqueue_style method

// first we create our hook 
function wp_my_style_scripts(){

    wp_enqueue_style('style', "http://localhost/wordpress/wp-content/plugins/custom-plugins/assets/css/style.css");
    wp_enqueue_script('wp-main', "http://localhost/wordpress/wp-content/plugins/custom-plugins/assets/js/wp-main.js");
}
add_action('init', 'wp_my_style_scripts');



// Dynamic table creation
function custom_plugins_table(){
	global $wpdb;
	require_once(ABSPATH.'wp-admin/includes/upgrade.php');
	if(count($wpdb->get_var('SHOW TABLES LIKE "wp_custom_contact" ')) == 0){
	$sql_query_to_create_table = "CREATE TABLE `wp_custom_contact` (
								 `id` int(11) NOT NULL AUTO_INCREMENT,
								 `name` varchar(255) DEFAULT NULL,
								 `email` varchar(255) DEFAULT NULL,
								 `created_At` timestamp NULL DEFAULT NULL,
								 PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
								
	dbDelta($sql_query_to_create_table);
	}
}

register_activation_hook(__FILE__, 'custom_plugins_table')

// ---------------------- WP LIST TABLE CODE START HERE ------------------------------


 
?>