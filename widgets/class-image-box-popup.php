<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Image_Box_Popup extends Widget_Base {
	public function get_name(): string { return 'g12_image_box_popup'; }
	public function get_title(): string { return esc_html__( 'G12 Image Box with Popup', 'gtwelve-elementor' ); }
	public function get_icon(): string { return 'eicon-image-box'; }
	public function get_categories(): array { return array( 'gtwelve' ); }
	public function get_keywords(): array { return array( 'image', 'box', 'card', 'popup', 'modal', 'g12' ); }
	public function get_style_depends(): array { return array( 'gtwelve-elementor-image-box-popup' ); }
	public function get_script_depends(): array { return array( 'gtwelve-elementor-image-box-popup' ); }

	protected function register_controls(): void {
		$this->start_controls_section( 'section_cards', array( 'label' => esc_html__( 'Cards', 'gtwelve-elementor' ) ) );
		$repeater = new Repeater();
		$repeater->add_control( 'title', array( 'label' => esc_html__( 'Title', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Card title', 'gtwelve-elementor' ), 'label_block' => true ) );
		$repeater->add_control( 'image', array( 'label' => esc_html__( 'Main / Popup Image', 'gtwelve-elementor' ), 'type' => Controls_Manager::MEDIA, 'default' => array( 'url' => Utils::get_placeholder_image_src() ) ) );
		$repeater->add_control( 'icon', array( 'label' => esc_html__( 'Optional Card Icon', 'gtwelve-elementor' ), 'description' => esc_html__( 'When set, this replaces the main image on the card only.', 'gtwelve-elementor' ), 'type' => Controls_Manager::MEDIA ) );
		$repeater->add_control( 'excerpt', array( 'label' => esc_html__( 'Excerpt', 'gtwelve-elementor' ), 'type' => Controls_Manager::WYSIWYG, 'default' => esc_html__( 'Add a short card description here.', 'gtwelve-elementor' ) ) );
		$repeater->add_control( 'button_text', array( 'label' => esc_html__( 'Button Text', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Learn More', 'gtwelve-elementor' ) ) );
		$repeater->add_control( 'popup_content', array( 'label' => esc_html__( 'Popup Content', 'gtwelve-elementor' ), 'type' => Controls_Manager::WYSIWYG, 'default' => esc_html__( 'Add the full popup content here.', 'gtwelve-elementor' ) ) );
		$this->add_control( 'cards', array( 'label' => esc_html__( 'Card Items', 'gtwelve-elementor' ), 'type' => Controls_Manager::REPEATER, 'fields' => $repeater->get_controls(), 'title_field' => '{{{ title }}}', 'default' => array( array( 'title'=>'Business Setup', 'excerpt'=>'Discover a setup solution designed around your goals.', 'button_text'=>'Learn More', 'popup_content'=>'Add the complete details for this service here.' ), array( 'title'=>'Business Support', 'excerpt'=>'Get practical support as your company grows.', 'button_text'=>'Learn More', 'popup_content'=>'Add the complete details for this service here.' ), array( 'title'=>'Growth Services', 'excerpt'=>'Explore services that help your business move forward.', 'button_text'=>'Learn More', 'popup_content'=>'Add the complete details for this service here.' ) ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'section_layout', array( 'label' => esc_html__( 'Layout', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'columns', array( 'label'=>esc_html__( 'Columns', 'gtwelve-elementor' ), 'type'=>Controls_Manager::SELECT, 'default'=>'3', 'tablet_default'=>'2', 'mobile_default'=>'1', 'options'=>array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4' ), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__grid'=>'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ) ) );
		$this->add_responsive_control( 'column_gap', array( 'label'=>esc_html__( 'Column Gap', 'gtwelve-elementor' ), 'type'=>Controls_Manager::SLIDER, 'range'=>array( 'px'=>array( 'min'=>0, 'max'=>160 ) ), 'default'=>array( 'size'=>80, 'unit'=>'px' ), 'tablet_default'=>array( 'size'=>48, 'unit'=>'px' ), 'mobile_default'=>array( 'size'=>20, 'unit'=>'px' ), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__grid'=>'column-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'row_gap', array( 'label'=>esc_html__( 'Row Gap', 'gtwelve-elementor' ), 'type'=>Controls_Manager::SLIDER, 'range'=>array( 'px'=>array( 'min'=>0, 'max'=>120 ) ), 'default'=>array( 'size'=>48, 'unit'=>'px' ), 'mobile_default'=>array( 'size'=>32, 'unit'=>'px' ), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__grid'=>'row-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'section_card_style', array( 'label'=>esc_html__( 'Cards', 'gtwelve-elementor' ), 'tab'=>Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'card_background', array( 'label'=>esc_html__( 'Background', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__card'=>'background-color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Border::get_type(), array( 'name'=>'card_border', 'selector'=>'{{WRAPPER}} .g12-ibwp__card' ) );
		$this->add_responsive_control( 'card_padding', array( 'label'=>esc_html__( 'Padding', 'gtwelve-elementor' ), 'type'=>Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em','%'), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__card'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'card_radius', array( 'label'=>esc_html__( 'Border Radius', 'gtwelve-elementor' ), 'type'=>Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__card'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array( 'name'=>'card_shadow', 'selector'=>'{{WRAPPER}} .g12-ibwp__card' ) );
		$this->add_responsive_control( 'card_align', array( 'label'=>esc_html__( 'Text Alignment', 'gtwelve-elementor' ), 'type'=>Controls_Manager::CHOOSE, 'options'=>array( 'left'=>array('title'=>'Left','icon'=>'eicon-text-align-left'), 'center'=>array('title'=>'Center','icon'=>'eicon-text-align-center'), 'right'=>array('title'=>'Right','icon'=>'eicon-text-align-right') ), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__card'=>'text-align: {{VALUE}};' ) ) );
		$this->add_control( 'image_height', array( 'label'=>esc_html__( 'Image Height', 'gtwelve-elementor' ), 'type'=>Controls_Manager::SLIDER, 'range'=>array( 'px'=>array('min'=>100,'max'=>600) ), 'default'=>array('size'=>280,'unit'=>'px'), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__image img'=>'height: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_control( 'image_radius', array( 'label'=>esc_html__( 'Image Radius', 'gtwelve-elementor' ), 'type'=>Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__image img'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'card_title_color', array( 'label'=>esc_html__( 'Title Color', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__card-title'=>'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name'=>'card_title_typography', 'selector'=>'{{WRAPPER}} .g12-ibwp__card-title' ) );
		$this->add_control( 'excerpt_color', array( 'label'=>esc_html__( 'Excerpt Color', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__excerpt'=>'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name'=>'excerpt_typography', 'selector'=>'{{WRAPPER}} .g12-ibwp__excerpt' ) );
		$this->end_controls_section();

		$this->start_controls_section( 'section_button_style', array( 'label'=>esc_html__( 'Button', 'gtwelve-elementor' ), 'tab'=>Controls_Manager::TAB_STYLE ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name'=>'button_typography', 'selector'=>'{{WRAPPER}} .g12-ibwp__button' ) );
		$this->start_controls_tabs( 'button_tabs' );
		$this->start_controls_tab( 'button_normal', array( 'label'=>esc_html__( 'Normal', 'gtwelve-elementor' ) ) );
		$this->add_control( 'button_color', array( 'label'=>esc_html__( 'Text Color', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'default'=>'#ffffff', 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__button'=>'color: {{VALUE}};' ) ) );
		$this->add_control( 'button_background', array( 'label'=>esc_html__( 'Background', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'default'=>'#D6A456', 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__button'=>'background: {{VALUE}};' ) ) );
		$this->end_controls_tab();
		$this->start_controls_tab( 'button_hover', array( 'label'=>esc_html__( 'Hover', 'gtwelve-elementor' ) ) );
		$this->add_control( 'button_hover_color', array( 'label'=>esc_html__( 'Text Color', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__button:hover, {{WRAPPER}} .g12-ibwp__button:focus'=>'color: {{VALUE}};' ) ) );
		$this->add_control( 'button_hover_background', array( 'label'=>esc_html__( 'Background', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'default'=>'#AB8134', 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__button:hover, {{WRAPPER}} .g12-ibwp__button:focus'=>'background: {{VALUE}};' ) ) );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control( 'button_padding', array( 'label'=>esc_html__( 'Padding', 'gtwelve-elementor' ), 'type'=>Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'default'=>array('top'=>8,'right'=>12,'bottom'=>8,'left'=>12,'unit'=>'px','isLinked'=>false), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__button'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'button_radius', array( 'label'=>esc_html__( 'Border Radius', 'gtwelve-elementor' ), 'type'=>Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'default'=>array('top'=>8,'right'=>8,'bottom'=>8,'left'=>8,'unit'=>'px','isLinked'=>true), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__button'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'section_popup_style', array( 'label'=>esc_html__( 'Popup', 'gtwelve-elementor' ), 'tab'=>Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'overlay_color', array( 'label'=>esc_html__( 'Overlay Color', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'default'=>'rgba(0,0,0,0.70)', 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__popup'=>'background-color: {{VALUE}};' ) ) );
		$this->add_control( 'popup_background', array( 'label'=>esc_html__( 'Content Background', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'default'=>'#ffffff', 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__popup-dialog'=>'background-color: {{VALUE}};' ) ) );
		$this->add_responsive_control( 'popup_width', array( 'label'=>esc_html__( 'Maximum Width', 'gtwelve-elementor' ), 'type'=>Controls_Manager::SLIDER, 'range'=>array('px'=>array('min'=>300,'max'=>1200)), 'default'=>array('size'=>800,'unit'=>'px'), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__popup-dialog'=>'max-width: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'popup_padding', array( 'label'=>esc_html__( 'Padding', 'gtwelve-elementor' ), 'type'=>Controls_Manager::DIMENSIONS, 'size_units'=>array('px','em'), 'default'=>array('top'=>30,'right'=>30,'bottom'=>30,'left'=>30,'unit'=>'px','isLinked'=>true), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__popup-dialog'=>'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'popup_radius', array( 'label'=>esc_html__( 'Border Radius', 'gtwelve-elementor' ), 'type'=>Controls_Manager::DIMENSIONS, 'size_units'=>array('px','%'), 'default'=>array('top'=>8,'right'=>8,'bottom'=>8,'left'=>8,'unit'=>'px','isLinked'=>true), 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__popup-dialog'=>'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_control( 'popup_title_color', array( 'label'=>esc_html__( 'Title Color', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__popup-title'=>'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name'=>'popup_title_typography', 'selector'=>'{{WRAPPER}} .g12-ibwp__popup-title' ) );
		$this->add_control( 'popup_text_color', array( 'label'=>esc_html__( 'Text Color', 'gtwelve-elementor' ), 'type'=>Controls_Manager::COLOR, 'selectors'=>array( '{{WRAPPER}} .g12-ibwp__popup-text'=>'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name'=>'popup_text_typography', 'selector'=>'{{WRAPPER}} .g12-ibwp__popup-text' ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$popup_id = 'g12-ibwp-popup-' . $this->get_id();
		?>
		<section class="g12-ibwp" data-g12-ibwp>
			<div class="g12-ibwp__grid">
				<?php foreach ( $settings['cards'] as $index => $card ) :
					$image = ! empty( $card['image']['url'] ) ? $card['image'] : array();
					$visual = ! empty( $card['icon']['url'] ) ? $card['icon'] : $image;
					?>
					<article class="g12-ibwp__card elementor-repeater-item-<?php echo esc_attr( $card['_id'] ); ?>">
						<?php if ( ! empty( $visual['url'] ) ) : ?><div class="<?php echo ! empty( $card['icon']['url'] ) ? 'g12-ibwp__icon' : 'g12-ibwp__image'; ?>"><img src="<?php echo esc_url( $visual['url'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" loading="lazy"></div><?php endif; ?>
						<?php if ( $card['title'] ) : ?><h3 class="g12-ibwp__card-title"><?php echo wp_kses_post( $card['title'] ); ?></h3><?php endif; ?>
						<?php if ( $card['excerpt'] ) : ?><div class="g12-ibwp__excerpt"><?php echo wp_kses_post( $card['excerpt'] ); ?></div><?php endif; ?>
						<?php if ( $card['button_text'] ) : ?><button class="g12-ibwp__button" type="button" data-g12-ibwp-trigger="<?php echo esc_attr( $index ); ?>" aria-haspopup="dialog" aria-controls="<?php echo esc_attr( $popup_id ); ?>"><?php echo esc_html( $card['button_text'] ); ?></button><?php endif; ?>
						<script type="application/json" class="g12-ibwp__data"><?php echo wp_json_encode( array( 'title'=>$card['title'], 'image'=>! empty($image['url']) ? esc_url_raw($image['url']) : '', 'alt'=>$card['title'], 'content'=>wp_kses_post($card['popup_content']) ), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); ?></script>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="g12-ibwp__popup" id="<?php echo esc_attr( $popup_id ); ?>" hidden>
				<div class="g12-ibwp__popup-dialog" role="dialog" aria-modal="true" aria-labelledby="<?php echo esc_attr( $popup_id ); ?>-title">
					<button type="button" class="g12-ibwp__close" aria-label="<?php esc_attr_e( 'Close popup', 'gtwelve-elementor' ); ?>">&times;</button>
					<div class="g12-ibwp__popup-image" hidden><img src="" alt=""></div>
					<h3 class="g12-ibwp__popup-title" id="<?php echo esc_attr( $popup_id ); ?>-title"></h3>
					<div class="g12-ibwp__popup-text"></div>
				</div>
			</div>
		</section>
		<?php
	}
}
