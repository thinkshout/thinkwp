<?php
/**
 * The search results template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package thinkwp
 * @subpackage  Timber
 */

use Timber\Timber;

$context                 = Timber::get_context();
$context['search_query'] = get_search_query();
$context['posts']        = Timber::get_posts();
$context['pagination']   = Timber::get_pagination();

$templates = array( 'archive/archive.twig', 'index.twig' );

Timber::render( $templates, $context );
