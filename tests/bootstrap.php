<?php
/**
 * Load dependencies for WP_Nonces tests
 */

if( ! file_exists( $wp_test_includes = getenv( 'WP_TEST_PATH' ) . 'includes/' ) ) {
	die( 'Please check the env variable WP_TEST_PATH from phpunit.xml.dist' );
}

// Load WordPress test utils
require $wp_test_includes . 'functions.php';

/**
 * Load WP_Nonces class
 */
function load_nonce_class() {
	require './src/class-wp-nonces.php';
}
tests_add_filter( 'muplugins_loaded', 'load_nonce_class' );

// Load WordPress and test libraries
require $wp_test_includes . 'bootstrap.php';
