<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class login extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('adminModel');
        $this->load->library("encryption");
        $this->logged_in();
    }
    
	public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        
        if($this->form_validation->run() == false){
            $this->load->view('userlogin/login');
        } 
        else {
            $email      =   $this->security->xss_clean($this->input->post('email'));
            $password   =   $this->security->xss_clean($this->input->post('password'));
            //$encriptPassword    = $this->encryption->encrypt($password);
            $user       =   $this->adminModel->login($email, $password);
            if($user){
                $userdata = array(
                    'pkci_user_ajaxid'	=> $user->pkci_user_ajaxid,
                    'name'				=> $user->name,
					'email'				=> $user->email,
					'password'			=> $user->password,
                    'category'			=> $user->category,
                    'authenticated'		=> TRUE
                );
				
                $this->session->set_userdata($userdata);
                $this->load->view('books/index');
            }
            else {
                $this->session->set_flashdata('message', 'Invalid email or password');
                $this->load->view('userlogin/login');
            }
        }
    }
	private function logged_in() {
		$this->load->helper('url');
        if(! $this->session->userdata('authenticated')) {
            $this->load->view('userlogin/login');
        }
    }
	public function logout()
    {
        $this->session->sess_destroy();
		$this->load->view('userlogin/login');
    }
}
