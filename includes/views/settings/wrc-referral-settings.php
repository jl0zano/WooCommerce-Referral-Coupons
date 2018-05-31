<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

settings_fields( 'wrc-settings-group-referral' );
do_settings_sections( 'wrc-settings-group-referral' );
$wrc_referral_discount_type = esc_attr( get_option('referral_discount_type') );
$wrc_referral_individual_use = get_option('referral_individual_use');
$wrc_referral_apply_before_tax = get_option('referral_apply_before_tax');
?>
<h3><?php _e('Referral coupon settings', 'woocommerce-referral-coupons'); ?></h3>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><?php _e('Coupon name prefix', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="text" name="referral_prefix" value="<?php echo esc_attr( get_option('referral_prefix') ); ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Discount type', 'woocommerce-referral-coupons'); ?></th>
		<td>
			<select name="referral_discount_type">
				<option value="percent" <?php if($wrc_referral_discount_type == 'percent'){ echo "selected"; } ?>><?php _e('Percent', 'woocommerce-referral-coupons'); ?></option>
				<option value="fixed_cart" <?php if($wrc_referral_discount_type == 'fixed_cart'){ echo "selected"; } ?>><?php _e('Fixed Cart', 'woocommerce-referral-coupons'); ?></option>
			</select>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Discount amount', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="number" min="1" name="referral_coupon_amount" value="<?php echo esc_attr( get_option('referral_coupon_amount') ); ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Individual coupon', 'woocommerce-referral-coupons'); ?></th>
		<td>
			<input type="radio" name="referral_individual_use" value="1" <?php if($wrc_referral_individual_use){ echo 'checked'; } ?>> <?php _e('Yes', 'woocommerce-referral-coupons'); ?> 
			<input type="radio" name="referral_individual_use" value="0" <?php if(!$wrc_referral_individual_use){ echo 'checked'; } ?>> <?php _e('No', 'woocommerce-referral-coupons'); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Product IDs', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="text" name="referral_product_ids" value="<?php echo esc_attr(get_option('referral_product_ids') ); ?>" /></td>
		<td><?php _e('Product IDs this coupon can be used with (comma separated). Leave blank to use coupon on all products.', 'woocommerce-referral-coupons'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Exclude Product IDs', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="text" name="referral_exclude_product_ids" value="<?php echo esc_attr(get_option('referral_exclude_product_ids') ); ?>" /></td>
		<td><?php _e('Product IDs this coupon cannot be used with (comma separated).', 'woocommerce-referral-coupons'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Coupon usage limit', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="number" min="1" name="referral_usage_limit" value="<?php echo esc_attr( get_option('referral_usage_limit') ); ?>" /></td>
		<td><?php _e('Amount of times this coupon can be used globally. Leave blank for unlimited times.', 'woocommerce-referral-coupons'); ?></td>
	</tr>

	<tr valign="top">
		<th scope="row"><?php _e('Coupon expiry after creation', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="number" min="1" class="wrc-datepicker" name="referral_expiry_date" value="<?php echo esc_attr( get_option('referral_expiry_date') ); ?>" /></td>
		<td><?php _e('Days after creation for coupon to expire. Leave blank for no expiration.', 'woocommerce-referral-coupons'); ?></td>
	</tr>

	<tr valign="top">
		<th scope="row"><?php _e('Apply before Tax', 'woocommerce-referral-coupons'); ?></th>
		<td>
			<input type="radio" name="referral_apply_before_tax" value="1" <?php if($wrc_referral_apply_before_tax){ echo 'checked'; } ?>> <?php _e('Yes', 'woocommerce-referral-coupons'); ?> 
			<input type="radio" name="referral_apply_before_tax" value="0" <?php if(!$wrc_referral_apply_before_tax){ echo 'checked'; } ?>> <?php _e('No', 'woocommerce-referral-coupons'); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Coupon usage limit per user', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="number" min="1" name="referral_usage_limit_per_user" value="<?php echo esc_attr( get_option('referral_usage_limit_per_user') ); ?>" /></td>
		<td><?php _e('Amount of times this coupon can be used by a customer. Leave blank for unlimited times.', 'woocommerce-referral-coupons'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Minimum amount', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="number" min="1" name="referral_minimum_amount" value="<?php echo esc_attr( get_option('referral_minimum_amount') ); ?>" /></td>
		<td><?php _e('Minimum spend amount that must be met before this coupon can be used. Leave blank for none.', 'woocommerce-referral-coupons'); ?></td>
	</tr>
	<tr valign="top">
		<th scope="row"><?php _e('Maximum amount', 'woocommerce-referral-coupons'); ?></th>
		<td><input type="number" min="1" name="referral_maximum_amount" value="<?php echo esc_attr( get_option('referral_maximum_amount') ); ?>" /></td>
		<td><?php _e('Maximum spend amount that must be met before this coupon can be used. Leave blank for none.', 'woocommerce-referral-coupons'); ?></td>
	</tr>
</table>