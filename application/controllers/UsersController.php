<?php

/**
 * 
 */
class UsersController extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();

	}

	public function index()
	{				//echo "string";exit();
		$this->load->view('userlist');
	}
}