<?php

if( ! defined( 'ABSPATH' ) ) {
	exit();
}

/*
 * From: http://wordpress.stackexchange.com/questions/241287/implementing-namespaces-in-plugin-template
 * We don't need the convert or the str_to_lower calls from the above link.
*/

spl_autoload_register( 'purrly_link_checkAutoload' );
function purrly_link_checkAutoload( $classname ) {

	if( 0 !== strpos( $classname, 'purrly_link_check' ) ) {
		return;
	}

	$class = str_replace( '\\', DIRECTORY_SEPARATOR, $classname );

	# Create the actual file-path
	$path = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $class . '.php';

	# Check if the file exists
	if( file_exists( $path ) ) {
		# Require once on the file
		require_once $path;
	}
}