<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/16/17 12:06 PM
 */

namespace Enpii\WpEnpiiCore\Base;


class Component extends BaseComponent {

	/**
	 * Component constructor.
	 * Initialize values for object based on configuration array
	 *
	 * @param null|array $config
	 */
	public function __construct( $config = null ) {
		if ( ! empty( $config ) ) {
			foreach ( (array) $config as $key => $value ) {
				if ( property_exists( get_class( $this ), $key ) ) {
					$this->$key = $value;
				}
			}
		}
	}
}