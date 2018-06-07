<?php
/**
 * Created by PhpStorm.
 * User: tracnguyen
 * Date: 5/1/18
 * Time: 9:36 PM
 */

namespace Enpii\WpEnpiiCore;

class Wp {
	/**
	 * Get option from ACF option, with WPML supported
	 *
	 * @param string $name
	 * @param string $default
	 *
	 * @return mixed
	 */
	public static function get_option( $name, $default = null ) {
		if ( get_field( $name, 'option' ) ) {
			return get_field( $name, 'option' );
		} else if ( defined( 'ICL_LANGUAGE_CODE' ) && get_field( $name . '_' . ICL_LANGUAGE_CODE, 'option' ) ) {
			return get_field( $name . '_' . ICL_LANGUAGE_CODE, 'option' );
		} else {
			return $default;
		}
	}

	/**
	 * Get option value from a data given
	 *
	 * @param string $name name of the option to get
	 * @param mixed $data data given for getting option
	 * @param null $default default value
	 *
	 * @return null
	 */
	public static function get_option_data( $name, $data, $default = null ) {
		if ( ! empty( $data[ $name ] ) ) {
			return $data[ $name ];
		} else if ( defined( 'ICL_LANGUAGE_CODE' ) && ! empty( $data[ $name . '_' . ICL_LANGUAGE_CODE ] ) ) {
			return $data[ $name . '_' . ICL_LANGUAGE_CODE ];
		} else {
			return $default;
		}
	}

	/**
	 * Get content of a template block for the layout with params
	 * Template file should be in `templates` folder of child theme, parent theme or of this plugin
	 *
	 * @param string $template_slug name of the template
	 * @param array $params arguments needed to be sent to the view
	 *
	 * @return string
	 */
	public static function get_template_block( $template_slug, $params = [] ) {
		extract( $params );
		$template_default_path     = NP_ENPII_PATH . DIRECTORY_SEPARATOR . $template_slug . '.php';
		$template_theme_path       = get_template_directory() . DIRECTORY_SEPARATOR . $template_slug . '.php';
		$template_child_theme_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . $template_slug . '.php';
		ob_start();
		if ( file_exists( $template_child_theme_path ) ) {
			include $template_child_theme_path;
		} else if ( file_exists( $template_theme_path ) ) {
			include $template_theme_path;
		} else if ( file_exists( $template_default_path ) ) {
			include( $template_default_path );
		}
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
     * Register basic custom post type
	 * @param $post_type string, name of the post type to be registered with WP
	 * @param $slug string, slug of the post type
	 * @param $plural_name string, plural name of the post type
	 * @param $singular_name string, singular name of the post type
	 * @param $menu_position int, position in sidebar menu
	 */
	public static function register_post_type( $post_type, $slug, $plural_name, $singular_name, $menu_position ) {
		if ( ! empty( $post_type ) ) {
			$labels = array(
				'name'               => _x( $plural_name, 'post type general name', Base::TEXT_DOMAIN ),
				'singular_name'      => _x( $singular_name, 'post type singular name', Base::TEXT_DOMAIN ),
				'menu_name'          => _x( $plural_name, 'admin menu', Base::TEXT_DOMAIN ),
				'name_admin_bar'     => _x( $singular_name, 'add new on admin bar', Base::TEXT_DOMAIN ),
				'add_new'            => _x( sprintf( 'Add New %s', $singular_name ), Base::TEXT_DOMAIN ),
				'add_new_item'       => __( sprintf( 'Add New %s', $singular_name ), Base::TEXT_DOMAIN ),
				'new_item'           => __( sprintf( 'New %s', $singular_name ), Base::TEXT_DOMAIN ),
				'edit_item'          => __( sprintf( 'Edit %s', $singular_name ), Base::TEXT_DOMAIN ),
				'view_item'          => __( sprintf( 'View %s', $singular_name ), Base::TEXT_DOMAIN ),
				'all_items'          => __( sprintf( 'All %s', $plural_name ), Base::TEXT_DOMAIN ),
				'search_items'       => __( sprintf( 'Search %s', $plural_name ), Base::TEXT_DOMAIN ),
				'parent_item_colon'  => __( sprintf( 'Parent %s :', $singular_name ), Base::TEXT_DOMAIN ),
				'not_found'          => __( sprintf( 'No %s found', $plural_name ), Base::TEXT_DOMAIN ),
				'not_found_in_trash' => __( sprintf( 'No %s found in Trash.', $plural_name ), Base::TEXT_DOMAIN )
			);
			$args   = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_nav_menus'  => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => $slug ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => $menu_position,
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' )
			);
			register_post_type( $post_type, $args );
		}
	}

	/**
     * Register basic custom taxonomy
	 * @param $taxonomy
	 * @param $slug_taxonomy
	 * @param $post_type
	 * @param $plural_name
	 * @param $singular_name
	 */
	public static function register_taxonomy( $taxonomy, $slug_taxonomy, $post_type, $plural_name, $singular_name ) {
		if ( ! empty( $taxonomy ) ) {
			register_taxonomy( $taxonomy, $post_type, array(
				// Hierarchical taxonomy (like categories)
				'hierarchical' => true,
				// This array of options controls the labels displayed in the WordEvent Admin UI
				'labels'       => array(
					'name'              => _x( $plural_name, 'taxonomy general name', Base::TEXT_DOMAIN ),
					'singular_name'     => _x( $singular_name, 'taxonomy singular name', Base::TEXT_DOMAIN ),
					'search_items'      => __( sprintf( 'Search %s', $singular_name ), Base::TEXT_DOMAIN ),
					'all_items'         => __( sprintf( 'All %s', $plural_name ), Base::TEXT_DOMAIN ),
					'parent_item'       => __( sprintf( 'Parent %s', $singular_name ), Base::TEXT_DOMAIN ),
					'parent_item_colon' => __( sprintf( 'Parent %s :', $singular_name ), Base::TEXT_DOMAIN ),
					'edit_item'         => __( sprintf( 'Edit %s', $singular_name ), Base::TEXT_DOMAIN ),
					'update_item'       => __( sprintf( 'Update %s ', $singular_name ), Base::TEXT_DOMAIN ),
					'add_new_item'      => __( sprintf( 'Add New %s', $singular_name ), Base::TEXT_DOMAIN ),
					'new_item_name'     => __( sprintf( 'New %s', $singular_name ), Base::TEXT_DOMAIN ),
					'menu_name'         => __( $plural_name, Base::TEXT_DOMAIN ),
				),
				// Control the slugs used for this taxonomy
				'rewrite'      => array(
					'slug'         => $slug_taxonomy, // This controls the base slug that will display before each term
					'with_front'   => false, // Don't display the category base before "/locations/"
					'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
				),
			) );
		}
	}

	/**
	 * Add a custom Site Admin role, a role can control user but unable to manage plugins, themes
	 */
	public static function add_role_site_admin() {
		add_role( 'site_admin', __(
			'Site Admin', Base::TEXT_DOMAIN ),
			array(
				'activate_plugins'       => false,
				'create_users'           => true,
				'delete_others_pages'    => true,
				'delete_others_posts'    => true,
				'delete_pages'           => true,
				'delete_plugins'         => false,
				'delete_posts'           => true,
				'delete_private_pages'   => true,
				'delete_private_posts'   => true,
				'delete_published_pages' => true,
				'delete_published_posts' => true,
				'delete_themes'          => false,
				'delete_users'           => true,
				'edit_dashboard'         => true,
				'edit_others_pages'      => true,
				'edit_others_posts'      => true,
				'edit_pages'             => true,
				'edit_plugins'           => false,
				'edit_posts'             => true,
				'edit_private_pages'     => true,
				'edit_private_posts'     => true,
				'edit_published_pages'   => true,
				'edit_published_posts'   => true,
				'edit_theme_options'     => true,
				'edit_themes'            => false,
				'edit_users'             => true,
				'export'                 => true,
				'import'                 => true,
				'install_plugins'        => false,
				'install_themes'         => false,
				'list_users'             => true,
				'manage_categories'      => true,
				'manage_links'           => true,
				'manage_options'         => true,
				'moderate_comments'      => true,
				'promote_users'          => true,
				'publish_pages'          => true,
				'publish_posts'          => true,
				'read'                   => true,
				'read_private_pages'     => true,
				'read_private_posts'     => true,
				'remove_users'           => true,
				'switch_themes'          => true,
				'unfiltered_html'        => true,
				'unfiltered_upload'      => true,
				'update_core'            => false,
				'update_plugins'         => false,
				'update_themes'          => false,
				'upload_files'           => true,
				'copy_posts'             => true,
				'create_posts'           => true,
				'publish_s'              => true,
				'read_private_s'         => true,
				'wpseo_bulk_edit'        => true,
			)
		);
	}

	/**
	 * Load Font Awesome
     * @param bool $use_cdn
	 */
	public static function load_font_awesome( $use_cdn = false ) {
		wp_enqueue_style( 'font-awesome', $use_cdn ? 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' : NP_ASSETS_URL . '/font-awesome/web-fonts-with-css/css/fontawesome-all.min.css', array(), NP_PLUGIN_CORE_VER, 'all' );
	}

	/**
     * Load BxSlider assets
	 * @param bool $use_cdn
	 */
	public static function load_bxslider( $use_cdn = false ) {
		wp_enqueue_style( 'bxslider', $use_cdn ? 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css' : NP_ASSETS_URL . '/bxslider-4/dist/jquery.bxslider.min.css', array(), NP_PLUGIN_CORE_VER, 'screen' );

		wp_enqueue_script( 'bxslider', $use_cdn ? 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js' : NP_ASSETS_URL . '/bxslider-4/dist/jquery.bxslider.min.js', ['jquery'], NP_PLUGIN_CORE_VER, true );
	}

    public static function load_detectizr( $use_cdn = false ) {
        wp_enqueue_script( 'modernizr','https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js', [], NP_PLUGIN_CORE_VER, 'all' );
        wp_enqueue_script( 'detectizr','https://cdnjs.cloudflare.com/ajax/libs/detectizr/2.2.0/detectizr.min.js', ['modernizr'], NP_PLUGIN_CORE_VER, 'all' );
    }

	public static function registerMainSlider( $args = array() ) {
		$args      = array();
		$subFields = array();
		if ( empty( $args ) ) {
			$args = array(
				'image',
				'intro',
				'button_text',
				'button_link',
			);
		}
		foreach ( $args as $item ) {
			switch ( $item ) {
				case'image':
					$subFields = array(
						array(
							'key'               => 'field_573177546f3f7',
							'label'             => __( 'Image', Base::TEXT_DOMAIN ),
							'name'              => 'image',
							'type'              => 'image',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'return_format'     => 'array',
							'preview_size'      => 'medium',
							'library'           => 'all',
							'min_width'         => '',
							'min_height'        => '',
							'min_size'          => '',
							'max_width'         => '',
							'max_height'        => '',
							'max_size'          => '',
							'mime_types'        => '',
						),
					);
					break;
				case'intro':
					$subFields = array_merge( $subFields, array(
							array(
								'key'               => 'field_5731776b6f3f8',
								'label'             => __( 'Intro', Base::TEXT_DOMAIN ),
								'name'              => 'intro',
								'type'              => 'textarea',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'maxlength'         => '',
								'rows'              => '',
								'new_lines'         => 'wpautop',
								'readonly'          => 0,
								'disabled'          => 0,
							),
						)
					);
					break;
				case'button_text':
					$subFields = array_merge( $subFields, array(
							array(
								'key'               => 'field_573177766f3f9',
								'label'             => __( 'Button Text', Base::TEXT_DOMAIN ),
								'name'              => 'button_text',
								'type'              => 'text',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
								'readonly'          => 0,
								'disabled'          => 0,
							),
						)
					);
					break;
				case'button_link':
					$subFields = array_merge( $subFields, array(
						array(
							'key'               => 'field_5731777d6f3fa',
							'label'             => __( 'Button Link', Base::TEXT_DOMAIN ),
							'name'              => 'button_link',
							'type'              => 'url',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						)
					) );
					break;
			}
		}
		if ( function_exists( 'acf_add_local_field_group' ) ):
			acf_add_local_field_group( array(
				'key'                   => 'group_5731773fa67da',
				'title'                 => __( 'Options - Main Slider', Base::TEXT_DOMAIN ),
				'fields'                => array(
					array(
						'key'               => 'field_5731778b6f3fb',
						'label'             => __( 'Slider', Base::TEXT_DOMAIN ),
						'name'              => 'slider',
						'type'              => 'repeater',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'collapsed'         => '',
						'min'               => '',
						'max'               => '',
						'layout'            => 'block',
						'button_label'      => __( 'Add Slider Item' ),
						Base::TEXT_DOMAIN,
						'sub_fields'        => $subFields
					),
					array(
						'key'               => 'field_5731794cc7caa',
						'label'             => __( 'Autoplay', Base::TEXT_DOMAIN ),
						'name'              => 'autoplay',
						'type'              => 'number',
						'instructions'      => __( 'In millisecond. Default 0 (not sliding on start).', Base::TEXT_DOMAIN ),
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 0,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
						'readonly'          => 0,
						'disabled'          => 0,
					),
					array(
						'key'               => 'field_57317964c7cab',
						'label'             => __( 'Transition', Base::TEXT_DOMAIN ),
						'name'              => 'transition',
						'type'              => 'number',
						'instructions'      => __( 'Speed in millisecond when slider rotating.' ),
						Base::TEXT_DOMAIN,
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 1000,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
						'readonly'          => 0,
						'disabled'          => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'acf-options',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => '',
			) );
			acf_add_local_field_group( array(
				'key'                   => 'group_57317811158c8',
				'title'                 => __( 'Page - Main Slider', Base::TEXT_DOMAIN ),
				'fields'                => array(
					array(
						'key'               => 'field_5731782233e45',
						'label'             => __( 'Option Slider', Base::TEXT_DOMAIN ),
						'name'              => 'option_slider',
						'type'              => 'radio',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'choices'           => array(
							'no'     => __( 'No Main Slider', Base::TEXT_DOMAIN ),
							'global' => __( 'Use Global', Base::TEXT_DOMAIN ),
							'custom' => __( 'Use Custom', Base::TEXT_DOMAIN ),
						),
						'other_choice'      => 0,
						'save_other_choice' => 0,
						'default_value'     => '',
						'layout'            => 'horizontal',
					),
					array(
						'key'               => 'field_5731785b33e46',
						'label'             => 'Slider',
						'name'              => 'slider',
						'type'              => 'repeater',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_5731782233e45',
									'operator' => '==',
									'value'    => 'custom',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'collapsed'         => '',
						'min'               => '',
						'max'               => '',
						'layout'            => 'block',
						'button_label'      => __( 'Add Slider Item', Base::TEXT_DOMAIN ),
						'sub_fields'        => array(
							array(
								'key'               => 'field_5731787533e47',
								'label'             => __( 'Image', Base::TEXT_DOMAIN ),
								'name'              => 'image',
								'type'              => 'image',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'return_format'     => 'array',
								'preview_size'      => 'medium',
								'library'           => 'all',
								'min_width'         => '',
								'min_height'        => '',
								'min_size'          => '',
								'max_width'         => '',
								'max_height'        => '',
								'max_size'          => '',
								'mime_types'        => '',
							),
							array(
								'key'               => 'field_573178a833e48',
								'label'             => __( 'Intro', Base::TEXT_DOMAIN ),
								'name'              => 'intro',
								'type'              => 'textarea',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'maxlength'         => '',
								'rows'              => '',
								'new_lines'         => 'wpautop',
								'readonly'          => 0,
								'disabled'          => 0,
							),
							array(
								'key'               => 'field_573178b133e49',
								'label'             => __( 'Button Text', Base::TEXT_DOMAIN ),
								'name'              => 'button_text',
								'type'              => 'text',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
								'readonly'          => 0,
								'disabled'          => 0,
							),
							array(
								'key'               => 'field_573178bb33e4a',
								'label'             => __( 'Button Link', Base::TEXT_DOMAIN ),
								'name'              => 'button_link',
								'type'              => 'url',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
							),
						),
					),
					array(
						'key'               => 'field_573178d746af9',
						'label'             => __( 'Autoplay', Base::TEXT_DOMAIN ),
						'name'              => 'autoplay',
						'type'              => 'number',
						'instructions'      => __( 'In millisecond. Default 0 (not sliding on start).', Base::TEXT_DOMAIN ),
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_5731782233e45',
									'operator' => '==',
									'value'    => 'custom',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 0,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
						'readonly'          => 0,
						'disabled'          => 0,
					),
					array(
						'key'               => 'field_573178fb46afa',
						'label'             => __( 'Transition', Base::TEXT_DOMAIN ),
						'name'              => 'transition',
						'type'              => 'number',
						'instructions'      => __( 'Speed in millisecond when slider rotating.', Base::TEXT_DOMAIN ),
						'required'          => 0,
						'conditional_logic' => array(
							array(
								array(
									'field'    => 'field_5731782233e45',
									'operator' => '==',
									'value'    => 'custom',
								),
							),
						),
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'default_value'     => 1000,
						'placeholder'       => '',
						'prepend'           => '',
						'append'            => '',
						'min'               => '',
						'max'               => '',
						'step'              => '',
						'readonly'          => 0,
						'disabled'          => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'page',
						),
					),
				),
				'menu_order'            => 1,
				'position'              => 'acf_after_title',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => '',
			) );
		endif;
	}

	public static function displayMainSlider() {
		$mainSliderType = 1;
		$optionSlider   = get_field( 'option_slider' );
		NpWp::registerStyleMainSlider( $mainSliderType );
		NpWp::registerScriptMainSlider( $mainSliderType );
		if ( $optionSlider == 'global' ) {
			$data       = get_field( 'slider', 'option' );
			$autoPlay   = get_field( 'autoplay', 'option' );
			$transition = get_field( 'transition', 'option' );
			$args       = array(
				'data'       => $data,
				'autoPlay'   => $autoPlay,
				'transition' => $transition,
			);
			NpWp::getBlock( 'common/_main-slider', $args );
		}
		if ( $optionSlider == 'custom' ) {
			$data       = get_field( 'slider' );
			$autoPlay   = get_field( 'autoplay' );
			$transition = get_field( 'transition' );
			$args       = array(
				'data'       => $data,
				'autoPlay'   => $autoPlay,
				'transition' => $transition,
			);
			NpWp::getBlock( 'common/_main-slider', $args );
		}
	}

	/**
	 * @param int $type : if $type = 1 using bx slider
	 */
	protected function registerStyleMainSlider( $type = 1 ) {
		if ( $type == 1 ) {
			$styleDefaultUrl = NP_ENPII_URL . '/assets/common/main-slider.css';
			$styleThemePath  = get_template_directory() . DIRECTORY_SEPARATOR . 'assets/common/main-slider.css';
			$styleThemeUrl   = get_template_directory_uri() . DIRECTORY_SEPARATOR . 'assets/common/main-slider.css';
			if ( file_exists( $styleThemePath ) ) {
				wp_enqueue_style( 'main-slider-css', $styleThemeUrl, array(), NP_THEME_VERSION );
			} else {
				wp_enqueue_style( 'main-slider-default-css', $styleDefaultUrl, array(), NP_PLUGIN_CORE_VER );
			}
		}
	}

	protected function registerScriptMainSlider( $type ) {
		if ( $type == 1 ) {
			$scriptDefaultUrl = NP_ENPII_URL . '/assets/common/main-slider.js';
			$scriptThemePath  = get_template_directory() . DIRECTORY_SEPARATOR . 'assets/common/main-slider.js';
			$scriptThemeUrl   = get_template_directory_uri() . DIRECTORY_SEPARATOR . 'assets/common/main-slider.js';
			if ( file_exists( $scriptThemePath ) ) {
				wp_enqueue_script( 'main-slider-js', $scriptThemeUrl, array(), NP_THEME_VERSION, true );
			} else {
				wp_enqueue_script( 'main-slider-default-js', $scriptDefaultUrl, array(), NP_PLUGIN_CORE_VER, true );
			}
		}
	}

	/*
	 * Function for get year month link of post type
	 */
	public static function getArchives( $postType = 'post', $format = 'month', $timeFormat = 'Y-m-d H:i:s', $type = 'link' ) {
		global $wpdb;
		$year_query  = get_query_var( 'year' );
		$mont_query  = get_query_var( 'monthnum' );
		$query       = "
            SELECT YEAR(post_date) AS `year`, count(ID) as posts , MONTH(post_date) as `month`
            FROM $wpdb->posts
            WHERE post_type = '$postType' AND post_status = 'publish' 
            GROUP BY `year`, `month` 
            ORDER BY `year` DESC, `month` ASC
         ";
		$results     = $wpdb->get_results( $query );
		$arrayResult = array();
		if ( ! empty( $results ) ) {
			foreach ( $results as $item ) {
				$arrayResult[ $item->year ][ $item->month ] = $item->posts;
			}
		}
		if ( $type == 'select' && ! empty( $arrayResult ) ) : ?>
            <select class="archive-link-list archive-link-<?php echo $postType ?>">
				<?php foreach ( $arrayResult as $year => $months ): ?>

                    <optgroup label="<?php echo $year ?>">
						<?php foreach ( array_reverse( $months, true ) as $month => $count ):
							$datetime = new DateTime( $year . '-' . $month . '-1' );
							?>
                            <option
                                    value="<?php echo get_month_link( $year, $month ); ?>" <?php echo ( $year == $year_query && $month == $mont_query ) ? 'selected' : '' ?>><?php echo $datetime->format( $timeFormat ) ?></option>
						<?php endforeach; ?>
                    </optgroup>
				<?php endforeach; ?>
            </select>
		<?php endif;
	}

	public static function getLatestYear( $postType = 'post' ) {
		global $wpdb;
		$query   = "
        SELECT YEAR(post_date) AS `year`, count(ID) as posts 
        FROM $wpdb->posts
        WHERE post_type = '$postType' AND post_status = 'publish' 
        GROUP BY YEAR(post_date) 
        ORDER BY post_date DESC 
     ";
		$results = $wpdb->get_results( $query );

		return $results[0]->year;
	}

	public static function getTheExcerpt( $postID ) {
		global $post;
		$save_post = $post;
		$post      = get_post( $postID );
		$output    = get_the_excerpt();
		$post      = $save_post;

		return $output;
	}

	public static function getVideoID( $videoUrl ) {
		$youtubeUrl = $videoUrl;
		parse_str( parse_url( $youtubeUrl, PHP_URL_QUERY ), $arrayResult );

		return $arrayResult['v'];
	}
}