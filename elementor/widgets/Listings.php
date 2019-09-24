<?php

namespace WPSight_Geneva\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All information about custom widgets can be found here
 * https://developers.elementor.com/creating-a-new-widget/
 */
class Listings extends Widget_Base {

	public function get_name() {
		return 'wpsight_geneva_listings';
	}

	public function get_title() {
		return __( 'Listings', 'wpcasa-geneva' );
	}

    public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'general', 'theme' ];
	}

	protected function _register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'wpcasa-geneva' ),
            ]
        );

        $this->add_control(
            'listing_type',
            [
                'label' => __( 'Listing type', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'false',
            ]
        );

        $this->add_control(
            'date',
            [
                'label' => __( 'Date', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'yes',
            ]
        );

        $details_array = [];
        foreach ( array_keys(wpsight_details()) as $detail ) {
            $details_array[$detail] = wpsight_get_detail( $detail, 'label' );
        }

        $this->add_control(
            'show_elements',
            [
                'label' => __( 'Listing Details', 'wpcasa-geneva' ),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $details_array,
                'default' => [ 'numberOfRooms', 'details_4' ],
            ]
        );

        $this->end_controls_section();

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'wpcasa-geneva' ),
			]
		);

        $this->add_control(
            'min',
            [
                'label' => __( 'Min', 'wpcasa-geneva' ),
                'type' => Controls_Manager::NUMBER,
                'step' => 10,
            ]
        );

        $this->add_control(
            'max',
            [
                'label' => __( 'Max', 'wpcasa-geneva' ),
                'type' => Controls_Manager::NUMBER,
                'step' => 10,
            ]
        );

        $this->add_control(
            'nr',
            [
                'label' => __( 'Number of listings', 'wpcasa-geneva' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '10',
                'step' => 1,
            ]
        );

        foreach( get_object_taxonomies( wpsight_post_type(), 'objects' ) as $key => $taxonomy ) {
            $terms = get_terms( array( $key ), array( 'hide_empty' => 0 ) );
            $terms_filtered = array_column($terms, 'name', 'slug');
            $terms_filtered = array_merge(["" => sprintf( esc_attr__( 'All %s', 'wpcasa-geneva' ),  $taxonomy->label  )], $terms_filtered);

            if ( $terms ) {
                $this->add_control(
                    $taxonomy->name,
                    [
                        'label' =>  $taxonomy->label,
                        'type' => Controls_Manager::SELECT,
                        'default' => '',
                        'options' => $terms_filtered,
                    ]
                );
            }
        }

        $this->add_control(
            'orderby',
            [
                'label' => __( 'OrderBy', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date' => __( 'Post Date', 'wpcasa-geneva' ),
                    'price' => __( 'Price', 'wpcasa-geneva' ),
                    'title' => __( 'Title', 'wpcasa-geneva' ),
                    'name'  => __( 'Name(slug)', 'wpcasa-geneva' ),
                    'rand'  => __( 'Rand', 'wpcasa-geneva' ),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __( 'Order', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => __( 'DESC', 'wpcasa-geneva' ),
                    'ASC' => __( 'ASC', 'wpcasa-geneva' ),
                ],
            ]
        );

        $this->add_control(
            'show_panel',
            [
                'label' => __( 'Show panel', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'show_paging',
            [
                'label' => __( 'Show pagination', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

	}

	protected function render() {
        $listing_args = [];
        $settings = $this->get_active_settings();

        foreach ( $settings as $index => $item ) {
            $this->add_render_attribute( $index, $index, $item);
            if ( !is_array($settings[$index]) ) { //need to avoid notice string to array
                $listing_args[] = $this->get_render_attribute_string( $index );
            }
        }

        if ( 'yes' === $settings['listing_type'] ) {
            $settings['show_elements'][] = 'listing_type';
        }

        if ( 'yes' === $settings['title'] ) {
            $settings['show_elements'][] = 'title';
        }

        if ( 'yes' === $settings['date'] ) {
            $settings['show_elements'][] = 'date';
        }
//       add filter to edit listing card details
        $show_elements = $settings['show_elements'];
        add_filter( 'card_info_filter', function() use ( $show_elements ) {
            return $show_elements;
        });

        echo do_shortcode('[wpsight_listings ' . implode( " ", $listing_args ) . ']');
    }

	public function render_plain_content() {}
}
