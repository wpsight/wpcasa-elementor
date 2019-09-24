<?php

namespace WPSight_Geneva\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All information about custom widgets can be found here
 * https://developers.wpcasa-geneva.com/creating-a-new-widget/
 */
class ListingMap extends Widget_Base {

    private function get_map_zoom() {
        $zoom = [];

        for ( $i = 1; $i <= 20; $i++ ) {
            $zoom[$i] = $i;
        }

        return $zoom;
    }

	public function get_name() {
		return 'wpsight_geneva_listing_map';
	}

	public function get_title() {
		return __( 'Listing Map', 'wpcasa-geneva' );
	}

    public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'theme-elements-single', 'theme' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'wpcasa-geneva' ),
			]
		);

        $this->add_control(
            'map_height',
            [
                'label' => __( 'Map Height (px):', 'wpcasa-geneva' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( '555', 'wpcasa-geneva' ),
            ]
        );

        $this->add_control(
            'map_type',
            [
                'label' => __( 'Map Type:', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'ROADMAP',
                'options' => [
                    'ROADMAP' => __( 'Roadmap', 'wpcasa-geneva' ),
                    'SATELLITE' => __( 'Satellite', 'wpcasa-geneva' ),
                    'HYBRID' => __( 'Hybrid', 'wpcasa-geneva' ),
                    'TERRAIN' => __( 'Terrain', 'wpcasa-geneva' ),
                ],
            ]
        );

        $this->add_control(
            'map_zoom',
            [
                'label' => __( 'Map Zoom:', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SELECT,
                'default' => '14',
                'options' => $this->get_map_zoom(),
            ]
        );

        $this->add_control(
            'map_no_streetview',
            [
                'label' => __( 'Disable streetview', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'map_control_type',
            [
                'label' => __( 'Enable type control', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'map_control_nav',
            [
                'label' => __( 'Enable nav control', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'map_scrollwheel',
            [
                'label' => __( 'Enable scrollwheel', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'no',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'display_note',
            [
                'label' => __( 'Display public note', 'wpcasa-geneva' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'False', 'wpcasa-geneva' ),
                'label_on' => __( 'True', 'wpcasa-geneva' ),
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

		$this->end_controls_section();

	}

	protected function render() {
        $map_args = [];
        $settings = $this->get_active_settings();

        foreach ( $settings as $index => $item ) {
            $map_args[$index] = $item;
        }
        wpsight_get_template( 'listing-single-location.php', array( 'gallery_args' => $map_args ) );
    }

	public function render_plain_content() {}
}
