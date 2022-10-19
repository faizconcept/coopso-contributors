<?php
/**
 * File to display contributors at Front end.
 *
 * @package Contributors
 *
 * @param array $contributors  Contributors list in array.
 *
 * @return html content with Contributors list of the post.
 */
function display_frontend_contributors_meta_box( $contributors ) {

	$contributors_list = $contributors[0];

	$html               = '<div class="contributors-box-out-area">' .
							'<div class="contributors-heading">Contributors:</div>' .
								'<div class="contributor-list">';
	$total_contributors = count( $contributors_list );

	for ( $i = 0; $i < $total_contributors; $i ++ ) {

			$author_display_name = get_the_author_meta( 'display_name', $contributors_list[ $i ] );
			$author_page_url     = get_author_posts_url( $contributors_list[ $i ] );
			$contributor_image   = get_avatar( $contributors_list[ $i ], 70 );

			$html .= '<div class="contributor-box">' .
						'<a href="' . esc_url( $author_page_url ) . '">' .
							'<div class="contributor-image">' . $contributor_image . '</div>' .
							'<div class="contributor-name">' . $author_display_name . '</div>' .
						'</a>' .
					'</div>';

	}

			$html .= '</div>' .
			'</div>';

	return $html;
}
