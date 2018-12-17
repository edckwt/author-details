<?php
/**
 * Load all Pages
*/
require_once(dirname(__FILE__).'/display-all-author-details.php');
require_once(dirname(__FILE__).'/add-new-author-details.php');
require_once(dirname(__FILE__).'/edit-author-details.php');
require_once(dirname(__FILE__).'/extra-user-profile-fields.php');
/**
*  Add Settings pages
*/
function ad_add_menu_page() {

	//Author Details Page
	$settings_menu_title = ad_words('settings_menu_title');
	$settings_menu_page_title = ad_words('settings_menu_page_title');
	$capability = "manage_options";
	
	add_submenu_page( 'users.php', $settings_menu_page_title, $settings_menu_title, $capability, AD_Config::display_all_authors_details_page, AD_Config::display_all_authors_details_page);
	ad_add_pages_not_shown_in_menu($capability);
}

function ad_add_pages_not_shown_in_menu($capability) {
	//Add Custom Author Page
	$add_author_details_title = ad_words('add_author_details_title');
	$add_new_author_details_page = add_submenu_page(__FILE__, $add_author_details_title, $add_author_details_title, $capability, AD_Config::add_new_author_details_page, AD_Config::add_new_author_details_page);
	add_action( 'admin_print_styles-' . $add_new_author_details_page, 'ad_admin_styles' );
	
	//Edit Custom Author Page
	$edit_author_details_title = ad_words('edit_author_details_title');
	$edit_author_details_page = add_submenu_page(__FILE__, $edit_author_details_title, $edit_author_details_title, $capability, AD_Config::edit_author_details_page, AD_Config::edit_author_details_page);
	add_action( 'admin_print_styles-' . $edit_author_details_page, 'ad_admin_styles' );
}

function ad_admin_styles() {
	wp_enqueue_script("jquery");
}

function ad_admin_settings_page() {
?>
	<div class="wrap">
	<h1><?php echo ad_words('settings'); ?></h1>
	</div>
<?php
}

function ad_admin_init() {
	register_setting( 'ad-settings-group', AD_Config::plugin_name );
}

add_action('admin_init', 'ad_admin_init');
add_action('admin_menu', 'ad_add_menu_page');
?>