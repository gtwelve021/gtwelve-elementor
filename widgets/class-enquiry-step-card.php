<?php
namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enquiry_Step_Card extends Widget_Base {
	public function get_name() {
		return 'g12_enquiry_step_card';
	}

	public function get_title() {
		return esc_html__( 'G12 Enquiry Step Card', 'gtwelve-elementor' );
	}

	public function get_icon() {
		return 'eicon-editor-list-ul';
	}

	public function get_categories() {
		return array( 'gtwelve' );
	}

	public function get_keywords() {
		return array( 'g12', 'enquiry', 'step', 'card', 'process' );
	}

	public function get_style_depends() {
		return array( 'gtwelve-elementor-widgets' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'step_number',
			array(
				'label'       => esc_html__( 'Step Number', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '1.', 'gtwelve-elementor' ),
				'placeholder' => esc_html__( '1.', 'gtwelve-elementor' ),
				'label_block' => false,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Send an Enquiry', 'gtwelve-elementor' ),
				'placeholder' => esc_html__( 'Send an Enquiry', 'gtwelve-elementor' ),
				'rows'        => 2,
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => esc_html__( "Drop us a line, and we'll get the ball rolling-no strings attached!", 'gtwelve-elementor' ),
				'placeholder' => esc_html__( 'Drop us a line...', 'gtwelve-elementor' ),
			)
		);

		$this->add_control(
			'card_link',
			array(
				'label'       => esc_html__( 'Link', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'gtwelve-elementor' ),
				'options'     => array( 'url', 'is_external', 'nofollow' ),
			)
		);

		$this->add_responsive_control(
			'alignment',
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
					'justify' => array(
						'title' => esc_html__( 'Justified', 'gtwelve-elementor' ),
						'icon'  => 'eicon-text-align-justify',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .g12-enquiry-step-card' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_style',
			array(
				'label' => esc_html__( 'Card', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__( 'Padding', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'default'    => array(
					'top'      => 12,
					'right'    => 18,
					'bottom'   => 16,
					'left'     => 22,
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .g12-enquiry-step-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_margin',
			array(
				'label'      => esc_html__( 'Margin', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', 'rem', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .g12-enquiry-step-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'card_background',
				'label'    => esc_html__( 'Background', 'gtwelve-elementor' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}}',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color'      => array(
						'default' => '#000000',
					),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}}',
			)
		);

		$this->add_responsive_control(
			'card_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em', 'rem' ),
				'selectors'  => array(
					'{{WRAPPER}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'card_box_shadow',
				'selector' => '{{WRAPPER}}',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number_style',
			array(
				'label' => esc_html__( 'Number', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'number_color',
			array(
				'label'     => esc_html__( 'Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3c33c',
				'selectors' => array(
					'{{WRAPPER}} .g12-enquiry-step-card__number' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'number_typography',
				'selector' => '{{WRAPPER}} .g12-enquiry-step-card__number',
			)
		);

		$this->add_responsive_control(
			'number_gap',
			array(
				'label'      => esc_html__( 'Gap', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 40,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .g12-enquiry-step-card__number' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title_style',
			array(
				'label' => esc_html__( 'Title', 'gtwelve-elementor' ),
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
					'{{WRAPPER}} .g12-enquiry-step-card__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .g12-enquiry-step-card__title',
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .g12-enquiry-step-card__title',
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Bottom Spacing', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 80,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 36,
				),
				'selectors'  => array(
					'{{WRAPPER}} .g12-enquiry-step-card__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_description_style',
			array(
				'label' => esc_html__( 'Description', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .g12-enquiry-step-card__description' => 'color: {{VALUE}};',
					'{{WRAPPER}} .g12-enquiry-step-card__description p' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'description_link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f3c33c',
				'selectors' => array(
					'{{WRAPPER}} .g12-enquiry-step-card__description a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'description_link_hover_color',
			array(
				'label'     => esc_html__( 'Link Hover Color', 'gtwelve-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-enquiry-step-card__description a:hover, {{WRAPPER}} .g12-enquiry-step-card__description a:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .g12-enquiry-step-card__description',
			)
		);

		$this->add_responsive_control(
			'description_spacing',
			array(
				'label'      => esc_html__( 'Paragraph Spacing', 'gtwelve-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', 'rem' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 40,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .g12-enquiry-step-card__description p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$number      = isset( $settings['step_number'] ) ? $settings['step_number'] : '';
		$title       = isset( $settings['title'] ) ? $settings['title'] : '';
		$description = isset( $settings['description'] ) ? $settings['description'] : '';
		$has_link    = ! empty( $settings['card_link']['url'] );

		if ( $has_link ) {
			$this->add_link_attributes( 'card_link', $settings['card_link'] );
		}
		?>
		<<?php echo $has_link ? 'a' : 'div'; ?> class="g12-enquiry-step-card" <?php $has_link ? $this->print_render_attribute_string( 'card_link' ) : null; ?>>
			<?php if ( '' !== $title || '' !== $number ) : ?>
				<div class="g12-enquiry-step-card__heading">
					<?php if ( '' !== $number ) : ?>
						<span class="g12-enquiry-step-card__number"><?php echo esc_html( $number ); ?></span>
					<?php endif; ?>

					<?php if ( '' !== $title ) : ?>
						<h3 class="g12-enquiry-step-card__title"><?php echo wp_kses_post( nl2br( $title ) ); ?></h3>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( '' !== $description ) : ?>
				<div class="g12-enquiry-step-card__description">
					<?php echo wp_kses_post( $description ); ?>
				</div>
			<?php endif; ?>
		</<?php echo $has_link ? 'a' : 'div'; ?>>
		<?php
	}
}
