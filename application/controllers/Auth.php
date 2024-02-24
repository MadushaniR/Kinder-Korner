<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
	}

	public function index()
	{
		$data['user_name'] = $this->session->userdata('user_name');
		$data['userID'] = $this->session->userdata('userID');
		$this->load->view('Auth/login');
	}

	public function register()
	{
		$this->load->view('Auth/register');
	}

	public function registration_form()
	{
		$this->auth_model->register_user();
	}

	public function login_form()
	{
		$this->load->model('auth_model');
		$user_data = $this->auth_model->login_user();

		if ($user_data) {
			$this->session->set_userdata('userID', $user->userID);
			$this->session->set_userdata('user_name', $user_data->username);
			redirect('auth/main');
		} else {
			$this->session->set_flashdata('warning', 'Incorrect Authentication!!!');
			redirect('Auth/');
		}
	}

	public function main()
	{
		$data['user_name'] = $this->session->userdata('user_name');
		$data['userID'] = $this->session->userdata('userID');
		$this->load->model('auth_model');
		$this->load->view('Auth/index', $data);
	}

	public function logout()
	{
		$this->session->unset_userdata('userID');
		$this->session->set_flashdata('suc', 'You have been logged out successfully.');
		redirect('/');
	}
}
