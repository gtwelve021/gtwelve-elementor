<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Setup_Comparison extends Widget_Base {
	public function get_name(): string {
		return 'g12_setup_comparison';
	}

	public function get_title(): string {
		return esc_html__( 'Setup Comparison', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-table';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'comparison', 'offer', 'pricing', 'setup', 'table' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-setup-comparison' );
	}

	public function get_script_depends(): array {
		return array( 'gtwelve-elementor-setup-comparison' );
	}

	protected function register_controls(): void {
		$this->start_controls_section( 'content_section', array( 'label' => esc_html__( 'Comparison', 'gtwelve-elementor' ) ) );

		$this->add_control( 'standard_heading', array(
			'label' => esc_html__( 'Standard Column Heading', 'gtwelve-elementor' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'Typical Low-Cost Setup', 'gtwelve-elementor' ),
			'label_block' => true,
		) );
		$this->add_control( 'offer_heading', array(
			'label' => esc_html__( 'Offer Column Heading', 'gtwelve-elementor' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'G12 AED 4,999 Offer', 'gtwelve-elementor' ),
			'label_block' => true,
		) );

		$repeater = new Repeater();
		$repeater->add_control( 'feature', array(
			'label' => esc_html__( 'Feature', 'gtwelve-elementor' ),
			'type' => Controls_Manager::TEXT,
			'label_block' => true,
		) );
		foreach ( array( 'standard' => 'Standard', 'offer' => 'Offer' ) as $key => $label ) {
			$repeater->add_control( $key . '_type', array(
				'label' => sprintf( esc_html__( '%s Value Type', 'gtwelve-elementor' ), $label ),
				'type' => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => array(
					'check' => esc_html__( 'Check', 'gtwelve-elementor' ),
					'cross' => esc_html__( 'Cross', 'gtwelve-elementor' ),
					'text' => esc_html__( 'Text', 'gtwelve-elementor' ),
				),
			) );
			$repeater->add_control( $key . '_text', array(
				'label' => sprintf( esc_html__( '%s Text', 'gtwelve-elementor' ), $label ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'condition' => array( $key . '_type' => 'text' ),
			) );
			$repeater->add_control( $key . '_bold', array(
				'label' => sprintf( esc_html__( 'Bold %s Text', 'gtwelve-elementor' ), $label ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition' => array( $key . '_type' => 'text' ),
			) );
		}

		$this->add_control( 'rows', array(
			'label' => esc_html__( 'Rows', 'gtwelve-elementor' ),
			'type' => Controls_Manager::REPEATER,
			'fields' => $repeater->get_controls(),
			'title_field' => '{{{ feature }}}',
			'default' => $this->get_default_rows(),
		) );
		$this->end_controls_section();

		$this->start_controls_section( 'table_style', array( 'label' => esc_html__( 'Table', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'cell_padding', array(
			'label' => esc_html__( 'Cell Padding', 'gtwelve-elementor' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => array( 'px' ),
			'default' => array( 'top' => 15, 'right' => 24, 'bottom' => 15, 'left' => 24, 'unit' => 'px', 'isLinked' => false ),
			'selectors' => array( '{{WRAPPER}} .g12-setup-comparison th, {{WRAPPER}} .g12-setup-comparison td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ),
		) );
		$this->add_control( 'border_color', array(
			'label' => esc_html__( 'Grid Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#E9E9E9',
			'selectors' => array( '{{WRAPPER}} .g12-setup-comparison th, {{WRAPPER}} .g12-setup-comparison td' => 'border-color: {{VALUE}};' ),
		) );
		$this->end_controls_section();

		$this->start_controls_section( 'heading_style', array( 'label' => esc_html__( 'Headings', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'standard_bg', array( 'label' => esc_html__( 'Standard Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#E5E5E5', 'selectors' => array( '{{WRAPPER}} .g12-setup-comparison__standard-heading' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'offer_bg', array( 'label' => esc_html__( 'Offer Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#171717', 'selectors' => array( '{{WRAPPER}} .g12-setup-comparison__offer-heading' => 'background: {{VALUE}};' ) ) );
		$this->add_control( 'offer_color', array( 'label' => esc_html__( 'Offer Heading Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#D5A43B', 'selectors' => array( '{{WRAPPER}} .g12-setup-comparison__offer-heading' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .g12-setup-comparison thead th' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'body_style', array( 'label' => esc_html__( 'Body', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'text_color', array( 'label' => esc_html__( 'Text Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#2D2D2D', 'selectors' => array( '{{WRAPPER}} .g12-setup-comparison tbody' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'muted_color', array( 'label' => esc_html__( 'Muted Text Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#858585', 'selectors' => array( '{{WRAPPER}} .g12-setup-comparison__standard' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'check_color', array( 'label' => esc_html__( 'Check Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#27D51F', 'selectors' => array( '{{WRAPPER}} .g12-setup-comparison__check' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'cross_color', array( 'label' => esc_html__( 'Cross Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#FF1515', 'selectors' => array( '{{WRAPPER}} .g12-setup-comparison__cross' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'body_typography', 'selector' => '{{WRAPPER}} .g12-setup-comparison tbody' ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['rows'] ) ) { return; }
		?>
		<div class="g12-setup-comparison-shell" data-g12-setup-comparison>
			<div class="g12-setup-comparison" role="region" aria-label="<?php echo esc_attr__( 'Setup offer comparison', 'gtwelve-elementor' ); ?>" tabindex="0" data-g12-setup-comparison-viewport>
				<table>
				<thead><tr><th class="g12-setup-comparison__empty"><span class="screen-reader-text"><?php echo esc_html__( 'Feature', 'gtwelve-elementor' ); ?></span></th><th class="g12-setup-comparison__standard-heading"><?php echo esc_html( $settings['standard_heading'] ); ?></th><th class="g12-setup-comparison__offer-heading"><?php echo esc_html( $settings['offer_heading'] ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $settings['rows'] as $row ) : ?>
					<tr><th scope="row"><?php echo esc_html( $row['feature'] ?? '' ); ?></th><td class="g12-setup-comparison__standard"><?php $this->render_value( $row, 'standard' ); ?></td><td class="g12-setup-comparison__offer"><?php $this->render_value( $row, 'offer' ); ?></td></tr>
				<?php endforeach; ?>
				</tbody>
				</table>
			</div>
			<div class="g12-setup-comparison__scrollbar" data-g12-setup-comparison-scrollbar aria-hidden="true">
				<span class="g12-setup-comparison__scrollbar-thumb" data-g12-setup-comparison-thumb></span>
			</div>
		</div>
		<?php
	}

	private function render_value( array $row, string $column ): void {
		$type = $row[ $column . '_type' ] ?? 'text';
		if ( 'check' === $type || 'cross' === $type ) {
			$mark = 'check' === $type ? '&#10003;' : '&times;';
			$label = 'check' === $type ? esc_html__( 'Included', 'gtwelve-elementor' ) : esc_html__( 'Not included', 'gtwelve-elementor' );
			printf( '<span class="g12-setup-comparison__mark g12-setup-comparison__%1$s" aria-label="%2$s">%3$s</span>', esc_attr( $type ), esc_attr( $label ), $mark );
			return;
		}
		$tag = 'yes' === ( $row[ $column . '_bold' ] ?? '' ) ? 'strong' : 'span';
		printf( '<%1$s>%2$s</%1$s>', $tag, esc_html( $row[ $column . '_text' ] ?? '' ) );
	}

	private function get_default_rows(): array {
		return array(
			array( 'feature' => 'Free Zone License', 'standard_type' => 'check', 'offer_type' => 'check' ),
			array( 'feature' => 'Multiple Business Activities', 'standard_type' => 'text', 'standard_text' => 'May Cost Extra', 'offer_type' => 'text', 'offer_text' => 'Up to 3 Included', 'offer_bold' => 'yes' ),
			array( 'feature' => 'Multiple Shareholders', 'standard_type' => 'text', 'standard_text' => 'May Cost Extra', 'offer_type' => 'check' ),
			array( 'feature' => 'Company Stamp', 'standard_type' => 'cross', 'offer_type' => 'check' ),
			array( 'feature' => 'Visa Assistance', 'standard_type' => 'cross', 'offer_type' => 'check' ),
			array( 'feature' => 'Pricing Transparency', 'standard_type' => 'text', 'standard_text' => 'Varies', 'offer_type' => 'text', 'offer_text' => 'No Hidden Costs', 'offer_bold' => 'yes' ),
			array( 'feature' => 'Dedicated Setup Support', 'standard_type' => 'text', 'standard_text' => 'Varies', 'offer_type' => 'check' ),
		);
	}
}
