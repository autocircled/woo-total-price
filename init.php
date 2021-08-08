<?php
/**
 * Plugin Name: Product Total Price for WooCommerce
 * Plugin URI: https://wordpress.org/plugins/product-total-price-for-woocommerce/
 * Description: An addon for WooCommerce that will help visitors to understand the final product price when product's quantity changes.
 * Author: autocircle
 * Author URI: https://devhelp.us/
 * 
 * Version: 1.1.0
 * Requires at least:    4.0.0
 * Tested up to:         5.8
 * WC requires at least: 3.0.0
 * WC tested up to: 	 5.5.2
 * 
 * 
 * Text Domain: wc-total-price
 * Domain Path: /languages/
 *
 * @author autocircle
 * @package Product Total Price for WooCommerce
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Do not open this file directly.' );
}

if ( !function_exists('is_plugin_active') ){
    /**
    * Including Plugin file for security
    * Include_once
    * 
    * @since 1.0.0
    */
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( ! is_plugin_active('woocommerce/woocommerce.php') ) {
    return;
}

if ( ! defined( 'WCPTP_VERSION' ) ) {
    
    define( 'WCPTP_VERSION', '1.0.0');
    
}

if ( ! defined( 'WCPTP_BASE_NAME' ) ) {
    
    /**
     * @return string woo-total-price/init.php
     */
    define( 'WCPTP_BASE_NAME', plugin_basename( __FILE__ ) );
    
}

if ( ! defined( 'WCPTP_BASE_DIR' ) ) {
    
    /**
     * Returns directory base path
     * 
     * @return string directory base path
     * 
     */
    define( 'WCPTP_BASE_DIR', plugin_dir_path( __FILE__ ) );
    
}

if ( ! defined( 'WCPTP_BASE_URL' ) ) {
    
    /**
     * Returns  Directory url
     * 
     * @return string Directory url
     */    
    define( 'WCPTP_BASE_URL', plugins_url() . '/'. plugin_basename( dirname( __FILE__ ) ) . '/' );
    
}

class WCPTP {
    protected static $_instance = null;
    protected static $version = '1.2.1';
        
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function __construct() {
        add_action( 'init', function(){
            load_plugin_textdomain( 'wc-total-price', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        } );
        
        add_action( 'woocommerce_loaded', array( $this, 'wcptp_init' ) );
    }
    
    public function wcptp_init() {
        if ( ! is_admin() ) {
                add_action( 'woocommerce_single_product_summary', array( $this, 'wcptp_total_product_price_html' ), 31 );
                add_action( 'wp_enqueue_scripts', array( $this, 'load_script' ), 5 );
        }
    }
    
    public function wcptp_total_product_price_html(){
        global $product;
        
        if( $product->is_type( array( 'simple' ) ) ){
            echo self::total_price_div();
        }
    }
    
    public static function total_price_div(){
        return '<div class="wcptp-total-price"></div>';
    }


    public function load_script(){
        if ( ! is_single() ) { return; }
        
        global $post;
        $product = wc_get_product( $post->ID );
        
        if ( ! empty( $product ) ) {
            wp_register_script( 'wcptp_script', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array( 'jquery', 'wp-util', 'wc-add-to-cart-variation' ), self::$version );
            wp_enqueue_script( 'wcptp_script' );
            $wcptp_data = array(
                'precision' 			=> wc_get_price_decimals(),
				'thousand_separator' 	=> wc_get_price_thousand_separator(),
				'decimal_separator'  	=> wc_get_price_decimal_separator(),
				'currency_symbol' 		=> get_woocommerce_currency_symbol(),
				'product_type'			=> $product->get_type(),
				'price'					=> $product->get_price()
            );
            wp_localize_script( 'wcptp_script', 'wcptp_data', $wcptp_data );

            $wcptp_tempates_path = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/';
			$wcptp_price_template = apply_filters( 'wcptp_price_total_template_file', 'price-total.php', $product );
			wc_get_template( $wcptp_price_template, array(), '', $wcptp_tempates_path );
        }
    }
    
}
WCPTP::instance();