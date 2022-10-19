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
		add_action( 'wp_enqueue_scripts', array( $this, 'register_frontend_contributors_stylesheet' ) );
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

				$contributors_list = $contributors[0];

				$contributors_box_html = '<div class="contributors-box-out-area">' .
										'<div class="contributors-heading">Contributors:</div>' .
											'<div class="contributor-list">';
				$total_contributors    = count( $contributors_list );

				for ( $i = 0; $i < $total_contributors; $i ++ ) {

						$author_display_name = get_the_author_meta( 'display_name', $contributors_list[ $i ] );
						$author_page_url     = get_author_posts_url( $contributors_list[ $i ] );
						$contributor_image   = get_avatar( $contributors_list[ $i ], 70 );

						$contributors_box_html .= '<div class="contributor-box">' .
									'<a href="' . esc_url( $author_page_url ) . '">' .
										'<div class="contributor-image">' . $contributor_image . '</div>' .
										'<div class="contributor-name">' . $author_display_name . '</div>' .
									'</a>' .
								'</div>';

				}

						$contributors_box_html .= '</div>' .
						'</div>';

						$content = $content . $contributors_box_html;
			}
		}

		return $content;
	}

}
