<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| CI Bootstrap 3 Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
| See example and detailed explanation from:
| 	/application/config/ci_bootstrap_example.php
*/

$config['ci_bootstrap'] = array(

	// Site name
	'site_name' => 'Khedma',

	// Default page title prefix
	'page_title_prefix' => '',

	// Default page title
	'page_title' => '',

	// Default meta data
	'meta_data'	=> array(
		'author'		=> '',
		'description'	=> '',
		'keywords'		=> ''
	),

	// Default scripts to embed at page head or end
	'scripts' => array(
		'head'	=> array(
			// 'assets/frontend/js/vendor/modernizr-2.8.3.min.js?v=2.1',
			// 'assets/frontend/js/vendor/jquery-1.12.4.min.js?v=2.1',
			// 'assets/frontend/js/bootstrap.min.js?v=2.1',
			// 'assets/frontend/js/owl.carousel.min.js?v=2.1',
			// 'assets/frontend/js/jquery.counterup.min.js?v=2.1',
			// 'assets/frontend/js/waypoints.js?v=2.1',
			// 'assets/frontend/js/isotope.pkgd.min.js?v=2.1',
			// 'assets/frontend/js/jquery.stellar.min.js?v=2.1',
			// 'assets/frontend/js/magnific.min.js?v=2.1',
			// 'assets/frontend/js/venobox.min.js?v=2.1',
			// 'assets/frontend/js/jquery.meanmenu.js?v=2.1',
			// 'assets/frontend/js/form-validator.min.js?v=2.1',
			// 'assets/frontend/js/plugins.js?v=2.1',
			// 'assets/frontend/js/main.js?v=2.1',
			// 'assets/frontend/js/index_login.js?v=2.1',
			// 'assets/frontend/js/mapcode.js?v=2.1'

			


			  
		),
		'foot'	=> array(
			/*'assets/dist/frontend/lib.min.js',
			'assets/dist/frontend/app.min.js'*/

		),
	),

	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			/*'assets/frontend/css/style.css?v=1.1',
			'assets/frontend/css/flexslider.css?v=1.1',
			'assets/frontend/css/sweetalert.css?v=1.1',
			'assets/admin/css/chosen.css?v=1.1',
			'assets/admin/css/viewer.min.css?v=1.1'*/

			// 'assets/frontend/css/bootstrap.min.css',
			// 'assets/frontend/css/owl.carousel.css?v=2.1',	
			// 'assets/frontend/css/owl.transitions.css?v=2.1',
			// 'assets/frontend/css/meanmenu.min.css?v=2.1',
			// 'assets/frontend/css/font-awesome.min.css?v=2.1',
			// 'assets/frontend/css/flaticon.css?v=2.1',
			// 'assets/frontend/css/icon.css?v=2.1',
			// 'assets/frontend/css/magnific.min.css?v=2.1',
			// 'assets/frontend/css/venobox.css?v=2.1',
			// 'assets/frontend/css/style.css?v=2.1',
			// 'assets/frontend/css/responsive.css?v=2.1',
			// 'assets/frontend/css/login_css.css?v=2.1'
		)
	),

	// Default CSS class for <body> tag
	'body_class' => '',
	
	// Multilingual settings
	'languages' => array(
		'default'		=> 'en',
		'autoload'		=> array('general'),
		'available'		=> array(
			'en' => array(
				'label'	=> 'English',
				'value'	=> 'english'
			),
			'ar' => array(
				'label'	=> 'العربية',
				'value' => 'arabic'
			)
			/*'zh' => array(
				'label'	=> '繁體中文',
				'value'	=> 'traditional-chinese'
			),
			'cn' => array(
				'label'	=> '简体中文',
				'value'	=> 'simplified-chinese'
			),
			'es' => array(
				'label'	=> 'Español',
				'value' => 'spanish'
			)*/

		)
	),

	// Google Analytics User ID
	'ga_id' => '',

	// Menu items
	'menu' => array(
		'home' => array(
			'name'		=> 'Home',
			'url'		=> '',
		),
	),

	// Login page
	'login_url' => '',

	// Restricted pages
	'page_auth' => array(
	),

	// Email config
	'email' => array(
		'from_email'		=> '',
		'from_name'			=> '',
		'subject_prefix'	=> '',
		
		// Mailgun HTTP API
		'mailgun_api'		=> array(
			'domain'			=> '',
			'private_api_key'	=> ''
		),
	),

	// Debug tools
	'debug' => array(
		'view_data'	=> FALSE,
		'profiler'	=> FALSE
	),
);

/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_frontend_myen';