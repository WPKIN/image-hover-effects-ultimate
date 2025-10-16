<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes\Admin\Pages\Tabs;

class Help {

	public function render() {
		?>
		<div id="help" class="wpkin-help getting-started-content active">
			<div class="content-heading heading-questions">
				<h2>
					<?php _e( 'Frequently Asked', 'image-hover-effects-ultimate' ); ?>
					<mark><?php _e( 'Questions', 'image-hover-effects-ultimate' ); ?></mark>
				</h2>
			</div>

			<section class="section-faq">

				<!-- FAQ Item 1 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'I have a pre-sale question. How can I get support?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'For any pre-sale inquiries, please contact us directly by submitting a form here:', 'image-hover-effects-ultimate' ); ?>
							<a href="https://wpkin.com/contact-us/" target="_blank" rel="noopener noreferrer">
								<?php _e( 'Contact Us', 'image-hover-effects-ultimate' ); ?>
							</a>
						</p>
					</div>
				</div>

				<!-- FAQ Item 2 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'How do I install the Image Hover Effects Ultimate plugin?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( "Go to Plugins → Add New → Upload Plugin, choose the Image Hover Effects .zip file, install and activate. You can also install it directly from the WordPress plugin directory by searching for 'Image Hover Effects Ultimate'.", 'image-hover-effects-ultimate' ); ?>
							<a href="https://wpkindemos.com/imagehover/docs/" target="_blank" rel="noopener noreferrer">
								<?php _e( 'Read Installation Guide', 'image-hover-effects-ultimate' ); ?>
							</a>
						</p>
					</div>
				</div>

				<!-- FAQ Item 3 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'I purchased the PRO version, but it still shows the free plan. What should I do?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( "After purchase, go to the Plugins menu in your WordPress dashboard. Scroll down to the Image Hover Effects Ultimate plugin and click on 'Activate License.' A modal will appear where you can enter and submit your license key.", 'image-hover-effects-ultimate' ); ?>
						</p>
						<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/help/license-activate.png'; ?>">
					</div>
				</div>
				<!-- FAQ Item 4 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'Where can I find the PRO license key?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'After purchase, you should receive a confirmation email containing the license key. If you did not receive it due to email delivery issues, you can access your license key from the', 'image-hover-effects-ultimate' ); ?>
							<a href="https://users.freemius.com/store/20097/" target="_blank" rel="noopener noreferrer">Freemius Customer Portal.</a>
						</p>
					</div>
				</div>

				<!-- FAQ Item 5 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'How do I display Image Hover Effects on my website?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'Each Image Hover Effect you create generates a shortcode. Copy this shortcode and paste it inside any post, page, or widget area where you want the effect to appear. Works with Gutenberg, Elementor, WPBakery, Divi, and other builders.', 'image-hover-effects-ultimate' ); ?>
						</p>
						<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/basic-uses/shortcode.png'; ?>">
					</div>
				</div>

				<!-- FAQ Item 6 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'Where can I get support if I face an issue?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'For free users, you can ask questions in the WordPress.org support forum. For Pro users, premium email support is available. You can also contact us directly:', 'image-hover-effects-ultimate' ); ?>
							<a href="https://wpkin.com/contact-us/" target="_blank" rel="noopener noreferrer">
								<?php _e( 'Contact Support', 'image-hover-effects-ultimate' ); ?>
							</a>
						</p>
					</div>
				</div>

				<!-- FAQ Item 7 -->
				<div class="faq-item">
					<div class="faq-header" style="cursor:pointer">
						<i class="dashicons dashicons-arrow-down-alt2"></i>
						<h3>
							<?php _e( 'Is Image Hover Effects responsive and mobile-friendly?', 'image-hover-effects-ultimate' ); ?>
						</h3>
					</div>
					<div class="faq-body" style="display:none;">
						<p>
							<?php _e( 'Yes! Image Hover Effects Ultimate is fully responsive and mobile-friendly. Every effect is built with mobile in mind and includes touch-enable features. The effects automatically adapt to all screen sizes and work smoothly on iPhone, Android, tablets, and all touch screen devices.', 'image-hover-effects-ultimate' ); ?>
						</p>
					</div>
				</div>

			</section>

			<div class="content-heading heading-help">
				<h2>
					<?php _e( 'Need', 'image-hover-effects-ultimate' ); ?>
					<mark><?php _e( 'Help?', 'image-hover-effects-ultimate' ); ?></mark>
				</h2>
				<p>
					<?php _e( 'Read our documentation or contact us directly for support.', 'image-hover-effects-ultimate' ); ?>
				</p>
			</div>

			<div class="facebook-cta">
				<div class="cta-content">
					<h2><?php _e( 'Support', 'image-hover-effects-ultimate' ); ?></h2>
					<p>
						<?php _e( 'Join our community and get help from other Image Hover Effects users. Share your ideas, solve problems, and learn tips to get the most out of this powerful plugin.', 'image-hover-effects-ultimate' ); ?>
					</p>
				</div>
				<div class="cta-btn">
					<a href="https://wordpress.org/support/plugin/image-hover-effects-ultimate/" class="wpkin-btn btn-primary" target="_blank" rel="noopener noreferrer">
						<i class="dashicons dashicons-sos"></i>
						<?php _e( 'Get Support', 'image-hover-effects-ultimate' ); ?>
					</a>
				</div>
			</div>
		</div>

		<?php
	}
}
