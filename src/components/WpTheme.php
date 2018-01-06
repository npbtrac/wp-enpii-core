<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/18/17 3:13 PM
 */

namespace Enpii\WpEnpiiCore\Components;

use Enpii\WpEnpiiCore\Base\Component;

class WpTheme extends Component {

	/* @var string represent current version of theme */
	public $version;

	/* @var string for theme translation */
	public $text_domain;

	/* @var bool choose to load popular assets from CDN or not */
	public $use_cdn = false;

	public $base_path;
	public $base_url;
	public $child_base_path;
	public $child_base_url;

	/**
	 * Get language path of the theme
	 * @return string
	 */
	public function get_lang_path() {
		return $this->base_path . DS . 'languages';
	}

	/**
	 * Initialize the theme hooks and basic configurations.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', [ $this, 'after_setup_theme' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
	}

	/**
	 * This method called when action `after_setup_theme` fired
	 */
	public function after_setup_theme() {
		$this->load_theme_textdomain( $this->text_domain, $this->get_lang_path() );
		$this->add_theme_support();
		$this->register_nav_menus();
	}

	/**
	 * Make theme available for translation.
	 * Handle loading the translation with text domain
	 *
	 * @param null|string $text_domain
	 * @param bool|string $path
	 */
	public function load_theme_textdomain( $text_domain = null, $path = false ) {
		load_theme_textdomain( $text_domain, $path );
	}

	/**
	 * Add features from WordPress to support the theme
	 */
	public function add_theme_support() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
	    */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
			'gallery',
			'audio',
		) );

		// Add theme support for Custom Logo.
		add_theme_support( 'custom-logo', array(
			'width'      => 250,
			'height'     => 250,
			'flex-width' => true,
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		$starter_content = [];
		$starter_content = apply_filters( 'enpii_starter_content', $starter_content );
		add_theme_support( 'starter-content', $starter_content );
	}

	/**
	 * Register navigation menus for theme
	 */
	public function register_nav_menus() {
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary-menu'   => __( 'Primary Menu', $this->text_domain ),
			'secondary-menu' => __( 'Secondary Menu', $this->text_domain ),
		) );
	}

	/**
	 * This method called when 'wp_enqueue_scripts' fired
	 * For handling javascript and stylesheets
	 */
	public function wp_enqueue_scripts() {

	}

	/**
	 * This method called when 'widgets_init' fired
	 */
	public function widgets_init() {

	}

	/**
	 * Add inline scripts to the output
	 *
	 * @param $handle
	 * @param $data
	 * @param string $position
	 */
	public function add_inline_script( $handle, $data, $position = 'after' ) {
		wp_add_inline_script( $handle, $data, $position );
	}

	/**
	 * Get a template inside a theme with parameters
	 *
	 * @param $slug
	 * @param array $args
	 */
	public function get_template_part( $slug, $args = [] ) {
		/* @var \WP_Query $wp_query */
		global $wp_query;

		// Put local arguments to query_vars then revert it back to original
		$old_query_vars = $wp_query->query_vars;
		$wp_query->query_vars = (array) $wp_query->query_vars;
		foreach ($args as $key => $val) {
			if (!is_integer($key)) {
				$wp_query->query_vars[$key] = $val;
			}
		}

		ob_start();
		get_template_part( $slug );
		$result = ob_get_contents();
		ob_end_clean();

		$wp_query->query_vars = $old_query_vars;

		return $result;

	}
}