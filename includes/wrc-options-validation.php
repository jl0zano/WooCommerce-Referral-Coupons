<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
    
function wrc_validate_prize_prefix($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'prize_prefix', 'invalid-prize_prefix', __( 'Coupon prefix must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 'prize';
    }
    return $new_value;
}

function wrc_validate_prize_discount_type($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'prize_discount_type', 'invalid-prize_discount_type', __( 'Coupon discount type must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 'percent';
    }
    return $new_value;
}

function wrc_validate_prize_coupon_amount($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'prize_coupon_amount', 'invalid-prize_coupon_amount', __( 'Coupon ammount must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }else if(!intval($new_value)){
        add_settings_error( 'prize_coupon_amount', 'invalid-prize_coupon_amount', __( 'Coupon amount must be a number. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }else if(intval($new_value) < 1){
        add_settings_error( 'prize_coupon_amount', 'invalid-prize_coupon_amount', __( 'Coupon ammount must be greater than 0. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }else if(get_option('prize_discount_type') === 'percent' && intval($new_value) > 99){
        add_settings_error( 'referral_coupon_amount', 'invalid-referral_coupon_amount', __( 'Coupon ammount must be less than 100 percent discount. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }
    return $new_value;
}

function wrc_validate_prize_individual_use($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'prize_individual_use', 'invalid-prize_individual_use', __( 'Type', 'Coupon individual use must not be empty. Assigned default value.' ), 'error' );
        $new_value = true;
    }
    return $new_value;
}


function wrc_validate_prize_usage_limit($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'prize_usage_limit', 'invalid-prize_usage_limit', __( 'Coupon usage limit must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'prize_usage_limit', 'invalid-prize_usage_limit', __( 'Coupon usage limit must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}

function wrc_validate_prize_expiry_date ( $new_value, $old_value ) {
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'prize_expiry_date', 'invalid-prize_expiry_date', __( 'Coupon expiry days must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $date = null;
        }else if(abs(intval($new_value)) < 1){
            add_settings_error( 'prize_expiry_date', 'invalid-prize_expiry_date', __( 'Coupon expiry days must be grater than 1', 'woocommerce-referral-coupons' ), 'error' );
            $date = null;
            
        }else{
            $date = intval($new_value);
        }
    }
    return $date;

}

function wrc_validate_prize_apply_before_tax($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'prize_apply_before_tax', 'invalid-prize_apply_before_tax', __( 'Coupon apply before tax must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = true;
    }
    return $new_value;
}

function wrc_validate_prize_usage_limit_per_user($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'prize_usage_limit_per_user', 'invalid-prize_usage_limit_per_user', __( 'Coupon usage limit per user must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'prize_usage_limit_per_user', 'invalid-prize_usage_limit_per_user', __( 'Coupon usage limit per user must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}

function wrc_validate_prize_minimum_amount($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'prize_minimum_amount', 'invalid-prize_minimum_amount', __( 'Coupon minimum amount must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'prize_minimum_amount', 'invalid-prize_minimum_amount', __( 'Coupon minimum amount must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}

function wrc_validate_prize_maximum_amount($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'prize_maximum_amount', 'invalid-prize_maximum_amount', __( 'Coupon maximum amount must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'prize_maximum_amount', 'invalid-prize_maximum_amount', __( 'Coupon maximum amount must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}

function wrc_sanitize_product_ids ( $new_value, $old_value ) {
    $arr_product_ids = array();
    if($new_value !== ''){
        $input = str_replace(' ', '', $new_value);
        $ids = explode(",",$input);
        foreach( $ids as $id ) {
            $verified_id = intval($id);
            if($verified_id){
                array_push($arr_product_ids, abs($verified_id));
            }
        }
    }
    return implode(',', $arr_product_ids);
}

function wrc_validate_referral_prefix($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'referral_prefix', 'invalid-referral_prefix', __( 'Coupon prefix must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 'referral';
    }
    return $new_value;
}

function wrc_validate_referral_discount_type($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'referral_discount_type', 'invalid-referral_discount_type', __( 'Coupon discount type must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 'percent';
    }
    return $new_value;
}

function wrc_validate_referral_coupon_amount($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'referral_coupon_amount', 'invalid-referral_coupon_amount', __( 'Coupon ammount must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }else if(!intval($new_value)){
        add_settings_error( 'referral_coupon_amount', 'invalid-referral_coupon_amount', __( 'Coupon amount must be a number. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }else if(intval($new_value) < 1){
        add_settings_error( 'referral_coupon_amount', 'invalid-referral_coupon_amount', __( 'Coupon ammount must be greater than 0. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }else if(get_option('referral_discount_type') === 'percent' && intval($new_value) > 99){
        add_settings_error( 'referral_coupon_amount', 'invalid-referral_coupon_amount', __( 'Coupon discount ammount must be less than 100 percent discount. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = 10;
    }
    return $new_value;
}

function wrc_validate_referral_individual_use($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'referral_individual_use', 'invalid-referral_individual_use', __( 'Coupon individual use must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = true;
    }
    return $new_value;
}


function wrc_validate_referral_usage_limit($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'referral_usage_limit', 'invalid-referral_usage_limit', __( 'Coupon usage limit must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'referral_usage_limit', 'invalid-referral_usage_limit', __( 'Coupon usage limit must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}

function wrc_validate_referral_expiry_date ( $new_value, $old_value ) {
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'referral_expiry_date', 'invalid-referral_expiry_date', __( 'Coupon expiry days must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $date = null;
        }else if(abs(intval($new_value)) < 1){
            add_settings_error( 'referral_expiry_date', 'invalid-referral_expiry_date', __( 'Coupon expiry days must be grater than 1', 'woocommerce-referral-coupons' ), 'error' );
            $date = null;
        }else{
            $date = intval($new_value);
        }
    }
    return $date;

}

function wrc_validate_referral_apply_before_tax($new_value, $old_value){
    if($new_value === ''){
        add_settings_error( 'referral_apply_before_tax', 'invalid-referral_apply_before_tax', __( 'Coupon apply before tax must not be empty. Assigned default value.', 'woocommerce-referral-coupons' ), 'error' );
        $new_value = true;
    }
    return $new_value;
}

function wrc_validate_referral_usage_limit_per_user($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'referral_usage_limit_per_user', 'invalid-referral_usage_limit_per_user', __( 'Coupon usage limit per user must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'referral_usage_limit_per_user', 'invalid-referral_usage_limit_per_user', __( 'Coupon usage limit per user must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}

function wrc_validate_referral_minimum_amount($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'referral_minimum_amount', 'invalid-referral_minimum_amount', __( 'Coupon minimum amount must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'referral_minimum_amount', 'invalid-referral_minimum_amount', __( 'Coupon minimum amount must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}

function wrc_validate_referral_maximum_amount($new_value, $old_value){
    if($new_value !== ''){
        if(!intval($new_value)){
            add_settings_error( 'referral_maximum_amount', 'invalid-referral_maximum_amount', __( 'Coupon maximum amount must be a number.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }else if(intval($new_value) < 1){
            add_settings_error( 'referral_maximum_amount', 'invalid-referral_maximum_amount', __( 'Coupon maximum amount must be greater than 0.', 'woocommerce-referral-coupons' ), 'error' );
            $new_value = null;
        }
    }
    return $new_value;
}
?>