<?php 
/**
 * Display the contributors meta box HTML at the front end
 *
 * @package Contributors
 *
 * @param array $contributors  Contributors list in array.
 *
 * @return html content with Contributors list of the post
 */
function display_frontend_contributors_meta_box( $contributors ) {

	$contributors_list = explode( ',', $contributors[0] );

	$html               = "<div class='contributors-heading'>Contributors:</div>";
	$total_contributors = count( $contributors_list );

	for ( $i = 0; $i < $total_contributors; $i ++ ) {

			$author_display_name = get_the_author_meta( 'display_name', $contributors_list[ $i ] );
			$author_page_url     = get_author_posts_url( $contributors_list[ $i ] );

			$html .= sprintf( "<div class='contributor-box'><a href='%s'>%s %s </a></div>", $author_page_url, get_avatar( $contributors_list[ $i ] ), $author_display_name );
	}

	return $html;
}
