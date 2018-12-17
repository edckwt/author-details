<?php
/**
 * Stores the profile information
 *
*/
Class AD_Profile_DB{
	//This might not be the actual table name if wordpress adds a prefix to it.
	const table_name = 'author_details_db';
	const db_version_number = 1.0;
	
	//Column names
	const profile_id = "profile_id";
	const username = "username";
	const first_name = "first_name";
	const last_name = "last_name";
	const email = "email";
	const url = "url";
	const description = "description";
	const twitter = "twitter";
	const facebook = "facebook";
	const google_plus = "google_plus";
	const linkedin = "linkedin";
	const display_html_block = "display_html_block";	//Y/N
	const html_block = "html_block";
	const use_custom_image = "use_custom_image";	// Y/N
	const custom_image_url = "custom_image_url";
	const flickr = "flickr";
	const youtube = "youtube";
	const vimeo = "vimeo";
	const skype = "skype";
	const xing = "xing";
	
	public $wpdb;
	public $full_table_name;	
	
	function __construct( $wpdb ) {
		$this->wpdb = $wpdb;
		$this->full_table_name = $this->get_table_name();
	}
	
	public function get_table_name() {
		return $this->wpdb->prefix . self::table_name;
	}
		
	function create_table(){
		if(!$this->does_table_exist()) {
			$sql = "CREATE TABLE " . $this->full_table_name . " (
			profile_id mediumint(9) NOT NULL AUTO_INCREMENT,
			username VARCHAR(90),
			first_name VARCHAR(90),
			last_name VARCHAR(90),
			email VARCHAR(90),
			url VARCHAR(200),
			description VARCHAR(2000),
			twitter VARCHAR(250),
			facebook VARCHAR(250),
			google_plus VARCHAR(250),
			linkedin VARCHAR(250),
			flickr VARCHAR(250),
			youtube VARCHAR(250),
			vimeo VARCHAR(250),
			skype VARCHAR(230),
			xing VARCHAR(250),			
			use_custom_image VARCHAR(5),
			custom_image_url VARCHAR(200),
			display_html_block VARCHAR(5),
			html_block VARCHAR(2000),
				  	  UNIQUE KEY id (profile_id)			
							);";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
			$this->register_db_version();
			
			add_option(AD_Config::ad_global_display_on_single_post, "on");
		}		
	}
	
	public function does_table_exist() {
		return $this->wpdb->get_var("show tables like '$this->full_table_name'") == $this->full_table_name;
	}
	
	private function update_db_version() {
		update_option($this->full_table_name . "_db_version", self::db_version_number);
	}
	
	private function register_db_version() {
		add_option($this->full_table_name . "_db_version", self::db_version_number);
	}
	
	function insert_from_old_rows(){
		$table_name = $this->wpdb->prefix.'caa_profile_db';
		if($this->wpdb->get_var("show tables like '$table_name'") == $table_name){
			$users = $this->wpdb->get_results("SELECT * FROM $table_name");
			if( $users ){
				$code = '';
				foreach ( $users as $user ){
					$profile_id = $user->profile_id;
					$username = $user->username;
					
					$data_values = array( 
						'username' => $user->username,
						'first_name' => $user->first_name,
						'last_name' => $user->last_name,
						'email' => $user->email,
						'url' => $user->url,
						'description' => $user->description,
						'twitter' => $user->twitter,
						'facebook' => $user->facebook,
						'google_plus' => $user->google_plus,
						'linkedin' => $user->linkedin,
						'flickr' => $user->flickr,
						'youtube' => $user->youtube,
						'vimeo' => $user->vimeo,
						'skype' => $user->skype,
						'xing' => $user->xing,
						'use_custom_image' => $user->use_custom_image,
						'custom_image_url' => $user->custom_image_url,
						'display_html_block' => $user->display_html_block,
						'html_block' => $user->html_block
					);
					
					$user_count = $this->wpdb->get_var( "SELECT COUNT(*) FROM $this->full_table_name WHERE username='".$username."'" );
					if($user_count == 0){
						$this->wpdb->insert( $this->full_table_name, $data_values );
						if($this->wpdb->show_errors()){
							$code .= '<p>Added user <strong>'.$username.'</strong></p>';
						}else{
							$code .= '<p>Not added user <strong>'.$username.'</strong></p>';
						}
					}else{
						//$code .= '<p><u>'.$username.'</u></p>';
						$code .= '';
					}
				}
			}else{
				//$code = '<h2>Not found users.</h2>';
				$code = '';
			}
		}else{
			//$code = '<h2>Table <u><strong>'.$table_name.'</strong></u> not found.</h2>';
			$code = '';
		}
		return $code;
	}
		
	function get_all_rows(){
		return $this->wpdb->get_results("SELECT * FROM ".$this->full_table_name." ORDER BY username");
	}
	
	function get_row_by_id($profile_id){
		return $this->wpdb->get_row("SELECT * FROM ".$this->full_table_name." WHERE profile_id = '" . $profile_id . "' ORDER BY username");
	}
	
	function get_row_by_username($username){
		return $this->wpdb->get_row("SELECT * FROM ".$this->full_table_name." WHERE username = '" . $username . "' ORDER BY username");
	}
	
	function create_new_row($data=''){
		if(isset($data) && is_array($data)){
			$data_values = array( 
				'username' => $data['username'],
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'email' => $data['email'],
				'url' => $data['url'],
				'description' => $data['description'],
				'twitter' => $data['twitter'],
				'facebook' => $data['facebook'],
				'google_plus' => $data['google_plus'],
				'linkedin' => $data['linkedin'],
				'flickr' => $data['flickr'],
				'youtube' => $data['youtube'],
				'vimeo' => $data['vimeo'],
				'skype' => $data['skype'],
				'xing' => $data['xing'],
				'use_custom_image' => $data['use_custom_image'],
				'custom_image_url' => $data['custom_image_url'],
				'display_html_block' => $data['display_html_block'],
				'html_block' => $data['html_block']
			);

			$this->wpdb->show_errors();
			$rows_affected = $this->wpdb->insert( $this->full_table_name, $data_values );
			$this->wpdb->hide_errors();
			return $this->wpdb->insert_id;
		}else{
			return '<div id="message" class="error"><p>Not Added!</p></div>';
		}
	}

	function edit_row($data=''){
		if(isset($data) && is_array($data)){
			$data_update = array( 
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'email' => $data['email'],
				'url' => $data['url'],
				'description' => $data['description'],
				'twitter' => $data['twitter'],
				'facebook' => $data['facebook'],
				'google_plus' => $data['google_plus'],
				'linkedin' => $data['linkedin'],
				'flickr' => $data['flickr'],
				'youtube' => $data['youtube'],
				'vimeo' => $data['vimeo'],
				'skype' => $data['skype'],
				'xing' => $data['xing'],
				'use_custom_image' => $data['use_custom_image'],
				'custom_image_url' => $data['custom_image_url'],
				'display_html_block' => $data['display_html_block'],
				'html_block' => $data['html_block']
			);

			$data_where = array('profile_id' => $data['profile_id']);
			$this->wpdb->show_errors();
			$this->create_table(); //Does nothing if table exists. Otherwise prints error message on why table cannot be created.
		
			//update table. returns false if errors
			$this->wpdb->update($this->full_table_name, $data_update, $data_where);		
			$this->wpdb->hide_errors();
		}else{
			return '<div id="message" class="error"><p>Not Update!</p></div>';
		}
	}
	
	function delete_row_by_profile_id($profile_id){
		$this->wpdb->show_errors();
		$this->wpdb->query( $this->wpdb->prepare("DELETE FROM $this->full_table_name WHERE profile_id=%d", array($profile_id)) );	
		$this->wpdb->hide_errors();
	}
}