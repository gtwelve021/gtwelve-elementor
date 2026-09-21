<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Business_Package_Cards extends Widget_Base {
	public function get_name(): string {
		return 'g12_business_package_cards';
	}

	public function get_title(): string {
		return esc_html__( 'Business Package Cards', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-price-table';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'package', 'packages', 'pricing', 'price', 'business setup', 'cards' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-business-package-cards' );
	}

	public function get_script_depends(): array {
		return array( 'gtwelve-elementor-business-package-cards' );
	}

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls(): void {
		$this->start_controls_section(
			'section_packages',
			array(
				'label' => esc_html__( 'Packages', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'packages_title',
			array(
				'label'       => esc_html__( 'Package Title', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Mainland Package', 'gtwelve-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'name_of_package',
			array(
				'label'       => esc_html__( 'Package Name', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Essential', 'gtwelve-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'prefix_price',
			array(
				'label'   => esc_html__( 'Price Prefix', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Starting from', 'gtwelve-elementor' ),
			)
		);

		$repeater->add_control(
			'packages_price',
			array(
				'label'   => esc_html__( 'Price', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '12,500',
			)
		);

		$repeater->add_control(
			'feature_list',
			array(
				'label'       => esc_html__( 'Features', 'gtwelve-elementor' ),
				'description' => esc_html__( 'Enter one feature per line.', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => "Trade license\nInitial approval\nBusiness name reservation\nDedicated setup support",
				'rows'        => 6,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'link_label',
			array(
				'label'   => esc_html__( 'Button Text', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Get started', 'gtwelve-elementor' ),
			)
		);

		$repeater->add_control(
			'package_link',
			array(
				'label'         => esc_html__( 'Button Link', 'gtwelve-elementor' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => 'https://example.com',
				'show_external' => true,
				'default'       => array(
					'url' => '#',
				),
			)
		);

		$this->add_control(
			'packages',
			array(
				'label'       => esc_html__( 'Packages', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ packages_title }}}',
				'default'     => $this->get_default_packages(),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_features',
			array(
				'label' => esc_html__( 'Image Features', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$image_feature_repeater = new Repeater();

		$image_feature_repeater->add_control(
			'package_number',
			array(
				'label'       => esc_html__( 'Package Number', 'gtwelve-elementor' ),
				'description' => esc_html__( 'Use 1 for the first package, 2 for the second package, and so on.', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 1,
				'step'        => 1,
				'default'     => 1,
			)
		);

		$image_feature_repeater->add_control(
			'image',
			array(
				'label' => esc_html__( 'Image', 'gtwelve-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$image_feature_repeater->add_control(
			'feature_text',
			array(
				'label'       => esc_html__( 'Text', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Split payment into instalments', 'gtwelve-elementor' ),
				'rows'        => 2,
				'label_block' => true,
			)
		);

		$this->add_control(
			'image_features',
			array(
				'label'       => esc_html__( 'Image Features', 'gtwelve-elementor' ),
				'description' => esc_html__( 'Add each image feature here, then select which package should display it.', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $image_feature_repeater->get_controls(),
				'default'     => array(),
				'title_field' => '{{{ feature_text }}}',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_controls(): void {
		$this->start_controls_section(
			'section_layout_style',
			array(
				'label' => esc_html__( 'Layout', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards' => '--g12-package-columns: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_gap',
			array(
				'label'      => esc_html__( 'Card Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 8, 'max' => 80 ),
				),
				'default'    => array( 'size' => 32, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-package-cards' => '--g12-package-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'section_padding',
			array(
				'label'      => esc_html__( 'Section Padding', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-package-cards' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_style',
			array(
				'label' => esc_html__( 'Cards', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'card_background',
			array(
				'label'     => esc_html__( 'Card Background', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards' => '--g12-package-card-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ab8134',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards' => '--g12-package-border: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
				'default'    => array( 'size' => 8, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-package-cards' => '--g12-package-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'header_color_start',
			array(
				'label'     => esc_html__( 'Header Gradient Start', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d6a456',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards' => '--g12-package-header-start: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'header_color_end',
			array(
				'label'     => esc_html__( 'Header Gradient End', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ab8134',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards' => '--g12-package-header-end: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_title_color',
			array(
				'label'     => esc_html__( 'Package Title Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__card-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'label'    => esc_html__( 'Package Title Typography', 'gtwelve-elementor' ),
				'selector' => '{{WRAPPER}} .g12-package-cards__card-title',
			)
		);

		$this->add_control(
			'package_name_color',
			array(
				'label'     => esc_html__( 'Package Name Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__package-name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price_features_style',
			array(
				'label' => esc_html__( 'Price & Features', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'price_prefix_color',
			array(
				'label'     => esc_html__( 'Price Prefix Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#71717a',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__price-prefix' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Price Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__price-value' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'label'    => esc_html__( 'Price Typography', 'gtwelve-elementor' ),
				'selector' => '{{WRAPPER}} .g12-package-cards__price-value',
			)
		);

		$this->add_control(
			'feature_color',
			array(
				'label'     => esc_html__( 'Feature Text Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__feature-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'feature_icon_color',
			array(
				'label'     => esc_html__( 'Check Icon Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d6a557',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__check' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'feature_typography',
				'label'    => esc_html__( 'Feature Typography', 'gtwelve-elementor' ),
				'selector' => '{{WRAPPER}} .g12-package-cards__feature-text',
			)
		);

		$this->add_control(
			'image_feature_heading',
			array(
				'label'     => esc_html__( 'Image Features', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'image_feature_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__image-feature-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'image_feature_typography',
				'label'    => esc_html__( 'Typography', 'gtwelve-elementor' ),
				'selector' => '{{WRAPPER}} .g12-package-cards__image-feature-text',
			)
		);

		$this->add_responsive_control(
			'image_feature_logo_width',
			array(
				'label'      => esc_html__( 'Image Width', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array( 'min' => 16, 'max' => 160 ),
					'%'  => array( 'min' => 5, 'max' => 50 ),
				),
				'default'    => array( 'size' => 40, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-package-cards__image-feature-image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_feature_column_gap',
			array(
				'label'      => esc_html__( 'Image to Text Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array( 'min' => 0, 'max' => 60 ),
					'em'  => array( 'min' => 0, 'max' => 4, 'step' => 0.1 ),
					'rem' => array( 'min' => 0, 'max' => 4, 'step' => 0.1 ),
				),
				'default'    => array( 'size' => 12, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-package-cards__image-feature' => 'column-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_feature_row_gap',
			array(
				'label'      => esc_html__( 'Row Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px'  => array( 'min' => 0, 'max' => 60 ),
					'em'  => array( 'min' => 0, 'max' => 4, 'step' => 0.1 ),
					'rem' => array( 'min' => 0, 'max' => 4, 'step' => 0.1 ),
				),
				'default'    => array( 'size' => 8, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-package-cards__image-feature' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__( 'Button', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .g12-package-cards__button',
			)
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		$this->start_controls_tab(
			'button_normal_tab',
			array( 'label' => esc_html__( 'Normal', 'gtwelve-elementor' ) )
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background',
			array(
				'label'     => esc_html__( 'Background Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d6a557',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'button_hover_tab',
			array( 'label' => esc_html__( 'Hover', 'gtwelve-elementor' ) )
		);

		$this->add_control(
			'button_hover_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__button:hover, {{WRAPPER}} .g12-package-cards__button:focus-visible' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_background',
			array(
				'label'     => esc_html__( 'Background Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ab8134',
				'selectors' => array(
					'{{WRAPPER}} .g12-package-cards__button:hover, {{WRAPPER}} .g12-package-cards__button:focus-visible' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'button_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 40 ) ),
				'default'    => array( 'size' => 5, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-package-cards__button' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$packages = $settings['packages'] ?? array();
		$all_image_features = isset( $settings['image_features'] ) && is_array( $settings['image_features'] ) ? $settings['image_features'] : array();

		if ( empty( $packages ) ) {
			return;
		}

		$slider_id = 'g12-package-cards-slider-' . $this->get_id();
		?>
		<section class="g12-package-cards" data-g12-package-cards>
			<div class="g12-package-cards__viewport" data-g12-package-viewport>
				<div class="g12-package-cards__track">
					<?php foreach ( $packages as $index => $package ) : ?>
						<?php
						$features = $this->get_feature_lines( $package['feature_list'] ?? '' );
						$package_number = $index + 1;
						$image_features = array_values(
							array_filter(
								$all_image_features,
								static fn( array $image_feature ): bool => $package_number === max( 1, (int) ( $image_feature['package_number'] ?? 1 ) )
							)
						);
						if ( empty( $image_features ) && isset( $package['image_features'] ) && is_array( $package['image_features'] ) ) {
							$image_features = $package['image_features'];
						}
						$image_features = array_values(
							array_filter(
								$image_features,
								static fn( array $image_feature ): bool => '' !== ( $image_feature['image']['url'] ?? '' ) || '' !== trim( (string) ( $image_feature['feature_text'] ?? '' ) )
							)
						);
						$link_key = 'package_link_' . $index;
						if ( ! empty( $package['package_link']['url'] ) ) {
							$this->add_link_attributes( $link_key, $package['package_link'] );
							$this->add_render_attribute( $link_key, 'class', 'g12-package-cards__button' );
						}
						?>
						<article class="g12-package-cards__card">
							<div class="g12-package-cards__card-header">
								<?php if ( ! empty( $package['packages_title'] ) ) : ?>
									<h3 class="g12-package-cards__card-title"><?php echo esc_html( $package['packages_title'] ); ?></h3>
								<?php endif; ?>
				<?php if ( ! empty( $package['name_of_package'] ) ) : ?>
					<p class="g12-package-cards__package-name"><?php echo wp_kses( nl2br( (string) $package['name_of_package'], false ), array( 'br' => array() ) ); ?></p>
				<?php endif; ?>
							</div>

							<div class="g12-package-cards__price">
								<?php if ( ! empty( $package['prefix_price'] ) ) : ?>
									<p class="g12-package-cards__price-prefix"><?php echo esc_html( $package['prefix_price'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $package['packages_price'] ) ) : ?>
									<p class="g12-package-cards__price-value">
										<img class="g12-package-cards__currency" src="<?php echo esc_url( GTWELVE_ELEMENTOR_URL . 'assets/img/UAE_Dirham_Symbol.svg' ); ?>" alt="<?php echo esc_attr__( 'UAE Dirham', 'gtwelve-elementor' ); ?>" width="28" height="25">
										<span><?php echo esc_html( $package['packages_price'] ); ?></span>
									</p>
								<?php endif; ?>
							</div>

							<?php if ( ! empty( $features ) || ! empty( $image_features ) ) : ?>
								<div class="g12-package-cards__features">
									<ul>
										<?php foreach ( $features as $feature ) : ?>
											<li>
												<svg class="g12-package-cards__check" aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>
												<span class="g12-package-cards__feature-text"><?php echo esc_html( $feature ); ?></span>
											</li>
										<?php endforeach; ?>
										<?php foreach ( $image_features as $image_feature ) : ?>
											<?php
											$image_url = $image_feature['image']['url'] ?? '';
											$image_text = trim( (string) ( $image_feature['feature_text'] ?? '' ) );
											?>
											<li class="g12-package-cards__image-feature<?php echo '' === $image_url ? ' g12-package-cards__image-feature--text-only' : ''; ?>">
												<?php if ( '' !== $image_url ) : ?>
													<img class="g12-package-cards__image-feature-image" src="<?php echo esc_url( $image_url ); ?>" alt="" loading="lazy" decoding="async">
												<?php endif; ?>
												<?php if ( '' !== $image_text ) : ?>
													<span class="g12-package-cards__image-feature-text"><?php echo esc_html( $image_text ); ?></span>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $package['link_label'] ) && ! empty( $package['package_link']['url'] ) ) : ?>
								<div class="g12-package-cards__button-wrap">
									<a <?php echo $this->get_render_attribute_string( $link_key ); ?>><?php echo esc_html( $package['link_label'] ); ?></a>
								</div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if ( count( $packages ) > 1 ) : ?>
				<div class="g12-package-cards__slider-wrap" data-g12-package-slider-wrap>
					<label class="g12-package-cards__slider-label" for="<?php echo esc_attr( $slider_id ); ?>"><?php echo esc_html__( 'Package carousel slider control', 'gtwelve-elementor' ); ?></label>
					<input id="<?php echo esc_attr( $slider_id ); ?>" class="g12-package-cards__slider" data-g12-package-slider type="range" min="0" max="500" value="0">
				</div>
			<?php endif; ?>
		</section>
		<?php
	}

	private function get_feature_lines( string $features ): array {
		$lines = preg_split( '/\r\n|\r|\n/', $features );

		if ( ! is_array( $lines ) ) {
			return array();
		}

		return array_values(
			array_filter(
				array_map( 'trim', $lines ),
				static fn( string $line ): bool => '' !== $line
			)
		);
	}

	private function get_default_packages(): array {
		return array(
			array(
				'packages_title' => esc_html__( 'Mainland Package', 'gtwelve-elementor' ),
				'name_of_package' => esc_html__( 'Essential', 'gtwelve-elementor' ),
				'prefix_price' => esc_html__( 'Starting from', 'gtwelve-elementor' ),
				'packages_price' => '12,500',
				'feature_list' => "Trade license\nInitial approval\nBusiness name reservation\nDedicated setup support",
				'link_label' => esc_html__( 'Get started', 'gtwelve-elementor' ),
				'package_link' => array( 'url' => '#' ),
			),
			array(
				'packages_title' => esc_html__( 'Free Zone Package', 'gtwelve-elementor' ),
				'name_of_package' => esc_html__( 'Professional', 'gtwelve-elementor' ),
				'prefix_price' => esc_html__( 'Starting from', 'gtwelve-elementor' ),
				'packages_price' => '18,500',
				'feature_list' => "Trade license\nEstablishment card\nInvestor visa eligibility\nDedicated setup support",
				'link_label' => esc_html__( 'Get started', 'gtwelve-elementor' ),
				'package_link' => array( 'url' => '#' ),
			),
			array(
				'packages_title' => esc_html__( 'Complete Package', 'gtwelve-elementor' ),
				'name_of_package' => esc_html__( 'Premium', 'gtwelve-elementor' ),
				'prefix_price' => esc_html__( 'Starting from', 'gtwelve-elementor' ),
				'packages_price' => '24,500',
				'feature_list' => "Trade license\nEstablishment card\nInvestor visa processing\nBank account assistance",
				'link_label' => esc_html__( 'Get started', 'gtwelve-elementor' ),
				'package_link' => array( 'url' => '#' ),
			),
		);
	}
}
