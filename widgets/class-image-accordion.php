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

class Image_Accordion extends Widget_Base {
	public function get_name(): string {
		return 'gtwelve_image_accordion';
	}

	public function get_title(): string {
		return esc_html__( 'GTwelve Image Accordion', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-slider-full-screen';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'gtwelve', 'accordion', 'gallery', 'image', 'hover' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-image-accordion' );
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'section_items',
			array(
				'label' => esc_html__( 'Items', 'gtwelve-elementor' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__( 'Background Image', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array( 'url' => Utils::get_placeholder_image_src() ),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Education', 'gtwelve-elementor' ),
				'placeholder' => esc_html__( 'Enter title', 'gtwelve-elementor' ),
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'International schools and universities for families', 'gtwelve-elementor' ),
				'placeholder' => esc_html__( 'Enter description', 'gtwelve-elementor' ),
				'rows'        => 3,
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Items', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'title'       => esc_html__( 'Healthcare', 'gtwelve-elementor' ),
						'description' => esc_html__( 'Specialist access and clinics', 'gtwelve-elementor' ),
					),
					array(
						'title'       => esc_html__( 'Education', 'gtwelve-elementor' ),
						'description' => esc_html__( 'International schools and universities for families', 'gtwelve-elementor' ),
					),
					array(
						'title'       => esc_html__( 'Housing', 'gtwelve-elementor' ),
						'description' => esc_html__( 'Homes in prime city locations', 'gtwelve-elementor' ),
					),
					array(
						'title'       => esc_html__( 'Lifestyle', 'gtwelve-elementor' ),
						'description' => esc_html__( 'Memberships, sport, leisure, and events', 'gtwelve-elementor' ),
					),
				),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->add_responsive_control(
			'height',
			array(
				'label'          => esc_html__( 'Height', 'gtwelve-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px' ),
				'range'          => array( 'px' => array( 'min' => 200, 'max' => 800 ) ),
				'default'        => array( 'size' => 420, 'unit' => 'px' ),
				'tablet_default' => array( 'size' => 360, 'unit' => 'px' ),
				'mobile_default' => array( 'size' => 240, 'unit' => 'px' ),
				'selectors'      => array(
					'{{WRAPPER}} .gtwelve-image-accordion' => '--gtwelve-image-accordion-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_overlay',
			array(
				'label' => esc_html__( 'Overlay', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'overlay_color',
			array(
				'label'     => esc_html__( 'Overlay Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0,0,0,0.55)',
				'selectors' => array(
					'{{WRAPPER}} .gtwelve-image-accordion__overlay' => 'background: linear-gradient(145deg, {{VALUE}} 0%, rgba(0,0,0,0.28) 40%, rgba(0,0,0,0.6) 100%);',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			array(
				'label' => esc_html__( 'Text', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .gtwelve-image-accordion__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .gtwelve-image-accordion__title',
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Description Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f1f1f1',
				'selectors' => array(
					'{{WRAPPER}} .gtwelve-image-accordion__description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .gtwelve-image-accordion__description',
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Content Padding', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem' ),
				'default'    => array( 'top' => '20', 'right' => '20', 'bottom' => '20', 'left' => '20', 'unit' => 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .gtwelve-image-accordion__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$items = $this->get_settings_for_display( 'items' );

		if ( empty( $items ) || ! is_array( $items ) ) {
			return;
		}
		?>
		<div class="gtwelve-image-accordion">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$image_url  = $item['image']['url'] ?? '';
				$inline_css = $image_url ? 'background-image: url(' . esc_url( $image_url ) . ');' : '';
				?>
				<div class="gtwelve-image-accordion__item"<?php echo $inline_css ? ' style="' . esc_attr( $inline_css ) . '"' : ''; ?>>
					<div class="gtwelve-image-accordion__overlay"></div>
					<div class="gtwelve-image-accordion__content">
						<div class="gtwelve-image-accordion__text">
							<?php if ( ! empty( $item['title'] ) ) : ?>
								<h3 class="gtwelve-image-accordion__title"><?php echo esc_html( $item['title'] ); ?></h3>
							<?php endif; ?>
							<?php if ( ! empty( $item['description'] ) ) : ?>
								<p class="gtwelve-image-accordion__description"><?php echo esc_html( $item['description'] ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
	}
}
