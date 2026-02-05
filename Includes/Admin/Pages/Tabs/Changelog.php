<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Includes\Admin\Pages\Tabs;

class Changelog
{

	public function render()
	{

		// Full changelog array
		$logs = [
			[
				'version' => '9.11.0',
				'date' => '06-02-2026',
				'sections' => [
					'new' => [
						'Added item count display for each module in the "Image Hover" dashboard page.',
						'Added "Create New" and "Import" buttons to the Shortcode page header for better navigation.',
						'Implemented iframe-based preview for strict style isolation and better performance.',
						'Added responsive device controls (Desktop, Tablet, Mobile) with live preview scaling.',
					],
					'enhancement' => [
						'Moved inline CSS styles to the external admin stylesheet for better maintainability.',
						'Cleaned up the Shortcode page interface by removing the unused "Import Image Hover Files" box.',
						'Refined item count display logic to hide counts for extension modules.',
						'Simplified template selection by showing all available templates on the effect page, removing the need for a separate "Add More" step.',
					],
					'fix' => [
						'Restored original header text on the Shortcode page after initial layout changes.',
						'Fixed CSS specificity issues where saved styles could override live preview changes.',
						'Resolved browser event handling for numeric inputs to ensure immediate preview updates.',
						'Solved Shortcode backward compatibility issues with legacy data.',
						'Resolved Pro feature access issues with legacy license status.',
					],
				],
			],
			[
				'version' => '9.10.6',
				'date' => '21-11-2025',
				'sections' => [
					'new' => [
						'Enhanced frontend asset loader with conditional Waypoints and Touch scripts.',
						'Added cache-busting for admin assets via file modification time.',
					],
					'enhancement' => [
						'Optimized inline JS injection timing for smoother rendering.',
						'Hardened AJAX/REST flows with stricter nonce verification and safe JSON output.',
					],
					'fix' => [
						'Minor stability fixes in shortcode rendering and widget output escaping.',
						'Fixed security issue for Lightbox.',
					],
				],
			],
			[
				'version' => '9.10.5',
				'date' => '21-11-2025',
				'sections' => [
					'enhancement' => [
						'Kept initialization lightweight and deferred heavy operations to later hooks.',
					],
					'fix' => [
						'Resolved WordPress 6.7 notice "_load_textdomain_just_in_time" by initializing the plugin on init after translations load.',
						'Allowed safe HTML in Short Description by using wp_kses_post during submission, enabling <br> line breaks.',
					],
				],
			],
			[
				'version' => '9.10.4',
				'date' => '16-10-2025',
				'sections' => [
					'enhancement' => [
						'Update UI/UX.',
						'Added Getting started page.',
						'Refactored coding structure.',
						'Enhanced error handling and debugging throughout shortcode system.',
						'Improved input validation for all shortcode rendering.',
					],
					'fix' => [
						'Fixed HTML tags not rendering in Lightbox title and description fields.',
						'Fixed HTML tags not rendering in button text across all modules.',
						'Fixed Visual Composer integration - dropdown now properly passes Style ID.',
						'Fixed Widget fatal error - corrected Bootstrap class reference.',
						'Fixed Widget block editor error with proper validation.',
						'Fixed PHP 8.2 deprecation warning for dynamic properties.',
					],
				],
			],
			[
				'version' => '9.10.3',
				'date' => '15-03-2025',
				'sections' => [
					'enhancement' => [
						'Improved input sanitization and escaping throughout the plugin.',
						'Updated database queries to use $wpdb->prepare() for better security.',
						'Minor performance and code quality improvements.',
					],
					'fix' => [
						'Fixed all reported security issues.',
					],
				],
			],
			[
				'version' => '9.10.2',
				'date' => '20-12-2024',
				'sections' => [
					'fix' => [
						'Fixed Demo image not displaying issue.',
					],
				],
			],
			[
				'version' => '9.10.1',
				'date' => '05-11-2024',
				'sections' => [
					'fix' => [
						'Fixed Redirect and not allowed issue.',
					],
				],
			],
			[
				'version' => '9.10.0',
				'date' => '15-09-2024',
				'sections' => [
					'new' => [
						'Added Freemius for license.',
						'Added PSR4 Namespace and Autoloading.',
					],
					'fix' => [
						'Fixed responsive issues.',
					],
				],
			],
			[
				'version' => '9.9.7',
				'date' => '25-07-2024',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.8.',
					],
					'fix' => [
						'Fixed Shortcode listing issue.',
						'Fixed Icon displaying issue.',
					],
				],
			],
			[
				'version' => '9.9.6',
				'date' => '10-05-2024',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.7.2.',
					],
					'fix' => [
						'Fixed color change issue.',
					],
				],
			],
			[
				'version' => '9.9.5',
				'date' => '20-03-2024',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.7.',
					],
					'fix' => [
						'Fixed Data Table search issue.',
					],
				],
			],
			[
				'version' => '9.9.4',
				'date' => '15-01-2024',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.6.2.',
					],
					'fix' => [
						'Fixed Ajax Bugs.',
					],
				],
			],
			[
				'version' => '9.9.3',
				'date' => '20-11-2023',
				'sections' => [
					'enhancement' => [
						'Update Admin Ajax.',
						'Compatible with WordPress 6.4.3.',
					],
				],
			],
			[
				'version' => '9.9.1',
				'date' => '15-09-2023',
				'sections' => [
					'enhancement' => [
						'Update Admin Ajax.',
						'Compatible with WordPress 6.3.0.',
					],
				],
			],
			[
				'version' => '9.9.0',
				'date' => '05-07-2023',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.2.2.',
					],
					'fix' => [
						'Custom CSS issues.',
					],
				],
			],
			[
				'version' => '9.8.6',
				'date' => '20-05-2023',
				'sections' => [
					'enhancement' => [
						'Update Admin Ajax.',
						'Compatible with WordPress 6.2.0.',
					],
					'fix' => [
						'Solved json files issue.',
					],
				],
			],
			[
				'version' => '9.8.5',
				'date' => '10-03-2023',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.1.1.',
					],
					'fix' => [
						'Solve XSS Issues.',
					],
				],
			],
			[
				'version' => '9.8.4',
				'date' => '25-01-2023',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.0.4.',
					],
					'fix' => [
						'Solve Magnifier issues.',
					],
				],
			],
			[
				'version' => '9.8.3',
				'date' => '15-11-2022',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.0.1.',
					],
					'fix' => [
						'Solve settings issues.',
					],
				],
			],
			[
				'version' => '9.8.2',
				'date' => '20-09-2022',
				'sections' => [
					'enhancement' => [
						'Compatible with WordPress 6.0.',
					],
					'new' => [
						'Add alt tag.',
					],
					'fix' => [
						'Solve templates issues.',
					],
				],
			],
			[
				'version' => '9.8.1',
				'date' => '05-07-2022',
				'sections' => [
					'new' => [
						'Support HTML.',
						'Support Shortcode.',
					],
				],
			],
			[
				'version' => '9.8.0',
				'date' => '20-05-2022',
				'sections' => [
					'enhancement' => [
						'Modify Admin.',
						'Add Validation to render html.',
					],
				],
			],
			[
				'version' => '9.7.3',
				'date' => '10-03-2022',
				'sections' => [
					'fix' => [
						'Fixed Escape Issues.',
					],
				],
			],
			[
				'version' => '9.7.2',
				'date' => '25-01-2022',
				'sections' => [
					'new' => [
						'HTML Supported.',
					],
					'fix' => [
						'Fixed Admin Bugs.',
					],
				],
			],
			[
				'version' => '9.7.1',
				'date' => '15-11-2021',
				'sections' => [
					'enhancement' => [
						'Modify Admin Request.',
					],
				],
			],
			[
				'version' => '9.7.0',
				'date' => '20-09-2021',
				'sections' => [
					'enhancement' => [
						'Modify Admin Request.',
						'Admin Query.',
					],
				],
			],
			[
				'version' => '9.6.2',
				'date' => '10-07-2021',
				'sections' => [
					'enhancement' => [
						'Update Rest API Request.',
						'Admin Query.',
					],
				],
			],
			[
				'version' => '9.6.1',
				'date' => '25-05-2021',
				'sections' => [
					'enhancement' => [
						'Edit Clone Delete Button Modify.',
					],
					'fix' => [
						'Solved Ajax Load.',
					],
				],
			],
			[
				'version' => '9.6.0',
				'date' => '15-03-2021',
				'sections' => [
					'new' => [
						'Return Clone Button.',
						'Add Ajax Load.',
						'Dynamic Content.',
					],
				],
			],
			[
				'version' => '9.5.3',
				'date' => '20-01-2021',
				'sections' => [
					'enhancement' => [
						'Modify Oxilab Template.',
					],
					'fix' => [
						'Solved After Property.',
					],
				],
			],
			[
				'version' => '9.5.2',
				'date' => '10-11-2020',
				'sections' => [
					'new' => [
						'Add Web Import Options.',
						'View Oxilab Template.',
					],
					'enhancement' => [
						'Modify Admin Panel.',
					],
				],
			],
			[
				'version' => '9.5.1',
				'date' => '25-09-2020',
				'sections' => [
					'new' => [
						'Add JSON Import Export Options.',
					],
					'enhancement' => [
						'Regular Update.',
						'Support for 5.7.2 version.',
					],
				],
			],
			[
				'version' => '9.5.0',
				'date' => '15-07-2020',
				'sections' => [
					'new' => [
						'Add 2 new Layouts into General Effects.',
					],
					'enhancement' => [
						'Upgrade Responsive Style.',
					],
				],
			],
			[
				'version' => '9.4.3',
				'date' => '05-05-2020',
				'sections' => [
					'enhancement' => [
						'Upgrade Admin Issue.',
					],
				],
			],
			[
				'version' => '9.4.1',
				'date' => '20-03-2020',
				'sections' => [
					'enhancement' => [
						'Upgrade Admin Issue.',
					],
					'fix' => [
						'Extension Bugs.',
					],
				],
			],
			[
				'version' => '9.4.0',
				'date' => '10-01-2020',
				'sections' => [
					'enhancement' => [
						'Upgrade Docs Issue.',
					],
					'fix' => [
						'Carousel Bugs.',
					],
				],
			],
			[
				'version' => '9.3.4',
				'date' => '25-11-2019',
				'sections' => [
					'enhancement' => [
						'Upgrade Nested CSS Issue.',
					],
					'fix' => [
						'Fixed Extension Bugs.',
					],
				],
			],
			[
				'version' => '9.3.3',
				'date' => '15-09-2019',
				'sections' => [
					'enhancement' => [
						'Upgrade Visual Composer Issues.',
					],
					'fix' => [
						'Fixed Bugs.',
					],
				],
			],
			[
				'version' => '9.3.2',
				'date' => '05-07-2019',
				'sections' => [
					'enhancement' => [
						'Upgrade Modules.',
					],
				],
			],
			[
				'version' => '9.3.1',
				'date' => '20-05-2019',
				'sections' => [
					'enhancement' => [
						'Upgrade Database Issue.',
					],
				],
			],
			[
				'version' => '9.3',
				'date' => '10-03-2019',
				'sections' => [
					'new' => [
						'New Admin panel.',
						'8 type of Effects.',
					],
				],
			],
			[
				'version' => '9.2',
				'date' => '25-01-2019',
				'sections' => [
					'fix' => [
						'Fixed Bugs.',
					],
				],
			],
			[
				'version' => '9.1',
				'date' => '15-11-2018',
				'sections' => [
					'fix' => [
						'Fixed Bugs with page builders.',
					],
				],
			],
			[
				'version' => '9.0',
				'date' => '05-09-2018',
				'sections' => [
					'fix' => [
						'Fixed Bugs with Update Admin.',
					],
				],
			],
			[
				'version' => '8.9',
				'date' => '20-07-2018',
				'sections' => [
					'fix' => [
						'Fixed with Gutenberg.',
					],
				],
			],
			[
				'version' => '8.8',
				'date' => '10-05-2018',
				'sections' => [
					'new' => [
						'Added Font Awesome upto 7.1.',
					],
					'fix' => [
						'Fixed Bugs.',
					],
				],
			],
			[
				'version' => '8.7',
				'date' => '25-03-2018',
				'sections' => [
					'fix' => [
						'Fixed Bugs.',
					],
				],
			],
			[
				'version' => '8.6',
				'date' => '15-01-2018',
				'sections' => [
					'new' => [
						'Added Font Awesome 5.5.',
					],
					'fix' => [
						'Fixed Bugs.',
					],
				],
			],
			[
				'version' => '8.5',
				'date' => '20-11-2017',
				'sections' => [
					'fix' => [
						'Fixed Bugs.',
					],
				],
			],
			[
				'version' => '8.4',
				'date' => '10-09-2017',
				'sections' => [
					'fix' => [
						'Fixed Bugs.',
					],
				],
			],
			[
				'version' => '8.3',
				'date' => '25-07-2017',
				'sections' => [
					'new' => [
						'Add image Rearrange Options.',
					],
					'enhancement' => [
						'Update font Awesome.',
					],
				],
			],
			[
				'version' => '8.2',
				'date' => '15-05-2017',
				'sections' => [
					'new' => [
						'Add Mobile or Touch Device Behavior.',
					],
					'fix' => [
						'Solved Some Responsive Data.',
					],
				],
			],
			[
				'version' => '8.1',
				'date' => '05-03-2017',
				'sections' => [
					'new' => [
						'Add License Option.',
						'User Capabilities.',
					],
				],
			],
			[
				'version' => '8.0',
				'date' => '20-01-2017',
				'sections' => [
					'enhancement' => [
						'Customize Responsive Data.',
					],
				],
			],
		];
?>

		<div id="what-new" class="content-what-new">
			<div class="content-heading">
				<h2>
					<?php echo __('Exploring the', 'image-hover-effects-ultimate'); ?>
					<mark><?php echo __('Latest Updates', 'image-hover-effects-ultimate'); ?></mark>
				</h2>
				<p>
					<?php echo __('Dive into the recent changelog for fresh insights about new features and improvements.', 'image-hover-effects-ultimate'); ?>
				</p>
			</div>

			<?php foreach ($logs as $log) : ?>
				<div class="log">
					<div class="log-header" style="cursor:pointer;">
						<span class="log-version"><?php echo esc_html($log['version']); ?></span>
						<span class="log-date">(<?php echo esc_html($log['date']); ?>)</span>
						<i class="dashicons dashicons-arrow-down-alt2"></i>
					</div>
					<div class="log-body" style="display:none;">
						<?php foreach ($log['sections'] as $section => $items) : ?>
							<div class="log-section <?php echo esc_attr($section); ?>">
								<h3>
									<?php
									$section_titles = [
										'new' => __('New Features', 'image-hover-effects-ultimate'),
										'fix' => __('Bug Fixes', 'image-hover-effects-ultimate'),
										'enhancement' => __('Improvements', 'image-hover-effects-ultimate'),
										'remove' => __('Deprecations', 'image-hover-effects-ultimate'),
									];
									echo $section_titles[$section];
									?>
								</h3>
								<?php foreach ($items as $item) : ?>
									<div class="log-item log-item-<?php echo esc_attr($section); ?>">
										<?php
										$section_icons = [
											'new' => 'dashicons-plus-alt2',
											'fix' => 'dashicons-saved',
											'enhancement' => 'dashicons-star-filled',
											'remove' => 'dashicons-trash',
										];
										?>
										<i class="dashicons <?php echo esc_attr($section_icons[$section]); ?>"></i>
										<?php echo esc_html($item); ?>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

<?php
	}
}
