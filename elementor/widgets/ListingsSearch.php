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
class ListingsSearch extends Widget_Base {

	public function get_name() {
		return 'wpsight_geneva_listings_search';
	}

	public function get_title() {
		return __( 'Listings Search', 'wpcasa-geneva' );
	}

    public function get_icon() {
		return 'eicon-search';
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

		$this->end_controls_section();

	}

	protected function render() {
        wpsight_search(array());
    }

	public function render_plain_content() {}
}
