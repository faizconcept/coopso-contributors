<?php
/**
 * Plugin Name: Coopso Contributors
 * Plugin URI: http://wordpress.org/plugins/coopso-contributors/
 * Description: This is a WordPress contributors plugin. Admin can select the multiple users who contribute into the post. When admin can activate this plugin then contributors' meta box will be displayed and admin can select the authors who contribute to the post and those name will be displayed the at the front end under the post title with Gravatars of the authors.
 * Version: 1.0.0
 * Author: Faiz A Shaikh
 * Author URI: https://profiles.wordpress.org/faiz786/
 *
 * @package Contributors
 */

define( 'COOPSO_CONTRIBUTORS_DIR', dirname( __FILE__ ) );

// include contributors admin meta box class.
require_once COOPSO_CONTRIBUTORS_DIR . '/includes/classes/class-coopso-contributors-admin-meta-box.php';

// include contributors frontend meta box class.
require_once COOPSO_CONTRIBUTORS_DIR . '/includes/classes/class-coopso-contributors-frontend-meta-box.php';

// call the contributors object.
new Coopso_Contributors_Admin_Meta_Box();

// Showcase contributors list on the front end.
if ( ! is_admin() ) {
	new Coopso_Contributors_Frontend_Meta_Box();
}
