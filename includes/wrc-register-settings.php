<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function register_wrc_settings(){

	register_setting('wrc-settings-group-referral', 'referral_prefix', array(
		'type' => 'string',
		'default' => 'referral',
		'sanitize_callback' => 'wrc_validate_referral_prefix'
	));
	register_setting('wrc-settings-group-referral', 'referral_discount_type', array(
		'type' => 'string',
		'default' => 'percent',
		'sanitize_callback' => 'wrc_validate_referral_discount_type'
	));
	register_setting('wrc-settings-group-referral', 'referral_coupon_amount', array(
		'type' => 'integer',
		'default' => 10,
		'sanitize_callback' => 'wrc_validate_referral_coupon_amount'
	));
	register_setting('wrc-settings-group-referral', 'referral_individual_use', array(
		'type' => 'boolean',
		'default' => true,
		'sanitize_callback' => 'wrc_validate_referral_individual_use'
	));
	register_setting('wrc-settings-group-referral', 'referral_product_ids', array(
		'type' => 'string',
		'default' => '',
		'sanitize_callback' => 'wrc_sanitize_product_ids'
	));
	register_setting('wrc-settings-group-referral', 'referral_exclude_product_ids', array(
		'type' => 'string',
		'default' => '',
		'sanitize_callback' => 'wrc_sanitize_product_ids'
	));
	register_setting('wrc-settings-group-referral', 'referral_usage_limit', array(
		'type' => 'integer',
		'default' => 1,
		'sanitize_callback' => 'wrc_validate_referral_usage_limit'
	));
	register_setting('wrc-settings-group-referral', 'referral_expiry_date', array(
		'type' => 'integer',
		'sanitize_callback' => 'wrc_validate_referral_expiry_date'
	));
	register_setting('wrc-settings-group-referral', 'referral_apply_before_tax', array(
		'type' => 'boolean',
		'default' => true,
		'sanitize_callback' => 'wrc_validate_referral_apply_before_tax'
	));
	register_setting('wrc-settings-group-referral', 'referral_usage_limit_per_user', array(
		'type' => 'integer',
		'default' => 1,
		'sanitize_callback' => 'wrc_validate_referral_usage_limit_per_user'
	));
	register_setting('wrc-settings-group-referral', 'referral_minimum_amount', array(
		'type' => 'integer',
		'sanitize_callback' => 'wrc_validate_referral_minimum_amount'
	));
	register_setting('wrc-settings-group-referral', 'referral_maximum_amount', array(
		'type' => 'integer',
		'sanitize_callback' => 'wrc_validate_referral_maximum_amount'
	));
	register_setting('wrc-settings-group-referral', 'referral_disabled_coupon', array(
		'type' => 'boolean',
		'default' => false
	));

	//Prize coupon

	register_setting('wrc-settings-group-prize', 'prize_prefix', array(
		'type' => 'string',
		'default' => 'prize',
		'sanitize_callback' => 'wrc_validate_prize_prefix'
	));
	register_setting('wrc-settings-group-prize', 'prize_discount_type', array(
		'type' => 'string',
		'default' => 'percent',
		'sanitize_callback' => 'wrc_validate_prize_discount_type'
	));
	register_setting('wrc-settings-group-prize', 'prize_coupon_amount', array(
		'type' => 'integer',
		'default' => 10,
		'sanitize_callback' => 'wrc_validate_prize_coupon_amount'
	));
	register_setting('wrc-settings-group-prize', 'prize_individual_use', array(
		'type' => 'boolean',
		'default' => true,
		'sanitize_callback' => 'wrc_validate_prize_individual_use'
	));
	register_setting('wrc-settings-group-prize', 'prize_product_ids', array(
		'type' => 'string',
		'default' => '',
		'sanitize_callback' => 'wrc_sanitize_product_ids'
	));
	register_setting('wrc-settings-group-prize', 'prize_exclude_product_ids', array(
		'type' => 'string',
		'default' => '',
		'sanitize_callback' => 'wrc_sanitize_product_ids'
	));
	register_setting('wrc-settings-group-prize', 'prize_usage_limit', array(
		'type' => 'integer',
		'default' => 1,
		'sanitize_callback' => 'wrc_validate_prize_usage_limit'
	));
	register_setting('wrc-settings-group-prize', 'prize_expiry_date', array(
		'type' => 'integer',
		'sanitize_callback' => 'wrc_validate_prize_expiry_date'
	));
	register_setting('wrc-settings-group-prize', 'prize_apply_before_tax', array(
		'type' => 'boolean',
		'default' => true,
		'sanitize_callback' => 'wrc_validate_prize_apply_before_tax'
	));
	register_setting('wrc-settings-group-prize', 'prize_usage_limit_per_user', array(
		'type' => 'integer',
		'default' => 1,
		'sanitize_callback' => 'wrc_validate_prize_usage_limit_per_user'
	));
	register_setting('wrc-settings-group-prize', 'prize_minimum_amount', array(
		'type' => 'integer',
		'sanitize_callback' => 'wrc_validate_prize_minimum_amount'
	));
	register_setting('wrc-settings-group-prize', 'prize_maximum_amount', array(
		'type' => 'integer',
		'sanitize_callback' => 'wrc_validate_prize_maximum_amount'
	));
	register_setting('wrc-settings-group-prize', 'prize_disabled_coupon', array(
		'type' => 'boolean',
		'default' => false
	));
}
?>