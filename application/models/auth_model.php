<?php
class auth_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register_user()
    {

        $password = $this->input->post('password');
        $con_password = $this->input->post('con_password');


        if ($password != $con_password) {
            $this->session->set_flashdata('wrong', 'The password not equal with confirmation!');
            redirect('Auth/register');
        } else {
            $data = array(
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "password" => $password
            );

            $this->db->insert('users', $data);
            $this->session->set_flashdata('suc', 'You are registered please login');
            redirect('Auth/');
        }
    }
    
    public function login_user()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        $user = $query->row(); // Get the user data

        if ($user) {
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('user_name', $user->name);
            $this->session->set_flashdata('suc', 'You are logged in as ' . $user->name);
            redirect('Auth/main');
        } else {
            $this->session->set_flashdata('warning', 'Incorrect Authentication!!!');
            redirect('Auth/');
        }
    }

    public function get_user_by_id($user_id)
    {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        return $query->row(); // Return the user data
    }
}
