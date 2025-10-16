<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes\Admin\Pages\Tabs;

class Introduction {

	function render() {
		?>
		<div id="introduction" class="getting-started-content content-introduction setup-complete active" >
			<div class="content-heading heading-overview">
				<h2>
					<?php echo esc_html__( 'Welcome to', 'image-hover-effects-ultimate' ); ?>
					<mark><?php echo esc_html__( 'Image Hover Effects Ultimate', 'image-hover-effects-ultimate' ); ?></mark>
				</h2>
				<p>
					<?php echo esc_html__( 'Create stunning image hover effects, galleries, lightbox, comparison, and magnifier with 500+ modern CSS3 animations.', 'image-hover-effects-ultimate' ); ?>
				</p>
			</div>

			<section class="section-introduction section-full">
				<div class="col-description">
					<p><?php echo esc_html__( 'Image Hover Effects Ultimate allows you to create impressive, responsive image galleries and hover effects that enhance user engagement and bring your website to life. Whether it\'s portfolios, product showcases, galleries, or interactive image displays, Image Hover Effects makes your visuals unforgettable.', 'image-hover-effects-ultimate' ); ?></p>
					<p><?php echo esc_html__( 'With 500+ hover effects, multiple effect modules (General Effects, Caption, Flipbox, Button, Carousel, Filter/Sorting, Lightbox, Comparison, Magnifier, Square Effects), and flexible customization options, you can design stunning, responsive galleries in just a few clicks — fully compatible with Elementor, Gutenberg, WPBakery, and all major page builders.', 'image-hover-effects-ultimate' ); ?></p>
				</div>

				<div class="col-image">
					<iframe src="https://www.youtube.com/embed/SGHeoNPogbE" title="YouTube demo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen=""></iframe>
				</div>
			</section>

			<div class="content-heading never-miss-feature">
				<h2>
					<?php echo esc_html__( 'Powerful', 'image-hover-effects-ultimate' ); ?>
					<mark><?php echo esc_html__( 'Image Hover Features', 'image-hover-effects-ultimate' ); ?></mark>
				</h2>
				<p><?php echo esc_html__( 'Design eye-catching image effects and galleries with complete flexibility', 'image-hover-effects-ultimate' ); ?></p>
			</div>

			<section class="section-full">
				<div class="col-description">
					<h2><?php echo esc_html__( '500+ Hover Effects & Animations', 'image-hover-effects-ultimate' ); ?></h2>
					<p><?php echo esc_html__( 'Choose from an extensive library of 500+ pre-built hover animations and effects across multiple modules including General Effects (33 styles), Caption Effects (31 styles), Flipbox Effects (29 styles), Button Effects (11 styles), Square Effects (22 styles), and more. From subtle fades to bold 3D transformations, Image Hover Effects has the perfect animation for every project. All effects are smooth, lightweight, and optimized for performance, so your site stays fast and responsive. Mix and match effects to create unique interactions that grab attention and keep visitors engaged.', 'image-hover-effects-ultimate' ); ?></p>
				</div>
				<div class="col-image">
					<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/Intruduction/50-hover-effects.png'; ?>" alt=""/>
				</div>
			</section>

			<section class="section-full">
				<div class="col-image">
					<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/Intruduction/customization.png'; ?>" alt=""/>
				</div>
				<div class="col-description">
					<h2><?php echo esc_html__( 'Multiple Effect Modules', 'image-hover-effects-ultimate' ); ?></h2>
					<p><?php echo esc_html__( 'Choose from 10+ different effect modules: General Effects, Caption Effects, Flipbox Effects, Button Effects, Square Effects, Carousel/Slider, Filter/Sorting, Image Lightbox, Image Comparison, Image Magnifier, and Display Post. Each module comes with extensive customization options including colors, fonts, borders, shadows, backgrounds, and more. Your designs remain fully responsive, ensuring they look stunning on desktops, tablets, and mobile devices alike.', 'image-hover-effects-ultimate' ); ?></p>
				</div>
			</section>

			<section class="section-full">
				<div class="col-description">
					<h2><?php echo esc_html__( 'Responsive & Mobile Friendly', 'image-hover-effects-ultimate' ); ?><span class="badge"><?php echo esc_html__( 'Touch Enabled', 'image-hover-effects-ultimate' ); ?> ⚡</span></h2>
					<p><?php echo esc_html__( 'Every effect is built with mobile in mind and includes touch-enable features. Image effects automatically adapt to all screen sizes, ensuring your site looks great on desktops, tablets, and phones. Works smoothly on iPhone, Android, and all touch screen devices. No extra coding or adjustments are required — everything works out of the box. With fully responsive layouts and touch navigation support, you can deliver a seamless user experience across every device.', 'image-hover-effects-ultimate' ); ?></p>
				</div>
				<div class="col-image">
					<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/Intruduction/responsive.png'; ?>" alt=""/>
				</div>
			</section>

			<div class="content-heading heading-shortcodes">
				<h2>
					<mark><?php echo esc_html__( 'Flexible Shortcodes', 'image-hover-effects-ultimate' ); ?></mark>
					<?php echo esc_html__( 'for Easy Integration', 'image-hover-effects-ultimate' ); ?>
				</h2>
				<p><?php echo esc_html__( 'Insert Image Hover Effects anywhere using shortcodes or page builders.', 'image-hover-effects-ultimate' ); ?></p>
			</div>

			<section class="section-shortcodes section-full">
				<div class="col-description">
					<h2><?php echo esc_html__( 'Insert Anywhere', 'image-hover-effects-ultimate' ); ?></h2>
					<p><?php echo esc_html__( 'With shortcode support, you can easily place Image Hover Effects inside posts, pages, widgets, or custom layouts. Fully compatible with Elementor, Gutenberg, WPBakery (Visual Composer), Divi, Beaver Builder, and all major page builders.', 'image-hover-effects-ultimate' ); ?></p>
					<div class="shortcode-examples">
						<p><strong><?php echo esc_html__( 'Example shortcode:', 'image-hover-effects-ultimate' ); ?></strong></p>
						<ul>
							<li><code>[iheu_ultimate_oxi id="1"]</code> - <?php echo esc_html__( 'Displays image hover effect with the selected design', 'image-hover-effects-ultimate' ); ?></li>
						</ul>
					</div>
				</div>
				<div class="col-image">
					<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/Intruduction/shortcode.png'; ?>" alt=""/>
				</div>
			</section>

			<div class="content-heading heading-integrations">
				<h2>
					<mark><?php echo esc_html__( 'Advanced Features', 'image-hover-effects-ultimate' ); ?></mark>
					<?php echo esc_html__( 'for Designers', 'image-hover-effects-ultimate' ); ?>
				</h2>
				<p><?php echo esc_html__( 'Take your visuals further with these powerful tools', 'image-hover-effects-ultimate' ); ?></p>
			</div>

			<div class="section-wrap">
				<section class="section-private-folders section-half">
					<div class="col-description">
						<h2><?php echo esc_html__( 'Clone & Live Preview', 'image-hover-effects-ultimate' ); ?></h2>
						<p><?php echo esc_html__( 'Clone settings of one specific image effect to apply it to another image with just one click. Save time when adding multiple images with the same style. Plus, enjoy real-time Live Preview while editing - see your customizations instantly without page refresh. This brings a great advantage for editors and designers working with multiple image galleries.', 'image-hover-effects-ultimate' ); ?></p>
					</div>
				<div class="col-image">
					<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/Intruduction/custom-icon.png'; ?>" alt=""/>
				</div>
			</section>

			<section class="section-private-folders section-half">
				<div class="col-description">
					<h2><?php echo esc_html__( 'Custom CSS & SEO-friendly', 'image-hover-effects-ultimate' ); ?></h2>
					<p><?php echo esc_html__( 'Take full control with the built-in Custom CSS option. Add your own code without touching the plugin\'s core files. Perfect for developers and designers who need unique, tailored designs. The plugin is also SEO-friendly, allowing you to add alt tags, titles, and descriptions to images. Great for eCommerce sites - easily link hover effects to social media or product pages to boost engagement.', 'image-hover-effects-ultimate' ); ?></p>
				</div>
				<div class="col-image">
					<img src="<?php echo OXI_IMAGE_HOVER_URL . 'image/getting-started/Intruduction/custom-css.png'; ?>" alt=""/>
				</div>
			</section>
			</div>

			<section class="section-conclusion section-full">
				<div class="col-description">
					<h2><?php echo esc_html__( 'Ready to Create Stunning Image Effects?', 'image-hover-effects-ultimate' ); ?></h2>
					<p><?php echo esc_html__( 'Image Hover Effects Ultimate gives you everything you need to create beautiful, interactive image galleries and effects that boost engagement and make your site stand out. Start building today!', 'image-hover-effects-ultimate' ); ?></p>
				</div>
				<div>
					<a href="admin.php?page=oxi-image-hover-ultimate" class="wpkin-btn btn-primary get-pro-btn">
						<?php echo esc_html__( 'Create Image Hover Now', 'image-hover-effects-ultimate' ); ?>
					</a>
				</div>
			</section>
		</div>
		<?php
	}
}
