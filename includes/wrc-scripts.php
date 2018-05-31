<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	
add_action('wp_enqueue_scripts', 'wrc_add_scripts');
function wrc_add_scripts(){
	wp_enqueue_style('wrc-main-style', plugins_url(). '/woocommerce-referral-coupons/css/style.css');
	wp_enqueue_script('wrc-main-script', plugins_url(). '/woocommerce-referral-coupons/js/main.js');
}

add_action( 'admin_enqueue_scripts', 'wrc_add_scripts_admin' );
function wrc_add_scripts_admin($hook) {
	wp_enqueue_script('ajaxloadpost', plugins_url().'/woocommerce-referral-coupons/js/admin-ajax.js', array('jquery'));
	wp_localize_script( 'ajaxloadpost', 'ajax_postajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_style('wrc-admin-style', plugins_url(). '/woocommerce-referral-coupons/css/admin-style.css');
}

include(dirname(__FILE__).'/views/wrc-front-end.php');

include(dirname(__FILE__).'/views/wrc-back-end.php');

include(dirname(__FILE__).'/wrc-register-settings.php');

include(dirname(__FILE__).'/wrc-coupons.php');

include(dirname(__FILE__).'/wrc-options-validation.php');

include(dirname(__FILE__).'/wrc-ajax.php');

?>