<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_filter( 'manage_edit-shop_coupon_columns', 'wrc_add_coupon_owner_column_header', 20 );
function wrc_add_coupon_owner_column_header( $columns ) {

	$new_columns = array();

	foreach ( $columns as $column_name => $column_info ) {

		$new_columns[ $column_name ] = $column_info;

		if ( 'expiry_date' === $column_name ) {
			$new_columns['coupon_owner'] = __( 'Owner', 'woocommerce-referral-coupons' );
			$new_columns['coupon_type'] = __( 'Type', 'woocommerce-referral-coupons' );
		}
	}

	return $new_columns;
}

add_action( 'manage_shop_coupon_posts_custom_column', 'wrc_add_coupon_owner_column_content' );
function wrc_add_coupon_owner_column_content( $column ) {
	global $post;
	if ( 'coupon_owner' === $column ) {
		$coupon_user_id = get_post_meta($post->ID, 'user_id', true);
		if ( $coupon_user_id ) {
			$user = get_userdata($coupon_user_id);
			echo $user->user_login;
		}
	}

	if ( 'coupon_type' === $column ) {
		$coupon_type = get_post_meta($post->ID, 'coupon_type', true);
		if ( $coupon_type ) {
			echo $coupon_type;
		}
	}

}

add_action("admin_menu", "wrc_add_menu");
function wrc_add_menu(){
	add_submenu_page("woocommerce", __("Referral Coupons", 'woocommerce-referral-coupons'), __("Referral Coupons", 'woocommerce-referral-coupons'), 'manage_options', "wrc-settings", "wrc_add_main_page");
	add_action( 'admin_init', 'register_wrc_settings' );
}

function wrc_add_main_page(){
?>
<div class="wrap">
	<h1><?php _e('WooCommerce Referral Coupons', 'woocommerce-referral-coupons'); ?></h1>
	
	<?php
	if( isset( $_GET[ 'tab' ] ) ) {
		$active_tab = $_GET[ 'tab' ];
	}else{
		$active_tab = 'welcome';
	}
	?>

	<h2 class="nav-tab-wrapper">
		<a href="?page=wrc-settings" class="nav-tab <?php echo $active_tab == 'welcome' ? 'nav-tab-active' : ''; ?>"><?php _e('Welcome', 'woocommerce-referral-coupons'); ?></a>
		<a href="?page=wrc-settings&tab=referral-settings" class="nav-tab <?php echo $active_tab == 'referral-settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Referral Coupon', 'woocommerce-referral-coupons'); ?></a>
		<a href="?page=wrc-settings&tab=prize-settings" class="nav-tab <?php echo $active_tab == 'prize-settings' ? 'nav-tab-active' : ''; ?>"><?php _e('Prize Coupon', 'woocommerce-referral-coupons'); ?></a>
		<a href="?page=wrc-settings&tab=generate-coupons" class="nav-tab <?php echo $active_tab == 'generate-coupons' ? 'nav-tab-active' : ''; ?>"><?php _e('Generate coupons', 'woocommerce-referral-coupons'); ?></a>
	</h2>

	<?php
	if($active_tab === 'welcome'){
	?>
	<p><?php _e('This plugin generates coupons for registered users. When an order with a referral coupon is completed, the referrer will recieve a new coupon for him.', 'woocommerce-referral-coupons'); ?></p>
	<h3><?php _e('How does it work?', 'woocommerce-referral-coupons'); ?></h3>
	<ol>
		<li><?php _e('<b>User "A"</b> registers on website', 'woocommerce-referral-coupons'); ?></li>
		<li><?php _e('A unique coupon is generated for <b>user "A"</b>', 'woocommerce-referral-coupons'); ?></li>
		<li><?php _e('<b>User "B"</b> makes a purchase with <b>user "A"</b> coupon', 'woocommerce-referral-coupons'); ?></li>
		<li><?php _e('<b>User "B"</b> order is marked as complete by store admin', 'woocommerce-referral-coupons'); ?></li>
		<li><?php _e('<b>User "A"</b> recieves a discount coupon on his email', 'woocommerce-referral-coupons'); ?></li>
	</ol>
	<p><?php _e('See plugin settings to configure coupons.', 'woocommerce-referral-coupons'); ?></p>
	<?php
	}else if($active_tab === 'generate-coupons'){
		include(dirname(__FILE__).'/settings/wrc-generate-settings.php');
	}else if($active_tab === 'referral-settings' || $active_tab === 'prize-settings'){
		settings_errors();
	?>
		<form method="post" action="options.php">
		<?php
		if($active_tab === 'referral-settings'){
			include(dirname(__FILE__).'/settings/wrc-referral-settings.php');
		}else if($active_tab === 'prize-settings'){
			include(dirname(__FILE__).'/settings/wrc-prize-settings.php');
		}
		submit_button();
		?>
		</form>
	<?php
	}
	?>
	<p><i><?php _e('Plugin made by', 'woocommerce-referral-coupons'); ?> <a href="https://lozanojai.me" target="_blank">Jaime Lozano</a>. <?php _e('Feel free to contribute to the plugin!', 'woocommerce-referral-coupons'); ?> <?php _e('Visit the', 'woocommerce-referral-coupons'); ?> <a href="#"><?php _e('repo', 'woocommerce-referral-coupons'); ?></a>.</i></p>
</div>
<?php } ?>