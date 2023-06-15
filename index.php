<?php
/**
 * Plugin Name: All in One SEO Author
 * Description: Adds author schema to All in One SEO
 * Author:      Velocity Growth
 * Author URI:  https://velocitygrowth.com/
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_admin() ) {
  require_once( plugin_dir_path( __FILE__ ) . 'profile.php' );
} else {
  require_once( plugin_dir_path( __FILE__ ) . 'inject.php' );
}


