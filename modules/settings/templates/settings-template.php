<?php
/**
 * Settings page template.
 *
 * @package Ultimate_Woo_Quick_View
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {
	?>

	<div class="wrap heatbox-wrap uwquickview-settings-page">

		<div class="heatbox-header heatbox-margin-bottom">

			<div class="heatbox-container heatbox-container-center">

				<div class="logo-container">

					<div>
						<span class="title">
							<?php _e( 'Ultimate Quick View for WooCommerce', 'ultimate-woo-quick-view' ); ?>
							<span class="version"><?php echo esc_html( ULTIMATE_WOO_QUICK_VIEW_PLUGIN_VERSION ); ?></span>
						</span>
						<p class="subtitle"><?php _e( 'The #1 plugin to quick view your Woocommerce products.', 'ultimate-woo-quick-view' ); ?></p>
					</div>

					<div>
						<img src="<?php echo esc_url( ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/ultimate-woo-quick-view.png">
					</div>

				</div>

			</div>

		</div>

		<div class="heatbox-container heatbox-container-center">

			<h1 style="display: none;"></h1>

			<form method="post" action="options.php" class="uwquickview-settings-form">

				<?php settings_fields( 'uwquickview-settings-group' ); ?>

				<div class="heatbox">
					<?php do_settings_sections( 'uwquickview-general-settings' ); ?>
				</div>

				<div class="heatbox">
					<?php do_settings_sections( 'uwquickview-button-settings' ); ?>
				</div>

				<?php submit_button( '', 'button button-primary button-larger' ); ?>

			</form>

			<div class="heatbox-divider"></div>

		</div>

		<div class="heatbox-container heatbox-container-wide heatbox-container-center uwquickview-featured-products">

			<h2><?php _e( 'Check out our other free WordPress products!', 'ultimate-woo-quick-view' ); ?></h2>

			<ul class="products">
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/swift-control/" target="_blank">
						<img src="<?php echo esc_url( ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/swift-control.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'WP Swift Control', 'ultimate-woo-quick-view' ); ?></h3>
						<p class="subheadline"><?php _e( 'Replace the boring WordPress Admin Bar with this!', 'ultimate-woo-quick-view' ); ?></p>
						<p><?php _e( 'Swift Control is the plugin that make your clients love WordPress. It drastically improves the user experience when working with WordPress and allows you to replace the boring WordPress admin bar with your own navigation panel.', 'ultimate-woo-quick-view' ); ?></p>
						<a href="https://wordpress.org/plugins/swift-control/" target="_blank" class="button"><?php _e( 'View Features', 'ultimate-woo-quick-view' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank">
						<img src="<?php echo esc_url( ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/ultimate-dashboard.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'Ultimate Dashboard', 'ultimate-woo-quick-view' ); ?></h3>
						<p class="subheadline"><?php _e( 'The #1 plugin to customize your WordPress dashboard.', 'ultimate-woo-quick-view' ); ?></p>
						<p><?php _e( 'Ultimate Dashboard is a clean & lightweight plugin that was made to optimize the user experience for clients inside the WordPress admin area.', 'ultimate-woo-quick-view' ); ?></p>
						<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank" class="button"><?php _e( 'View Features', 'ultimate-woo-quick-view' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/responsive-youtube-vimeo-popup/" target="_blank">
						<img src="<?php echo esc_url( ULTIMATE_WOO_QUICK_VIEW_PLUGIN_URL ); ?>/assets/images/wp-video-popup.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'WP Video Popup', 'ultimate-woo-quick-view' ); ?></h3>
						<p class="subheadline"><?php _e( 'The #1 Video Popup Plugin for WordPress.', 'ultimate-woo-quick-view' ); ?></p>
						<p><?php _e( 'Add beautiful responsive YouTube & Vimeo video lightbox popups to any post, page or custom post type of website without sacrificing performance.', 'ultimate-woo-quick-view' ); ?></p>
						<a href="https://wordpress.org/plugins/responsive-youtube-vimeo-popup/" target="_blank" class="button"><?php _e( 'View Features', 'ultimate-woo-quick-view' ); ?></a>
					</div>
				</li>
			</ul>

			<p class="credit"><?php _e( 'Made with ❤ in Aschaffenburg, Germany', 'ultimate-woo-quick-view' ); ?></p>

		</div>

	</div>

	<?php
};
