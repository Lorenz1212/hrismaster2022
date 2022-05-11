<?php 
class Authentication_Model extends CI_Model {
    private function setCookies($token, $data, $days,$type,$role){
        $auth = array('name' =>$type.'_'.$role.'_auth','value'=> $token,'expire' => time() + (86400 * $days),'secure' => FALSE);
        $this->input->set_cookie($auth);
        $user = array('name' => $type.'_'.$role.'_user','value'=> $this->encryption->encrypt(json_encode($data)),'expire' => time() + (86400 * $days),'secure' => TRUE);
        $this->input->set_cookie($user);
    }
    private function User_Data($type){
        return $this->input->cookie('ADMIN_'.$type,true);
    }
     private function TODAY(){
       date_default_timezone_set('Asia/Manila');
       $datestamp = date("Y-m-d");
       $timestamp = date("H:i:s");
       return $now = $datestamp.' '.$timestamp;
    }
    private function _set_data($type,$role,$result){
        $data = array(
          $type.'_'.$role.'_ID'=>$result->id,
          $type.'_'.$role.'_FNAME'=>$result->fname, 
          $type.'_'.$role.'_LNAME'=> $result->lname, 
          $type.'_'.$role.'_UNAME'=>$result->username, 
          $type.'_'.$role.'_EMAIL'=>$result->email, 
          $type.'_'.$role.'_PROFILE' =>$result->profile_img, 
          $type.'_'.$role.'_AdSTATUS'=>md5("active"), 
          $type.'_'.$role.'_TYPE'=>md5("admin"),
          $type.'_'.$role.'_COUNTRY'=>$result->country, 
          $type.'_'.$role.'_ROLE'=>$result->role  
        );
        $this->session->set_userdata($data);
        return $data;
      }
     function Login_Admin($email,$password,$remember){  
            error_reporting(0);  
            $remember = ($remember) ? 30 : 1;
            //GET first 9 digit of NEW IP ADDRESS
            $ip_address_main=$this->input->ip_address();
            $arr = explode(".",$ip_address_main);
            unset($arr[3]);
            $ip_address = implode(".",$arr);

            $data_response = array();
            $admin = $this->db->select('*')->from('tbl_administrator')->where('password="'.md5($password).'" AND (email="'.$email.'" OR username="'.$email.'")')->get()->row();
            if(!$admin){
              return 'Login failed! wrong username/password.';
            }else{
              if($admin->status=='0'){
                return 'Sorry, your account is deactivated. You cannot sign-in right now.';
              }else if($admin->status=='2'){
                return 'Sorry, your account is temporary on-hold. Please try again later.';
              }
              $email=$admin->email;
              $token="";
              $data = array();
              //GET first 9 digit of OLD IP ADDRESS
              $arr = explode(".",$admin->ipadd_prev);
              unset($arr[3]);
              $ip_address_prev = implode(".",$arr);

              //CHECK IF IP ADDRESS WAS CHANGE
              if($ip_address_prev == $ip_address || $row->ipadd_prev === null){
                $this->db->where('email',$email);
                $this->db->update('tbl_administrator',array('ipadd_prev'=>$ip_address_main));
                $token = md5($admin->username.''.$this->TODAY().''.$ip_address_main);
                $device = "setupbrowsecap";
                $admin_id=$admin->id;
                $data = $this->_set_data($this->appinfo->sess_name(),'ADMIN',$admin);
                $result = $this->db->query("INSERT INTO tbl_administrator_login_details (admin_id, expiration, device, ip_add, token, token_status, role) VALUES ('".$admin->id."', DATE_ADD(NOW(), INTERVAL ".$remember." DAY), '$device', '$ip_address_main', '$token', '1','".$admin->role."') ON DUPLICATE KEY UPDATE login_date= VALUES(login_date), expiration= VALUES(expiration), device= VALUES(device), ip_add= VALUES(ip_add), token= VALUES(token), token_status= VALUES(token_status), role= VALUES(role)");
                if($result){
                  $this->session->set_userdata('admin_days_to_remember',$remember);
                  $this->session->set_userdata('adminview','dashboard');
                  $this->setCookies($token, $data, $remember,$this->appinfo->sess_name(),'admin');
                  return array('url'=>'view/adminview/dashboard');
                }else{
                   return 'Opsss, Something went wrong, Please try again later.';
                }
              }else{
                $pin = random_int(100000, 999999);
                $this->db->query("UPDATE tbl_administrator SET ipadd_pin='$pin', expiry= DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email='".$email."'");
                 return 'ip_check';
              }
            }
          }
    public function Admin_Login_Forgotpass($email){
      $email= strtolower($email);
      $token = bin2hex(random_bytes(32));
      $hashedToken = md5(hex2bin($token));
      if($email == 'forgot_pass_in'){
        $email = $this->appinfo->admin_email();
      }
      $hash_email=$this->encryption->encrypt($email);
      $url = base_url()."authentication/admin_forgotpass?token=".$hash_email."&validator=".$token;
      $sql = "SELECT fname, email, (SELECT expiry FROM tbl_user_reset_pass WHERE email = '$email' AND status IS NULL AND expiry > NOW() LIMIT 1) AS expiry FROM tbl_administrator WHERE email = '$email' LIMIT 1";
      $result = $this->db->query($sql)->row();
      if($result){
        if(!empty($result->expiry)){
          return 'Opps, We have already sent you an email to reset your password. Please check your email.';
          exit();
        }else{
          try{
              $notify = $this->Email_model->notify_user("forgot-pass", $url, strtolower($result->email), $result->fname);
              $sql = "INSERT INTO tbl_user_reset_pass (email, hash, expiry) VALUES ('$email', '$hashedToken', DATE_ADD(NOW(), INTERVAL 10 MINUTE))";
              $result = $this->db->query($sql);
              if($result){
                return true;
              }else{
                return 'Reset password is unavailable at this moment';
              }
          }catch(Exception $e){
            return 'Reset password is unavailable at this moment';
          }
        }
      }else{
        return "Sorry, We can&apos;t find that email.";
      }
    }
    public function Admin_Login_Resetpass($token, $validator, $password){
        $password = md5($password);
        $hashedToken = md5(hex2bin($validator));
        $email = $this->encryption->decrypt($token);
        $email = str_replace('"', '', $email);

        if(ctype_xdigit($validator) != true ){
          return "It seems that this link is invalid.";
          exit();
        }else{
          if(strlen($validator) % 2 != 0 ){
            return "It seems that this link is invalid.";
            exit();
          }else{
            $sql = "SELECT * FROM tbl_user_reset_pass WHERE email = '$email' AND hash='".$hashedToken."' AND status IS NULL LIMIT 1";
            $result = $this->db->query($sql)->row();
            if($result){
              if($result->expiry < $this->TODAY()){
                return "This link is already expired!";
              }else{
                $sql = "UPDATE tbl_user_reset_pass SET status = '1' WHERE id='".$result->id."'";
                if($this->db->query($sql)){
                  $sql = "UPDATE tbl_administrator SET password = '$password' WHERE email = '".$result->email."'";
                  if($this->db->query($sql)){
                    return true;
                  }else{
                    return false;
                  }
                }else{
                  return false;
                }
              }
            }else{
              return "It seems that this link is invalid.";
            }
          }
        }
      }

}
?>