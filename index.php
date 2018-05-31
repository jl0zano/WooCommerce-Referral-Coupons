<?php
/*
* Plugin Name: WooCommerce Referral Coupons
* Plugin URI:
* Description: Generates store coupons for registered users. When an order with a referral coupon is completed, the referrer will recieve a new coupon for him.
* Author: Jaime Lozano
* Author URI: https://jaimelozano.me
* Version: 0.1

WooCommerce Referral Coupons is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
WooCommerce Referral Coupons is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action('plugins_loaded', 'wrc_check_for_woocommerce');
function wrc_check_for_woocommerce() {
    if (defined('WC_VERSION')) {
    	require_once(plugin_dir_path(__FILE__).'/includes/wrc-scripts.php');
	}
}

/* Override Woocommerce Templates ============= */


function wrc_plugin_path() {

// gets the absolute path to this plugin directory

  return untrailingslashit( plugin_dir_path( __FILE__ ) );
}
add_filter( 'woocommerce_locate_template', 'wrc_woocommerce_locate_template', 10, 3 );



function wrc_woocommerce_locate_template( $template, $template_name, $template_path ) {
  global $woocommerce;

  $_template = $template;

  if ( ! $template_path ) $template_path = $woocommerce->template_url;

  $plugin_path  = wrc_plugin_path() . '/woocommerce/';

  // Look within passed path within the theme - this is priority
  $template = locate_template(

    array(
      $template_path . $template_name,
      $template_name
    )
  );

  // Modification: Get the template from this plugin, if it exists
  if ( ! $template && file_exists( $plugin_path . $template_name ) )
    $template = $plugin_path . $template_name;

  // Use default template
  if ( ! $template )
    $template = $_template;

  // Return what we found
  return $template;
}

/* Override Woocommerce Templates ============= */

add_action('plugins_loaded', 'wcr_load_textdomain');
function wcr_load_textdomain() {
	load_plugin_textdomain( 'woocommerce-referral-coupons', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}

?>