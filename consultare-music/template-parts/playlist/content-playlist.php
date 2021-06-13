<?php
/**
 * Template part for displaying Hero Content
 *
 * @package Consultare
 */

$consultare_playlist_type = consultare_gtm( 'consultare_playlist_type' );

if ( consultare_gtm( 'consultare_playlist_page' ) ) {
	$consultare_args = array(
		'page_id'        => absint( consultare_gtm( 'consultare_playlist_page' ) ),
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

	$subtitle      = consultare_gtm( 'consultare_playlist_custom_subtitle' );
	?>

	<div id="playlist-section" class="playlist-section dark-background section content-position-right default">
		<div class="section-featured-page">
			<div class="container">
				<div class="row">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="ff-grid-6 featured-page-thumb">
						<?php the_post_thumbnail( 'consultare-hero', array( 'class' => 'alignnone' ) );?>
					</div>
					<?php endif; ?>

					<!-- .ff-grid-6 -->
					<div class="ff-grid-6 featured-page-content">
						<div class="featured-page-section">
							<div class="section-title-wrap text-alignleft">
								<?php if ( $subtitle ) : ?>
								<p class="section-top-subtitle"><?php echo esc_html( $subtitle ); ?></p>
								<?php endif; ?>

								<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

							</div>

							<div class="featured-info">
								<?php the_content(); ?>
							</div><!-- .featured-info -->
						</div><!-- .featured-page-section -->
					</div><!-- .ff-grid-6 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section-featured-page -->
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
