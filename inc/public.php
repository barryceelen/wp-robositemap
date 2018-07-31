<?php
/**
 * Contains admin functionality
 *
 * @package   RoboSitemap
 * @author    Barry Ceelen
 * @license   GPL-3.0+
 * @link      https://github.com/barryceelen/wp-robositemap
 * @copyright Barry Ceelen
 * @since     Robositemap 1.0.0
 */

namespace RoboSitemap;

// Display the contents of the sitemap.xml.
add_action( 'init', __NAMESPACE__ . '\robositemap_sitemap' );

// Display the contents of the robots.txt.
add_filter( 'robots_txt', __NAMESPACE__ . '\robositemap_robots_txt', 10, 2 );

/**
 * Display the contents of the sitemap.xml.
 *
 * @since 1.0.0
 *
 * @return void
 */
function robositemap_sitemap() {

	if ( empty( $_SERVER['REQUEST_URI'] ) ) { // WPCS: input var okay.
		return;
	}

	$request = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ); // WPCS: input var okay.

	if ( '/sitemap.xml' === $request ) {

		$post_id = get_option( 'robositemap_sitemap' );

		if ( ! empty( $post_id ) ) {

			$post = get_post( $post_id );

			if ( $post ) {
				header( 'Content-type: text/xml' );
				echo $post->post_content; // WPCS: XSS ok.
				die();
			}
		}
	}
}

/**
 * Display the contents of the sitemap.xml.
 *
 * @since 1.0.0
 *
 * @param string $output Robots.txt output.
 * @param bool   $public Whether the site is considered "public".
 * @return string
 */
function robositemap_robots_txt( $output, $public ) {

	$post_id = get_option( 'robositemap_robotstxt' );

	if ( ! empty( $post_id ) ) {

		$post = get_post( $post_id );

		if ( $post && ! empty( $post->post_content ) ) {

			$output = esc_html( $post->post_content );
		}
	}

	return $output;
}
