<?php

/**
 * Plugin Name: WooOrdersExport
 * Description: This piece of plugin allows admin users to filter and export orders data in a CSV format.
 * Version: 1.0.0
 * Author: Nilaksha Perera
 * Author URI: https://nilaksha.com
 * Text Domain: wooorderexport
 */

defined('ABSPATH') || exit;

if (version_compare(get_bloginfo('version'), '5.5', '<=')) {
    die('Needs a Wordpress higher version.');
}

if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    die('Needs Woocommerce installed and activated.');
}

define('WOOOREXP_PATH', plugin_dir_path(__FILE__));
define('WOOOREXP_URL', plugin_dir_url(__FILE__));

/**
 * Reference : https://docs.woocommerce.com/document/create-a-plugin/
 */
if (!class_exists('WooOrderExport')) {
    class WooOrderExportCore
    {
        public function __construct()
        {
            /**
             * INCLUDE FILES
             */
            require(WOOOREXP_PATH . '/views/wooorderexport_settings.php');
            require(WOOOREXP_PATH . '/includes/activation.php');

            /**
             * INCLUDE CLASSES
             */
            require(WOOOREXP_PATH . '/classes/WooOrderExportSettings.php');
            require(WOOOREXP_PATH . '/classes/WooOrderRetrieve.php');

            /**
             * INCLUDE HOOKS
             */
            register_activation_hook(__FILE__, 'wooOderExportActivation');
            //Below commented, adds a menu item in WooCommerce section
            //add_action('admin_menu' , array(new WooOrderExportSettings(), 'wooOrderExportSettingsPage'));
            add_action('admin_post_woo_oder_export_to_csv', array(new WooOrderRetrieve(), 'wooOderExporttoCSV'));
            add_action('manage_posts_extra_tablenav', array(new WooOrderRetrieve(), 'adminOrderListTopButton'), 20, 1);
            
        }
    }
    $wooOrderExport = new WooOrderExportCore();
}
