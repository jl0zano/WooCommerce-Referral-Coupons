<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action( 'woocommerce_account_dashboard', 'wrc_add_coupon_to_account_dashboard', 10, 0 );
function wrc_add_coupon_to_account_dashboard() { 
?>
	<hr>
	<p id="wrc-myaccount-link"><b><?php _e("Share your invite coupon with your friends. You'll earn a discount coupon when they start buying.", 'woocommerce-referral-coupons'); ?> <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>referral-coupons/"><?php _e('Learn more', 'woocommerce-referral-coupons'); ?>.</a></b></p>
<?php
}

add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
	wp_enqueue_style( 'dashicons' );
}

add_action( 'init', 'wrc_add_referral_coupons_endpoint' );
function wrc_add_referral_coupons_endpoint() {
	add_rewrite_endpoint( 'referral-coupons', EP_ROOT | EP_PAGES );
}

add_filter( 'query_vars', 'wrc_referral_coupons_query_vars', 0 );
function wrc_referral_coupons_query_vars( $vars ) {
	$vars[] = 'referral-coupons';
	return $vars;
}

add_filter( 'woocommerce_account_menu_items', 'wrc_add_referral_coupons_link_my_account' );
function wrc_add_referral_coupons_link_my_account( $items ) {
	$items['referral-coupons'] = __('Referral coupons', 'woocommerce-referral-coupons');
	return $items;
}

add_action( 'woocommerce_account_referral-coupons_endpoint', 'wrc_referral_coupons_content' );
function wrc_referral_coupons_content() {
	$current_user_id = get_current_user_id();
	$args = array(
		'posts_per_page'   => -1,
		'post_type'        => 'shop_coupon',
		'meta_query' => array(
			'relation'      => 'OR',
			array(
				'relation' => 'AND',
				array(
				   'key' => 'user_id',
				   'value' => $current_user_id,
				   'compare' => '=',
			   ),
				array(
				   'key' => 'coupon_type',
				   'value' => 'referral',
				   'compare' => '=',
			   )
			),
			array(
				'relation' => 'AND',
				array(
				   'key' => 'user_id',
				   'value' => $current_user_id,
				   'compare' => '=',
			   ),
				array(
				   'key' => 'coupon_type',
				   'value' => 'prize',
				   'compare' => '=',
			   )
			)
		)
	);
	$referralCoupon = '';
	$prizeCoupons = '';
	$coupons = get_posts( $args );
	foreach($coupons as $coupon){

		$coupon_obj =  new WC_Coupon($coupon->ID);

			$expiry_date = $coupon_obj->get_date_expires();
			$usage_limit = get_post_meta($coupon->ID, 'usage_limit', true);
			$coupon_expired = '';

			if($usage_limit){
				$uses_substraction = intval($usage_limit) - $coupon_obj->get_usage_count();
				$uses_left = ($usage_limit ? __('Uses left', 'woocommerce-referral-coupons') . ': ' . $uses_substraction : '');
				$coupon_expired = ($uses_substraction < 1 ? '<div class="wrc-coupon-expired-overlay"><p>'.__('Coupon limit reached', 'woocommerce-referral-coupons').'</p></div>' : '');
			}else{
				$uses_left = '';
			}


			if($expiry_date){
				$coupon_expired = (new DateTime() > $expiry_date ? '<div class="wrc-coupon-expired-overlay"><p>'.__('Coupon expired', 'woocommerce-referral-coupons').'</p></div>' : '');
			}

			$expiry_date = ($expiry_date ? __('Expires', 'woocommerce-referral-coupons') .' ' . substr($expiry_date, 0, 10) : __('No expiration', 'woocommerce-referral-coupons'));
			

			$discount_type = get_post_meta($coupon->ID, 'discount_type', true);
			$discount_amount = get_post_meta($coupon->ID, 'coupon_amount', true);
			$discount = ($discount_type === 'percent' ? $discount_amount.'% '.__('off', 'woocommerce-referral-coupons') : '$'.$discount_amount.' '.__('off', 'woocommerce-referral-coupons'));

			$wrc_coupon_classes = 'wrc-coupon-divisor';

		if(get_post_meta($coupon->ID, 'coupon_type', true) === 'referral' ){
			$referralCoupon = '
				<div class="wrc-coupon-divisor">
					'.$coupon_expired.'
					<h3 class="wrc-coupon-title"><b>'.$coupon->post_title.'</b><br>('.$discount.')</h3>
					<p>'.$expiry_date.'. '.$uses_left.'</p>
					<div class="wrc-coupon-share" data-coupon="'.$coupon->post_title.'" data-blog="'.get_bloginfo('name').'" data-blog-url="'.get_bloginfo('url').'">
						<a class="wrc-share-site wcr-visible-xs" href="#" data-site="whatsapp">
							<span class="dashicons dashicons-admin-comments"></span>
						</a>
						<a class="wrc-share-site" href="#" data-site="twitter">
							<span class="dashicons dashicons-twitter"></span>
						</a>
						<a class="wrc-share-site" href="#" data-site="email">
							<span class="dashicons dashicons-email-alt"></span>
						</a>
					</div>
				</div>
			';

		}else{
			$prizeCoupons.= '
				<div class="wrc-coupon-divisor">
					'.$coupon_expired.'
					<h3 class="wrc-coupon-title"><b>'.$coupon->post_title.'</b><br>('.$discount.')</h3>
					<p>'.$expiry_date.'. '.$uses_left.'</p>
				</div>
			';
		}

	}
	?>
	<p><?php _e("Every time a user uses your discount coupon code, you'll recieve a discount coupon. Share it with your friends!", 'woocommerce-referral-coupons'); ?></p>
	<p class="wrc-coupon-type"><?php _e('My referral coupon', 'woocommerce-referral-coupons'); ?></p>
	<?php echo ($referralCoupon ? $referralCoupon: __("You don't have a referral coupon yet.", 'woocommerce-referral-coupons')); ?>
	<p class="wrc-coupon-type"><?php _e('My prize coupons', 'woocommerce-referral-coupons'); ?></p>
	<?php echo ($prizeCoupons ? $prizeCoupons: __("You don't have any prize coupons yet.", 'woocommerce-referral-coupons')); ?>

<?php
}
?>