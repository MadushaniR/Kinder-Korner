<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Auth extends RestController
{

    function __construct()
    {
        parent::__construct();
    }

    // Method to handle user registration via POST request
    public function register_user_post()
    {
        $this->load->model('AuthModel');

        $username = $this->post('username');
        $email = $this->post('email');
        $password = $this->post('password');
        $con_password = $this->post('con_password');

        // Check if any required fields are empty
        if (empty($username) || empty($email) || empty($password) || empty($con_password)) {
            $this->response(['message' => 'All fields are required'], 400);
            return;
        }

        // Check if passwords match
        if ($password != $con_password) {
            $this->response(['message' => 'Passwords do not match'], 400);
            return;
        }

        $result = $this->AuthModel->register_user($username, $email, $password);

        // Send response based on registration result
        if ($result === 'You are registered. Please log in.') {
            $this->response(['message' => $result], 200);
        } else {
            $this->response(['message' => $result], 400);
        }
    }

    // Method to handle user login via POST request
    public function login_user_post()
    {
        $this->load->model('AuthModel');

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $result = $this->AuthModel->login_user($email, $password);

        // Send response based on login result
        if ($result === 'Login successful') {
            $this->response(['message' => $result], 200);
        } else {
            $this->response(['message' => $result], 401);
        }
    }

    // login view
    public function login_get()
    {
        $this->load->view('Auth/login');
    }

    // register view
    public function register_get()
    {
        $this->load->view('Auth/register');
    }

    // when loading kinder koner application landing page view
    public function index_get()
    {
        $this->load->view('LandingPage/LandingPageView');
    }
}
