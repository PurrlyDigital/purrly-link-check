<?php

namespace purrly_link_check\Classes;

if( ! defined( 'ABSPATH' ) ) {
	die();
}

abstract class Base {

	public $pluginURL;
	public $pluginPath;
	public $customNonce;
	public $wpdb;
	public $customPrefix  = 'purrly_link_check';
	public $pluginDirName = 'purrly_link_check';

	public function __construct() {

		global $wpdb;

		$this->pluginPath  = realpath( dirname( __FILE__, 2 ) );
		$this->pluginURL   = plugins_url( basename( dirname( __FILE__, 2 ) ) );
		$this->customNonce = "{$this->customPrefix}Nonce";
		$this->wpdb        = $wpdb;

	}

}