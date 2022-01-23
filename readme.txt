=== Product Total Price for WooCommerce ===
Contributors: autocircle
Donate link: https://devhelp.us
Tags: subtotal, price sub total, price preview, dynamic price, price display, woocommerce, total price, final price, price times quantity
Requires at least: 4.0
Tested up to: 5.9
Stable tag: 1.1.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html	

An addon for WooCommerce that will help visitors to understand the final product price when product's quantity changes.

== Description ==

**Product Total Price for WooCommerce** is an addon for WooCommerce based site where visitors of your site can see the total price when they increase or decrease the quantity number. 

= How it works =

The plugin has build based on the concept of PnP (Plug n Play). So you don't have to worry about settings.

This plugin uses WooCommerce settings to get the pricing option, so you don't have to worry about how the price is displayed.

= Requirements =
WooCommerce 3.0 or later.

== Installation ==
1. Visit Plugins > Add New
2. Search for "Product Total Price for WooCommerce"
3. Activate "Product Total Price for WooCommerce" from your plugins page
4. That's all


== Frequently asked questions ==
= Why I don't find any settings? =
Yes! You really don't need anything for this plugin.

= WPML ready? =
Yes!

= How to change the text "Total Price" to custom? =
You can paste this code to your current theme's functions.php:

`
add_filter( 'wcptp_price_html', 'wcptp_price_html' );
function wcptp_price_html( $wcptp_price_html ) {
	return str_replace( 'Total Price', 'Order Total', $wcptp_price_html );
}
`
This is an example that will change "Total Price" to "Order Total".

= Will this work with other plugins of WooCommerce? =
Yes allmost with all plugins and themes.

== Screenshots ==

1. Screenshot 1
2. Screenshot 2

== Changelog ==

= 1.1.2 =
Release Date: -------------

= 1.1.1 =
Release Date: September 3rd, 2021

Added below features as per request of WordPress support topic https://wordpress.org/support/topic/variable-product-price-not-changing/

Enhancements:

* Variable product support

Bug Fixes:

* Total price preview loading automatically

= 1.1.0 =
* WooCommerce missing notice added
* Tested with WP version 5.8
* Tested with WC version 5.5.2
* Code cleanup done

= 1.0.0 =
* Initial release!

