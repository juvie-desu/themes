<?php
/**
 * Child Theme functions and definitions.
 * This theme is a child theme for Consultare.
 *
 * @package Consultare_Music
 * @author  FireflyThemes https://fireflythemes.com
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU Public License
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 */

/**
 * Theme functions and definitions.
 */
function consultare_music_enqueue_styles() {
	// Parent Theme stylesheet.
	wp_enqueue_style( 'consultare-style', get_template_directory_uri() . '/style.css', null, consultare_music_get_file_mod_date( get_template_directory() . '/style.css' ) );

	wp_enqueue_style( 'consultare-music-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'consultare-style' ),
        consultare_music_get_file_mod_date( get_stylesheet_directory() . '/style.css' )
    );
}
add_action(  'wp_enqueue_scripts', 'consultare_music_enqueue_styles' );

/**
 * Get file modified date
 */
function consultare_music_get_file_mod_date( $file ) {
	return date( 'Ymd-Gis', filemtime( $file ) );
}

/**
 * Loads the child theme textdomain.
 */
function consultare_music_setup() {
    load_child_theme_textdomain( 'consultare-music', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'consultare_music_setup', 11 );

/**
 * Override parent function to load Oswald Google font
 */
function consultare_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Heebo, translate this to 'off'. Do not translate
    * into your own language.
    */
    $roboto_slab = _x( 'on', 'Roboto Slab font: on or off', 'consultare-music' );
    $poppins = _x( 'on', 'Poppins font: on or off', 'consultare-music' );
    $oswald = _x( 'on', 'Oswald font: on or off', 'consultare-music' );

    if ( 'off' !== $roboto_slab && 'off' !== $poppins && 'off' !== $oswald ) {
        $font_families = array();

        if ( 'off' !== $roboto_slab ) {
            $font_families[] = 'Roboto Slab:300,400,500,600,700,800,900';
        }

        if ( 'off' !== $poppins ) {
            $font_families[] = 'Poppins:300,400,500,600,700,800,900';
        }

        if ( 'off' !== $oswald ) {
            $font_families[] = 'Oswald:300,400,500,600,700,800,900';
        }


        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}

/**
 * Edit Media playlist elements to match our theme's elements for sticky playlist
 */
function consultare_music_mejs_add_container_class() {
    if ( ! wp_script_is( 'mediaelement', 'done' ) ) {
        return;
    }
    ?>
    <script>
    (function() {
        var settings = window._wpmejsSettings || {};

        settings.features = settings.features || mejs.MepDefaults.features;

        settings.features.push( 'consultare_class' );

        MediaElementPlayer.prototype.buildconsultare_class = function(player, controls, layers, media) {
            if ( ! player.isVideo ) {
                var container = player.container[0] || player.container;

                container.style.height = '';
                container.style.width = '';
                player.options.setDimensions = false;
            }

            if ( jQuery( '#' + player.id ).parents('#sticky-playlist').length ) {
                player.container.addClass( 'consultare-mejs-container consultare-mejs-sticky-playlist-container' );

                jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').addClass('displaynone');

                var volume_slider = controls[0].children[5];

                if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {
                    var playlist_button =
                    jQuery('<div class="mejs-button mejs-playlist-button mejs-toggle-playlist">' +
                        '<button type="button" aria-controls="mep_0" title="Toggle Playlist"></button>' +
                    '</div>')

                    // append it to the toolbar
                    .appendTo( jQuery( '#' + player.id ) )

                    // add a click toggle event
                    .on( 'click',function() {
                        jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').slideToggle();
                        jQuery( this ).toggleClass('is-open')
                    });

                    var play_button = controls[0].children[0];

                    // Add next button after volume slider
                    var next_button =
                    jQuery('<div class="mejs-button mejs-next-button mejs-next">' +
                        '<button type="button" aria-controls="' + player.id
                        + '" title="Next Track"></button>' +
                    '</div>')

                    // insert after volume slider
                    .insertAfter(play_button)

                    // add a click toggle event
                    .on( 'click',function() {
                        jQuery( '#' + player.id ).parent().find( '.wp-playlist-next').trigger('click');
                    });

                    // Add prev button after volume slider
                    var previous_button =
                    jQuery('<div class="mejs-button mejs-previous-button mejs-previous">' +
                        '<button type="button" aria-controls="' + player.id
                        + '" title="Previous Track"></button>' +
                    '</div>')

                    // insert after volume slider
                    .insertBefore( play_button )

                    // add a click toggle event
                    .on( 'click',function() {
                        jQuery( '#' + player.id ).parent().find( '.wp-playlist-prev').trigger('click');
                    });
                }
            }
        }
    })();
    </script>
    <?php
}
add_action( 'wp_print_footer_scripts', 'consultare_music_mejs_add_container_class' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function consultare_music_body_classes( $classes ) {
    // Add header Style Class.
    $classes['header-class'] = 'header-two';

    return $classes;
}
add_filter( 'body_class', 'consultare_music_body_classes', 99 );

/**
 * Customizer additions.
 */
require get_theme_file_path( '/inc/customizer/playlist.php' );

/**
 * Customizer additions.
 */
require get_theme_file_path( '/inc/customizer/sticky-playlist.php' );
