<?php
/**
 * Called by the wordpress the_content filter
 */
function ad_append_author_details_bio($content) {
	global $post;

	$ad_global_display_on_home_page = get_option( AD_Config::ad_global_display_on_home_page );		// is_home()
	$ad_global_display_on_page = get_option( AD_Config::ad_global_display_on_page );					// is_page()
	$ad_global_display_on_single_post = get_option( AD_Config::ad_global_display_on_single_post );	// is_single()
	$ad_global_display_on_archive_page = get_option( AD_Config::ad_global_display_on_archive_page );	// is_archive()
	$ad_global_display_on_top = get_option( AD_Config::ad_global_display_on_top );					// display author box on top of post
	
	$content=preg_replace_callback("/\[author-details=.*\]/",'ad_filter_shortcode_callback',$content);
	$content=preg_replace_callback("/\[author-details\]/",'ad_filter_shortcode_with_no_username_callback',$content);
	
	if( is_home() && $ad_global_display_on_home_page){
		if($ad_global_display_on_top){
			$content = ad_get_current_author_bio() . $content;
		}else{
			$content .= ad_get_current_author_bio();
		}
	}
	if( is_page() && $ad_global_display_on_page){
		if($ad_global_display_on_top){
			$content = ad_get_current_author_bio() . $content;
		}else{
			$content .= ad_get_current_author_bio();
		}
	}
	if( is_single() && $ad_global_display_on_single_post){
		if($ad_global_display_on_top){
			$content = ad_get_current_author_bio() . $content;
		}else{
			$content .= ad_get_current_author_bio();
		}
	}
	if( is_archive() && $ad_global_display_on_archive_page){
		if($ad_global_display_on_top){
			$content = ad_get_current_author_bio() . $content;
		}else{
			$content .= ad_get_current_author_bio();
		}
	}
	
	
// 	if ( ! is_page() ){
		
// 		$content=preg_replace_callback("/\[author-details=.*\]/",'ad_filter_shortcode_callback',$content);
// 		$content=preg_replace_callback("/\[author-details\]/",'ad_filter_shortcode_with_no_username_callback',$content);
		
// 		if( ! is_home() ){
// 			$content .= ad_get_current_author_bio();
// 		}
// 	}
	return $content;
}

function ad_filter_shortcode_callback($matches){
	$user_login = str_replace("[author-details=","",$matches[0]);
	$user_login = str_replace("]","",$user_login);

	$content = ad_get_author_bio($user_login);
	return $content;
}

function ad_filter_shortcode_with_no_username_callback($matches){
	$user_login = get_the_author_meta(AD_Author::user_login);
	$content = ad_get_author_bio($user_login);
	return $content;
}

function ad_get_current_author_bio(){
	$user_login = get_the_author_meta(AD_Author::user_login);
	return ad_get_author_bio($user_login);
}


/**
 * Create the HTML code for the author bio
 * 1) check if author is in "Do not display" list"
 * 2) check custom fields to see if author is specified
 *  - If author is in "Do not display" list and there is no custom field, return.
 * 3) check if author exists in author-details_db
 * 4) if not in author-details_db, use wordpress profile
 */
function ad_get_author_bio($username){
	
	$display_author = ad_can_display_user($username);
	
	$custom_username = ad_get_author_from_custom_field();
	if($custom_username){
		$username = $custom_username;
	}
	
	if($display_author == false && $custom_username == null){
		//Author is "Do not display" and there is no custom field.
		return;
	}
	
	$author = ad_get_author_details_from_database($username);
	
	if($author == null && $custom_username==null && $display_author){
		$author = ad_get_author_details_from_wordpress_user_profile();
	}
	
	return ad_get_author_bio_html($author);
}

function ad_get_author_bio_html($author){
	if($author == null){
		//No author to display
		return;
	}
	
	if($author[AD_Profile_DB::display_html_block]){
		//use custom block if it is enabled
		return esc_html( $author[AD_Profile_DB::html_block] );
	}
	
	$author_email = $author[AD_Author::user_email];
	$author_post_link = get_the_author_link();
	$author_name = $author[AD_Author::first_name] . " " . $author[AD_Author::last_name];
	$author_url = $author[AD_Author::user_url];
	if($author_url){
		$author_name = '<a href="'.$author_url.'" rel="author" class="author-details-name">'.$author_name.'</a>';
	}
	$author_description = esc_html( $author[AD_Author::description] );
	
	$image_size = 75;
	$author_image = get_avatar( $author_email, $image_size);
	
	if(isset($author[AD_Profile_DB::use_custom_image]) && $author[AD_Profile_DB::use_custom_image] != ""){
		//use custom author image url
		$author_image_url = esc_html( $author[AD_Profile_DB::custom_image_url]);
		$author_image = '<img src="'.$author_image_url.'" width="'.$image_size.'" height="'.$image_size.'" />';
	}
	
	if($author_description == ""){
		$author_bio = '';
	}else{
		$author_bio = '<div id="author-details" class="author-details">';
		$author_bio .= '<div class="author-details-inner">';
		$author_bio .= '<div class="author-details-image">';
		$author_bio .= $author_image;
		$author_bio .= '<div class="author-details-overlay"></div>';
		$author_bio .= '</div>';
		$author_bio .= '<div class="author-details-info">';
		$author_bio .= '<div class="author-details-name">'.$author_name.'</div>';
		$author_bio .= '<p>'.$author_description.'</p>';
		$author_bio .= ad_get_all_social_media($author);
		$author_bio .= '</div>';
		$author_bio .= '</div>';
		$author_bio .= '</div>';
	}
	return $author_bio;	
}

/**
 * Check whether the about author box for this author should be displayed
 * @param unknown_type $username
 * @return boolean
 */
function ad_can_display_user($username){
	$display_author = true;
	
	if(get_the_author_meta(AD_Author::disable_about_author)){
		$display_author = false;
	}
	
	return $display_author;
}

/**
 * Get custom field for custom author (if any)
 */
function ad_get_author_from_custom_field(){
	global $post;
	
	return get_post_meta($post->ID, AD_Config::custom_field_in_post_for_author_details, true);
}

/**
 * Get Author details from wordpress user profile
 * @return multitype:string NULL
 */
function ad_get_author_details_from_wordpress_user_profile(){
	$wordpres_author_details = array( 	
		AD_Author::first_name => get_the_author_meta(AD_Author::user_firstname),
		AD_Author::last_name => get_the_author_meta(AD_Author::user_lastname),
		AD_Author::user_email => get_the_author_meta(AD_Author::user_email),
		AD_Author::user_url => get_the_author_meta(AD_Author::user_url),
		AD_Author::description => get_the_author_meta(AD_Author::description),
		AD_Author::twitter => get_the_author_meta(AD_Author::twitter),
		AD_Author::facebook => get_the_author_meta(AD_Author::facebook),
		AD_Author::google_plus => get_the_author_meta(AD_Author::google_plus),
		AD_Author::linkedin => get_the_author_meta(AD_Author::linkedin),
		AD_Author::flickr => get_the_author_meta(AD_Author::flickr),
		AD_Author::youtube => get_the_author_meta(AD_Author::youtube),
		AD_Author::vimeo => get_the_author_meta(AD_Author::vimeo),
		AD_Author::skype => get_the_author_meta(AD_Author::skype),
		AD_Author::xing => get_the_author_meta(AD_Author::xing),
		AD_Profile_DB::display_html_block => null
		);
	return $wordpres_author_details;
}

function ad_get_author_details_from_database($username, $convert_line_feeds_to_br = false){
	global $wpdb;
	
	$database_author_details=null;
	$author_profile_db = new AD_Profile_DB($wpdb);
	$result = $author_profile_db->get_row_by_username($username);
	if($result){
		$author_description = $result->description;
		if($convert_line_feeds_to_br){
			$author_description = $author_description;
		}
		
		$database_author_details = array(
			AD_Author::first_name => $result->first_name,
			AD_Author::last_name => $result->last_name,
			AD_Author::user_email => $result->email,
			AD_Author::user_url => $result->url,
			AD_Author::description => $author_description,
			AD_Author::twitter => $result->twitter,
			AD_Author::facebook => $result->facebook,
			AD_Author::google_plus => $result->google_plus,
			AD_Author::linkedin => $result->linkedin,
			AD_Author::flickr => $result->flickr,
			AD_Author::youtube => $result->youtube,
			AD_Author::vimeo => $result->vimeo,
			AD_Author::skype => $result->skype,
			AD_Author::xing => $result->xing,
			AD_Profile_DB::use_custom_image => $result->use_custom_image,
			AD_Profile_DB::custom_image_url => $result->custom_image_url,
			AD_Profile_DB::display_html_block => $result->display_html_block,
			AD_Profile_DB::html_block => $result->html_block
		);		
	}
	return $database_author_details;
}

function ad_get_all_social_media($author){
	$content = ad_add_social_media($author, AD_Author::facebook) .
	ad_add_social_media($author, AD_Author::twitter).
	ad_add_social_media($author, AD_Author::linkedin).
	ad_add_social_media($author, AD_Author::google_plus).
	ad_add_social_media($author, AD_Author::flickr).
	ad_add_social_media($author, AD_Author::youtube).
	ad_add_social_media($author, AD_Author::vimeo).
	ad_add_social_media($author, AD_Author::skype).
	ad_add_social_media($author, AD_Author::xing);
	if($content!=""){
		$content = '<div class="author_details_social_media">'.$content.'</div>';
	}
	return $content;
}

function ad_add_social_media($author, $media_type){
	global $ad_plugin_dir_path;
	
	$social_media_id = $author[$media_type];
	if($social_media_id==null || $social_media_id==""){
		//User does not use this social media
		return "";
	}

	$social_media_content = '';
	if($media_type == AD_Author::twitter){
		$social_media_content .= '<a href="'.$social_media_id.'" rel="Twitter me" id="author-details-twitter"><img title="'.ad_words('twitter').'" src="' . $ad_plugin_dir_path . '/images/social_media/twitter.png" alt="'.ad_words('twitter').'" /></a>';
	}else if($media_type == AD_Author::facebook){
		$social_media_content .= '<a href="'.$social_media_id.'" rel="Facebook me" id="author-details-facebook"><img title="'.ad_words('facebook').'" src="' . $ad_plugin_dir_path . '/images/social_media/facebook.png" alt="'.ad_words('facebook').'" /></a>';
	}else if($media_type == AD_Author::google_plus){
		$social_media_content .= '<a href="'.$social_media_id.'" rel="me publisher author" id="author-details-google_plus"><img title="'.ad_words('google_plus').'" src="' . $ad_plugin_dir_path . '/images/social_media/google_plus.png" alt="'.ad_words('google_plus').'" /></a>';
	}else if($media_type == AD_Author::linkedin){
		$social_media_content .= '<a href="'.$social_media_id.'" rel="LinkedIn me" id="author-details-linkedin"><img title="'.ad_words('linkedin').'" src="' . $ad_plugin_dir_path . '/images/social_media/linkedin.png" alt="'.ad_words('linkedin').'" /></a>';
	}else if($media_type == AD_Author::flickr){
		$social_media_content .= '<a href="'.$social_media_id.'" rel="Flickr me" id="author-details-flickr"><img title="'.ad_words('flickr').'" src="' . $ad_plugin_dir_path . '/images/social_media/flickr.png" alt="'.ad_words('flickr').'" /></a>';
	}else if($media_type == AD_Author::youtube){
		$social_media_content .= '<a href="'.$social_media_id.'" rel="YouTube me" id="author-details-youtube"><img title="'.ad_words('youtube').'" src="' . $ad_plugin_dir_path . '/images/social_media/youtube.png" alt="'.ad_words('youtube').'" /></a>';
	}else if($media_type == AD_Author::vimeo){
		$social_media_content .= '<a href="'.$social_media_id.'" rel="Vimeo me" id="author-details-vimeo"><img title="'.ad_words('vimeo').'" src="' . $ad_plugin_dir_path . '/images/social_media/vimeo.png" alt="'.ad_words('vimeo').'" /></a>';
	}else if($media_type == AD_Author::skype){
		$social_media_content .= '<a href="'.$social_media_id.'?userinfo" rel="Skype me" id="author-details-skype"><img title="'.ad_words('skype').'" src="' . $ad_plugin_dir_path . '/images/social_media/skype.png" alt="'.ad_words('skype').'" /></a>';
	}else if($media_type == AD_Author::xing){
		$social_media_content .= '<a href="'.$social_media_id.'" rel=" Xing me" id="author-details-xing"><img title="'.ad_words('xing').'" src="' . $ad_plugin_dir_path . '/images/social_media/xing.png" alt="'.ad_words('xing').'" /></a>';
	}
	return $social_media_content;
}
