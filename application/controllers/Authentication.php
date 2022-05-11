<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Authentication extends CI_Controller {
    function __construct(){
       parent::__construct();      
       $this->load->model('Authentication_Model');    
    }
    public function AdminLogin(){
        $this->load->view('auth/admin/login');
    }
    public function admin_forgotpass(){
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
    public function Admin_Login_Forgotpass(){
        $email = $this->input->post('email') ?? $this->invalidMissing_Input("Email is required");
        $model_response = $this->Authentication_Model->Admin_Login_Forgotpass($email);
        if($model_response != false){
            $data = array(
                'status' => 'success',
                'message' => 'request accepted',
                'payload' => base64_encode(json_encode($model_response))
            );
        }else{
           $data = array(
                'status' => 'error',
                'message' => 'Something went wrong, Please try again later.',
                'payload' => base64_encode(json_encode($model_response))
            );
        }
        echo json_encode($data);
    }
     public function Admin_Login_Resetpass(){
        $password = $this->input->post('password')?? $this->invalidMissing_Input("Password is required");
        $password = (strlen($password) < 8 )? $this->invalidMissing_Input("Password must atleast 8 characters long") : $password;
        $cpassword = $this->input->post('cpassword')?? $this->invalidMissing_Input("Confirm password is required");
        $cpassword = (strlen($cpassword) < 8 )? $this->invalidMissing_Input("Password must atleast 8 characters long") : $cpassword;
        $cpassword = (strcasecmp($password, $cpassword ) != 0) ? $this->_invalidMissing_Input("Password doesn't match!") : $cpassword;
        $token =  $this->input->post('reset_token') ?? $this->invalidMissing_Input("Opps!, It seems that this link is invalid.");
        $validator = $this->input->post('reset_validator') ?? $this->invalidMissing_Input("Opps!, It seems that this link is invalid.");
        $model_response = $this->Authentication_Model->Admin_Login_Resetpass($token, $validator, $cpassword);
            if($model_response){
                $response = array(
                    'status' => 'success',
                    'message' => 'Request successful',
                    'payload' => base64_encode(json_encode($model_response))
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'message' => 'Internal server error',
                    'payload' => base64_encode(json_encode($model_response))
                );
        }
        echo json_encode($response);
      }
     private function invalidMissing_Input($message){
          $data = array(
              'status' => 'failed',
              'message' => $message,
              'payload' => ''
           );
           echo json_encode($data);
           exit();
      }




}
?>