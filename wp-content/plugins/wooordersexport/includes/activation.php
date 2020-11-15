<?php 
/**
 * @package Get Order Export Data
 */
defined( 'ABSPATH' ) || exit;

if(!function_exists('woo_oder_export_activation') ){

    /**
     * Created By : Nilaksha
     * Created At : 14/11/2020
     * Summary : Adds plugin options at the call of the function
     *
     * @return void
     */
    function wooOderExportActivation(){
        if(!get_option('woo_oder_export_settings')){
            add_option('woo_oder_export_settings', array(
                'button_label' => 'Export Data',
                'activated_date' => date("Y-m-d : H:i:s"),
            ));
        }
    }

}


?>