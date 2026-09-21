<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Testimonial_Quote_Cards extends Widget_Base {
	public function get_name(): string {
		return 'g12_testimonial_quote_cards';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Testimonial Quote Cards', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-testimonial';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'testimonial', 'review', 'quote', 'cards', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-testimonial-quote-cards' );
	}

	public function get_script_depends(): array {
		return array( 'gtwelve-elementor-testimonial-quote-cards' );
	}

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls(): void {
		$this->start_controls_section(
			'section_testimonials',
			array(
				'label' => esc_html__( 'Testimonials', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			array(
				'label'       => esc_html__( 'Name', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Customer Name', 'gtwelve-elementor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'review',
			array(
				'label'       => esc_html__( 'Review', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Add the customer testimonial here.', 'gtwelve-elementor' ),
				'rows'        => 5,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'avatar',
			array(
				'label'   => esc_html__( 'Avatar', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'testimonials',
			array(
				'label'       => esc_html__( 'Testimonial Cards', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => array(
					array(
						'name'       => 'Ruth Corpuz',
						'review'     => 'G12 corporate service provider is great! Their customer service is good, and their consultants are knowledgeable, making everything easy and smooth.',
						'avatar'     => array( 'url' => Utils::get_placeholder_image_src() ),
					),
					array(
						'name'       => 'Muhammad Qasim',
						'review'     => 'Got my permit from G12. Also doing my marketing and accounting with them. Professional services with good pricing highly recommended',
						'avatar'     => array( 'url' => Utils::get_placeholder_image_src() ),
					),
					array(
						'name'       => 'Humaira Cheema',
						'review'     => 'During the setup process, I hit a snag with paperwork, reached out to the team at G12, who took care of the problem and handled it efficiently.',
						'avatar'     => array( 'url' => Utils::get_placeholder_image_src() ),
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider',
			array(
				'label' => esc_html__( 'Vertical Slider', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'visible_cards',
			array(
				'label'          => esc_html__( 'Visible Cards', 'gtwelve-elementor' ),
				'type'           => Controls_Manager::NUMBER,
				'min'            => 1,
				'max'            => 6,
				'step'           => 1,
				'default'        => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'selectors'      => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-visible: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'gtwelve-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gtwelve-elementor' ),
				'label_off'    => esc_html__( 'No', 'gtwelve-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'autoplay_delay',
			array(
				'label'     => esc_html__( 'Autoplay Delay (ms)', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 15000,
				'step'      => 100,
				'default'   => 3500,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'transition_duration',
			array(
				'label'     => esc_html__( 'Transition Duration (ms)', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 100,
				'max'       => 2000,
				'step'      => 50,
				'default'   => 500,
				'selectors' => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-transition: {{VALUE}}ms;',
				),
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
				'condition'    => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'show_navigation',
			array(
				'label'        => esc_html__( 'Show Vertical Dots', 'gtwelve-elementor' ),
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
			'section_layout_style',
			array(
				'label' => esc_html__( 'Layout', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'card_gap',
			array(
				'label'      => esc_html__( 'Card Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 100 ),
				),
				'default'        => array( 'size' => 46, 'unit' => 'px' ),
				'mobile_default' => array( 'size' => 24, 'unit' => 'px' ),
				'selectors'      => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Card Padding', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'      => '22',
					'right'    => '80',
					'bottom'   => '24',
					'left'     => '24',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'mobile_default' => array(
					'top'      => '20',
					'right'    => '52',
					'bottom'   => '22',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'      => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_gap',
			array(
				'label'      => esc_html__( 'Avatar and Text Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 60 ),
				),
				'default'        => array( 'size' => 26, 'unit' => 'px' ),
				'mobile_default' => array( 'size' => 16, 'unit' => 'px' ),
				'selectors'      => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-content-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_radius',
			array(
				'label'      => esc_html__( 'Card Radius', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 0, 'max' => 50 ),
				),
				'default'    => array( 'size' => 9, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_avatar_style',
			array(
				'label' => esc_html__( 'Avatar', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'avatar_size',
			array(
				'label'      => esc_html__( 'Avatar Size', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 30, 'max' => 160 ),
				),
				'default'    => array( 'size' => 54, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-avatar-size: {{SIZE}}{{UNIT}};',
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
			'name_color',
			array(
				'label'     => esc_html__( 'Name Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards__name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'name_typography',
				'selector'       => '{{WRAPPER}} .g12-testimonial-quote-cards__name',
				'fields_options' => array(
					'typography'  => array( 'default' => 'custom' ),
					'font_size'   => array( 'default' => array( 'size' => 16, 'unit' => 'px' ) ),
					'font_weight' => array( 'default' => '700' ),
					'line_height' => array( 'default' => array( 'size' => 1.3, 'unit' => 'em' ) ),
				),
			)
		);

		$this->add_control(
			'review_color',
			array(
				'label'     => esc_html__( 'Review Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards__review' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'           => 'review_typography',
				'selector'       => '{{WRAPPER}} .g12-testimonial-quote-cards__review',
				'fields_options' => array(
					'typography'  => array( 'default' => 'custom' ),
					'font_size'   => array( 'default' => array( 'size' => 15, 'unit' => 'px' ) ),
					'font_weight' => array( 'default' => '400' ),
					'line_height' => array( 'default' => array( 'size' => 1.45, 'unit' => 'em' ) ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_quote_style',
			array(
				'label' => esc_html__( 'Quote and Dots', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'quote_color',
			array(
				'label'     => esc_html__( 'Quote Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d1a04b',
				'selectors' => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-accent: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'quote_size',
			array(
				'label'      => esc_html__( 'Quote Size', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 24, 'max' => 120 ),
				),
				'default'    => array( 'size' => 72, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-quote-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'dot_color',
			array(
				'label'     => esc_html__( 'Dot Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#cfcfcf',
				'selectors' => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-dot: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'dot_size',
			array(
				'label'      => esc_html__( 'Dot Size', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array( 'min' => 4, 'max' => 20 ),
				),
				'default'    => array( 'size' => 8, 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-testimonial-quote-cards' => '--g12-quote-cards-dot-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings     = $this->get_settings_for_display();
		$testimonials = isset( $settings['testimonials'] ) && is_array( $settings['testimonials'] ) ? $settings['testimonials'] : array();

		if ( empty( $testimonials ) ) {
			return;
		}
		?>
		<div
			class="g12-testimonial-quote-cards"
			data-g12-testimonial-vertical-slider
			data-autoplay="<?php echo esc_attr( $settings['autoplay'] ?? 'yes' ); ?>"
			data-autoplay-delay="<?php echo esc_attr( (string) ( $settings['autoplay_delay'] ?? 3500 ) ); ?>"
			data-pause-hover="<?php echo esc_attr( $settings['pause_on_hover'] ?? 'yes' ); ?>"
		>
			<div class="g12-testimonial-quote-cards__viewport" data-g12-quote-viewport>
				<div class="g12-testimonial-quote-cards__track" data-g12-quote-track>
					<?php foreach ( $testimonials as $index => $testimonial ) : ?>
						<?php
						$name       = isset( $testimonial['name'] ) ? trim( (string) $testimonial['name'] ) : '';
						$review     = isset( $testimonial['review'] ) ? trim( (string) $testimonial['review'] ) : '';
						$avatar_url = isset( $testimonial['avatar']['url'] ) ? (string) $testimonial['avatar']['url'] : '';
						?>
						<article class="g12-testimonial-quote-cards__card" data-g12-quote-slide aria-hidden="<?php echo 0 === $index ? 'false' : 'true'; ?>">
							<div class="g12-testimonial-quote-cards__avatar-wrap">
								<?php if ( '' !== $avatar_url ) : ?>
									<img class="g12-testimonial-quote-cards__avatar" src="<?php echo esc_url( $avatar_url ); ?>" alt="<?php echo esc_attr( $name ); ?>">
								<?php endif; ?>
							</div>

							<div class="g12-testimonial-quote-cards__content">
								<?php if ( '' !== $name ) : ?>
									<h3 class="g12-testimonial-quote-cards__name"><?php echo esc_html( $name ); ?></h3>
								<?php endif; ?>
								<?php if ( '' !== $review ) : ?>
									<p class="g12-testimonial-quote-cards__review"><?php echo esc_html( $review ); ?></p>
								<?php endif; ?>
							</div>

							<span class="g12-testimonial-quote-cards__quote" aria-hidden="true">&#8221;</span>
						</article>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if ( 'yes' === ( $settings['show_navigation'] ?? 'yes' ) && count( $testimonials ) > 1 ) : ?>
				<div class="g12-testimonial-quote-cards__dots" aria-label="<?php echo esc_attr__( 'Testimonial navigation', 'gtwelve-elementor' ); ?>">
					<?php foreach ( $testimonials as $index => $testimonial ) : ?>
						<button
							type="button"
							class="g12-testimonial-quote-cards__dot<?php echo 0 === $index ? ' is-active' : ''; ?>"
							data-g12-quote-dot="<?php echo esc_attr( (string) $index ); ?>"
							aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number */ esc_html__( 'Show testimonial %d', 'gtwelve-elementor' ), $index + 1 ) ); ?>"
							aria-current="<?php echo 0 === $index ? 'true' : 'false'; ?>"
						></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}
}
