<?php
/**
 * Class Test_Coopso_Contributors_Frontend_Meta_Box
 *
 * @package Coopso_Contributors
 */
class Test_Coopso_Contributors_Frontend_Meta_Box extends WP_UnitTestCase {

	/**
	 * Contructor for the test.
	 */
	public function test_construct() {
		// Replace this with some actual testing code.
		$show_contributors = new Coopso_Contributors_Frontend_Meta_Box();

		$front_end_style_action_hooked = has_action( 'wp_enqueue_scripts', array( $show_contributors, 'register_frontend_contributors_stylesheet' ) );

		$is_registered = has_action( 'the_content', array( $show_contributors, 'coopso_contributors_display_after_content' ) );

		if ( 10 === $is_registered && 10 === $front_end_style_action_hooked ) {
			$is_registered = true;
		} else {
			$is_registered = false;
		}

		$this->assertTrue( $is_registered );
	}

	/**
	 * Test to display the contributors after the content.
	 */
	public function test_coopso_contributors_display_after_content() {

		global $wp_query;

		// Set the $content value for testing.
		$content              = 'Test content for testing';
		$display_contributors = new Coopso_Contributors_Frontend_Meta_Box();

		// Create a dummy post using the 'WP_UnitTest_Factory_For_Post' class.
		$post_id = $this->factory->post->create(
			array(
				'post_status'  => 'publish',
				'post_title'   => 'Test 1',
				'post_content' => 'Test Content',
			)
		);

		// Create three Dummy user ids.
		$user_ids = $this->factory->user->create_many( 3 );

		// Call the update_post_meta to store the array of three user ids created above.
		update_post_meta( $post_id, 'coopso_contributors_box_id', $user_ids );

		$wp_query = new WP_Query(
			array(
				'post__in'       => array( $post_id ),
				'posts_per_page' => 1,
			)
		);

		if ( $wp_query->have_posts() ) {
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();

				$wp_query->is_single = true;

				$filtered_output = $display_contributors->coopso_contributors_display_after_content( $content );

				/**
				 * Check if the 'contributor-name' class name is present in the output
				 * If the strpos() returns a position, which means our content was added, in which case our test is successful.
				 */
				$string_found = strpos( $filtered_output, 'contributor-name' );
				$this->assertTrue( false !== $string_found );

			}
		}

	}

	/**
	 * Test for register_frontend_contributors_stylesheet()
	 */
	public function test_register_frontend_contributors_stylesheet() {

		$enqueue_style = new Coopso_Contributors_Frontend_Meta_Box();
		$enqueue_style->register_frontend_contributors_stylesheet();

		// Check if the stylesheet is enqueued, wp_style_is will return true if its enqueued.
		$enqueued_post_meta_css = wp_style_is( 'coopso_contributors' );

		$this->assertTrue( $enqueued_post_meta_css );
	}


}
