<?php
/**
 * Activation of plugin
 *
 */
include_once(dirname(__FILE__).'/includes/includes-master-list.php');

global $wpdb;
//create the custom author database
$author_details_database_table = new AD_Profile_DB($wpdb);
$author_details_database_table->create_table();
?>