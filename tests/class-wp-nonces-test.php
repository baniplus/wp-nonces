<?php

class WP_Nonces_Test extends WP_UnitTestCase {
	private static $wp_nonce;
	private static $custom_action = '__custom_action';
	private static $nonce_name = '__custom_action';

	public static function setUpBeforeClass() {
		self::$wp_nonce = new WP_Nonces( array(
			'action' => self::$custom_action,
			'nonce_name' => self::$nonce_name
		) );
	}

	public function test_wp_nonce_get_field() {
		$field = self::$wp_nonce->get_field();

		$this->assertNotEmpty( $field );

		$dom = new DOMDocument();
		$this->assertTrue( $dom->loadHTML( $field ) );
		$nonce = $dom
					->getElementById( self::$nonce_name )
					->getAttribute( 'value' );

		$this->assertNotFalse( self::$wp_nonce->verify( $nonce ) );
	}

	public function test_wp_nonce_field() {
		$field = self::$wp_nonce->get_field();

		$this->expectOutputString( $field );
		self::$wp_nonce->field();
	}

	public function test_wp_nonce_url() {
		$url_nonce = self::$wp_nonce->url( 'https://example.com' );
		$nonce = self::$wp_nonce->create();

		$this->assertContains( self::$nonce_name . '=' . $nonce, $url_nonce );
	}

	public function test_wp_nonce_create() {
		$nonce = self::$wp_nonce->create();
		$nonce_alt = self::$wp_nonce->create( '__alt_action' );

		$this->assertNotEquals( $nonce, $nonce_alt );
		$this->assertNotFalse( self::$wp_nonce->verify( $nonce ) );
	}

	public function test_wp_nonce_check_admin_referer() {
		$nonce = self::$wp_nonce->create();

		$_REQUEST[ self::$nonce_name ] = $nonce;
		$this->assertNotFalse( self::$wp_nonce->check_admin_referer() );
	}

	public function test_wp_nonce_check_ajax_referer() {
		$nonce = self::$wp_nonce->create();

		$_REQUEST[ self::$nonce_name ] = $nonce;
		$this->assertNotFalse( self::$wp_nonce->check_ajax_referer() );
	}

	public function test_wp_nonce_get_referer_field() {
		$field = self::$wp_nonce->get_field();
		$field_referer = self::$wp_nonce->get_referer_field();

		$this->assertNotEmpty( $field_referer );
		$this->assertContains( $field_referer, $field );
	}

	public function test_wp_nonce_referer_field() {
		$field = self::$wp_nonce->get_referer_field();

		$this->expectOutputString( $field );
		self::$wp_nonce->referer_field();
	}
}