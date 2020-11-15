<?php

/**
 * @package Get Order Export Data
 */
defined('ABSPATH') || exit;

if (!function_exists('wooOrderExportSettingsPageCallback')) {
    /**
     * Created By : Nilaksha 
     * Created At : 15/11/2020
     * Summary : Returns the form to get the export CSV
     *
     * @return void
     */
    function wooOrderExportSettingsPageCallback()
    {
?>
        <form id="wooorderexport-csv" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="woo_oder_export_to_csv">
            <div class="tablenav top">
                <div class="alignleft">
                    <input type="submit" class="button" value="<?php echo __('Export CSV', 'woocommerce'); ?>">
                </div>
            </div>
        </form>
<?php
    }
}
?>