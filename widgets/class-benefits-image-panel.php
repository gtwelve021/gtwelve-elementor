<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Benefits_Image_Panel extends Widget_Base {
	public function get_name(): string {
		return 'g12_benefits_image_panel';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Benefits Image Panel', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-image-box';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'benefits', 'requirements', 'image', 'list', 'eligibility', 'visa', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-benefits-image-panel' );
	}

	protected function register_controls(): void {
		$this->register_showcase_controls();
		$this->register_layout_style_controls();
		$this->register_benefits_style_controls();
		$this->register_panel_style_controls();
	}

	private function register_showcase_controls(): void {
		$this->start_controls_section( 'showcase_section', array( 'label' => esc_html__( 'Benefits and Eligibility', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_CONTENT ) );

		$benefit = new Repeater();
		$benefit->add_control( 'label', array( 'label' => esc_html__( 'Benefit', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'label_block' => true, 'default' => esc_html__( 'Long-term residency', 'gtwelve-elementor' ) ) );
		$this->add_control(
			'benefits',
			array(
				'label'       => esc_html__( 'Benefit Labels', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $benefit->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => $this->get_default_benefits(),
			)
		);

		$this->add_control( 'desktop_image', array( 'label' => esc_html__( 'Desktop Image', 'gtwelve-elementor' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => 'https://g12.ae/wp-content/uploads/2025/03/Golden-Visa-Composition.avif' ) ) );
		$this->add_control( 'mobile_image', array( 'label' => esc_html__( 'Mobile Image', 'gtwelve-elementor' ), 'type' => Controls_Manager::MEDIA, 'description' => esc_html__( 'Optional. The desktop image is used when empty.', 'gtwelve-elementor' ), 'default' => array( 'url' => 'https://g12.ae/wp-content/uploads/2025/03/Golden-Visa-Section-responsive.avif' ) ) );
		$this->add_control( 'image_alt', array( 'label' => esc_html__( 'Image Alt Text', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'label_block' => true, 'default' => esc_html__( 'UAE Golden Visa', 'gtwelve-elementor' ) ) );
		$this->add_control( 'panel_title', array( 'label' => esc_html__( 'Panel Title', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'label_block' => true, 'default' => esc_html__( 'WHO CAN APPLY?', 'gtwelve-elementor' ) ) );

		$point = new Repeater();
		$point->add_control( 'text', array( 'label' => esc_html__( 'Eligibility Point', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'label_block' => true, 'default' => esc_html__( 'Add an eligibility requirement', 'gtwelve-elementor' ) ) );
		$this->add_control(
			'eligibility_points',
			array(
				'label'       => esc_html__( 'Eligibility Points', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $point->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => $this->get_default_points(),
			)
		);
		$this->end_controls_section();
	}

	private function register_layout_style_controls(): void {
		$this->start_controls_section( 'layout_style', array( 'label' => esc_html__( 'Layout and Image', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'max_width', array( 'label' => esc_html__( 'Maximum Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 700, 'max' => 1800 ), '%' => array( 'min' => 60, 'max' => 100 ) ), 'default' => array( 'size' => 1280, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'stage_min_height', array( 'label' => esc_html__( 'Showcase Minimum Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 400, 'max' => 1200 ) ), 'default' => array( 'size' => 820, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 720, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__stage' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'image_width', array( 'label' => esc_html__( 'Image Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( '%', 'px' ), 'range' => array( '%' => array( 'min' => 30, 'max' => 90 ), 'px' => array( 'min' => 200, 'max' => 1000 ) ), 'default' => array( 'size' => 55, 'unit' => '%' ), 'mobile_default' => array( 'size' => 78, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__visual' => 'width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'image_bottom_spacing', array( 'label' => esc_html__( 'Image Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 200 ) ), 'default' => array( 'size' => 0, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__visual' => 'bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_benefits_style_controls(): void {
		$this->start_controls_section( 'benefits_style', array( 'label' => esc_html__( 'Benefit Labels', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'benefit_text_color', array( 'label' => esc_html__( 'Text Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#111111', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__benefit-label' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'benefit_background', array( 'label' => esc_html__( 'Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__benefit-label' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'benefit_border_color', array( 'label' => esc_html__( 'Border Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#d6a557', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__benefit-label' => 'border-color: {{VALUE}};' ) ) );
		$this->add_control( 'connector_color', array( 'label' => esc_html__( 'Connector Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#bab7b7', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__connector' => 'background: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'benefit_typography', 'selector' => '{{WRAPPER}} .g12-benefits-panel__benefit-label' ) );
		$this->add_responsive_control( 'benefit_gap', array( 'label' => esc_html__( 'Vertical Gap', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 4, 'max' => 60 ) ), 'default' => array( 'size' => 20, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 10, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__benefits' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'benefit_padding', array( 'label' => esc_html__( 'Label Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 6, 'right' => 18, 'bottom' => 6, 'left' => 18, 'unit' => 'px', 'isLinked' => false ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__benefit-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_panel_style_controls(): void {
		$this->start_controls_section( 'panel_style', array( 'label' => esc_html__( 'Eligibility Panel', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'panel_background', array( 'label' => esc_html__( 'Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#000000', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__eligibility' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'panel_title_color', array( 'label' => esc_html__( 'Title Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__panel-title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'panel_title_typography', 'selector' => '{{WRAPPER}} .g12-benefits-panel__panel-title' ) );
		$this->add_control( 'point_color', array( 'label' => esc_html__( 'Point Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#bababa', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__point' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'star_color', array( 'label' => esc_html__( 'Star Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#facc15', 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__star' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'point_typography', 'selector' => '{{WRAPPER}} .g12-benefits-panel__point' ) );
		$this->add_responsive_control( 'panel_width', array( 'label' => esc_html__( 'Panel Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( '%', 'px' ), 'range' => array( '%' => array( 'min' => 40, 'max' => 100 ), 'px' => array( 'min' => 300, 'max' => 1200 ) ), 'default' => array( 'size' => 72, 'unit' => '%' ), 'mobile_default' => array( 'size' => 100, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__eligibility' => 'width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'panel_padding', array( 'label' => esc_html__( 'Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 36, 'right' => 42, 'bottom' => 36, 'left' => 42, 'unit' => 'px', 'isLinked' => false ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__eligibility' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_group_control( Group_Control_Border::get_type(), array( 'name' => 'panel_border', 'selector' => '{{WRAPPER}} .g12-benefits-panel__eligibility' ) );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array( 'name' => 'panel_shadow', 'selector' => '{{WRAPPER}} .g12-benefits-panel__eligibility' ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$benefits = $settings['benefits'] ?? array();
		$points   = $settings['eligibility_points'] ?? array();

		if ( empty( $benefits ) && empty( $points ) ) {
			return;
		}

		$desktop_url = $settings['desktop_image']['url'] ?? '';
		$mobile_url  = $settings['mobile_image']['url'] ?? '';

		// Migrate the original widget default, which incorrectly used the mobile crop on desktop.
		if ( 'https://g12.ae/wp-content/uploads/2025/03/Golden-Visa-Section-responsive.avif' === $desktop_url ) {
			$desktop_url = 'https://g12.ae/wp-content/uploads/2025/03/Golden-Visa-Composition.avif';
		}
		?>

		<div class="g12-benefits-panel">
			<div class="g12-benefits-panel__stage">
				<?php if ( ! empty( $benefits ) ) : ?>
					<ul class="g12-benefits-panel__benefits">
						<?php foreach ( $benefits as $benefit ) : ?>
							<li class="g12-benefits-panel__benefit elementor-repeater-item-<?php echo esc_attr( $benefit['_id'] ?? '' ); ?>"><span class="g12-benefits-panel__benefit-label"><?php echo esc_html( $benefit['label'] ?? '' ); ?></span><span class="g12-benefits-panel__connector" aria-hidden="true"></span></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $desktop_url ) : ?>
					<div class="g12-benefits-panel__visual">
						<picture>
							<?php if ( $mobile_url ) : ?><source media="(max-width: 767px)" srcset="<?php echo esc_url( $mobile_url ); ?>"><?php endif; ?>
							<img class="g12-benefits-panel__image" src="<?php echo esc_url( $desktop_url ); ?>" alt="<?php echo esc_attr( $settings['image_alt'] ?? '' ); ?>" loading="lazy">
						</picture>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $settings['panel_title'] ) || ! empty( $points ) ) : ?>
					<aside class="g12-benefits-panel__eligibility">
						<?php if ( ! empty( $settings['panel_title'] ) ) : ?><h3 class="g12-benefits-panel__panel-title"><?php echo esc_html( $settings['panel_title'] ); ?></h3><?php endif; ?>
						<?php if ( ! empty( $points ) ) : ?>
							<ul class="g12-benefits-panel__points">
								<?php foreach ( $points as $point ) : ?>
									<li class="g12-benefits-panel__point elementor-repeater-item-<?php echo esc_attr( $point['_id'] ?? '' ); ?>"><span class="g12-benefits-panel__star" aria-hidden="true">★</span><span><?php echo esc_html( $point['text'] ?? '' ); ?></span></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</aside>
				<?php endif; ?>
			</div>
		</div>

		<?php
	}

	private function get_default_benefits(): array {
		return array(
			array( 'label' => esc_html__( '10-Year, Renewable Residency', 'gtwelve-elementor' ) ),
			array( 'label' => esc_html__( 'Fast-Track Path to UAE Citizenship', 'gtwelve-elementor' ) ),
			array( 'label' => esc_html__( 'Live in the Safest City in the World', 'gtwelve-elementor' ) ),
			array( 'label' => esc_html__( '#2 Safest Place in the World', 'gtwelve-elementor' ) ),
			array( 'label' => esc_html__( 'Travel Benefits & Global Mobility', 'gtwelve-elementor' ) ),
			array( 'label' => esc_html__( 'Access to Employment and Business Opportunities', 'gtwelve-elementor' ) ),
			array( 'label' => esc_html__( 'Sponsor Your Family as well', 'gtwelve-elementor' ) ),
			array( 'label' => esc_html__( 'Permanent Residency for Dependents', 'gtwelve-elementor' ) ),
		);
	}

	private function get_default_points(): array {
		return array(
			array( 'text' => esc_html__( 'Must be a UAE resident', 'gtwelve-elementor' ) ),
			array( 'text' => esc_html__( 'Real estate owners (min. property value AED 2M)', 'gtwelve-elementor' ) ),
			array( 'text' => esc_html__( 'Individuals with a fixed deposit of AED 2M', 'gtwelve-elementor' ) ),
			array( 'text' => esc_html__( 'Individuals with a salary of AED 30K', 'gtwelve-elementor' ) ),
			array( 'text' => esc_html__( 'University graduates with a min. GPA 3.8/4', 'gtwelve-elementor' ) ),
		);
	}
}
