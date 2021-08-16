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
$context['pagination']   = Timber::get_pagination();

Timber::render( $templates, $context );
