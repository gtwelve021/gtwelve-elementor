<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Feature_Benefits extends Widget_Base {
	public function get_name(): string {
		return 'g12_feature_benefits';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Feature Benefits', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-image';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'features', 'benefits', 'image', 'free zone', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'swiper', 'gtwelve-elementor-feature-benefits' );
	}

	public function get_script_depends(): array {
		return array( 'gtwelve-elementor-feature-benefits' );
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Benefits', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'image',
			array(
				'label'       => esc_html__( 'Image', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Feature title', 'gtwelve-elementor' ),
			)
		);
		$repeater->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'label_block' => true,
				'default'     => esc_html__( 'Add a short description for this benefit.', 'gtwelve-elementor' ),
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__( 'Benefit Items', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => array(
					array(
						'image'       => array(),
						'title'       => esc_html__( 'Sector-Specific Free Zones', 'gtwelve-elementor' ),
						'description' => esc_html__( 'The right free zone for your business plans will offer access to invaluable resources and support.', 'gtwelve-elementor' ),
					),
					array(
						'image'       => array(),
						'title'       => esc_html__( '100% Ownership', 'gtwelve-elementor' ),
						'description' => esc_html__( 'A free zone company in UAE entitles you to 100% ownership of your business without the need for a local partner.', 'gtwelve-elementor' ),
					),
					array(
						'image'       => array(),
						'title'       => esc_html__( 'Cost Efficiency', 'gtwelve-elementor' ),
						'description' => esc_html__( 'Free zone business setup is generally cost-efficient. With over 50 free zones to choose from, you can find licensing options for every budget.', 'gtwelve-elementor' ),
					),
				),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'slider_section', array( 'label' => esc_html__( 'Swiper Slider', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_CONTENT ) );
		$this->add_control( 'autoplay', array( 'label' => esc_html__( 'Autoplay', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'autoplay_delay', array( 'label' => esc_html__( 'Autoplay Delay (ms)', 'gtwelve-elementor' ), 'type' => Controls_Manager::NUMBER, 'min' => 1000, 'max' => 15000, 'step' => 100, 'default' => 3500, 'condition' => array( 'autoplay' => 'yes' ) ) );
		$this->add_control( 'transition_speed', array( 'label' => esc_html__( 'Transition Speed (ms)', 'gtwelve-elementor' ), 'type' => Controls_Manager::NUMBER, 'min' => 100, 'max' => 2000, 'step' => 50, 'default' => 500 ) );
		$this->add_control( 'pause_on_hover', array( 'label' => esc_html__( 'Pause on Hover', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes', 'condition' => array( 'autoplay' => 'yes' ) ) );
		$this->add_control( 'infinite_loop', array( 'label' => esc_html__( 'Infinite Loop', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'show_pagination', array( 'label' => esc_html__( 'Show Pagination', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'layout_style', array( 'label' => esc_html__( 'Layout', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control(
			'column_gap',
			array(
				'label' => esc_html__( 'Column Gap', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ), 'range' => array( 'px' => array( 'min' => 0, 'max' => 160 ), 'em' => array( 'min' => 0, 'max' => 10, 'step' => .1 ) ),
				'default' => array( 'size' => 60, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 35, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 32, 'unit' => 'px' ),
				'selectors' => array( '{{WRAPPER}} .g12-feature-benefits' => '--g12-feature-benefits-gap: {{SIZE}}{{UNIT}};' ),
			)
		);
		$this->add_responsive_control(
			'alignment',
			array(
				'label' => esc_html__( 'Alignment', 'gtwelve-elementor' ), 'type' => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array( 'title' => esc_html__( 'Left', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-left' ),
					'center' => array( 'title' => esc_html__( 'Center', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-center' ),
					'right' => array( 'title' => esc_html__( 'Right', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-right' ),
				),
				'default' => 'center', 'toggle' => false,
				'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__item' => 'text-align: {{VALUE}};', '{{WRAPPER}} .g12-feature-benefits__image-wrap' => 'justify-content: {{VALUE}};' ),
			)
		);
		$this->end_controls_section();

		$this->start_controls_section( 'image_style', array( 'label' => esc_html__( 'Image', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'image_width', array( 'label' => esc_html__( 'Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px', '%', 'vw' ), 'range' => array( 'px' => array( 'min' => 10, 'max' => 300 ), '%' => array( 'min' => 1, 'max' => 100 ), 'vw' => array( 'min' => 1, 'max' => 30 ) ), 'default' => array( 'size' => 52, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__image' => 'width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px', 'vw' ), 'range' => array( 'px' => array( 'min' => 10, 'max' => 300 ), 'vw' => array( 'min' => 1, 'max' => 30 ) ), 'default' => array( 'size' => 52, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__image' => 'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'image_object_fit', array( 'label' => esc_html__( 'Object Fit', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'contain', 'options' => array( 'contain' => esc_html__( 'Contain', 'gtwelve-elementor' ), 'cover' => esc_html__( 'Cover', 'gtwelve-elementor' ), 'fill' => esc_html__( 'Fill', 'gtwelve-elementor' ) ), 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__image' => 'object-fit: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'image_gap', array( 'label' => esc_html__( 'Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 10, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__image-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'title_style', array( 'label' => esc_html__( 'Title', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .g12-feature-benefits__title', 'fields_options' => array( 'typography' => array( 'default' => 'custom' ), 'font_size' => array( 'default' => array( 'size' => 16, 'unit' => 'px' ) ), 'font_weight' => array( 'default' => '700' ), 'line_height' => array( 'default' => array( 'size' => 1.3, 'unit' => 'em' ) ) ) ) );
		$this->add_responsive_control( 'title_gap', array( 'label' => esc_html__( 'Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 14, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'description_style', array( 'label' => esc_html__( 'Description', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__description' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .g12-feature-benefits__description', 'fields_options' => array( 'typography' => array( 'default' => 'custom' ), 'font_size' => array( 'default' => array( 'size' => 16, 'unit' => 'px' ) ), 'font_weight' => array( 'default' => '400' ), 'line_height' => array( 'default' => array( 'size' => 1.4, 'unit' => 'em' ) ) ) ) );
		$this->add_responsive_control( 'description_width', array( 'label' => esc_html__( 'Maximum Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px', '%' ), 'range' => array( 'px' => array( 'min' => 120, 'max' => 600 ), '%' => array( 'min' => 20, 'max' => 100 ) ), 'default' => array( 'size' => 340, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__description' => 'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'pagination_style', array( 'label' => esc_html__( 'Pagination', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => array( 'show_pagination' => 'yes' ) ) );
		$this->add_control( 'pagination_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__pagination' => '--swiper-pagination-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'pagination_gap', array( 'label' => esc_html__( 'Top Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 24, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-feature-benefits__pagination' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['items'] ) ) {
			return;
		}
		?>
		<div class="g12-feature-benefits swiper" data-g12-feature-benefits data-autoplay="<?php echo esc_attr( $settings['autoplay'] ?? 'yes' ); ?>" data-delay="<?php echo esc_attr( (string) ( $settings['autoplay_delay'] ?? 3500 ) ); ?>" data-speed="<?php echo esc_attr( (string) ( $settings['transition_speed'] ?? 500 ) ); ?>" data-pause-hover="<?php echo esc_attr( $settings['pause_on_hover'] ?? 'yes' ); ?>" data-loop="<?php echo esc_attr( $settings['infinite_loop'] ?? 'yes' ); ?>">
			<div class="g12-feature-benefits__wrapper swiper-wrapper">
			<?php foreach ( $settings['items'] as $item ) : ?>
				<div class="g12-feature-benefits__item swiper-slide elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
					<?php if ( ! empty( $item['image']['url'] ) ) : ?>
						<div class="g12-feature-benefits__image-wrap">
							<img class="g12-feature-benefits__image" src="<?php echo esc_url( $item['image']['url'] ); ?>" alt="<?php echo esc_attr( $item['title'] ?? '' ); ?>">
						</div>
					<?php endif; ?>
					<?php if ( '' !== trim( (string) $item['title'] ) ) : ?><h3 class="g12-feature-benefits__title"><?php echo esc_html( $item['title'] ); ?></h3><?php endif; ?>
					<?php if ( '' !== trim( (string) $item['description'] ) ) : ?><p class="g12-feature-benefits__description"><?php echo esc_html( $item['description'] ); ?></p><?php endif; ?>
				</div>
			<?php endforeach; ?>
			</div>
			<?php if ( 'yes' === ( $settings['show_pagination'] ?? '' ) ) : ?><div class="g12-feature-benefits__pagination swiper-pagination"></div><?php endif; ?>
		</div>
		<?php
	}
}
