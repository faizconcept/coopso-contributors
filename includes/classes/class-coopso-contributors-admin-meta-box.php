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
		add_action( 'add_meta_boxes', array( $this, 'create_contributors_box' ) );
		add_action( 'save_post', array( $this, 'save_contributors_box' ) );

	}

	/**
	 * To add the meta box in the admin post area
	 */
	public function create_contributors_box() {
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
	public function save_contributors_box( $post_id ) {

		$cp_contributors_field = isset( $_POST['cp_contributors_field'] ) ? $_POST['cp_contributors_field'] : '';
		if ( ! empty( $cp_contributors_field ) ) {

			$cp_user_list = array();
			foreach ( $cp_contributors_field as $cp_user ) {
				$cp_user_list[] = sanitize_text_field( $cp_user );
			}

			$cp_users = implode( ',', $cp_user_list );
			if ( isset( $cp_users ) ) {
				update_post_meta( $post_id, 'coopso_contributors_box_id', $cp_users );
			}
		}
	}

	/**
	 * Display the meta box HTML to the user.
	 *
	 * @param \WP_Post $post   Post object.
	 */
	public function coopso_contributors_box_html( $post ) {
		$cp_users_str = get_post_meta( $post->ID, 'coopso_contributors_box_id', true );
		$cp_users     = explode( ',', $cp_users_str );

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
