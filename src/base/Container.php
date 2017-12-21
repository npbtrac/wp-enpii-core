<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/21/17 12:06 PM
 */

namespace Enpii\WpEnpiiCore\Base;


class Container extends Component {
	/**
	 * @var array singleton objects indexed by their types
	 */
	protected $_components = [];

	protected $_config = [];

	public function __construct( $config = null ) {
		if ( ! empty( $config['components'] ) ) {
			$this->_config = $config['components'];
		}
	}

	public function getComponent( $alias ) {
		if ( empty( $this->_components[ $alias ] ) ) {
			if ( empty( $this->_config[ $alias ] ) ) {
				$component = null;
			} else {
				$component = $this->setComponent( $alias, $this->_config[ $alias ] );
			}
			return $this->_components[ $alias ] = $component;
		}

		return $this->_components[ $alias ];
	}

	public function setComponent( $alias, $componentConfig ) {
		if ( empty( $componentConfig['className'] ) ) {
			return null;
		}
		$className = $componentConfig['className'];
		unset( $componentConfig['className'] );

		return $this->_components[ $alias ] = $className::initInstance($componentConfig);

	}

}