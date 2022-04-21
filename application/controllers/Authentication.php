<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Authentication extends CI_Controller {
    function __construct(){
       parent::__construct();      
       $this->load->model('Authentication_Model');    
   }
    public function AdminLogin(){
        $this->load->view('auth/admin/login');
    }
    public function forgot_password(){
        $this->load->view('auth/admin/forgot_password');
    }
    public function Login_Admin(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$remember = $this->input->post('remember');
		$model_response = $this->Authentication_Model->Login_Admin($username,$password,$remember);
        $data = array(
          'status' => 'success',
          'message' => 'request accepted',
          'payload' => base64_encode(json_encode($model_response))
        );
        echo json_encode($data);
	}

}
?>