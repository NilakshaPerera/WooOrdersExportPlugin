<?php

/**
 * @package Get Order Export Data
 */
defined('ABSPATH') || exit;
if (!function_exists('wooOrderExportSettingsPageButton')) {
    /**
     * Created By : Nilaksha 
     * Created At : 15/11/2020
     * Summary : Gets search parameters and form the parameter post URL in the button
     *
     * @return void
     */
    function wooOrderExportSettingsPageButton()
    {
        $paramString = '';
        $paramString .= ('&paged=' . ((isset($_GET['paged'])) ? $_GET['paged'] : 1));
        $paramString .= ('&orderby=' . ((isset($_GET['orderby'])) ? $_GET['orderby'] : ""));
        $paramString .= ('&order=' . ((isset($_GET['order'])) ? $_GET['order'] : ""));
        $paramString .= ('&_customer_user=' . ((isset($_GET['_customer_user'])) ? $_GET['_customer_user'] : ""));
        $paramString .= ('&s=' . ((isset($_GET['s'])) ? $_GET['s'] : ""));
        $paramString .= ('&m=' . ((isset($_GET['m'])) ? $_GET['m'] : ""));
        $paramString .= ('&post_status=' . ((isset($_GET['post_status'])) ? $_GET['post_status'] : ""));  

?>
        <div class="alignright">
            <a href="<?php echo admin_url('admin-post.php?action=woo_oder_export_to_csv' . $paramString); ?>" style="height:32px;margin-left:5px;" class="button"><?php echo __('Export CSV', 'woocommerce'); ?></a>
        </div>
<?php
    }
}
?>