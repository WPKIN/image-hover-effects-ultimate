<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes\Admin\Pages\Tabs;

class GetPro {

    public function render() {

        // Feature array
        $features = [
            'Design Features' => [
                [
					'title' => '150+ Free Hover Effect Styles',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => '500+ Premium Hover Effect Styles',
					'free' => false,
					'pro' => true,
				],
                [
					'title' => 'General Effects Module (33 styles)',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Caption Effects Module (31 styles)',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Flipbox Effects Module (29 styles)',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Button Effects Module (11 styles)',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Square Effects Module (22 styles)',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Custom Background Colors & Gradients',
					'free' => false,
					'pro' => true,
				],
                [
					'title' => 'Advanced Hover Animations',
					'free' => true,
					'pro' => true,
				],
            ],
            'Extension Modules' => [
                [
					'title' => 'Carousel/Slider Extension',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Image Lightbox Extension',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Image Comparison Extension',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Image Magnifier Extension',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Filter/Sorting Extension',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Display Post Extension',
					'free' => true,
					'pro' => true,
				],
            ],
            'Content Features' => [
                [
					'title' => 'Custom Titles & Descriptions',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Custom Fonts & Typography (650+ Google Fonts)',
					'free' => false,
					'pro' => true,
				],
                [
					'title' => 'Unlimited Image Hover Effects',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Custom Links & Call To Action Buttons',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Clone Image Settings',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Live Preview',
					'free' => true,
					'pro' => true,
				],
            ],
            'Integrations' => [
                [
					'title' => 'Gutenberg Block Support',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Elementor Integration',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'WPBakery (Visual Composer) Integration',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Divi Builder Integration',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Beaver Builder Integration',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'SiteOrigin Integration',
					'free' => true,
					'pro' => true,
				],
            ],
            'Styling Options' => [
                [
					'title' => 'Custom Border & Shadow Settings',
					'free' => false,
					'pro' => true,
				],
                [
					'title' => 'Image Alignment Options',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Custom CSS Editor',
					'free' => false,
					'pro' => true,
				],
				[
					'title' => 'Image Padding & Margin Control',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Animation Duration Control',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Hover Background Image',
					'free' => true,
					'pro' => true,
				],
            ],
            'Advanced Features' => [
                [
					'title' => 'Responsive Layout Settings',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Touch Enable for Mobile',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'SEO-friendly (Alt Tags, Titles)',
					'free' => true,
					'pro' => true,
				],
				[
					'title' => 'Image Hover Cache',
					'free' => false,
					'pro' => true,
				],
				[
					'title' => 'Auto-resizing for Images',
					'free' => true,
					'pro' => true,
				],
            ],
            'Support & Updates' => [
                [
					'title' => 'Documentation Access',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Community Support (WordPress.org)',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Premium Support',
					'free' => false,
					'pro' => true,
				],
                [
					'title' => 'Regular Updates',
					'free' => true,
					'pro' => true,
				],
                [
					'title' => 'Priority Feature Requests',
					'free' => false,
					'pro' => true,
				],
				[
					'title' => 'Video Tutorials',
					'free' => true,
					'pro' => true,
				],
            ],
        ];
        ?>

        <div id="get-pro" class="getting-started-content content-get-pro active">
            <div class="content-heading">
                <h2>
                    <mark><?php echo __( 'Enhance Your Image Galleries', 'image-hover-effects-ultimate' ); ?></mark>
                    <?php echo __( 'with Image Hover Effects PRO', 'image-hover-effects-ultimate' ); ?>
                </h2>
                <p><?php echo __( 'Unlock 500+ premium hover effects, advanced animations, and extensive customization options to create stunning image galleries and effects that engage your visitors.', 'image-hover-effects-ultimate' ); ?></p>
                <a href="https://wpkindemos.com/imagehover/pricing/" class="wpkin-btn btn-primary get-pro-btn" target="_blank" rel="noopener noreferrer">
                    <i class="dashicons dashicons-awards"></i> <?php echo __( 'Get PRO Now', 'image-hover-effects-ultimate' ); ?>
                </a>
            </div>

            <div class="content-heading free-vs-pro">
                <h2><?php echo __( 'Compare Features', 'image-hover-effects-ultimate' ); ?></h2>
                <div class="free-vs-pro-wrap">
                    <span><?php echo __( 'FREE', 'image-hover-effects-ultimate' ); ?></span>
                    <?php echo __( 'vs', 'image-hover-effects-ultimate' ); ?>
                    <span><?php echo __( 'PRO', 'image-hover-effects-ultimate' ); ?></span>
                </div>
                <p><?php echo __( 'The PRO version unlocks 500+ premium hover effects, advanced customization, multiple extension modules, and integrations to make your image galleries more attractive and professional.', 'image-hover-effects-ultimate' ); ?></p>
            </div>

            <div class="features-list">
                <div class="list-header">
                    <div class="feature-title"><?php echo __( 'Feature List', 'image-hover-effects-ultimate' ); ?></div>
                    <div class="feature-free"><?php echo __( 'Free', 'image-hover-effects-ultimate' ); ?></div>
                    <div class="feature-pro"><?php echo __( 'Pro', 'image-hover-effects-ultimate' ); ?></div>
                </div>

                <?php foreach ( $features as $section => $items ) : ?>
                    <div class="feature feature-heading">
                        <div class="feature-title"><?php echo esc_html__( $section, 'image-hover-effects-ultimate' ); ?></div>
                        <div class="feature-free"></div>
                        <div class="feature-pro"></div>
                    </div>
                    <?php foreach ( $items as $feature ) : ?>
                        <div class="feature">
                            <div class="feature-title"><?php echo esc_html__( $feature['title'], 'image-hover-effects-ultimate' ); ?></div>
                            <div class="feature-free">
                                <i class="dashicons <?php echo $feature['free'] ? 'dashicons-saved' : 'dashicons-no-alt'; ?>"></i>
                            </div>
                            <div class="feature-pro">
                                <i class="dashicons <?php echo $feature['pro'] ? 'dashicons-saved' : 'dashicons-no-alt'; ?>"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>

            <div class="get-pro-cta">
                <div class="cta-content">
                    <h2><?php echo __( 'Create Stunning Image Effects with', 'image-hover-effects-ultimate' ); ?> <mark><?php echo __( 'Image Hover Effects PRO', 'image-hover-effects-ultimate' ); ?></mark></h2>
                    <p><?php echo __( 'Upgrade to PRO and unlock 500+ premium hover effects, 10+ extension modules, advanced customization, and premium support to transform your website visuals and image galleries.', 'image-hover-effects-ultimate' ); ?></p>
                </div>
                <div class="cta-btn">
                    <a href="https://wpkindemos.com/imagehover/pricing/" class="wpkin-btn btn-primary" target="_blank" rel="noopener noreferrer">
                        <i class="dashicons dashicons-cart"></i> <?php echo __( 'Upgrade Now', 'image-hover-effects-ultimate' ); ?>
                    </a>
                </div>
            </div>
        </div>

        <?php
    }
}
