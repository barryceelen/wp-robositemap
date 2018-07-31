<?php
/**
 * Contains admin functionality
 *
 * @package   RoboSitemap
 * @author    Barry Ceelen
 * @license   GPL-3.0+
 * @link      https://github.com/barryceelen/wp-robositemap
 * @copyright Barry Ceelen
 * @since     RoboSitemap 1.0.0
 */

namespace RoboSitemap;

// Enqueue admin scripts.
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue_scripts' );

// Enqueue admin styles.
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue_styles' );

// Add admin menu page.
add_action( 'admin_menu', __NAMESPACE__ . '\admin_menu' );

// Process and save our data.
add_action( 'admin_post_robositemap-save', __NAMESPACE__ . '\save' );

// Add an action link pointing to the options page.
$robositemap_plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . 'robositemap.php' );
add_filter( 'plugin_action_links_' . $robositemap_plugin_basename, __NAMESPACE__ . '\add_plugin_action_link' );

/**
 * Enqueue admin scripts.
 *
 * @since 1.0.0
 * @param  string $hook Hook name for the current screen.
 * @return void
 */
function admin_enqueue_scripts( $hook ) {

	if ( 'settings_page_robositemap-settings' !== $hook ) {
		return;
	}

	wp_enqueue_script(
		'robositemap',
		esc_url( ROBOSITEMAP_URL . 'js/admin.js' ),
		array(
			'jquery',
			'wp-codemirror',
		),
		'1.0.0',
		true
	);

	$strings = array(
		'saved_message' => esc_html__( 'Saved', 'robositemap' ),
		'unknown_error' => esc_html__( 'An unknown error occurred.', 'robositemap' ),
	);

	wp_localize_script(
		'robositemap',
		'robositemap',
		$strings
	);
}


/**
 * Render styles.
 *
 * @since 1.0.0
 * @param  string $hook Hook name for the current screen.
 * @return void
 */
function admin_enqueue_styles( $hook ) {

	if ( 'settings_page_robositemap-settings' !== $hook ) {
		return;
	}

	wp_enqueue_style(
		'robositemap',
		esc_url( ROBOSITEMAP_URL . 'css/admin.css' ),
		array(
			'code-editor',
		),
		'1.0.0',
		false
	);
}


/**
 * Add admin menu page.
 *
 * @since 1.0.0
 * @return void
 */
function admin_menu() {

	add_options_page(
		esc_html__( 'Robots.txt and Sitemap', 'robositemap' ),
		esc_html__( 'Robots.txt & Sitemap', 'robositemap' ),
		'manage_options',
		'robositemap-settings',
		__NAMESPACE__ . '\render_settings_screen'
	);
}


/**
 * Output the settings screen.
 *
 * @since 1.0.0
 * @return void
 */
function render_settings_screen() {

	$content_sitemap = '';
	$content_robots  = '';
	$post_id_robots  = get_option( 'robositemap_robotstxt' );
	$post_id_sitemap = get_option( 'robositemap_sitemap' );
	$post_robots     = false;
	$post_sitemap    = false;

	if ( $post_id_robots ) {
		$post_robots = get_post( $post_id_robots );
	}

	if ( is_a( $post_robots, 'WP_Post' ) ) {
		$content_robots = $post_robots->post_content;
	}

	if ( $post_id_sitemap ) {
		$post_sitemap = get_post( $post_id_sitemap );
	}

	if ( is_a( $post_sitemap, 'WP_Post' ) ) {
		$content_sitemap = $post_sitemap->post_content;
	}

	require ROBOSITEMAP_DIR . 'templates/form.php';
}

/**
 * Process and save our data.
 *
 * @since 1.0.0
 * @return void
 */
function save() {

	current_user_can( 'manage_options' ) || die;
	check_admin_referer( 'robositemap_save' );

	$_post = stripslashes_deep( $_POST );

	$post_id_robots  = $_post['post_id_robots'];
	$post_id_sitemap = $_post['post_id_sitemap'];

	$postarr = array(
		'ID'           => $post_id_robots,
		'post_title'   => 'Robots.txt',
		'post_content' => wp_kses_post( $_post['robositemap_content_robots'] ),
		'post_type'    => 'robositemap',
		'post_status'  => 'publish',
	);

	$post_id_robots = wp_insert_post( $postarr );

	if ( $post_id_robots ) {
		// Todo: Show error.
		update_option( 'robositemap_robotstxt', $post_id_robots );
	}

	$postarr = array(
		'ID'           => $post_id_sitemap,
		'post_title'   => 'Sitemap',
		'post_content' => $_post['robositemap_content_sitemap'], // Note: Not escaping anything here!
		'post_type'    => 'robositemap',
		'post_status'  => 'publish',
	);

	$post_id_sitemap = wp_insert_post( $postarr );

	if ( $post_id_sitemap ) {
		// Todo: Show error.
		update_option( 'robositemap_sitemap', $post_id_sitemap );
	}

	wp_safe_redirect( esc_url_raw( $_post['_wp_http_referer'] ) . '&updated=true' );
	exit;
}

/**
 * Add a plugin settings link to the plugins page.
 *
 * @since 1.0.1
 *
 * @param array $links An array of action links.
 * @return array Modified array of action links.
 */
function add_plugin_action_link( $links ) {

	if ( current_user_can( 'manage_options' ) ) {
		$link = sprintf(
			'<a href="%s">%s</a>',
			admin_url( 'options-general.php?page=robositemap-settings' ),
			esc_html__( 'Settings', 'multilocale' )
		);
		$links = array_merge( array( 'settings' => $link ), $links );
	}

	return $links;
}
