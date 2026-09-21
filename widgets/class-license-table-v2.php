<?php

namespace GTwelveElementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if (! defined('ABSPATH')) {
	exit;
}

class License_Table_V2 extends Widget_Base
{
	public function get_name(): string
	{
		return 'g12_license_table_v2';
	}

	public function get_title(): string
	{
		return esc_html__('License Table v2', 'gtwelve-elementor');
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
		return array('table', 'license', 'comparison', 'business', 'columns');
	}

	public function get_style_depends(): array
	{
		return array('gtwelve-elementor-widgets');
	}

	protected function register_controls(): void
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
				'condition'    => array('caption!' => ''),
			)
		);

		$column_repeater = new Repeater();
		$column_repeater->add_control(
			'heading',
			array(
				'label'       => esc_html__('Table Heading', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Column Heading', 'gtwelve-elementor'),
				'label_block' => true,
			)
		);

		$column_repeater->add_control(
			'bold',
			array(
				'label'        => esc_html__('Bold Column', 'gtwelve-elementor'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'gtwelve-elementor'),
				'label_off'    => esc_html__('No', 'gtwelve-elementor'),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'       => esc_html__('Table Headings', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $column_repeater->get_controls(),
				'title_field' => '{{{ heading }}}',
				'default'     => $this->get_default_columns(),
				'description' => esc_html__('Add or remove headings. Row cells follow this same order.', 'gtwelve-elementor'),
			)
		);

		$cell_repeater = new Repeater();
		$cell_repeater->add_control(
			'value',
			array(
				'label'       => esc_html__('Cell Value', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__('Cell value', 'gtwelve-elementor'),
				'rows'        => 3,
				'label_block' => true,
				'description' => esc_html__('Bold text is supported with <b>...</b>.', 'gtwelve-elementor'),
			)
		);

		$row_repeater = new Repeater();
		$row_repeater->add_control(
			'row_label',
			array(
				'label'       => esc_html__('Row Label', 'gtwelve-elementor'),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__('Table Row', 'gtwelve-elementor'),
				'label_block' => true,
				'description' => esc_html__('Short label used to identify this row in the editor.', 'gtwelve-elementor'),
			)
		);

		$row_repeater->add_control(
			'cell_values',
			array(
				'label'       => esc_html__('Row Cells', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $cell_repeater->get_controls(),
				'title_field' => '{{{ value }}}',
				'default'     => $this->get_default_cell_values(),
				'description' => esc_html__('Add one cell item for each table column, in the same order as the headings.', 'gtwelve-elementor'),
			)
		);

		$this->add_control(
			'rows',
			array(
				'label'       => esc_html__('Rows', 'gtwelve-elementor'),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $row_repeater->get_controls(),
				'title_field' => '{{{ row_label }}}',
				'default'     => $this->get_default_rows(),
				'description' => esc_html__('Give each row a short label, then add one cell item for each heading.', 'gtwelve-elementor'),
			)
		);

		$this->end_controls_section();
	}

	protected function render(): void
	{
		$settings = $this->get_settings_for_display();
		$columns  = $settings['columns'] ?? array();
		$rows     = $settings['rows'] ?? array();

		if (empty($columns) || empty($rows)) {
			return;
		}

		$caption_text = wp_strip_all_tags($settings['caption'] ?? '');
		$show_caption = 'yes' === ($settings['show_caption'] ?? '');
		?>
		<div class="license-table license-table--v2">
			<div class="license-table__scroll">
				<table class="license-table__table">
					<?php if ($caption_text) : ?>
						<caption class="<?php echo $show_caption ? 'license-table__caption' : 'license-table__caption license-table__caption--screen-reader'; ?>">
							<?php echo esc_html($caption_text); ?>
						</caption>
					<?php endif; ?>
					<thead>
						<tr>
							<?php foreach ($columns as $column) : ?>
								<th class="<?php echo 'yes' === ($column['bold'] ?? '') ? 'license-table__column--bold' : ''; ?>" scope="col">
									<?php echo esc_html($column['heading'] ?? ''); ?>
								</th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($rows as $row) : ?>
							<?php
							$cells = array();
							if (! empty($row['cell_values']) && is_array($row['cell_values'])) {
								foreach ($row['cell_values'] as $cell_value) {
									$cells[] = (string) ($cell_value['value'] ?? '');
								}
							} else {
								$cells = preg_split('/\R/', (string) ($row['legacy_cells'] ?? $row['cells'] ?? ''));
							}
							?>
							<tr>
								<?php foreach ($columns as $index => $column) : ?>
									<?php $cell = $cells[$index] ?? ''; ?>
									<?php $cell_class = 'yes' === ($column['bold'] ?? '') ? 'license-table__column--bold' : ''; ?>
									<?php if (0 === $index) : ?>
										<th class="license-table__row-heading <?php echo esc_attr($cell_class); ?>" scope="row"><?php echo $this->format_cell_text($cell); ?></th>
									<?php else : ?>
										<td class="<?php echo esc_attr($cell_class); ?>"><?php echo $this->format_cell_text($cell); ?></td>
									<?php endif; ?>
								<?php endforeach; ?>
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
		$allowed_html = array(
			'b'      => array(),
			'strong' => array(),
		);

		return nl2br(wp_kses($text, $allowed_html));
	}

	private function get_default_columns(): array
	{
		return array(
			array('heading' => esc_html__('License Type', 'gtwelve-elementor')),
			array('heading' => esc_html__('Purpose', 'gtwelve-elementor')),
			array('heading' => esc_html__('Example Activities', 'gtwelve-elementor')),
		);
	}

	private function get_default_rows(): array
	{
		return array(
			array(
				'row_label' => esc_html__('Commercial License', 'gtwelve-elementor'),
				'cell_values' => $this->get_default_cell_values(
					esc_html__('Commercial License', 'gtwelve-elementor'),
					esc_html__('Buying/selling goods, trading, distribution', 'gtwelve-elementor'),
					esc_html__('Logistics, E-commerce, General Trading, Import & Export', 'gtwelve-elementor')
				),
			),
			array(
				'row_label' => esc_html__('Industrial License', 'gtwelve-elementor'),
				'cell_values' => $this->get_default_cell_values(
					esc_html__('Industrial License', 'gtwelve-elementor'),
					esc_html__('Manufacturing or industrial activities', 'gtwelve-elementor'),
					esc_html__('Packaging, Processing, Assembling, Manufacturing', 'gtwelve-elementor')
				),
			),
			array(
				'row_label' => esc_html__('Professional License', 'gtwelve-elementor'),
				'cell_values' => $this->get_default_cell_values(
					esc_html__('Professional License', 'gtwelve-elementor'),
					esc_html__('Service-based or consultancy businesses', 'gtwelve-elementor'),
					esc_html__('Construction, Repair, Security, Financial, Technical, Consultancy, Tourism, Accounting', 'gtwelve-elementor')
				),
			),
			array(
				'row_label' => esc_html__('Freelance License', 'gtwelve-elementor'),
				'cell_values' => $this->get_default_cell_values(
					esc_html__('Freelance License', 'gtwelve-elementor'),
					esc_html__('Solo professionals, creative/digital services', 'gtwelve-elementor'),
					esc_html__('Photography, Digital Marketing, Graphic Designing, Consultancy Services', 'gtwelve-elementor')
				),
			),
		);
	}

	private function get_default_cell_values(string ...$values): array
	{
		return array_map(
			static function (string $value): array {
				return array('value' => $value);
			},
			$values
		);
	}
}
