<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Expandable_Content extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_see_more';
	}

	public function get_title(): string
	{
		return esc_html__('Expandable Content', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-read-more';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('see more', 'read more', 'toggle', 'content', 'expandable');
	}

	public function get_style_depends(): array
	{
		return array('gtwelve-elementor-widgets');
	}

	public function get_script_depends(): array
	{
		return array('gtwelve-elementor-widgets');
	}

	protected function register_controls(): void
	{
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__('Content', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__('Button Text', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('See More', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'less_text',
			array(
				'label'   => esc_html__('Close Text', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('See Less', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'content',
			array(
				'label'   => esc_html__('Hidden Content', 'gtwelve-elementor'),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__('Add your hidden content here. This area opens when the user clicks the See More button.', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'open_by_default',
			array(
				'label'        => esc_html__('Open by Default', 'gtwelve-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'gtwelve-elementor'),
				'label_off'    => esc_html__('No', 'gtwelve-elementor'),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__('Button', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'     => esc_html__('Alignment', 'gtwelve-elementor'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__('Left', 'gtwelve-elementor'),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__('Center', 'gtwelve-elementor'),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__('Right', 'gtwelve-elementor'),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .expandable-content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_width',
			array(
				'label'     => esc_html__('Width', 'gtwelve-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'auto',
				'options'   => array(
					'auto' => esc_html__('Auto', 'gtwelve-elementor'),
					'100%' => esc_html__('Full Width', 'gtwelve-elementor'),
				),
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__button' => 'width: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .expandable-content__button',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__('Text Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .expandable-content__icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__('Hover Text Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__button:hover, {{WRAPPER}} .expandable-content__button:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .expandable-content__button:hover .expandable-content__icon svg, {{WRAPPER}} .expandable-content__button:focus .expandable-content__icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background',
			array(
				'label'     => esc_html__('Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_background',
			array(
				'label'     => esc_html__('Hover Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__button:hover, {{WRAPPER}} .expandable-content__button:focus' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_color',
			array(
				'label'     => esc_html__('Border Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__button' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_width',
			array(
				'label'      => esc_html__('Border Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__button' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__('Padding', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_radius',
			array(
				'label'      => esc_html__('Border Radius', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_gap',
			array(
				'label'      => esc_html__('Text/Icon Gap', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 40)),
				'default'    => array('size' => 8, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content' => '--expandable-button-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon_style',
			array(
				'label' => esc_html__('Icon', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__('Size', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 8, 'max' => 64)),
				'default'    => array('size' => 20, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content' => '--expandable-button-icon-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__('Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_open_rotation',
			array(
				'label'      => esc_html__('Open Rotation', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('deg'),
				'range'      => array('deg' => array('min' => -180, 'max' => 180)),
				'default'    => array('size' => 90, 'unit' => 'deg'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content.is-open .expandable-content__icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			array(
				'label' => esc_html__('Content Panel', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .expandable-content__content',
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__('Text Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content' => 'color: {{VALUE}};',
				),
			)
		);

		foreach (array('h1', 'h2', 'h3', 'h4', 'h5', 'h6') as $heading_tag) {
			$heading_label = strtoupper($heading_tag);

			$this->add_control(
				$heading_tag . '_style_heading',
				array(
					'label'     => sprintf(
						/* translators: %s: heading level, for example H1. */
						esc_html__('%s Style', 'gtwelve-elementor'),
						$heading_label
					),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				)
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				array(
					'name'     => $heading_tag . '_typography',
					'selector' => '{{WRAPPER}} .expandable-content__content ' . $heading_tag,
				)
			);

			$this->add_control(
				$heading_tag . '_color',
				array(
					'label'     => sprintf(
						/* translators: %s: heading level, for example H1. */
						esc_html__('%s Color', 'gtwelve-elementor'),
						$heading_label
					),
					'type'      => Controls_Manager::COLOR,
					'selectors' => array(
						'{{WRAPPER}} .expandable-content__content ' . $heading_tag => 'color: {{VALUE}};',
					),
				)
			);

			$this->add_responsive_control(
				$heading_tag . '_top_spacing',
				array(
					'label'      => sprintf(
						/* translators: %s: heading level, for example H1. */
						esc_html__('%s Top Space', 'gtwelve-elementor'),
						$heading_label
					),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('px', 'em'),
					'range'      => array(
						'px' => array('min' => 0, 'max' => 80),
						'em' => array('min' => 0, 'max' => 5, 'step' => 0.1),
					),
					'selectors'  => array(
						'{{WRAPPER}} .expandable-content__content ' . $heading_tag . ':not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}};',
					),
				)
			);

			$this->add_responsive_control(
				$heading_tag . '_bottom_spacing',
				array(
					'label'      => sprintf(
						/* translators: %s: heading level, for example H1. */
						esc_html__('%s Bottom Space', 'gtwelve-elementor'),
						$heading_label
					),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => array('px', 'em'),
					'range'      => array(
						'px' => array('min' => 0, 'max' => 80),
						'em' => array('min' => 0, 'max' => 5, 'step' => 0.1),
					),
					'selectors'  => array(
						'{{WRAPPER}} .expandable-content__content ' . $heading_tag => 'margin-bottom: {{SIZE}}{{UNIT}};',
					),
				)
			);
		}

		$this->add_control(
			'paragraph_style_heading',
			array(
				'label'     => esc_html__('Paragraphs', 'gtwelve-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'paragraph_typography',
				'selector' => '{{WRAPPER}} .expandable-content__content p',
			)
		);

		$this->add_control(
			'paragraph_color',
			array(
				'label'     => esc_html__('Paragraph Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content p' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'paragraph_spacing',
			array(
				'label'      => esc_html__('Paragraph Space', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em'),
				'range'      => array(
					'px' => array('min' => 0, 'max' => 80),
					'em' => array('min' => 0, 'max' => 5, 'step' => 0.1),
				),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__content p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'list_style_heading',
			array(
				'label'     => esc_html__('Lists', 'gtwelve-elementor'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'list_typography',
				'selector' => '{{WRAPPER}} .expandable-content__content ul, {{WRAPPER}} .expandable-content__content ol, {{WRAPPER}} .expandable-content__content li',
			)
		);

		$this->add_control(
			'list_color',
			array(
				'label'     => esc_html__('List Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content ul, {{WRAPPER}} .expandable-content__content ol, {{WRAPPER}} .expandable-content__content li' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'unordered_list_marker',
			array(
				'label'     => esc_html__('Bullet Style', 'gtwelve-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''       => esc_html__('Default', 'gtwelve-elementor'),
					'disc'   => esc_html__('Disc', 'gtwelve-elementor'),
					'circle' => esc_html__('Circle', 'gtwelve-elementor'),
					'square' => esc_html__('Square', 'gtwelve-elementor'),
					'none'   => esc_html__('Hide Bullets', 'gtwelve-elementor'),
				),
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content ul' => 'list-style-type: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'ordered_list_marker',
			array(
				'label'     => esc_html__('Number Style', 'gtwelve-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''              => esc_html__('Default', 'gtwelve-elementor'),
					'decimal'       => esc_html__('Decimal', 'gtwelve-elementor'),
					'lower-alpha'   => esc_html__('Lower Alpha', 'gtwelve-elementor'),
					'upper-alpha'   => esc_html__('Upper Alpha', 'gtwelve-elementor'),
					'lower-roman'   => esc_html__('Lower Roman', 'gtwelve-elementor'),
					'upper-roman'   => esc_html__('Upper Roman', 'gtwelve-elementor'),
					'none'          => esc_html__('Hide Numbers', 'gtwelve-elementor'),
				),
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content ol' => 'list-style-type: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'list_marker_position',
			array(
				'label'     => esc_html__('Marker Position', 'gtwelve-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => array(
					''        => esc_html__('Default', 'gtwelve-elementor'),
					'outside' => esc_html__('Outside', 'gtwelve-elementor'),
					'inside'  => esc_html__('Inside', 'gtwelve-elementor'),
				),
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content ul, {{WRAPPER}} .expandable-content__content ol' => 'list-style-position: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'list_spacing',
			array(
				'label'      => esc_html__('List Bottom Space', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em'),
				'range'      => array(
					'px' => array('min' => 0, 'max' => 80),
					'em' => array('min' => 0, 'max' => 5, 'step' => 0.1),
				),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__content ul, {{WRAPPER}} .expandable-content__content ol' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'list_item_spacing',
			array(
				'label'      => esc_html__('List Item Space', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em'),
				'range'      => array(
					'px' => array('min' => 0, 'max' => 60),
					'em' => array('min' => 0, 'max' => 4, 'step' => 0.1),
				),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__content li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'list_indent',
			array(
				'label'      => esc_html__('List Indent', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', 'em'),
				'range'      => array(
					'px' => array('min' => 0, 'max' => 80),
					'em' => array('min' => 0, 'max' => 5, 'step' => 0.1),
				),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__content ul, {{WRAPPER}} .expandable-content__content ol' => 'padding-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_background',
			array(
				'label'     => esc_html__('Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_spacing',
			array(
				'label'      => esc_html__('Top Spacing', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 120)),
				'default'    => array('size' => 24, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content' => '--expandable-content-spacing: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__('Padding', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_radius',
			array(
				'label'      => esc_html__('Border Radius', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', '%'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_border_color',
			array(
				'label'     => esc_html__('Border Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .expandable-content__content' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'content_border_width',
			array(
				'label'      => esc_html__('Border Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px'),
				'selectors'  => array(
					'{{WRAPPER}} .expandable-content__content' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings = $this->get_settings_for_display();
		$is_open  = 'yes' === ($settings['open_by_default'] ?? '');
		?>
		<div class="expandable-content<?php echo $is_open ? ' is-open' : ''; ?>" data-expandable-content>
			<button class="expandable-content__button" type="button" data-expandable-content-toggle aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>">
				<span class="expandable-content__button-text" data-open-text="<?php echo esc_attr($settings['button_text'] ?? ''); ?>" data-close-text="<?php echo esc_attr($settings['less_text'] ?? ''); ?>">
					<?php echo esc_html($is_open ? ($settings['less_text'] ?? '') : ($settings['button_text'] ?? '')); ?>
				</span>
				<span class="expandable-content__icon" role="presentation" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
						<path d="M8.16667 15L7 13.8333L10.8333 10L7 6.16667L8.16667 5L13.1667 10L8.16667 15Z"></path>
					</svg>
				</span>
			</button>

			<div class="expandable-content__content" data-expandable-content-panel<?php echo $is_open ? '' : ' hidden'; ?>>
				<?php echo wp_kses_post($settings['content'] ?? ''); ?>
			</div>
		</div>
		<?php
	}
}
