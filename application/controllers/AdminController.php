<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {
   function __construct(){
       parent::__construct();      
       $this->load->model('Admin_Model');    
    } 
     function _invalidMissing_Input($message){
          $data = array(
              'status' => 'failed',
              'message' => $message,
              'payload' => ''
           );
           echo json_encode($data);
           exit();
      }
      public function Controller(){
         $action = $this->input->post('data1');
         switch($action){
            case "profile":{
               $type = $this->input->post('data2')?? _invalidMissing_Input("Missing request type");
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
                $type =$this->input->post('data2')??_invalidMissing_Input("Missing request type");
                $val = $this->input->post('data3')?? false;
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
               $type = $this->input->post('data2')??_invalidMissing_Input("Missing request type");
               $val = $this->input->post('data3')?? false;
               $model_response = $controller->Members($type,$val);
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
                    $fname = $this->input->post('fname')?? _invalidMissing_Input("First name is required");
                    $fname = (strlen($fname) > 20) ? _invalidMissing_Input("First name can contain maximum of 20 characters"):$fname;
                    $fname = (preg_match('/^[\'^£$%&*()}{@#~?<>,|=+¬]+$/', $fname)) ? _invalidMissing_Input("First name can only consist of alphabetical characters"):$fname;
                    $lname = $this->input->post('lname')?? _invalidMissing_Input("Last name is required");
                    $lname = (strlen($lname) > 20) ? _invalidMissing_Input("Last name can contain maximum of 20 characters"):$lname;
                    $lname = (preg_match('/^[\'^£$%&*()}{@#~?<>,|=+¬]+$/', $lname)) ? _invalidMissing_Input("Last name can only consist of alphabetical characters"):$lname;
                    $mname = (strlen($this->input->post('mname')) > 20) ? _invalidMissing_Input("Middle name can contain maximum of 20 characters"):$this->input->post('mname');
                    $mname = (preg_match('/^[\'^£$%&*()}{@#~?<>,|=+¬]+$/', $mname)) ? _invalidMissing_Input("Middle name can only consist of alphabetical characters"):$mname;
                    $model_response = $this->Admin_Model->Save_User_Profile($type,$fname,$lname,$mname,false,false,false,false,false,false,false,false,false,false,false,false);
                  }else if($type=="save_contact_info"){
                     $country = $this->input->post('country') ?? 'PH';
                     $phonecode =$this->input->post('phonecode') ?? '63';
                     $mobile = $this->input->post('mobile') ??_invalidMissing_Input("Mobile number is required");
                     $mobile = (!is_numeric($_POST['mobile'])) ? _invalidMissing_Input("Mobile number can contain digits only"):$mobile;
                     $mobile = (strlen($_POST['mobile'])!=10 ) ? _invalidMissing_Input("Mobile number is not valid"):$mobile;
                     $city = (preg_match('/^[\'^£$%&*()}{@#~?<>,|=+¬]+$/', $this->input->post('city'))) ? _invalidMissing_Input("City can only consist of alphabetical characters"):$this->input->post('city');
                     $city = (strlen($city) > 20) ? _invalidMissing_Input("City can contain maximum of 20 characters"):$city;
                     $model_response = $this->Admin_Model->Save_User_Profile($type,false,false,false,$city,$country,$phonecode,$mobile,false,false,false,false,false,false,false,false);
                  }else if($type=="save_change_pass"){
                     $n_password = $this->input->post('n_password')?? _invalidMissing_Input("Password is required");
                     $n_password = (strlen($n_password) < 8 ) ? _invalidMissing_Input("Password must atleast 8 characters long") : $n_password;
                     $v_password = $this->input->post('v_password')?? _invalidMissing_Input("Confirm password is required");
                     $v_password = (strlen($v_password) < 8 ) ? _invalidMissing_Input("Password must atleast 8 characters long") : $v_password;
                     $v_password = (strcasecmp($n_password, $v_password ) != 0) ? _invalidMissing_Input("Password doesn't match!") : $v_password;
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