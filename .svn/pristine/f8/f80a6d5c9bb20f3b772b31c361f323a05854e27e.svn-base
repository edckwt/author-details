<?php
include_once(dirname(__FILE__).'/../includes/includes-master-list.php');
/**
 * Display all Author Details (Wordpress Hook Entry)
 */
function ad_display_all_authors_details_page(){
	$display_text = null;
	if(isset($_GET["action"]) && $_GET["action"]=="delete" && isset($_GET["profile_id"])) {
		global $wpdb;
		$authors_details_database = new AD_Profile_DB($wpdb);
		$profile_id = intval($_GET["profile_id"]);
		
		$authors_details_database->delete_row_by_profile_id($profile_id);
		$display_text = ad_return_message(ad_words('deleted'), ad_words('updated'));
	}
	ad_display_all_authors_details($display_text);
}

function ad_display_all_authors_details($display_text){
	global $wpdb;
	$authors_details_database = new AD_Profile_DB($wpdb);
	?>
	<div class="wrap">
		<div id="icon-users" class="icon32"><br /></div>
		<h2><?php echo ad_words('author_details'); ?> <a href="admin.php?page=<?php echo AD_Config::add_new_author_details_page; ?>" class="add-new-h2"><?php echo ad_words('add'); ?></a></h2>
		<p>&nbsp;</p>
	<?php 
		echo $authors_details_database->insert_from_old_rows();
		echo $display_text;
		$entryResults = $authors_details_database->get_all_rows();
		if($entryResults){
			ad_display_entries_header_and_footer();
			foreach ($entryResults as $singleEntryResult) {
				$profile_id = $singleEntryResult->{AD_Profile_DB::profile_id};
				$username = $singleEntryResult->{AD_Profile_DB::username};
				$first_name = $singleEntryResult->{AD_Profile_DB::first_name};
				$last_name = $singleEntryResult->{AD_Profile_DB::last_name};
				$email = $singleEntryResult->{AD_Profile_DB::email};
				
				$image_size = 40;
				$author_image = get_avatar( $email, $image_size);
					
				echo '<tr>';
				echo '<td>'.$author_image.' '.$username;
				ad_include_row_options($profile_id, $username);
				echo '</td>';
				echo '<td>' . $first_name . '</td>';
				echo '<td>' . $last_name . '</td>';
				echo '<td>' . $email . '</td>';
				echo '</tr>';
			}
			
			ad_display_entries_close_table();
		}else{
			echo '<p>'.ad_words('no_author').' <a href="admin.php?page='.AD_Config::add_new_author_details_page.'">'.ad_words('add_one').'</a></p>';
		}	
		
		ad_update_global_settings();
		echo ad_display_global_settings();
	?>
	</div>
	<?php
		
}

function ad_update_global_settings(){

	if(! isset($_POST["is_form_submitted"])){
		//Form was not submitted.
		return;
	}
	$ad_global_display_on_home_page = NULL;
	if(isset($_POST["ad_global_display_on_home_page"])){
		$ad_global_display_on_home_page = esc_attr($_POST["ad_global_display_on_home_page"]);
	}
	add_option(AD_Config::ad_global_display_on_home_page, $ad_global_display_on_home_page);
	update_option(AD_Config::ad_global_display_on_home_page, $ad_global_display_on_home_page);

	
	$ad_global_display_on_page = NULL;
	if(isset($_POST["ad_global_display_on_page"])){
		$ad_global_display_on_page = esc_attr($_POST["ad_global_display_on_page"]);
	}
	add_option(AD_Config::ad_global_display_on_page, $ad_global_display_on_page);
	update_option(AD_Config::ad_global_display_on_page, $ad_global_display_on_page);
	
	$ad_global_display_on_single_post = NULL;
	if(isset($_POST["ad_global_display_on_single_post"])){
		$ad_global_display_on_single_post = esc_attr($_POST["ad_global_display_on_single_post"]);
	}
	add_option(AD_Config::ad_global_display_on_single_post, $ad_global_display_on_single_post);
	update_option(AD_Config::ad_global_display_on_single_post, $ad_global_display_on_single_post);
	
	$ad_global_display_on_archive_page = NULL;
	if(isset($_POST["ad_global_display_on_archive_page"])){
		$ad_global_display_on_archive_page = esc_attr($_POST["ad_global_display_on_archive_page"]);
	}
	add_option(AD_Config::ad_global_display_on_archive_page, $ad_global_display_on_archive_page);
	update_option(AD_Config::ad_global_display_on_archive_page, $ad_global_display_on_archive_page);
	
	$ad_global_display_on_top = NULL;
	if(isset($_POST["ad_global_display_on_top"])){
		$ad_global_display_on_top = esc_attr($_POST["ad_global_display_on_top"]);
	}
	add_option(AD_Config::ad_global_display_on_top, $ad_global_display_on_top);
	update_option(AD_Config::ad_global_display_on_top, $ad_global_display_on_top);
	
	echo ad_return_message(ad_words('global'), ad_words('updated'));
}

function ad_display_global_settings(){
	
	$ad_global_display_on_home_page = get_option( AD_Config::ad_global_display_on_home_page );		// is_home()
	$ad_global_display_on_page = get_option( AD_Config::ad_global_display_on_page );					// is_page()
	$ad_global_display_on_single_post = get_option( AD_Config::ad_global_display_on_single_post );	// is_single()
	$ad_global_display_on_archive_page = get_option( AD_Config::ad_global_display_on_archive_page );	// is_archive()
	$ad_global_display_on_top = get_option( AD_Config::ad_global_display_on_top );					// is_top()
	?>
	<h3><?php echo ad_words('global_settings'); ?></h3>
		<p><?php echo ad_words('choose'); ?></p>
		<form action="" method="post" id="global-settings">
		<input type="hidden" name="is_form_submitted" value="yes"/>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="ad_global_display_on_home_page"><?php echo ad_words('home_page'); ?></label></th>
					<td><input name="ad_global_display_on_home_page" type="checkbox" id="ad_global_display_on_home_page" <?php if($ad_global_display_on_home_page){ echo "checked"; } ?> /></td>
				</tr>
				<tr>
					<th scope="row"><label for="ad_global_display_on_page"><?php echo ad_words('single_page'); ?></label></th>
					<td><input name="ad_global_display_on_page" type="checkbox" id="ad_global_display_on_page" <?php if($ad_global_display_on_page){ echo "checked"; } ?> /></td>
				</tr>
				<tr>
					<th scope="row"><label for="ad_global_display_on_single_post"><?php echo ad_words('single_post'); ?></label></th>
					<td><input name="ad_global_display_on_single_post" type="checkbox" id="ad_global_display_on_single_post" <?php if($ad_global_display_on_single_post){ echo "checked"; } ?> /></td>
				</tr>
				<tr>
					<th scope="row"><label for="ad_global_display_on_archive_page"><?php echo ad_words('archive_page'); ?></label></th>
					<td><input name="ad_global_display_on_archive_page" type="checkbox" id="ad_global_display_on_archive_page" <?php if($ad_global_display_on_archive_page){ echo "checked"; } ?> /></td>
				</tr>
			</table>
		<br />
		<?php echo ad_words('choose_display_location'); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="ad_global_display_on_top"><?php echo ad_words('top'); ?></label></th>
					<td><input name="ad_global_display_on_top" type="checkbox" id="ad_global_display_on_top" <?php if($ad_global_display_on_top){ echo "checked"; } ?> /></td>
				</tr>
			</table>
		
		<p class="submit">
		<input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php echo ad_words('save_changes'); ?>" />
		</p>
		</form>	
		<?php 
}


function ad_include_row_options($profile_id, $username){
	?>
<div class="row-actions">
	<span><a href="admin.php?page=<?php echo AD_Config::edit_author_details_page; ?>&profile_id=<?php echo $profile_id;?>"><?php echo ad_words('edit'); ?></a>
		|</span> <span><a
		href="admin.php?page=<?php echo AD_Config::display_all_authors_details_page ?>&action=delete&profile_id=<?php echo $profile_id;?>" 
		onclick="return confirm('<?php echo ad_words('confirm'); ?> <?php echo $username; ?>?')"><?php echo ad_words('delete'); ?></a>
	</span>
</div>
<?php
}


function ad_display_entries_header_and_footer(){
	?>
<table class="widefat fixed">
        <thead>
                <tr class="thead">
                        <th scope="col"><?php echo ad_words('username'); ?></th>
                        <th scope="col"><?php echo ad_words('first_name'); ?></th>
                        <th scope="col"><?php echo ad_words('last_name'); ?></th>
                        <th scope="col"><?php echo ad_words('email'); ?></th>
                </tr>
        </thead>
        <tfoot>
                <tr class="thead">
                        <th scope="col"><?php echo ad_words('username'); ?></th>
                        <th scope="col"><?php echo ad_words('first_name'); ?></th>
                        <th scope="col"><?php echo ad_words('last_name'); ?></th>
                        <th scope="col"><?php echo ad_words('email'); ?></th>
                </tr>
        </tfoot>
        <tbody>
        <?php
}

function ad_display_entries_close_table(){
?>
</tbody>
</table>
<?php
}
