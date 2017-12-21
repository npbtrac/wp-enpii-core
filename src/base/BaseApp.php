<?php
/**
 * Created by PhpStorm.
 * Author: npbtrac@yahoo.com
 * Date time: 12/21/17 1:21 PM
 */

namespace Enpii\WpEnpiiCore\Base;


class BaseApp {



	/* @var Container $container */
	public static $container;

	protected $_components = [];
	protected $_config = null;

	public function __construct( $config = null ) {


	}

	public static function setInstance( $config = null ) {
		if ( ! empty( $config ) && empty( static::$instance ) ) {
			static::$instance = new static( $config );
		}
	}
}