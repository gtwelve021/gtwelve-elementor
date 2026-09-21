<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Video_Slider extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_video_slider';
	}

	public function get_title(): string
	{
		return esc_html__('G12 Video Slider', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-video-camera';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('video', 'slider', 'carousel', 'reel', 'g12');
	}

	public function get_style_depends(): array
	{
		wp_register_style(
			'gtwelve-elementor-video-slider',
			GTWELVE_ELEMENTOR_URL . 'assets/css/video-slider.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		return array('gtwelve-elementor-video-slider');
	}

	public function get_script_depends(): array
	{
		wp_register_script(
			'gtwelve-elementor-video-slider',
			GTWELVE_ELEMENTOR_URL . 'assets/js/video-slider.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		return array('gtwelve-elementor-video-slider');
	}

	protected function register_controls(): void
	{
		$this->start_controls_section(
			'section_videos',
			array(
				'label' => esc_html__('Videos', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'video_file',
			array(
				'label'       => esc_html__('Video', 'gtwelve-elementor'),
				'type'        => Controls_Manager::MEDIA,
				'media_types' => array('video'),
			)
		);

		$repeater->add_control(
			'poster',
			array(
				'label' => esc_html__('Poster Image', 'gtwelve-elementor'),
				'type'  => Controls_Manager::MEDIA,
			)
		);

		$this->add_control(
			'videos',
			array(
				'label'       => esc_html__('Video Slides', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ video_file.url }}}',
				'default'     => array(
					array('video_file' => array('url' => 'https://g12.ae/wp-content/uploads/2025/11/WhatsApp-Video-2025-11-14-at-13.14.53_0774af44.mp4')),
					array('video_file' => array('url' => 'https://g12.ae/wp-content/uploads/2025/11/mobile.mp4')),
				),
			)
		);

		$this->add_control(
			'placeholder',
			array(
				'label'   => esc_html__('Placeholder Image', 'gtwelve-elementor'),
				'type'    => Controls_Manager::MEDIA,
				'default' => array('url' => Utils::get_placeholder_image_src()),
			)
		);

		$this->add_control(
			'autoplay_delay',
			array(
				'label'   => esc_html__('Autoplay Delay (ms)', 'gtwelve-elementor'),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1000,
				'step'    => 500,
				'default' => 6000,
			)
		);

		$this->add_control(
			'show_navigation',
			array(
				'label'        => esc_html__('Navigation Buttons', 'gtwelve-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Show', 'gtwelve-elementor'),
				'label_off'    => esc_html__('Hide', 'gtwelve-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings = $this->get_settings_for_display();
		$videos = array_values(array_filter($settings['videos'] ?? array(), static function ($video) {
			return ! empty($video['video_file']['url'] ?? '');
		}));
		$placeholder = $settings['placeholder']['url'] ?? Utils::get_placeholder_image_src();
		$autoplay_delay = max(0, (int) ($settings['autoplay_delay'] ?? 6000));
		$show_nav = ($settings['show_navigation'] ?? 'yes') === 'yes';
		?>
		<div class="g12-video-slider-widget" data-g12-video-slider>
			<div class="g12-video-slider-widget__slider" data-autoplay="<?php echo esc_attr((string) $autoplay_delay); ?>" data-has-nav="<?php echo $show_nav ? 'true' : 'false'; ?>">
				<div class="g12-video-slider-widget__track">
					<?php if (! empty($videos)) : ?>
						<?php foreach ($videos as $index => $video) : ?>
							<?php
							$video_url = $video['video_file']['url'] ?? '';
							$poster = $video['poster']['url'] ?? '';
							if (! $video_url) {
								continue;
							}
							?>
							<div class="g12-video-slider-widget__slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-slide="<?php echo esc_attr((string) $index); ?>">
								<video src="<?php echo esc_url($video_url); ?>" muted playsinline preload="metadata"<?php echo $poster ? ' poster="' . esc_url($poster) . '"' : ''; ?>></video>
								<button class="g12-video-slider-widget__play" type="button"
									aria-label="<?php esc_attr_e('Play video', 'gtwelve-elementor'); ?>"
									data-play-label="<?php esc_attr_e('Play video', 'gtwelve-elementor'); ?>"
									data-pause-label="<?php esc_attr_e('Pause video', 'gtwelve-elementor'); ?>">
									<svg class="g12-video-slider-widget__play-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
										<polygon points="6 3 20 12 6 21 6 3"></polygon>
									</svg>
									<svg class="g12-video-slider-widget__pause-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
										<rect x="6" y="4" width="4" height="16"></rect>
										<rect x="14" y="4" width="4" height="16"></rect>
									</svg>
								</button>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<div class="g12-video-slider-widget__slide is-active">
							<?php if ($placeholder) : ?>
								<img src="<?php echo esc_url($placeholder); ?>" alt="<?php esc_attr_e('Video placeholder', 'gtwelve-elementor'); ?>">
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ($show_nav && count($videos) > 1) : ?>
				
					<div class="g12-video-slider-widget__dots" role="tablist">
						<?php foreach ($videos as $index => $video) : ?>
							<button class="g12-video-slider-widget__dot<?php echo 0 === $index ? ' is-active' : ''; ?>" type="button" aria-label="<?php echo esc_attr(sprintf(__('Go to video %d', 'gtwelve-elementor'), $index + 1)); ?>" data-slide="<?php echo esc_attr((string) $index); ?>" role="tab"></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
