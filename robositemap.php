<?php
/**
 * Main plugin file
 *
 * @package   RoboSitemap
 * @author    Barry Ceelen
 * @license   GPL-3.0+
 * @link      https://github.com/barryceelen/wp-robositemap
 * @copyright Barry Ceelen
 *
 * Plugin Name: Robositemap
 * Plugin URI: https://github.com/barryceelen/wp-robositemap
 * Description: Manually edit your robots.txt and sitemap.xml file from the WordPress admin.
 * Version: 1.0.1
 * Text Domain: robositemap
 * Author: Barry Ceelen
 * Author URI: https://github.com/barryceelen
 * License: GPL-3.0+
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/inc/post-type.php';

if ( is_admin() ) {

	define( 'ROBOSITEMAP_DIR', plugin_dir_path( __FILE__ ) );
	define( 'ROBOSITEMAP_URL', plugin_dir_url( __FILE__ ) );

	require_once __DIR__ . '/inc/admin.php';

} else {

	require_once __DIR__ . '/inc/public.php';
}
