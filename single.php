<?php
/**
 * The single post template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package thinkwp
 * @subpackage  Timber
 */

use Timber\Timber;

$context     = Timber::get_context();
$timber_post = Timber::query_post();
if ( isset( $timber_post->hero_hero_image ) && strlen( $timber_post->hero_hero_image ) ) {
	$timber_post->hero_image = new \Timber\Image( $timber_post->hero_hero_image );
} else {
	$timber_post->hero_image = $timber_post->thumbnail;
}
if ( isset( $timber_post->flexible_content ) && is_array( $timber_post->flexible_content ) && count( $timber_post->flexible_content ) ) {
	$timber_post->flexible_blocks = $timber_post->flexible_content;
}
$timber_post->categories = $timber_post->categories();
$context['post']         = $timber_post;
$context['next_post']    = get_next_post();
$context['prev_post']    = get_previous_post();
$templates               = array( 'post/single-' . $timber_post->ID . '.twig', 'post/single-' . $timber_post->post_type . '.twig', 'post/single.twig' );

Timber::render( $templates, $context );
