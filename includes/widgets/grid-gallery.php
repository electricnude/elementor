<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Widget_Grid_Gallery extends Widget_Base {

	public function get_id() {
		return 'grid-gallery';
	}

	public function get_title() {
		return __( 'Grid Gallery', 'elementor' );
	}

	public function get_icon() {
		return 'gallery-grid';
	}

	protected function _register_controls() {
		$this->add_control(
			'section_gallery',
			[
				'label' => __( 'Grid Gallery', 'elementor' ),
				'type' => Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
				'section' => 'section_gallery',
			]
		);

		$this->add_control(
			'wp_gallery',
			[
				'label' => __( 'Add Images', 'elementor' ),
				'type' => Controls_Manager::GALLERY,
				'section' => 'section_gallery',
			]
		);

		$this->add_group_control(
			Group_Control_Image_size::get_type(),
			[
				'name' => 'thumbnail',
			]
		);

		$gallery_columns = range( 1, 10 );
		$gallery_columns = array_combine( $gallery_columns, $gallery_columns );

		$this->add_control(
			'gallery_columns',
			[
				'label' => __( 'Columns', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 4,
				'options' => $gallery_columns,
				'section' => 'section_gallery',
			]
		);

		$this->add_control(
			'gallery_link',
			[
				'label' => __( 'Link to', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'file',
				'section' => 'section_gallery',
				'options' => [
					'file' => __( 'Media File', 'elementor' ),
					'attachment' => __( 'Attachment', 'elementor' ),
					'none' => __( 'None', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'gallery_rand',
			[
				'label' => __( 'Ordering', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_gallery',
				'options' => [
					'' => __( 'Default', 'elementor' ),
					'rand' => __( 'Random', 'elementor' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'section_gallery_images',
			[
				'label' => __( 'Images', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'gallery_gap',
			[
				'label' => __( 'Columns Gap', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_gallery_images',
				'tab' => self::TAB_STYLE,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'custom' => __( 'Custom', 'elementor' ),
				],
			]
		);

		$columns_padding = is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';

		$this->add_control(
			'columns_padding',
			[
				'label' => __( 'Columns Padding', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'condition' => [
					'gallery_gap' => 'custom',
				],
				'section' => 'section_gallery_images',
				'tab' => self::TAB_STYLE,
				'selectors' => [
					'{{WRAPPER}} .gallery-item' => 'padding: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;',
					'{{WRAPPER}} .gallery' => 'margin: ' . $columns_padding,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => __( 'Image Border', 'elementor' ),
				'tab' => self::TAB_STYLE,
				'section' => 'section_gallery_images',
				'selector' => '{{WRAPPER}} .gallery-item img',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'tab' => self::TAB_STYLE,
				'section' => 'section_gallery_images',
				'selectors' => [
					'{{WRAPPER}} .gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_caption',
			[
				'label' => __( 'Caption', 'elementor' ),
				'type' => Controls_Manager::SECTION,
				'tab' => self::TAB_STYLE,
			]
		);

		$this->add_control(
			'gallery_display_caption',
			[
				'label' => __( 'Display', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'section' => 'section_gallery_images',
				'tab' => self::TAB_STYLE,
				'default' => 'default',
				'options' => [
					'default' => __( 'Show', 'elementor' ),
					'none' => __( 'Hide', 'elementor' ),
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'align',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon' => 'align-justify',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'gallery_display_caption' => 'default',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-item .gallery-caption' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'elementor' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'tab' => self::TAB_STYLE,
				'section' => 'section_caption',
				'selector' => '{{WRAPPER}} .gallery-item .gallery-caption',
			]
		);
	}

	protected function render( $instance = [] ) {
		if ( ! $instance['wp_gallery'] ) {
			return;
		}

		$ids = wp_list_pluck( $instance['wp_gallery'], 'id' );

		$this->add_render_attribute( 'shortcode', 'ids', implode( ',', $ids ) );

		if ( $instance['gallery_columns'] ) {
			$this->add_render_attribute( 'shortcode', 'columns', $instance['gallery_columns'] );
		}

		if ( 'custom' !== $instance['thumbnail_size'] ) {
			$this->add_render_attribute( 'shortcode', 'size', $instance['thumbnail_size'] );
		}

		if ( $instance['gallery_link'] ) {
			$this->add_render_attribute( 'shortcode', 'link', $instance['gallery_link'] );
		}

		if ( ! empty( $instance['gallery_rand'] ) ) {
			$this->add_render_attribute( 'shortcode', 'orderby', $instance['gallery_rand'] );
		}
		?>
		<div class="elementor-wp-gallery">
			<?php echo do_shortcode( '[gallery ' . $this->get_render_attribute_string( 'shortcode' ) . ']' ); ?>
		</div>
		<?php
	}

	protected function content_template() {}
}
