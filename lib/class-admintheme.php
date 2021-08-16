<?php
/**
 * Theme Admin Interface functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package thinkwp
 */

/**
 * Admin Theme class that instatiates with actions, filters, and other definitions specifically behing the is_admin() function
 */
class AdminTheme extends Theme {
	/**
	 * Construct the class adding actions, filters, and other initiation code
	 */
	public function __construct() {
		// Filters!
		add_filter( 'use_block_editor_for_post_type', [ $this, 'check_post_can_gutenberg' ], 10, 2 );
		add_filter( 'gutenberg_can_edit_post_type', [ $this, 'check_post_can_gutenberg' ], 10, 2 );
		// Actions!
		add_action( 'admin_init', array( $this, 'remove_post_support' ) );
	}

	/**
	 * Remove Editor From Applicable Post/Pages
	 */
	public function remove_post_support() {
		$post_id = $this->get_admin_post();
		if ( is_null( $post_id ) ) {
			return;
		}
		if ( get_option( 'page_on_front' ) === $post_id ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}

	/**
	 * Get post loaded in editor
	 */
	protected function get_admin_post() {
		// @codingStandardsIgnoreStart
		if ( ! ( is_admin() && ! empty( $_GET['post'] ) ) ) {
			return null;
		}
		return $_GET['post'];
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Remove Gutenberg Editor from front page
	 *
	 * @param boolean $can_edit true or false user can edit.
	 */
	public function check_post_can_gutenberg( $can_edit ) {
		$post_id = $this->get_admin_post();
		if ( is_null( $post_id ) ) {
			return $can_edit;
		}
		$post_can_gutenberg = true;
		if ( get_option( 'page_on_front' ) === $post_id ) {
			$post_can_gutenberg = false;
		}
		return $post_can_gutenberg;
	}
}
