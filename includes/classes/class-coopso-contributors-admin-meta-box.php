<?php
/**
 * Contributors meta box admin class
 *
 * @package Contributors
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Create the contributors meta box.
 */
class Coopso_Contributors_Admin_Meta_Box {

	/**
	 * Constructor function.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'coopso_create_contributors_box' ) );
		add_action( 'save_post', array( $this, 'coopso_save_contributors_box' ) );

	}

	/**
	 * To add the meta box in the admin post area
	 */
	public function coopso_create_contributors_box() {
		add_meta_box(
			'coopso_contributors_box_id',
			'Contributors',
			array( $this, 'coopso_contributors_box_html' ),
			array( 'post' ),
			'side'
		);
	}

	/**
	 * To save the meta box function
	 *
	 * @param integer $post_id post id of the post.
	 */
	public function coopso_save_contributors_box( $post_id ) {

		if ( isset( $_POST['post_type'] ) && 'post' === $_POST['post_type'] && ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if the nonce valued we received is the same we created.
		$coopso_contributor_nonce_name = filter_input( INPUT_POST, 'coopso_contributor_nonce_name', FILTER_SANITIZE_STRING );
		if ( ! isset( $coopso_contributor_nonce_name ) || ! wp_verify_nonce( wp_unslash( $coopso_contributor_nonce_name ), COOPSO_CONTRIBUTORS_PLUGIN_BASE_FILE ) ) {
			return;
		}

		$cp_contributors_field = filter_input( INPUT_POST, 'cp_contributors_field', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );

		$cp_contributors_users = ( ! empty( $cp_contributors_field ) ? wp_unslash( $cp_contributors_field ) : array() );

		if ( ! empty( $cp_contributors_users ) ) {

			update_post_meta( $post_id, 'coopso_contributors_box_id', $cp_contributors_users );
		}
	}

	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post   Post object.
	 */
	public function coopso_contributors_box_html( $post ) {

		$coopso_contributors_user_ids = get_post_meta( $post->ID, 'coopso_contributors_box_id' );

		if ( is_array( $coopso_contributors_user_ids ) && ! empty( $coopso_contributors_user_ids ) ) {
			$cp_contributors_users = $coopso_contributors_user_ids[0];
		}

		$user_query = new WP_User_Query(
			array(
				'role__in' => array( 'administrator', 'editor', 'author' ),
				'number'   => '-1',
				'fields'   => array( 'display_name', 'ID' ),
			)
		);

		$wp_users = $user_query->get_results();

		if ( ! empty( $wp_users ) ) {

			include_once COOPSO_CONTRIBUTORS_DIR . '/templates/admin/coopso-contributors-admin-meta-box.php';
		}
	}
}
