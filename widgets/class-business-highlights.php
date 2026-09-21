<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Business_Highlights extends Widget_Base {
	public function get_name(): string {
		return 'g12_business_highlights';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Business Highlights', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-counter';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'business', 'highlights', 'stats', 'experience', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-widgets' );
	}

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls(): void {
		$this->start_controls_section(
			'section_columns',
			array(
				'label' => esc_html__( 'Highlight Columns', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'top_label',
			array(
				'label'       => esc_html__( 'Top Label', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'top_title',
			array(
				'label'       => esc_html__( 'Top Highlight', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'bottom_label',
			array(
				'label'       => esc_html__( 'Bottom Label', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'bottom_title',
			array(
				'label'       => esc_html__( 'Bottom Highlight', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'label_block' => true,
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'       => esc_html__( 'Columns', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ top_title }}}',
				'default'     => $this->get_default_columns(),
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
			'column_gap',
			array(
				'label'      => esc_html__( 'Column Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 160 ),
					'em' => array( 'min' => 0, 'max' => 10, 'step' => 0.1 ),
				),
				'default'    => array( 'size' => 80, 'unit' => 'px' ),
				'tablet_default' => array( 'size' => 48, 'unit' => 'px' ),
				'mobile_default' => array( 'size' => 20, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-business-highlights' => '--g12-business-highlights-column-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'row_gap',
			array(
				'label'          => esc_html__( 'Row Gap', 'gtwelve-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array( 'min' => 0, 'max' => 160 ),
					'em' => array( 'min' => 0, 'max' => 10, 'step' => 0.1 ),
				),
				'default'        => array( 'size' => 12, 'unit' => 'px' ),
				'tablet_default' => array( 'size' => 12, 'unit' => 'px' ),
				'mobile_default' => array( 'size' => 28, 'unit' => 'px' ),
				'selectors'      => array(
					'{{WRAPPER}} .g12-business-highlights' => '--g12-business-highlights-row-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'text_align',
			array(
				'label'     => esc_html__( 'Alignment', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'gtwelve-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'gtwelve-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'gtwelve-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'toggle'    => false,
				'selectors' => array(
					'{{WRAPPER}} .g12-business-highlights__group' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_style',
			array(
				'label' => esc_html__( 'Labels', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__( 'Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d2d2d2',
				'selectors' => array(
					'{{WRAPPER}} .g12-business-highlights__label' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'label_typography',
				'selector'       => '{{WRAPPER}} .g12-business-highlights__label',
				'fields_options' => array(
					'typography' => array(
						'default' => 'custom',
					),
					'font_size' => array(
						'default' => array(
							'size' => 16,
							'unit' => 'px',
						),
					),
					'font_weight' => array(
						'default' => '400',
					),
					'line_height' => array(
						'default' => array(
							'size' => 1.05,
							'unit' => 'em',
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'label_title_gap',
			array(
				'label'      => esc_html__( 'Label to Highlight Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 30 ),
					'em' => array( 'min' => 0, 'max' => 2, 'step' => 0.1 ),
				),
				'default'    => array( 'size' => 1, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-business-highlights__group' => '--g12-business-highlights-label-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			array(
				'label' => esc_html__( 'Highlights', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-business-highlights__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'title_typography',
				'selector'       => '{{WRAPPER}} .g12-business-highlights__title',
				'fields_options' => array(
					'typography' => array(
						'default' => 'custom',
					),
					'font_size' => array(
						'default' => array(
							'size' => 21,
							'unit' => 'px',
						),
					),
					'font_weight' => array(
						'default' => '600',
					),
					'line_height' => array(
						'default' => array(
							'size' => 1.05,
							'unit' => 'em',
						),
					),
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$columns = $this->get_settings_for_display( 'columns' );

		if ( empty( $columns ) || ! is_array( $columns ) ) {
			return;
		}
		?>
		<div class="g12-business-highlights">
			<?php foreach ( $columns as $column ) : ?>
				<?php $this->render_highlight_group( $column['top_label'] ?? '', $column['top_title'] ?? '' ); ?>
			<?php endforeach; ?>
			<?php foreach ( $columns as $column ) : ?>
				<?php $this->render_highlight_group( $column['bottom_label'] ?? '', $column['bottom_title'] ?? '' ); ?>
			<?php endforeach; ?>
		</div>
		<?php
	}

	private function render_highlight_group( string $label, string $title ): void {
		?>
		<div class="g12-business-highlights__group">
			<?php if ( '' !== trim( $label ) ) : ?>
				<div class="g12-business-highlights__label"><?php echo nl2br( esc_html( $label ) ); ?></div>
			<?php endif; ?>
			<?php if ( '' !== trim( $title ) ) : ?>
				<h3 class="g12-business-highlights__title"><?php echo nl2br( esc_html( $title ) ); ?></h3>
			<?php endif; ?>
		</div>
		<?php
	}

	private function get_default_columns(): array {
		return array(
			array(
				'top_label'    => esc_html__( 'Speed &', 'gtwelve-elementor' ),
				'top_title'    => esc_html__( 'Efficiency', 'gtwelve-elementor' ),
				'bottom_label' => esc_html__( 'More than', 'gtwelve-elementor' ),
				'bottom_title' => "50 Free Zones\nand Mainland",
			),
			array(
				'top_label'    => esc_html__( '15+ Years of', 'gtwelve-elementor' ),
				'top_title'    => esc_html__( 'Experience', 'gtwelve-elementor' ),
				'bottom_label' => esc_html__( '500+ Companies', 'gtwelve-elementor' ),
				'bottom_title' => esc_html__( 'Incorporated', 'gtwelve-elementor' ),
			),
			array(
				'top_label'    => esc_html__( 'Dedicated', 'gtwelve-elementor' ),
				'top_title'    => esc_html__( 'Success Manager', 'gtwelve-elementor' ),
				'bottom_label' => esc_html__( 'Strong Partner', 'gtwelve-elementor' ),
				'bottom_title' => esc_html__( 'Network', 'gtwelve-elementor' ),
			),
		);
	}
}
