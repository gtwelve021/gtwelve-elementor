<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Review_Grid extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_review_grid';
	}

	public function get_title(): string
	{
		return esc_html__('Review Grid', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-review';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('review', 'reviews', 'testimonial', 'rating', 'grid', 'slider');
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
			'section_reviews',
			array(
				'label' => esc_html__('Reviews', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'name',
			array(
				'label'       => esc_html__('Name', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Jeric Pontanos', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'avatar',
			array(
				'label' => esc_html__('Avatar', 'gtwelve-elementor'),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$repeater->add_control(
			'initial',
			array(
				'label'       => esc_html__('Fallback Initial', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'J',
				'label_block' => false,
			)
		);

		$repeater->add_control(
			'review_count',
			array(
				'label'   => esc_html__('Review Count Text', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('5 reviews', 'gtwelve-elementor'),
			)
		);

		$repeater->add_control(
			'rating',
			array(
				'label'   => esc_html__('Rating', 'gtwelve-elementor'),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 0,
				'max'     => 5,
				'step'    => 0.5,
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label'       => esc_html__('Review Text', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Good communication, fast support, very transparent about the pricing and their packages.', 'gtwelve-elementor'),
				'rows'        => 5,
				'label_block' => true,
			)
		);

		$this->add_control(
			'reviews',
			array(
				'label'       => esc_html__('Reviews', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => $this->get_default_reviews(),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_controls(): void
	{
		$this->start_controls_section(
			'section_layout_style',
			array(
				'label' => esc_html__('Layout', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__('Desktop Columns', 'gtwelve-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'2' => esc_html__('2', 'gtwelve-elementor'),
					'3' => esc_html__('3', 'gtwelve-elementor'),
					'4' => esc_html__('4', 'gtwelve-elementor'),
				),
				'selectors' => array(
					'{{WRAPPER}} .review-grid__track' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				),
			)
		);

		$this->add_responsive_control(
			'gap',
			array(
				'label'      => esc_html__('Card Gap', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 8, 'max' => 60)),
				'default'    => array('size' => 24, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__('Card Padding', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em'),
				'default'    => array(
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '22',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .review-grid__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'card_background',
			array(
				'label'     => esc_html__('Card Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-card-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_border_color',
			array(
				'label'     => esc_html__('Border Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e6e8ec',
				'selectors' => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-border: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'card_radius',
			array(
				'label'      => esc_html__('Card Radius', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 30)),
				'default'    => array('size' => 14, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-radius: {{SIZE}}{{UNIT}};',
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

		$this->add_control(
			'name_color',
			array(
				'label'     => esc_html__('Name Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d99a34',
				'selectors' => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-name: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'name_typography',
				'selector' => '{{WRAPPER}} .review-grid__name',
			)
		);

		$this->add_control(
			'meta_color',
			array(
				'label'     => esc_html__('Meta Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#b7bbc3',
				'selectors' => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-meta: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__('Review Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-text: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .review-grid__content',
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'     => esc_html__('Star Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d99a34',
				'selectors' => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-star: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_mobile_style',
			array(
				'label' => esc_html__('Mobile', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'mobile_button_text',
			array(
				'label'   => esc_html__('Button Text', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('See more reviews', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'mobile_button_less_text',
			array(
				'label'   => esc_html__('Button Less Text', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('See fewer reviews', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'mobile_button_color',
			array(
				'label'     => esc_html__('Button Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d99a34',
				'selectors' => array(
					'{{WRAPPER}} .review-grid' => '--review-grid-mobile-button: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings = $this->get_settings_for_display();
		$reviews  = $settings['reviews'] ?? array();

		if (empty($reviews)) {
			return;
		}

		$widget_id = 'review-grid-' . $this->get_id();
		$more_label = $settings['mobile_button_text'] ?? esc_html__('See more reviews', 'gtwelve-elementor');
		$less_label = $settings['mobile_button_less_text'] ?? esc_html__('See fewer reviews', 'gtwelve-elementor');
		?>
		<div id="<?php echo esc_attr($widget_id); ?>" class="review-grid" data-review-grid>
			<div class="review-grid__viewport" data-review-grid-viewport>
				<div class="review-grid__track">
					<?php foreach ($reviews as $review) : ?>
						<?php $this->render_review($review); ?>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if (count($reviews) > 2 && $more_label) : ?>
				<div class="review-grid__more-wrap">
					<button class="review-grid__more" type="button" data-review-grid-more data-more-label="<?php echo esc_attr($more_label); ?>" data-less-label="<?php echo esc_attr($less_label ?: $more_label); ?>">
						<?php echo esc_html($more_label); ?>
					</button>
				</div>
			<?php endif; ?>
		</div>
		<?php
	}

	private function render_review(array $review): void
	{
		$name         = $review['name'] ?? '';
		$avatar_url   = $review['avatar']['url'] ?? '';
		$avatar_alt   = $review['avatar']['alt'] ?? $name;
		$initial      = $review['initial'] ?? '';
		$review_count = $review['review_count'] ?? '';
		$rating       = min(5, max(0, (float) ($review['rating'] ?? 5)));
		$content      = $review['content'] ?? '';
		?>
		<article class="review-grid__card">
			<header class="review-grid__card-header">
				<div class="review-grid__avatar" aria-hidden="<?php echo $avatar_url ? 'false' : 'true'; ?>">
					<?php if ($avatar_url) : ?>
						<img src="<?php echo esc_url($avatar_url); ?>" alt="<?php echo esc_attr($avatar_alt); ?>" loading="lazy">
					<?php else : ?>
						<span><?php echo esc_html($initial ?: strtoupper(substr(wp_strip_all_tags($name), 0, 1))); ?></span>
					<?php endif; ?>
				</div>
				<div class="review-grid__meta">
					<?php if ($name) : ?>
						<h3 class="review-grid__name"><?php echo esc_html($name); ?></h3>
					<?php endif; ?>
					<?php if ($review_count) : ?>
						<div class="review-grid__count"><?php echo esc_html($review_count); ?></div>
					<?php endif; ?>
				</div>
			</header>
			<div class="review-grid__stars" aria-label="<?php echo esc_attr(sprintf(__('Rating: %s out of 5', 'gtwelve-elementor'), $rating)); ?>">
				<?php echo $this->render_stars($rating); ?>
			</div>
			<?php if ($content) : ?>
				<p class="review-grid__content"><?php echo esc_html($content); ?></p>
			<?php endif; ?>
		</article>
		<?php
	}

	private function render_stars(float $rating): string
	{
		$output = '';

		for ($index = 1; $index <= 5; $index++) {
			$class = $rating >= $index ? ' is-filled' : '';
			$output .= '<span class="review-grid__star' . esc_attr($class) . '" aria-hidden="true">&#9733;</span>';
		}

		return $output;
	}

	private function get_default_reviews(): array
	{
		return array(
			array(
				'name'         => esc_html__('Jeric Pontanos', 'gtwelve-elementor'),
				'avatar'       => array('url' => ''),
				'initial'      => 'J',
				'review_count' => esc_html__('5 reviews', 'gtwelve-elementor'),
				'rating'       => 5,
				'content'      => esc_html__('Good communication, fast support, very transparent about the pricing and their packages. My business setup was successful thanks to the G12 team, especially Ms. Dilahad.', 'gtwelve-elementor'),
			),
			array(
				'name'         => esc_html__('Jitendar Chaturvedi', 'gtwelve-elementor'),
				'avatar'       => array('url' => ''),
				'initial'      => 'J',
				'review_count' => esc_html__('5 reviews', 'gtwelve-elementor'),
				'rating'       => 5,
				'content'      => esc_html__('I had an excellent experience working with Sonia during the initial setup of my company. From the very beginning, she was incredibly helpful, knowledgeable, and professional.', 'gtwelve-elementor'),
			),
			array(
				'name'         => esc_html__('Emily Thompson', 'gtwelve-elementor'),
				'avatar'       => array('url' => ''),
				'initial'      => 'E',
				'review_count' => esc_html__('5 reviews', 'gtwelve-elementor'),
				'rating'       => 5,
				'content'      => esc_html__('G12 handled my relocation paperwork and trade license far quicker than expected. Every update was clear, and their transparency on fees made it stress-free.', 'gtwelve-elementor'),
			),
		);
	}
}
