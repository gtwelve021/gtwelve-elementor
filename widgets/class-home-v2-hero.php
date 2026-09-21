<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Home_V2_Hero extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_home_v2_hero';
	}

	public function get_title(): string
	{
		return esc_html__('G12 Home V2 Hero', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-site-search';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('g12', 'home', 'hero', 'ai', 'search', 'generate success');
	}

	public function get_style_depends(): array
	{
		return array('gtwelve-elementor-home-v2-hero');
	}

	public function get_script_depends(): array
	{
		return array('gtwelve-elementor-home-v2-hero');
	}

	protected function register_controls(): void
	{
		$this->register_hero_controls();
		$this->register_search_controls();
		$this->register_results_controls();
		$this->register_layout_controls();
		$this->register_heading_style_controls();
		$this->register_search_style_controls();
		$this->register_supporting_style_controls();
	}

	private function register_hero_controls(): void
	{
		$this->start_controls_section(
			'hero_content',
			array(
				'label' => esc_html__('Hero Content', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control('symbol', array('label' => esc_html__('Symbol', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => '#'));
		$this->add_control('heading_first', array('label' => esc_html__('Heading First Line', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('GENERATE', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control('heading_second', array('label' => esc_html__('Heading Second Line', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('SUCCESS', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control(
			'hero_image',
			array(
				'label'   => esc_html__('Team Image', 'gtwelve-elementor'),
				'type'    => Controls_Manager::MEDIA,
				'default' => array('url' => home_url('/wp-content/uploads/2025/11/Home-Banner-G12-1.webp')),
			)
		);
		$this->add_control('image_alt', array('label' => esc_html__('Image Alt Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Our team ready to help you generate success', 'gtwelve-elementor'), 'label_block' => true));

		$this->add_control('rating_heading', array('label' => esc_html__('Rating Badge', 'gtwelve-elementor'), 'type' => Controls_Manager::HEADING, 'separator' => 'before'));
		$this->add_control('rating_logo', array('label' => esc_html__('Google Logo', 'gtwelve-elementor'), 'type' => Controls_Manager::MEDIA, 'default' => array('url' => home_url('/wp-content/uploads/2025/03/icons8-google-48.png'))));
		$this->add_control('rating_score', array('label' => esc_html__('Rating Score', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => '4.9'));
		$this->add_control('rating_title', array('label' => esc_html__('Rating Title', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Trusted Consultants', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control('rating_verified', array('label' => esc_html__('Verified Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('verified by Trustindex', 'gtwelve-elementor'), 'label_block' => true));

		$this->end_controls_section();
	}

	private function register_search_controls(): void
	{
		$this->start_controls_section('search_content', array('label' => esc_html__('Search Content', 'gtwelve-elementor'), 'tab' => Controls_Manager::TAB_CONTENT));
		$this->add_control('placeholder', array('label' => esc_html__('Placeholder', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Search anything about business setup', 'gtwelve-elementor'), 'label_block' => true));

		$typing_hint = new Repeater();
		$typing_hint->add_control('text', array('label' => esc_html__('Typing Phrase', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Compare free zones in minutes', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control(
			'typing_hints',
			array(
				'label'       => esc_html__('Animated Placeholder Phrases', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $typing_hint->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => array(
					array('text' => esc_html__('Search anything about business setup', 'gtwelve-elementor')),
					array('text' => esc_html__('Compare free zones in minutes', 'gtwelve-elementor')),
					array('text' => esc_html__('Find the right trade license', 'gtwelve-elementor')),
					array('text' => esc_html__('Estimate your setup costs', 'gtwelve-elementor')),
				),
			)
		);
		$this->add_control('typing_speed', array('label' => esc_html__('Typing Speed (ms)', 'gtwelve-elementor'), 'type' => Controls_Manager::NUMBER, 'default' => 72, 'min' => 30, 'max' => 200, 'step' => 1));
		$this->add_control('typing_pause', array('label' => esc_html__('Phrase Pause (ms)', 'gtwelve-elementor'), 'type' => Controls_Manager::NUMBER, 'default' => 1500, 'min' => 500, 'max' => 5000, 'step' => 100));
		$this->add_control('button_text', array('label' => esc_html__('Button Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Get Answer', 'gtwelve-elementor')));
		$this->add_control('loading_text', array('label' => esc_html__('Loading Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Thinking...', 'gtwelve-elementor')));
		$this->add_control('helper_text', array('label' => esc_html__('Helper Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXTAREA, 'default' => esc_html__('Ask your questions and get instant answers: Compare free zones, license types, and setup costs – all in one place.', 'gtwelve-elementor')));
		$this->add_control('top_searches_label', array('label' => esc_html__('Top Searches Label', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Top Searches:', 'gtwelve-elementor')));

		$search = new Repeater();
		$search->add_control('query', array('label' => esc_html__('Search Phrase', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Business Setup Process', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control(
			'top_searches',
			array(
				'label'       => esc_html__('Top Searches', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $search->get_controls(),
				'title_field' => '{{{ query }}}',
				'default'     => array(
					array('query' => esc_html__('Business Setup Process', 'gtwelve-elementor')),
					array('query' => esc_html__('Best Freezone for Trading', 'gtwelve-elementor')),
					array('query' => esc_html__('Business License Cost', 'gtwelve-elementor')),
				),
			)
		);

		$this->add_control('ajax_action', array('label' => esc_html__('AI AJAX Action', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => 'dubai_ai_home_v2', 'description' => esc_html__('Plugin-owned AI endpoint used by this widget.', 'gtwelve-elementor')));
		$this->end_controls_section();
	}

	private function register_results_controls(): void
	{
		$this->start_controls_section('results_content', array('label' => esc_html__('Results and Actions', 'gtwelve-elementor'), 'tab' => Controls_Manager::TAB_CONTENT));
		$this->add_control('callback_shortcode', array('label' => esc_html__('Callback Form Shortcode', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => '[fluentform id="1"]', 'description' => esc_html__('Fluent Forms shortcode displayed in the callback popup.', 'gtwelve-elementor')));
		$this->add_control('initial_message', array('label' => esc_html__('Initial Message', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Type a question and click Get Answer.', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control('empty_message', array('label' => esc_html__('Empty Message', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Please type a question first.', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control('error_message', array('label' => esc_html__('Error Message', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('We could not get an answer. Please try again.', 'gtwelve-elementor'), 'label_block' => true));
		$this->add_control('related_heading', array('label' => esc_html__('Related Heading', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Related Searches:', 'gtwelve-elementor')));
		$this->add_control('auto_scroll', array('label' => esc_html__('Auto Scroll to Results', 'gtwelve-elementor'), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__('Yes', 'gtwelve-elementor'), 'label_off' => esc_html__('No', 'gtwelve-elementor'), 'return_value' => 'yes', 'default' => 'yes', 'separator' => 'before'));
		$this->add_control('scroll_offset', array('label' => esc_html__('Scroll Offset (px)', 'gtwelve-elementor'), 'type' => Controls_Manager::NUMBER, 'min' => 0, 'max' => 300, 'step' => 1, 'default' => 90, 'condition' => array('auto_scroll' => 'yes')));

		$related = new Repeater();
		$related->add_control('label', array('label' => esc_html__('Label', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Business Setup in IFZA Free Zone', 'gtwelve-elementor'), 'label_block' => true));
		$related->add_control('url', array('label' => esc_html__('Link', 'gtwelve-elementor'), 'type' => Controls_Manager::URL, 'placeholder' => 'https://g12.ae/'));
		$this->add_control(
			'related_links',
			array(
				'label'       => esc_html__('Related Searches', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $related->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => array(
					array('label' => 'Business Setup in IFZA Free Zone', 'url' => array('url' => home_url('/business-setup-in-ifza-free-zone/'))),
					array('label' => 'Dubai Mainland Company Formation', 'url' => array('url' => home_url('/business-setup-in-dubai-mainland/'))),
					array('label' => 'Free Zone vs Mainland Comparison', 'url' => array('url' => home_url('/mainland-free-zone-offshore-company-setup-in-dubai/'))),
				),
			)
		);

		$this->add_control('whatsapp_text', array('label' => esc_html__('WhatsApp Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Connect on WhatsApp', 'gtwelve-elementor'), 'separator' => 'before'));
		$this->add_control('whatsapp_url', array('label' => esc_html__('WhatsApp Link', 'gtwelve-elementor'), 'type' => Controls_Manager::URL, 'default' => array('url' => 'https://wa.me/971527034124', 'is_external' => true)));
		$this->add_control('callback_text', array('label' => esc_html__('Callback Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Get Callback', 'gtwelve-elementor')));
		$this->add_control('callback_url', array('label' => esc_html__('Callback Link', 'gtwelve-elementor'), 'type' => Controls_Manager::URL, 'default' => array('url' => '#contact')));
		$this->add_control('calculator_text', array('label' => esc_html__('Calculator Text', 'gtwelve-elementor'), 'type' => Controls_Manager::TEXT, 'default' => esc_html__('Calculate Cost', 'gtwelve-elementor')));
		$this->add_control('calculator_url', array('label' => esc_html__('Calculator Link', 'gtwelve-elementor'), 'type' => Controls_Manager::URL, 'default' => array('url' => 'https://aiquote.g12.ae/', 'is_external' => true)));
		$this->end_controls_section();
	}

	private function register_layout_controls(): void
	{
		$this->start_controls_section('layout_style', array('label' => esc_html__('Layout', 'gtwelve-elementor'), 'tab' => Controls_Manager::TAB_STYLE));
		$this->add_control('section_background', array('label' => esc_html__('Background', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget' => 'background: {{VALUE}};')));
		$this->add_responsive_control('minimum_height', array('label' => esc_html__('Minimum Height', 'gtwelve-elementor'), 'type' => Controls_Manager::SLIDER, 'range' => array('px' => array('min' => 420, 'max' => 1100)), 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget' => 'min-height: {{SIZE}}{{UNIT}};')));
		$this->add_responsive_control('section_padding', array('label' => esc_html__('Padding', 'gtwelve-elementor'), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array('px', '%'), 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};')));
		$this->add_responsive_control('content_width', array('label' => esc_html__('Content Width', 'gtwelve-elementor'), 'type' => Controls_Manager::SLIDER, 'range' => array('px' => array('min' => 680, 'max' => 1500)), 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__inner' => 'max-width: {{SIZE}}{{UNIT}};')));
		$this->add_responsive_control('image_width', array('label' => esc_html__('Team Image Width', 'gtwelve-elementor'), 'type' => Controls_Manager::SLIDER, 'size_units' => array('%', 'px'), 'range' => array('%' => array('min' => 35, 'max' => 100), 'px' => array('min' => 300, 'max' => 1100)), 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__image' => 'width: {{SIZE}}{{UNIT}};')));
		$this->end_controls_section();
	}

	private function register_heading_style_controls(): void
	{
		$this->start_controls_section('heading_style', array('label' => esc_html__('Heading and Image', 'gtwelve-elementor'), 'tab' => Controls_Manager::TAB_STYLE));
		$this->add_control('symbol_color', array('label' => esc_html__('Symbol Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__symbol' => 'color: {{VALUE}};')));
		$this->add_control('first_line_color', array('label' => esc_html__('First Line Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#050505', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__first' => 'color: {{VALUE}};')));
		$this->add_control('second_line_color', array('label' => esc_html__('Second Line Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#c8953d', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__second' => 'color: {{VALUE}};')));
		$this->add_group_control(Group_Control_Typography::get_type(), array('name' => 'heading_typography', 'selector' => '{{WRAPPER}} .g12-home-v2-widget__title'));
		$this->add_responsive_control('heading_size', array('label' => esc_html__('Heading Size', 'gtwelve-elementor'), 'type' => Controls_Manager::SLIDER, 'range' => array('px' => array('min' => 34, 'max' => 150)), 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__title' => 'font-size: {{SIZE}}{{UNIT}};')));
		$this->end_controls_section();
	}

	private function register_search_style_controls(): void
	{
		$this->start_controls_section('search_style', array('label' => esc_html__('Search Bar', 'gtwelve-elementor'), 'tab' => Controls_Manager::TAB_STYLE));
		$this->add_responsive_control('search_width', array('label' => esc_html__('Search Width', 'gtwelve-elementor'), 'type' => Controls_Manager::SLIDER, 'size_units' => array('%', 'px'), 'range' => array('%' => array('min' => 50, 'max' => 100), 'px' => array('min' => 300, 'max' => 1000)), 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__search-area' => 'max-width: {{SIZE}}{{UNIT}};')));
		$this->add_control('search_background', array('label' => esc_html__('Bar Background', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#151515', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__form' => 'background: {{VALUE}};')));
		$this->add_control('search_text_color', array('label' => esc_html__('Input Text Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__input' => 'color: {{VALUE}};', '{{WRAPPER}} .g12-home-v2-widget__input::placeholder' => 'color: {{VALUE}};')));
		$this->add_control('button_background', array('label' => esc_html__('Button Background', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__submit' => '--g12-button-gold: {{VALUE}};')));
		$this->add_control('button_text_color', array('label' => esc_html__('Button Text Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#151515', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__submit' => 'color: {{VALUE}};')));
		$this->add_group_control(Group_Control_Box_Shadow::get_type(), array('name' => 'search_shadow', 'selector' => '{{WRAPPER}} .g12-home-v2-widget__form'));
		$this->end_controls_section();
	}

	private function register_supporting_style_controls(): void
	{
		$this->start_controls_section('supporting_style', array('label' => esc_html__('Supporting Content', 'gtwelve-elementor'), 'tab' => Controls_Manager::TAB_STYLE));
		$this->add_control('supporting_color', array('label' => esc_html__('Helper Text Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#202020', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__helper, {{WRAPPER}} .g12-home-v2-widget__top-searches' => 'color: {{VALUE}};', '{{WRAPPER}} .g12-home-v2-widget__suggestion' => 'color: {{VALUE}};')));
		$this->add_group_control(Group_Control_Typography::get_type(), array('name' => 'supporting_typography', 'selector' => '{{WRAPPER}} .g12-home-v2-widget__helper, {{WRAPPER}} .g12-home-v2-widget__top-searches'));
		$this->add_control('result_text_color', array('label' => esc_html__('Result Text Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#191919', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__results' => 'color: {{VALUE}};')));
		$this->add_control('result_link_color', array('label' => esc_html__('Result Link Color', 'gtwelve-elementor'), 'type' => Controls_Manager::COLOR, 'default' => '#9b7028', 'selectors' => array('{{WRAPPER}} .g12-home-v2-widget__results a' => 'color: {{VALUE}};')));
		$this->end_controls_section();
	}

	private function render_search_form(array $settings, string $instance, bool $secondary = false): void
	{
		$input_id = $instance . ($secondary ? '-result-search' : '-search');
?>
		<form class="g12-home-v2-widget__form" role="search" data-g12-home-v2-form>
			<label class="screen-reader-text" for="<?php echo esc_attr($input_id); ?>"><?php echo esc_html__('Search', 'gtwelve-elementor'); ?></label>
			<input id="<?php echo esc_attr($input_id); ?>" class="g12-home-v2-widget__input" type="search" autocomplete="off" placeholder="<?php echo esc_attr($settings['placeholder'] ?? ''); ?>" data-g12-home-v2-input>
			<button class="g12-home-v2-widget__voice" type="button" aria-label="<?php echo esc_attr__('Start voice search', 'gtwelve-elementor'); ?>" title="<?php echo esc_attr__('Voice search', 'gtwelve-elementor'); ?>" data-g12-home-v2-voice>
				<svg class="mic" viewBox="0 0 24 24" aria-hidden="true">
					<path d="M12 14a3 3 0 0 0 3-3V6a3 3 0 0 0-6 0v5a3 3 0 0 0 3 3Zm5-3a5 5 0 0 1-10 0H5a7 7 0 0 0 6 6.92V21H9v2h6v-2h-2v-3.08A7 7 0 0 0 19 11h-2Z" />
				</svg>
				<svg class="eq" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
					<rect class="b b1" x="4" y="6" width="3" height="12" rx="1" />
					<rect class="b b2" x="10.5" y="4" width="3" height="16" rx="1" />
					<rect class="b b3" x="17" y="8" width="3" height="8" rx="1" />
				</svg>
			</button>
			<button class="g12-home-v2-widget__submit" type="submit" data-g12-home-v2-submit>
				<span class="g12-home-v2-widget__sparkles" aria-hidden="true">
					<span class="spark s1"></span>
					<span class="spark s2"></span>
					<span class="spark s3"></span>
				</span>
				<span data-g12-home-v2-button-label><?php echo esc_html($settings['button_text'] ?? 'Get Answer'); ?></span>
			</button>
		</form>
	<?php
	}

	private function render_supporting_content(array $settings): void
	{
		$top_searches = $settings['top_searches'] ?? array();
	?>
		<?php if (! empty($settings['helper_text'])) : ?>
			<p class="g12-home-v2-widget__helper"><?php echo esc_html($settings['helper_text']); ?></p>
		<?php endif; ?>
		<?php if (! empty($top_searches)) : ?>
			<div class="g12-home-v2-widget__top-searches">
				<span><?php echo esc_html($settings['top_searches_label'] ?? 'Top Searches:'); ?></span>
				<?php foreach ($top_searches as $item) : ?>
					<?php if (! empty($item['query'])) : ?>
						<button type="button" class="g12-home-v2-widget__suggestion" data-g12-home-v2-query="<?php echo esc_attr($item['query']); ?>"><?php echo esc_html($item['query']); ?></button>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	<?php
	}

	private function render_action_link(string $key, array $settings, string $icon): void
	{
		$text = $settings[$key . '_text'] ?? '';
		$url  = $settings[$key . '_url'] ?? array();
		if ('whatsapp' === $key && in_array(($url['url'] ?? ''), array('https://wa.me/971523992235', 'https://wa.me/971525850087'), true)) {
			$url['url'] = 'https://wa.me/971527034124';
		}
		if (! $text || empty($url['url'])) {
			return;
		}
		$this->add_link_attributes($key . '_url', $url);
	?>
		<a class="g12-home-v2-widget__cta" <?php if ('callback' === $key) {
												echo 'data-g12-callback-open';
											} ?> <?php echo $this->get_render_attribute_string($key . '_url'); ?>>
			<span class="g12-home-v2-widget__cta-icon" aria-hidden="true"><?php echo $icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Internal SVG only. ?></span><?php echo esc_html($text); ?>
		</a>
	<?php
	}

	protected function render(): void
	{
		$settings  = $this->get_settings_for_display();
		$instance  = 'g12-home-v2-' . $this->get_id();
		$image_url = $settings['hero_image']['url'] ?? '';
		$rating_logo_url = $settings['rating_logo']['url'] ?? home_url('/wp-content/uploads/2025/03/icons8-google-48.png');
		$typing_hints = array();
		foreach ($settings['typing_hints'] ?? array() as $typing_hint) {
			if (! empty($typing_hint['text'])) {
				$typing_hints[] = $typing_hint['text'];
			}
		}
		if (empty($typing_hints)) {
			$typing_hints[] = $settings['placeholder'] ?? 'Search anything about business setup';
		}
	?>
		<section
			id="<?php echo esc_attr($instance); ?>"
			class="g12-home-v2-widget"
			aria-label="<?php echo esc_attr__('Generate success hero', 'gtwelve-elementor'); ?>"
			data-g12-home-v2
			data-callback-nonce="<?php echo esc_attr(wp_create_nonce('gtwelve_hero_callback')); ?>"
			data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
			data-action="<?php echo esc_attr($settings['ajax_action'] ?? 'dubai_ai_home_v2'); ?>"
			data-button-text="<?php echo esc_attr($settings['button_text'] ?? 'Get Answer'); ?>"
			data-loading-text="<?php echo esc_attr($settings['loading_text'] ?? 'Thinking...'); ?>"
			data-empty-message="<?php echo esc_attr($settings['empty_message'] ?? 'Please type a question first.'); ?>"
			data-error-message="<?php echo esc_attr($settings['error_message'] ?? 'We could not get an answer. Please try again.'); ?>"
			data-typing-hints="<?php echo esc_attr(wp_json_encode($typing_hints)); ?>"
			data-typing-speed="<?php echo esc_attr((string) ($settings['typing_speed'] ?? 72)); ?>"
			data-typing-pause="<?php echo esc_attr((string) ($settings['typing_pause'] ?? 1500)); ?>"
			data-auto-scroll="<?php echo esc_attr('yes' === ($settings['auto_scroll'] ?? 'yes') ? 'yes' : 'no'); ?>"
			data-scroll-offset="<?php echo esc_attr((string) ($settings['scroll_offset'] ?? 90)); ?>">
			<div class="g12-home-v2-widget__inner">
				<div class="g12-home-v2-widget__intro" data-g12-home-v2-intro>
					<h1 class="g12-home-v2-widget__title">
						<span class="g12-home-v2-widget__line"><span class="g12-home-v2-widget__symbol"><?php echo esc_html($settings['symbol'] ?? '#'); ?></span><span class="g12-home-v2-widget__first"><?php echo esc_html($settings['heading_first'] ?? 'GENERATE'); ?></span></span>
						<span class="g12-home-v2-widget__second"><?php echo esc_html($settings['heading_second'] ?? 'SUCCESS'); ?></span>
					</h1>
					<?php if ($image_url) : ?>
						<div class="g12-home-v2-widget__image-wrap">
							<img class="g12-home-v2-widget__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($settings['image_alt'] ?? ''); ?>" loading="eager" fetchpriority="high" decoding="async">
						</div>
					<?php endif; ?>
				</div>

				<div class="g12-home-v2-widget__search-area">
					<div class="g12-home-v2-widget__rating" role="group" aria-label="<?php echo esc_attr(sprintf('Google rating %s. %s, %s.', $settings['rating_score'] ?? '4.9', $settings['rating_title'] ?? 'Trusted Consultants', $settings['rating_verified'] ?? 'verified by Trustindex')); ?>" data-g12-home-v2-intro>
						<span class="g12-home-v2-widget__google" aria-hidden="true">
							<img src="<?php echo esc_url($rating_logo_url); ?>" alt="" loading="lazy" decoding="async">
						</span>
						<span class="g12-home-v2-widget__rating-copy">
							<span class="g12-home-v2-widget__rating-stars"><span class="g12-home-v2-widget__stars" aria-hidden="true">★★★★★</span><strong><?php echo esc_html($settings['rating_score'] ?? '4.9'); ?></strong></span>
							<b><?php echo esc_html($settings['rating_title'] ?? 'Trusted Consultants'); ?></b>
							<small><?php echo esc_html($settings['rating_verified'] ?? 'verified by Trustindex'); ?> <i tabindex="0" aria-label="<?php echo esc_attr__('Trustindex verification information', 'gtwelve-elementor'); ?>">i<span><?php echo esc_html__('Trustindex verifies companies with a review score above 4.5 based on recent Google reviews.', 'gtwelve-elementor'); ?></span></i></small>
						</span>
					</div>

					<div data-g12-home-v2-intro>
						<?php $this->render_search_form($settings, $instance); ?>
						<?php $this->render_supporting_content($settings); ?>
					</div>

					<div class="g12-home-v2-widget__results" data-g12-home-v2-results hidden aria-live="polite">
						<?php $this->render_search_form($settings, $instance, true); ?>
						<?php $this->render_supporting_content($settings); ?>
						<div class="g12-home-v2-widget__answer" data-g12-home-v2-answer>
							<p class="g12-home-v2-widget__status"><?php echo esc_html($settings['initial_message'] ?? 'Type a question and click Get Answer.'); ?></p>
						</div>
						<?php if (! empty($settings['related_links'])) : ?>
							<h4><?php echo esc_html($settings['related_heading'] ?? 'Related Searches:'); ?></h4>
							<div class="g12-home-v2-widget__related">
								<?php foreach ($settings['related_links'] as $index => $item) : ?>
									<?php
									if (empty($item['label']) || empty($item['url']['url'])) {
										continue;
									}
									$this->add_link_attributes('related_' . $index, $item['url']);
									?>
									<a <?php echo $this->get_render_attribute_string('related_' . $index); ?>><?php echo esc_html($item['label']); ?></a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						<div class="g12-home-v2-widget__cta-row">
							<?php $this->render_action_link('whatsapp', $settings, '<svg class="ico" viewBox="-23 -21 682 682.66669" xmlns="http://www.w3.org/2000/svg"><path d="m544.386719 93.007812c-59.875-59.945312-139.503907-92.9726558-224.335938-93.007812-174.804687 0-317.070312 142.261719-317.140625 317.113281-.023437 55.894531 14.578125 110.457031 42.332032 158.550781l-44.992188 164.335938 168.121094-44.101562c46.324218 25.269531 98.476562 38.585937 151.550781 38.601562h.132813c174.785156 0 317.066406-142.273438 317.132812-317.132812.035156-84.742188-32.921875-164.417969-92.800781-224.359376zm-224.335938 487.933594h-.109375c-47.296875-.019531-93.683594-12.730468-134.160156-36.742187l-9.621094-5.714844-99.765625 26.171875 26.628907-97.269531-6.269532-9.972657c-26.386718-41.96875-40.320312-90.476562-40.296875-140.28125.054688-145.332031 118.304688-263.570312 263.699219-263.570312 70.40625.023438 136.589844 27.476562 186.355469 77.300781s77.15625 116.050781 77.132812 186.484375c-.0625 145.34375-118.304687 263.59375-263.59375 263.59375zm144.585938-197.417968c-7.921875-3.96875-46.882813-23.132813-54.148438-25.78125-7.257812-2.644532-12.546875-3.960938-17.824219 3.96875-5.285156 7.929687-20.46875 25.78125-25.09375 31.066406-4.625 5.289062-9.242187 5.953125-17.167968 1.984375-7.925782-3.964844-33.457032-12.335938-63.726563-39.332031-23.554687-21.011719-39.457031-46.960938-44.082031-54.890626-4.617188-7.9375-.039062-11.8125 3.476562-16.171874 8.578126-10.652344 17.167969-21.820313 19.808594-27.105469 2.644532-5.289063 1.320313-9.917969-.664062-13.882813-1.976563-3.964844-17.824219-42.96875-24.425782-58.839844-6.4375-15.445312-12.964843-13.359374-17.832031-13.601562-4.617187-.230469-9.902343-.277344-15.1875-.277344-5.28125 0-13.867187 1.980469-21.132812 9.917969-7.261719 7.933594-27.730469 27.101563-27.730469 66.105469s28.394531 76.683594 32.355469 81.972656c3.960937 5.289062 55.878906 85.328125 135.367187 119.648438 18.90625 8.171874 33.664063 13.042968 45.175782 16.695312 18.984374 6.03125 36.253906 5.179688 49.910156 3.140625 15.226562-2.277344 46.878906-19.171875 53.488281-37.679687 6.601563-18.511719 6.601563-34.375 4.617187-37.683594-1.976562-3.304688-7.261718-5.285156-15.183593-9.253906Z" fill-rule="evenodd"/></svg>'); ?>
							<?php $this->render_action_link('callback', $settings, '<svg class="ico" viewBox="0 0 482.6 482.6" xmlns="http://www.w3.org/2000/svg"><path d="M98.339 320.8c47.6 56.9 104.9 101.7 170.3 133.4 24.9 11.8 58.2 25.8 95.3 28.2 2.3.1 4.5.2 6.8.2 24.9 0 44.9-8.6 61.2-26.3 5.9-7.1 12.5-13.4 19.7-20.5 21.3-22.2 21.3-50.4-.2-71.9l-60.1-60.1c-10.2-10.6-22.4-16.2-35.2-16.2s-25.1 5.6-35.6 16.1l-35.8 35.8c-7.4-4-14.5-7.4-20.9-11.2-32.6-20.7-62.2-47.7-90.5-82.4-14.3-18.1-23.9-33.3-30.6-48.8 12.7-11.5 24.6-24.3 35.9-35.4 10.8-10.8 16.6-23.3 16.6-36s-5.7-25.2-16.6-36l-29.8-29.8c-10.1-10.3-20.2-20.8-30.5-30.5C87.739 5.3 75.639 0 62.839 0c-12.7 0-24.9 5.3-35.6 15.5L-10.161 52.9c-13.6 13.6-21.3 30.1-22.9 49.2-1.9 23.9 2.5 49.3 13.9 80 17.9 47.5 44.3 91.6 83.5 138.7Z" transform="translate(33.1)"/></svg>'); ?>
							<?php $this->render_action_link('calculator', $settings, '<svg class="ico g12-home-v2-widget__calculator-icon" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="15"><path d="M232.6 459.7h223.5a22.3 22.3 0 0 0 22.3-22.3v-86.3M125.9 334.3V169.2M478.4 316.9V29.8a22.3 22.3 0 0 0-22.3-22.3H243.1M148.2 7.5a22.3 22.3 0 0 0-22.3 22.3v147.4M169.1 61.3h266.1V135H169.1Z"/><path d="M244.5 190.2a14.3 14.3 0 0 1 12.4-7.1h18.6a14.3 14.3 0 1 1 0 28.6h-12.6M328.8 183.1h18.6a14.3 14.3 0 1 1 0 28.6h-18.6a14.3 14.3 0 1 1 0-28.6ZM400.7 183.1h18.6a14.3 14.3 0 1 1 0 28.6h-18.6a14.3 14.3 0 1 1 0-28.6ZM260.9 256h14.6a14.3 14.3 0 1 1 0 28.6h-18.6a14.3 14.3 0 0 1-14.3-14.3M328.8 256h18.6a14.3 14.3 0 1 1 0 28.6h-18.6a14.3 14.3 0 1 1 0-28.6ZM400.7 256h18.6a14.3 14.3 0 1 1 0 28.6h-18.6a14.3 14.3 0 1 1 0-28.6ZM242.6 328.9a14.3 14.3 0 0 1 14.3-14.3h18.6a14.3 14.3 0 1 1 0 28.7h-16.6M328.8 314.6h18.6a14.3 14.3 0 1 1 0 28.7h-18.6a14.3 14.3 0 1 1 0-28.7ZM400.7 314.6h18.6a14.3 14.3 0 1 1 0 28.7h-18.6a14.3 14.3 0 1 1 0-28.7Z"/><path d="M33.6 430.1V472c0 15.8 34.5 29 80.3 31.9M232.6 428.1V470c0 16.3-36.7 29.8-84.5 32.1M226.6 418.9c3.9 3.5 6 7.2 6 11.1 0 18-44.5 32.5-99.5 32.5S33.6 448 33.6 430c0-9.7 13-18.4 33.5-24.3M61.9 351.3v41.9c0 18 44.5 32.5 99.5 32.5s99.5-14.5 99.5-32.5v-41.9M261 351.3c0 18-44.6 32.5-99.5 32.5S61.9 369.3 61.9 351.3s44.5-32.5 99.5-32.5S261 333.3 261 351.3Z"/></g></svg>'); ?>
						</div>
					</div>
				</div>
			</div>
			<dialog class="g12-home-v2-widget__callback" aria-labelledby="<?php echo esc_attr($instance . '-callback-title'); ?>">
				<button type="button" data-callback-close aria-label="Close callback form">×</button>
				<h3 id="<?php echo esc_attr($instance . '-callback-title'); ?>">Request a Callback</h3>
				<?php echo do_shortcode(! empty($settings['callback_shortcode']) ? $settings['callback_shortcode'] : '[fluentform id="1"]'); ?>
			</dialog>
		</section>
<?php
	}
}
