<?php
add_action( 'show_user_profile', 'ad_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'ad_show_extra_profile_fields' );

function ad_show_extra_profile_fields( $user ) { 
?>
<h3><?php echo ad_words('social_media'); ?></h3>
<table class="form-table">
	<tr>
		<th><label for="twitter"><?php echo ad_words('twitter'); ?></label></th>
		<td>
			<input name="twitter" type="text" id="twitter" value="<?php echo esc_attr( get_the_author_meta( AD_Author::twitter, $user->ID ) ); ?>" />
		</td>
	</tr>
	<tr>
		<th><label for="facebook"><?php echo ad_words('facebook'); ?></label></th>
		<td>
			<input name="facebook" type="text" id="facebook" value="<?php echo esc_attr( get_the_author_meta( AD_Author::facebook, $user->ID ) ); ?>" />
		</td>
	</tr>
	<tr>
		<th><label for="google_plus"><?php echo ad_words('google_plus'); ?></label></th>
		<td>
			<input name="google_plus" type="text" id="google_plus" value="<?php echo esc_attr( get_the_author_meta( AD_Author::google_plus, $user->ID ) ); ?>" />
		</td>
	</tr>
	<tr>
		<th><label for="linkedin"><?php echo ad_words('linkedin'); ?></label></th>
		<td>
			<input name="linkedin" type="text" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( AD_Author::linkedin, $user->ID ) ); ?>" />
		</td>
	</tr>	
	<tr>
		<th><label for="flickr"><?php echo ad_words('flickr'); ?></label></th>
		<td>
			<input name="flickr" type="text" id="flickr" value="<?php echo esc_attr( get_the_author_meta( AD_Author::flickr, $user->ID ) ); ?>" />
		</td>
	</tr>	
	<tr>
		<th><label for="youtube"><?php echo ad_words('youtube'); ?></label></th>
		<td>
			<input name="youtube" type="text" id="youtube" value="<?php echo esc_attr( get_the_author_meta( AD_Author::youtube, $user->ID ) ); ?>" />
		</td>
	</tr>	
	<tr>
		<th><label for="vimeo"><?php echo ad_words('vimeo'); ?></label></th>
		<td>
			<input name="vimeo" type="text" id="vimeo" value="<?php echo esc_attr( get_the_author_meta( AD_Author::vimeo, $user->ID ) ); ?>" />
		</td>
	</tr>	
	<tr>
		<th><label for="skype"><?php echo ad_words('skype'); ?></label></th>
		<td>
			<input name="skype" type="text" id="skype" value="<?php echo esc_attr( get_the_author_meta( AD_Author::skype, $user->ID ) ); ?>" />
		</td>
	</tr>	
	<tr>
		<th><label for="xing"><?php echo ad_words('xing'); ?></label></th>
		<td>
			<input name="xing" type="text" id="xing" value="<?php echo esc_attr( get_the_author_meta( AD_Author::xing, $user->ID ) ); ?>" />
		</td>
	</tr>	
	<tr>
		<th><label for="disable_about_author"><?php echo ad_words('disable'); ?></label></th>
		<td>
			<input name="disable_about_author" type="checkbox" id="disable_about_author" 
			<?php if( get_the_author_meta( AD_Author::disable_about_author, $user->ID ) ){ echo "checked";} ?>
				/>
			<span class="description"><?php echo ad_words('check'); ?></span>
		</td>
	</tr>
</table>
<?php 
}

add_action( 'personal_options_update', 'ad_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'ad_save_extra_profile_fields' );

function ad_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
	return false;

	/* Save social media information */
	update_user_meta( $user_id, AD_Author::twitter, esc_attr($_POST["twitter"]) );
	update_user_meta( $user_id, AD_Author::facebook, esc_attr($_POST["facebook"]) );
	update_user_meta( $user_id, AD_Author::google_plus, esc_attr($_POST["google_plus"]) );
	update_user_meta( $user_id, AD_Author::linkedin, esc_attr($_POST["linkedin"]) );
	update_user_meta( $user_id, AD_Author::flickr, esc_attr($_POST["flickr"]) );
	update_user_meta( $user_id, AD_Author::youtube, esc_attr($_POST["youtube"]) );
	update_user_meta( $user_id, AD_Author::vimeo, esc_attr($_POST["vimeo"]) );
	update_user_meta( $user_id, AD_Author::skype, esc_attr($_POST["skype"]) );
	update_user_meta( $user_id, AD_Author::xing, esc_attr($_POST["xing"]) );
	
	$disable_about_author = "";
	if(isset($_POST["disable_about_author"])){
		$disable_about_author = esc_attr($_POST["disable_about_author"]);
	}
	update_user_meta( $user_id, AD_Author::disable_about_author, $disable_about_author );
}