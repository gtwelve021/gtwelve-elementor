<?php
namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Rating_Badge extends Widget_Base {
    public function get_name(): string {
        return 'gtwelve_rating_badge';
    }

    public function get_title(): string {
        return esc_html__( 'GTwelve Rating Badge', 'gtwelve-elementor' );
    }

    public function get_icon(): string {
        return 'eicon-rating';
    }

    public function get_categories(): array {
        return [ 'gtwelve' ];
    }

    public function get_keywords(): array {
        return [ 'rating', 'badge', 'stars', 'testimonial', 'g12' ];
    }

    public function get_style_depends(): array {
        return [ 'gtwelve-elementor-rating-badge' ];
    }

    protected function register_controls(): void {
        $this->start_controls_section( 'section_content', [
            'label' => __( 'Content', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'logo', [
            'label' => __( 'Logo', 'gtwelve-elementor' ),
            'type'  => Controls_Manager::MEDIA,
            'default' => [ 'url' => Utils::get_placeholder_image_src() ],
        ] );

        $this->add_control( 'rating_value', [
            'label'       => __( 'Rating Value', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => '4.8',
            'placeholder' => '4.8',
        ] );

        $this->add_control( 'stars_count', [
            'label' => __( 'Stars', 'gtwelve-elementor' ),
            'type'  => Controls_Manager::NUMBER,
            'min'   => 1,
            'max'   => 5,
            'step'  => 1,
            'default' => 5,
        ] );

        $this->add_control( 'label', [
            'label'       => __( 'Label', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Trusted Consultants', 'gtwelve-elementor' ),
            'placeholder' => __( 'Trusted Consultants', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'verified_text', [
            'label'       => __( 'Verified Text', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'verified by Trustindex', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'disclaimer_text', [
            'label'       => __( 'Disclaimer Text', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXTAREA,
            'rows'        => 4,
            'default'     => __( 'Trustindex verifies that the company has a review score above 4.5, based on reviews collected on Google over the past 12 months, qualifying it to receive the', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'disclaimer_link_label', [
            'label'       => __( 'Disclaimer Link Label', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Trusted Consultant Certificate', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'disclaimer_link', [
            'label'       => __( 'Disclaimer Link', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::URL,
            'default'     => [ 'url' => 'https://www.trustindex.io/the-trustindex-verified-badge/' ],
        ] );

        $this->add_control( 'badge_link', [
            'label'       => __( 'Link', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => __( 'https://reviews.example.com', 'gtwelve-elementor' ),
        ] );

        $this->end_controls_section();

        $this->register_container_style_controls();
        $this->register_logo_style_controls();
        $this->register_rating_style_controls();
        $this->register_text_style_controls();
        $this->register_info_style_controls();
        $this->register_tooltip_style_controls();
    }

    private function register_container_style_controls(): void {
        $this->start_controls_section( 'section_style_container', [
            'label' => __( 'Badge Container', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'badge_alignment', [
            'label'     => __( 'Alignment', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'flex-start' => [ 'title' => __( 'Left', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-left' ],
                'center'     => [ 'title' => __( 'Center', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'flex-end'   => [ 'title' => __( 'Right', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'default'   => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge-shell' => 'justify-content: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'badge_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'badge_border',
            'selector' => '{{WRAPPER}} .gtwelve-rating-badge',
        ] );

        $this->add_responsive_control( 'badge_radius', [
            'label'      => __( 'Border Radius', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'default'    => [ 'top' => 14, 'right' => 14, 'bottom' => 14, 'left' => 14, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'badge_padding', [
            'label'      => __( 'Padding', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', 'rem' ],
            'default'    => [ 'top' => 10, 'right' => 14, 'bottom' => 10, 'left' => 14, 'unit' => 'px', 'isLinked' => false ],
            'mobile_default' => [ 'top' => 8, 'right' => 10, 'bottom' => 8, 'left' => 10, 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'badge_max_width', [
            'label'      => __( 'Maximum Width', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'vw' ],
            'range'      => [
                'px' => [ 'min' => 120, 'max' => 1200 ],
                '%'  => [ 'min' => 10, 'max' => 100 ],
                'vw' => [ 'min' => 10, 'max' => 100 ],
            ],
            'default'    => [ 'size' => 92, 'unit' => 'vw' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'badge_shadow',
            'selector' => '{{WRAPPER}} .gtwelve-rating-badge',
        ] );

        $this->add_control( 'badge_hover_heading', [
            'label'     => __( 'Hover', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
        ] );

        $this->add_control( 'badge_hover_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge:hover, {{WRAPPER}} .gtwelve-rating-badge:focus' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'badge_hover_offset', [
            'label'      => __( 'Vertical Offset', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => -30, 'max' => 30 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge:hover, {{WRAPPER}} .gtwelve-rating-badge:focus' => 'transform: translateY({{SIZE}}{{UNIT}});',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'badge_hover_shadow',
            'selector' => '{{WRAPPER}} .gtwelve-rating-badge:hover, {{WRAPPER}} .gtwelve-rating-badge:focus',
        ] );

        $this->end_controls_section();
    }

    private function register_logo_style_controls(): void {
        $this->start_controls_section( 'section_style_logo', [
            'label' => __( 'Logo', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'logo_area_size', [
            'label'      => __( 'Logo Area Size', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 20, 'max' => 180 ],
                'em'  => [ 'min' => 1, 'max' => 12, 'step' => 0.1 ],
                'rem' => [ 'min' => 1, 'max' => 12, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 58, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 38, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__logo' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'logo_image_size', [
            'label'      => __( 'Image Size', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 8, 'max' => 160 ],
                '%'   => [ 'min' => 10, 'max' => 100 ],
                'em'  => [ 'min' => 0.5, 'max' => 10, 'step' => 0.1 ],
                'rem' => [ 'min' => 0.5, 'max' => 10, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 32, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__logo img, {{WRAPPER}} .gtwelve-rating-badge__logo svg' => 'width: {{SIZE}}{{UNIT}}; max-width: 100%; height: auto;',
            ],
        ] );

        $this->add_responsive_control( 'logo_spacing', [
            'label'      => __( 'Right Spacing', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 100 ],
                'em'  => [ 'min' => 0, 'max' => 6, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 6, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 14, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 10, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__logo' => 'margin-right: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'logo_divider_color', [
            'label'     => __( 'Divider Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#e0e0e0',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__logo' => 'border-right-color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'logo_divider_width', [
            'label'      => __( 'Divider Width', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
            'default'    => [ 'size' => 1, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__logo' => 'border-right-width: {{SIZE}}{{UNIT}}; border-right-style: solid;',
            ],
        ] );

        $this->add_responsive_control( 'logo_radius', [
            'label'      => __( 'Image Border Radius', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__logo img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_rating_style_controls(): void {
        $this->start_controls_section( 'section_style_rating', [
            'label' => __( 'Stars & Score', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'star_color', [
            'label'     => __( 'Star Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#f4b400',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__stars-fill' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'star_size', [
            'label'      => __( 'Star Size', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 8, 'max' => 80 ],
                'em'  => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
                'rem' => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 21, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__stars-fill' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'star_letter_spacing', [
            'label'      => __( 'Star Spacing', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range'      => [
                'px' => [ 'min' => -3, 'max' => 15, 'step' => 0.5 ],
                'em' => [ 'min' => -0.2, 'max' => 1, 'step' => 0.05 ],
            ],
            'default'    => [ 'size' => 1, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__stars-fill' => 'letter-spacing: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'stars_score_gap', [
            'label'      => __( 'Stars to Score Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 60 ],
                'em'  => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 6, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__stars' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'score_color', [
            'label'     => __( 'Score Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111111',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__score' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'score_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-rating-badge__score',
            'fields_options' => $this->typography_defaults( 14, '700', 1 ),
        ] );

        $this->end_controls_section();
    }

    private function register_text_style_controls(): void {
        $this->start_controls_section( 'section_style_text', [
            'label' => __( 'Title & Verified Text', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'content_gap', [
            'label'      => __( 'Content Row Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 50 ],
                'em'  => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 2, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__content' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111111',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__title' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'title_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-rating-badge__title',
            'fields_options' => $this->typography_defaults( 15, '700', 1.1 ),
        ] );

        $this->add_control( 'verified_color', [
            'label'     => __( 'Verified Text Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#030303',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__verified' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'verified_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-rating-badge__verified',
            'fields_options' => $this->typography_defaults( 12, '400', 1.3 ),
        ] );

        $this->add_responsive_control( 'verified_info_gap', [
            'label'      => __( 'Verified Text to Icon Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 40 ],
                'em'  => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 6, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__verified' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_info_style_controls(): void {
        $this->start_controls_section( 'section_style_info', [
            'label' => __( 'Info Icon', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'info_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__info' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'info_color', [
            'label'     => __( 'Text Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#555555',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__info' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'info_border_color', [
            'label'     => __( 'Border Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#9a9a9a',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__info' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'info_size', [
            'label'      => __( 'Size', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 10, 'max' => 60 ],
                'em'  => [ 'min' => 0.5, 'max' => 4, 'step' => 0.1 ],
                'rem' => [ 'min' => 0.5, 'max' => 4, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 16, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__info' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'info_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-rating-badge__info',
            'fields_options' => $this->typography_defaults( 11, '700', 1 ),
        ] );

        $this->add_responsive_control( 'info_radius', [
            'label'      => __( 'Border Radius', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'default'    => [ 'top' => 50, 'right' => 50, 'bottom' => 50, 'left' => 50, 'unit' => '%', 'isLinked' => true ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_tooltip_style_controls(): void {
        $this->start_controls_section( 'section_style_tooltip', [
            'label' => __( 'Tooltip', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'tooltip_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'tooltip_text_color', [
            'label'     => __( 'Text Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111111',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'tooltip_link_color', [
            'label'     => __( 'Link Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#0b5fff',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer a' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'tooltip_link_hover_color', [
            'label'     => __( 'Link Hover Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer a:hover, {{WRAPPER}} .gtwelve-rating-badge__disclaimer a:focus' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'tooltip_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-rating-badge__disclaimer',
            'fields_options' => $this->typography_defaults( 12, '400', 1.35 ),
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'tooltip_border',
            'selector' => '{{WRAPPER}} .gtwelve-rating-badge__disclaimer',
        ] );

        $this->add_responsive_control( 'tooltip_width', [
            'label'      => __( 'Width', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vw' ],
            'range'      => [
                'px' => [ 'min' => 120, 'max' => 600 ],
                'vw' => [ 'min' => 20, 'max' => 95 ],
            ],
            'default'    => [ 'size' => 260, 'unit' => 'px' ],
            'mobile_default' => [ 'size' => 220, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'tooltip_padding', [
            'label'      => __( 'Padding', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', 'rem' ],
            'default'    => [ 'top' => 10, 'right' => 12, 'bottom' => 10, 'left' => 12, 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'tooltip_radius', [
            'label'      => __( 'Border Radius', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'default'    => [ 'top' => 10, 'right' => 10, 'bottom' => 10, 'left' => 10, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'tooltip_gap', [
            'label'      => __( 'Vertical Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => -50, 'max' => 100 ],
                'em'  => [ 'min' => -3, 'max' => 6, 'step' => 0.1 ],
                'rem' => [ 'min' => -3, 'max' => 6, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer' => 'bottom: calc(100% + {{SIZE}}{{UNIT}});',
            ],
        ] );

        $this->add_responsive_control( 'tooltip_horizontal_position', [
            'label'      => __( 'Horizontal Position', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ '%' ],
            'range'      => [ '%' => [ 'min' => -100, 'max' => 200 ] ],
            'default'    => [ 'size' => 50, 'unit' => '%' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-rating-badge__disclaimer' => 'left: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'tooltip_shadow',
            'selector' => '{{WRAPPER}} .gtwelve-rating-badge__disclaimer',
        ] );

        $this->end_controls_section();
    }

    private function typography_defaults( int $font_size, string $font_weight, float $line_height ): array {
        return [
            'typography'  => [ 'default' => 'custom' ],
            'font_size'   => [ 'default' => [ 'size' => $font_size, 'unit' => 'px' ] ],
            'font_weight' => [ 'default' => $font_weight ],
            'line_height' => [ 'default' => [ 'size' => $line_height, 'unit' => 'em' ] ],
        ];
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $stars    = max( 1, min( 5, (int) ( $settings['stars_count'] ?? 5 ) ) );
        $logo_url = $settings['logo']['url'] ?? '';
        $logo_alt = $settings['logo']['alt'] ?? __( 'Rating logo', 'gtwelve-elementor' );
        $link     = $settings['badge_link']['url'] ?? '';
        $rating_value = $settings['rating_value'] ?? '';
        $label = $settings['label'] ?? '';
        $verified_text = $settings['verified_text'] ?? '';
        $disclaimer_text = $settings['disclaimer_text'] ?? '';
        $disclaimer_link_label = $settings['disclaimer_link_label'] ?? '';
        $disclaimer_link = $settings['disclaimer_link']['url'] ?? '';

        $aria_label = trim( sprintf(
            /* translators: 1: rating value, 2: badge label, 3: verified text */
            __( 'Google rating %1$s. %2$s, %3$s.', 'gtwelve-elementor' ),
            $rating_value,
            $label,
            $verified_text
        ) );

        $tag_open  = '<div class="gtwelve-rating-badge" role="img" aria-label="' . esc_attr( $aria_label ) . '">';
        $tag_close = '</div>';

        if ( $link ) {
            $target   = ! empty( $settings['badge_link']['is_external'] ) ? ' target="_blank" rel="noopener"' : '';
            $tag_open = '<a class="gtwelve-rating-badge" href="' . esc_url( $link ) . '"' . $target . ' role="img" aria-label="' . esc_attr( $aria_label ) . '">';
            $tag_close = '</a>';
        }

        echo '<div class="gtwelve-rating-badge-shell">';
        echo $tag_open; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
        <?php if ( $logo_url ) : ?>
            <div class="gtwelve-rating-badge__logo" aria-hidden="true">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" loading="lazy" decoding="async" />
            </div>
        <?php endif; ?>
        <div class="gtwelve-rating-badge__content">
            <div class="gtwelve-rating-badge__stars">
                <span class="gtwelve-rating-badge__stars-fill" aria-hidden="true">
                    <?php for ( $i = 0; $i < $stars; $i++ ) : ?>
                        &#9733;
                    <?php endfor; ?>
                </span>
                <?php if ( $rating_value ) : ?>
                    <span class="gtwelve-rating-badge__score"><?php echo esc_html( $rating_value ); ?></span>
                <?php endif; ?>
            </div>
            <?php if ( $label ) : ?>
                <div class="gtwelve-rating-badge__title"><?php echo esc_html( $label ); ?></div>
            <?php endif; ?>
            <?php if ( $verified_text ) : ?>
                <div class="gtwelve-rating-badge__verified">
                    <?php echo esc_html( $verified_text ); ?>
                    <?php if ( $disclaimer_text || $disclaimer_link_label ) : ?>
                        <span class="gtwelve-rating-badge__info" aria-hidden="true">
                            i
                            <span class="gtwelve-rating-badge__disclaimer">
                                <?php echo esc_html( $disclaimer_text ); ?>
                                <?php if ( $disclaimer_link && $disclaimer_link_label ) : ?>
                                    <a href="<?php echo esc_url( $disclaimer_link ); ?>" target="_blank" rel="noopener">
                                        <?php echo esc_html( $disclaimer_link_label ); ?>
                                    </a>.
                                <?php endif; ?>
                            </span>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
        echo $tag_close; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</div>';
    }
}
