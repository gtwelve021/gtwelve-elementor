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

		$this->add_control( 'heading', array( 'label' => esc_html__( 'Heading', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'label_block' => true, 'default' => '' ) );
		$this->add_control( 'heading_tag', array( 'label' => esc_html__( 'Heading HTML Tag', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'h2', 'options' => array( 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'div' => 'div' ) ) );
		$this->add_control( 'intro_content', array( 'label' => esc_html__( 'Intro Content', 'gtwelve-elementor' ), 'type' => Controls_Manager::WYSIWYG, 'default' => '' ) );
		$this->add_control( 'content_divider', array( 'type' => Controls_Manager::DIVIDER ) );

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
		$this->add_responsive_control( 'max_width', array( 'label' => esc_html__( 'Maximum Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 700, 'max' => 1800 ), '%' => array( 'min' => 60, 'max' => 100 ) ), 'default' => array( 'size' => 100, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'stage_min_height', array( 'label' => esc_html__( 'Showcase Minimum Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 1200 ) ), 'default' => array( 'size' => 0, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 0, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 0, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__stage' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'image_width', array( 'label' => esc_html__( 'Image Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( '%', 'px' ), 'range' => array( '%' => array( 'min' => 30, 'max' => 90 ), 'px' => array( 'min' => 200, 'max' => 1000 ) ), 'default' => array( 'size' => 55, 'unit' => '%' ), 'mobile_default' => array( 'size' => 70, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__visual--desktop' => 'width: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .g12-benefits-panel__visual--mobile .g12-benefits-panel__image' => 'width: {{SIZE}}{{UNIT}};' ) ) );
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
		$this->add_responsive_control( 'benefit_gap', array( 'label' => esc_html__( 'Vertical Gap', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 4, 'max' => 60 ) ), 'default' => array( 'size' => 16, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 10, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__benefits' => 'gap: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .g12-benefits-panel__benefit + .g12-benefits-panel__benefit' => 'margin-top: 0;' ) ) );
		$this->add_responsive_control( 'benefit_padding', array( 'label' => esc_html__( 'Label Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 6, 'right' => 16, 'bottom' => 6, 'left' => 16, 'unit' => 'px', 'isLinked' => false ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__benefit-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
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
		$this->add_responsive_control( 'panel_width', array( 'label' => esc_html__( 'Panel Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( '%', 'px' ), 'range' => array( '%' => array( 'min' => 40, 'max' => 100 ), 'px' => array( 'min' => 300, 'max' => 1200 ) ), 'default' => array( 'size' => 71, 'unit' => '%' ), 'mobile_default' => array( 'size' => 100, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__eligibility' => 'width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'panel_padding', array( 'label' => esc_html__( 'Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'unit' => 'px', 'isLinked' => false ), 'selectors' => array( '{{WRAPPER}} .g12-benefits-panel__eligibility' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
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
			<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['intro_content'] ) ) : ?>
				<div class="g12-benefits-panel__editorial">
					<?php
					if ( ! empty( $settings['heading'] ) ) {
						$allowed_heading_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div' );
						$heading_tag         = in_array( $settings['heading_tag'] ?? 'h2', $allowed_heading_tags, true ) ? $settings['heading_tag'] : 'h2';
						printf( '<%1$s class="g12-benefits-panel__heading">%2$s</%1$s>', esc_attr( $heading_tag ), wp_kses_post( $settings['heading'] ) );
					}
					?>
					<?php if ( ! empty( $settings['intro_content'] ) ) : ?><div class="g12-benefits-panel__intro"><?php echo wp_kses_post( $settings['intro_content'] ); ?></div><?php endif; ?>
				</div>
			<?php endif; ?>
			<div class="g12-benefits-panel__stage">
				<div class="g12-benefits-panel__text-column">
					<?php if ( ! empty( $benefits ) ) : ?>
						<div class="g12-benefits-panel__benefits-wrap"><ul class="g12-benefits-panel__benefits">
							<?php foreach ( $benefits as $benefit ) : ?>
								<li class="g12-benefits-panel__benefit elementor-repeater-item-<?php echo esc_attr( $benefit['_id'] ?? '' ); ?>"><span class="g12-benefits-panel__benefit-label"><?php echo esc_html( $benefit['label'] ?? '' ); ?></span><span class="g12-benefits-panel__connector" aria-hidden="true"></span></li>
							<?php endforeach; ?>
						</ul></div>
					<?php endif; ?>
					<?php if ( $desktop_url ) : ?>
						<div class="g12-benefits-panel__visual g12-benefits-panel__visual--mobile"><picture><?php if ( $mobile_url ) : ?><source media="(max-width: 600px)" srcset="<?php echo esc_url( $mobile_url ); ?>"><?php endif; ?><img class="g12-benefits-panel__image" src="<?php echo esc_url( $desktop_url ); ?>" alt="<?php echo esc_attr( $settings['image_alt'] ?? '' ); ?>" loading="lazy"></picture></div>
					<?php endif; ?>
					<?php if ( ! empty( $settings['panel_title'] ) || ! empty( $points ) ) : ?>
						<aside class="g12-benefits-panel__eligibility"><div class="g12-benefits-panel__eligibility-inner">
							<?php if ( ! empty( $settings['panel_title'] ) ) : ?><h3 class="g12-benefits-panel__panel-title"><?php echo esc_html( $settings['panel_title'] ); ?></h3><?php endif; ?>
							<?php if ( ! empty( $points ) ) : ?><ul class="g12-benefits-panel__points">
								<?php foreach ( $points as $point ) : ?>
									<li class="g12-benefits-panel__point elementor-repeater-item-<?php echo esc_attr( $point['_id'] ?? '' ); ?>"><svg class="g12-benefits-panel__star" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><span><?php echo esc_html( $point['text'] ?? '' ); ?></span></li>
								<?php endforeach; ?>
							</ul><?php endif; ?>
						</div></aside>
					<?php endif; ?>
				</div>
				<?php if ( $desktop_url ) : ?><div class="g12-benefits-panel__visual g12-benefits-panel__visual--desktop"><img class="g12-benefits-panel__image" src="<?php echo esc_url( $desktop_url ); ?>" alt="<?php echo esc_attr( $settings['image_alt'] ?? '' ); ?>" loading="lazy"></div><?php endif; ?>
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
