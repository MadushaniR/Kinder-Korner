<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
use chriskacerguis\RestServer\RestController;

class AuthApi extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->model('AuthModel');
    }

     // Endpoint for user registration
    public function register_post() {
        $data = $this->post();

        // Check if username, email, and password are provided
        if (!empty($data['username']) && !empty($data['email']) && !empty($data['password'])) {
            // Call the register_user method from AuthModel to register the user
            $result = $this->AuthModel->register_user($data['username'], $data['email'], $data['password']);

            if ($result) {
                $this->response(array('success' => 'User registered successfully'), 200);
            } else {
                $this->response(array('error' => 'Registration failed'), 400);
            }
        } else {
            $this->response(array('error' => 'Username, email, and password are required'), 400);
        }
    }
    
     // Endpoint for user login
     public function login_post() {
        $email = $this->post('email');
        $password = $this->post('password');

        if (!empty($email) && !empty($password)) {
            // Call the login_user method from AuthModel to authenticate the user
            $result = $this->AuthModel->login_user($email, $password);

            if ($result) {
                $this->response($result, 200);
            } else {
                $this->response(array('error' => 'Invalid email or password'), 401);
            }
        } else {
            $this->response(array('error' => 'Email and password are required'), 400);
        }
    }

}
