<?php
/*
Plugin Name: WPCasa Elementor
Plugin URI:
Description: This plugin connect with Real Advisor CRM and sync listing to WPCasa plugin.
Version: 1.0.0
Author: Wpcasa Elementor
Author URI: http://realadvisor.ch
GitHub Plugin URI: https://github.com/wpsight/wpcasa-elementor
Requires at least: 4.0
Tested up to: 4.6
Text Domain: wpcasa-elementor
Domain Path: /languages
Copyright:
License: GNU General Public License v2.0 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * WPCasa_RealAdvisor_Init Class
 */
class WPCasa_Elementor_Init
{
    public function __construct()
    {
        define('WPCASA_ELEMENTOR_PLUGIN_DIR', untrailingslashit(plugin_dir_path(__FILE__)));

        include_once WPCASA_ELEMENTOR_PLUGIN_DIR . '/elementor/widgets-manager.php';
//        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
//        add_action('template_redirect', array($this, 'overriding_wpcasa_post'));

        add_filter( 'template_include', array($this, 'overriding_wpcasa_post') );
        add_action( 'elementor/theme/register_locations', array($this, 'wpsight_geneva_register_elementor_locations' ));
//        add_action('template_redirect', array($this, 'overriding_wpcasa_post'));
//        do_action('overriding_wpcasa_post');
    }



    /**
     *	wpsight_geneva_register_elementor_locations()
     *
     *	Register Elementor Locations
     *	https://developers.elementor.com/theme-locations-api/registering-locations/
     *
     *	@since	1.0.0
     */

    public function wpsight_geneva_register_elementor_locations($elementor_theme_manager) {
        $elementor_theme_manager->register_all_core_location();
    }

//    public function load_plugin_textdomain()
//    {
//        load_plugin_textdomain('wpcasa-realadvisor', false, dirname(plugin_basename(__FILE__)) . '/languages/');
//    }


    public function overriding_wpcasa_post( $original_template ) {
        $conditions_manager = \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'theme-builder' )->get_conditions_manager();

        if( is_singular( 'listing' ) && ( !empty($conditions_manager->get_documents_for_location('single')) ) ) {
            return plugin_dir_path(__FILE__) . 'single.php';
        } else {
            return $original_template;
        }

    }

}

$realadvisor_init = new WPCasa_Elementor_Init();

