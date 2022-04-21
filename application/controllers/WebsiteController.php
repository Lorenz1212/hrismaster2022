<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class WebsiteController extends CI_Controller {
    public function Action(){
      $action = $this->input->post('action');
      switch($action){
         case "contact_us":{
            $type = $this->input->post('type');
            $receiver = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
            $name = $this->input->post('name');
            $mobile = $this->input->post('mobile');
            $model_response = $this->Email_model->email_setup($type,$receiver,$subject,$message,$name,$mobile);
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
}
?>