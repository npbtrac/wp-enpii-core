<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/16/17 12:06 PM
 */

namespace Enpii\WpEnpiiCore\Base;


class Component {
	public static $instance;

	public function __set( $key, $value ) {
		if ( empty( $this->$key ) ) {
			$this->$key = $value;
		}
	}

	public function __get( $key ) {
		return empty( $this->$key ) ? null : $this->$key;
	}

	public static function initInstance( $config = null ) {
		if ( ! empty( $config ) && empty( static::$instance ) ) {
			static::$instance = new static();
			foreach ( (array) $config as $key => $value ) {
				if ( property_exists( get_class( static::$instance ), $key ) ) {
					static::$instance->$key = $value;
				}
			}
		}

		return static::$instance;
	}
}