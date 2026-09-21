<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class Team_Feature_Strip extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_team_feature_strip';
	}

	public function get_title(): string
	{
		return esc_html__('G12 Team Feature Strip', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-person';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('team', 'features', 'people', 'columns', 'g12');
	}

	public function get_style_depends(): array
	{
		return array('gtwelve-elementor-widgets');
	}

	public function get_script_depends(): array
	{
		return array('gtwelve-elementor-widgets');
	}

	protected function register_controls(): void
	{
		$this->register_content_controls();
		$this->register_style_controls();
	}

	private function register_content_controls(): void
	{
		$this->start_controls_section(
			'section_items',
			array(
				'label' => esc_html__('Items', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			array(
				'label'   => esc_html__('Person Image', 'gtwelve-elementor'),
				'type'    => Controls_Manager::MEDIA,
				'default' => array('url' => Utils::get_placeholder_image_src()),
			)
		);

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__('Title', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Complete End-to-End Solutions', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'description',
			array(
				'label'       => esc_html__('Description', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => esc_html__('We provide tailored company registration services for businesses of all sizes.', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'items',
			array(
				'label'       => esc_html__('Feature Items', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'default'     => $this->get_default_items(),
			)
		);

		$this->end_controls_section();
	}

	private function register_style_controls(): void
	{
		$this->start_controls_section(
			'section_layout_style',
			array(
				'label' => esc_html__('Layout', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'     => esc_html__('Columns', 'gtwelve-elementor'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '4',
				'options'   => array(
					'2' => esc_html__('2', 'gtwelve-elementor'),
					'3' => esc_html__('3', 'gtwelve-elementor'),
					'4' => esc_html__('4', 'gtwelve-elementor'),
				),
				'selectors' => array(
					'{{WRAPPER}} .team-feature-strip__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				),
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'      => esc_html__('Column Gap', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 80)),
				'default'    => array('size' => 40, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .team-feature-strip' => '--team-feature-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'strip_height',
			array(
				'label'      => esc_html__('Gold Strip Height', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 60, 'max' => 220)),
				'default'    => array('size' => 144, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .team-feature-strip' => '--team-feature-strip-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => esc_html__('Image Height', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 100, 'max' => 300)),
				'default'    => array('size' => 180, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .team-feature-strip' => '--team-feature-image-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'strip_color',
			array(
				'label'     => esc_html__('Gold Strip Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d7a653',
				'selectors' => array(
					'{{WRAPPER}} .team-feature-strip' => '--team-feature-strip-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'image_grayscale',
			array(
				'label'        => esc_html__('Grayscale Images', 'gtwelve-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'gtwelve-elementor'),
				'label_off'    => esc_html__('No', 'gtwelve-elementor'),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors'    => array(
					'{{WRAPPER}} .team-feature-strip' => '--team-feature-image-filter: grayscale(1);',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_text_style',
			array(
				'label' => esc_html__('Text', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__('Title Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .team-feature-strip__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .team-feature-strip__title',
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__('Description Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0f2438',
				'selectors' => array(
					'{{WRAPPER}} .team-feature-strip__description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .team-feature-strip__description',
			)
		);

		$this->add_control(
			'accent_color',
			array(
				'label'     => esc_html__('Bottom Accent Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#d7a653',
				'selectors' => array(
					'{{WRAPPER}} .team-feature-strip' => '--team-feature-accent: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$items = $this->get_settings_for_display('items');

		if (empty($items) || ! is_array($items)) {
			return;
		}
		?>
		<div class="team-feature-strip" data-team-feature-strip>
			<div class="team-feature-strip__desktop">
				<div class="team-feature-strip__media" aria-hidden="true">
					<div class="team-feature-strip__gold"></div>
					<div class="team-feature-strip__image-grid">
						<?php foreach ($items as $item) : ?>
							<?php
							$image_url = $item['image']['url'] ?? '';
							$image_alt = $item['image']['alt'] ?? ($item['title'] ?? '');
							?>
							<div class="team-feature-strip__image-cell">
								<?php if ($image_url) : ?>
									<img class="team-feature-strip__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="team-feature-strip__grid">
					<?php foreach ($items as $item) : ?>
						<div class="team-feature-strip__item">
							<?php if (! empty($item['title'])) : ?>
								<h3 class="team-feature-strip__title"><?php echo esc_html($item['title']); ?></h3>
							<?php endif; ?>
							<?php if (! empty($item['description'])) : ?>
								<p class="team-feature-strip__description"><?php echo esc_html($item['description']); ?></p>
							<?php endif; ?>
							<span class="team-feature-strip__accent" aria-hidden="true"></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="team-feature-strip__mobile" data-team-feature-mobile>
				<div class="team-feature-strip__mobile-viewport" data-team-feature-viewport>
					<div class="team-feature-strip__mobile-track">
						<?php foreach ($items as $index => $item) : ?>
							<?php
							$image_url = $item['image']['url'] ?? '';
							$image_alt = $item['image']['alt'] ?? ($item['title'] ?? '');
							?>
							<div class="team-feature-strip__mobile-slide" data-team-feature-slide="<?php echo esc_attr((string) $index); ?>">
								<div class="team-feature-strip__mobile-media">
									<div class="team-feature-strip__gold"></div>
									<div class="team-feature-strip__image-cell">
										<?php if ($image_url) : ?>
											<img class="team-feature-strip__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
										<?php endif; ?>
									</div>
								</div>
								<div class="team-feature-strip__item">
									<?php if (! empty($item['title'])) : ?>
										<h3 class="team-feature-strip__title"><?php echo esc_html($item['title']); ?></h3>
									<?php endif; ?>
									<?php if (! empty($item['description'])) : ?>
										<p class="team-feature-strip__description"><?php echo esc_html($item['description']); ?></p>
									<?php endif; ?>
									<span class="team-feature-strip__accent" aria-hidden="true"></span>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if (count($items) > 1) : ?>
					<div class="team-feature-strip__nav">
						<button class="team-feature-strip__nav-btn" type="button" data-team-feature-prev><?php echo esc_html__('Prev', 'gtwelve-elementor'); ?></button>
						<button class="team-feature-strip__nav-btn" type="button" data-team-feature-next><?php echo esc_html__('Next', 'gtwelve-elementor'); ?></button>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	private function get_default_items(): array
	{
		return array(
			array(
				'title'       => esc_html__('Complete End-to-End Solutions', 'gtwelve-elementor'),
				'description' => esc_html__('We provide tailored company registration services for businesses of all sizes. G12 is your one-stop shop for business setup in Dubai, getting your corporate bank account, residency visas and much more.', 'gtwelve-elementor'),
			),
			array(
				'title'       => esc_html__('Top-Quality Service', 'gtwelve-elementor'),
				'description' => esc_html__('We spent years building customized solutions which empower our clients business dreams. Rest assured, G12 business setup consultants in Dubai will remove all the paperwork and hassle to provide you with quick and professional solutions.', 'gtwelve-elementor'),
			),
			array(
				'title'       => esc_html__('Expert Team You Can Trust', 'gtwelve-elementor'),
				'description' => esc_html__('With over 15 years of experience and long-standing relationships with the relevant government authorities, our experienced professionals are continuously staying informed about new laws and regulations.', 'gtwelve-elementor'),
			),
			array(
				'title'       => esc_html__('Hassle-Free Process', 'gtwelve-elementor'),
				'description' => esc_html__('Your dedicated Account Manager is there to answer all your questions regarding Business Setup in Dubai or Business Setup in UAE. We help you choose the correct business structure from the beginning.', 'gtwelve-elementor'),
			),
		);
	}
}
