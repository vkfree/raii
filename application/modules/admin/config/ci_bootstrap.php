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
	'site_name' => 'rai',

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
			// 'assets/admin/js/bootstrap-select.min.js',
			'assets/admin/js/jquery.slimscroll.js',
			'assets/admin/js/jquery.inputmask.bundle.js',
			'assets/admin/js/sweetalert.min.js',
			'assets/admin/js/dialogs.js',
			'assets/admin/js/waves.js',
			/*'assets/admin/js/jquery.flot.js',
			'assets/admin/js/jquery.flot.resize.js',
			'assets/admin/js/jquery.flot.pie.js',*/
			'assets/admin/js/Chart.bundle.js',
			'assets/admin/js/admin.js',
			// 'assets/admin/js/demo.js',
			'assets/admin/js/jquery.validate.js',
			'assets/admin/js/jquery.steps.min.js',
			//'assets/admin/js/select2.min.js',
			'assets/admin/js/form-wizard.js',
			'assets/admin/js/advanced-form-elements.js',
			'assets/admin/js/bootstrap-tagsinput.js',
			'assets/admin/js/ckeditor/ckeditor.js',
			'assets/admin/js/bootstrap-material-datetimepicker/js/moment.js',
			'assets/admin/js/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js',
			'assets/admin/js/chosen.jquery.js',
			'assets/admin/js/viewer.min.js',
		),
		'foot'	=> array(
		),
	),

	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'assets/admin/css/roboto.css',
			'assets/admin/css/fonts_popins.css',
			'assets/admin/css/material_icons.css',
			'assets/admin/css/bootstrap.css',
			//'assets/admin/css/bootstrap-select.min.css',
			'assets/admin/css/waves.css',
			'assets/admin/css/animate.css',
			'assets/admin/css/morris.css',
			'assets/admin/css/style.css',
			'assets/admin/css/all-themes.css',
			'assets/admin/css/mystyle.css',
			'assets/admin/css/sweetalert.css',
			//'assets/admin/css/select2.min.css',
			'assets/admin/css/bootstrap-tagsinput.css',
			'assets/admin/js/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css',
			'assets/admin/css/chosen.css',
			'assets/admin/css/viewer.min.css'
		)
	),

	// Default CSS class for <body> tag
	'body_class' => '',
	
	// Multilingual settings
	'languages' => array(
	),

	// Menu items
	'menu' => array(

		'dashbord' => array(
			'name'		=> 'Dashbord',
			'url'		=> '',
			'icon'		=> 'dashboard',
		),

		'user' => array(
			'name'		=> 'User',
			'url'		=> 'user',
			'icon'		=> 'group',
			'children'  => array(
				'List'		=> 'user',
				'Create'	=> 'user/create'
			)
		),

		'survey' => array(
			'name'		=> 'Survey',
			'url'		=> 'survey',
			'icon'		=> 'poll',
			'children'  => array(
				'List'			=> 'survey',
				'Create'		=> 'survey/create',
			)
		),

		'payments' => array(
			'name'		=> 'Payments',
			'url'		=> 'payments',
			'icon'		=> 'payment',
			'children'  => array(
				'List'			=> 'payments/list',
				'Create'		=> 'payments/create',
			)
		),

		'rewards' => array(
        	'name'		=> 'Rewards',
        	'url'		=> 'rewards',
        	'icon'		=> 'gamepad',
        	'children'  => array(
        		'List'			=> 'rewards/list',
        	    'Create'		=> 'rewards/create',
        	)
        ),
        
    	
    	'setting' => array(
        	'name'		=> 'Setting',
        	'url'		=> 'setting',
        	'icon'		=> 'brightness_7',
        	'children'  => array(
        		'Refreal'			=> 'rewards/list',
        	    'Notification'		=> 'rewards/create',
        	    'Profile'		=> 'rewards/create',
        	    'History'		=> 'rewards/create',
        	)
        ),

		'banner' => array(
        	'name'		=> 'Banner',
        	'url'		=> 'banner',
        	'icon'		=> 'add_a_photo',
        	'children'  => array(
        		'List'			=> 'banner',
        	    'Create'		=> 'banner/create',
        	)
        ),
        
		'pages' => array(
        	'name'		=> 'Pages',
        	'url'		=> 'pages',
        	'icon'		=> 'pages',
        	'children'  => array(
        		'List'			=> 'pages',
        	   	'Create'		=> 'pages/create',
        	   	'FAQ'			=> 'pages/test',
        	   	// 'FAQ'			=> 'pages/test',
        	   /*	'About'			=> 'pages/about_service',*/
        	)
        ),
		
		
        


		/*

		'activate_driver' => array(
			'name'		=> 'Activate Driver',
			'url'		=> 'activate_driver',
			'icon'		=> 'group',
		),


		'booking' => array(
        	'name'		=> 'Booking Listing',
        	'url'		=> 'booking/list1',
        	'icon'		=> 'note',
        ),
        
        
        'cancel_booking' => array(
        	'name'		=> 'Cancel Booking List',
        	'url'		=> 'cancel_booking/list1',
        	'icon'		=> 'note',
        	'children'  => array(
        		'List'			=> 'cancel_booking/list1',
        	    'Driverwise Listing'		=> 'cancel_booking_driverwise/list1',
        	)
        ),
        
        'loyal_customer' => array(
        	'name'		=> 'Loyal Customer',
        	'url'		=> 'loyal_customer',
        	'icon'		=> 'stars',
        	'children'  => array(
        		'List'						=> 'loyal_customer/list1',
        		'First Time Order List'		=> 'loyal_customer/first_time_order',
        		'No Order Yet'				=> 'loyal_customer/no_order_yet',
        		'Last Order List '			=> 'loyal_customer/date_diff',
        	)
        ),
        
    
         'driver' => array(
			'name'		=> 'Report Drivers',
			'url'		=> 'driver/list1',
			'icon'		=> 'group',
		),
		
		
		// 'statement' => array(
		// 	'name'		=> 'Statement',
		// 	'url'		=> 'statement',
		// 	'icon'		=> 'widgets',
		// 	'children'  => array(
				
		// 		'Complete Ride List'		=> 'statement/list1',
				
		// 		'Daily Statement'		=> 'daily_statement/daily_statement',
		// 		'Monthly Statement'		=> 'monthly_statement/monthly_statement',
		// 		'Yearly Statement'		=> 'yearly/yearly',
		// 	)
		// ),
		
		
		 // 'complaint' => array(
   //      	'name'		=> 'Rating & Reviews',
   //      	'url'		=> 'complaint/list1',
   //      	'icon'		=> 'note',
        	
   //      ),
        
	/*	'Driver statement' => array(
			'name'		=> 'Driver Statement',
			'url'		=> 'statement',
			'icon'		=> 'widgets',
			'children'  => array(
				'List'		=> 'statement/driver',
			)
		),
		*/
		
  //   	'price' => array(
		// 	'name'		=> 'Vehicle Price',
		// 	'url'		=> 'price',
		// 	'icon'		=> 'group',
		// ),
		
		
	    
        //  'ticket' => array(
        // 	'name'		=> 'Raise Ticket',
        // 	'url'		=> 'ticket/list1',
        // 	'icon'		=> 'note',
        // 	'children'  => array(
        // 		'List'			=> 'ticket/list1',
        // 		'Create'			=> 'ticket/create',
        // 	)
        // ),
        
        
  //       'invoice' => array(
		// 	'name'		=> 'Invoice',
		// 	'url'		=> 'invoice',
		// 	'icon'		=> 'account_circle'
		// ),
    
  //       	'help' => array(
		// 	'name'		=> 'Help',
		// 	'url'		=> 'help',
		// 	'icon'		=> 'widgets',
		// ),
		
        
		/*'util' => array(
			'name'		=> 'Utilities',
			'url'		=> 'util',
			'icon'		=> 'settings_applications',
			'children'  => array(
				'Database Versions'		=> 'util/list_db',
			)
		),*/
		
		'logout' => array(
			'name'		=> 'Sign Out',
			'url'		=> 'panel/logout',
			'icon'		=> 'input',
		)
	),

	// Login page
	'login_url' => 'admin/login',

	// Restricted pages
	'page_auth' => array(
		'useful_links'				=> array('webmaster', 'admin', 'manager'),
		'pages'					=> array('webmaster', 'admin', 'manager'),
		'user'					=> array('webmaster', 'admin', 'manager'),
		
		'report'					=> array('webmaster', 'admin', 'manager'),
		'review'				=> array('webmaster', 'admin', 'manager'),
		'admin_option'				=> array('webmaster', 'admin', 'manager'),
		'plan'					=> array('webmaster', 'admin', 'manager'),
		'admin_option'				=> array('webmaster', 'admin', 'manager'),
		'email_send'				=> array('webmaster', 'admin', 'manager'),
		'order_invoice'				=> array('webmaster', 'admin', 'manager'),
		'basket_request'			=> array('webmaster', 'admin', 'manager'),
		'admin_payment'				=> array('webmaster', 'admin', 'manager'),
		'vender_option'				=> array('vendor'),
		'user/create'				=> array('webmaster', 'admin', 'manager'),
		'user/group'				=> array('webmaster', 'admin', 'manager'),
		'panel'					=> array('webmaster', 'admin'),
		'orders'				=> array('webmaster', 'admin', 'vendor','branch'),
		'address'				=> array('webmaster', 'admin', 'manager'),
		'vendor'				=> array('vendor'),
		'category'				=> array('webmaster'),
		'category/create'			=> array('webmaster'),
		'product'				=> array('webmaster', 'vendor'),
		'product/create'			=> array('webmaster', 'vendor'),
		'dashboard/create'			=> array('webmaster', 'vendor'),
		'dashboard/list'			=> array('webmaster', 'vendor'),
		'vender_request/list1'			=> array('vendor'),

		'request'				=> array('webmaster'),
		'feedback'				=> array('webmaster'),
		'panel/vendor_user'			=> array('webmaster', 'admin'),
		'panel/admin_user_create'		=> array('webmaster', 'admin'),
		'util'					=> array('webmaster'),
		'util/list_db'				=> array('webmaster'),
		'util/backup_db'			=> array('webmaster'),
		'util/restore_db'			=> array('webmaster'),
		'util/remove_db'			=> array('webmaster'),
	),

	// AdminLTE settings
	'adminlte' => array(
		'body_class' => array(
			'webmaster'	=> 'theme-light-green',
			'admin'		=> 'theme-light-green',
			'manager'	=> 'theme-light-green',
			'staff'		=> 'theme-light-green',
			'vendor'	=> 'theme-light-green',
			'branch'	=> 'theme-light-green',
		)
	),

	// Useful links to display at bottom of sidemenu
	'useful_links' => array(
		array(
			'auth'		=> array('webmaster', 'admin', 'manager', 'staff'),
			'name'		=> 'Frontend Website',
			'url'		=> '',
			'target'	=> '_blank',
			'color'		=> 'text-aqua'
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
$config['sess_cookie_name'] = 'ci_session_admin_myen';
