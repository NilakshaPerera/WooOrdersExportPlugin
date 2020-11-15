<?php 
/**
 * @package Get Order Export Data
 */
defined( 'ABSPATH' ) || exit;

if(!class_exists('WooOrderExportSettings')){
    class WooOrderExportSettings{
        /**
         * Created By : Nilaksha 
         * Created At : 14/11/2020
         * Summary : Passes the prerequisites to the submenu page
         *
         * @return void
         */
        public function wooOrderExportSettingsPage(){
            add_submenu_page(
                'woocommerce',
                __('Orders Export Settings', 'wooorderexport'),
                __('Orders Export Settings', 'wooorderexport'),
                'manage_options',
                'woo_order_export_settings',
                'wooOrderExportSettingsPageCallback',
                10
            );
        }

    }
}