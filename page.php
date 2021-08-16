<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package thinkwp
 */

use Timber\Timber;

$context     = Timber::get_context();
$timber_post = new TimberPost();
if ( isset( $post->hero_hero_image ) && strlen( $post->hero_hero_image ) ) {
	$timber_post->hero_image = new \Timber\Image( $post->hero_hero_image );
} else {
	$timber_post->hero_image = $timber_post->thumbnail;
}
if ( isset( $timber_post->flexible_content ) && is_array( $timber_post->flexible_content ) && count( $timber_post->flexible_content ) ) {
	$timber_post->flexible_blocks = $timber_post->flexible_content;
}
$context['post']       = $timber_post;
$context['pagination'] = Timber::get_pagination();
$templates             = array( 'page/page-' . $timber_post->slug . '.twig', $timber_post->slug . '.twig', 'templates/page.twig' );
Timber::render( $templates, $context, false );
