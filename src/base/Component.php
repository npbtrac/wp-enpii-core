<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/16/17 12:06 PM
 */

namespace Enpii\WpEnpiiCore\Base;


abstract class Component {
	public function __set( $key, $value ) {
		if ( empty( $this->$key ) ) {
			$this->$key = $value;
		}
	}

	public function __get( $key ) {
		return empty( $this->$key ) ? null : $this->$key;
	}

	public function __construct( $config = null ) {
		foreach ( (array) $config as $key => $value ) {
			if ( property_exists( get_class( $this ), $key ) ) {
				$this->$key = $value;
			}
		}
	}
}