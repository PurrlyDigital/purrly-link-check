<?php

/*
Plugin Name: Purrly Digital Link Check
Plugin URI: https://www.purrlydigital.com/plugins/link-check
Description: Make sure that all the sites you link out to are valid on a regular basis.
Version: 0.1
Author: Maje Media LLC
Author URI: https://www.purrlydigital.com/plugins/link-check
Copyright: 2022
Text Domain: purrly-link-check
Domain Path: /lang
*/

namespace purrly_link_check;

use purrly_link_check\Classes\Base;

if( ! defined( 'ABSPATH' ) ) {
	die();
}

require_once( 'autoloader.php' );

class purrly_link_check extends Base {

	private static $instance;

	public static function get_instance() {

		if( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {

		parent::__construct();

	}

	public function Activate() {

	}

	public function Deactivate() {

	}

}

$purrly_link_check = \purrly_link_check\purrly_link_check::get_instance();

register_activation_hook( __FILE__, [ $purrly_link_check, 'Activate' ] );
register_deactivation_hook( __FILE__, [ $purrly_link_check, 'Deactivate' ] );