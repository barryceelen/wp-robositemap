<?php
/**
 * Template for displaying the admin form
 *
 * @package   RoboSitemap
 * @author    Barry Ceelen
 * @license   GPL-3.0+
 * @link      https://github.com/barryceelen/wp-robositemap
 * @copyright Barry Ceelen
 * @since     Robositemap 1.0.0
 */

?>
<div class="wrap">

	<h1><?php esc_html_e( 'Manage robots.txt and sitemap' ); ?></h1>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="robositemap-settings-form">

		<h2><?php echo esc_html__( 'Robots.txt', 'robositemap' ); ?></h2>

		<input type="hidden" name="action" value="robositemap-save" />
		<?php wp_nonce_field( 'robositemap_save' ); ?>

		<input type="hidden" name="post_id_robots" value="<?php echo ( is_a( $post_robots, 'WP_Post' ) ? esc_attr( $post_robots->ID ) : '' ); ?>" />

		<label class="screen-reader-text" for="robositemap_content_robots">
			<?php echo esc_html__( 'Robots.txt content', 'robositemap' ); ?>
		</label>
		<textarea class="widefat code" rows="25" name="robositemap_content_robots" id="js-robositemap-content-robots"><?php echo esc_textarea( $content_robots ); ?></textarea>

		<h2><?php echo esc_html__( 'Sitemap', 'robositemap' ); ?></h2>

		<input type="hidden" name="post_id_sitemap" value="<?php echo ( is_a( $post_sitemap, 'WP_Post' ) ? esc_attr( $post_sitemap->ID ) : '' ); ?>" />

		<label class="screen-reader-text" for="robositemap_content_sitemap">
			<?php echo esc_html__( 'Sitemap content', 'robositemap' ); ?>
		</label>

		<textarea class="widefat code" rows="25" name="robositemap_content_sitemap" id="js-robositemap-content-sitemap"><?php echo esc_textarea( $content_sitemap ); ?></textarea>

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_attr( 'Save Changes' ); ?>">
			<span class="spinner" style="float:none;vertical-align:top"></span>
		</p>
	</form>

</div>
