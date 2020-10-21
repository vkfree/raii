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
	'site_name' => 'Life Venue',

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
	/*
	// Default scripts to embed at page head or end
	'scripts' => array(
		'head'	=> array(
			'assets/dist/admin/adminlte.min.js',
			'assets/dist/admin/lib.min.js',
			'assets/dist/admin/app.min.js'
		),
		'foot'	=> array(
		),
	),

	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'assets/dist/admin/adminlte.min.css',
			'assets/dist/admin/lib.min.css',
			'assets/dist/admin/app.min.css'
		)
	),*/
	// Default scripts to embed at page head or end
	'scripts' => array(
		'head'	=> array(
			'assets/admin/js/jquery.min.js',
			'assets/admin/js/bootstrap.js',
			'assets/admin/js/bootstrap-select.min.js',
			'assets/admin/js/jquery.slimscroll.js',
			'assets/admin/js/jquery.inputmask.bundle.js',
			'assets/admin/js/waves.js',
			'assets/admin/js/sweetalert.min.js',
			'assets/admin/js/dialogs.js',
			'assets/admin/js/admin.js',
			'assets/admin/js/demo.js',
			'assets/admin/js/jquery.validate.js',
			'assets/admin/js/jquery.steps.min.js',
			'assets/admin/js/form-wizard.js',
			'assets/admin/js/advanced-form-elements.js'
		),
		'foot'	=> array(
		),
	),

	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'assets/admin/css/roboto.css',
			'assets/admin/css/material_icons.css',
			'assets/admin/css/bootstrap.css',
			'assets/admin/css/bootstrap-select.min.css',
			'assets/admin/css/waves.css',
			'assets/admin/css/animate.css',
			'assets/admin/css/morris.css',
			'assets/admin/css/style.css',
			'assets/admin/css/all-themes.css',
			'assets/admin/css/mystyle.css',
			'assets/admin/css/sweetalert.css'
		)
	),

	// Default CSS class for <body> tag
	'body_class' => '',
	
	// Multilingual settings
	'languages' => array(
	),

	// Menu items
	'menu' => array(
		'home' => array(
			'name'		=> 'Home',
			'url'		=> '',
			'icon'		=> 'home',
		),
		'user' => array(
			'name'		=> 'Users',
			'url'		=> 'user',
			'icon'		=> 'group',
			'children'  => array(
				'List'			=> 'user',
				// 'Create'		=> 'user/create',
				'User Groups'	=> 'user/group',
			)
		),
		'panel' => array(
			'name'		=> 'Admin Panel',
			'url'		=> 'panel',
			'icon'		=> 'settings',
			'children'  => array(
				'Admin Users'			=> 'panel/admin_user',
				'Create Admin User'		=> 'panel/admin_user_create',
				'Admin User Groups'		=> 'panel/admin_user_group',
			)
		),
		'category' => array(
			'name'		=> 'Category',
			'url'		=> 'category',
			'icon'		=> 'widgets',
			'children'  => array(
				'List'			=> 'category',
				'Create'		=> 'category/create',
			)
		),
		'product' => array(
			'name'		=> 'Product',
			'url'		=> 'product',
			'icon'		=> 'adb',
			'children'  => array(
				'List'			=> 'product',
				'Create'		=> 'product/create',
			)
		),
		'util' => array(
			'name'		=> 'Utilities',
			'url'		=> 'util',
			'icon'		=> 'settings_applications',
			'children'  => array(
				'Database Versions'		=> 'util/list_db',
			)
		),
		'logout' => array(
			'name'		=> 'Sign Out',
			'url'		=> 'panel/logout',
			'icon'		=> 'input',
		)
	),

	// Login page
	'login_url' => 'wsapp/home/login',

	// Useful links to display at bottom of sidemenu
	'useful_links' => array(
		array(
			'auth'		=> array('webmaster', 'admin', 'manager', 'staff'),
			'name'		=> 'Frontend Website',
			'url'		=> '',
			'target'	=> '_blank',
			'color'		=> 'text-aqua'
		),
		/*array(
			'auth'		=> array('webmaster', 'admin'),
			'name'		=> 'API Site',
			'url'		=> 'api',
			'target'	=> '_blank',
			'color'		=> 'text-orange'
		),
		array(
			'auth'		=> array('webmaster', 'admin', 'manager', 'staff'),
			'name'		=> 'Github Repo',
			'url'		=> CI_BOOTSTRAP_REPO,
			'target'	=> '_blank',
			'color'		=> 'text-green'
		),*/
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
$config['sess_cookie_name'] = 'ci_session_admin';