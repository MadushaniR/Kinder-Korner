<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	
	public function index()
	{
		$this->load->view('Auth/login');
	}

	public function register(){
		$this->load->view('Auth/register');
	}

	public function registration_form(){
		$this->auth_model->register_user();
	}

	public function login_form(){
		$this->auth_model->login_user();
	}

	public function main(){
		$this->load->view('Auth/index');
	}
}


