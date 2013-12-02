<?php
/**
 * Class to create option pages
 *
 * This class is developed to make adding theme option pages to a theme simple
 * 
 * @copyright 2013 Simon Lait
 * @version Release 1.0
 * @link https://github.com/pieman1981/simonlait.info/tree/master/wordpress%20-%20theme%20option%20page%20builder
 * @since Class available since Release 1.0
 */
class ThemeOptionPageBuilder {
	
	/* Menu Builder */
	private $form_page_title = '';
	private $form_menu_title = '';
	private $form_menu_capability = '';
	private $form_menu_slug = '';
	
	/* Option Builder */
	public $options_name = '';
	public $settings_sections_name = '';
	
	/** Section Options */
	private $section_id = '';
	private $section_para_text = '';
	private $setting_sections = array();

	/* Field Options */
	private $settings_fields = array();
	
	public $files_uploaded = array();
	
	/* Defaults for input fields */
	private $defaults = array(  
        'id'      => 'default_field',                   // the ID of the setting in our options array, and the ID of the HTML form element  
        'title'   => 'Default Field',                   // the label for the HTML form element  
        'desc'    => '',  															// the description displayed under the HTML form element  
        'std'     => '',                                // the default value for this setting  
        'type'    => 'text',                            // the HTML form element to use  
        'choices' => array(),                           // (optional): the values in radio buttons or a drop-down menu  
        'class'   => '',																// the HTML form element class. Also used for validation purposes!  
				'size'    => '30'																// width of inputs
    );  
	
	private $tabs;
	
	/**
	 * Add tabs to the option page
	 *
	 * @param  Array  $tabs  An array of tabs. Key is tab URL, value is tab text
	 */
	public function addTabs( $tabs = array() ) {
		$this->tabs = $tabs;
	}
	
	/**
	 * Clear all form elements / setting sections before building the page
	 */
	public function clear_form_element() {
		unset($this->setting_sections);
		unset($this->settings_fields);
		$this->setting_sections = array();
		$this->settings_fields = array();
	}
	
	/**
	 * Construct function to create the menu item details
	 *
	 * @param  String  $form_page_title  Page title for new options page
	 * @param  String  $form_menu_title  Menu title for new options page
	 * @param  String  $form_menu_capability  Form menu capability
	 * @param  String  $form_menu_slug  URL for the new option page
	 * @param  Boolean $option_page  Standard theme option page under appearance tab, or a bespoke page
	 * @param  Integer $menu_position  Menu position if not a standard theme option page
	 */
	public function construct($form_page_title='',$form_menu_title='',$form_menu_capability='',$form_menu_slug='', $option_page = true, $menu_position = 0) {
		$this->form_page_title = $form_page_title;
		$this->form_menu_title = $form_menu_title;
		$this->form_menu_capability = $form_menu_capability;
		$this->form_menu_slug = $form_menu_slug;
		$this->option_page = $option_page;
		$this->menu_position = $menu_position;
		
		add_action( 'admin_menu', array( $this, 'create_options_menu' ) );
	}
	
	/**
	 *  Create the item on the admin navigation (appearance menu or bespoke menu)
	 */
	public function create_options_menu() {
		if ($this->option_page) {
			add_theme_page( $this->form_page_title,	//Page title
						$this->form_menu_title, //Menu title
						$this->form_menu_capability, //Capability
						$this->form_menu_slug, //Slug
						array( $this, 'output_options_page' )
					);
		}
		else {
			add_menu_page( $this->form_page_title, //Page title
					$this->form_menu_title, //Menu title
					$this->form_menu_capability, //Capability
					$this->form_menu_slug, //Slug
					array( $this, 'output_options_page' ),
					'',
					$this->menu_position
				);
		
		}
	}
	
	/**
	 *  Create the HTML for the options page
	 */
	public function output_options_page() {
	?>
		<div class="wrap">
			<?php $tabs = $this->tabs; ?>
			<h2>Theme Settings</h2>
			<div id="icon-themes" class="icon32"></div>
			<h2>
			<?php
				$current = (isset($_GET['tab']) ? $_GET['tab'] : key($tabs));
				foreach ( $tabs as $tab => $name ) {
					$class = ( $current == $tab ? ' nav-tab-active' : '' );
					echo "<a class='nav-tab$class' href='?page=$this->form_menu_slug&tab=$tab'>$name</a>";
				}
			?>
			</h2>
			<p>Take control of your theme by overriding the default settings with your own preferences.</p>
			<form action="options.php?tab=<?php echo $current ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="page" value="<?php echo $this->form_menu_slug ?>" />
			<?php
				settings_errors();
				settings_fields($this->options_name);
				do_settings_sections($this->settings_sections_name);
				submit_button();
			?>
			</form>
		</div>
	<?php
	}
	
	/**
	 *  Add a settings section to the options page
	 *
	 * @param  String  $set_tab_id  Settings Tab ID
	 * @param  String  $section_header_text  Head text for the section
	 * @param  String  $section_para_text  Paragraph text for the section
	 */
	public function add_settings_section( $set_tab_id = '', $section_header_text = '', $section_para_text = '' ) {
		$section_options = array( 'header' => $section_header_text, 'para' => $section_para_text );
		$this->options_name = $set_tab_id . '_theme_options';
		$this->settings_sections_name = $tab_id . '_settings_options';
		$this->setting_sections[$this->settings_sections_name] = $section_options;
	}
	
	/**
	 *  Redundant, can't find a way to make this work
	 */
	public function show_section_text() {
		echo '<p></p>';
	}
	
	/**
	 *  Add a form element to a settings section
	 *
	 * @param  String  $ele_label  Label text
	 * @param  Array  $args  An array of options relating to the input field
	 */
	public function add_form_element( $ele_label = '', $args = array() ) {
		$ele_options = array( 'label' => $ele_label, 'args' => $args);
		if ( isset($args['id']) ) {
			$this->settings_fields[$args['id']] = $ele_options;
		}
	}
	
	/**
	 *  Show an input field on the options page
	 *
	 * @param  Array  $args  An array of options relating to the input field
	 */
	function show_section_form( $args ) {
		extract( wp_parse_args( $args, $this->defaults ));  
		$options = get_option( $this->options_name );
		$field_class = ($class != '') ? ' ' . $class : ''; 
		$default = ($options[$id] ? $options[$id] : '' );
		$placeholder = ($std ? $std : '' );
		
		switch ( $type ) {  
			case 'file': //show file input type
				echo "<input class='regular-text$field_class' type='file' id='$id' name='$id' value='$default' />";  
				echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
				echo ($default != '') ? "<br /><img src='$default' class='image-100'/>" : "";
			break;
			
			case 'text':  //show text input type
				$default = stripslashes( $default );  
				$default = esc_attr( $default );  
				echo "<input size='$size' class='regular-text$field_class' type='text' id='$id' name='" . $this->options_name . "[$id]' placeholder='$placeholder' value='$default' />";  
				echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
			break;  
			
			case 'multi-text':  //show multi text input type
				foreach($choices as $item) {  
					$item = explode("|",$item); // Label|ID|Placehoder
					$item[0] = esc_html($item[0]);  
					$value = '';
					if (!empty($options[$id])) {  
						foreach ($options[$id] as $option_key => $option_val){  
							if ($item[1] == $option_key) {  
								$value = $option_val;  
							}  
						}  
					} 
					$placeholder = (isset($item[2]) ? $item[2] : ''); 
					echo "<span class='multi-span'>$item[0]:</span> <input size='$size' class='$field_class' type='text' id='$id|$item[1]' name='" . $this->options_name . "[$id][$item[1]]' placeholder='$placeholder' value='$value' /><br/>";  
				}  
				echo ($desc != '') ? "<span class='description'>$desc</span>" : "";  
			break;  
			
			case 'textarea':  //show textarea input type
				$options[$id] = stripslashes($options[$id]);  
				$options[$id] = esc_html( $options[$id]);  
				echo "<textarea class='textarea$field_class' type='text' id='$id' name='" . $this->options_name . "[$id]' rows='5' cols='30' placeholder='$placeholder'>$default</textarea>";  
				echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";           
			break;  
			
			case 'select':  //show select input type
				echo "<select id='$id' class='select$field_class' name='" . $this->options_name . "[$id]'>";  
					foreach($choices as $item) {  
						$value  = esc_attr($item);  
						$item   = esc_html($item);  
						  
						$selected = ($default==$value) ? 'selected="selected"' : '';  
						echo "<option value='$value' $selected>$item</option>";  
					}  
				echo "</select>";  
				echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";   
			break; 
			
			case 'checkbox': //show checkbox input type
				foreach($choices as $item) {  
					$itemEx = explode("|",$item);  //label|value
					$item = esc_html($itemEx[0]);  
					$value = esc_attr($itemEx[1]); 				
					$checked = '';  
					if ( isset($options[$id][$value]) ) {  
						if ( $options[$id][$value] == 1) {  
							$checked = 'checked="checked"';  
						}  
					} else {
						if ( $value == $default ) {
							$checked = 'checked="checked"';  
						}
					}
					  
					echo "<input class='checkbox$field_class' type='checkbox' id='$id|$value' name='" . $this->options_name . "[$id][$value]' value='1' $checked /> $item <br/>";  
				}  
				echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
			break;  
			
			case 'radio': //show radio input type
				foreach($choices as $item) {  
					$itemEx = explode("|",$item);  //label|value
					$item = esc_html($itemEx[0]);  
					$value = esc_attr($itemEx[1]); 				
					$checked = '';  
					  
					if ( isset($default) ) {  
						if ( $default == $value) {  
							$checked = 'checked="checked"';  
						}  
					}  
					echo "<input class='checkbox$field_class' type='radio' id='$id|$value' name='" . $this->options_name . "[$id]' value='$value' $checked /> $item <br/>";  
				}  
				echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";
			break;  
		}
	}
	
	/**
	 *  Create the option page form
	 */
	public function create_options_form() {
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'after_setup_theme', array( $this, 'create_file_options' ) );
	}
	
	/**
	 *  Fix for problems with file input types
	 */
	public function create_file_options() {
		if ( sizeof ( $this->settings_fields) ) { 
			$add_options = array();
			$options = get_option( $this->options_name );
			foreach ( $this->settings_fields as $ele_id => $settings_field) {
				if ( !isset($options[$ele_id]) ) {
					$add_options[$ele_id] = '';
				}
			}
			add_option( $this->options_name, $add_options );
		};
	}
	
	/**
	 *  Loop over each tab and register the settings, add the sections, and add form elements
	 */
	public function register_settings() {
		foreach ($this->tabs as $name => $tab) {
			$tab_name = $name . '_theme_options';
			register_setting( 
				$tab_name, //setting group name
				$tab_name, //option name for get_option
				array( $this, 'form_validate_options' ) //callback
			);
		}
		
		//add sections
		if ( sizeof ( $this->setting_sections) ) {
			foreach ( $this->setting_sections as $section_id => $setting_section) {
				$this->section_para_text = $setting_section['para'];
				add_settings_section(
					$section_id, // html id for section
					$setting_section['header'], //section text inside h3
					array( $this, 'show_section_text' ),
					$this->settings_sections_name
				);
			}
		}
		
		//add form elements
		if ( sizeof ( $this->settings_fields) ) { 
			foreach ( $this->settings_fields as $ele_id => $settings_field) {
				add_settings_field(
					$ele_id, //html id for setting
					$settings_field['label'], // text printed next to field
					array( $this, 'show_section_form' ), // callback function to echo field
					$this->settings_sections_name, // settings page to show
					$this->settings_sections_name,// settings section
					$settings_field['args']// args
				);
			}
		};
	}
	
	/**
	 *  Validate inputs ready to save in db
	 *
	 * @param  Array  $input  All raw input values submitted 
	 * @returns Array $valid_input An array of valid value after being validated
	 */
	function form_validate_options ( $input ) {
		$valid_input = array();
		$field_elements = $this->settings_fields;
		$set_options = get_option( $this->options_name );
		foreach ( $field_elements as $field_id => $option) {
			if (!isset($set_options[$option['args']['id']])) {
				$set_options[$option['args']['id']] = '';
			}
			switch ( $option['args']['type'] ) { 
				case 'file': 
					$file_url = array();
					$image = $_FILES[$option['args']['id']];
					//we have found the image we are trying to upload
					if ($image['size'] && $image['name']) {
						//check image type
						if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) && $image['error'] == 0 ){
							$override = array('test_form' => false); 
							$file = wp_handle_upload( $image, $override );
							if ($file) {
								 $valid_input[$option['args']['id']] = esc_url_raw(trim($file['url']));
							}
						}
						else {
							add_settings_error(  
								$option['args']['id'], // setting title  
								$this->options_name . '_txt_numeric_error', // error ID  
								'Wrong file type. Please use a jpg, jpeg, png or gif.', // error message  
								'error' // type of message  
							);  
						}
					}
					break;
					
				case 'text':  
					//switch validation based on the class!  
					switch ( $option['args']['class'] ) {  
							//for numeric   
							case 'numeric':  
									//accept the input only when numeric!  
									$input[$option['args']['id']]       = trim($input[$option['args']['id']]); // trim whitespace  
									$valid_input[$option['args']['id']] = (is_numeric($input[$option['args']['id']])) ? $input[$option['args']['id']] : $set_options[$option['args']['id']];  
										
									// register error  
									if(is_numeric($input[$option['args']['id']]) == FALSE) {  
											add_settings_error(  
													$option['args']['id'], // setting title  
													$this->options_name . '_txt_numeric_error', // error ID  
													'Expecting a Numeric value! Please fix.', // error message  
													'error' // type of message  
											);  
									}  
							break;  
								
							//for multi-numeric values (separated by a comma)  
							case 'multinumeric':  
									//accept the input only when the numeric values are comma separated  
									$input[$option['args']['id']]       = trim($input[$option['args']['id']]); // trim whitespace  
										
									if($input[$option['args']['id']] !=''){  
											// /^-?\d+(?:,\s?-?\d+)*$/ matches: -1 | 1 | -12,-23 | 12,23 | -123, -234 | 123, 234  | etc.  
											$valid_input[$option['args']['id']] = (preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['args']['id']]) == 1) ? $input[$option['args']['id']] : $set_options[$option['args']['id']];  
									}else{  
											$valid_input[$option['args']['id']] = $input[$option['args']['id']];  
									}  
										
									// register error  
									if($input[$option['args']['id']] !='' && preg_match('/^-?\d+(?:,\s?-?\d+)*$/', $input[$option['args']['id']]) != 1) {  
											add_settings_error(  
													$option['args']['id'], // setting title  
													$this->options_name . '_txt_multinumeric_error', // error ID  
													'Expecting comma separated numeric values! Please fix.', // error message  
													'error' // type of message  
											);  
									}  
							break;  
								
							//for no html  
							case 'nohtml':  
									//accept the input only after stripping out all html, extra white space etc!  
									$input[$option['args']['id']]       = sanitize_text_field($input[$option['args']['id']]); // need to add slashes still before sending to the database  
									$valid_input[$option['args']['id']] = addslashes($input[$option['args']['id']]);  
							break;  
								
							//for url  
							case 'url':  
									//accept the input only when the url has been sanited for database usage with esc_url_raw()  
									$input[$option['args']['id']]       = trim($input[$option['args']['id']]); // trim whitespace  
									$valid_input[$option['args']['id']] = esc_url_raw($input[$option['args']['id']]);  
							break;  
								
							//for email  
							case 'email':  
									//accept the input only after the email has been validated  
									$input[$option['args']['id']]       = trim($input[$option['args']['id']]); // trim whitespace  
									if($input[$option['args']['id']] != ''){  
											$valid_input[$option['args']['id']] = (is_email($input[$option['args']['id']])!== FALSE) ? $input[$option['args']['id']] : $set_options[$option['args']['id']];  
									}elseif($input[$option['args']['id']] == ''){  
											$valid_input[$option['args']['id']] = $set_options[$option['args']['id']];  
									}  
										
									// register error  
									if (is_email($input[$option['args']['id']])== FALSE || $input[$option['args']['id']] == '') {  
											add_settings_error(  
													$option['args']['id'], // setting title  
													$this->options_name . '_txt_email_error', // error ID  
													'Please enter a valid email address.', // error message  
													'error' // type of message  
											);  
									}  
							break;  
								
							// a "cover-all" fall-back when the class argument is not set  
							default:  
									// accept only a few inline html elements  
									$allowed_html = array(  
											'a' => array('href' => array (),'title' => array ()),  
											'b' => array(),  
											'em' => array (),   
											'i' => array (),  
											'strong' => array()  
									);  
										
									$input[$option['args']['id']]       = trim($input[$option['args']['id']]); // trim whitespace  
									$input[$option['args']['id']]       = force_balance_tags($input[$option['args']['id']]); // find incorrectly nested or missing closing tags and fix markup  
									$input[$option['args']['id']]       = wp_kses( $input[$option['args']['id']], $allowed_html); // need to add slashes still before sending to the database  
									$valid_input[$option['args']['id']] = addslashes($input[$option['args']['id']]);   
							break;  
           }  
        break;  
                  
				case "multi-text": 
						unset($textarray);  
						unset($text_values);
						$text_values = array();  
						foreach ($option['args']['choices'] as $ev ) {  
								// explode the connective  
								$pieces = explode("|", $ev);  
									
								$text_values[] = $pieces[1];  
						}  
						foreach ($text_values as $v ) {   
								// Check that the option isn't empty  
								if ( $input[$option['args']['id']][$v] ) { 
										// If it's not null, make sure it's sanitized, add it to an array 
										switch ($option['args']['class']) { 
												// different sanitation actions based on the class create you own cases as you need them 
												//for numeric input 
												case 'numeric': 
														//accept the input only if is numberic! 
														$input[$option['args']['id']][$v] = trim( $input[$option['args']['id']][$v] ); // trim whitespace 
														$input[$option['args']['id']][$v]= (is_numeric( $input[$option['args']['id']][$v] )) ? $input[$option['args']['id']][$v] : ''; 
												break; 
												 
												// a "cover-all" fall-back when the class argument is not set 
												default: 
														// strip all html tags and white-space. 
													 $input[$option['args']['id']][$v] = sanitize_text_field($input[$option['args']['id']][$v]); // need to add slashes still before sending to the database 
													 $input[$option['args']['id']][$v] = addslashes($input[$option['args']['id']][$v]); 
												break; 
										} 
							
										$valid_input[$option['args']['id']][$v] = $input[$option['args']['id']][$v];
                }
								else {
									$valid_input[$option['args']['id']][$v] = '';
								}
            } 
          break; 
                 
					case 'textarea': 
							//switch validation based on the class! 
							switch ( $option['args']['class'] ) { 
									//for only inline html 
									case 'inlinehtml': 
											// accept only inline html 
											$input[$option['args']['id']]       = trim($input[$option['args']['id']]); // trim whitespace 
											$input[$option['args']['id']]       = force_balance_tags($input[$option['args']['id']]); // find incorrectly nested or missing closing tags and fix markup 
											$input[$option['args']['id']]       = addslashes($input[$option['args']['id']]); //wp_filter_kses expects content to be escaped! 
											$valid_input[$option['args']['id']] = wp_filter_kses($input[$option['args']['id']]); //calls stripslashes then addslashes 
									break; 
									 
									//for no html 
									case 'nohtml': 
											//accept the input only after stripping out all html, extra white space etc! 
											$input[$option['args']['id']]       = sanitize_text_field($input[$option['args']['id']]); // need to add slashes still before sending to the database 
											$valid_input[$option['args']['id']] = addslashes($input[$option['args']['id']]); 
									break; 
									 
									//for allowlinebreaks 
									case 'allowlinebreaks': 
											//accept the input only after stripping out all html, extra white space etc! 
											$input[$option['args']['id']]       = wp_strip_all_tags($input[$option['args']['id']]); // need to add slashes still before sending to the database 
											$valid_input[$option['args']['id']] = addslashes($input[$option['args']['id']]); 
									break; 
									 
									// a "cover-all" fall-back when the class argument is not set 
									default: 
											// accept only limited html 
											//my allowed html 
											$allowed_html = array( 
													'a'             => array('href' => array (),'title' => array ()), 
													'b'             => array(), 
													'blockquote'    => array('cite' => array ()), 
													'br'            => array(), 
													'dd'            => array(), 
													'dl'            => array(), 
													'dt'            => array(), 
													'em'            => array (),  
													'i'             => array (), 
													'li'            => array(), 
													'ol'            => array(), 
													'p'             => array(), 
													'q'             => array('cite' => array ()), 
													'strong'        => array(), 
													'ul'            => array(), 
													'h1'            => array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()), 
													'h2'            => array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()), 
													'h3'            => array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()), 
													'h4'            => array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()), 
													'h5'            => array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()), 
													'h6'            => array('align' => array (),'class' => array (),'id' => array (), 'style' => array ()) 
											); 
											 
											$input[$option['args']['id']]       = trim($input[$option['args']['id']]); // trim whitespace 
											$input[$option['args']['id']]       = force_balance_tags($input[$option['args']['id']]); // find incorrectly nested or missing closing tags and fix markup 
											$input[$option['args']['id']]       = wp_kses( $input[$option['args']['id']], $allowed_html); // need to add slashes still before sending to the database 
											$valid_input[$option['args']['id']] = addslashes($input[$option['args']['id']]);                             
									break; 
							} 
					break; 
					 
					case 'select': 
							// check to see if the selected value is in our approved array of values! 
							$valid_input[$option['args']['id']] = (in_array( $input[$option['args']['id']], $option['args']['choices']) ? $input[$option['args']['id']] : '' ); 
					break; 
                    
          case 'checkbox':  
							unset($checkboxarray);
							unset($check_values);
					
							$check_values = array();  
							foreach ($option['args']['choices'] as $vh ) {  
									// explode the connective  
									$pieces = explode("|", $vh);  	
									$check_values[] = $pieces[1];  
							}  
							foreach ($check_values as $v ) {           
									// Check that the option isn't null  
									if (!empty($input[$option['args']['id']][$v])) { 
											// If it's not null, make sure it's true, add it to an array 
											$valid_input[$option['args']['id']][$v] = 1; 
									} 
									else { 
										 $valid_input[$option['args']['id']][$v] = 0; 
									} 
							} 
					break;  
				
					case 'radio':  
							$check_values = array();  
							foreach ($option['args']['choices'] as $k => $v ) {  
									// explode the connective  
									$pieces = explode("|", $v);  
										
									$check_values[] = $pieces[1];  
							}  	
							foreach ($check_values as $v ) {          
										
									// Check that the option isn't null  
									if ($input[$option['args']['id']] == $v) { 
											// If it's not null, make sure it's true, add it to an array 
										 $valid_input[$option['args']['id']] = $v;  
									} 
							 
							} 
          break;  
			}			
		}
		
		//finally check for files that were previously uploaded that we don't want to loose
		$valid_input = wp_parse_args( $valid_input, $set_options );

		return $valid_input;
	}	
}
?>