<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Site_Header extends Widget_Base {
	public function get_name(): string { return 'g12_site_header'; }
	public function get_title(): string { return esc_html__( 'G12 Site Header', 'gtwelve-elementor' ); }
	public function get_icon(): string { return 'eicon-header'; }
	public function get_categories(): array { return array( 'gtwelve' ); }
	public function get_keywords(): array { return array( 'header', 'navigation', 'menu', 'logo', 'mobile' ); }
	public function get_style_depends(): array { return array( 'gtwelve-elementor-site-header' ); }
	public function get_script_depends(): array { return array( 'gtwelve-elementor-site-header' ); }

	protected function register_controls(): void {
		$this->start_controls_section( 'header_content', array( 'label' => esc_html__( 'Header', 'gtwelve-elementor' ) ) );
		$this->add_control( 'logo', array( 'label' => esc_html__( 'Logo', 'gtwelve-elementor' ), 'type' => Controls_Manager::MEDIA ) );
		$this->add_control( 'logo_text', array( 'label' => esc_html__( 'Logo Text', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'G12', 'label_block' => true ) );
		$this->add_control( 'logo_link', array( 'label' => esc_html__( 'Logo Link', 'gtwelve-elementor' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => home_url( '/' ) ) ) );
		$this->add_control( 'cta_text', array( 'label' => esc_html__( 'CTA Text', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => '+971 52 703 4124' ) );
		$this->add_control( 'cta_link', array( 'label' => esc_html__( 'CTA Link', 'gtwelve-elementor' ), 'type' => Controls_Manager::URL, 'default' => array( 'url' => 'tel:+971527034124' ) ) );
		$this->add_control( 'show_topbar', array( 'label' => esc_html__( 'Show Top Bar', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->end_controls_section();

		$menu_item = new Repeater();
		$menu_item->add_control( 'item_type', array( 'label' => esc_html__( 'Item Type', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'main', 'options' => array( 'main' => esc_html__( 'Main Menu Item', 'gtwelve-elementor' ), 'sub' => esc_html__( 'Dropdown Item', 'gtwelve-elementor' ) ) ) );
		$menu_item->add_control( 'label', array( 'label' => esc_html__( 'Label', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Menu Item', 'gtwelve-elementor' ), 'label_block' => true ) );
		$menu_item->add_control( 'link', array( 'label' => esc_html__( 'Link', 'gtwelve-elementor' ), 'type' => Controls_Manager::URL, 'placeholder' => 'https://g12.ae/' ) );
		$this->start_controls_section( 'navigation_content', array( 'label' => esc_html__( 'Navigation', 'gtwelve-elementor' ) ) );
		$this->add_control( 'menu_items', array( 'label' => esc_html__( 'Menu Items', 'gtwelve-elementor' ), 'type' => Controls_Manager::REPEATER, 'fields' => $menu_item->get_controls(), 'title_field' => '{{{ label }}}', 'description' => esc_html__( 'Place dropdown items immediately below their main menu item.', 'gtwelve-elementor' ), 'default' => array( array( 'item_type' => 'main', 'label' => 'Business Setup', 'link' => array( 'url' => '#' ) ), array( 'item_type' => 'sub', 'label' => 'Mainland Company', 'link' => array( 'url' => home_url( '/mainland-company-formation/' ) ) ), array( 'item_type' => 'sub', 'label' => 'Free Zone Company', 'link' => array( 'url' => home_url( '/free-zone-company-formation/' ) ) ), array( 'item_type' => 'main', 'label' => 'Financial Services', 'link' => array( 'url' => '#' ) ), array( 'item_type' => 'main', 'label' => 'Real Estate', 'link' => array( 'url' => '#' ) ), array( 'item_type' => 'main', 'label' => 'Contact', 'link' => array( 'url' => home_url( '/contact/' ) ) ) ) ) );
		$this->end_controls_section();

		$notice = new Repeater();
		$notice->add_control( 'icon', array( 'label' => esc_html__( 'Icon', 'gtwelve-elementor' ), 'type' => Controls_Manager::MEDIA ) );
		$notice->add_control( 'text', array( 'label' => esc_html__( 'Text', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Header Link', 'gtwelve-elementor' ), 'label_block' => true ) );
		$notice->add_control( 'link', array( 'label' => esc_html__( 'Link', 'gtwelve-elementor' ), 'type' => Controls_Manager::URL ) );
		$this->start_controls_section( 'topbar_content', array( 'label' => esc_html__( 'Top Bar Links', 'gtwelve-elementor' ), 'condition' => array( 'show_topbar' => 'yes' ) ) );
		$this->add_control( 'topbar_items', array( 'type' => Controls_Manager::REPEATER, 'fields' => $notice->get_controls(), 'title_field' => '{{{ text }}}', 'default' => array( array( 'text' => 'AI Cost Calculator', 'link' => array( 'url' => 'https://aiquote.g12.ae/', 'is_external' => true ) ), array( 'text' => 'Business Setup Guide', 'link' => array( 'url' => home_url( '/business-setup-guide/' ) ) ), array( 'text' => 'Refer & Earn', 'link' => array( 'url' => home_url( '/refer-and-earn/' ) ) ) ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'style', array( 'label' => esc_html__( 'Style', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'background', array( 'label' => esc_html__( 'Header Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-site-header__main' => 'background-color: {{VALUE}};' ) ) );
		$this->add_control( 'text_color', array( 'label' => esc_html__( 'Navigation Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#111111', 'selectors' => array( '{{WRAPPER}} .g12-site-header' => '--g12-header-text: {{VALUE}};' ) ) );
		$this->add_control( 'accent', array( 'label' => esc_html__( 'Accent Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#c8953d', 'selectors' => array( '{{WRAPPER}} .g12-site-header' => '--g12-header-accent: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'nav_typography', 'selector' => '{{WRAPPER}} .g12-site-header__nav' ) );
		$this->end_controls_section();
	}

	private function link_attributes( string $name, array $link ): void {
		if ( empty( $link['url'] ) ) { return; }
		$this->add_link_attributes( $name, $link );
	}

	private function render_navigation( array $items ): void {
		$groups = array();
		foreach ( $items as $item ) {
			if ( 'sub' !== ( $item['item_type'] ?? 'main' ) || empty( $groups ) ) {
				if ( 'sub' === ( $item['item_type'] ?? 'main' ) ) { continue; }
				$groups[] = array( 'main' => $item, 'children' => array() );
			} else {
				$groups[ count( $groups ) - 1 ]['children'][] = $item;
			}
		}
		echo '<ul class="g12-site-header__menu">';
		foreach ( $groups as $group_index => $group ) {
			$main = $group['main'];
			$children = $group['children'];
			$main_key = 'menu_main_' . $group_index;
			$this->link_attributes( $main_key, $main['link'] ?? array() );
			echo '<li class="' . ( $children ? 'menu-item-has-children' : '' ) . '"><a ' . $this->get_render_attribute_string( $main_key ) . ( $children ? ' aria-haspopup="true" aria-expanded="false"' : '' ) . '>' . esc_html( $main['label'] ?? '' ) . '</a>';
			if ( $children ) {
				echo '<ul class="sub-menu">';
				foreach ( $children as $child_index => $child ) {
					$child_key = 'menu_child_' . $group_index . '_' . $child_index;
					$this->link_attributes( $child_key, $child['link'] ?? array() );
					echo '<li><a ' . $this->get_render_attribute_string( $child_key ) . '>' . esc_html( $child['label'] ?? '' ) . '</a></li>';
				}
				echo '</ul>';
			}
			echo '</li>';
		}
		echo '</ul>';
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$logo_url = ! empty( $settings['logo']['url'] ) ? $settings['logo']['url'] : '';
		$this->link_attributes( 'logo_link', $settings['logo_link'] ?? array() );
		$this->link_attributes( 'cta_link', $settings['cta_link'] ?? array() );
		$nav_id = 'g12-header-nav-' . $this->get_id();
		?>
		<header class="g12-site-header" data-g12-site-header>
			<?php if ( 'yes' === ( $settings['show_topbar'] ?? '' ) && ! empty( $settings['topbar_items'] ) ) : ?>
				<div class="g12-site-header__topbar"><div class="g12-site-header__topbar-inner">
					<?php foreach ( $settings['topbar_items'] as $index => $item ) : $key = 'topbar_' . $index; $this->link_attributes( $key, $item['link'] ?? array() ); ?>
						<a class="g12-site-header__notice" <?php echo $this->get_render_attribute_string( $key ); ?>>
							<?php if ( ! empty( $item['icon']['url'] ) ) : ?><img src="<?php echo esc_url( $item['icon']['url'] ); ?>" alt="" loading="lazy"><?php endif; ?>
							<span><?php echo esc_html( $item['text'] ?? '' ); ?></span>
						</a>
					<?php endforeach; ?>
				</div></div>
			<?php endif; ?>
			<div class="g12-site-header__main"><div class="g12-site-header__inner">
				<a class="g12-site-header__brand" <?php echo $this->get_render_attribute_string( 'logo_link' ); ?> aria-label="<?php echo esc_attr__( 'Home', 'gtwelve-elementor' ); ?>">
					<?php if ( $logo_url ) : ?><img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $settings['logo_text'] ?? get_bloginfo( 'name' ) ); ?>"><?php else : ?><span><?php echo esc_html( $settings['logo_text'] ?? 'G12' ); ?></span><?php endif; ?>
				</a>
				<button class="g12-site-header__toggle" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr( $nav_id ); ?>"><span></span><span></span><span></span><b><?php echo esc_html__( 'Menu', 'gtwelve-elementor' ); ?></b></button>
				<nav id="<?php echo esc_attr( $nav_id ); ?>" class="g12-site-header__nav" aria-label="<?php echo esc_attr__( 'Primary navigation', 'gtwelve-elementor' ); ?>">
					<?php $this->render_navigation( $settings['menu_items'] ?? array() ); ?>
				</nav>
				<?php if ( ! empty( $settings['cta_text'] ) ) : ?><a class="g12-site-header__cta" <?php echo $this->get_render_attribute_string( 'cta_link' ); ?>><span aria-hidden="true">☎</span><?php echo esc_html( $settings['cta_text'] ); ?></a><?php endif; ?>
			</div></div>
		</header>
		<?php
	}
}
