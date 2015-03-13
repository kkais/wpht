<?php
/* Plugin Name: Handsome Testimonials
Plugin URI: http://handsomeapps.io
Description: Create Testimonials with Style
Version: 1.1.4
Author: Handsome Apps
License: GPLv2 or later
Text Domain: hndtst_loc
*/

/*********************
CONSTANTS
**********************/

// plugin prefix
if(!defined('TSTMT_PREFIX')) {
    define('TSTMT_PREFIX', 'uig_');
}
 
// plugin folder url
if(!defined('TSTMT_PLUGIN_URL')) {
    define('TSTMT_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}
 
// plugin folder path
if(!defined('TSTMT_PLUGIN_DIR')) {
    define('TSTMT_PLUGIN_DIR', dirname(__FILE__));
}


/*********************
GLOBAL VARIABLES
**********************/
//Retreive plugin settinsg from database
$handsometestimonials_options = get_option('handsometestimonials_settings'); 


/*********************
INCLUDES
**********************/

include(TSTMT_PLUGIN_DIR . '/includes/settings_getting_started.php'); //the plugin options page
include(TSTMT_PLUGIN_DIR . '/includes/hndtst_post-type.php'); //Register testimonial custom post type
include(TSTMT_PLUGIN_DIR . '/includes/tst_shortcode-single.php'); //Shortcode for single testimonial
include(TSTMT_PLUGIN_DIR . '/includes/tst_shortcode-preview.php'); //Shortcode for testimonial generator preview
include(TSTMT_PLUGIN_DIR . '/includes/tst_display_functions.php'); //Shortcode for testimonial generator preview
include(TSTMT_PLUGIN_DIR . '/includes/tst_shortcode_generator.php'); //Testimonial Shortcode Generator UI 
include(TSTMT_PLUGIN_DIR . '/includes/tst_dragdrop.php'); //Testimonial Shortcode Generator UI 
include(TSTMT_PLUGIN_DIR . '/includes/admin-alerts.php'); //Admin Alerts


/*******************************************
* Plugin text domain for translations
*******************************************/
 
load_plugin_textdomain( 'hndtst_loc', false, dirname( plugin_basename( __FILE__ ) ) . '/includes/languages/' );


/*******************************************
Enqueue Styles and Scripts
********************************************/
//Enqueue Admin Styles and Scripts
add_action( 'admin_enqueue_scripts', 'hndtst_load_admin_scripts', 100 );
function hndtst_load_admin_scripts() {

    wp_enqueue_style( 'hndtst_admin', TSTMT_PLUGIN_URL . 'includes/css/admin.css' );

}

/*******************************************
Create/Upgrade DB Table for saving testimonial shortcode data
********************************************/
// Run the install scripts upon plugin activation
register_activation_hook(__FILE__,'hndtst_saved_tsts');

//Set DB Table Version
global $hndtst_db_version;
$hndtst_db_version = '1.0';


//Create testimonial shortcode database table upon installation
function hndtst_saved_tsts () {
   global $wpdb;
   global $hndtst_db_version;
   $hndtst_saved_tsts = $wpdb->prefix . 'hndtst_saved';

	$charset_collate = $wpdb->get_charset_collate();

	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$hndtst_saved_tsts'") != $hndtst_saved_tsts) 

	{

		$sql = "CREATE TABLE " . $hndtst_saved_tsts . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		shortcode text NOT NULL,
		UNIQUE KEY id (id)
		) $charset_collate; ";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

		add_option( 'hndtst_db_version', $hndtst_db_version );
	}

}


?>