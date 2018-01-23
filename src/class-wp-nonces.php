<?php

/**
 * Nonces API: WP_Nonces class
 * 
 * Use WordPress Nonces in an object orientated environment
 * @author Vitalie Glodeanu <vglodeanu@gmail.com>
 */
class WP_Nonces {
	/**
	 * Default nonces settings
	 *
	 * @var array
	 */
	private static $settings;

	/**
	 * @param array $settings
	 */
	public function __construct( $settings = array() ) {
		self::$settings = wp_parse_args( $settings, array(
			'action' => -1,
			'nonce_name' => '_wpnonce'
		) );
	}

	/**
	 * Get default settings
	 *
	 * @param string $name    The setting name
	 * @param string $default Falback value
	 * @return mixed A value of default settings
	 */
	private static function get_setting( $name, $default = '' ) {
		return isset( self::$settings[ $name ] ) ? self::$settings[$name] : $default;
	}

	/**
	 * Display a message to confirm the action being taken.
	 *
	 * @uses wp_nonce_ays
	 * @param string $action Optional. The nonce action.
	 */
	public function message( $action = '' ) {
		wp_nonce_ays( $action );
	}

	/**
	 * Retrieve nonce hidden field for forms.
	 *
	 * @uses wp_nonce_field
	 * @param int|string $action  Optional. Action name. Default null.
	 * @param string     $name    Optional. Nonce name. Default null.
	 * @param bool       $referer Optional. Whether to set the referer 
	 *                            field for validation. Default true.
	 * @return string Nonce field HTML markup.
	 */
	public function get_field( $action = null, $name = null, $referer = true ) {
		$action = $action ?: self::get_setting( 'action' );
		$name = $name ?: self::get_setting( 'nonce_name' );

		return wp_nonce_field( $action, $name, $referer, false );
	}

	/**
	 * Display nonce hidden field for forms.
	 *
	 * @param int|string $action  Optional. Action name. Default null.
	 * @param string     $name    Optional. Nonce name. Default null.
	 * @param bool       $referer Optional. Whether to set the referer
	 *                            field for validation. Default true.
	 * @return void
	 */
	public function field( $action = null, $name = null, $referer = true ) {
		echo $this->get_field( $action, $name, $referer );
	}

	/**
	 * Retrieve URL with nonce added to URL query.
	 *
	 * @uses wp_nonce_url
	 * @param string     $actionurl URL to add nonce action.
	 * @param int|string $action    Optional. Nonce action name. Default null.
	 * @param string     $name      Optional. Nonce name. Default null.
	 * @return string Escaped URL with nonce action added.
	 */
	public function url( $actionurl, $action = null, $name = null ) {
		$action = $action ?: self::get_setting( 'action' );
		$name = $name ?: self::get_setting( 'nonce_name' );

		return wp_nonce_url( $actionurl, $action, $name );
	}

	/**
	 * Verify that correct nonce was used with time limit.
	 *
	 * @uses wp_verify_nonce
	 * @param string     $nonce  Nonce that was used in the form to verify
	 * @param string|int $action Should give context to what is taking place
	 *                           and be the same when nonce was created. Default null.
	 * @return false|int False if the nonce is invalid, 1 if the nonce is valid
	 *                   and generated between 0-12 hours ago, 2 if the nonce is valid
	 *                   and generated between 12-24 hours ago.
	 */
	public function verify( $nonce, $action = null ) {
		$action = $action ?: self::get_setting( 'action' );

		return wp_verify_nonce( $nonce, $action );
	}

	/**
	 * Creates a cryptographic token tied to a specific action, user,
	 * user session, and window of time.
	 *
	 * @uses wp_create_nonce
	 * @param string|int $action Scalar value to add context to the nonce. Default null.
	 * @return string The token.
	 */
	public function create( $action = null ) {
		$action = $action ?: self::get_setting( 'action' );

		return wp_create_nonce( $action );
	}

	/**
	 * Makes sure that a user was referred from another admin page.
	 *
	 * @uses check_admin_referer
	 * @param int|string $action    Action nonce. Default null.
	 * @param string     $query_arg Optional. Key to check for nonce in `$_REQUEST`.
	 *                   Default null.
	 * @return false|int False if the nonce is invalid, 1 if the nonce is valid
	 *                   and generated between 0-12 hours ago, 2 if the nonce is valid 
	 *                   and generated between 12-24 hours ago.
	 */
	public function check_admin_referer( $action = null, $query_arg = null ) {
		$action = $action ?: self::get_setting( 'action' );
		$query_arg = $query_arg ?: self::get_setting( 'nonce_name' );

		return check_admin_referer( $action, $query_arg );
	}

	/**
	 * Verifies the Ajax request to prevent processing requests external of the blog.
	 *
	 * @uses check_ajax_referer
	 * @param int|string   $action    Action nonce. Default null.
	 * @param false|string $query_arg Optional. Key to check for the nonce in `$_REQUEST`.
	 *                                If false,`$_REQUEST` values will be evaluated for '_ajax_nonce',
	 *                                and '_wpnonce' (in that order). Default null.
	 * @param bool         $die       Optional. Whether to die early when the nonce cannot be verified.
	 *                                Default true.
	 * @return false|int False if the nonce is invalid, 1 if the nonce is valid
	 *                   and generated between 0-12 hours ago, 2 if the nonce is valid
	 *                   and generated between 12-24 hours ago.
	 */
	public function check_ajax_referer( $action = null, $query_arg = null, $die = true ) {
		$action = $action ?: self::get_setting( 'action' );
		$query_arg = $query_arg ?: self::get_setting( 'nonce_name' );

		return check_ajax_referer( $action, $query_arg, $die );
	}

	/**
	 * Retrieve referer hidden field for forms.
	 *
	 * @uses wp_referer_field
	 * @return string Referer field HTML markup.
	 */
	public function get_referer_field() {
		return wp_referer_field( false );
	}

	/**
	 * Display referer hidden field for forms.
	 *
	 * @return void
	 */
	public function referer_field() {
		echo $this->get_referer_field();
	}
}
