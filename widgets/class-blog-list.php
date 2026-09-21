<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blog_List extends Widget_Base {
	public function get_name(): string {
		return 'g12_blog_list';
	}

	public function get_title(): string {
		return esc_html__( 'G12 Blog List', 'gtwelve-elementor' );
	}

	public function get_icon(): string {
		return 'eicon-post-list';
	}

	public function get_categories(): array {
		return array( 'gtwelve' );
	}

	public function get_keywords(): array {
		return array( 'blog', 'posts', 'articles', 'news', 'grid', 'g12' );
	}

	public function get_style_depends(): array {
		return array( 'gtwelve-elementor-blog-list' );
	}

	protected function register_controls(): void {
		$this->register_query_controls();
		$this->register_content_controls();
		$this->register_layout_controls();
		$this->register_card_controls();
		$this->register_image_controls();
		$this->register_text_controls();
		$this->register_pagination_controls();
	}

	private function register_query_controls(): void {
		$this->start_controls_section(
			'query_section',
			array(
				'label' => esc_html__( 'Query', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label'   => esc_html__( 'Posts Per Page', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 24,
				'step'    => 1,
				'default' => 6,
			)
		);

		$this->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Categories', 'gtwelve-elementor' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => $this->get_category_options(),
				'multiple'    => true,
				'label_block' => true,
				'description' => esc_html__( 'Leave empty to display posts from every category.', 'gtwelve-elementor' ),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order By', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => array(
					'date'     => esc_html__( 'Date', 'gtwelve-elementor' ),
					'modified' => esc_html__( 'Last Modified', 'gtwelve-elementor' ),
					'title'    => esc_html__( 'Title', 'gtwelve-elementor' ),
					'rand'     => esc_html__( 'Random', 'gtwelve-elementor' ),
				),
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order', 'gtwelve-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => array(
					'DESC' => esc_html__( 'Descending', 'gtwelve-elementor' ),
					'ASC'  => esc_html__( 'Ascending', 'gtwelve-elementor' ),
				),
			)
		);

		$this->end_controls_section();
	}

	private function register_content_controls(): void {
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Card Content', 'gtwelve-elementor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control( 'show_image', array( 'label' => esc_html__( 'Featured Image', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'gtwelve-elementor' ), 'label_off' => esc_html__( 'Hide', 'gtwelve-elementor' ), 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'thumbnail_size', array( 'label' => esc_html__( 'Image Size', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'medium_large', 'options' => array( 'thumbnail' => esc_html__( 'Thumbnail', 'gtwelve-elementor' ), 'medium' => esc_html__( 'Medium', 'gtwelve-elementor' ), 'medium_large' => esc_html__( 'Medium Large', 'gtwelve-elementor' ), 'large' => esc_html__( 'Large', 'gtwelve-elementor' ), 'full' => esc_html__( 'Full', 'gtwelve-elementor' ) ), 'condition' => array( 'show_image' => 'yes' ) ) );
		$this->add_control( 'title_tag', array( 'label' => esc_html__( 'Title HTML Tag', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'h3', 'options' => array( 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6' ) ) );
		$this->add_control( 'show_excerpt', array( 'label' => esc_html__( 'Excerpt', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'gtwelve-elementor' ), 'label_off' => esc_html__( 'Hide', 'gtwelve-elementor' ), 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'excerpt_length', array( 'label' => esc_html__( 'Excerpt Words', 'gtwelve-elementor' ), 'type' => Controls_Manager::NUMBER, 'min' => 5, 'max' => 80, 'step' => 1, 'default' => 20, 'condition' => array( 'show_excerpt' => 'yes' ) ) );
		$this->add_control( 'show_date', array( 'label' => esc_html__( 'Post Date', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'gtwelve-elementor' ), 'label_off' => esc_html__( 'Hide', 'gtwelve-elementor' ), 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'date_format', array( 'label' => esc_html__( 'Date Format', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => 'F j, Y', 'description' => esc_html__( 'Uses the standard WordPress date format.', 'gtwelve-elementor' ), 'condition' => array( 'show_date' => 'yes' ) ) );
		$this->add_control( 'read_more_text', array( 'label' => esc_html__( 'Read More Text', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'Read More »', 'gtwelve-elementor' ), 'label_block' => true ) );
		$this->add_control( 'show_pagination', array( 'label' => esc_html__( 'Pagination', 'gtwelve-elementor' ), 'type' => Controls_Manager::SWITCHER, 'label_on' => esc_html__( 'Show', 'gtwelve-elementor' ), 'label_off' => esc_html__( 'Hide', 'gtwelve-elementor' ), 'return_value' => 'yes', 'default' => 'yes' ) );
		$this->add_control( 'no_posts_message', array( 'label' => esc_html__( 'No Posts Message', 'gtwelve-elementor' ), 'type' => Controls_Manager::TEXT, 'default' => esc_html__( 'No posts found.', 'gtwelve-elementor' ), 'label_block' => true ) );

		$this->end_controls_section();
	}

	private function register_layout_controls(): void {
		$this->start_controls_section( 'layout_style', array( 'label' => esc_html__( 'Layout', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_responsive_control( 'column_gap', array( 'label' => esc_html__( 'Column Gap', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 30, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__grid' => 'column-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->add_responsive_control( 'row_gap', array( 'label' => esc_html__( 'Row Gap', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 100 ) ), 'default' => array( 'size' => 35, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__grid' => 'row-gap: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_card_controls(): void {
		$this->start_controls_section( 'card_style', array( 'label' => esc_html__( 'Cards', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'card_background', array( 'label' => esc_html__( 'Background', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ffffff', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__card' => 'background-color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Border::get_type(), array( 'name' => 'card_border', 'selector' => '{{WRAPPER}} .g12-blog-list__card' ) );
		$this->add_responsive_control( 'card_radius', array( 'label' => esc_html__( 'Border Radius', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', '%' ), 'default' => array( 'top' => 3, 'right' => 3, 'bottom' => 3, 'left' => 3, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->add_group_control( Group_Control_Box_Shadow::get_type(), array( 'name' => 'card_shadow', 'selector' => '{{WRAPPER}} .g12-blog-list__card' ) );
		$this->add_responsive_control( 'content_padding', array( 'label' => esc_html__( 'Content Padding', 'gtwelve-elementor' ), 'type' => Controls_Manager::DIMENSIONS, 'size_units' => array( 'px', 'em' ), 'default' => array( 'top' => 30, 'right' => 30, 'bottom' => 30, 'left' => 30, 'unit' => 'px', 'isLinked' => true ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	private function register_image_controls(): void {
		$this->start_controls_section( 'image_style', array( 'label' => esc_html__( 'Featured Image', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => array( 'show_image' => 'yes' ) ) );
		$this->add_responsive_control( 'image_height', array( 'label' => esc_html__( 'Height', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 120, 'max' => 600 ) ), 'default' => array( 'size' => 250, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__media' => 'height: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}}; flex-basis: {{SIZE}}{{UNIT}};', '{{WRAPPER}} .g12-blog-list__image' => 'height: 100%; min-height: 100%;' ) ) );
		$this->add_control( 'image_position', array( 'label' => esc_html__( 'Object Position', 'gtwelve-elementor' ), 'type' => Controls_Manager::SELECT, 'default' => 'center center', 'options' => array( 'center center' => esc_html__( 'Center', 'gtwelve-elementor' ), 'center top' => esc_html__( 'Top', 'gtwelve-elementor' ), 'center bottom' => esc_html__( 'Bottom', 'gtwelve-elementor' ), 'left center' => esc_html__( 'Left', 'gtwelve-elementor' ), 'right center' => esc_html__( 'Right', 'gtwelve-elementor' ) ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__image' => 'object-position: {{VALUE}};' ) ) );
		$this->end_controls_section();
	}

	private function register_text_controls(): void {
		$this->start_controls_section( 'title_style', array( 'label' => esc_html__( 'Title', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'title_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ab8134', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__title a' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'title_hover_color', array( 'label' => esc_html__( 'Hover Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#d6a557', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__title a:hover, {{WRAPPER}} .g12-blog-list__title a:focus-visible' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'title_typography', 'selector' => '{{WRAPPER}} .g12-blog-list__title', 'fields_options' => array( 'typography' => array( 'default' => 'custom' ), 'font_size' => array( 'default' => array( 'size' => 21, 'unit' => 'px' ) ), 'font_weight' => array( 'default' => '600' ), 'line_height' => array( 'default' => array( 'size' => 1, 'unit' => 'em' ) ) ) ) );
		$this->add_responsive_control( 'title_spacing', array( 'label' => esc_html__( 'Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 25, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'excerpt_style', array( 'label' => esc_html__( 'Excerpt', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => array( 'show_excerpt' => 'yes' ) ) );
		$this->add_control( 'excerpt_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#777777', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__excerpt' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'excerpt_typography', 'selector' => '{{WRAPPER}} .g12-blog-list__excerpt', 'fields_options' => array( 'typography' => array( 'default' => 'custom' ), 'font_size' => array( 'default' => array( 'size' => 14, 'unit' => 'px' ) ), 'line_height' => array( 'default' => array( 'size' => 1.5, 'unit' => 'em' ) ) ) ) );
		$this->add_responsive_control( 'excerpt_spacing', array( 'label' => esc_html__( 'Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 60 ) ), 'default' => array( 'size' => 24, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'read_more_style', array( 'label' => esc_html__( 'Read More', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE ) );
		$this->add_control( 'read_more_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#d6a456', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__read-more' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'read_more_hover_color', array( 'label' => esc_html__( 'Hover Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#ab8134', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__read-more:hover, {{WRAPPER}} .g12-blog-list__read-more:focus-visible' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'read_more_typography', 'selector' => '{{WRAPPER}} .g12-blog-list__read-more', 'fields_options' => array( 'typography' => array( 'default' => 'custom' ), 'font_size' => array( 'default' => array( 'size' => 12, 'unit' => 'px' ) ), 'font_weight' => array( 'default' => '500' ), 'text_transform' => array( 'default' => 'uppercase' ) ) ) );
		$this->add_responsive_control( 'read_more_spacing', array( 'label' => esc_html__( 'Bottom Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 50 ) ), 'default' => array( 'size' => 20, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__read-more' => 'margin-bottom: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();

		$this->start_controls_section( 'date_style', array( 'label' => esc_html__( 'Date', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => array( 'show_date' => 'yes' ) ) );
		$this->add_control( 'date_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#adadad', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__date' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'date_typography', 'selector' => '{{WRAPPER}} .g12-blog-list__date', 'fields_options' => array( 'typography' => array( 'default' => 'custom' ), 'font_size' => array( 'default' => array( 'size' => 12, 'unit' => 'px' ) ), 'line_height' => array( 'default' => array( 'size' => 1.3, 'unit' => 'em' ) ) ) ) );
		$this->end_controls_section();
	}

	private function register_pagination_controls(): void {
		$this->start_controls_section( 'pagination_style', array( 'label' => esc_html__( 'Pagination', 'gtwelve-elementor' ), 'tab' => Controls_Manager::TAB_STYLE, 'condition' => array( 'show_pagination' => 'yes' ) ) );
		$this->add_control( 'pagination_color', array( 'label' => esc_html__( 'Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#777777', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__pagination .page-numbers' => 'color: {{VALUE}};' ) ) );
		$this->add_control( 'pagination_active_color', array( 'label' => esc_html__( 'Active and Hover Color', 'gtwelve-elementor' ), 'type' => Controls_Manager::COLOR, 'default' => '#d6a557', 'selectors' => array( '{{WRAPPER}} .g12-blog-list__pagination .page-numbers.current, {{WRAPPER}} .g12-blog-list__pagination a.page-numbers:hover, {{WRAPPER}} .g12-blog-list__pagination a.page-numbers:focus-visible' => 'color: {{VALUE}};' ) ) );
		$this->add_group_control( Group_Control_Typography::get_type(), array( 'name' => 'pagination_typography', 'selector' => '{{WRAPPER}} .g12-blog-list__pagination .page-numbers' ) );
		$this->add_responsive_control( 'pagination_top_spacing', array( 'label' => esc_html__( 'Top Spacing', 'gtwelve-elementor' ), 'type' => Controls_Manager::SLIDER, 'range' => array( 'px' => array( 'min' => 0, 'max' => 120 ) ), 'default' => array( 'size' => 35, 'unit' => 'px' ), 'selectors' => array( '{{WRAPPER}} .g12-blog-list__pagination' => 'margin-top: {{SIZE}}{{UNIT}};' ) ) );
		$this->end_controls_section();
	}

	protected function render(): void {
		$settings     = $this->get_settings_for_display();
		$current_page = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );
		$query_args   = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => max( 1, absint( $settings['posts_per_page'] ?? 6 ) ),
			'paged'               => $current_page,
			'orderby'             => sanitize_key( $settings['orderby'] ?? 'date' ),
			'order'               => 'ASC' === ( $settings['order'] ?? 'DESC' ) ? 'ASC' : 'DESC',
			'ignore_sticky_posts' => true,
		);

		if ( ! empty( $settings['categories'] ) && is_array( $settings['categories'] ) ) {
			$query_args['category__in'] = array_map( 'absint', $settings['categories'] );
		}

		$query = new \WP_Query( $query_args );

		if ( ! $query->have_posts() ) {
			echo '<p class="g12-blog-list__empty">' . esc_html( $settings['no_posts_message'] ?? esc_html__( 'No posts found.', 'gtwelve-elementor' ) ) . '</p>';
			return;
		}

		$title_tag     = in_array( $settings['title_tag'] ?? 'h3', array( 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ? $settings['title_tag'] : 'h3';
		$thumbnail_size = sanitize_key( $settings['thumbnail_size'] ?? 'medium_large' );
		?>
		<div class="g12-blog-list">
			<div class="g12-blog-list__grid">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<article <?php post_class( 'g12-blog-list__card' ); ?>>
						<?php if ( 'yes' === ( $settings['show_image'] ?? 'yes' ) && has_post_thumbnail() ) : ?>
							<a class="g12-blog-list__media" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: post title */ __( 'Read %s', 'gtwelve-elementor' ), get_the_title() ) ); ?>">
								<?php echo get_the_post_thumbnail( get_the_ID(), $thumbnail_size, array( 'class' => 'g12-blog-list__image', 'loading' => 'lazy' ) ); ?>
							</a>
						<?php endif; ?>

						<div class="g12-blog-list__content">
							<<?php echo esc_html( $title_tag ); ?> class="g12-blog-list__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></<?php echo esc_html( $title_tag ); ?>>

							<?php if ( 'yes' === ( $settings['show_excerpt'] ?? 'yes' ) ) : ?>
								<p class="g12-blog-list__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), max( 1, absint( $settings['excerpt_length'] ?? 20 ) ), '…' ) ); ?></p>
							<?php endif; ?>

							<div class="g12-blog-list__footer">
								<?php if ( ! empty( $settings['read_more_text'] ) ) : ?><a class="g12-blog-list__read-more" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: post title */ __( 'Read more about %s', 'gtwelve-elementor' ), get_the_title() ) ); ?>"><?php echo esc_html( $settings['read_more_text'] ); ?></a><?php endif; ?>
								<?php if ( 'yes' === ( $settings['show_date'] ?? 'yes' ) ) : ?><time class="g12-blog-list__date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date( $settings['date_format'] ?? 'F j, Y' ) ); ?></time><?php endif; ?>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php $this->render_pagination( $query, $current_page, $settings ); ?>
		</div>
		<?php
		wp_reset_postdata();
	}

	private function render_pagination( \WP_Query $query, int $current_page, array $settings ): void {
		if ( 'yes' !== ( $settings['show_pagination'] ?? 'yes' ) || $query->max_num_pages < 2 ) {
			return;
		}

		$big   = 999999999;
		$links = paginate_links(
			array(
				'base'      => str_replace( (string) $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'    => '?paged=%#%',
				'current'   => $current_page,
				'total'     => $query->max_num_pages,
				'mid_size'  => 2,
				'prev_text' => esc_html__( '« Previous', 'gtwelve-elementor' ),
				'next_text' => esc_html__( 'Next »', 'gtwelve-elementor' ),
				'type'      => 'array',
			)
		);

		if ( empty( $links ) ) {
			return;
		}

		echo '<nav class="g12-blog-list__pagination" aria-label="' . esc_attr__( 'Blog pagination', 'gtwelve-elementor' ) . '">' . wp_kses_post( implode( '', $links ) ) . '</nav>';
	}

	private function get_category_options(): array {
		$options    = array();
		$categories = get_categories( array( 'hide_empty' => false ) );

		foreach ( $categories as $category ) {
			$options[ (string) $category->term_id ] = $category->name;
		}

		return $options;
	}
}
