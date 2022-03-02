<?php
/**
 * Settings page template.
 *
 * @package Ultimate_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {
	?>

	<div class="wrap heatbox-wrap uquickview-settings-page">

		<div class="heatbox-header heatbox-margin-bottom">

			<div class="heatbox-container heatbox-container-center">

				<div class="logo-container">

					<span class="title">
						<?php _e( 'Ultimate Quick View for WooCommerce', 'ultimate-quick-view-woocommerce' ); ?>
						<span class="version"><?php echo esc_html( ULTIMATE_QUICK_VIEW_PLUGIN_VERSION ); ?></span>
					</span>

					<p class="subtitle"><?php _e( 'A neat & clean plugin to quick view your WooCommerce products.', 'ultimate-quick-view-woocommerce' ); ?></p>

				</div>

			</div>

		</div>

		<div class="heatbox-container heatbox-container-center">

			<h1 style="display: none;"></h1>

			<form method="post" action="options.php" class="uquickview-settings-form">

				<?php settings_fields( 'uquickview-settings-group' ); ?>

				<div class="heatbox">
					<?php do_settings_sections( 'uquickview-general-settings' ); ?>
				</div>

				<div class="heatbox">
					<?php do_settings_sections( 'uquickview-button-settings' ); ?>
				</div>

				<?php submit_button( '', 'button button-primary button-larger' ); ?>

			</form>

			<div class="heatbox-divider"></div>

		</div>

		<div class="heatbox-container heatbox-container-wide heatbox-container-center uquickview-featured-products">

			<h2><?php _e( 'Check out our other free WordPress products!', 'ultimate-quick-view-woocommerce' ); ?></h2>

			<ul class="products">
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/better-admin-bar/" target="_blank">
						<img src="<?php echo esc_url( ULTIMATE_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/swift-control.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'Better Admin Bar', 'ultimate-quick-view-woocommerce' ); ?></h3>
						<p class="subheadline"><?php _e( 'Replace the boring WordPress Admin Bar with this!', 'ultimate-quick-view-woocommerce' ); ?></p>
						<p><?php _e( 'Better Admin Bar is the plugin that make your clients love WordPress. It drastically improves the user experience when working with WordPress and allows you to replace the boring WordPress admin bar with your own navigation panel.', 'ultimate-quick-view-woocommerce' ); ?></p>
						<a href="https://wordpress.org/plugins/better-admin-bar/" target="_blank" class="button"><?php _e( 'View Features', 'ultimate-quick-view-woocommerce' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank">
						<img src="<?php echo esc_url( ULTIMATE_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/ultimate-dashboard.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'Ultimate Dashboard', 'ultimate-quick-view-woocommerce' ); ?></h3>
						<p class="subheadline"><?php _e( 'The #1 plugin to customize your WordPress dashboard.', 'ultimate-quick-view-woocommerce' ); ?></p>
						<p><?php _e( 'Ultimate Dashboard is a clean & lightweight plugin that was made to optimize the user experience for clients inside the WordPress admin area.', 'ultimate-quick-view-woocommerce' ); ?></p>
						<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank" class="button"><?php _e( 'View Features', 'ultimate-quick-view-woocommerce' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/responsive-youtube-vimeo-popup/" target="_blank">
						<img src="<?php echo esc_url( ULTIMATE_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/wp-video-popup.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'WP Video Popup', 'ultimate-quick-view-woocommerce' ); ?></h3>
						<p class="subheadline"><?php _e( 'The #1 Video Popup Plugin for WordPress.', 'ultimate-quick-view-woocommerce' ); ?></p>
						<p><?php _e( 'Add beautiful responsive YouTube & Vimeo video lightbox popups to any post, page or custom post type of website without sacrificing performance.', 'ultimate-quick-view-woocommerce' ); ?></p>
						<a href="https://wordpress.org/plugins/responsive-youtube-vimeo-popup/" target="_blank" class="button"><?php _e( 'View Features', 'ultimate-quick-view-woocommerce' ); ?></a>
					</div>
				</li>
			</ul>

			<p class="credit"><?php _e( 'Made with ❤ in Aschaffenburg, Germany', 'ultimate-quick-view-woocommerce' ); ?></p>

		</div>

	</div>

	<?php
};
