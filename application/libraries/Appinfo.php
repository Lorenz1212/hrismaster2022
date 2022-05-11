<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appinfo {
        protected $CI;
        public function __construct() {
            $this->CI =& get_instance();    
            $this->CI->load->library('encryption');  
            $this->CI->load->helper('array');

            //Admin Login Background
            $this->admin_bg = base_url('assets/media/bg/bg-1.jpg');
            $this->admin_color = " ";

            //Member Login Background
            $this->member_bg = base_url('assets/media/bg/bg-1.jpg');
            $this->member_color = " ";

            //EMAIL SET UP GMAIL
            $this->protocol = 'smtp';
            $this->smtp_host = 'ssl://smtp.gmail.com';
            $this->smtp_port = '465';
            $this->smtp_user = 'britsbrots@gmail.com';
            $this->smtp_pass = 'llqvytzgzeivgfeg';
            $this->mailtype = 'html';
            $this->charset = 'iso-8859-1';
            $this->web_email ='HRIS Support Team<support@miracle-tree.org>';

            //Creator
            $this->created_by = 'Lorenz Cabreros';
            $this->creator_fb = 'https://www.facebook.com/lorenz1212';
            
            //SESSION
            $this->sess_name = "HRISMASTER2022";

            //Company
            $this->app_company = 'HR Service Management';
            $this->app_company_acronym = 'HRIS';
            $this->app_year = '2022';
            $this->app_location ='Sta. Rosa, Laguna';

            //LOGO
            $this->email_logo = base_url('images/logo/logo-email.png'); 
            $this->app_logo =  base_url('images/logo/logo-small.png');

            
            $admincookie = json_decode($this->CI->encryption->decrypt($this->CI->input->cookie($this->sess_name.'_admin_user', TRUE)),TRUE);
            if($admincookie){
                 $this->admin_id = element($this->sess_name.'_ADMIN_ID', $admincookie);
                 $this->admin_fname = element($this->sess_name.'_ADMIN_FNAME', $admincookie);
                 $this->admin_lname = element($this->sess_name.'_ADMIN_LNAME', $admincookie);
                 $this->admin_letter = element($this->sess_name.'_ADMIN_FNAME', $admincookie)[0];
                 $this->admin_username = element($this->sess_name.'_ADMIN_UNAME',$admincookie);
                 $this->admin_email = element($this->sess_name.'_ADMIN_EMAIL', $admincookie);
                 $this->admin_status = element($this->sess_name.'_ADMIN_AdSTATUS',$admincookie);
                 $this->admin_type = element($this->sess_name.'_ADMIN_TYPE',$admincookie);
                 $this->admin_country = element($this->sess_name.'_ADMIN_COUNTRY',$admincookie);
                 $this->admin_position = element($this->sess_name.'_ADMIN_POSITION',$admincookie);
                 $this->admin_role = element($this->sess_name.'_ADMIN_ROLE', $admincookie);
                 $this->admin_profile = element($this->sess_name.'_ADMIN_PROFILE', $admincookie); 
            }
            $usercookie = json_decode($this->CI->encryption->decrypt($this->CI->input->cookie($this->sess_name.'_member_user', TRUE)),TRUE);
             if($usercookie){
                 $this->member_id = element($this->sess_name.'_MEMBER_ID', $usercookie);
                 $this->member_fname = element($this->sess_name.'_MEMBER_FNAME', $usercookie);
                 $this->member_lname = element($this->sess_name.'_MEMBER_LNAME', $usercookie);
                 $this->member_letter = element($this->sess_name.'_MEMBER_FNAME', $usercookie)[0];
                 $this->member_username = element($this->sess_name.'_MEMBER_UNAME',$usercookie);
                 $this->member_email = element($this->sess_name.'_MEMBER_EMAIL', $usercookie);
                 $this->member_status = element($this->sess_name.'_MEMBER_AdSTATUS',$usercookie);
                 $this->member_type = element($this->sess_name.'_MEMBER_TYPE',$usercookie);
                 $this->member_country = element($this->sess_name.'_MEMBER_COUNTRY',$usercookie);
                 $this->member_position = element($this->sess_name.'_MEMBER_POSITION', $usercookie);
                 $this->member_role = element($this->sess_name.'_MEMBER_ROLE', $usercookie);
                 $this->member_profile = element($this->sess_name.'_MEMBER_PROFILE', $usercookie); 
            }
        }
        public function sess_name(){return $this->sess_name;}

      

        //EMAIL SET UP FOR GMAIL
        public function smtp_host(){return $this->smtp_host;}
        public function smtp_port(){return $this->smtp_port;}
        public function smtp_user(){return $this->smtp_user;}
        public function smtp_pass(){return $this->smtp_pass;}
        public function mailtype(){return $this->mailtype;}
        public function charset(){return $this->charset;}
    

        //EMAIL SET UP LOGO
        public function email_logo(){return $this->email_logo;}
        public function app_location(){return $this->web_location;}
        public function web_email(){return $this->web_email;}
        public function protocol(){return $this->protocol;}
       
        
        //Creator
        public function created_by(){return $this->created_by;}
        public function creator_fb(){return $this->creator_fb;}
         

        //Background
        public function admin_bg(){ return $this->admin_bg;}
        public function admin_color(){ return $this->admin_color;}
        public function member_bg(){ return $this->member_bg;}
        public function member_color(){ return $this->member_color;}

        //Web
        public function app_logo(){return $this->app_logo;}
        public function app_company(){return $this->app_company;}
        public function app_company_acronym(){return $this->app_company_acronym;}
        public function app_year(){return $this->app_year;}
        
        //COOKIE ADMIN
        public function admin_fullname(){return $this->admin_fname.' '.$this->admin_lname;}
        public function admin_position(){return $this->admin_position;}
        public function admin_email(){return $this->admin_email;}
        public function admin_username(){return $this->admin_username;}
        public function admin_status(){return $this->admin_status;}
        public function admin_type(){return $this->admin_type;}
        public function admin_country(){return $this->admin_country;}
        public function admin_role(){return $this->admin_role;}
        public function admin_profile(){return $this->admin_profile;}
        public function admin_image(){
            return ($this->admin_profile=="default.png") ? '<span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30 text-uppercase">'.($this->admin_letter).'</span>' : '<div class="symbol-label" style="background-image:url(images/profile/'.$this->admin_profile.')"></div>';
        }

        //COOKIE MEMBER
        public function member_fullname(){return $this->member_fname.' '.$this->member_lname;}
        public function member_position(){return $this->member_position;}
        public function member_email(){return $this->member_email;}
        public function member_username(){return $this->member_username;}
        public function member_status(){return $this->member_status;}
        public function member_type(){return $this->member_type;}
        public function member_country(){return $this->member_country;}
        public function member_role(){return $this->member_role;}
        public function member_profile(){return $this->member_profile;}
        public function member_image(){
            return ($this->member_profile=="default.png") ? '<span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30 text-uppercase">'.($this->member_letter).'</span>' : '<div class="symbol-label" style="background-image:url(images/profile/'.$this->member_profile.')"></div>';
        }

        public function send_email($to, $sender, $html_body, $subject){
                  $curl = curl_init();
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($curl, CURLOPT_POST, 1);
                  curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                  curl_setopt($curl, CURLOPT_URL, "https://api.smtp2go.com/v3/email/send");
                  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(array(
                      "api_key" => 'api-816BDBEACB6F11ECAD4AF23C91C88F4E',
                      "to" => array(0 => $to),
                      "sender" => $sender,
                      "subject" => $subject,
                      "html_body" => $html_body,
                      "text_body" => $subject

                  )));
                $result = curl_exec($curl);
                $object = json_decode($result, true);
                if($object['data']['succeeded'] >= 1){
                  return true;
                }else{
                  return false;
                }
         }
   
        //PERMISSION ADMIN
        public function permission_admin($page){

        }
         //PERMISSION MEMBER
        public function permission_member($page){
          
        }
} 
?>