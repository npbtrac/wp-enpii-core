<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/18/17 3:13 PM
 */

namespace Enpii\WpEnpiiCore\Components;

use Enpii\WpEnpiiCore\Base\Component;

class WpTheme extends Component {

	public $version;
	public $text_domain;
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
	}

	/**
	 * This method called when action `after_setup_theme` fired
	 */
	public function after_setup_theme() {
		$this->load_theme_textdomain( $this->text_domain, $this->get_lang_path() );
		$this->add_theme_support();
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
	 * This method called when 'wp_enqueue_scripts' fired
	 * For handling javascript and stylesheets
	 */
	public function wp_enqueue_scripts() {

	}
}