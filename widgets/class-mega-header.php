<?php
namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Source-matched header with individually editable Elementor content. */
class Mega_Header extends Widget_Base {

	public function get_name(): string { return 'g12_mega_header'; }
	public function get_title(): string { return esc_html__( 'G12 Mega Header', 'gtwelve-elementor' ); }
	public function get_icon(): string { return 'eicon-header'; }
	public function get_categories(): array { return array( 'gtwelve' ); }
	public function get_keywords(): array { return array( 'header', 'mega menu', 'navigation', 'sticky', 'g12' ); }
	public function get_style_depends(): array { return array( 'gtwelve-elementor-mega-header' ); }
	public function get_script_depends(): array { return array( 'gtwelve-elementor-mega-header' ); }

	private function field_definitions(): array {
		static $fields;
		if ( null === $fields ) {
			$fields = json_decode( file_get_contents( GTWELVE_ELEMENTOR_PATH . 'includes/mega-header/controls.json' ), true ) ?: array();
		}
		return $fields;
	}

	private function field_default( array $field ) {
		$value = $field['default'];
		if ( 'media' === $field['kind'] ) {
			$value['url'] = GTWELVE_ELEMENTOR_URL . 'assets/mega-header/' . $value['url'];
		}
		return $value;
	}

	protected function register_controls(): void {
		$this->start_controls_section( 'behavior', array( 'label' => esc_html__( 'Header Settings', 'gtwelve-elementor' ) ) );
		$this->add_control( 'sticky_mode', array( 'label' => esc_html__( 'Scroll Behavior', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'sticky', 'options' => array( 'sticky' => esc_html__( 'Sticky and Compact on Scroll', 'gtwelve-elementor' ), 'normal' => esc_html__( 'Scroll with Page', 'gtwelve-elementor' ) ) ) );
		$this->add_control( 'show_topbar', array( 'label' => esc_html__( 'Show Top Bar', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes', 'return_value' => 'yes' ) );
		$this->add_control( 'editing_note', array( 'type' => Controls_Manager::RAW_HTML, 'raw' => esc_html__( 'Edit the supplied menu content in the sections below. The original menu structure is preserved. Use this widget in a full-width header container with no padding.', 'gtwelve-elementor' ) ) );
		$this->end_controls_section();
		$groups = array();
		foreach ( $this->field_definitions() as $field ) { $groups[ $field['section'] ][] = $field; }
		foreach ( $groups as $index => $fields ) {
			$this->start_controls_section( 'content_' . sanitize_title( $index ), array( 'label' => $index ) );
			foreach ( $fields as $field ) {
				$types = array( 'text' => Controls_Manager::TEXT, 'url' => Controls_Manager::URL, 'media' => Controls_Manager::MEDIA );
				$this->add_control( $field['key'], array( 'label' => $field['label'], 'type' => $types[ $field['kind'] ], 'default' => $this->field_default( $field ), 'label_block' => true, 'dynamic' => array( 'active' => true ) ) );
			}
			$this->end_controls_section();
		}
		$this->start_controls_section( 'appearance', array( 'label' => esc_html__( 'Colors', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		foreach ( array( 'gold' => 'Accent', 'ink' => 'Text', 'line' => 'Borders', 'surface' => 'Top Bar Background' ) as $key => $label ) {
			$selectors = array( '{{WRAPPER}} .g12-header' => '--' . $key . ': {{VALUE}};' );
			if ( 'surface' === $key ) { $selectors['{{WRAPPER}} .g12-header .g12-topbar'] = 'background-color: {{VALUE}};'; }
			$this->add_control( 'color_' . $key, array( 'label' => $label, 'type' => Controls_Manager::COLOR, 'selectors' => $selectors ) );
		}
		foreach ( array( 'header_background' => array( 'Header Background', '{{WRAPPER}} .g12-header:not(.is-scrolled)' ), 'scroll_background' => array( 'Header Background on Scroll', '{{WRAPPER}} .g12-header.is-scrolled' ), 'panel_background' => array( 'Dropdown Background', '{{WRAPPER}} .g12-header .g12-mega, {{WRAPPER}} .g12-header .g12-dropdown, {{WRAPPER}} .g12-header .g12-ecosystem-panel' ) ) as $key => $control ) {
			$this->add_control( $key, array( 'label' => $control[0], 'type' => Controls_Manager::COLOR, 'selectors' => array( $control[1] => 'background-color: {{VALUE}};' ) ) );
		}
		$this->end_controls_section();
		$this->register_header_style_controls();
	}

	private function register_header_style_controls(): void {
		$areas = array(
			'navigation' => array( 'Main Navigation', '.g12-menu > li > a' ),
			'topbar' => array( 'Top Bar', '.g12-topbar__link' ),
			'submenu' => array( 'Dropdown and Card Links', '.g12-dropdown a, {{WRAPPER}} .g12-header .g12-zone-card, {{WRAPPER}} .g12-header .g12-finance-group li a, {{WRAPPER}} .g12-header .g12-ecosystem-panel__list a' ),
			'tabs' => array( 'Mega Menu Tabs', '.g12-tab' ),
			'sidebar' => array( 'Mega Menu Sidebar', '.g12-mega__side-tab > a' ),
			'headings' => array( 'Mega Menu Headings', '.g12-finance-group h4, {{WRAPPER}} .g12-header .g12-ecosystem-panel__heading' ),
			'phone' => array( 'Phone Link', '.g12-call-button__text' ),
		);
		$this->start_controls_section( 'header_typography', array( 'label' => esc_html__( 'Fonts and Text Colors', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		foreach ( $areas as $key => $area ) {
			$selector = '{{WRAPPER}} .g12-header ' . $area[1];
			$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => $key . '_typography', 'label' => $area[0] . ' Typography', 'selector' => $selector ) );
			$this->add_control( $key . '_text_color', array( 'label' => $area[0] . ' Text Color', 'type' => Controls_Manager::COLOR, 'selectors' => array( $selector => 'color: {{VALUE}};' ) ) );
		}
		$this->add_control( 'link_hover_color', array( 'label' => esc_html__( 'Link Hover Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#b58b3b', 'selectors' => array(
			'{{WRAPPER}} .g12-header .g12-menu > li:hover > a, {{WRAPPER}} .g12-header .g12-dropdown a:hover, {{WRAPPER}} .g12-header .g12-zone-card:hover, {{WRAPPER}} .g12-header .g12-finance-group a:hover, {{WRAPPER}} .g12-header .g12-ecosystem-panel a:hover, {{WRAPPER}} .g12-header .g12-mega__side-tab:hover > a, {{WRAPPER}} .g12-header .g12-tab:hover, {{WRAPPER}} .g12-header .g12-topbar__link:hover, {{WRAPPER}} .g12-header .g12-call-button:hover .g12-call-button__text' => 'color: {{VALUE}}; background-color: transparent;',
		) ) );
		$this->add_control( 'active_text_color', array( 'label' => esc_html__( 'Active Tab Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#987127', 'selectors' => array( '{{WRAPPER}} .g12-header .g12-tab.is-active, {{WRAPPER}} .g12-header .g12-mega__side-tab.is-active > a' => 'color: {{VALUE}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'header_dimensions', array( 'label' => esc_html__( 'Logo and Spacing', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$sliders = array(
			'logo_width' => array( 'Logo Width', '.g12-nav > .g12-logo img', 'width', 40, 220 ),
			'compact_logo_width' => array( 'Logo Width on Scroll', '.g12-nav > .g12-logo img', 'width', 30, 180 ),
			'nav_height' => array( 'Navigation Height', '.g12-nav', 'height', 50, 160 ),
			'compact_nav_height' => array( 'Navigation Height on Scroll', '.g12-nav', 'height', 45, 120 ),
			'menu_gap' => array( 'Menu Item Gap', '.g12-menu', 'gap', 0, 40 ),
			'topbar_gap' => array( 'Top Bar Link Gap', '.g12-topbar', 'gap', 0, 60 ),
			'card_gap' => array( 'Mega Menu Card Gap', '.g12-mega__panel', 'gap', 0, 40 ),
		);
		foreach ( $sliders as $key => $control ) {
			$state = in_array( $key, array( 'compact_logo_width', 'compact_nav_height' ), true ) ? '.is-scrolled' : ( in_array( $key, array( 'logo_width', 'nav_height' ), true ) ? ':not(.is-scrolled)' : '' );
			$this->add_responsive_control( $key, array( 'label' => $control[0], 'type' => Controls_Manager::SLIDER, 'size_units' => array( 'px' ), 'range' => array( 'px' => array( 'min' => $control[3], 'max' => $control[4] ) ), 'selectors' => array( '{{WRAPPER}} .g12-header' . $state . ' ' . $control[1] => $control[2] . ': {{SIZE}}{{UNIT}};' ) ) );
		}
		foreach ( array( 'nav_item_padding' => array( 'Navigation Link Padding', '.g12-menu > li > a' ), 'dropdown_link_padding' => array( 'Dropdown Link Padding', '.g12-dropdown a' ), 'panel_padding' => array( 'Dropdown Panel Padding', '.g12-menu > li > .g12-mega, {{WRAPPER}} .g12-header .g12-menu > li > .g12-dropdown, {{WRAPPER}} .g12-header .g12-menu > li > .g12-ecosystem-panel' ), 'card_padding' => array( 'Card Padding', '.g12-zone-card' ) ) as $key => $control ) {
			$selectors = array( '{{WRAPPER}} .g12-header ' . $control[1] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' );
			if ( 'nav_item_padding' === $key ) {
				$selectors['{{WRAPPER}} .g12-header .g12-menu > .g12-menu-item--digital > a'] = 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;';
			}
			$this->add_responsive_control( $key, array( 'label' => $control[0], 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'selectors' => $selectors ) );
		}
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		// The retired theme header's scroll listener dereferences its missing wrapper.
		// Remove only that legacy file when this replacement header is rendered.
		$scripts = wp_scripts();
		foreach ( $scripts->registered as $handle => $script ) {
			if ( preg_match( '~(?:^|/)themes/g12-child/assets/js/scroll\.js(?:\?|$)~', (string) $script->src ) ) {
				wp_dequeue_script( $handle );
			}
		}
		$replacements = array( '{{instance}}' => esc_attr( $this->get_id() ) );
		foreach ( $this->field_definitions() as $field ) {
			$key = $field['key'];
			$value = $settings[ $key ] ?? $this->field_default( $field );
			if ( 'url' === $field['kind'] ) {
				$link = is_array( $value ) ? $value : array();
				// An empty URL keeps an anchor keyboard accessible without navigating away.
				$link['url'] = $link['url'] ?? '';
				if ( '' === $link['url'] ) { $link['url'] = '#'; }
				$this->add_link_attributes( $key, $link );
				$replacements[ '{{' . $key . '}}' ] = $this->get_render_attribute_string( $key );
			} elseif ( 'media' === $field['kind'] ) {
				$replacements[ '{{' . $key . '}}' ] = esc_url( is_array( $value ) ? ( $value['url'] ?? '' ) : '' );
			} else {
				$replacements[ '{{' . $key . '}}' ] = esc_attr( (string) $value );
			}
		}
		$template = file_get_contents( GTWELVE_ELEMENTOR_PATH . 'includes/mega-header/template.html' );
		$attributes = 'data-instance="' . esc_attr( $this->get_id() ) . '" data-sticky="' . ( 'normal' === ( $settings['sticky_mode'] ?? 'sticky' ) ? 'no' : 'yes' ) . '" data-hide-topbar="' . ( 'yes' === ( $settings['show_topbar'] ?? 'yes' ) ? 'no' : 'yes' ) . '"';
		$template = str_replace( 'data-g12-mega-header=""', 'data-g12-mega-header="" ' . $attributes, $template );
		// The template is plugin-owned; all user-controlled substitutions are escaped above.
		echo strtr( $template, $replacements ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
