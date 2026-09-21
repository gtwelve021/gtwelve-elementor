<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Ticker_V2 extends Widget_Base {
	public function get_name(): string {
		return 'g12_elementor_ticker_v2';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Ticker V2', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-posts-ticker';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'ticker', 'marquee', 'scroll', 'highlights', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-ticker-v2' );
	}

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls(): void {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Ticker Items', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'text',
			array(
				'label'       => esc_html__( 'Text', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Ticker item', 'gtwelve-elementor' ),
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
				'default'     => array(
					array( 'text' => esc_html__( 'Full Ownership & Flexibility', 'gtwelve-elementor' ) ),
					array( 'text' => esc_html__( 'Incl. General Trading & E-Commerce', 'gtwelve-elementor' ) ),
					array( 'text' => esc_html__( 'Complete Shipping & Logistics Support', 'gtwelve-elementor' ) ),
					array( 'text' => esc_html__( '15+ Years of Experience', 'gtwelve-elementor' ) ),
				),
			)
		);

		$this->add_control(
			'aria_label',
			array(
				'label'       => esc_html__( 'Accessibility Label', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Highlights', 'gtwelve-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'gtwelve-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gtwelve-elementor' ),
				'label_off'    => esc_html__( 'No', 'gtwelve-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	private function register_style_controls(): void {
		$this->start_controls_section(
			'section_ticker_style',
			array(
				'label' => esc_html__( 'Ticker', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'background_start',
			array(
				'label'     => esc_html__( 'Background Start', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#032643',
				'selectors' => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-bg-start: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'background_end',
			array(
				'label'     => esc_html__( 'Background End', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#09497c',
				'selectors' => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-bg-end: {{VALUE}};',
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
					'px' => array( 'min' => 0, 'max' => 80 ),
					'em' => array( 'min' => 0, 'max' => 5, 'step' => 0.1 ),
				),
				'default'        => array( 'size' => 10, 'unit' => 'px' ),
				'mobile_default' => array( 'size' => 8, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2__inner' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
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
					'px'  => array( 'min' => 0, 'max' => 160 ),
					'rem' => array( 'min' => 0, 'max' => 10, 'step' => 0.1 ),
				),
				'default'        => array( 'size' => 3.2, 'unit' => 'rem' ),
				'mobile_default' => array( 'size' => 1.6, 'unit' => 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'animation_speed',
			array(
				'label'       => esc_html__( 'Loop Duration (seconds)', 'gtwelve-elementor' ),
				'description' => esc_html__( 'A higher value makes the ticker move more slowly.', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 5,
				'max'         => 120,
				'step'        => 1,
				'default'     => 30,
				'selectors'   => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-speed: {{VALUE}}s;',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			array(
				'label' => esc_html__( 'Text', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-text: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'text_typography',
				'selector'       => '{{WRAPPER}} .g12-elementor-ticker-v2__item',
				'fields_options' => array(
					'typography'  => array( 'default' => 'custom' ),
					'font_weight' => array( 'default' => '300' ),
					'line_height' => array( 'default' => array( 'size' => 1.6, 'unit' => 'em' ) ),
				),
			)
		);

		$this->add_responsive_control(
			'letter_spacing',
			array(
				'label'      => esc_html__( 'Letter Spacing', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array( 'min' => -2, 'max' => 10, 'step' => 0.1 ),
					'em' => array( 'min' => -0.1, 'max' => 1, 'step' => 0.01 ),
				),
				'default'    => array( 'size' => 0.2, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2__item' => 'letter-spacing: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dot_style',
			array(
				'label' => esc_html__( 'Separator Dot', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'dot_color',
			array(
				'label'     => esc_html__( 'Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d6a24a',
				'selectors' => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-dot: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'dot_size',
			array(
				'label'      => esc_html__( 'Size', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 2, 'max' => 30 ) ),
				'default'    => array( 'size' => 8, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-dot-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dot_gap',
			array(
				'label'      => esc_html__( 'Text Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 50 ) ),
				'default'    => array( 'size' => 12, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-elementor-ticker-v2' => '--g12-ticker-dot-gap: {{SIZE}}{{UNIT}};',
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

		$classes = array( 'g12-elementor-ticker-v2' );
		if ( 'yes' === ( $settings['pause_on_hover'] ?? '' ) ) {
			$classes[] = 'g12-elementor-ticker-v2--pause-hover';
		}
		?>
		<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" role="region" aria-label="<?php echo esc_attr( $settings['aria_label'] ?? '' ); ?>">
			<div class="g12-elementor-ticker-v2__inner">
				<div class="g12-elementor-ticker-v2__viewport">
					<div class="g12-elementor-ticker-v2__track">
						<?php $this->render_item_list( $items, false ); ?>
						<?php $this->render_item_list( $items, true ); ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}

	private function render_item_list( array $items, bool $duplicate ): void {
		?>
		<ul class="g12-elementor-ticker-v2__list" role="list"<?php echo $duplicate ? ' aria-hidden="true"' : ''; ?>>
			<?php foreach ( $items as $item ) : ?>
				<?php
				$text = isset( $item['text'] ) ? trim( (string) $item['text'] ) : '';
				if ( '' === $text ) {
					continue;
				}
				?>
				<li class="g12-elementor-ticker-v2__item">
					<span class="g12-elementor-ticker-v2__dot" aria-hidden="true"></span>
					<span class="g12-elementor-ticker-v2__text"><?php echo esc_html( $text ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}
