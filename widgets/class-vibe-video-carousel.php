<?php
namespace GTwelveElementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Vibe_Video_Carousel extends \Elementor\Widget_Base {
	public function get_name() {
		return 'g12_vibe_video_carousel';
	}

	public function get_title() {
		return esc_html__( 'G12 Vibe Video Carousel', 'gtwelve-elementor' );
	}

	public function get_icon() {
		return 'eicon-slider-video';
	}

	public function get_categories() {
		return array( 'gtwelve' );
	}

	public function get_style_depends() {
		return array( 'gtwelve-elementor-vibe-video-carousel' );
	}

	public function get_script_depends() {
		return array( 'gtwelve-elementor-vibe-video-carousel' );
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'gtwelve-elementor' ),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'video_file',
			array(
				'label'      => esc_html__( 'Video File', 'gtwelve-elementor' ),
				'type'       => \Elementor\Controls_Manager::MEDIA,
				'media_type' => 'video',
			)
		);

		$repeater->add_control(
			'video_url',
			array(
				'label'       => esc_html__( 'External Video URL', 'gtwelve-elementor' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://example.com/video.webm',
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'poster',
			array(
				'label' => esc_html__( 'Poster Image', 'gtwelve-elementor' ),
				'type'  => \Elementor\Controls_Manager::MEDIA,
			)
		);

		$repeater->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'gtwelve-elementor' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Buy Now', 'gtwelve-elementor' ),
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Button Link', 'gtwelve-elementor' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://example.com',
			)
		);

		$this->add_control(
			'videos',
			array(
				'label'       => esc_html__( 'Videos', 'gtwelve-elementor' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ button_text || "Video" }}}',
				'default'     => $this->get_default_videos(),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			array(
				'label' => esc_html__( 'Style', 'gtwelve-elementor' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Button Color', 'gtwelve-elementor' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => array(
					'{{WRAPPER}} .g12-vibe-video-link' => 'background-color: {{VALUE}};',
				),
			)
		);

	}

	private function get_default_videos() {
		$items = array(
			array(
				'video_url' => 'https://cdn.shopify.com/videos/c/o/v/6c00939bc5d64d93a0556899347e50aa.webm',
				'link'      => array( 'url' => '#' ),
			),
			array(
				'video_url' => 'https://cdn.shopify.com/videos/c/o/v/225898d9d281420da8603c471ad41b64.webm',
				'link'      => array( 'url' => '#' ),
			),
			array(
				'video_url' => 'https://cdn.shopify.com/videos/c/o/v/8a09addb217e4adc8f88823658586de0.webm',
				'link'      => array( 'url' => '#' ),
			),
			array(
				'video_url' => 'https://cdn.shopify.com/videos/c/o/v/dbf561ac4d7c47028ff1d80660c13892.webm',
				'link'      => array( 'url' => '#' ),
			),
			array(
				'video_url' => 'https://cdn.shopify.com/videos/c/o/v/c8c02b22db764a9babb181f1bdcd1906.webm',
				'link'      => array( 'url' => '#' ),
			),
			array(
				'video_url' => 'https://cdn.shopify.com/videos/c/o/v/2f7c1bc025f94acf87b9733014040fa2.webm',
				'link'      => array( 'url' => '#' ),
			),
			array(
				'video_url' => 'https://cdn.shopify.com/videos/c/o/v/0a66f0ce1fad488c99f8d29bb5f414cd.webm',
				'link'      => array( 'url' => '#' ),
			),
		);

		foreach ( $items as &$item ) {
			$item['button_text'] = esc_html__( 'Buy Now', 'gtwelve-elementor' );
		}

		return $items;
	}

	private function get_video_url( $item ) {
		if ( ! empty( $item['video_file']['url'] ) ) {
			return $item['video_file']['url'];
		}

		return ! empty( $item['video_url'] ) ? $item['video_url'] : '';
	}

	private function get_video_type( $url ) {
		$path = wp_parse_url( $url, PHP_URL_PATH );
		$ext  = strtolower( pathinfo( (string) $path, PATHINFO_EXTENSION ) );

		if ( 'webm' === $ext ) {
			return 'video/webm';
		}

		if ( 'ogg' === $ext || 'ogv' === $ext ) {
			return 'video/ogg';
		}

		return 'video/mp4';
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$videos   = isset( $settings['videos'] ) && is_array( $settings['videos'] ) ? $settings['videos'] : array();

		if ( empty( $videos ) ) {
			return;
		}

		?>
		<div class="g12-vibe-video-section">
			<div class="g12-vibe-video-panorama panorama-slider">
				<div class="g12-vibe-video-swiper swiper">
					<div class="g12-vibe-video-track swiper-wrapper">
						<?php foreach ( $videos as $item ) : ?>
							<?php
							$video_url   = $this->get_video_url( $item );
							$poster_url  = ! empty( $item['poster']['url'] ) ? $item['poster']['url'] : '';
							$link_url    = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '';
							$button_text = ! empty( $item['button_text'] ) ? $item['button_text'] : esc_html__( 'Buy Now', 'gtwelve-elementor' );
							$target      = ! empty( $item['link']['is_external'] ) ? ' target="_blank"' : '';
							$nofollow    = ! empty( $item['link']['nofollow'] ) ? ' rel="nofollow"' : '';

							if ( empty( $video_url ) ) {
								continue;
							}
							?>
							<div class="g12-vibe-video-slide swiper-slide">
								<div class="g12-vibe-video-box video-box">
									<video class="g12-vibe-video-media video lazy-vibe-video" loop muted data-g12-audio="1" playsinline preload="metadata"<?php echo $poster_url ? ' poster="' . esc_url( $poster_url ) . '"' : ' poster="#"'; ?>>
										<source src="<?php echo esc_url( $video_url ); ?>" data-src="<?php echo esc_url( $video_url ); ?>" type="<?php echo esc_attr( $this->get_video_type( $video_url ) ); ?>">
									</video>
									<button class="g12-vibe-video-mute" type="button" aria-label="<?php echo esc_attr__( 'Unmute video', 'gtwelve-elementor' ); ?>" aria-pressed="false">
									<span class="g12-vibe-video-mute-icon g12-vibe-video-icon-muted" aria-hidden="true">
										<svg viewBox="0 0 24 24" focusable="false">
											<path d="M4 10v4h3l4 3V7l-4 3H4z"></path>
											<path d="M15.5 9.5l4 5m0-5l-4 5"></path>
										</svg>
									</span>
									<span class="g12-vibe-video-mute-icon g12-vibe-video-icon-unmuted" aria-hidden="true" hidden>
										<svg viewBox="0 0 24 24" focusable="false">
											<path d="M4 10v4h3l4 3V7l-4 3H4z"></path>
											<path d="M15 9.25a4 4 0 0 1 0 5.5"></path>
											<path d="M17.75 7a7 7 0 0 1 0 10"></path>
										</svg>
										</span>
									</button>
									<?php if ( $link_url ) : ?>
										<a class="g12-vibe-video-link video-link" href="<?php echo esc_url( $link_url ); ?>"<?php echo $target . $nofollow; ?>>
											<?php echo esc_html( $button_text ); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="g12-vibe-video-pagination swiper-pagination"></div>
				</div>
			</div>
		</div>
		<?php
	}
}
