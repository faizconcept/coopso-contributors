<?php
/**
 * Contributors meta box frontend class
 *
 * @package Contributors
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * To display the contributors at the front end
 */
class Coopso_Contributors_Frontend_Meta_Box {

	/**
	 * Constructor function.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_frontend_contributors_stylesheet' ) );
		add_filter( 'the_content', array( $this, 'coopso_contributors_display_after_content' ) );
	}

	/**
	 * To register the stylesheet of contributors
	 */
	public function register_frontend_contributors_stylesheet() {
		wp_register_style( 'coopso_contributors', plugins_url( '../../assets/css/frontend-contributors-style.css', __FILE__ ), array(), '1.0' );
		wp_enqueue_style( 'coopso_contributors' );
	}

	/**
	 * The description.
	 *
	 * @param string $content This is the post content.
	 * @return string The updated content.
	 */
	public function coopso_contributors_display_after_content( $content ) {

		if ( is_single() ) {
			$post_id = get_the_ID();

			// get the contributors list.
			$contributors = get_post_meta( $post_id, 'coopso_contributors_box_id' );
			if ( ! empty( $contributors ) ) {

				include_once COOPSO_CONTRIBUTORS_DIR . '/templates/frontend/coopso-contributors-frontend-meta-box.php';
				$contributors_meta_box_html = display_frontend_contributors_meta_box( $contributors );
				$content                    = $content . $contributors_meta_box_html;
			}
		}

		return $content;
	}

}
