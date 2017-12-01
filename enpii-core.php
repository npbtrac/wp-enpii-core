<?php
/**
 * Plugin Name: Enpii Core
 * Author: npbtrac@yahoo.com
 * Date time: 12/1/17 2:07 PM
 * Date: 2/19/16
 * Time: 2:19 PM
 */
defined( '_ENPII_CORE' ) || define( '_ENPII_CORE', __FILE__ );
defined( '_NP_ENPII_URL' ) || define( '_NP_ENPII_URL', plugins_url( 'enpii-core' ) );
defined( '_NP_ENPII_PATH' ) || define( '_NP_ENPII_PATH', __DIR__ );
defined( '_NP_TEXT_DOMAIN' ) || define( '_NP_TEXT_DOMAIN', 'enpii' );
defined( '_NP_PLUGIN_VER' ) || define( '_NP_PLUGIN_VER', 0.1 );
defined( '_NP_ASSETS_URL' ) || define( '_NP_ASSETS_URL', plugins_url( 'enpii-core' ) . DIRECTORY_SEPARATOR . 'assets' );

require_once "vendor/autoload.php";

class NpCore {
	static function activate() {
		// do not generate any output

		// Require ACF pro
		$plugin = 'advanced-custom-fields-pro/acf.php';
		if ( ! is_plugin_active( $plugin ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			die( __( 'Enpii Core requires ACF pro', _NP_TEXT_DOMAIN ) );
		} else {
			Enpii\WpEnpiiCore\Wp::addRoleSiteAdmin();
		}

	}
}

register_activation_hook( __FILE__, array( 'NpCore', 'activate' ) );
