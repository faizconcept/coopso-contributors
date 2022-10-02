<?php
/**
 * Display the contributors in the admin area in the post section
 *
 * @package Contributors
 */

$i = 1;
foreach ( $wp_users as $cp_user ) {

		$cid     = 'contributor' . $i;
		$checked = in_array( $cp_user->ID, $cp_users ) ? 'checked' : '';

		wp_nonce_field( plugin_basename( __FILE__ ), 'coopso_add_contributor_nonce' );

	?>
		<div>
		<input type="checkbox" name="cp_contributors_field[]" value="<?php echo $cp_user->ID; ?>" id="<?php echo $cid; ?>" <?php echo $checked; ?> />
		<label for="<?php echo $cid; ?>"><?php echo $cp_user->display_name; ?></label>
		</div>
	<?php
	$i++;
}
