<?php
Class AD_Config{
	const plugin_name = "author-details";
	const version = "1.3";

	//Admin Pages
	const display_all_authors_details_page = "ad_display_all_authors_details_page";
	const add_new_author_details_page = "ad_add_new_author_details_page";
	const edit_author_details_page = "ad_edit_author_details_page";
	const settings_page = "ad_settings_page";
	const custom_field_in_post_for_author_details = "post-author";
	
	//Global configuration values
	const ad_global_display_on_home_page = "ad_global_display_on_home_page";
	const ad_global_display_on_page = "ad_global_display_on_page";
	const ad_global_display_on_archive_page = "ad_global_display_on_archive_page";
	const ad_global_display_on_single_post = "ad_global_display_on_single_post";
	const ad_global_display_on_top = "ad_global_display_on_top";
}

Class AD_Author{
	//wordpress parameters
	const user_login = "user_login";
	const user_nicename = "user_nicename";
	const user_email = "user_email";
	const user_url = "user_url";
	const display_name = "display_name";
	const nickname = "nickname";
	const first_name = "first_name";
	const last_name = "last_name";
	const description = "description";
	const jabber = "jabber";
	const aim = "aim";
	const yim = "yim";
	const user_firstname = "user_firstname";
	const user_lastname = "user_lastname";
	const user_description = "user_description";
	const ID = "ID";
	
	//custom parameters
	const twitter = "twitter";
	const facebook = "facebook";
	const google_plus = "google_plus";
	const linkedin = "linkedin";
	const flickr = "flickr";
	const youtube = "youtube";
	const vimeo = "vimeo";
	const skype = "skype";
	const xing = "xing";
	const disable_about_author = "disable_about_author";
}

function ad_words($k=''){
	$text['author_details'] = 'Author Details';
	$text['settings_menu_title'] = 'Author Details';
	$text['settings_menu_page_title'] = 'Author Details';
	$text['add_author_details_title'] = 'Add Custom Author';
	$text['edit_author_details_title'] = 'Edit Custom Author';
	$text['settings'] = 'Settings';
	$text['add_new'] = 'Add New Author Details';
	$text['username'] = 'Username';
	$text['required_input'] = '(required)';
	$text['email'] = 'E-mail';
	$text['first_name'] = 'First Name';
	$text['last_name'] = 'Last Name';
	$text['website'] = 'Website';
	$text['description'] = 'Description';
	$text['twitter'] = 'Twitter';
	$text['facebook'] = 'Facebook';
	$text['google_plus'] = 'Google+';
	$text['linkedin'] = 'LinkedIn';
	$text['flickr'] = 'Flickr';
	$text['youtube'] = 'YouTube';
	$text['vimeo'] = 'Vimeo';
	$text['skype'] = 'Skype';
	$text['xing'] = 'Xing';
	$text['custom_image'] = 'Use Custom Author Image';
	$text['gravatar'] = '<span class="description"><br/>(uses <a href="http://gravatar.com" target="_new">Gravatar</a> if unchecked)</span>';
	$text['image_location'] = 'Custom Author Image location';
	$text['size'] = '<span class="description"><br/>(will be re-sized to 75x75 pixels)</span>';
	$text['custom_html'] = 'Use Custom HTML';
	$text['custom_html_code'] = 'Custom HTML';
	$text['save_changes'] = 'Save Changes';
	$text['add'] = 'Add New User';
	$text['exist'] = 'Error, Custom Author does not exist!';
	$text['error'] = 'error';
	$text['error_username'] = 'Error! Username';
	$text['already'] = 'already exists!';
	$text['required'] = 'Error! Username is required!';
	$text['added'] = 'Custom Author Successfully Added';
	$text['back_to_all'] = 'Back to all authors details';
	$text['updated'] = 'updated';
	$text['error_adding'] = 'Error Adding Author Details!';
	$text['cancel'] = 'Cancel';
	$text['delete'] = 'Delete';
	$text['social_media'] = 'Social Media';
	$text['disable'] = 'Disable about author display';
	$text['check'] = 'Check this box to not have author\'s profile displayed at bottom of each post.';
	$text['deleted'] = 'Author Details Deleted!';
	$text['no_author'] = 'There are currently no author details. Why not';
	$text['add_one'] = 'add one?';
	$text['global'] = 'Global settings Updated!';
	$text['global_settings'] = 'Global Settings';
	$text['choose'] = 'Choose which type of post to automatically display on:';
	$text['home_page'] = 'Home Page';
	$text['single_page'] = 'Single Page';
	$text['single_post'] = 'Single Post';
	$text['archive_page'] = 'Archive Page';
	$text['choose_display_location'] = 'Choose display location (defaults to bottom of post when unchecked):';
	$text['top'] = 'Top';
	$text['edit'] = 'Edit';
	$text['confirm'] = 'Confirm Deletion of';
	return $text[$k];
}

function ad_return_message($message, $message_type){
	return '<div id="message" class="'.$message_type.'"><p><strong>' . $message . '</strong></p></div>';
}
?>