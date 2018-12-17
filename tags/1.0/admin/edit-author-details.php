<?php
/**
* Edit Author Details (Wordpress Hook Entry)
*/
function ad_edit_author_details_page(){
	$display_text = null;
	if(! isset($_GET["profile_id"])) {
		$display_text = ad_return_message(ad_words('exist'), ad_words('error'));
		return ad_display_all_authors_details($display_text);	
	}
	
	if( isset($_POST["profile_id"])) {
		$display_text = ad_save_author_details_changes();
	}
	
	$profile_id = intval($_GET["profile_id"]);
	if (!preg_match('/<div id="message" class="error">/i', $display_text)) {
		ad_edit_author_details($display_text, $profile_id);
	}else{
		echo $display_text;
		echo '<p><a href="admin.php?page='.AD_Config::edit_author_details_page.'&profile_id='.$profile_id.'" class="button">'. __('Back') .'</a></p>';
	}
}

function ad_save_author_details_changes(){
	global $wpdb;
	$profile_id = esc_attr($_POST["profile_id"]);
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
	
	$error = 0;
	$msg = '';
	
	if($description == ""){
		$error = 1;
		$msg .= '<p><strong>Description empty!</strong></p>';
	}
	if($email != ""){
		if(is_email($email) == false){
			$error = 1;
			$msg .= '<p><strong>Email is not valid!</strong></p>';
		}
	}
			
	if($error == 1){
		return '<div id="message" class="error">'.$msg.'</div>';
	}else{
		$data = array(
			'profile_id' => $profile_id,
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
		$author_details_table = new AD_Profile_DB($wpdb);
		$author_details_table->edit_row($data);
		return ad_return_message("Custom Author Updated", "updated");
	}
}

function ad_edit_author_details($display_text, $profile_id){
	global $wpdb, $ad_plugin_dir_path;
	$author_details_table = new AD_Profile_DB($wpdb);
	$result = $author_details_table->get_row_by_id($profile_id);
	?>
	<div class="wrap">
	<div style="display:none" id="plugin_url"><?php echo $ad_plugin_dir_path; ?></div>	<!-- Store plugin url path here here for use by javascript -->
	<div id="icon-users" class="icon32"><br /></div>
	<h2>Edit Custom Author <a href="admin.php?page=<?php echo AD_Config::display_all_authors_details_page; ?>" class='button'><?php _e('Back'); ?> </a></h2>
	<?php 
	echo $display_text;
	$author = ad_get_author_details_from_database($result->username, true);
	$author_display_box = ad_get_author_bio_html($author);
	?>
	
	<form action="" method="post" id="createuser">
	<input type="hidden" name="profile_id" value="<?php echo $profile_id; ?>"/>
		<table class="form-table">
			<tr class="form-field form-required">
				<th scope="row"><label for="username"><?php echo ad_words('username'); ?> </label></th>
				<td><?php echo $result->username; ?></td>
			</tr>
			<tr class="form-field form-required">
				<th scope="row"><label for="short-code">Short-code </label></th>
				<td><strong>[author-details=<?php echo $result->username; ?>]</strong></td>
			</tr>			
			<tr class="form-field">
				<th scope="row"><label for="email"><?php echo ad_words('email'); ?></label></th>
				<td><input name="email" type="text" id="email" value="<?php echo $result->email; ?>" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="first_name"><?php echo ad_words('first_name'); ?></label></th>
				<td><input name="first_name" type="text" id="first_name" value="<?php echo $result->first_name; ?>" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="last_name"><?php echo ad_words('last_name'); ?></label></th>
				<td><input name="last_name" type="text" id="last_name" value="<?php echo $result->last_name; ?>" /></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="url"><?php echo ad_words('website'); ?></label></th>
				<td><input name="url" type="text" id="url" value="<?php echo $result->url; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="description"><?php echo ad_words('description'); ?></label></th>
				<td><textarea name="description" id="description" rows="5" cols="50" ><?php echo $result->description; ?></textarea></td>
			</tr>
			<tr>
				<th scope="row"><label for="twitter"><?php echo ad_words('twitter'); ?></label></th>
				<td><input name="twitter" type="text" id="twitter" value="<?php echo $result->twitter; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="facebook"><?php echo ad_words('facebook'); ?></label></th>
				<td><input name="facebook" type="text" id="facebook" value="<?php echo $result->facebook; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="google_plus"><?php echo ad_words('google_plus'); ?></label></th>
				<td><input name="google_plus" type="text" id="google_plus" value="<?php echo $result->google_plus; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="linkedin"><?php echo ad_words('linkedin'); ?></label></th>
				<td><input name="linkedin" type="text" id="linkedin" value="<?php echo $result->linkedin; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="flickr"><?php echo ad_words('flickr'); ?></label></th>
				<td><input name="flickr" type="text" id="flickr" value="<?php echo $result->flickr; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="youtube"><?php echo ad_words('youtube'); ?></label></th>
				<td><input name="youtube" type="text" id="youtube" value="<?php echo $result->youtube; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="vimeo"><?php echo ad_words('vimeo'); ?></label></th>
				<td><input name="vimeo" type="text" id="vimeo" value="<?php echo $result->vimeo; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="skype"><?php echo ad_words('skype'); ?></label></th>
				<td><input name="skype" type="text" id="skype" value="<?php echo $result->skype; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="xing"><?php echo ad_words('xing'); ?></label></th>
				<td><input name="xing" type="text" id="xing" value="<?php echo $result->xing; ?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="use_custom_image"><?php echo ad_words('custom_image'); ?> <?php echo ad_words('gravatar'); ?></label></th>
				<td><input name="use_custom_image" type="checkbox" id="use_custom_image"
				<?php if($result->use_custom_image){ echo "checked"; }?> 
				/></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="custom_image_url"><?php echo ad_words('image_location'); ?> <?php echo ad_words('size'); ?></label></th>
				<td><input name="custom_image_url" type="text" id="custom_image_url" value="<?php echo $result->custom_image_url; ?>" /></td>
			</tr>		
			<tr>
				<th scope="row"><label for="display_html_block"><?php echo ad_words('custom_html'); ?></label></th>
				<td><input name="display_html_block" type="checkbox" id="display_html_block"
				<?php if($result->display_html_block){ echo "checked"; }?> 
				/></td>
			</tr>
			<tr>
				<th scope="row"><label for="html_block"><?php echo ad_words('custom_html_code'); ?></label></th>
				<td><?php wp_editor( $result->html_block, 'html_block' ) ?></td>
			</tr>		
		</table>
	<p class="submit">
	<input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php echo ad_words('save_changes'); ?>" /> 
	<a href="admin.php?page=<?php echo AD_Config::display_all_authors_details_page ?>&action=delete&profile_id=<?php echo $profile_id;?>" onclick="return confirm('Confirm Deletion of <?php echo $result->username; ?>?')"><?php echo ad_words('delete'); ?></a>
	</p>
	</form>	
	</div>
	<?php 	
}