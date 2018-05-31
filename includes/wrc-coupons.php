<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'user_register', 'wrc_create_referral_coupon', 10, 1 );
function wrc_create_referral_coupon( $user_id ) {

	$coupon_prefix = get_option('referral_prefix');

	$coupon_options = array(
		'coupon_code'  => $coupon_prefix . $user_id . wrc_generate_random_string(),
		'discount_type' => get_option('referral_discount_type'),
		'coupon_amount' => get_option('referral_coupon_amount'),
		'individual_use' => get_option('referral_individual_use'),
		'product_ids' => get_option('referral_product_ids'),
		'exclude_product_ids' => get_option('referral_exclude_product_ids'),
		'usage_limit' => get_option('referral_usage_limit'),
		'expiry_date' => get_option('referral_expiry_date'),
		'apply_before_tax' => get_option('referral_apply_before_tax'),
		'free_shipping' => false,
		'usage_limit_per_user' => get_option('referral_usage_limit_per_user'),
		'minimum_amount' => get_option('referral_minimum_amount'),
		'maximum_amount' => get_option('referral_maximum_amount'),
		'user_id' => $user_id,
		'coupon_type' => 'referral',
		'order_id' => null
	);

	if(!wrc_create_coupon($coupon_options)){
		error_log("Couldn't create referral coupon.", 0);
		return false;
	}else{
		return true;
	}

}

function wrc_create_coupon( $coupon_options ){
					
	$coupon = array(
		'post_title' => $coupon_options['coupon_code'],
		'post_content' => '',
		'post_status' => 'publish',
		'post_author' => 1,
		'post_type'     => 'shop_coupon'
	);
						
	$new_coupon_id = wp_insert_post( $coupon );
						
	if($new_coupon_id){

		if($coupon_options['expiry_date'] !== ''){
			$expiry_date = new WC_DateTime();
			$expiry_date->modify('+'.$coupon_options['expiry_date'].' day');
		}else{
			$expiry_date = null;
		}

		update_post_meta( $new_coupon_id, 'discount_type', $coupon_options['discount_type'] );
		update_post_meta( $new_coupon_id, 'coupon_amount', $coupon_options['coupon_amount'] );
		update_post_meta( $new_coupon_id, 'individual_use', $coupon_options['individual_use'] );
		update_post_meta( $new_coupon_id, 'product_ids', $coupon_options['product_ids'] );
		update_post_meta( $new_coupon_id, 'exclude_product_ids', $coupon_options['exclude_product_ids']);
		update_post_meta( $new_coupon_id, 'usage_limit', $coupon_options['usage_limit'] );
		update_post_meta( $new_coupon_id, 'expiry_date', $expiry_date );
		update_post_meta( $new_coupon_id, 'apply_before_tax', $coupon_options['apply_before_tax'] );
		update_post_meta( $new_coupon_id, 'free_shipping', $coupon_options['free_shipping'] );
		update_post_meta( $new_coupon_id, 'usage_limit_per_user', $coupon_options['usage_limit_per_user'] );
		update_post_meta( $new_coupon_id, 'minimum_amount', $coupon_options['minimum_amount'] );
		update_post_meta( $new_coupon_id, 'maximum_amount', $coupon_options['maximum_amount'] );
		add_post_meta( $new_coupon_id, 'user_id', $coupon_options['user_id'] );
		add_post_meta( $new_coupon_id, 'coupon_type', $coupon_options['coupon_type'] );
		add_post_meta( $new_coupon_id, 'order_id', $coupon_options['order_id'] );
		return true;
	}else{
		return false;
	}

}

add_action( 'woocommerce_order_status_completed', 'wrc_order_status_completed', 10, 1 );
function wrc_order_status_completed( $order_id ) {

	$args = array(
	    'posts_per_page'   => -1,
	    'post_type'        => 'shop_coupon',
	    'fields'           => 'ids',
	    'meta_query' => array(
	                   array(
	                       'key' => 'order_id',
	                       'value' => $order_id,
	                       'compare' => '=',
	                   )
	               )
	);

	$coupons = get_posts( $args );
	if(!$coupons){
		$order = wc_get_order( $order_id );
		$coupon_prefix = get_option('referral_prefix');

		foreach( $order->get_used_coupons() as $coupon_name) {

			$coupon_post_obj = get_page_by_title($coupon_name, OBJECT, 'shop_coupon');
			$coupon_id = $coupon_post_obj->ID;
			if(get_post_meta($coupon_id, 'coupon_type', true) === "referral"){

				if (substr($coupon_name, 0, strlen($coupon_prefix)) == $coupon_prefix) {
					$referral_user_id = intval(substr($coupon_name, strlen($coupon_prefix)));
				}

				$prize_prefix = get_option('prize_prefix');
				$prize_code = $prize_prefix . $referral_user_id . wrc_generate_random_string();

				while(get_page_by_title($prize_code, OBJECT, 'shop_coupon')){
					//Coupon exists
					$prize_code = $prize_prefix . $referral_user_id . wrc_generate_random_string();
				}

				$prize_options = array(
					'coupon_code'  => $prize_code,
					'discount_type' => get_option('prize_discount_type'),
					'coupon_amount' => get_option('prize_coupon_amount'),
					'individual_use' => get_option('prize_individual_use'),
					'product_ids' => get_option('prize_product_ids'),
					'exclude_product_ids' => get_option('prize_exclude_product_ids'),
					'usage_limit' => get_option('prize_usage_limit'),
					'expiry_date' => get_option('prize_expiry_date'),
					'apply_before_tax' => get_option('prize_apply_before_tax'),
					'free_shipping' => false,
					'usage_limit_per_user' => get_option('prize_usage_limit_per_user'),
					'minimum_amount' => get_option('prize_minimum_amount'),
					'maximum_amount' => get_option('prize_maximum_amount'),
					'user_id' => $referral_user_id,
					'coupon_type' => 'prize',
					'order_id' => $order_id
				);

				if(wrc_create_coupon($prize_options)){
					$ref_user_info = get_userdata($referral_user_id);
					$ref_email = $ref_user_info->user_email;

					$mailer = WC()->mailer();
	 
					$recipient = $ref_email;
					$subject = __("You've got a new coupon!", 'woocommerce-referral-coupons');
					$content = wrc_get_coupon_notification_content( $subject, $mailer, $prize_code );
					$headers = "Content-Type: text/html\r\n";
				 
					$mailer->send( $recipient, $subject, $content, $headers );
				}
				break;
			}
		}
	}
}

add_action('woocommerce_applied_coupon', 'wrc_apply_coupon_on_product');
function wrc_apply_coupon_on_product() {
	wc_clear_notices();
	
	foreach( WC()->cart->get_coupons() as $coupon) {
		$coupon_post_obj = get_page_by_title($coupon->get_code(), OBJECT, 'shop_coupon');
		$coupon_id = $coupon_post_obj->ID;

		$coupon_type = get_post_meta($coupon_id, 'coupon_type', true);
		if($coupon_type === 'referral' && get_option('referral_disabled_coupon')){
			wc_add_notice( __("You can't use this coupon.", 'woocommerce-referral-coupons'), 'error' );
			WC()->cart->remove_coupon( $coupon->get_code() );
		}else if($coupon_type === 'prize' && get_option('prize_disabled_coupon')){
			wc_add_notice( __("You can't use this coupon.", 'woocommerce-referral-coupons'), 'error' );
			WC()->cart->remove_coupon( $coupon->get_code() );
			return false;
		}else{
			$coupon_user_id = get_post_meta($coupon_id, 'user_id', true);
			$current_user_id = get_current_user_id();
			if($coupon_type === "referral" && $coupon_user_id == $current_user_id){
				wc_add_notice( __("You can't use your own coupon, share it with your friends!", 'woocommerce-referral-coupons'), 'error' );
				WC()->cart->remove_coupon( $coupon->get_code() );
				return false;
			}else if($coupon_type === "prize" && $coupon_user_id != $current_user_id){
				wc_add_notice( __("You can't use this coupon.", 'woocommerce-referral-coupons'), 'error' );
				WC()->cart->remove_coupon( $coupon->get_code() );
				return false;
			}else{
				return true;
			}
		}
	}
}

function wrc_update_coupons( $coupon_options ){
	 
	$coupon_id = $coupon_options['coupon_id'];

	if($coupon_options['expiry_date'] !== ''){
		$expiry_date = new WC_DateTime();
		$expiry_date->modify('+'.$coupon_options['expiry_date'].' day');
	}else{
		$expiry_date = null;
	}
	$the_coupon = array(
		'ID'           => $coupon_id,
		'post_title'   => $coupon_options['coupon_code']
	);

	wp_update_post( $the_coupon );
	update_post_meta( $coupon_id, 'discount_type', $coupon_options['discount_type'] );
	update_post_meta( $coupon_id, 'coupon_amount', $coupon_options['coupon_amount'] );
	update_post_meta( $coupon_id, 'individual_use', $coupon_options['individual_use'] );
	update_post_meta( $coupon_id, 'product_ids', $coupon_options['product_ids'] );
	update_post_meta( $coupon_id, 'exclude_product_ids', $coupon_options['exclude_product_ids']);
	update_post_meta( $coupon_id, 'usage_limit', $coupon_options['usage_limit'] );
	update_post_meta( $coupon_id, 'expiry_date', $expiry_date );
	update_post_meta( $coupon_id, 'apply_before_tax', $coupon_options['apply_before_tax'] );
	update_post_meta( $coupon_id, 'free_shipping', $coupon_options['free_shipping'] );
	update_post_meta( $coupon_id, 'usage_limit_per_user', $coupon_options['usage_limit_per_user'] );
	update_post_meta( $coupon_id, 'minimum_amount', $coupon_options['minimum_amount'] );
	update_post_meta( $coupon_id, 'maximum_amount', $coupon_options['maximum_amount'] );
	return true;
}

function wrc_get_coupon_notification_content($heading = false, $mailer, $prize_code) {

	$template = 'emails/customer-new-coupon.php';
 
	return wc_get_template_html( $template, array(
		'email_heading' => $heading,
		'sent_to_admin' => true,
		'plain_text'    => false,
		'email'         => $mailer,
		'prize_code'    => $prize_code
	), '', untrailingslashit( plugin_dir_path(__FILE__) ) . '/woocommerce/' );
}

function wrc_generate_random_string($length = 5) {
	return '-' . substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyz', ceil($length/strlen($x)) )),1,$length);
}
?>