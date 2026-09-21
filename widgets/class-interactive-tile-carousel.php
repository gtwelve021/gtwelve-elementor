<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Interactive_Tile_Carousel extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_tile_grid_v2';
	}

	public function get_title(): string
	{
		return esc_html__('Interactive Tile Carousel', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-carousel';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('tile', 'grid', 'carousel', 'cards', 'interactive');
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
			'section_heading',
			array(
				'label' => esc_html__('Heading', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'       => esc_html__('Title', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Explore Dubai for your family', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'heading_tag',
			array(
				'label'   => esc_html__('Title HTML Tag', 'gtwelve-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => $this->get_heading_tags(),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_cards',
			array(
				'label' => esc_html__('Cards', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'subtitle',
			array(
				'label'       => esc_html__('Subtitle / Label', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Family Living', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__('Title', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Top-Notch Schools for Bright Futures', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'title_tag',
			array(
				'label'   => esc_html__('Title HTML Tag', 'gtwelve-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => $this->get_heading_tags(),
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label'   => esc_html__('Back Content', 'gtwelve-elementor'),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__('From globally accredited schools to a wide range of extracurricular activities, Dubai offers an educational environment where your children can thrive.', 'gtwelve-elementor'),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__('Image', 'gtwelve-elementor'),
				'type'    => Controls_Manager::MEDIA,
				'default' => array('url' => \Elementor\Utils::get_placeholder_image_src()),
			)
		);

		$repeater->add_control(
			'mode',
			array(
				'label'   => esc_html__('Mode', 'gtwelve-elementor'),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => array(
					'dark'        => esc_html__('Dark', 'gtwelve-elementor'),
					'perspective' => esc_html__('Perspective', 'gtwelve-elementor'),
					'default'     => esc_html__('Default', 'gtwelve-elementor'),
				),
			)
		);

		$repeater->add_control(
			'link_label',
			array(
				'label'   => esc_html__('Link Label', 'gtwelve-elementor'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Explore more', 'gtwelve-elementor'),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__('Link', 'gtwelve-elementor'),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'https://example.com',
				'default'     => array('url' => '#'),
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__('Cards', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => $this->get_default_cards(),
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
			'card_width',
			array(
				'label'      => esc_html__('Desktop Card Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 220, 'max' => 520)),
				'default'    => array('size' => 300, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel__desktop .interactive-tile-carousel__card' => 'flex-basis: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_height',
			array(
				'label'      => esc_html__('Card Height', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 320, 'max' => 720)),
				'default'    => array('size' => 452, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel .interactive-tile-carousel__card' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'gap',
			array(
				'label'      => esc_html__('Gap', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 48)),
				'default'    => array('size' => 10, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel__desktop-cards, {{WRAPPER}} .interactive-tile-carousel__mobile-cards' => 'gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_radius',
			array(
				'label'      => esc_html__('Card Radius', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 40)),
				'default'    => array('size' => 0, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-card-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'card_padding',
			array(
				'label'      => esc_html__('Card Padding', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 12, 'max' => 56)),
				'default'    => array('size' => 24, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-card-padding: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_heading_style',
			array(
				'label' => esc_html__('Heading', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__('Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-heading-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .interactive-tile-carousel__heading',
			)
		);

		$this->add_responsive_control(
			'heading_spacing',
			array(
				'label'      => esc_html__('Bottom Spacing', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 120)),
				'default'    => array('size' => 32, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-heading-spacing: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_text_style',
			array(
				'label' => esc_html__('Card Text', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'label_color',
			array(
				'label'     => esc_html__('Label Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-label-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'label_typography',
				'selector' => '{{WRAPPER}} .interactive-tile-carousel__card-label',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__('Title Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-title-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'card_title_typography',
				'selector' => '{{WRAPPER}} .interactive-tile-carousel__card-title',
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__('Content Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-content-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .interactive-tile-carousel__card-content',
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__('Button Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-button-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .interactive-tile-carousel__button',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_card_colors_style',
			array(
				'label' => esc_html__('Card Colors', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'dark_card_background',
			array(
				'label'     => esc_html__('Dark Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#141414',
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-dark-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'perspective_card_background',
			array(
				'label'     => esc_html__('Perspective Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e7ddd0',
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-perspective-bg: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'default_card_background',
			array(
				'label'     => esc_html__('Default Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-default-bg: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image_style',
			array(
				'label' => esc_html__('Image & Overlay', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'overlay_top_color',
			array(
				'label'     => esc_html__('Overlay Top', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-overlay-top: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'overlay_bottom_color',
			array(
				'label'     => esc_html__('Overlay Bottom', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-overlay-bottom: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'hover_overlay_top_color',
			array(
				'label'     => esc_html__('Hover Overlay Top', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-overlay-hover-top: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'hover_overlay_bottom_color',
			array(
				'label'     => esc_html__('Hover Overlay Bottom', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-overlay-hover-bottom: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'image_brightness',
			array(
				'label'     => esc_html__('Image Brightness', 'gtwelve-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0.2,
				'max'       => 1.5,
				'step'      => 0.01,
				'default'   => 0.92,
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-image-brightness: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'image_hover_blur',
			array(
				'label'      => esc_html__('Hover Blur', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 120)),
				'default'    => array('size' => 75, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-image-hover-blur: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'image_hover_opacity',
			array(
				'label'     => esc_html__('Hover Opacity', 'gtwelve-elementor'),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 0,
				'max'       => 1,
				'step'      => 0.01,
				'default'   => 0.5,
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-image-hover-opacity: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'image_hover_width',
			array(
				'label'      => esc_html__('Hover Image Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 300, 'max' => 1200)),
				'default'    => array('size' => 800, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-image-hover-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_mobile_slider_style',
			array(
				'label' => esc_html__('Mobile Slider', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'slider_track_color',
			array(
				'label'     => esc_html__('Track Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d7d7d7',
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-slider-track: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_thumb_color',
			array(
				'label'     => esc_html__('Thumb Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-slider-thumb: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_track_height',
			array(
				'label'      => esc_html__('Track Height', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 2, 'max' => 12)),
				'default'    => array('size' => 4, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-slider-track-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'slider_thumb_size',
			array(
				'label'      => esc_html__('Thumb Size', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 10, 'max' => 34)),
				'default'    => array('size' => 18, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .interactive-tile-carousel' => '--tile-slider-thumb-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings = $this->get_settings_for_display();
		$cards    = $settings['cards'] ?? array();

		if (empty($cards)) {
			return;
		}

		$widget_id = 'interactive-tile-carousel-' . $this->get_id();
?>
		<div id="<?php echo esc_attr($widget_id); ?>" class="interactive-tile-carousel" data-interactive-tile-carousel>
			<?php $this->render_desktop($settings, $cards, $widget_id); ?>
			<?php $this->render_mobile($settings, $cards, $widget_id); ?>
		</div>
	<?php
	}

	private function render_desktop(array $settings, array $cards, string $widget_id): void
	{
	?>
		<section class="interactive-tile-carousel__desktop">
			<div class="interactive-tile-carousel__stage interactive-tile-carousel__stage--min-cards" id="block-carousel-whats-trending-with-data-and-ai">
				<?php $this->render_heading($settings); ?>
				<div class="interactive-tile-carousel__desktop-viewport">
					<div class="interactive-tile-carousel__desktop-cards flickity-enabled is-draggable" data-template-zone="interactive-tile-carousel-desktop" tabindex="0">
						<?php foreach ($cards as $index => $card) : ?>
							<?php $this->render_card($card, $widget_id . '-desktop-' . $index, false); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
	<?php
	}

	private function render_mobile(array $settings, array $cards, string $widget_id): void
	{
		$slider_id = $widget_id . '-mobile-slider';
	?>

		<div class="interactive-tile-carousel__mobile">
			<?php $this->render_heading($settings); ?>
			<div class="interactive-tile-carousel__mobile-viewport">
				<div class="interactive-tile-carousel__mobile-cards" data-template-zone="interactive-tile-carousel-mobile">
					<?php foreach ($cards as $index => $card) : ?>
						<?php $this->render_card($card, $widget_id . '-mobile-' . $index, false); ?>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="interactive-tile-carousel__slider-container">
				<label for="<?php echo esc_attr($slider_id); ?>" class="interactive-tile-carousel__slider-label"><?php echo esc_html__('Carousel slider control', 'gtwelve-elementor'); ?></label>
				<input id="<?php echo esc_attr($slider_id); ?>" class="interactive-tile-carousel__slider" max="500" min="0" name="carousel slider" value="0" type="range">
			</div>
		</div>

	<?php
	}

	private function render_heading(array $settings): void
	{
		if (empty($settings['heading'])) {
			return;
		}

		$tag = $this->sanitize_heading_tag($settings['heading_tag'] ?? 'h2');
	?>
		<div class="interactive-tile-carousel__heading-wrap">
			<<?php echo esc_attr($tag); ?> class="interactive-tile-carousel__heading"><?php echo wp_kses_post(nl2br($settings['heading'])); ?></<?php echo esc_attr($tag); ?>>
		</div>
	<?php
	}

	private function render_card(array $card, string $card_id, bool $force_dark): void
	{
		$title      = $card['title'] ?? '';
		$subtitle   = $card['subtitle'] ?? '';
		$content    = $card['content'] ?? '';
		$image_url  = $card['image']['url'] ?? '';
		$image_alt  = $card['image']['alt'] ?? wp_strip_all_tags($title);
		$link       = $card['link'] ?? array();
		$link_url   = $link['url'] ?? '';
		$cover_url  = $link_url ?: '#';
		$link_text  = $card['link_label'] ?? '';
		$title_tag  = $this->sanitize_heading_tag($card['title_tag'] ?? 'h3');
		$mode_class = $this->get_mode_class($card['mode'] ?? 'dark', $force_dark);
	?>
		<div class="interactive-tile-carousel__card <?php echo esc_attr($mode_class); ?>" id="<?php echo esc_attr($card_id); ?>" data-cta-title="Expand">
			<button class="interactive-tile-carousel__card-toggle" aria-expanded="false" aria-controls="<?php echo esc_attr($card_id); ?>" aria-label="<?php echo esc_attr($subtitle ?: wp_strip_all_tags($title)); ?>"></button>
			<a href="<?php echo esc_url($cover_url); ?>" class="interactive-tile-carousel__card-cover" tabindex="-1" aria-label="<?php echo esc_attr(trim(($subtitle ?: wp_strip_all_tags($title)) . ' Expand')); ?>" <?php echo ! empty($link['is_external']) && $link_url ? 'target="_blank" rel="noopener noreferrer"' : 'target="_self"'; ?> data-barba-transition></a>
			<button disabled class="interactive-tile-carousel__icon-button interactive-tile-carousel__card-close" tabindex="-1" aria-hidden="true">
				<div class="interactive-tile-carousel__close-text"><?php echo esc_html__('Close', 'gtwelve-elementor'); ?></div>
				<div class="interactive-tile-carousel__close-icon" aria-hidden="true"></div>
			</button>

			<?php if ($image_url) : ?>
				<div class="interactive-tile-carousel__card-image">
					<div class="image interactive-tile-carousel__image-wrap">
						<div class="cmp-image" itemscope itemtype="http://schema.org/ImageObject">
							<img src="<?php echo esc_url($image_url); ?>" loading="lazy" class="cmp-image__image" itemprop="contentUrl" width="600" height="848" alt="<?php echo esc_attr($image_alt); ?>">
						</div>
					</div>
				</div>
			<?php endif; ?>

			<?php if ($subtitle) : ?>
				<div class="interactive-tile-carousel__card-label"><?php echo esc_html($subtitle); ?></div>
			<?php endif; ?>

			<?php if ($title) : ?>
				<<?php echo esc_attr($title_tag); ?> class="interactive-tile-carousel__card-title"><?php echo esc_html($title); ?></<?php echo esc_attr($title_tag); ?>>
			<?php endif; ?>

			<div class="interactive-tile-carousel__card-panel">
				<div class="interactive-tile-carousel__card-front"></div>
				<div class="interactive-tile-carousel__card-back">
					<?php if ($content) : ?>
						<div class="interactive-tile-carousel__card-content"><?php echo wp_kses_post($content); ?></div>
					<?php endif; ?>
					<?php if ($link_text && $link_url) : ?>
						<a href="<?php echo esc_url($link_url); ?>" class="interactive-tile-carousel__button interactive-tile-carousel__button--ghost" tabindex="-1" aria-label="<?php echo esc_attr('Expand: ' . ($subtitle ?: wp_strip_all_tags($title))); ?>" <?php echo ! empty($link['is_external']) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?> data-barba-transition>
							<div class="interactive-tile-carousel__button-text"><?php echo esc_html($link_text); ?></div>
							<div class="interactive-tile-carousel__button-icon interactive-tile-carousel__button-icon--right" aria-hidden="true"></div>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
<?php
	}

	private function get_mode_class(string $mode, bool $force_dark): string
	{
		if ($force_dark || 'dark' === $mode) {
			return 'interactive-tile-carousel__card--dark';
		}

		if ('perspective' === $mode) {
			return 'interactive-tile-carousel__card--perspective';
		}

		return 'interactive-tile-carousel__card--default';
	}

	private function sanitize_heading_tag(string $tag): string
	{
		return array_key_exists($tag, $this->get_heading_tags()) ? $tag : 'h2';
	}

	private function get_heading_tags(): array
	{
		return array(
			'h1'  => 'H1',
			'h2'  => 'H2',
			'h3'  => 'H3',
			'h4'  => 'H4',
			'h5'  => 'H5',
			'h6'  => 'H6',
			'div' => 'div',
		);
	}

	private function get_default_cards(): array
	{
		return array(
			array(
				'subtitle'   => esc_html__('Education', 'gtwelve-elementor'),
				'title'      => esc_html__('Top-Notch Schools for Bright Futures', 'gtwelve-elementor'),
				'title_tag'  => 'h3',
				'content'    => esc_html__('Dubai offers globally accredited schools, extracurricular activities, and an educational environment where children can thrive.', 'gtwelve-elementor'),
				'image'      => array('url' => \Elementor\Utils::get_placeholder_image_src()),
				'mode'       => 'dark',
				'link_label' => esc_html__('Explore more', 'gtwelve-elementor'),
				'link'       => array('url' => '#'),
			),
			array(
				'subtitle'   => esc_html__('Safety', 'gtwelve-elementor'),
				'title'      => esc_html__('Safety That Lets You Sleep Peacefully', 'gtwelve-elementor'),
				'title_tag'  => 'h3',
				'content'    => esc_html__('Secure communities, dependable infrastructure, and family-friendly neighborhoods support a calmer daily life.', 'gtwelve-elementor'),
				'image'      => array('url' => \Elementor\Utils::get_placeholder_image_src()),
				'mode'       => 'dark',
				'link_label' => esc_html__('Explore more', 'gtwelve-elementor'),
				'link'       => array('url' => '#'),
			),
			array(
				'subtitle'   => esc_html__('Lifestyle', 'gtwelve-elementor'),
				'title'      => esc_html__('A Lifestyle Built for Families', 'gtwelve-elementor'),
				'title_tag'  => 'h3',
				'content'    => esc_html__('Waterfront living, modern communities, leisure, and convenience come together for families building a long-term future.', 'gtwelve-elementor'),
				'image'      => array('url' => \Elementor\Utils::get_placeholder_image_src()),
				'mode'       => 'perspective',
				'link_label' => esc_html__('Explore more', 'gtwelve-elementor'),
				'link'       => array('url' => '#'),
			),
			array(
				'subtitle'   => esc_html__('Healthcare', 'gtwelve-elementor'),
				'title'      => esc_html__('Healthcare You Can Truly Rely On', 'gtwelve-elementor'),
				'title_tag'  => 'h3',
				'content'    => esc_html__('Advanced hospitals, experienced specialists, and high-quality medical care help families feel supported.', 'gtwelve-elementor'),
				'image'      => array('url' => \Elementor\Utils::get_placeholder_image_src()),
				'mode'       => 'dark',
				'link_label' => esc_html__('Explore more', 'gtwelve-elementor'),
				'link'       => array('url' => '#'),
			),
		);
	}
}
