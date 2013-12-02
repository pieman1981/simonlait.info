<?php
/**
 * Include the builder class
 */
include('class.ThemeOptionPageBuilder.php');

/**
 * Create a default variable for current option tab
 */
$sl_options_current = '';

/**
 * Create a class instance
 */
$sl_options = new ThemeOptionPageBuilder();

/**
 * Now add tabs (key is the URL parameter, value is the text output on the tab itself)
 */
$sl_options->addTabs( array('home' => 'Home' ,'general' => 'General' ) );

/**
 * Call the construct function to set up the pages
 *
 * @param  String  $form_page_title  Page title for new options page
 * @param  String  $form_menu_title  Menu title for new options page
 * @param  String  $form_menu_capability  Form menu capability
 * @param  String  $form_menu_slug  URL for the new option page
 * @param  Boolean $option_page  Standard theme option page under appearance tab, or a bespoke page
 * @param  Integer $menu_position  Menu position if not a standard theme option page
 */
$sl_options->construct( 'Theme Options', 'Theme Options', 'manage_options', 'theme_options', true, 0 );

/**
 * Find out which tab is selected an save to sl_options_current, default to home (first item of array passed into add tabs)
 */
if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme_options') {
	$sl_options_current = (isset($_GET['tab']) ? $_GET['tab'] : 'home');
}

/**
 * Cautionary clearing of form elements before we build each page
 */
$sl_options->clear_form_element();

/**
 * Now build the options based on what the URL is (home or general in this example)
 */
switch ($sl_options_current) {
	//home option tab
	case 'home':
	default:
		
		/**
		 * Add a settings section to the form
		 *
		 * @param  String  Section ID
		 * @param  String  Section header text
		 */
		$sl_options->add_settings_section('home','Home Page Settings');		
		/**
		 * Create an array of all the options you want the input to have
		 *
		 * Possible Parameters:
		 *
		 * @param  String  type  The type of input (select, text, multi-text, checkbox, textarea, file, radio)
		 * @param  String  id  The id for the input (must be unique)
		 * @param  String  desc  Description text to explain what the input will be used for
		 * @param  String  std  The default value (if select, checkbox or radio) / placeholder text
		 * @param  String class  Class of the input, this will decide what validation occurs (for text fields : numeric, multinumeric, nohtml, url, email. For textareas : inlinehtml, nohtml, allowlinebreaks )
		 * @param  Array choices  For multi-text (Label|ID|Placeholder) select (Option1,Option2), checkbox and radio (Label|Value)
		 * @param  String size  The width of the input
		 */
		$field_args = array( 'type' => 'select', 'id' => 'theme_colour_option', 'desc' =>  'Select a colour theme for your site', 'std' => 'Default', 'class' => '', 'choices' => array('Default','Red','Blue','Yellow','Green') );
		
		/**
		 * Now add the form element to the class 
		 *
		 * @param  String  Label text
		 * @param  Array  Input field arguments
		 */
		$sl_options->add_form_element( 'Select a colour theme:', $field_args);
		
		/**
		 * Text input example
		 */
		$field_args = array( 'type' => 'text', 'id' => 'teaser_option', 'desc' => 'Teaser text to display on the homepage', 'std' => 'Teaser text', 'class' => '');
		$sl_options->add_form_element( 'Enter homepage teaser text:', $field_args);
		
		/**
		 * Multi-text input example
		 *
		 * Choices => Label|ID|Placeholder
		 */
		$field_args = array( 'type' => 'multi-text', 'id' => 'people_names_option', 'choices' => array('Person 1|p1|Jo Smith','Person 2|p2|John Jones'), 'desc' =>  'Enter the name of two people here', 'size' => '40', 'std' => '', 'class' => '');
		$sl_options->add_form_element( 'Enter FIRST names only:', $field_args);
		
		/**
		 * Textarea input example
		 */
		$field_args = array( 'type' => 'textarea', 'id' => 'analytics_option', 'desc' => 'Enter Google Analytic tracking code here', 'std' => '', 'class' => '');
		$sl_options->add_form_element( 'Tracking code:', $field_args);
		
		/**
		 * Checkbox input example
		 *
		 * Choices => Label|Value
		 */
		$field_args = array( 'type' => 'checkbox', 'id' => 'show_posts_option', 'desc' => 'Show latest posts on your homepage', 'std' => 'show', 'class' => '', 'choices' => array('Show|show') );
		$sl_options->add_form_element( 'Show latest posts:', $field_args);
		
		/**
		 * Radio input example
		 *
		 * Choices => Label|Value
		 */
		$field_args = array( 'type' => 'radio', 'id' => 'number_posts_option', 'desc' => 'Decide on the number of posts to show', 'std' => 'show', 'class' => '', 'choices' => array('5|show5','10|show10','20|show20') );
		$sl_options->add_form_element( 'Number of posts to show:', $field_args);
		
		/**
		 * File input example
		 */
		$field_args = array( 'type' => 'file', 'id' => 'upload_file_option', 'desc' => 'Upload an image (recommended:500px x 250px, .jpg file format)', 'std' => '', 'class' => '');
		$sl_options->add_form_element( 'Upload image:', $field_args);
	
		break;

	//general option tab
	case 'general':
	
		//add a settings section to the form
		$sl_options->add_settings_section('general','General Site Settings');
		
		//now lets add the form inputs
		$field_args = array( 'type' => 'radio', 'id' => 'text_colour_option', 'desc' => 'Decide on the colour of text on the site', 'std' => 'black', 'class' => '', 'choices' => array('Black|#000','White|#fff') );
		$sl_options->add_form_element( 'Text colour on the site:', $field_args);
		
		break;
}

/**
 * Now create the options pages / sections / form
 */
$sl_options->create_options_form();
?>