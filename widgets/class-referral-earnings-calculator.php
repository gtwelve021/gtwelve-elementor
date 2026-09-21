<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Referral_Earnings_Calculator extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_referral_earnings_calculator';
	}

	public function get_title(): string
	{
		return esc_html__('Referral Earnings Calculator', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-calculator';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('referral', 'earnings', 'calculator', 'commission', 'slider');
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
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls(): void
	{
		$this->start_controls_section(
			'section_header',
			array(
				'label' => esc_html__('Header', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__('Title', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Interactive Earnings Calculator', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label'   => esc_html__('Title HTML Tag', 'gtwelve-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => $this->get_heading_tags(),
			)
		);

		$this->add_control(
			'subtitle',
			array(
				'label'       => esc_html__('Subtitle', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Adjust the sliders to see your potential monthly earnings', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_services',
			array(
				'label' => esc_html__('Services', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'label',
			array(
				'label'       => esc_html__('Label', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Business Setup', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'icon',
			array(
				'label'   => esc_html__('Icon', 'gtwelve-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'building',
				'options' => array(
					'building'  => esc_html__('Building', 'gtwelve-elementor'),
					'briefcase' => esc_html__('Briefcase', 'gtwelve-elementor'),
					'award'     => esc_html__('Award', 'gtwelve-elementor'),
				),
			)
		);

		$repeater->add_control(
			'rate',
			array(
				'label'   => esc_html__('AED Per Referral', 'gtwelve-elementor'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5000,
				'min'     => 0,
				'step'    => 50,
			)
		);

		$repeater->add_control(
			'default_count',
			array(
				'label'   => esc_html__('Default Referrals', 'gtwelve-elementor'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 0,
				'step'    => 1,
			)
		);

		$repeater->add_control(
			'max_count',
			array(
				'label'   => esc_html__('Max Referrals', 'gtwelve-elementor'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 20,
				'min'     => 1,
				'step'    => 1,
			)
		);

		$this->add_control(
			'services',
			array(
				'label'       => esc_html__('Services', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'default'     => $this->get_default_services(),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_summary',
			array(
				'label' => esc_html__('Summary & Button', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'total_label',
			array(
				'label'   => esc_html__('Total Label', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Total Monthly Earnings:', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'referrals_label',
			array(
				'label'   => esc_html__('Referrals Label', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Total Referrals', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'payout_label',
			array(
				'label'   => esc_html__('Payout Label', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Potential Payout', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'average_label',
			array(
				'label'   => esc_html__('Average Label', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Avg per Referral', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'cta_text',
			array(
				'label'       => esc_html__('Button Text Template', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Start Referring Now - Earn AED {monthly} Monthly', 'gtwelve-elementor'),
				'label_block' => true,
				'description' => esc_html__('Use {monthly} for the calculated monthly amount.', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'cta_link',
			array(
				'label'       => esc_html__('Button Link', 'gtwelve-elementor'),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'default'     => array('url' => '#'),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_controls(): void
	{
		$this->start_controls_section(
			'section_card_style',
			array(
				'label' => esc_html__('Card', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'max_width',
			array(
				'label'      => esc_html__('Max Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', '%'),
				'range'      => array(
					'px' => array('min' => 320, 'max' => 900),
					'%'  => array('min' => 10, 'max' => 100),
				),
				'default'    => array('size' => 572, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .referral-earnings-calculator' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'accent_color',
			array(
				'label'     => esc_html__('Accent Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d6a456',
				'selectors' => array(
					'{{WRAPPER}} .referral-earnings-calculator' => '--referral-calc-accent: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'accent_dark_color',
			array(
				'label'     => esc_html__('Accent Dark Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#b78635',
				'selectors' => array(
					'{{WRAPPER}} .referral-earnings-calculator' => '--referral-calc-accent-dark: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'body_background',
			array(
				'label'     => esc_html__('Body Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .referral-earnings-calculator' => '--referral-calc-body: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'summary_background',
			array(
				'label'     => esc_html__('Summary Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f7f3eb',
				'selectors' => array(
					'{{WRAPPER}} .referral-earnings-calculator' => '--referral-calc-summary: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			array(
				'label' => esc_html__('Text', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .referral-earnings-calculator__title',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'body_typography',
				'selector' => '{{WRAPPER}} .referral-earnings-calculator',
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__('Text Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .referral-earnings-calculator' => '--referral-calc-text: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings = $this->get_settings_for_display();
		$services = $settings['services'] ?? array();

		if (empty($services)) {
			return;
		}

		$title_tag = $this->sanitize_heading_tag($settings['title_tag'] ?? 'h3');
		$link = $settings['cta_link'] ?? array();
		$link_url = $link['url'] ?? '';
		$target = ! empty($link['is_external']) ? ' target="_blank" rel="noopener noreferrer"' : '';
		$initial_monthly_total = $this->get_initial_monthly_total($services);
		$initial_referral_total = $this->get_initial_referral_total($services);
		$initial_average = $initial_referral_total ? round($initial_monthly_total / $initial_referral_total) : 0;
		$cta_text = str_replace('{monthly}', number_format($initial_monthly_total), $settings['cta_text'] ?? '');
		?>
		<div class="referral-earnings-calculator" data-referral-earnings-calculator data-cta-template="<?php echo esc_attr($settings['cta_text'] ?? ''); ?>">
			<div class="referral-earnings-calculator__header">
				<?php if (! empty($settings['title'])) : ?>
					<<?php echo esc_attr($title_tag); ?> class="referral-earnings-calculator__title"><?php echo esc_html($settings['title']); ?></<?php echo esc_attr($title_tag); ?>>
				<?php endif; ?>
				<?php if (! empty($settings['subtitle'])) : ?>
					<p class="referral-earnings-calculator__subtitle"><?php echo esc_html($settings['subtitle']); ?></p>
				<?php endif; ?>
			</div>

			<div class="referral-earnings-calculator__body">
				<?php foreach ($services as $index => $service) : ?>
					<?php
					$rate = max(0, (int) ($service['rate'] ?? 0));
					$max = max(1, (int) ($service['max_count'] ?? 20));
					$value = min($max, max(0, (int) ($service['default_count'] ?? 0)));
					$input_id = 'referral-earnings-' . $this->get_id() . '-' . $index;
					?>
					<div class="referral-earnings-calculator__service" data-rate="<?php echo esc_attr((string) $rate); ?>">
						<div class="referral-earnings-calculator__service-row">
							<div class="referral-earnings-calculator__service-name">
								<span class="referral-earnings-calculator__icon" aria-hidden="true"><?php echo $this->get_icon_svg($service['icon'] ?? 'building'); ?></span>
								<label for="<?php echo esc_attr($input_id); ?>"><?php echo esc_html($service['label'] ?? ''); ?></label>
							</div>
							<div class="referral-earnings-calculator__service-total">
								<span data-service-count><?php echo esc_html((string) $value); ?></span> &times; AED <?php echo esc_html(number_format($rate)); ?> = AED <span data-service-total><?php echo esc_html(number_format($value * $rate)); ?></span>
							</div>
						</div>
						<input id="<?php echo esc_attr($input_id); ?>" class="referral-earnings-calculator__range" type="range" min="0" max="<?php echo esc_attr((string) $max); ?>" value="<?php echo esc_attr((string) $value); ?>" name="<?php echo esc_attr($input_id); ?>" aria-label="<?php echo esc_attr($service['label'] ?? ''); ?>" data-referral-range>
					</div>
				<?php endforeach; ?>

				<div class="referral-earnings-calculator__summary">
					<div class="referral-earnings-calculator__summary-top">
						<span class="referral-earnings-calculator__summary-label"><?php echo esc_html($settings['total_label'] ?? ''); ?></span>
						<span class="referral-earnings-calculator__summary-total">AED <span data-monthly-total><?php echo esc_html(number_format($initial_monthly_total)); ?></span></span>
					</div>
					<div class="referral-earnings-calculator__stats">
						<div class="referral-earnings-calculator__stat">
							<span><?php echo esc_html($settings['referrals_label'] ?? ''); ?></span>
							<strong data-total-referrals><?php echo esc_html(number_format($initial_referral_total)); ?></strong>
						</div>
						<div class="referral-earnings-calculator__stat">
							<span><?php echo esc_html($settings['payout_label'] ?? ''); ?></span>
							<strong>AED <span data-annual-total><?php echo esc_html(number_format($initial_monthly_total * 12)); ?></span></strong>
						</div>
						<div class="referral-earnings-calculator__stat">
							<span><?php echo esc_html($settings['average_label'] ?? ''); ?></span>
							<strong>AED <span data-average-referral><?php echo esc_html(number_format($initial_average)); ?></span></strong>
						</div>
					</div>
				</div>

				<?php if ($cta_text) : ?>
					<div class="referral-earnings-calculator__cta-wrap">
						<a class="referral-earnings-calculator__cta" href="<?php echo esc_url($link_url ?: '#'); ?>"<?php echo $target; ?> data-referral-cta><?php echo esc_html($cta_text); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	private function get_initial_monthly_total(array $services): int
	{
		$total = 0;

		foreach ($services as $service) {
			$rate = max(0, (int) ($service['rate'] ?? 0));
			$max = max(1, (int) ($service['max_count'] ?? 20));
			$value = min($max, max(0, (int) ($service['default_count'] ?? 0)));
			$total += $value * $rate;
		}

		return $total;
	}

	private function get_initial_referral_total(array $services): int
	{
		$total = 0;

		foreach ($services as $service) {
			$max = max(1, (int) ($service['max_count'] ?? 20));
			$total += min($max, max(0, (int) ($service['default_count'] ?? 0)));
		}

		return $total;
	}

	private function get_default_services(): array
	{
		return array(
			array(
				'label'         => esc_html__('Business Setup', 'gtwelve-elementor'),
				'icon'          => 'building',
				'rate'          => 5000,
				'default_count' => 3,
				'max_count'     => 20,
			),
			array(
				'label'         => esc_html__('Corporate Services', 'gtwelve-elementor'),
				'icon'          => 'briefcase',
				'rate'          => 1500,
				'default_count' => 5,
				'max_count'     => 20,
			),
			array(
				'label'         => esc_html__('Golden Visa', 'gtwelve-elementor'),
				'icon'          => 'award',
				'rate'          => 1000,
				'default_count' => 2,
				'max_count'     => 20,
			),
		);
	}

	private function get_icon_svg(string $icon): string
	{
		$icons = array(
			'building'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path><path d="M12 10h.01"></path><path d="M12 14h.01"></path><path d="M16 10h.01"></path><path d="M16 14h.01"></path><path d="M8 10h.01"></path><path d="M8 14h.01"></path></svg>',
			'briefcase' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path><rect width="20" height="14" x="2" y="6" rx="2"></rect></svg>',
			'award'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle></svg>',
		);

		return $icons[$icon] ?? $icons['building'];
	}

	private function sanitize_heading_tag(string $tag): string
	{
		return array_key_exists($tag, $this->get_heading_tags()) ? $tag : 'h3';
	}

	private function get_heading_tags(): array
	{
		return array(
			'h2'  => 'H2',
			'h3'  => 'H3',
			'h4'  => 'H4',
			'h5'  => 'H5',
			'h6'  => 'H6',
			'div' => 'div',
		);
	}
}
