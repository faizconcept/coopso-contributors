<?php
/**
 * Plugin Name: Coopso Contributors
 * Plugin URI: http://wordpress.org/plugins/coopso-contributors/
 * Description: This is a WordPress contributors plugin. Admin can select the multiple users who contribute to the post. When the admin can activate this plugin then the contributors' meta box will be displayed and the admin can select the users (editors, authors, admin) who can contribute to the post. At the front end under the post details page after the post content, there will be contributors box will be displayed. In the contributor's box,   users (authors, editors, and admin) names and Gravatars will be displayed. The guest users can click on the Gravatar or username and it will be redirected to the author page.
 * Version: 1.0.0
 * Author: Faiz A Shaikh
 * Author URI: https://profiles.wordpress.org/faiz786/
 * Coopso Contributors is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Coopso Contributors is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Coopso Contributors. If not, see <https://www.gnu.org/licenses/>.
 *
 * @package Contributors
 */

define( 'COOPSO_CONTRIBUTORS_DIR', dirname( __FILE__ ) );
define( 'COOPSO_CONTRIBUTORS_PLUGIN_BASE_FILE', plugin_basename( __FILE__ ) );


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
