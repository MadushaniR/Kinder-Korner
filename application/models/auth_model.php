
<?php

class auth_model extends CI_Model{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register_user(){

        $password=$this->input->post('password');
        $con_password=$this->input->post('con_password');
       

        if($password!=$con_password){
            $this->session->set_flashdata('worng','The password not equal with confirmation!');
            redirect('Auth/register');
        }else{
            $data=array(
                "name"=>$this->input->post('name'),
                "email"=>$this->input->post('email'),
                "password"=>$password
            );

            $this->db->insert('users',$data);
            $this->session->set_flashdata('suc','You are registered please login');
            redirect('Auth/');

        }



    }

    public function login_user(){
        $email=$this->input->post('email');
        $password=$this->input->post('password');

        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $query=$this->db->get('users');
        $find_user=$query->num_rows($query);

        if($find_user>0){
            $this->session->set_flashdata('suc','You are logged');
            redirect('Auth/main');
        }else{
            $this->session->set_flashdata('warning','Incorrect Authentication!!!');
            redirect('Auth/');
        }
    }

}

?>