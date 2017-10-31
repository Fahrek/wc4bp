<?php
/**
 * @package        WordPress
 * @subpackage     BuddyPress, Woocommerce
 * @author         GFireM
 * @copyright      2017, Themekraft
 * @link           https://github.com/Themekraft/BP-Shop-Integration
 * @license        http://www.opensource.org/licenses/gpl-2.0.php GPL License
 */

// No direct access is allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WC4BP_MyAccount_Content {

	private $end_points;

	public function __construct() {
		try {
			/**
			 * Apply filters to the endpoint shortcodes to handle woocommerce my account individual tabs
			 */
			$this->end_points = apply_filters( 'wc4bp_woocommerce_endpoint_key_content', array(
				'orders'              => array( $this, 'wc4bp_my_account_process_shortcode_orders' ),
				'downloads'           => array( $this, 'wc4bp_my_account_process_shortcode_downloads' ),
				'edit-address'        => array( $this, 'wc4bp_my_account_process_shortcode_edit_address' ),
				'payment-methods'     => array( $this, 'wc4bp_my_account_process_shortcode_payment_methods' ),
				'edit-account'        => array( $this, 'wc4bp_my_account_process_shortcode_edit_account' ),
				'add-payment-methods' => array( $this, 'wc4bp_my_account_process_shortcode_add_payment_methods' ),
			) );
			foreach ( $this->end_points as $key => $class ) {
				add_shortcode( $key, array( $this, 'process_shortcodes' ) );
			}
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}

	public function process_shortcodes( $attr, $content = '', $tag ) {
		try {
			foreach ( $this->end_points as $key => $class ) {
				if ( $tag == $key ) {
					call_user_func( $class, $attr, $content = '' );
				}
			}
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}


	public function wc4bp_my_account_process_shortcode_orders( $attr, $content ) {
		try {
			wc_print_notices();
			woocommerce_account_orders( 1 );//TODO get the current page
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}

	public function wc4bp_my_account_process_shortcode_downloads( $attr, $content ) {
		try {
			wc_print_notices();
			woocommerce_account_downloads();
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}

	public static function wc4bp_my_account_process_shortcode_edit_address( $attr, $content ) {
		try {
			wc_print_notices();
			WC_Shortcode_My_Account::edit_address();
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}

	public function wc4bp_my_account_process_shortcode_payment_methods( $attr, $content ) {
		try {
			wc_print_notices();
			if ( isset( $_GET['add-payment-method'] ) ) {//TODO need clean this var
				$suffix  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
				$path    = WC()->plugin_url() . 'assets/js/frontend/add-payment-method' . $suffix . '.js';
				$deps    = array( 'jquery', 'woocommerce' );
				$version = WC()->version;
				wp_register_script( 'wc-add-payment-method', $path, $deps, $version, true );
				wp_enqueue_script( 'wc-add-payment-method' );
				woocommerce_account_add_payment_method();
			} else {
				woocommerce_account_payment_methods();
			}
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}

	public function wc4bp_my_account_process_shortcode_add_payment_methods( $attr, $content ) {
		try {
			woocommerce_account_add_payment_method();
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}

	public function wc4bp_my_account_process_shortcode_edit_account( $attr, $content ) {
		try {
			wc_print_notices();
			WC_Shortcode_My_Account::edit_account();
		} catch ( Exception $exception ) {
			WC4BP_Loader::get_exception_handler()->save_exception( $exception->getTrace() );
		}
	}


}