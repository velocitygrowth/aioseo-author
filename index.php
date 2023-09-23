<?php
/**
 * Plugin Name: JSON-LD Author Schema
 * Description: Adds author schema to various SEO plugins.
 * Author:      Velocity Growth
 * Author URI:  https://velocitygrowth.com/
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$root_dir = plugin_dir_path( __FILE__ );

if ( is_admin() ) {
  require_once( $root_dir . 'profile.php' );
} else {
  require_once( $root_dir . 'inject/common.php' );
  require_once( $root_dir . 'inject/aioseo.php' );
  require_once( $root_dir . 'inject/smartcrawl.php' );
  require_once( $root_dir . 'inject/yoast.php' );
}


