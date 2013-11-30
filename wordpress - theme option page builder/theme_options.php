<?php
//include the builder class
include('class.ThemeOptionPageBuilder.php');

//create a default variable for current option tab
$sl_options_current = '';

//create a class instance
$sl_options = new ThemeOptionPageBuilder();

//now add tabs (key is the url parameter, value is the text output on the tab itself)
$sl_options->addTabs( array('home' => 'Home' ,'general' => 'General' ) );

//call the construct function to set up the pages
//parameters : page title, menu title, form menu capability, form menu slug, theme option page?, menu position (if not theme option page)
$sl_options->construct( 'Theme Options', 'Theme Options', 'manage_options', 'theme_options', true, 0 );

//find out which tab is selected an save to sl_options_current, default to home (first item of array passed into add tabs)
if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'theme_options') {
	$sl_options_current = (isset($_GET['tab']) ? $_GET['tab'] : 'home');
}

//cautionary clearing of form elements before we build each page
$sl_options->clear_form_element();

// how build the options based on what the url is (home or general in this example)
switch ($sl_options_current) {
	//home option tab
	case 'home':
	default:
		
		//add a settings section to the form
		//parameters : section id, section header text
		$sl_options->add_settings_section('home','Home Page Settings');
	
		//now lets add the form inputs
		
		//create an array of all the options you want the input to have
		//possible parameters
		//type => the type of input (select, text, multi-text, checkbox, textarea, file, radio)
		//id => the id for the input (must be unique)
		//desc => description text to explain what the input will be used for
		//std => the default value (if select, checkbox or radio) / placeholder text
		//class => class of the input, this will decide what validation occurs (for text fields : numeric, multinumeric, nohtml, url, email. For textareas : inlinehtml, nohtml, allowlinebreaks )
		//choices => for select, checkbox and radio
		//size => the width of your input
		$field_args = array( 'type' => 'select', 'id' => 'theme_colour_option', 'desc' =>  'Select a colour theme for your site', 'std' => 'Default', 'class' => '', 'choices' => array('Default','Red','Blue','Yellow','Green') );
		//now add the form element to the class 
		//parameters : label text, field_args array
		$sl_options->add_form_element( 'Select a colour theme:', $field_args);
		
		//text example
		$field_args = array( 'type' => 'text', 'id' => 'teaser_option', 'desc' => 'Teaser text to display on the homepage', 'std' => 'Teaser text', 'class' => '');
		$sl_options->add_form_element( 'Enter homepage teaser text:', $field_args);
		
		//multi-text example
		//choices => cat_name|cat_slug|Placeholder
		$field_args = array( 'type' => 'multi-text', 'id' => 'people_names_option', 'choices' => array('Person 1|p1|Jo Smith','Person 2|p2|John Jones'), 'desc' =>  'Enter the name of two people here', 'size' => '40', 'std' => '', 'class' => '');
		$sl_options->add_form_element( 'Enter FIRST names only:', $field_args);
		
		//textarea example
		$field_args = array( 'type' => 'textarea', 'id' => 'analytics_option', 'desc' => 'Enter Google Analytic tracking code here', 'std' => '', 'class' => '');
		$sl_options->add_form_element( 'Tracking code:', $field_args);
		
		//checkbox example
		//choices => label|value
		$field_args = array( 'type' => 'checkbox', 'id' => 'show_posts_option', 'desc' => 'Show latest posts on your homepage', 'std' => 'show', 'class' => '', 'choices' => array('Show|show') );
		$sl_options->add_form_element( 'Show latest posts:', $field_args);
		
		//radio example
		//choices => label|value
		$field_args = array( 'type' => 'radio', 'id' => 'number_posts_option', 'desc' => 'Decide on the number of posts to show', 'std' => 'show', 'class' => '', 'choices' => array('5|show5','10|show10','20|show20') );
		$sl_options->add_form_element( 'Number of posts to show:', $field_args);
		
		//file example
		$field_args = array( 'type' => 'file', 'id' => 'upload_file_option', 'desc' => 'Upload an image (recommended:500px x 250px, .jpg file format)', 'std' => '', 'class' => '');
		$sl_options->add_form_element( 'Upload image:', $field_args);
	
		break;

	//general option tab
	case 'general':
	
		//add a settings section to the form
		//parameters : section id, section header text
		$sl_options->add_settings_section('general','General Site Settings');
		
		//now lets add the form inputs
		$field_args = array( 'type' => 'radio', 'id' => 'text_colour_option', 'desc' => 'Decide on the colour of text on the site', 'std' => 'black', 'class' => '', 'choices' => array('Black|#000','White|#fff') );
		$sl_options->add_form_element( 'Text colour on the site:', $field_args);
		
		break;
}

//now create the options pages / form
$sl_options->create_options_form();
?>