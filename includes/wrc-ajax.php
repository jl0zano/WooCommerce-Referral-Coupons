<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

add_action('wp_ajax_generate_user_coupons', 'wrc_generate_user_coupons' );

function wrc_generate_user_coupons() {
	$users = get_users(array('fields' => 'ids'));
	$created_coupons = 0;
	foreach ($users as $user_id){
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'shop_coupon',
			'fields'           => 'ids',
			'meta_query' => array(
				'relation'      => 'AND',
							   array(
								   'key' => 'user_id',
								   'value' => $user_id,
								   'compare' => '=',
							   ),
							   array(
								   'key' => 'coupon_type',
								   'value' => 'referral',
								   'compare' => '=',
							   )
						   )
		);
		
		$coupons = get_posts( $args );
		if(count($coupons)<1){
			if(wrc_create_referral_coupon($user_id)){
				$created_coupons++;
			}
		}
	}
	printf(__( 'Created %s new coupons.', 'woocommerce-referral-coupons' ), $created_coupons );
	wp_die();
}

add_action('wp_ajax_update_coupons', 'wrc_update_coupons_ajax' );

function wrc_update_coupons_ajax() {
	$updated_coupons = 0;

	$args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'shop_coupon',
		'fields'           => 'ids',
		'meta_query' => array(
			'relation'      => 'OR',
						   array(
							   'key' => 'coupon_type',
							   'value' => 'prize',
							   'compare' => '=',
						   ),
						   array(
							   'key' => 'coupon_type',
							   'value' => 'referral',
							   'compare' => '=',
						   )
					   )
	);
	
	$coupons = get_posts( $args );
	$coupons_not_updated = array();


	foreach ($coupons as $coupon_id){
		$coupon_type = get_post_meta($coupon_id, 'coupon_type', true);
		$user_id = get_post_meta($coupon_id, 'user_id', true);

		$coupon_options = array(
				'coupon_id' => $coupon_id,
				'coupon_code'  => get_option($coupon_type.'_prefix') . $user_id . wrc_generate_random_string(),
				'discount_type' => get_option($coupon_type.'_discount_type'),
				'coupon_amount' => get_option($coupon_type.'_coupon_amount'),
				'individual_use' => get_option($coupon_type.'_individual_use'),
				'product_ids' => get_option($coupon_type.'_product_ids'),
				'exclude_product_ids' => get_option($coupon_type.'_exclude_product_ids'),
				'usage_limit' => get_option($coupon_type.'_usage_limit'),
				'expiry_date' => get_option($coupon_type.'_expiry_date'),
				'apply_before_tax' => get_option($coupon_type.'_apply_before_tax'),
				'free_shipping' => false,
				'usage_limit_per_user' => get_option($coupon_type.'_usage_limit_per_user'),
				'minimum_amount' => get_option($coupon_type.'_minimum_amount'),
				'maximum_amount' => get_option($coupon_type.'_maximum_amount')
			);

		if(wrc_update_coupons($coupon_options)){
			$updated_coupons++;
		}else{
			array_push($coupons_not_updated, $coupon_id);
		}
	}



	if(empty($coupons_not_updated)){
		_e('All coupons succesfully updated', 'woocommerce-referral-coupons');
	}else{
		_e("Couldn't update these coupons:", 'woocommerce-referral-coupons') . ' ' . implode(', ', $coupons_not_updated);
	}

	wp_die();
}

add_action('wp_ajax_disable_referral_coupons', 'wrc_disable_referral_coupons' );

function wrc_disable_referral_coupons() {
	if(get_option('referral_disabled_coupon')){
		update_option( 'referral_disabled_coupon', false);
		_e('Referral coupons are now enabled.', 'woocommerce-referral-coupons');
	}else{
		update_option( 'referral_disabled_coupon', true);
		_e('Referral coupons are now disabled.', 'woocommerce-referral-coupons');
	}
	wp_die();
}

add_action('wp_ajax_disable_prize_coupons', 'wrc_disable_prize_coupons' );

function wrc_disable_prize_coupons() {
	if(get_option('prize_disabled_coupon')){
		update_option( 'prize_disabled_coupon', false);
		_e('Prize coupons are now enabled.', 'woocommerce-referral-coupons');
	}else{
		update_option( 'prize_disabled_coupon', true);
		_e('Prize coupons are now disabled.', 'woocommerce-referral-coupons');
	}
	wp_die();
}

add_action('wp_ajax_delete_coupons', 'wrc_delete_coupons' );

function wrc_delete_coupons() {
  $coupons_not_deleted = array();
	$args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'shop_coupon',
		'fields'           => 'ids',
		'meta_query' => array(
			'relation'      => 'OR',
						   array(
							   'key' => 'coupon_type',
							   'value' => 'prize',
							   'compare' => '=',
						   ),
						   array(
							   'key' => 'coupon_type',
							   'value' => 'referral',
							   'compare' => '=',
						   )
					   )
	);
	
	$coupons = get_posts( $args );
	foreach($coupons as $coupon_id){
	  if(!wp_delete_post($coupon_id, true)){
		array_push($coupons_not_deleted, $coupon_id);
	  }
	}

	if(empty($coupons_not_deleted)){
	 _e('All coupons succesfully deleted.', 'woocommerce-referral-coupons');
	}else{
	  _e("Couldn't delete these coupons: ", 'woocommerce-referral-coupons') . ' ' . implode(', ', $coupons_not_deleted);
	}
	wp_die();
}


?>