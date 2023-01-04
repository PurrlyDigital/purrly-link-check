<?php

namespace purrly_link_check\Classes;

if( ! defined( 'ABSPATH' ) ) {
	die();
}

class Base {

	public string $pluginURL;
	public string $pluginPath;
	public string $customNonce;
	public \wpdb  $wpdb;
	public string $customPrefix = 'purrly_link_check';
	public string $settingsName;

	public function __construct() {

		global $wpdb;

		$this->pluginPath   = realpath( dirname( __FILE__, 2 ) );
		$this->pluginURL    = plugins_url( basename( dirname( __FILE__, 2 ) ) );
		$this->customNonce  = "{$this->customPrefix}Nonce";
		$this->wpdb         = $wpdb;
		$this->settingsName = "{$this->customPrefix}_settings";
	}

}