<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {
   function __construct(){
       parent::__construct();      
       $this->load->model('Admin_Model');    
    } 
      public function Controller(){
         $action = $this->input->post('data1');
         switch($action){
            case "profile":{
               $type = $this->input->post('data2');
               $image = (isset($_FILES['data3']['name'])) ? $_FILES['data3']['name'] : 'undefined';
               $tmp = (isset($_FILES['data3']['tmp_name'])) ? $_FILES['data3']['tmp_name'] : 'undefined';
               $avatar = $this->input->post('data4');
               $imgtype = $this->input->post('data5');
                  $model_response = $this->Admin_Model->profile($type,$image,$tmp,$avatar,$imgtype);
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
               break;
            }
            case "address":{
                $type =$this->input->post('data2');
                $val = $this->input->post('data3');
                $model_response = $this->Admin_Model->Address($type,$val);
                $data = array(
                  'status' => 'success',
                  'message' => 'request accepted',
                  'payload' => base64_encode(json_encode($model_response))
               );
               echo json_encode($data);
               break;
            }
            case "employee":{
               $type = $this->input->post('data2');
               $id = $this->input->post('data3');
                $model_response = $this->Admin_Model->Address($type,$val);
                $data = array(
                  'status' => 'success',
                  'message' => 'request accepted',
                  'payload' => base64_encode(json_encode($model_response))
               );
               echo json_encode($data);
               break;
            }
          

         }
      }
      public function Action(){
         $action = $this->input->post('action');
         switch($action){
            case "save_user_profile":{
               $type = $this->input->post('type');
               if($type=="save_personal_info"){
                     $fname = $this->input->post('fname'); 
                     $lname = $this->input->post('lname'); 
                     $mname = $this->input->post('mname'); 
                     $model_response = $this->Admin_Model->Save_User_Profile($type,$fname,$lname,$mname,false,false,false,false,false,false,false,false,false,false,false,false);
                  }else if($type=="save_contact_info"){
                     $country = (isset($_POST['country'])) ? $this->input->post('country') : 'PH';
                     $phonecode = (isset($_POST['phonecode'])) ? $this->input->post('phonecode') : '63';
                     $mobile = $this->input->post('mobile');
                     $city =$this->input->post('city');
                     $model_response = $this->Admin_Model->Save_User_Profile($type,false,false,false,$city,$country,$phonecode,$mobile,false,false,false,false,false,false,false,false);
                  }else if($type=="save_change_pass"){
                     $c_password = $this->input->post('c_password');
                     $n_password = $this->input->post('n_password');
                     $v_password = $this->input->post('v_password');
                     $model_response = $this->Admin_Model->Save_User_Profile($type,false,false,false,false,false,false,false,$c_password,$n_password,$v_password,false,false,false,false);
                  }
                 $data = array(
                    'status' => 'success',
                    'message' => 'request accepted',
                    'payload' => base64_encode(json_encode($model_response))
                 );
               echo json_encode($data);
               break;
            }


      }
   }


   public function Chart(){
      $action = $this->input->post('action');
      switch($action){
         case "chart":{
            $type = $this->input->post('type');
            $date = $this->input->post('date');
            $data = $this->Admin_Model->Chart($type,$date);
            echo json_encode($data);
         }

         
      }


   }

}
?>