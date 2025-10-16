<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes\Admin\Pages\Tabs;

class BasicUses {

	public function render() {
		?>
		<div id="help" class="wpkin-help getting-started-content active">
			<div class="content-heading heading-questions">
				<h2>
					<?php _e( 'Using Image Hover Effects', 'image-hover-effects-ultimate' ); ?>
					<mark><?php _e( 'Ultimate', 'image-hover-effects-ultimate' ); ?></mark>
				</h2>
				<p><?php _e( 'Here are some common questions and guides to help you get started with Image Hover Effects Ultimate.', 'image-hover-effects-ultimate' ); ?></p>
			</div>

			<section class="section-faq">

				<!-- FAQ Item 1 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'How can I create my first Image Hover Effect?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'After activation, go to Image Hover from your WordPress dashboard. Choose an effect module (General Effects, Caption, Flipbox, Button, etc.), select a layout from the template library, upload images, add content, and customize colors, fonts, and animations. Once done, save and copy the shortcode to display it anywhere on your site.', 'image-hover-effects-ultimate' ); ?>
						</p>
					</div>
				</div>

				<!-- FAQ Item 2 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'How do I display an Image Hover Effect on my page or post?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'Each Image Hover Effect you create generates a shortcode. Simply copy the shortcode [iheu_ultimate_oxi id="X"] and paste it inside any post, page, or widget area where you want the effect to appear. Compatible with Gutenberg, Elementor, WPBakery (Visual Composer), Divi, Beaver Builder, and more.', 'image-hover-effects-ultimate' ); ?>
						</p>
						<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/basic-uses/shortcode.png'; ?>">
					</div>
				</div>

				<!-- FAQ Item 3 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'Can I customize hover animations and styles?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'Yes! Image Hover Effects Ultimate provides 500+ hover animations across multiple effect modules. You can easily customize colors, fonts, borders, shadows, backgrounds, animations, image alignment, padding, and much more. You can design them directly from the settings panel without writing any code. Advanced users can also add custom CSS for complete control.', 'image-hover-effects-ultimate' ); ?>
						</p>
					</div>
				</div>

				<!-- FAQ Item 4 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'Does Image Hover Effects work with my page builder?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'Absolutely! Image Hover Effects shortcodes work seamlessly with Elementor, Gutenberg, WPBakery (Visual Composer), Divi, Beaver Builder, SiteOrigin, and all major page builders. The plugin also includes built-in Visual Composer extension for even easier integration.', 'image-hover-effects-ultimate' ); ?>
						</p>
					</div>
				</div>

				<!-- FAQ Item 5 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'What effect modules are available?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'Image Hover Effects Ultimate includes 10+ different effect modules: General Effects (33 styles), Caption Effects (31 styles), Flipbox Effects (29 styles), Button Effects (11 styles), Square Effects (22 styles), Carousel/Slider (3 styles), Filter/Sorting (2 styles), Image Lightbox (2 styles), Image Comparison (4 styles), Image Magnifier (2 styles), and Display Post. Each module offers unique animations and customization options.', 'image-hover-effects-ultimate' ); ?>
						</p>
					</div>
				</div>

				<!-- FAQ Item 6 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'How do I clone an existing hover effect?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'The Clone feature allows you to duplicate settings from one image effect to another with just one click. Go to the Image Hover Effects list, find the effect you want to clone, and click the Clone button. This saves time when you need to apply the same styles to multiple image galleries.', 'image-hover-effects-ultimate' ); ?>
						</p>
					</div>
				</div>

			</section>
		</div>
		<?php
	}
}
