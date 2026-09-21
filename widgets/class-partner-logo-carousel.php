<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Partner_Logo_Carousel extends Widget_Base {
	public function get_name(): string {
		return 'g12_partner_logo_carousel';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Partner Logo Carousel', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-logo';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'partner', 'logo', 'carousel', 'marquee', 'free zone', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-partner-logo-carousel' );
	}

	protected function register_controls(): void {
		$this->register_content_controls();
		$this->register_motion_controls();
		$this->register_heading_style_controls();
		$this->register_carousel_style_controls();
		$this->register_logo_style_controls();
	}

	private function register_content_controls(): void {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'       => esc_html__( 'Heading', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Official Free Zone Partners', 'gtwelve-elementor' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'heading_tag',
			array(
				'label'   => esc_html__( 'Heading HTML Tag', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'P',
				),
				'condition' => array( 'heading!' => '' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label' => esc_html__( 'Description', 'gtwelve-elementor' ),
				'type'  => Controls_Manager::WYSIWYG,
			)
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'logo',
			array(
				'label' => esc_html__( 'Logo', 'gtwelve-elementor' ),
				'type'  => Controls_Manager::MEDIA,
			)
		);
		$repeater->add_control(
			'alt_text',
			array(
				'label'       => esc_html__( 'Alt Text', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Partner logo', 'gtwelve-elementor' ),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'dynamic'     => array( 'active' => true ),
			)
		);

		$this->add_control(
			'logos',
			array(
				'label'         => esc_html__( 'Partner Logos', 'gtwelve-elementor' ),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'title_field'   => '{{{ alt_text || "Logo" }}}',
				'button_text'   => esc_html__( 'Add Logo', 'gtwelve-elementor' ),
				'prevent_empty' => false,
				'default'       => array(),
				'description'   => esc_html__( 'Add, reorder, duplicate, replace, or remove logos here. Open a logo item to edit its image, alt text, and link.', 'gtwelve-elementor' ),
			)
		);

		$this->end_controls_section();
	}

	private function register_motion_controls(): void {
		$this->start_controls_section(
			'motion_section',
			array(
				'label' => esc_html__( 'Carousel Motion', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'direction',
			array(
				'label'   => esc_html__( 'Direction', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Left', 'gtwelve-elementor' ),
					'right' => esc_html__( 'Right', 'gtwelve-elementor' ),
				),
			)
		);

		$this->add_control(
			'duration',
			array(
				'label'       => esc_html__( 'Loop Duration', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 's' ),
				'range'       => array( 's' => array( 'min' => 8, 'max' => 120, 'step' => 1 ) ),
				'default'     => array( 'size' => 38, 'unit' => 's' ),
				'description' => esc_html__( 'A larger value moves the logos more slowly.', 'gtwelve-elementor' ),
				'selectors'   => array( '{{WRAPPER}} .g12-partner-carousel' => '--g12-partner-duration: {{SIZE}}s;' ),
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

	private function register_heading_style_controls(): void {
		$this->start_controls_section( 'heading_style', array( 'label' => esc_html__( 'Heading and Description', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'text_alignment', array( 'label' => esc_html__( 'Alignment', 'gtwelve-elementor' ), 'type' => Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-right' ) ), 'default' => 'center', 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__header' => 'text-align: {{VALUE}};' ) ) );
		$this->add_control( 'heading_color', array( 'label' => esc_html__( 'Heading Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#111111', 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__heading' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .g12-partner-carousel__heading', 'fields_options' => array( 'typography' => array( 'default' => 'custom' ), 'font_size' => array( 'default' => array( 'size' => 32, 'unit' => 'px' ) ), 'font_weight' => array( 'default' => '600' ), 'line_height' => array( 'default' => array( 'size' => 1.2, 'unit' => 'em' ) ) ) ) );
		$this->add_responsive_control( 'heading_spacing', array( 'label' => esc_html__( 'Heading Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 16, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#555555', 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .g12-partner-carousel__description' ) );
		$this->end_controls_section();
	}

	private function register_carousel_style_controls(): void {
		$this->start_controls_section( 'carousel_style', array( 'label' => esc_html__( 'Carousel Container', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'carousel_background', array( 'label' => esc_html__( 'Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#f0f5fc', 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__viewport' => 'background-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'carousel_height', array( 'label' => esc_html__( 'Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 40, 'max' => 180 ) ), 'default' => array( 'size' => 70, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__viewport' => 'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'carousel_padding', array( 'label' => esc_html__( 'Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 10, 'right' => 10, 'bottom' => 10, 'left' => 10, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__viewport' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'carousel_radius', array( 'label' => esc_html__( 'Border Radius', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'default' => array( 'top' => 50, 'right' => 50, 'bottom' => 50, 'left' => 50, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__viewport' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'carousel_top_spacing', array( 'label' => esc_html__( 'Top Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 20, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__viewport' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_group_control( Group_Control_Border::get_type(), array( 'name' => 'carousel_border', 'selector' => '{{WRAPPER}} .g12-partner-carousel__viewport' ) );
		$this->end_controls_section();
	}

	private function register_logo_style_controls(): void {
		$this->start_controls_section( 'logo_style', array( 'label' => esc_html__( 'Logos', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'logo_height', array( 'label' => esc_html__( 'Logo Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 16, 'max' => 100 ) ), 'default' => array( 'size' => 40, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 26, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__logo img' => 'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'logo_gap', array( 'label' => esc_html__( 'Logo Gap', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 140 ) ), 'default' => array( 'size' => 60, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 30, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel' => '--g12-partner-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'grayscale', array( 'label' => esc_html__( 'Grayscale', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Yes', 'gtwelve-elementor' ), 'label_off' => esc_html__( 'No', 'gtwelve-elementor' ), 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'logo_opacity', array( 'label' => esc_html__( 'Opacity', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0.1, 'max' => 1, 'step' => 0.05 ) ), 'default' => array( 'size' => 1 ), 'selectors' => array( '{{WRAPPER}} .g12-partner-carousel__logo img' => 'opacity: {{SIZE}};' ) ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$logos    = $settings['logos'] ?? array();

		if ( empty( $logos ) ) {
			return;
		}

		$heading_tag  = in_array( $settings['heading_tag'] ?? 'h2', array( 'h2', 'h3', 'h4', 'h5', 'h6', 'p' ), true ) ? $settings['heading_tag'] : 'h2';
		$root_classes = array( 'g12-partner-carousel', 'g12-partner-carousel--' . ( 'right' === ( $settings['direction'] ?? 'left' ) ? 'right' : 'left' ) );

		if ( 'yes' === ( $settings['pause_on_hover'] ?? 'yes' ) ) {
			$root_classes[] = 'g12-partner-carousel--pause';
		}

		if ( 'yes' === ( $settings['grayscale'] ?? 'yes' ) ) {
			$root_classes[] = 'g12-partner-carousel--grayscale';
		}
		?>
		<section class="<?php echo esc_attr( implode( ' ', $root_classes ) ); ?>">
			<?php if ( ! empty( $settings['heading'] ) || ! empty( $settings['description'] ) ) : ?>
				<header class="g12-partner-carousel__header">
					<?php if ( ! empty( $settings['heading'] ) ) : ?><<?php echo esc_html( $heading_tag ); ?> class="g12-partner-carousel__heading"><?php echo esc_html( $settings['heading'] ); ?></<?php echo esc_html( $heading_tag ); ?>><?php endif; ?>
					<?php if ( ! empty( $settings['description'] ) ) : ?><div class="g12-partner-carousel__description"><?php echo wp_kses_post( $settings['description'] ); ?></div><?php endif; ?>
				</header>
			<?php endif; ?>

			<div class="g12-partner-carousel__viewport">
				<div class="g12-partner-carousel__track">
					<?php $this->render_logo_group( $logos, 1, false ); ?>
					<?php $this->render_logo_group( $logos, 2, true ); ?>
				</div>
			</div>
		</section>
		<?php
	}

	private function render_logo_group( array $logos, int $copy, bool $duplicate ): void {
		$aria = $duplicate ? ' aria-hidden="true"' : '';
		echo '<div class="g12-partner-carousel__group"' . $aria . '>';

		foreach ( $logos as $index => $item ) {
			$image = $item['logo'] ?? array();
			$url   = $image['url'] ?? '';

			if ( empty( $url ) ) {
				continue;
			}

			$link_key = 'partner_logo_' . $copy . '_' . $index;
			$tag      = ! empty( $item['link']['url'] ) ? 'a' : 'span';
			$this->add_render_attribute( $link_key, 'class', 'g12-partner-carousel__logo' );

			if ( 'a' === $tag ) {
				$this->add_link_attributes( $link_key, $item['link'] );
				if ( $duplicate ) {
					$this->add_render_attribute( $link_key, 'tabindex', '-1' );
				}
			}

			echo '<' . esc_html( $tag ) . ' ' . $this->get_render_attribute_string( $link_key ) . '>';

			$alt = $duplicate ? '' : ( $item['alt_text'] ?? esc_html__( 'Partner logo', 'gtwelve-elementor' ) );
			if ( ! empty( $image['id'] ) ) {
				echo wp_get_attachment_image( absint( $image['id'] ), 'full', false, array( 'alt' => esc_attr( $alt ), 'loading' => 'lazy' ) );
			} else {
				echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy">';
			}

			echo '</' . esc_html( $tag ) . '>';
		}

		echo '</div>';
	}

}
