<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class AI_Search extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_ai_search';
	}

	public function get_title(): string
	{
		return esc_html__('AI Search', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-search';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('ai', 'search', 'dubai', 'ask', 'chat');
	}

	public function get_style_depends(): array
	{
		return array('gtwelve-elementor-ai-search');
	}

	public function get_script_depends(): array
	{
		return array('gtwelve-elementor-ai-search');
	}

	protected function register_controls(): void
	{
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls(): void
	{
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__('Content', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'   => esc_html__('Search Icon', 'gtwelve-elementor'),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => home_url('/wp-content/uploads/2025/05/search-icon.avif'),
				),
			)
		);

		$this->add_control(
			'placeholder',
			array(
				'label'       => esc_html__('Placeholder', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Ask anything about Dubai business setup...', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__('Button Text', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Ask', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'thinking_text',
			array(
				'label'   => esc_html__('Loading Text', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Thinking...', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'answer_label',
			array(
				'label'   => esc_html__('Answer Label', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Answer:', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'empty_message',
			array(
				'label'       => esc_html__('Empty Question Message', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Please enter a question.', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'error_message',
			array(
				'label'       => esc_html__('Error Message', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Error getting response.', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'ajax_action',
			array(
				'label'       => esc_html__('AJAX Action', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'dubai_ai_ask',
				'description' => esc_html__('Plugin-owned AI endpoint used by this widget.', 'gtwelve-elementor'),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_controls(): void
	{
		$this->start_controls_section(
			'section_form_style',
			array(
				'label' => esc_html__('Form', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'form_width',
			array(
				'label'      => esc_html__('Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('%', 'px'),
				'range'      => array(
					'%'  => array('min' => 10, 'max' => 100),
					'px' => array('min' => 240, 'max' => 1400),
				),
				'selectors'  => array(
					'{{WRAPPER}} .g12-ai-search .search-form' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'form_border_color',
			array(
				'label'     => esc_html__('Border Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search .search-form' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'form_background',
			array(
				'label'     => esc_html__('Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search .search-form' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'label'    => esc_html__('Input Typography', 'gtwelve-elementor'),
				'selector' => '{{WRAPPER}} .g12-ai-search .search-field',
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label'     => esc_html__('Input Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search .search-field' => 'color: {{VALUE}};',
					'{{WRAPPER}} .g12-ai-search .search-field::placeholder' => 'color: {{VALUE}};',
				),
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .g12-ai-search .search-submit',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__('Text Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search .search-submit' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background',
			array(
				'label'     => esc_html__('Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search .search-submit' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_color',
			array(
				'label'     => esc_html__('Border Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search .search-submit' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_response_style',
			array(
				'label' => esc_html__('Response', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'response_background',
			array(
				'label'     => esc_html__('Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search__response' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'response_color',
			array(
				'label'     => esc_html__('Text Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .g12-ai-search__response' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'response_typography',
				'selector' => '{{WRAPPER}} .g12-ai-search__response',
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings    = $this->get_settings_for_display();
		$widget_id   = 'g12-ai-search-' . $this->get_id();
		$button_text = $settings['button_text'] ?? esc_html__('Ask', 'gtwelve-elementor');
		$icon_url    = $settings['icon']['url'] ?? '';
		?>
		<div
			id="<?php echo esc_attr($widget_id); ?>"
			class="g12-ai-search rad-faq-ask-search"
			data-g12-ai-search
			data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
			data-action="<?php echo esc_attr($settings['ajax_action'] ?? 'dubai_ai_ask'); ?>"
			data-thinking-text="<?php echo esc_attr($settings['thinking_text'] ?? 'Thinking...'); ?>"
			data-empty-message="<?php echo esc_attr($settings['empty_message'] ?? 'Please enter a question.'); ?>"
			data-error-message="<?php echo esc_attr($settings['error_message'] ?? 'Error getting response.'); ?>"
			data-answer-label="<?php echo esc_attr($settings['answer_label'] ?? 'Answer:'); ?>"
			data-button-text="<?php echo esc_attr($button_text); ?>"
		>
			<div class="search-form g12-ai-search__form" role="search">
				<?php if ($icon_url) : ?>
					<div class="search-form-img g12-ai-search__icon">
						<img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr__('search-icon', 'gtwelve-elementor'); ?>" class="search-icon">
					</div>
				<?php endif; ?>

				<input
					type="text"
					id="<?php echo esc_attr($widget_id . '-question'); ?>"
					class="search-field g12-ai-search__field"
					placeholder="<?php echo esc_attr($settings['placeholder'] ?? ''); ?>"
					data-g12-ai-search-input
				>

				<button type="button" class="search-submit g12-ai-search__submit" data-g12-ai-search-submit>
					<?php echo esc_html($button_text); ?>
				</button>

				<div id="<?php echo esc_attr($widget_id . '-response'); ?>" class="g12-ai-search__response" data-g12-ai-search-response aria-live="polite" hidden></div>
			</div>
		</div>
		<?php
	}
}
