<?php

/**
 * @package Get Order Export Data
 */
defined('ABSPATH') || exit;

if (!class_exists('WooOrderRetrieve')) {
    class WooOrderRetrieve
    {
        public function __construct()
        {
            /**
             * INCLUDE FILES
             */
            require(WOOOREXP_PATH . '/views/wooorderexport_top_bar_button.php');
        }

        /**
         * Created By : Nilaksha 
         * Created At : 14/11/2020
         * Summary : Gets the order records and preps the CSV file
         *           https://stackoverflow.com/questions/49437781/add-a-button-on-top-of-admin-orders-list-in-woocommerce?noredirect=1&lq=1
         *           https://developer.wordpress.org/reference/hooks/manage_posts_extra_tablenav/
         * @param [type] $which
         * @return void
         */
        function adminOrderListTopButton($which)
        {
            global $typenow;
            if ('shop_order' === $typenow && 'top' === $which) {
                wooOrderExportSettingsPageButton();
            }
        }

        /**
         * Created By : Nilaksha 
         * Created At : 14/11/2020
         * Summary : Gets the order records and preps the CSV file
         *           https://premium.wpmudev.org/blog/handling-form-submissions/
         *           https://www.businessbloomer.com/woocommerce-easily-get-order-info-total-items-etc-from-order-object/
         *
         * @return void
         */
        public function wooOderExporttoCSV()
        {
            $ord = $_GET['order'];
            $date = $_GET['m'];
            $paged = $_GET['paged'];
            $status = $_GET['post_status'];
            $orderBy = $_GET['orderby'];
            $customer = $_GET['_customer_user'];

            $searchQuery = isset($_REQUEST['s']) ? sanitize_text_field(wp_unslash($_GET['s'])) : '';
            $orders = $this->getWooCommerceOrderData($orderBy, $customer, $searchQuery, $date, $status, $ord, $paged);

            $dataArray = array();
            array_push($dataArray, implode(',', array('Order_Number', 'Order_Date', 'Order_Status', 'Customer_Name', 'Order_Total')));

        //  print_r($orders);
        //  die();

            foreach ($orders as $order) {
                array_push($dataArray, implode(
                    ',',
                    array(
                        ($order->get_id()) ? $this->replaceChar($order->get_id()) : "NA",
                        ($order->get_date_created()) ? $this->replaceChar($order->get_date_created()) : "NA",
                        ($order->get_status()) ? $this->replaceChar($order->get_status()) : "NA",
                        (!$order->get_billing_first_name() && !$order->get_billing_last_name()) ? "NA" : $this->replaceChar((($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()))),
                        ($order->get_total()) ? $this->replaceChar(($order->get_currency() . ' ' . $order->get_total())) : "NA",
                    )
                ));
            }

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="Orders-' . date("Y-m-d_H-i-s") . '.csv"');

            $fp = fopen('php://output', 'wb');
            foreach ($dataArray as $line) {
                $val = explode(",", $line);
                fputcsv($fp, $val);
            }
            fclose($fp);
        }

        /**
         * Created By : Nilaksha 
         * Created At : 14/11/2020
         * Summary : Gets all the order details WC tables based on params passed
         *           https://github.com/woocommerce/woocommerce/wiki/wc_get_orders-and-WC_Order_Query#general
         *           https://github.com/woocommerce/woocommerce/issues/24531
         *           https://rudrastyh.com/wordpress/meta_query.html
         *
         * @param [type] $orderBy
         * @param [type] $customer
         * @param [type] $searchQuery
         * @param [type] $date
         * @param [type] $status
         * @param [type] $order
         * @param integer $paged
         * @return array
         */
        public function getWooCommerceOrderData($orderBy, $customer, $searchQuery, $date, $status, $order, $paged = 1)
        {
            //Ignore shop order refund records to avoid duplicate history records for order
            $excludeFilter = array(
                'type' => 'shop_order_refund',
                'return' => 'ids',
            );

            $filter = array(
                'limit' => ((get_user_option('woocommerce_keys_per_page')) ? (int)get_user_option('woocommerce_keys_per_page') : 20),
                'paged' => $paged,
                'order' => $order,
                'exclude' => wc_get_orders($excludeFilter),
            );

            if ($status) {
                $filter['status']  = $status;
            }

            if ($orderBy === 'order_total') {
                $filter['meta_key']  = '_order_total';
                $filter['orderby'] = 'meta_value_num';
            } else {
                $filter['orderby'] = $orderBy;
            }

            if ($customer) {
                $filter['customer_id'] = $customer;
            }

            if ($searchQuery) {
                // $filter['meta_query'] = array(
                //     'relation' => 'OR',
                //     array(
                //         'key' => 'first_name',
                //         'value' => esc_attr($searchQuery),
                //         'compare' => 'LIKE'
                //     ),
                //     array(
                //         'key' => 'last_name',
                //         'value' => esc_attr($searchQuery),
                //         'compare' => 'LIKE'
                //     ),
                // );
            }

            if ($date) {
                //Get the first and the last day of the month for the query
                $date = strtotime($date . '01');
                $firstDay = date('Y-m-d', $date);
                $lastDay =  date('Y-m-t', $date);
                $filter['date_created'] = $firstDay . '...' . $lastDay;
            }
            return wc_get_orders($filter);
        }

        /**
         * Created By : Nilaksha 
         * Created At : 14/11/2020
         * Summary : Replaces comma char with given value 
         * @param [type] $string
         * @param [type] $replaceChar
         * @param [type] $replaceWith
         * @return string
         */
        public function replaceChar($string, $replaceChar = ',', $replaceWith = '_')
        {
            return str_replace($replaceChar, $replaceWith, $string);
        }
    }
}
