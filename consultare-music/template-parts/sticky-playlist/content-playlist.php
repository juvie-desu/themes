<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

if ( consultare_gtm( 'consultare_sticky_playlist_page' ) ) {
	$consultare_args = array(
		'page_id'        => absint( consultare_gtm( 'consultare_sticky_playlist_page' ) ),
		'posts_per_page' => 1,
	);
}

// If $consultare_args is empty return false
if ( empty( $consultare_args ) ) {
	return;
}

$consultare_loop = new WP_Query( $consultare_args );

while ( $consultare_loop->have_posts() ) :
	$consultare_loop->the_post();
	?>
	<div id="sticky-playlist" class="sticky-playlist">	
		<?php the_content(); ?>	
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
