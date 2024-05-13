<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel');
    }

    // Default method for the controller, loads landing page
    public function index()
    {
        // Fetch user data from session
        $data['user_name'] = $this->session->userdata('user_name');
        $data['userID'] = $this->session->userdata('userID');
        $this->load->view('LandingPage/LandingPageView');
    }

    // Method for displaying registration page
    public function register()
    {
        $this->load->view('Auth/register');
    }

    // Method for displaying login page
    public function login()
    {
        $this->load->view('Auth/login');
    }

    // Method to handle registration form submission
    public function registration_form()
    {
        $this->AuthModel->register_user();
    }

    // Method to handle login form submission
    public function login_form()
    {
        $this->load->model('AuthModel');
        // Attempt to login user
        $user_data = $this->AuthModel->login_user();

        // If login successful, set session data and redirect to main page
        if ($user_data) {
            $this->session->set_userdata('userID', $user_data->userID); 
            $this->session->set_userdata('user_name', $user_data->username);
            redirect('auth/main');
        } else { 
            $this->session->set_flashdata('warning', 'Incorrect Authentication!!!');
            redirect('Auth/login');
        }
    }

    // Main page after login, displays user data
    public function main()
    {
        // Fetch user data from session
        $data['user_name'] = $this->session->userdata('user_name');
        $data['userID'] = $this->session->userdata('userID');
        $this->load->model('AuthModel');
        $this->load->view('Auth/index', $data);
    }

    // Method to handle user logout
    public function logout()
    {
        $this->session->unset_userdata('userID');
        $this->session->set_flashdata('suc', 'You have been logged out successfully.');
        redirect('Auth/login');
    }
}
