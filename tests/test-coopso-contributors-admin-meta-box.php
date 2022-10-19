<?php
/**
 * Class Test_Coopso_Contributors_Admin_Meta_Box
 *
 * @package Coopso_Contributors
 */
class Test_Coopso_Contributors_Admin_Meta_Box extends WP_UnitTestCase {

	/**
	 * Constructor for test
	 */
	public function test_construct() {
		// Replace this with some actual testing code.
		$coopso_add_meta_box = new Coopso_Contributors_Admin_Meta_Box();

		$add_meta_boxes_action_hooked = has_action( 'add_meta_boxes', array( $coopso_add_meta_box, 'create_contributors_box' ) );
		$save_meta_box_action_hooked  = has_action( 'save_post', array( $coopso_add_meta_box, 'save_contributors_box' ) );

		if ( 10 === $add_meta_boxes_action_hooked && 10 === $save_meta_box_action_hooked ) {
			$is_registered = true;
		} else {
			$is_registered = false;
		}

		$this->assertTrue( $is_registered );
	}

	/**
	 * Test to create the contributor box
	 */
	public function test_create_contributors_box() {

		global $wp_meta_boxes;

		$add_meta_box = new Coopso_Contributors_Admin_Meta_Box();
		$add_meta_box->create_contributors_box();

		// Check if the two meta boxes are added on default 'post' screens.
		$add_post_screen_id  = $wp_meta_boxes['post']['side']['default']['coopso_contributors_box_id']['id'];
		$edit_post_screen_id = $wp_meta_boxes['post']['side']['default']['coopso_contributors_box_id']['id'];
		$meta_boxes_added    = ( 'coopso_contributors_box_id' === $add_post_screen_id && 'coopso_contributors_box_id' === $edit_post_screen_id );

		$this->assertTrue( $meta_boxes_added );

	}

	/**
	 * Test for coopso_contributors_box_html()
	 */
	public function test_coopso_contributors_box_html() {

		global $wp_query;
		global $post;

		$add_meta_box = new Coopso_Contributors_Admin_Meta_Box();

		// Create two Dummy user ids.
		$user_ids = $this->factory->user->create_many( 2 );

		// Create a dummy post using the 'WP_UnitTest_Factory_For_Post' class and give the post author's user ud as 2.
		$post_id = $this->factory->post->create(
			array(
				'post_status'  => 'publish',
				'post_title'   => 'Test Post',
				'post_content' => 'Test Content for testing',
				'post_author'  => 1,
				'post_type'    => 'post',
			)
		);

		// Create a custom query for the post with the above created post id.
		$wp_query = new WP_Query(
			array(
				'post__in'       => array( $post_id ),
				'posts_per_page' => 1,
			)
		);

		// Run the WordPress loop through this query to set the global $post.
		if ( $wp_query->have_posts() ) {
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
			}
		}

		// Set the array of user ids to post meta with meta key 'coopso_contributors_box_id', with the above created post id.
		update_post_meta( $post_id, 'coopso_contributors_box_id', $user_ids );

		// output buffering.
		ob_start();

		$add_meta_box->coopso_contributors_box_html( $post );
		$custom_box_html = ob_get_clean();

		// Validate the output string contains the class names we are expecting.
		$coopso_contributors_authors_div = strpos( $custom_box_html, 'coopso-contributors-authors' );

		if ( false === $coopso_contributors_authors_div ) {

			$found_contributors_authors = false;

		} else {

			$found_contributors_authors = true;

		}

		$this->assertTrue( $found_contributors_authors );

		wp_reset_postdata();
	}


}
