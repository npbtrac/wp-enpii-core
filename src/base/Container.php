<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/21/17 12:06 PM
 */

namespace Enpii\WpEnpiiCore\Base;


class Container extends BaseComponent {
	/**
	 * @var array of components used in applications
	 */
	protected $_components = [];

	protected $_config = [];

	/**
	 * Container constructor.
	 * Initialize components' configuration from external values
	 *
	 * @param null $config
	 */
	public function __construct( $config = null ) {
		if ( ! empty( $config['components'] ) ) {
			$this->_config = $config['components'];
		}
	}

	/**
	 * Get a component for using
	 * Only initialize component is used (lazy loading)
	 *
	 * @param $alias
	 *
	 * @return mixed|null
	 */
	public function get_component( $alias ) {
		if ( empty( $this->_components[ $alias ] ) ) {
			if ( empty( $this->_config[ $alias ] ) ) {
				$component = null;
			} else {
				$component = $this->set_component( $alias, $this->_config[ $alias ] );
			}

			return $this->_components[ $alias ] = $component;
		}

		return $this->_components[ $alias ];
	}

	/**
	 * Initialize a component using it's configuration
	 *
	 * @param $alias
	 * @param $component_config
	 *
	 * @return null
	 */
	public function set_component( $alias, $component_config ) {
		if ( empty( $component_config['class'] ) ) {
			return null;
		}
		$class_name = $component_config['class'];
		unset( $component_config['class'] );

		return $this->_components[ $alias ] = new $class_name( $component_config );
	}

}