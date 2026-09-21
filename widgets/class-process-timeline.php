<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Process_Timeline extends Widget_Base {
	public function get_name(): string {
		return 'g12_process_timeline';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Process Timeline', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-time-line';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'timeline', 'steps', 'process', 'journey', 'scroll', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-process-timeline' );
	}

	public function get_script_depends(): array {
		return array( 'gtwelve-elementor-process-timeline' );
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'steps_section',
			array(
				'label' => esc_html__( 'Timeline Steps', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'step_label',
			array(
				'label'       => esc_html__( 'Step Label', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'Leave empty to use the automatic step number.', 'gtwelve-elementor' ),
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Define the next milestone', 'gtwelve-elementor' ),
			)
		);
		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Explain what happens at this stage and what the client should prepare.', 'gtwelve-elementor' ),
			)
		);
		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Optional Image', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => Utils::get_placeholder_image_src() ),
			)
		);
		$repeater->add_control(
			'show_image',
			array(
				'label'        => esc_html__( 'Show Image', 'gtwelve-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'steps',
			array(
				'label'       => esc_html__( 'Steps', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array( 'title' => esc_html__( 'Choose your business activity', 'gtwelve-elementor' ), 'description' => esc_html__( 'Select the commercial or professional activity that best matches your plans.', 'gtwelve-elementor' ), 'show_image' => '' ),
					array( 'title' => esc_html__( 'Confirm the right jurisdiction', 'gtwelve-elementor' ), 'description' => esc_html__( 'Compare locations, operating requirements, and costs before committing.', 'gtwelve-elementor' ), 'show_image' => '' ),
					array( 'title' => esc_html__( 'Prepare your application', 'gtwelve-elementor' ), 'description' => esc_html__( 'Gather the required documents and submit the formation application.', 'gtwelve-elementor' ), 'show_image' => '' ),
					array( 'title' => esc_html__( 'Launch your company', 'gtwelve-elementor' ), 'description' => esc_html__( 'Complete licensing, workspace, banking, and residency requirements.', 'gtwelve-elementor' ), 'show_image' => '' ),
				),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Desktop Layout', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'alternating',
				'options' => array(
					'alternating' => esc_html__( 'Alternating', 'gtwelve-elementor' ),
					'right'       => esc_html__( 'Cards on Right', 'gtwelve-elementor' ),
				),
			)
		);

		$this->add_control(
			'animate_cards',
			array(
				'label'        => esc_html__( 'Reveal Cards on Scroll', 'gtwelve-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);
		$this->end_controls_section();

		$this->register_timeline_style_controls();
		$this->register_card_style_controls();
		$this->register_text_style_controls();
	}

	private function register_timeline_style_controls(): void {
		$this->start_controls_section( 'timeline_style', array( 'label' => esc_html__( 'Timeline', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'line_color', array( 'label' => esc_html__( 'Line Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#f3f3f3', 'selectors' => array( '{{WRAPPER}} .g12-process-timeline' => '--g12-timeline-line: {{VALUE}};' ) ) );
		$this->add_control( 'progress_color', array( 'label' => esc_html__( 'Progress Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#d6a557', 'selectors' => array( '{{WRAPPER}} .g12-process-timeline' => '--g12-timeline-accent: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'line_width', array( 'label' => esc_html__( 'Line Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 1, 'max' => 10 ) ), 'default' => array( 'size' => 2, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-process-timeline' => '--g12-timeline-line-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'item_gap', array( 'label' => esc_html__( 'Step Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 20, 'max' => 180 ) ), 'default' => array( 'size' => 64, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 44, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 32, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-process-timeline' => '--g12-timeline-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'content_width', array( 'label' => esc_html__( 'Maximum Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 600, 'max' => 1600 ), '%' => array( 'min' => 60, 'max' => 100 ) ), 'default' => array( 'size' => 1200, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__body' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_card_style_controls(): void {
		$this->start_controls_section( 'card_style', array( 'label' => esc_html__( 'Cards', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'card_background', array( 'label' => esc_html__( 'Background Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__card' => 'background-color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .g12-process-timeline__card' ) );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .g12-process-timeline__card' ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Border Radius', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'default' => array( 'top' => 16, 'right' => 16, 'bottom' => 16, 'left' => 16, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_width', array( 'label' => esc_html__( 'Card Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( '%' ), 'range' => array( '%' => array( 'min' => 30, 'max' => 48 ) ), 'default' => array( 'size' => 45, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .g12-process-timeline' => '--g12-timeline-card-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Image Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 80, 'max' => 500 ) ), 'default' => array( 'size' => 190, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__image' => 'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_text_style_controls(): void {
		$this->start_controls_section( 'step_text_style', array( 'label' => esc_html__( 'Step Text', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'step_label_color', array( 'label' => esc_html__( 'Label Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#9a6d25', 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__label' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'step_label_typography', 'selector' => '{{WRAPPER}} .g12-process-timeline__label' ) );
		$this->add_control( 'step_title_color', array( 'label' => esc_html__( 'Title Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#232323', 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'step_title_typography', 'selector' => '{{WRAPPER}} .g12-process-timeline__title' ) );
		$this->add_control( 'step_description_color', array( 'label' => esc_html__( 'Description Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#62666b', 'selectors' => array( '{{WRAPPER}} .g12-process-timeline__description, {{WRAPPER}} .g12-process-timeline__description a' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'step_description_typography', 'selector' => '{{WRAPPER}} .g12-process-timeline__description' ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$steps    = $settings['steps'] ?? array();

		if ( empty( $steps ) ) {
			return;
		}

		$classes = array( 'g12-process-timeline', 'g12-process-timeline--' . ( 'right' === ( $settings['layout'] ?? '' ) ? 'right' : 'alternating' ) );

		if ( 'yes' === ( $settings['animate_cards'] ?? 'yes' ) ) {
			$classes[] = 'g12-process-timeline--reveal';
		}
		?>
		<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-g12-process-timeline>
			<div class="g12-process-timeline__body">
				<div class="g12-process-timeline__rail" aria-hidden="true"><span class="g12-process-timeline__progress" data-g12-timeline-progress></span></div>
				<ol class="g12-process-timeline__list">
					<?php foreach ( $steps as $index => $step ) :
						$number = $index + 1;
						$label  = '' !== trim( (string) ( $step['step_label'] ?? '' ) ) ? $step['step_label'] : sprintf( esc_html__( 'Step %d', 'gtwelve-elementor' ), $number );
						?>
						<li class="g12-process-timeline__item elementor-repeater-item-<?php echo esc_attr( $step['_id'] ?? '' ); ?>" data-g12-timeline-item>
							<span class="g12-process-timeline__node" aria-hidden="true"><span><?php echo esc_html( (string) $number ); ?></span></span>
							<article class="g12-process-timeline__card">
								<?php if ( 'yes' === ( $step['show_image'] ?? '' ) && ! empty( $step['image']['url'] ) ) : ?>
									<div class="g12-process-timeline__image-wrap"><img class="g12-process-timeline__image" src="<?php echo esc_url( $step['image']['url'] ); ?>" alt="<?php echo esc_attr( $step['title'] ?? '' ); ?>" loading="lazy"></div>
								<?php endif; ?>
								<div class="g12-process-timeline__label"><?php echo esc_html( $label ); ?></div>
								<?php if ( ! empty( $step['title'] ) ) : ?><h3 class="g12-process-timeline__title"><?php echo esc_html( $step['title'] ); ?></h3><?php endif; ?>
								<?php if ( ! empty( $step['description'] ) ) : ?><div class="g12-process-timeline__description"><?php echo wp_kses_post( $step['description'] ); ?></div><?php endif; ?>
							</article>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>
		</section>
		<?php
	}
}
