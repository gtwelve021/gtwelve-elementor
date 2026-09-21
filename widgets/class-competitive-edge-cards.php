<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Competitive_Edge_Cards extends Widget_Base {
	public function get_name(): string {
		return 'g12_competitive_edge_cards';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Competitive Edge Cards', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-gallery-grid';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'competitive', 'edge', 'cards', 'team', 'benefits', 'hover', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-competitive-edge-cards' );
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'heading',
			array(
				'label'       => esc_html__( 'Heading', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'How G12 Gives You the Competitive Edge', 'gtwelve-elementor' ),
			)
		);

		$this->add_control(
			'heading_tag',
			array(
				'label'   => esc_html__( 'Heading HTML Tag', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p'  => 'p',
				),
			)
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Competitive advantage', 'gtwelve-elementor' ),
			)
		);
		$repeater->add_control(
			'description',
			array(
				'label'   => esc_html__( 'Description', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Explain how this advantage helps clients move forward with confidence.', 'gtwelve-elementor' ),
			)
		);
		$repeater->add_control(
			'image',
			array(
				'label'       => esc_html__( 'Portrait Image', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'tone',
			array(
				'label'   => esc_html__( 'Card Tone', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'dark',
				'options' => array(
					'dark' => esc_html__( 'Dark', 'gtwelve-elementor' ),
					'gold' => esc_html__( 'Gold', 'gtwelve-elementor' ),
				),
			)
		);

		$this->add_control(
			'cards',
			array(
				'label'       => esc_html__( 'Cards', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => $this->get_default_cards(),
			)
		);

		$this->add_control(
			'reveal_description',
			array(
				'label'        => esc_html__( 'Reveal Description on Hover', 'gtwelve-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
				'description'  => esc_html__( 'Descriptions always remain visible on mobile and for reduced-motion users.', 'gtwelve-elementor' ),
			)
		);
		$this->end_controls_section();

		$this->register_heading_style_controls();
		$this->register_layout_style_controls();
		$this->register_card_style_controls();
		$this->register_image_style_controls();
	}

	private function register_heading_style_controls(): void {
		$this->start_controls_section( 'heading_style', array( 'label' => esc_html__( 'Heading', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'heading_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#000000', 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__heading' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'heading_typography', 'selector' => '{{WRAPPER}} .g12-competitive-edge__heading' ) );
		$this->add_responsive_control( 'heading_alignment', array( 'label' => esc_html__( 'Alignment', 'gtwelve-elementor' ), 'type' => Controls_Manager::CHOOSE, 'options' => array( 'left' => array( 'title' => esc_html__( 'Left', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-left' ), 'center' => array( 'title' => esc_html__( 'Center', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-center' ), 'right' => array( 'title' => esc_html__( 'Right', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-right' ) ), 'default' => 'center', 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__heading' => 'text-align: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'heading_spacing', array( 'label' => esc_html__( 'Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'default' => array( 'size' => 40, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_layout_style_controls(): void {
		$this->start_controls_section( 'layout_style', array( 'label' => esc_html__( 'Layout', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'columns', array( 'label' => esc_html__( 'Columns', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => '4', 'tablet_default' => '2', 'mobile_default' => '1', 'options' => array( '1' => '1', '2' => '2', '3' => '3', '4' => '4' ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
		$this->add_responsive_control( 'card_gap', array( 'label' => esc_html__( 'Gap', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 80 ) ), 'default' => array( 'size' => 30, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 24, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 20, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__grid' => 'gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_min_height', array( 'label' => esc_html__( 'Card Minimum Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 240, 'max' => 750 ) ), 'default' => array( 'size' => 406, 'unit' => 'px' ), 'tablet_default' => array( 'size' => 420, 'unit' => 'px' ), 'mobile_default' => array( 'size' => 440, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__card' => 'min-height: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_card_style_controls(): void {
		$this->start_controls_section( 'card_style', array( 'label' => esc_html__( 'Cards', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'dark_background', array( 'label' => esc_html__( 'Dark Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#000000', 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__card--dark' => '--g12-edge-card-bg: {{VALUE}};' ) ) );
		$this->add_control( 'gold_background', array( 'label' => esc_html__( 'Gold Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#d6a456', 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__card--gold' => '--g12-edge-card-bg: {{VALUE}};' ) ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Title Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__title' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .g12-competitive-edge__title' ) );
		$this->add_control( 'description_color', array( 'label' => esc_html__( 'Description Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__description, {{WRAPPER}} .g12-competitive-edge__description a' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'description_typography', 'selector' => '{{WRAPPER}} .g12-competitive-edge__description' ) );
		$this->add_responsive_control( 'card_padding', array( 'label' => esc_html__( 'Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Border Radius', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_group_control( Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .g12-competitive-edge__card' ) );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .g12-competitive-edge__card' ) );
		$this->end_controls_section();
	}

	private function register_image_style_controls(): void {
		$this->start_controls_section( 'image_style', array( 'label' => esc_html__( 'Images', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'image_width', array( 'label' => esc_html__( 'Width', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'size_units' => array( '%', 'px' ), 'range' => array( '%' => array( 'min' => 30, 'max' => 120 ), 'px' => array( 'min' => 100, 'max' => 600 ) ), 'default' => array( 'size' => 88, 'unit' => '%' ), 'tablet_default' => array( 'size' => 72, 'unit' => '%' ), 'mobile_default' => array( 'size' => 80, 'unit' => '%' ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__image' => 'width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'image_offset', array( 'label' => esc_html__( 'Bottom Offset', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => -100, 'max' => 100 ) ), 'default' => array( 'size' => 0, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-competitive-edge__image-wrap' => 'bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$cards    = $settings['cards'] ?? array();

		if ( empty( $cards ) ) {
			return;
		}

		$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p' );
		$heading_tag  = in_array( $settings['heading_tag'] ?? 'h2', $allowed_tags, true ) ? $settings['heading_tag'] : 'h2';
		$classes      = array( 'g12-competitive-edge' );

		if ( 'yes' === ( $settings['reveal_description'] ?? 'yes' ) ) {
			$classes[] = 'g12-competitive-edge--hover-reveal';
		}
		?>
		<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php if ( ! empty( $settings['heading'] ) ) : ?>
				<<?php echo esc_html( $heading_tag ); ?> class="g12-competitive-edge__heading"><?php echo esc_html( $settings['heading'] ); ?></<?php echo esc_html( $heading_tag ); ?>>
			<?php endif; ?>
			<div class="g12-competitive-edge__grid">
				<?php foreach ( $cards as $card ) :
					$tone      = 'gold' === ( $card['tone'] ?? '' ) ? 'gold' : 'dark';
					$has_image = ! empty( $card['image']['url'] );
					?>
					<article class="g12-competitive-edge__card g12-competitive-edge__card--<?php echo esc_attr( $tone ); ?> elementor-repeater-item-<?php echo esc_attr( $card['_id'] ?? '' ); ?>"<?php echo 'yes' === ( $settings['reveal_description'] ?? 'yes' ) ? ' tabindex="0"' : ''; ?>>
						<div class="g12-competitive-edge__content">
							<?php if ( ! empty( $card['title'] ) ) : ?><h3 class="g12-competitive-edge__title"><?php echo esc_html( $card['title'] ); ?></h3><?php endif; ?>
							<?php if ( ! empty( $card['description'] ) ) : ?><div class="g12-competitive-edge__description"><?php echo wp_kses_post( $card['description'] ); ?></div><?php endif; ?>
						</div>
						<?php if ( $has_image ) : ?>
							<div class="g12-competitive-edge__image-wrap" aria-hidden="true"><img class="g12-competitive-edge__image" src="<?php echo esc_url( $card['image']['url'] ); ?>" alt="" loading="lazy"></div>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}

	private function get_default_cards(): array {
		return array(
			array(
				'title'       => esc_html__( 'One-Stop-Shop for Everything You Need', 'gtwelve-elementor' ),
				'description' => esc_html__( 'Get your business registration, residency, corporate bank account, PRO services, and even marketing—all managed by a single, streamlined team so you can focus on growth, not paperwork.', 'gtwelve-elementor' ),
				'image'       => array( 'url' => 'https://g12.ae/wp-content/uploads/2025/10/Tayssir-1.webp' ),
				'tone'        => 'dark',
			),
			array(
				'title'       => esc_html__( '15+ Years of Experience in Business Setup', 'gtwelve-elementor' ),
				'description' => esc_html__( 'With over a decade of combined experience, G12 knows every shortcut, compliance detail, and potential pitfall—so you don’t have to learn the hard way.', 'gtwelve-elementor' ),
				'image'       => array( 'url' => 'https://g12.ae/wp-content/uploads/2025/10/Erica.webp' ),
				'tone'        => 'gold',
			),
			array(
				'title'       => esc_html__( 'Strong Partner Network Across the UAE', 'gtwelve-elementor' ),
				'description' => esc_html__( 'From government authorities to financial institutions and marketing experts, our deep network opens doors and accelerates processes, giving you insider-level access from day one.', 'gtwelve-elementor' ),
				'image'       => array( 'url' => 'https://g12.ae/wp-content/uploads/2025/10/Janiee.webp' ),
				'tone'        => 'dark',
			),
			array(
				'title'       => esc_html__( 'Rated 4.9 Stars by Entrepreneurs Like You', 'gtwelve-elementor' ),
				'description' => esc_html__( 'Hundreds of founders have trusted G12 to help them successfully establish a company in the UAE. With a client-first approach, we aim at supporting you with speed and precision.', 'gtwelve-elementor' ),
				'image'       => array( 'url' => 'https://g12.ae/wp-content/uploads/2025/10/Soniya.webp' ),
				'tone'        => 'gold',
			),
		);
	}
}
