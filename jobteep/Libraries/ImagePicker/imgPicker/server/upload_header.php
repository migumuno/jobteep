<?php

// Error reporting
//error_reporting(0);

// HTTP access control
header('Access-Control-Allow-Origin: jobteep.com');
header('Access-Control-Allow-Origin: www.jobteep.com');

session_start();

require dirname(__FILE__) . '/ImgPicker.php';

$options = array(

	// Upload directory path
	'upload_dir' => '../../../../Data/Users/'.$_SESSION['imagePicker'].'/',
		
	'accept_file_types' => 'png|jpg|jpeg|gif',
		
	'max_file_size' => 1000000,

	// Upload directory url:
	//'upload_url' => 'http://localhost/imgPicker/files/',
	'upload_url' => '../../../Data/Users/'.$_SESSION['imagePicker'].'/',

    // Image versions:
    'versions' => array(
    	'header' => array(
    		'max_width' => 1000,
    		'max_height' => 400
    	),
    ),

    /**
	 * 	Load callback
	 *
	 *  @param 	ImgPicker 		$instance
	 *  @return string|array
	 */
    'load' => function($instance) {
    	//return 'avatar.jpg';
    },

    /**
	 * 	Delete callback
	 *
	 *  @param  string 		    $filename
	 *  @param 	ImgPicker 		$instance
	 *  @return boolean
	 */
    'delete' => function($filename, $instance) {
    	return true;
    },
	
	/**
	 * 	Upload start callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'upload_start' => function($image, $instance) {
		$image->name = $_SESSION['nameImg'].'.' . $image->type;		
	},
	
	/**
	 * 	Upload complete callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'upload_complete' => function($image, $instance) {
	},

	/**
	 * 	Crop start callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'crop_start' => function($image, $instance) {
		$image->name = $_SESSION['nameImg'].'.' . $image->type;
	},

	/**
	 * 	Crop complete callback
	 *
	 *  @param 	stdClass 		$image
	 *  @param 	ImgPicker 		$instance
	 *  @return void
	 */
	'crop_complete' => function($image, $instance) {
	}
);

// Create new ImgPicker instance
new ImgPicker($options);

/*
new ImgPicker($options, $messges);
	$messages - array of messages (See ImgPicker.php)
*/