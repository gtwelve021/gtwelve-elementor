<?php
namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
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
		$this->add_control( 'sticky', array( 'label' => esc_html__( 'Sticky Header', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'default' => 'yes', 'return_value' => 'yes' ) );
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
			$this->add_control( 'color_' . $key, array( 'label' => $label, 'type' => Controls_Manager::COLOR, 'selectors' => array( '{{WRAPPER}} .g12-header' => '--' . $key . ': {{VALUE}};' ) ) );
		}
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
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
		$attributes = 'data-instance="' . esc_attr( $this->get_id() ) . '" data-sticky="' . ( 'yes' === ( $settings['sticky'] ?? 'yes' ) ? 'yes' : 'no' ) . '" data-hide-topbar="' . ( 'yes' === ( $settings['show_topbar'] ?? 'yes' ) ? 'no' : 'yes' ) . '"';
		$template = str_replace( 'data-g12-mega-header=""', 'data-g12-mega-header="" ' . $attributes, $template );
		// The template is plugin-owned; all user-controlled substitutions are escaped above.
		echo strtr( $template, $replacements ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
