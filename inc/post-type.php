<?php
/**
 * Contains the custom post type functionality
 *
 * @package   RoboSitemap
 * @author    Barry Ceelen
 * @license   GPL-3.0+
 * @link      https://github.com/barryceelen/wp-robositemap
 * @copyright Barry Ceelen
 */

namespace RoboSitemap;

add_action( 'init', __NAMESPACE__ . '\register' );

/**
 * Register the 'robositemap' custom post type.
 *
 * @since 1.0.0
 * @return void
 */
function register() {

	$labels = array(
		'name'          => __( 'RoboSitemap', 'robositemap' ),
		'singular_name' => __( 'RoboSitemap', 'robositemap' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => false,
		'capability_type'     => 'post',
		'capabilities'     => array(
			'create_posts'           => 'manage_options',
			'delete_others_posts'    => 'manage_options',
			'delete_post'            => 'manage_options',
			'delete_posts'           => 'manage_options',
			'delete_private_posts'   => 'manage_options',
			'delete_published_posts' => 'manage_options',
			'edit_others_posts'      => 'manage_options',
			'edit_post'              => 'manage_options',
			'edit_posts'             => 'manage_options',
			'edit_private_posts'     => 'manage_options',
			'edit_published_posts'   => 'manage_options',
			'publish_posts'          => 'manage_options',
			'read'                   => 'read',
			'read_post'              => 'manage_options',
			'read_private_posts'     => 'manage_options',
		),
		'has_archive'         => false,
		'show_in_nav_menus'   => false,
		'hierarchical'        => false,
		'exclude_from_search' => true,
		'taxonomies'          => array(),
		'supports'            => array(
			'revisions',
		),
	);

	register_post_type( 'robositemap', $args );
}
