<?php
/**
 * Display the contributors in the admin area in the post section
 *
 * @package Contributors
 */

wp_nonce_field( COOPSO_CONTRIBUTORS_PLUGIN_BASE_FILE, 'coopso_contributor_nonce_name' );
$i       = 1;
$checked = '';
$html    = '';
foreach ( $wp_users as $cp_user ) {

		$cid = 'contributor' . $i;


	if ( is_array( $cp_contributors_users ) && ! empty( $cp_contributors_users ) ) {

		$checked = in_array( $cp_user->ID, $cp_contributors_users, true ) ? 'checked' : '';

	}

	$html .=
	'<div class="coopso-contributors-authors">' .
	'<input type="checkbox" name="cp_contributors_field[]" value="' . (int) $cp_user->ID . '" id="' . esc_html( $cid ) . '" ' . esc_html( $checked ) . ' />' .
	'<label for="' . esc_html( $cid ) . '">' . esc_html( $cp_user->display_name ) . '</label>' .
	'</div>';

	$i++;
}
$allowed = array(
	'div'   => array(
		'class' => array(),
	),
	'input' => array(
		'type'    => array(),
		'name'    => array(),
		'value'   => array(),
		'id'      => array(),
		'checked' => array(),
	),
	'label' => array(
		'for' => array(),
	),
);
echo wp_kses( $html, $allowed );
