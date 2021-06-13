<?php
/**
 * Playlist Options
 *
 * @package Consultare
 */

class Consultare_Sticky_Playlist_Options {
	public function __construct() {
		// Register Playlist Options.
		add_action( 'customize_register', array( $this, 'register_options' ), 99 );

		// Add default options.
		add_filter( 'consultare_customizer_defaults', array( $this, 'add_defaults' ) );
	}

	/**
	 * Add options to defaults
	 */
	public function add_defaults( $default_options ) {
		$defaults = array(
			'consultare_sticky_playlist_visibility' => 'disabled',
		);

		$updated_defaults = wp_parse_args( $defaults, $default_options );

		return $updated_defaults;
	}

	/**
	 * Add layouts section and its controls
	 */
	public function register_options( $wp_customize ) {
		// Add section.
		$wp_customize->add_section( 'consultare_sticky_playlist',
			array(
				'title' => esc_html__( 'Sticky Playlist', 'consultare-music' ),
				'panel' => 'consultare_theme_options'
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'settings'          => 'consultare_sticky_playlist_visibility',
				'type'              => 'select',
				'sanitize_callback' => 'consultare_sanitize_select',
				'label'             => esc_html__( 'Visible On', 'consultare-music' ),
				'section'           => 'consultare_sticky_playlist',
				'choices'           => Consultare_Customizer_Utilities::section_visibility(),
			)
		);

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Simple_Notice_Custom_Control',
				'sanitize_callback' => 'sanitize_text_field',
				'settings'          => 'consultare_sticky_playlist_add_info',
				'label'             =>  esc_html__( 'Info', 'consultare-music' ),
				'description'       =>  sprintf( esc_html__( 'If you dont know how to add playlist in page/post, check %1$sthis%2$s', 'consultare-music' ), '<a href="https://www.beginwp.com/how-to-add-audio-video-playlist-wordpress/" target="_blank">', '</a>' ),
				'section'           => 'consultare_sticky_playlist',
				'active_callback'   => array( $this, 'is_playlist_visible' ),
			)
		);

		// Add Edit Shortcut Icon.
		$wp_customize->selective_refresh->add_partial( 'consultare_sticky_playlist_visibility', array(
			'selector' => '#sticky-playlist',
		) );

		Consultare_Customizer_Utilities::register_option(
			array(
				'custom_control'    => 'Consultare_Dropdown_Posts_Custom_Control',
				'sanitize_callback' => 'absint',
				'settings'          => 'consultare_sticky_playlist_page',
				'label'             => esc_html__( 'Select Page', 'consultare-music' ),
				'section'           => 'consultare_sticky_playlist',
				'active_callback'   => array( $this, 'is_playlist_visible' ),
				'input_attrs' => array(
					'post_type'      => 'page',
					'posts_per_page' => -1,
					'orderby'        => 'name',
					'order'          => 'ASC',
				),
			)
		);
	}

	/**
	 * Playlist visibility active callback.
	 */
	public function is_playlist_visible( $control ) {
		return ( consultare_display_section( $control->manager->get_setting( 'consultare_sticky_playlist_visibility' )->value() ) );
	}
}

/**
 * Initialize class
 */
$consultare_sticky_playlist = new Consultare_Sticky_Playlist_Options();
