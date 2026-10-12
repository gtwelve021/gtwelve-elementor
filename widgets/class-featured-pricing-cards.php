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

class Featured_Pricing_Cards extends Widget_Base {
    public function get_name(): string {
        return 'gtwelve_featured_pricing_cards';
    }

    public function get_title(): string {
        return esc_html__( 'GTwelve Featured Pricing Cards', 'gtwelve-elementor' );
    }

    public function get_icon(): string {
        return 'eicon-price-table';
    }

    public function get_categories(): array {
        return [ 'gtwelve' ];
    }

    public function get_keywords(): array {
        return [ 'pricing', 'plans', 'table', 'packages', 'g12' ];
    }

    public function get_style_depends(): array {
        return [ 'gtwelve-elementor-featured-pricing-cards' ];
    }

    protected function register_controls(): void {
        $this->start_controls_section( 'section_general', [
            'label' => __( 'Layout', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'column_gap', [
            'label'      => __( 'Card Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 120 ],
                'em'  => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 32, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing' => '--gtwelve-featured-pricing-gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'minimum_card_width', [
            'label'      => __( 'Minimum Card Width', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 180, 'max' => 600 ],
                'rem' => [ 'min' => 12, 'max' => 40, 'step' => 0.5 ],
            ],
            'default'    => [ 'size' => 260, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing' => '--gtwelve-featured-pricing-min-width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_cards', [
            'label' => __( 'Plans', 'gtwelve-elementor' ),
        ] );

        $feature_repeater = new Repeater();
        $feature_repeater->add_control( 'feature_text', [
            'label'       => __( 'Feature', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => __( '0% Tax & 100% Ownership', 'gtwelve-elementor' ),
        ] );

        $card_repeater = new Repeater();

        $card_repeater->add_control( 'plan_title', [
            'label'       => __( 'Plan Title', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Free Zone Business Setup', 'gtwelve-elementor' ),
            'label_block' => true,
        ] );

        $card_repeater->add_control( 'plan_subtitle', [
            'label'       => __( 'Subtitle', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'with 1 Free Visa for Life', 'gtwelve-elementor' ),
        ] );

        $card_repeater->add_control( 'price_caption', [
            'label'       => __( 'Price Caption', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Starting from', 'gtwelve-elementor' ),
        ] );

        $card_repeater->add_control( 'price_text', [
            'label'       => __( 'Price Text', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'AED 14,999', 'gtwelve-elementor' ),
            'label_block' => true,
        ] );

        $card_repeater->add_control( 'is_featured', [
            'label'        => __( 'Featured Plan', 'gtwelve-elementor' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'gtwelve-elementor' ),
            'label_off'    => __( 'No', 'gtwelve-elementor' ),
            'return_value' => 'yes',
            'default'      => 'no',
        ] );

        $card_repeater->add_control( 'badge_text', [
            'label'       => __( 'Badge Text', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Most Popular', 'gtwelve-elementor' ),
            'condition'   => [ 'is_featured' => 'yes' ],
        ] );

        $card_repeater->add_control( 'features', [
            'label'       => __( 'Features', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $feature_repeater->get_controls(),
            'default'     => [
                [ 'feature_text' => __( '0% Tax & 100% Ownership', 'gtwelve-elementor' ) ],
                [ 'feature_text' => __( '1-Year Trade License', 'gtwelve-elementor' ) ],
                [ 'feature_text' => __( 'Free UAE Visa for Life', 'gtwelve-elementor' ) ],
                [ 'feature_text' => __( 'VIP Medical & Emirates ID', 'gtwelve-elementor' ) ],
            ],
            'title_field' => '{{{ feature_text }}}',
        ] );

        $card_repeater->add_control( 'button_text', [
            'label'       => __( 'Button Text', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => __( 'Start Your Business', 'gtwelve-elementor' ),
        ] );

        $card_repeater->add_control( 'button_link', [
            'label'       => __( 'Button Link', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::URL,
            'placeholder' => __( 'https://example.com', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'plans', [
            'label'       => __( 'Pricing Cards', 'gtwelve-elementor' ),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $card_repeater->get_controls(),
            'default'     => [
                [
                    'plan_title'   => __( 'Free Zone Business Setup', 'gtwelve-elementor' ),
                    'plan_subtitle'=> __( 'with 1 Free Visa for Life', 'gtwelve-elementor' ),
                    'price_text'   => __( 'AED 14,999', 'gtwelve-elementor' ),
                ],
                [
                    'plan_title'   => __( 'VIP Holding Company', 'gtwelve-elementor' ),
                    'plan_subtitle'=> __( 'with 1 Visa', 'gtwelve-elementor' ),
                    'price_text'   => __( 'AED 21,999', 'gtwelve-elementor' ),
                    'is_featured'  => 'yes',
                ],
                [
                    'plan_title'   => __( '10-Year UAE Golden Visa', 'gtwelve-elementor' ),
                    'plan_subtitle'=> __( 'Through Investment', 'gtwelve-elementor' ),
                    'price_text'   => __( 'AED 14,999', 'gtwelve-elementor' ),
                ],
            ],
            'title_field' => '{{{ plan_title }}}',
        ] );

        $this->end_controls_section();

        $this->register_card_style_controls();
        $this->register_featured_card_style_controls();
        $this->register_badge_style_controls();
        $this->register_text_style_controls();
        $this->register_price_style_controls();
        $this->register_features_style_controls();
        $this->register_button_style_controls();
    }

    private function register_card_style_controls(): void {
        $this->start_controls_section( 'section_style_card', [
            'label' => __( 'Card', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'card_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'card_border',
            'selector' => '{{WRAPPER}} .gtwelve-featured-pricing-card',
        ] );

        $this->add_responsive_control( 'card_radius', [
            'label'      => __( 'Border Radius', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'default'    => [ 'top' => 22, 'right' => 22, 'bottom' => 22, 'left' => 22, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'card_padding', [
            'label'      => __( 'Padding', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', 'rem', '%' ],
            'default'    => [ 'top' => 28, 'right' => 28, 'bottom' => 28, 'left' => 28, 'unit' => 'px', 'isLinked' => true ],
            'mobile_default' => [ 'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'card_shadow',
            'selector' => '{{WRAPPER}} .gtwelve-featured-pricing-card',
        ] );

        $this->add_responsive_control( 'card_min_height', [
            'label'      => __( 'Minimum Height', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vh' ],
            'range'      => [
                'px' => [ 'min' => 0, 'max' => 1000 ],
                'vh' => [ 'min' => 0, 'max' => 100 ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card' => 'min-height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_featured_card_style_controls(): void {
        $this->start_controls_section( 'section_style_featured_card', [
            'label' => __( 'Featured Card', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'featured_card_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card--featured' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'featured_border_color', [
            'label'     => __( 'Border Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d6a557',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card--featured' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'featured_card_offset', [
            'label'      => __( 'Vertical Offset', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px' ],
            'range'      => [ 'px' => [ 'min' => -80, 'max' => 80 ] ],
            'default'    => [ 'size' => 0, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card--featured' => 'transform: translateY({{SIZE}}{{UNIT}});',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'featured_card_shadow',
            'selector' => '{{WRAPPER}} .gtwelve-featured-pricing-card--featured',
        ] );

        $this->end_controls_section();
    }

    private function register_badge_style_controls(): void {
        $this->start_controls_section( 'section_style_badge', [
            'label' => __( 'Featured Badge', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'badge_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d6a557',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__badge' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'badge_text_color', [
            'label'     => __( 'Text Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__badge' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'badge_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-featured-pricing-card__badge',
            'fields_options' => $this->typography_defaults( 12, '700', 1 ),
        ] );

        $this->add_responsive_control( 'badge_padding', [
            'label'      => __( 'Padding', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', 'rem' ],
            'default'    => [ 'top' => 4, 'right' => 12, 'bottom' => 4, 'left' => 12, 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'badge_radius', [
            'label'      => __( 'Border Radius', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'default'    => [ 'top' => 999, 'right' => 999, 'bottom' => 999, 'left' => 999, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'badge_top', [
            'label'      => __( 'Top Position', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [
                'px' => [ 'min' => -100, 'max' => 100 ],
                '%'  => [ 'min' => -100, 'max' => 100 ],
            ],
            'default'    => [ 'size' => -11, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__badge' => 'top: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'badge_right', [
            'label'      => __( 'Right Position', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range'      => [
                'px' => [ 'min' => -100, 'max' => 200 ],
                '%'  => [ 'min' => -100, 'max' => 100 ],
            ],
            'default'    => [ 'size' => 10, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__badge' => 'right: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_text_style_controls(): void {
        $this->start_controls_section( 'section_style_text', [
            'label' => __( 'Title & Subtitle', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'text_alignment', [
            'label'     => __( 'Text Alignment', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [ 'title' => __( 'Left', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'default'   => 'left',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__header' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'title_color', [
            'label'     => __( 'Title Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#111827',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__title' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'title_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-featured-pricing-card__title',
            'fields_options' => $this->typography_defaults( 20, '700', 1.2 ),
        ] );

        $this->add_control( 'subtitle_color', [
            'label'     => __( 'Subtitle Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6b7280',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__subtitle' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'subtitle_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-featured-pricing-card__subtitle',
            'fields_options' => $this->typography_defaults( 15, '400', 1.4 ),
        ] );

        $this->add_responsive_control( 'title_subtitle_gap', [
            'label'      => __( 'Title to Subtitle Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 80 ],
                'em'  => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 6, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__subtitle' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'header_spacing', [
            'label'      => __( 'Header Bottom Spacing', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 120 ],
                'em'  => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 26, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_price_style_controls(): void {
        $this->start_controls_section( 'section_style_price', [
            'label' => __( 'Price', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_responsive_control( 'caption_alignment', [
            'label'     => __( 'Caption Alignment', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'left'   => [ 'title' => __( 'Left', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-left' ],
                'center' => [ 'title' => __( 'Center', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'right'  => [ 'title' => __( 'Right', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'default'   => 'left',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__caption' => 'text-align: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'price_alignment', [
            'label'     => __( 'Price Alignment', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
                'flex-start' => [ 'title' => __( 'Left', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-left' ],
                'center'     => [ 'title' => __( 'Center', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-center' ],
                'flex-end'   => [ 'title' => __( 'Right', 'gtwelve-elementor' ), 'icon' => 'eicon-text-align-right' ],
            ],
            'default'   => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__price' => 'justify-content: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'caption_color', [
            'label'     => __( 'Caption Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#6b7280',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__caption' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'caption_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-featured-pricing-card__caption',
            'fields_options' => $this->typography_defaults( 14, '400', 1.4 ),
        ] );

        $this->add_responsive_control( 'caption_price_gap', [
            'label'      => __( 'Caption to Price Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 60 ],
                'em'  => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 6, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__caption' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_control( 'price_color', [
            'label'     => __( 'Price Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#b8862b',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__price' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'price_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-featured-pricing-card__price',
            'fields_options' => $this->typography_defaults( 32, '700', 1 ),
        ] );

        $this->add_control( 'currency_color', [
            'label'     => __( 'Currency Icon Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#b8862b',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__currency svg' => 'fill: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'currency_size', [
            'label'      => __( 'Currency Icon Size', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 8, 'max' => 100 ],
                'em'  => [ 'min' => 0.5, 'max' => 6, 'step' => 0.1 ],
                'rem' => [ 'min' => 0.5, 'max' => 6, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 32, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__currency svg' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'currency_price_gap', [
            'label'      => __( 'Icon to Price Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 60 ],
                'em'  => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 12, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__price' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'price_bottom_spacing', [
            'label'      => __( 'Bottom Spacing', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 140 ],
                'em'  => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 40, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__price-block' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_features_style_controls(): void {
        $this->start_controls_section( 'section_style_features', [
            'label' => __( 'Features', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'feature_text_color', [
            'label'     => __( 'Text Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#5f6469',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__feature' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'feature_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-featured-pricing-card__feature',
            'fields_options' => $this->typography_defaults( 14, '400', 1.45 ),
        ] );

        $this->add_control( 'feature_icon_color', [
            'label'     => __( 'Icon Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d6a557',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__icon svg' => 'stroke: {{VALUE}};',
            ],
        ] );

        $this->add_responsive_control( 'feature_icon_size', [
            'label'      => __( 'Icon Size', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 8, 'max' => 80 ],
                'em'  => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
                'rem' => [ 'min' => 0.5, 'max' => 5, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 20, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__icon, {{WRAPPER}} .gtwelve-featured-pricing-card__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'feature_row_gap', [
            'label'      => __( 'Row Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 80 ],
                'em'  => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 5, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 16, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__features' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'feature_icon_gap', [
            'label'      => __( 'Icon to Text Gap', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 60 ],
                'em'  => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 4, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 10, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__feature' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'features_bottom_spacing', [
            'label'      => __( 'Bottom Spacing', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem' ],
            'range'      => [
                'px'  => [ 'min' => 0, 'max' => 120 ],
                'em'  => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
                'rem' => [ 'min' => 0, 'max' => 8, 'step' => 0.1 ],
            ],
            'default'    => [ 'size' => 28, 'unit' => 'px' ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__features' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ] );

        $this->end_controls_section();
    }

    private function register_button_style_controls(): void {
        $this->start_controls_section( 'section_style_button', [
            'label' => __( 'Button', 'gtwelve-elementor' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );

        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'           => 'button_typography',
            'selector'       => '{{WRAPPER}} .gtwelve-featured-pricing-card__button',
            'fields_options' => $this->typography_defaults( 16, '500', 1 ),
        ] );

        $this->start_controls_tabs( 'button_style_tabs' );

        $this->start_controls_tab( 'button_style_normal', [
            'label' => __( 'Normal', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'button_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#000000',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__button' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_text_color', [
            'label'     => __( 'Text Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__button' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'featured_button_background', [
            'label'     => __( 'Featured Card Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d6a557',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card--featured .gtwelve-featured-pricing-card__button' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_tab();

        $this->start_controls_tab( 'button_style_hover', [
            'label' => __( 'Hover', 'gtwelve-elementor' ),
        ] );

        $this->add_control( 'button_hover_background', [
            'label'     => __( 'Background', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#d6a557',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__button:hover, {{WRAPPER}} .gtwelve-featured-pricing-card__button:focus' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'button_hover_text_color', [
            'label'     => __( 'Text Color', 'gtwelve-elementor' ),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__button:hover, {{WRAPPER}} .gtwelve-featured-pricing-card__button:focus' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'button_hover_shadow',
            'selector' => '{{WRAPPER}} .gtwelve-featured-pricing-card__button:hover, {{WRAPPER}} .gtwelve-featured-pricing-card__button:focus',
        ] );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'button_border',
            'selector' => '{{WRAPPER}} .gtwelve-featured-pricing-card__button',
            'separator' => 'before',
        ] );

        $this->add_responsive_control( 'button_radius', [
            'label'      => __( 'Border Radius', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em', 'rem' ],
            'default'    => [ 'top' => 99, 'right' => 99, 'bottom' => 99, 'left' => 99, 'unit' => 'px', 'isLinked' => true ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'button_padding', [
            'label'      => __( 'Padding', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', 'rem' ],
            'default'    => [ 'top' => 14, 'right' => 18, 'bottom' => 14, 'left' => 18, 'unit' => 'px', 'isLinked' => false ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ] );

        $this->add_responsive_control( 'button_width', [
            'label'      => __( 'Width', 'gtwelve-elementor' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ '%', 'px' ],
            'range'      => [
                '%'  => [ 'min' => 10, 'max' => 100 ],
                'px' => [ 'min' => 80, 'max' => 800 ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .gtwelve-featured-pricing-card__button' => 'width: {{SIZE}}{{UNIT}};',
            ],
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
        $plans    = $settings['plans'] ?? [];

        if ( empty( $plans ) ) {
            return;
        }

        $this->add_render_attribute( 'wrapper', 'class', 'gtwelve-featured-pricing' );
        ?>
        <section <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <div class="gtwelve-featured-pricing__grid">
                <?php foreach ( $plans as $plan ) :
                    $is_featured = ( $plan['is_featured'] ?? '' ) === 'yes';
                    $card_classes = [ 'gtwelve-featured-pricing-card' ];
                    if ( $is_featured ) {
                        $card_classes[] = 'gtwelve-featured-pricing-card--featured';
                    }
                    $features = $plan['features'] ?? [];
                    $button_text = $plan['button_text'] ?? '';
                    $button_link = $plan['button_link']['url'] ?? '';
                    $target_attr = '';
                    if ( ! empty( $plan['button_link']['is_external'] ) ) {
                        $target_attr .= ' target="_blank" rel="noopener"';
                    }
                    $raw_price    = $plan['price_text'] ?? '';
                    $trimmed_price = $raw_price;
                    $show_aed_icon = false;
                    if ( $raw_price ) {
                        $replacement_count = 0;
                        $cleaned = preg_replace( '/^\s*AED\s*/i', '', $raw_price, 1, $replacement_count );
                        if ( null !== $cleaned && $replacement_count > 0 ) {
                            $trimmed_price = ltrim( (string) $cleaned );
                            $show_aed_icon = true;
                        }
                    }
                    ?>
                    <article class="<?php echo esc_attr( implode( ' ', $card_classes ) ); ?>">
                        <?php if ( $is_featured && ! empty( $plan['badge_text'] ) ) : ?>
                            <span class="gtwelve-featured-pricing-card__badge"><?php echo esc_html( $plan['badge_text'] ); ?></span>
                        <?php endif; ?>
                        <header class="gtwelve-featured-pricing-card__header">
                            <?php if ( ! empty( $plan['plan_title'] ) ) : ?>
                                <h3 class="gtwelve-featured-pricing-card__title"><?php echo wp_kses( $plan['plan_title'], [ 'br' => [] ] ); ?></h3>
                            <?php endif; ?>
                            <?php if ( ! empty( $plan['plan_subtitle'] ) ) : ?>
                                <p class="gtwelve-featured-pricing-card__subtitle"><?php echo esc_html( $plan['plan_subtitle'] ); ?></p>
                            <?php endif; ?>
                        </header>
                        <div class="gtwelve-featured-pricing-card__price-block">
                            <?php if ( ! empty( $plan['price_caption'] ) ) : ?>
                                <span class="gtwelve-featured-pricing-card__caption"><?php echo esc_html( $plan['price_caption'] ); ?></span>
                            <?php endif; ?>
                            <?php if ( ! empty( $raw_price ) ) : ?>
                                <span class="gtwelve-featured-pricing-card__price">
                                    <?php if ( $show_aed_icon ) : ?>
                                        <span class="gtwelve-featured-pricing-card__currency" aria-label="<?php echo esc_attr__( 'AED', 'gtwelve-elementor' ); ?>">
                                            <svg viewBox="0 0 1000 870" width="24" height="24"  role="presentation" focusable="false">
                                                <path d="m88.3 1c0.4 0.6 2.6 3.3 4.7 5.9 15.3 18.2 26.8 47.8 33 85.1 4.1 24.5 4.3 32.2 4.3 125.6v87h-41.8c-38.2 0-42.6-0.2-50.1-1.7-11.8-2.5-24-9.2-32.2-17.8-6.5-6.9-6.3-7.3-5.9 13.6 0.5 17.3 0.7 19.2 3.2 28.6 4 14.9 9.5 26 17.8 35.9 11.3 13.6 22.8 21.2 39.2 26.3 3.5 1 10.9 1.4 37.1 1.6l32.7 0.5v43.3 43.4l-46.1-0.3-46.3-0.3-8-3.2c-9.5-3.8-13.8-6.6-23.1-14.9l-6.8-6.1 0.4 19.1c0.5 17.7 0.6 19.7 3.1 28.7 8.7 31.8 29.7 54.5 57.4 61.9 6.9 1.9 9.6 2 38.5 2.4l30.9 0.4v89.6c0 54.1-0.3 94-0.8 100.8-0.5 6.2-2.1 17.8-3.5 25.9-6.5 37.3-18.2 65.4-35 83.6l-3.4 3.7h169.1c101.1 0 176.7-0.4 187.8-0.9 19.5-1 63-5.3 72.8-7.4 3.1-0.6 8.9-1.5 12.7-2.1 8.1-1.2 21.5-4 40.8-8.9 27.2-6.8 52-15.3 76.3-26.1 7.6-3.4 29.4-14.5 35.2-18 3.1-1.8 6.8-4 8.2-4.7 3.9-2.1 10.4-6.3 19.9-13.1 4.7-3.4 9.4-6.7 10.4-7.4 4.2-2.8 18.7-14.9 25.3-21 25.1-23.1 46.1-48.8 62.4-76.3 2.3-4 5.3-9 6.6-11.1 3.3-5.6 16.9-33.6 18.2-37.8 0.6-1.9 1.4-3.9 1.8-4.3 2.6-3.4 17.6-50.6 19.4-60.9 0.6-3.3 0.9-3.8 3.4-4.3 1.6-0.3 24.9-0.3 51.8-0.1 53.8 0.4 53.8 0.4 65.7 5.9 6.7 3.1 8.7 4.5 16.1 11.2 9.7 8.7 8.8 10.1 8.2-11.7-0.4-12.8-0.9-20.7-1.8-23.9-3.4-12.3-4.2-14.9-7.2-21.1-9.8-21.4-26.2-36.7-47.2-44l-8.2-3-33.4-0.4-33.3-0.5 0.4-11.7c0.4-15.4 0.4-45.9-0.1-61.6l-0.4-12.6 44.6-0.2c38.2-0.2 45.3 0 49.5 1.1 12.6 3.5 21.1 8.3 31.5 17.8l5.8 5.4v-14.8c0-17.6-0.9-25.4-4.5-37-7.1-23.5-21.1-41-41.1-51.8-13-7-13.8-7.2-58.5-7.5-26.2-0.2-39.9-0.6-40.6-1.2-0.6-0.6-1.1-1.6-1.1-2.4 0-0.8-1.5-7.1-3.5-13.9-23.4-82.7-67.1-148.4-131-197.1-8.7-6.7-30-20.8-38.6-25.6-3.3-1.9-6.9-3.9-7.8-4.5-4.2-2.3-28.3-14.1-34.3-16.6-3.6-1.6-8.3-3.6-10.4-4.4-35.3-15.3-94.5-29.8-139.7-34.3-7.4-0.7-17.2-1.8-21.7-2.2-20.4-2.3-48.7-2.6-209.4-2.6-135.8 0-169.9 0.3-169.4 1zm330.7 43.3c33.8 2 54.6 4.6 78.9 10.5 74.2 17.6 126.4 54.8 164.3 117 3.5 5.8 18.3 36 20.5 42.1 10.5 28.3 15.6 45.1 20.1 67.3 1.1 5.4 2.6 12.6 3.3 16 0.7 3.3 1 6.4 0.7 6.7-0.5 0.4-100.9 0.6-223.3 0.5l-222.5-0.2-0.3-128.5c-0.1-70.6 0-129.3 0.3-130.4l0.4-1.9h71.1c39 0 78 0.4 86.5 0.9zm297.5 350.3c0.7 4.3 0.7 77.3 0 80.9l-0.6 2.7-227.5-0.2-227.4-0.3-0.2-42.4c-0.2-23.3 0-42.7 0.2-43.1 0.3-0.5 97.2-0.8 227.7-0.8h227.2zm-10.2 171.7c0.5 1.5-1.9 13.8-6.8 33.8-5.6 22.5-13.2 45.2-20.9 62-3.8 8.6-13.3 27.2-15.6 30.7-1.1 1.6-4.3 6.7-7.1 11.2-18 28.2-43.7 53.9-73 72.9-10.7 6.8-32.7 18.4-38.6 20.2-1.2 0.3-2.5 0.9-3 1.3-0.7 0.6-9.8 4-20.4 7.8-19.5 6.9-56.6 14.4-86.4 17.5-19.3 1.9-22.4 2-96.7 2h-76.9v-129.7-129.8l220.9-0.4c121.5-0.2 221.6-0.5 222.4-0.7 0.9-0.1 1.8 0.5 2.1 1.2z" />
                                            </svg>
                                        </span>
                                    <?php endif; ?>
                                    <span class="gtwelve-featured-pricing-card__amount"><?php echo esc_html( $trimmed_price ); ?></span>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if ( ! empty( $features ) ) : ?>
                            <ul class="gtwelve-featured-pricing-card__features">
                                <?php foreach ( $features as $feature ) :
                                    $text = $feature['feature_text'] ?? '';
                                    if ( ! $text ) {
                                        continue;
                                    }
                                    ?>
                                    <li class="gtwelve-featured-pricing-card__feature">
                                        <span class="gtwelve-featured-pricing-card__icon" aria-hidden="true">
                                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><path d="m9 11 3 3L22 4"></path></svg>
                                        </span>
                                        <span><?php echo esc_html( $text ); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if ( $button_text ) : ?>
                            <?php if ( $button_link ) : ?>
                                <a class="gtwelve-featured-pricing-card__button" href="<?php echo esc_url( $button_link ); ?>"<?php echo $target_attr; ?>><?php echo esc_html( $button_text ); ?></a>
                            <?php else : ?>
                                <span class="gtwelve-featured-pricing-card__button" role="button" tabindex="0"><?php echo esc_html( $button_text ); ?></span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
    }
}
