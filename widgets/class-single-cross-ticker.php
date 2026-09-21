<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Single_Cross_Ticker extends Widget_Base {
	public function get_name(): string {
		return 'g12_single_cross_ticker';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Single Cross Ticker', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-posts-ticker';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'ticker', 'top', 'bottom', 'cross', 'marquee', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-single-cross-ticker' );
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Ticker', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'ticker_position',
			array(
				'label'   => esc_html__( 'Ticker Type', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'gtwelve-elementor' ),
					'bottom' => esc_html__( 'Bottom', 'gtwelve-elementor' ),
				),
			)
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'FLASH SALE', 'gtwelve-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Items', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => array_fill( 0, 8, array( 'text' => esc_html__( 'FLASH SALE', 'gtwelve-elementor' ) ) ),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'gtwelve-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'bar_style_section',
			array(
				'label' => esc_html__( 'Ticker Bar', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'bar_width',
			array(
				'label'      => esc_html__( 'Width', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%', 'px' ),
				'range'      => array(
					'%'  => array( 'min' => 100, 'max' => 200 ),
					'px' => array( 'min' => 300, 'max' => 2500 ),
				),
				'default'    => array( 'size' => 150, 'unit' => '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-single-cross-ticker' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rotation',
			array(
				'label'      => esc_html__( 'Rotation', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'range'      => array( 'deg' => array( 'min' => -30, 'max' => 30, 'step' => 0.5 ) ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-single-cross-ticker' => '--g12-single-ticker-rotation: {{SIZE}}deg;',
				),
			)
		);

		$this->add_responsive_control(
			'vertical_padding',
			array(
				'label'      => esc_html__( 'Vertical Padding', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 60 ),
					'em' => array( 'min' => 0, 'max' => 4, 'step' => 0.1 ),
				),
				'default'    => array( 'size' => 10, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-single-cross-ticker' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d6a557',
				'selectors' => array(
					'{{WRAPPER}} .g12-single-cross-ticker' => '--g12-single-ticker-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'edge_color',
			array(
				'label'     => esc_html__( 'Edge Highlight', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#efdb9f',
				'selectors' => array(
					'{{WRAPPER}} .g12-single-cross-ticker' => '--g12-single-ticker-edge: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'animation_speed',
			array(
				'label'       => esc_html__( 'Loop Duration (seconds)', 'gtwelve-elementor' ),
				'description' => esc_html__( 'Higher values move more slowly.', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 5,
				'max'         => 120,
				'default'     => 25,
				'selectors'   => array(
					'{{WRAPPER}} .g12-single-cross-ticker' => '--g12-single-ticker-speed: {{VALUE}}s;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'item_style_section',
			array(
				'label' => esc_html__( 'Items', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-single-cross-ticker .item' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'item_typography',
				'selector'       => '{{WRAPPER}} .g12-single-cross-ticker .item',
				'fields_options' => array(
					'typography'  => array( 'default' => 'custom' ),
					'font_size'   => array( 'default' => array( 'size' => 26, 'unit' => 'px' ) ),
					'font_weight' => array( 'default' => '700' ),
				),
			)
		);

		$this->add_responsive_control(
			'item_gap',
			array(
				'label'      => esc_html__( 'Item Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'rem' ),
				'range'      => array(
					'px'  => array( 'min' => 0, 'max' => 150 ),
					'rem' => array( 'min' => 0, 'max' => 10, 'step' => 0.1 ),
				),
				'default'    => array( 'size' => 3, 'unit' => 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-single-cross-ticker' => '--g12-single-ticker-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$items    = isset( $settings['items'] ) && is_array( $settings['items'] ) ? $settings['items'] : array();

		if ( empty( $items ) ) {
			return;
		}

		$type    = 'bottom' === ( $settings['ticker_position'] ?? 'top' ) ? 'bottom' : 'top';
		$classes = array( 'g12-single-cross-ticker', 'ticker-wrap', 'ticker-' . $type );
		if ( 'yes' === ( $settings['pause_on_hover'] ?? '' ) ) {
			$classes[] = 'g12-single-cross-ticker--pause-hover';
		}
		?>
		<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" role="region" aria-label="<?php echo esc_attr__( 'Scrolling ticker', 'gtwelve-elementor' ); ?>">
			<div class="ticker">
				<?php $this->render_collection( $items, false ); ?>
				<?php $this->render_collection( $items, true ); ?>
			</div>
		</div>
		<?php
	}

	private function render_collection( array $items, bool $duplicate ): void {
		?>
		<span class="item-collection-<?php echo $duplicate ? '2' : '1'; ?>"<?php echo $duplicate ? ' aria-hidden="true"' : ''; ?>>
			<?php foreach ( $items as $item ) : ?>
				<?php $text = isset( $item['text'] ) ? trim( (string) $item['text'] ) : ''; ?>
				<?php if ( '' !== $text ) : ?>
					<span class="item"><?php echo esc_html( $text ); ?></span>
				<?php endif; ?>
			<?php endforeach; ?>
		</span>
		<?php
	}
}
