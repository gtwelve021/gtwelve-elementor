<?php
namespace GTwelveElementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {
	const MINIMUM_ELEMENTOR_VERSION = '3.10.0';
	const MINIMUM_PHP_VERSION       = '7.4';

	private static ?Plugin $instance = null;

	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		AI_Handler::register();
		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		if ( $this->can_load() ) {
			add_action( 'elementor/elements/categories_registered', array( $this, 'register_widget_category' ) );
			add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
			add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_styles' ) );
			add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_scripts' ) );
		}
	}

	public function load_textdomain(): void {
		load_plugin_textdomain( 'gtwelve-elementor', false, dirname( plugin_basename( GTWELVE_ELEMENTOR_FILE ) ) . '/languages' );
	}

	private function can_load(): bool {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return false;
		}

		if ( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=' ) ) {
			return false;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			return false;
		}

		return true;
	}

	public function admin_notices(): void {
		if ( did_action( 'elementor/loaded' ) && version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=' ) && version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			return;
		}

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = '';

		if ( ! did_action( 'elementor/loaded' ) ) {
			$message = esc_html__( 'GTwelve Elementor requires Elementor to be installed and activated.', 'gtwelve-elementor' );
		} elseif ( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=' ) ) {
			$message = sprintf(
				/* translators: 1: required PHP version, 2: current PHP version */
				esc_html__( 'GTwelve Elementor requires PHP %1$s or higher. Your site is running PHP %2$s.', 'gtwelve-elementor' ),
				self::MINIMUM_PHP_VERSION,
				PHP_VERSION
			);
		} elseif ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			$message = sprintf(
				/* translators: 1: required Elementor version, 2: current Elementor version */
				esc_html__( 'GTwelve Elementor requires Elementor %1$s or higher. Your site is running Elementor %2$s.', 'gtwelve-elementor' ),
				self::MINIMUM_ELEMENTOR_VERSION,
				ELEMENTOR_VERSION
			);
		}

		if ( $message ) {
			printf( '<div class="notice notice-warning"><p>%s</p></div>', esc_html( $message ) );
		}
	}

	public function register_widget_category( $elements_manager ): void {
		$elements_manager->add_category(
			'gtwelve',
			array(
				'title' => esc_html__( 'Premium Elements', 'gtwelve-elementor' ),
				'icon'  => 'fa fa-plug',
			)
		);
	}

	public function register_styles(): void {
		wp_register_style(
			'gtwelve-elementor-widgets',
			GTWELVE_ELEMENTOR_URL . 'assets/css/widgets.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-ai-search',
			GTWELVE_ELEMENTOR_URL . 'assets/css/ai-search.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-business-package-cards',
			GTWELVE_ELEMENTOR_URL . 'assets/css/business-package-cards.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-image-accordion',
			GTWELVE_ELEMENTOR_URL . 'assets/css/image-accordion.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-rating-badge',
			GTWELVE_ELEMENTOR_URL . 'assets/css/rating-badge.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-featured-pricing-cards',
			GTWELVE_ELEMENTOR_URL . 'assets/css/featured-pricing-cards.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-ticker-v2',
			GTWELVE_ELEMENTOR_URL . 'assets/css/ticker-v2.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-single-cross-ticker',
			GTWELVE_ELEMENTOR_URL . 'assets/css/single-cross-ticker.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-testimonial-quote-cards',
			GTWELVE_ELEMENTOR_URL . 'assets/css/testimonial-quote-cards.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-image-box-popup',
			GTWELVE_ELEMENTOR_URL . 'assets/css/image-box-popup.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-feature-benefits',
			GTWELVE_ELEMENTOR_URL . 'assets/css/feature-benefits.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-setup-comparison',
			GTWELVE_ELEMENTOR_URL . 'assets/css/setup-comparison.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-vibe-video-carousel',
			GTWELVE_ELEMENTOR_URL . 'assets/css/vibe-video-carousel.css',
			array( 'swiper' ),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-process-timeline',
			GTWELVE_ELEMENTOR_URL . 'assets/css/process-timeline.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-competitive-edge-cards',
			GTWELVE_ELEMENTOR_URL . 'assets/css/competitive-edge-cards.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-benefits-image-panel',
			GTWELVE_ELEMENTOR_URL . 'assets/css/benefits-image-panel.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-blog-list',
			GTWELVE_ELEMENTOR_URL . 'assets/css/blog-list.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-partner-logo-carousel',
			GTWELVE_ELEMENTOR_URL . 'assets/css/partner-logo-carousel.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style(
			'gtwelve-elementor-home-v2-hero',
			GTWELVE_ELEMENTOR_URL . 'assets/css/home-v2-hero.css',
			array(),
			GTWELVE_ELEMENTOR_VERSION
		);

		wp_register_style( 'gtwelve-elementor-mega-header', GTWELVE_ELEMENTOR_URL . 'assets/mega-header/css/header.css', array(), GTWELVE_ELEMENTOR_VERSION );

	}

	public function register_scripts(): void {
		wp_register_script(
			'gtwelve-elementor-widgets',
			GTWELVE_ELEMENTOR_URL . 'assets/js/widgets.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-ai-search',
			GTWELVE_ELEMENTOR_URL . 'assets/js/ai-search.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-business-package-cards',
			GTWELVE_ELEMENTOR_URL . 'assets/js/business-package-cards.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-testimonial-quote-cards',
			GTWELVE_ELEMENTOR_URL . 'assets/js/testimonial-quote-cards.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-image-box-popup',
			GTWELVE_ELEMENTOR_URL . 'assets/js/image-box-popup.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-feature-benefits',
			GTWELVE_ELEMENTOR_URL . 'assets/js/feature-benefits.js',
			array( 'elementor-frontend', 'swiper' ),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-vibe-video-carousel',
			GTWELVE_ELEMENTOR_URL . 'assets/js/vibe-video-carousel.js',
			array( 'elementor-frontend', 'swiper' ),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-process-timeline',
			GTWELVE_ELEMENTOR_URL . 'assets/js/process-timeline.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-setup-comparison',
			GTWELVE_ELEMENTOR_URL . 'assets/js/setup-comparison.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script(
			'gtwelve-elementor-home-v2-hero',
			GTWELVE_ELEMENTOR_URL . 'assets/js/home-v2-hero.js',
			array(),
			GTWELVE_ELEMENTOR_VERSION,
			true
		);

		wp_register_script( 'gtwelve-elementor-mega-header', GTWELVE_ELEMENTOR_URL . 'assets/mega-header/js/header.js', array( 'jquery', 'elementor-frontend' ), GTWELVE_ELEMENTOR_VERSION, true );

	}

	public function register_widgets( $widgets_manager ): void {
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-interactive-tile-carousel.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-expandable-content.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-license-table.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-license-table-v2.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-ai-search.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-referral-earnings-calculator.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-review-grid.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-video-slider.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-team-feature-strip.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-enquiry-step-card.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-business-package-cards.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-business-highlights.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-image-accordion.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-rating-badge.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-featured-pricing-cards.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-ticker-v2.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-single-cross-ticker.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-testimonial-quote-cards.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-image-box-popup.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-feature-benefits.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-setup-comparison.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-vibe-video-carousel.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-process-timeline.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-competitive-edge-cards.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-benefits-image-panel.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-blog-list.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-partner-logo-carousel.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-home-v2-hero.php';
		require_once GTWELVE_ELEMENTOR_PATH . 'widgets/class-mega-header.php';

		$widgets_manager->register( new Widgets\Interactive_Tile_Carousel() );
		$widgets_manager->register( new Widgets\Expandable_Content() );
		$widgets_manager->register( new Widgets\License_Table() );
		$widgets_manager->register( new Widgets\License_Table_V2() );
		$widgets_manager->register( new Widgets\AI_Search() );
		$widgets_manager->register( new Widgets\Referral_Earnings_Calculator() );
		$widgets_manager->register( new Widgets\Review_Grid() );
		$widgets_manager->register( new Widgets\Video_Slider() );
		$widgets_manager->register( new Widgets\Team_Feature_Strip() );
		$widgets_manager->register( new Widgets\Enquiry_Step_Card() );
		$widgets_manager->register( new Widgets\Business_Package_Cards() );
		$widgets_manager->register( new Widgets\Business_Highlights() );
		$widgets_manager->register( new Widgets\Image_Accordion() );
		$widgets_manager->register( new Widgets\Rating_Badge() );
		$widgets_manager->register( new Widgets\Featured_Pricing_Cards() );
		$widgets_manager->register( new Widgets\Ticker_V2() );
		$widgets_manager->register( new Widgets\Single_Cross_Ticker() );
		$widgets_manager->register( new Widgets\Testimonial_Quote_Cards() );
		$widgets_manager->register( new Widgets\Image_Box_Popup() );
		$widgets_manager->register( new Widgets\Feature_Benefits() );
		$widgets_manager->register( new Widgets\Setup_Comparison() );
		$widgets_manager->register( new Widgets\Vibe_Video_Carousel() );
		$widgets_manager->register( new Widgets\Process_Timeline() );
		$widgets_manager->register( new Widgets\Competitive_Edge_Cards() );
		$widgets_manager->register( new Widgets\Benefits_Image_Panel() );
		$widgets_manager->register( new Widgets\Blog_List() );
		$widgets_manager->register( new Widgets\Partner_Logo_Carousel() );
		$widgets_manager->register( new Widgets\Home_V2_Hero() );
		$widgets_manager->register( new Widgets\Mega_Header() );
	}
}
