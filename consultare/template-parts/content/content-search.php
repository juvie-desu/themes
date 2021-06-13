<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Consultare
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clear-fix'); ?>>
	<div class="hentry-inner">
		<div class="post-thumbnail">
			<?php consultare_post_thumbnail(); ?>

			<?php consultare_posted_cats(); ?>
		</div><!-- .post-thumbnail -->
		
		<div class="entry-container">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			</header><!-- .entry-header -->
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				consultare_posted_on();
				consultare_posted_by();
				?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->

			<footer class="entry-footer entry-meta">
				<?php consultare_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div>
	</div><!-- .hentry-inner -->
</article><!-- #post-<?php the_ID(); ?> -->
