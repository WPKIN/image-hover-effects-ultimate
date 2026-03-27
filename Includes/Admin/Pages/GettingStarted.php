<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes\Admin\Pages;

/**
 * Description of GettingStarted
 *
 * @author Richard
 */
class GettingStarted
{

	public function __construct()
	{
		$this->Public_Render();
	}

	public function Public_Render()
	{
?>
	<div class="oxi-gs-wrap">
		<div class="oxi-gs-header">
			<h1><?php esc_html_e( 'Welcome to Image Hover Effects Ultimate', 'image-hover-effects-ultimate' ); ?></h1>
			<p><?php esc_html_e( "Thank you for installing Image Hover Effects Ultimate. Let's start creating stunning hover effects!", 'image-hover-effects-ultimate' ); ?></p>
		</div>

		<div class="oxi-gs-video-wrap">
			<div class="oxi-gs-video">
				<iframe src="https://www.youtube.com/embed/SGHeoNPogbE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		</div>
	</div>
	<div class="oxi-gs-cards-wrap">
		<div class="oxi-gs-cards">

			<div class="oxi-gs-card">
				<div class="oxi-gs-card-icon">
					<span class="dashicons dashicons-media-document"></span>
				</div>
				<h3><?php esc_html_e( 'Documentation', 'image-hover-effects-ultimate' ); ?></h3>
				<p><?php esc_html_e( 'Get started by spending some time with the documentation to get familiar with Image Hover Effects. Build awesome hover effects for you or your clients with ease.', 'image-hover-effects-ultimate' ); ?></p>
				<a href="https://oxilab.dev/docs/image-hover-effects/" class="oxi-gs-btn" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Documentation', 'image-hover-effects-ultimate' ); ?>
				</a>
			</div>

			<div class="oxi-gs-card">
				<div class="oxi-gs-card-icon">
					<span class="dashicons dashicons-thumbs-up"></span>
				</div>
				<h3><?php esc_html_e( 'Contribute to Image Hover Effects', 'image-hover-effects-ultimate' ); ?></h3>
				<p><?php esc_html_e( 'You can contribute to make Image Hover Effects better by reporting bugs & creating issues. Our development team always tries to make more powerful plugins with solved issues.', 'image-hover-effects-ultimate' ); ?></p>
				<a href="https://oxilab.dev/support/" class="oxi-gs-btn" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Report a Bug', 'image-hover-effects-ultimate' ); ?>
				</a>
			</div>

			<div class="oxi-gs-card">
				<div class="oxi-gs-card-icon">
					<span class="dashicons dashicons-video-alt3"></span>
				</div>
				<h3><?php esc_html_e( 'Video Tutorials', 'image-hover-effects-ultimate' ); ?></h3>
				<p><?php esc_html_e( "Unable to use Image Hover Effects Ultimate? Don't worry, you can check our video tutorials to make it easier to use.", 'image-hover-effects-ultimate' ); ?></p>
				<a href="https://www.youtube.com/@oxilabdev" class="oxi-gs-btn" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Video Tutorials', 'image-hover-effects-ultimate' ); ?>
				</a>
			</div>

			<div class="oxi-gs-card">
				<div class="oxi-gs-card-icon">
					<span class="dashicons dashicons-phone"></span>
				</div>
				<h3><?php esc_html_e( 'Support', 'image-hover-effects-ultimate' ); ?></h3>
				<p><?php esc_html_e( "Do you need our support? Don't worry, our experienced developer will help you.", 'image-hover-effects-ultimate' ); ?></p>
				<a href="https://wordpress.org/support/plugin/image-hover-effects-ultimate/#new-post" class="oxi-gs-btn" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Get Support', 'image-hover-effects-ultimate' ); ?>
				</a>
			</div>

		</div>
	</div>
<?php
	}
}
