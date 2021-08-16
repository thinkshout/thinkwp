<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package thinkwp
 */

use Timber\Timber;

$templates               = array( 'archive/archive-' . $post->post_type . '.twig', 'archive/archive.twig' );
$context                 = Timber::get_context();
$context['is_archive']   = true;
$context['archive_slug'] = str_replace( ' ', '-', strtolower( $context['wp_title'] ) );
$context['title']        = 'Archive';
$context['pagination']   = Timber::get_pagination();

if ( is_day() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} elseif ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

Timber::render( $templates, $context );
