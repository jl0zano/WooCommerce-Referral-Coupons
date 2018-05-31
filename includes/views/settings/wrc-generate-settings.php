<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="wrc-ajax-option">
	<h3>1. <?php _e('Generate coupon for all users', 'woocommerce-referral-coupons'); ?></h3>
	<p><?php _e("Referral coupons will be generated with current settings for all users if they don't already have one.", 'woocommerce-referral-coupons'); ?></p>
	<button class="button button-primary btn-settings-ajax" data-action="generate_user_coupons"><?php _e('Generate coupons', 'woocommerce-referral-coupons'); ?></button>
	<p class="wrc-ajax-response"><?php _e('Working...', 'woocommerce-referral-coupons'); ?></p>
</div>
<div class="wrc-ajax-option">
	<h3>2. <?php _e('Update coupon settings for all coupons', 'woocommerce-referral-coupons'); ?></h3>
	<p><?php _e('Referral and prize coupons will be updated with current settings.', 'woocommerce-referral-coupons'); ?></p>
	<button class="button button-primary btn-settings-ajax" data-action="update_coupons"><?php _e('Update coupons', 'woocommerce-referral-coupons'); ?></button>
	<p class="wrc-ajax-response"><?php _e('Working...', 'woocommerce-referral-coupons'); ?></p>
</div>
<div class="wrc-ajax-option">
<?php
	$referral_toggle_text = get_option('referral_disabled_coupon') ? __('Enable', 'woocommerce-referral-coupons') : __('Disable', 'woocommerce-referral-coupons');
?>
	<h3>3. <?php echo $referral_toggle_text ?> <?php _e('referral coupons', 'woocommerce-referral-coupons'); ?></h3>
	<p><?php _e("Users won't be able to use referral coupons if they are disabled.", 'woocommerce-referral-coupons'); ?></p>
	<button class="button button-primary btn-settings-ajax" data-action="disable_referral_coupons"><?php echo $referral_toggle_text; ?> <?php _e('referral coupons', 'woocommerce-referral-coupons'); ?></button>
	<p class="wrc-ajax-response"><?php _e('Working...', 'woocommerce-referral-coupons'); ?></p>
</div>
<div class="wrc-ajax-option">
<?php
	$prize_toggle_text = get_option('prize_disabled_coupon') ? __('Enable', 'woocommerce-referral-coupons') : __('Disable', 'woocommerce-referral-coupons');
?>
	<h3>4. <?php echo $prize_toggle_text ?> <?php _e('prize coupons', 'woocommerce-referral-coupons'); ?></h3>
	<p><?php _e("Users won't be able to use prize coupons if they are disabled.", 'woocommerce-referral-coupons'); ?></p>
	<button class="button button-primary btn-settings-ajax" data-action="disable_prize_coupons"><?php echo $prize_toggle_text; ?> <?php _e('prize coupons', 'woocommerce-referral-coupons'); ?></button>
	<p class="wrc-ajax-response"><?php _e('Working...', 'woocommerce-referral-coupons'); ?></p>
</div>
<div class="wrc-ajax-option">
	<h3>5. <?php _e('Delete all referral and prize coupons', 'woocommerce-referral-coupons'); ?></h3>
	<p><?php _e('Referral and prize coupons will be deleted.', 'woocommerce-referral-coupons'); ?></p>
	<button class="button button-primary btn-settings-ajax" data-action="delete_coupons"><?php _e('Delete coupons', 'woocommerce-referral-coupons'); ?></button>
	<p class="wrc-ajax-response"><?php _e('Working...', 'woocommerce-referral-coupons'); ?></p>
</div>