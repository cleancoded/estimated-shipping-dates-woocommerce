<?php

/*
  Plugin Name: Estimated Shipping Dates for WooCommerce
  Plugin URI: https://CLEANCODED.com
  Description: Easily set estimated fulfillment dates, at the product level, for any WooCommerce website.
  Author: CLEANCODED
  Version: 1.8
  Author URI: https://CLEANCODED.com
 */

global $rpesp_plugin_url, $rpesp_plugin_dir;

$rpesp_plugin_dir = dirname(__FILE__) . "/";
$rpesp_plugin_url = plugins_url() . "/" . basename($rpesp_plugin_dir) . "/";
include_once $rpesp_plugin_dir . 'lib/main.php';

