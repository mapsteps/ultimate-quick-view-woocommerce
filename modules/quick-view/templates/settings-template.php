<?php
/**
 * Settings page template.
 *
 * @package Woocommerce_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {
	?>

	<div class="wrap heatbox-wrap wooquickview-settings-page">

		<div class="heatbox-header heatbox-margin-bottom">

			<div class="heatbox-container heatbox-container-center">

				<div class="logo-container">

					<div>
						<span class="title">
							<?php _e( 'Woocommerce Quick View', 'woocommerce-quick-view' ); ?>
							<span class="version"><?php echo esc_html( WOOCOMMERCE_QUICK_VIEW_PLUGIN_VERSION ); ?></span>
						</span>
						<p class="subtitle"><?php _e( 'The #1 plugin to quick view your Woocommerce products.', 'woocommerce-quick-view' ); ?></p>
					</div>

					<div>
						<img src="<?php echo esc_url( WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/woocommerce-quick-view.png">
					</div>

				</div>

			</div>

		</div>

		<div class="heatbox-container heatbox-container-center">

			<h1 style="display: none;"></h1>

			<form method="post" action="options.php" class="wooquickview-settings-form">

				<?php settings_fields( 'wooquickview-settings-group' ); ?>

				<div class="heatbox">
					<?php do_settings_sections( 'wooquickview-general-settings' ); ?>
				</div>

				<div class="heatbox">
					<?php do_settings_sections( 'wooquickview-misc-settings' ); ?>
				</div>

				<?php submit_button( '', 'button button-primary button-larger' ); ?>

			</form>

			<div class="heatbox-divider"></div>

		</div>

		<div class="heatbox-container heatbox-container-wide heatbox-container-center wooquickview-featured-products">

			<h2><?php _e( 'Check out our other free WordPress products!', 'woocommerce-quick-view' ); ?></h2>

			<ul class="products">
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/swift-control/" target="_blank">
						<img src="<?php echo esc_url( WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/swift-control.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'WP Swift Control', 'woocommerce-quick-view' ); ?></h3>
						<p class="subheadline"><?php _e( 'Replace the boring WordPress Admin Bar with this!', 'woocommerce-quick-view' ); ?></p>
						<p><?php _e( 'Swift Control is the plugin that make your clients love WordPress. It drastically improves the user experience when working with WordPress and allows you to replace the boring WordPress admin bar with your own navigation panel.', 'woocommerce-quick-view' ); ?></p>
						<a href="https://wordpress.org/plugins/swift-control/" target="_blank" class="button"><?php _e( 'View Features', 'woocommerce-quick-view' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank">
						<img src="<?php echo esc_url( WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/ultimate-dashboard.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'Ultimate Dashboard', 'woocommerce-quick-view' ); ?></h3>
						<p class="subheadline"><?php _e( 'The #1 plugin to customize your WordPress dashboard.', 'woocommerce-quick-view' ); ?></p>
						<p><?php _e( 'Ultimate Dashboard is a clean & lightweight plugin that was made to optimize the user experience for clients inside the WordPress admin area.', 'woocommerce-quick-view' ); ?></p>
						<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank" class="button"><?php _e( 'View Features', 'woocommerce-quick-view' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/responsive-youtube-vimeo-popup/" target="_blank">
						<img src="<?php echo esc_url( WOOCOMMERCE_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/wp-video-popup.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'WP Video Popup', 'woocommerce-quick-view' ); ?></h3>
						<p class="subheadline"><?php _e( 'The #1 Video Popup Plugin for WordPress.', 'woocommerce-quick-view' ); ?></p>
						<p><?php _e( 'Add beautiful responsive YouTube & Vimeo video lightbox popups to any post, page or custom post type of website without sacrificing performance.', 'woocommerce-quick-view' ); ?></p>
						<a href="https://wordpress.org/plugins/responsive-youtube-vimeo-popup/" target="_blank" class="button"><?php _e( 'View Features', 'woocommerce-quick-view' ); ?></a>
					</div>
				</li>
			</ul>

			<p class="credit"><?php _e( 'Made with ❤ in Aschaffenburg, Germany', 'woocommerce-quick-view' ); ?></p>

		</div>

	</div>

	<?php
};
