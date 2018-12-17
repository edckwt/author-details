<?php
/**
* Add Author Details
*/
function ad_add_new_author_details_page(){
	$display_text = '';
	if(isset($_POST["username"])) {
		$display_text = ad_save_new_author_details();
	}
	ad_display_add_new_author_details_page($display_text);
}

function ad_save_new_author_details(){
	global $wpdb;
	$username = esc_attr($_POST["username"]);
	if($username ==""){
		return ad_return_message(ad_words('required'), ad_words('error'));
	}
	$email = esc_attr($_POST["email"]);
	$first_name = esc_attr($_POST["first_name"]);
	$last_name = esc_attr($_POST["last_name"]);
	$url = esc_attr($_POST["url"]);
	$description = esc_attr($_POST["description"]);
	$twitter = esc_attr($_POST["twitter"]);
	$facebook = esc_attr($_POST["facebook"]);
	$google_plus = esc_attr($_POST["google_plus"]);
	$linkedin = esc_attr($_POST["linkedin"]);
	$flickr = esc_attr($_POST["flickr"]);
	$youtube = esc_attr($_POST["youtube"]);
	$vimeo = esc_attr($_POST["vimeo"]);
	$skype = esc_attr($_POST["skype"]);
	$xing = esc_attr($_POST["xing"]);
	$use_custom_image = null;
	if(isset($_POST['use_custom_image']))
	{
		$use_custom_image = esc_attr($_POST["use_custom_image"]);
	}
	$custom_image_url = esc_attr($_POST["custom_image_url"]);
	$display_html_block = null;
	if(isset($_POST['display_html_block']))
	{
		$display_html_block = esc_attr($_POST["display_html_block"]);
	}
	$html_block = $_POST["html_block"];
	
	$author_details_table = new AD_Profile_DB($wpdb);	
	if($author_details_table->get_row_by_username($username) != null){
		//username already exist
		return ad_return_message("".ad_words('error_username')." <strong>". $username."</stong> ".ad_words('already')."", ad_words('error'));
	}
		$data = array(
			'username' => $username,
			'first_name' => $first_name, 
			'last_name' => $last_name, 
			'email' => $email, 
			'url' => $url, 
			'description' => $description, 
			'twitter' => $twitter, 
			'facebook' => $facebook, 
			'google_plus' => $google_plus, 
			'linkedin' => $linkedin, 
			'flickr' => $flickr, 
			'youtube' => $youtube, 
			'vimeo' => $vimeo, 
			'skype' => $skype, 
			'xing' => $xing, 
			'use_custom_image' => $use_custom_image, 
			'custom_image_url' => $custom_image_url, 
			'display_html_block' => $display_html_block, 
			'html_block' => $html_block
		);
	
	$profile_id = $author_details_table->create_new_row($data);
	if($profile_id){
		$message = '<p>'.ad_words('added').' <a href="admin.php?page='.AD_Config::display_all_authors_details_page.'">'.ad_words('back_to_all').'</a></p>';
		return ad_return_message($message, ad_words('updated'));
	}else{
		return ad_return_message(ad_words('error_adding'), ad_words('error'));
	}
	
}

function ad_display_add_new_author_details_page($display_text){
	global $ad_plugin_dir_path;
	?>
	<div class="wrap">
	<div style="display:none" id="plugin_url"><?php echo $ad_plugin_dir_path; ?></div>	<!-- Store plugin url path here here for use by javascript -->
	<div id="icon-users" class="icon32"><br /></div>
	<h2 id="add-new-user"><?php echo ad_words('add_new'); ?></h2>
	<?php echo $display_text; ?>
		
	<form action="" method="post" name="createuser" id="createuser" class="add:users: validate">
		<input name="action" type="hidden" value="createuser" />
		<table class="form-table">
			<tr class="form-field form-required">
				<th scope="row"><label for="username"><?php echo ad_words('username'); ?> <span class="description"><?php echo ad_words('required_input'); ?></span></label></th>
				<td><input name="username" type="text" id="username" value="" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="email"><?php echo ad_words('email'); ?></label></th>
				<td><input name="email" type="text" id="email" value="" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="first_name"><?php echo ad_words('first_name'); ?></label></th>
				<td><input name="first_name" type="text" id="first_name" value="" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="last_name"><?php echo ad_words('last_name'); ?></label></th>
				<td><input name="last_name" type="text" id="last_name" value="" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="url"><?php echo ad_words('website'); ?></label></th>
				<td><input name="url" type="text" id="url" value="" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="description"><?php echo ad_words('description'); ?></label></th>
				<td><textarea name="description" id="description" rows="5" cols="50" ></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label for="twitter"><?php echo ad_words('twitter'); ?></label></th>
				<td><input name="twitter" type="text" id="twitter" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="facebook"><?php echo ad_words('facebook'); ?></label></th>
				<td><input name="facebook" type="text" id="facebook" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="google_plus"><?php echo ad_words('google_plus'); ?></label></th>
				<td><input name="google_plus" type="text" id="google_plus" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="linkedin"><?php echo ad_words('linkedin'); ?></label></th>
				<td><input name="linkedin" type="text" id="linkedin" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="flickr"><?php echo ad_words('flickr'); ?></label></th>
				<td><input name="flickr" type="text" id="flickr" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="youtube"><?php echo ad_words('youtube'); ?></label></th>
				<td><input name="youtube" type="text" id="youtube" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="vimeo"><?php echo ad_words('vimeo'); ?></label></th>
				<td><input name="vimeo" type="text" id="vimeo" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="skype"><?php echo ad_words('skype'); ?></label></th>
				<td><input name="skype" type="text" id="skype" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="xing"><?php echo ad_words('xing'); ?></label></th>
				<td><input name="xing" type="text" id="xing" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="use_custom_image"><?php echo ad_words('custom_image'); ?> <?php echo ad_words('gravatar'); ?></label></th>
				<td><input name="use_custom_image" type="checkbox" id="use_custom_image" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="custom_image_url"><?php echo ad_words('image_location'); ?> <?php echo ad_words('size'); ?></label></th>
				<td><input name="custom_image_url" type="text" id="custom_image_url" value="" /></td>
			</tr>					
			<tr>
				<th scope="row"><label for="display_html_block"><?php echo ad_words('custom_html'); ?></label></th>
				<td><input name="display_html_block" type="checkbox" id="display_html_block" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="html_block"><?php echo ad_words('custom_html_code'); ?></label></th>
				<td><?php wp_editor( '', 'html_block' ) ?></td>
			</tr>		
		</table>
	
	<p class="submit">
	<input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php echo ad_words('add'); ?>" /> 
	<a href="admin.php?page=<?php echo AD_Config::display_all_authors_details_page; ?>"><?php echo ad_words('cancel'); ?></a>
	</p>
	</form>	
	</div>
	<?php 	
}