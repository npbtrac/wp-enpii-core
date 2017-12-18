<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/16/17 12:09 PM
 */

namespace Enpii\WpEnpiiCore\Base;


class App {

	/** @property static $instance */
	public static $instance;

	protected static $config = null;
	protected $components = [];

	/* @property WpTheme $wpTheme */

	public function __set( $name, $value ) {
		if ( empty( $this->components[ $name ] ) ) {
			$this->components[ $name ] = $value;
		}
	}

	public function __get( $key ) {
		if ( empty( static::$config[ $key ] ) ) {
			return null;
		}

		if ( empty( $this->components[ $key ] ) ) {
			$componentItem = static::$config[ $key ];

			if ( ! empty( $componentItem['className'] ) ) {
				$className = $componentItem['className'];
				unset( $componentItem['className'] );

				$this->components[ $key ] = new $className( $componentItem );
			}
		}


		return empty( $this->components[ $key ] ) ? null : $this->components[ $key ];
	}

	protected function __construct( $config = null ) {
		if ( empty( static::$config ) ) {
			static::$config = empty( $config['components'] ) ? null : $config['components'];
		}

	}

	public static function setInstance( $config = null ) {
		if ( ! empty( $config ) && empty( static::$instance ) ) {
			static::$instance = new static( $config );
		}
	}
}