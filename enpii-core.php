<?php
/**
 * Plugin Name: Enpii Core
 * Author: npbtrac@yahoo.com
 * Date time: 12/1/17 2:07 PM
 * Date: 2/19/16
 * Time: 2:19 PM
 */
defined( 'NP_PLUGIN_CORE_VER' ) || define( 'NP_PLUGIN_CORE_VER', 0.1 );

defined( 'NP_ENPII_URL' ) || define( 'NP_ENPII_URL', plugins_url( 'wp-enpii-core' ) );
defined( 'NP_ENPII_PATH' ) || define( 'NP_ENPII_PATH', __DIR__ );

defined( 'NP_TEXT_DOMAIN' ) || define( 'NP_TEXT_DOMAIN', 'enpii' );
defined( 'NP_ASSETS_URL' ) || define( 'NP_ASSETS_URL', plugins_url( 'wp-enpii-core' ) . DIRECTORY_SEPARATOR . 'assets' );

require_once "vendor/autoload.php";

class NpCore {
	static function activate() {
		// do not generate any output

		// Require ACF pro
		$plugin = 'advanced-custom-fields-pro/acf.php';
		if ( ! is_plugin_active( $plugin ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			die( __( 'Enpii Core requires ACF pro', NP_TEXT_DOMAIN ) );
		} else {
			Enpii\WpEnpiiCore\Wp::addRoleSiteAdmin();
		}

	}
}

register_activation_hook( __FILE__, array( 'NpCore', 'activate' ) );
