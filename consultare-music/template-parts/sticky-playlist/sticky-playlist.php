<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_enable = consultare_gtm( 'consultare_sticky_playlist_visibility' );

if ( ! consultare_display_section( $consultare_enable ) ) {
	return;
}

get_template_part( 'template-parts/sticky-playlist/content-playlist' );
