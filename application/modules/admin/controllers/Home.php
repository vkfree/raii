<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {


	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('custom_model');
	}

	public function index()
	{
		$this->mPageTitle = 'Home';
		$this->render('home');
	}
}