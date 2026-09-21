<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class License_Table extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_license_table';
	}

	public function get_title(): string
	{
		return esc_html__('License Table', 'gtwelve-elementor');
	}

	public function get_icon(): string
	{
		return 'eicon-table';
	}

	public function get_categories(): array
	{
		return array('gtwelve');
	}

	public function get_keywords(): array
	{
		return array('table', 'license', 'comparison', 'business');
	}

	public function get_style_depends(): array
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
			'section_table_content',
			array(
				'label' => esc_html__('Table', 'gtwelve-elementor'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'caption',
			array(
				'label'       => esc_html__('Caption', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'label_block' => true,
			)
		);

		$this->add_control(
			'show_caption',
			array(
				'label'        => esc_html__('Show Caption', 'gtwelve-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'gtwelve-elementor'),
				'label_off'    => esc_html__('No', 'gtwelve-elementor'),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => array(
					'caption!' => '',
				),
			)
		);

		$this->add_control(
			'license_heading',
			array(
				'label'       => esc_html__('License Heading', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('License Type', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'purpose_heading',
			array(
				'label'       => esc_html__('Purpose Heading', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Purpose', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$this->add_control(
			'activities_heading',
			array(
				'label'       => esc_html__('Activities Heading', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Example Activities', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'license_type',
			array(
				'label'       => esc_html__('License Type', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Commercial License', 'gtwelve-elementor'),
				'rows'        => 2,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'purpose',
			array(
				'label'       => esc_html__('Purpose', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Buying/selling goods, trading, distribution', 'gtwelve-elementor'),
				'rows'        => 3,
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'activities',
			array(
				'label'       => esc_html__('Example Activities', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Logistics, E-commerce, General Trading, Import & Export', 'gtwelve-elementor'),
				'rows'        => 3,
				'label_block' => true,
			)
		);

		$this->add_control(
			'rows',
			array(
				'label'       => esc_html__('Rows', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ license_type }}}',
				'default'     => $this->get_default_rows(),
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
			'table_width',
			array(
				'label'      => esc_html__('Table Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px', '%'),
				'range'      => array(
					'px' => array('min' => 320, 'max' => 1400),
					'%'  => array('min' => 10, 'max' => 100),
				),
				'default'    => array('size' => 100, 'unit' => '%'),
				'selectors'  => array(
					'{{WRAPPER}} .license-table__table' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'table_background',
			array(
				'label'     => esc_html__('Background', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .license-table__table' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_color',
			array(
				'label'     => esc_html__('Border Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => array(
					'{{WRAPPER}} .license-table__table, {{WRAPPER}} .license-table__table th, {{WRAPPER}} .license-table__table td' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_width',
			array(
				'label'      => esc_html__('Border Width', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 0, 'max' => 8)),
				'default'    => array('size' => 1, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .license-table__table, {{WRAPPER}} .license-table__table th, {{WRAPPER}} .license-table__table td' => 'border-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cell_padding',
			array(
				'label'      => esc_html__('Cell Padding', 'gtwelve-elementor'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array('px', 'em'),
				'default'    => array(
					'top'      => '14',
					'right'    => '20',
					'bottom'   => '14',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				),
				'selectors'  => array(
					'{{WRAPPER}} .license-table__table th, {{WRAPPER}} .license-table__table td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'row_min_height',
			array(
				'label'      => esc_html__('Row Min Height', 'gtwelve-elementor'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'range'      => array('px' => array('min' => 40, 'max' => 180)),
				'default'    => array('size' => 76, 'unit' => 'px'),
				'selectors'  => array(
					'{{WRAPPER}} .license-table__table tbody th, {{WRAPPER}} .license-table__table tbody td' => 'height: {{SIZE}}{{UNIT}};',
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
			'text_color',
			array(
				'label'     => esc_html__('Text Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#111111',
				'selectors' => array(
					'{{WRAPPER}} .license-table__table' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'cell_typography',
				'label'    => esc_html__('Cell Typography', 'gtwelve-elementor'),
				'selector' => '{{WRAPPER}} .license-table__table td',
			)
		);

		$this->add_control(
			'heading_color',
			array(
				'label'     => esc_html__('Heading Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .license-table__table thead th' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'heading_typography',
				'label'    => esc_html__('Heading Typography', 'gtwelve-elementor'),
				'selector' => '{{WRAPPER}} .license-table__table thead th',
			)
		);

		$this->add_control(
			'license_color',
			array(
				'label'     => esc_html__('License Type Color', 'gtwelve-elementor'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .license-table__row-heading' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'license_typography',
				'label'    => esc_html__('License Type Typography', 'gtwelve-elementor'),
				'selector' => '{{WRAPPER}} .license-table__row-heading',
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings = $this->get_settings_for_display();
		$rows     = $settings['rows'] ?? array();

		if (empty($rows)) {
			return;
		}

		$caption      = $settings['caption'] ?? '';
		$caption_text = wp_strip_all_tags($caption);
		$show_caption = 'yes' === ($settings['show_caption'] ?? '');
		?>
		<div class="license-table">
			<div class="license-table__scroll">
				<table class="license-table__table">
					<?php if ($caption_text) : ?>
						<caption class="<?php echo $show_caption ? 'license-table__caption' : 'license-table__caption license-table__caption--screen-reader'; ?>">
							<?php echo esc_html($caption_text); ?>
						</caption>
					<?php endif; ?>
					<thead>
						<tr>
							<th scope="col"><?php echo esc_html($settings['license_heading'] ?? ''); ?></th>
							<th scope="col"><?php echo esc_html($settings['purpose_heading'] ?? ''); ?></th>
							<th scope="col"><?php echo esc_html($settings['activities_heading'] ?? ''); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($rows as $row) : ?>
							<tr>
								<th class="license-table__row-heading" scope="row"><?php echo $this->format_cell_text($row['license_type'] ?? ''); ?></th>
								<td><?php echo $this->format_cell_text($row['purpose'] ?? ''); ?></td>
								<td><?php echo $this->format_cell_text($row['activities'] ?? ''); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php
	}

	private function format_cell_text(string $text): string
	{
		return nl2br(esc_html($text));
	}

	private function get_default_rows(): array
	{
		return array(
			array(
				'license_type' => esc_html__("Commercial\nLicense", 'gtwelve-elementor'),
				'purpose'      => esc_html__("Buying/selling goods,\ntrading, distribution", 'gtwelve-elementor'),
				'activities'   => esc_html__("Logistics, E-commerce, General Trading,\nImport & Export", 'gtwelve-elementor'),
			),
			array(
				'license_type' => esc_html__("Industrial\nLicense", 'gtwelve-elementor'),
				'purpose'      => esc_html__("Manufacturing or industrial\nactivities", 'gtwelve-elementor'),
				'activities'   => esc_html__("Packaging, Processing, Assembling,\nManufacturing", 'gtwelve-elementor'),
			),
			array(
				'license_type' => esc_html__("Professional\nLicense", 'gtwelve-elementor'),
				'purpose'      => esc_html__("Service-based or\nconsultancy businesses", 'gtwelve-elementor'),
				'activities'   => esc_html__("Construction, Repair, Security, Financial,\nTechnical, Consultancy, Tourism, Accounting", 'gtwelve-elementor'),
			),
			array(
				'license_type' => esc_html__("Freelance\nLicense", 'gtwelve-elementor'),
				'purpose'      => esc_html__("Solo professionals,\ncreative/digital services", 'gtwelve-elementor'),
				'activities'   => esc_html__("Photography, Digital Marketing, Graphic\nDesigning, Consultancy Services", 'gtwelve-elementor'),
			),
		);
	}
}
