<?php 
class Admin_Model extends CI_Model {
    function __construct() {
      $cookie = json_decode($this->encryption->decrypt($this->input->cookie($this->appinfo->sess_name().'_admin_user', TRUE)),TRUE);
      $this->admin_id = element($this->appinfo->sess_name().'_ADMIN_ID', $cookie);
      $this->admin_role = element($this->appinfo->sess_name().'_ADMIN_ROLE', $cookie);
      $this->admin_remember = $this->session->userdata('admin_days_to_remember');
    }
    private function setCookies($data, $days){
         $user = array('name' => 'sunlife_admin_user','value'=> $this->encryption->encrypt(json_encode($data)),'expire' => time() + (86400 * $days),'secure' => TRUE);
        $this->input->set_cookie($user);
    }
    private function _set_data($result){
        $data = array(
          $this->appinfo->sess_name().'_ADMIN_ID'=>$result->id,
          $this->appinfo->sess_name().'_ADMIN_FNAME'=>$result->fname, 
          $this->appinfo->sess_name().'_ADMIN_LNAME'=> $result->lname, 
          $this->appinfo->sess_name().'_ADMIN_UNAME'=>$result->username, 
          $this->appinfo->sess_name().'_ADMIN_EMAIL'=>$result->email, 
          $this->appinfo->sess_name().'_ADMIN_PROFILE' =>$result->profile_img, 
          $this->appinfo->sess_name().'_ADMIN_AdSTATUS'=>md5("active"), 
          $this->appinfo->sess_name().'_ADMIN_TYPE'=>md5('admin'),
          $this->appinfo->sess_name().'_ADMIN_COUNTRY'=>$result->country,
          $this->appinfo->sess_name().'_ADMIN_ROLE'=>$result->role  
        );
        $this->session->set_userdata($data);
        return $data;
    }
    private function move_to_folder($image,$tmp,$path,$table,$column,$name,$size){
         $newimage=$this->Get_Image_Code($table, $column, $name, $size, $image);
         $path_folder = $path.$newimage;
         copy($tmp, $path_folder);
         return $newimage;
    }
    private function move_to_folder_resize($image,$tmp,$path,$targetWidth,$targetHeight,$table,$column,$name,$size){
      $newimage=$this->Get_Image_Code($table, $column, $name, $size, $image);
      $extension=pathinfo($image, PATHINFO_EXTENSION);
      $path_folder = $path.$newimage;
      list($width, $height) = getimagesize($tmp);
      $file = $this->imageType($extension,$path_folder,$tmp,$targetWidth,$targetHeight,$width,$height);
        if($file == true){
          return $newimage;
        }else{
          return false;
        }
    }
    private function imageType($extension,$path_folder,$tmp,$targetWidth,$targetHeight,$width,$height){
       if($extension=='png' || $extension=='PNG'){
               $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
               $imageResourceId = imagecreatefrompng($tmp); 
               if(!imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight,$width,$height)){
                   return false;
             }else{
                  imagepng($targetLayer,$path_folder);
                return true;
             }
       }else if($extension=='jpg'  || $extension=='jpeg' || $extension=='JPG' || $extension=='JPEG'){
                $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
                $imageResourceId = imagecreatefromjpeg($tmp); 
                if(!imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight,$width,$height)){
                   return false;
             }else{
                  imagejpeg($targetLayer,$path_folder);
                return true;
             }
       }
    }
    private function Ac_Code($key, $length){ 
      $random="";srand((double)microtime()*1000000);
      $data = "ABCDEFGHJKLMNPQRSTUVWXYZ"; 
      $data .= "123456789"; 
      $data .= "54321ABCXVXV6789";
      for($i = 0; $i < $length; $i++) {

        $random .= substr($data, (rand()%(strlen($data))), 1);
      }
      return $key.$random; 
    }
   private function Get_Image_Code($table, $column, $key, $length, $image){
      $code = $this->Ac_Code($key, $length);
      if($code){
        $arr_image = explode('.', $image);
        $fileActualExt = strtolower(end($arr_image));
        $newimage = $code."-".str_replace(array( '-', '_', ' ', ',' , '(', ')'), '', $arr_image[0]).".". $fileActualExt;
        $check = $this->Check_Code($table, $column, $newimage);
        while ($check){
          $code = $profile_trans->get_code();
          if($code){
            $arr_image = explode('.', $image);
            $fileActualExt = strtolower(end($arr_image));
            $newimage = $code."-".str_replace(array( '-', '_', ' ', ',' , '(', ')'), '', $arr_image[0]).".". $fileActualExt;
            $check = $this->Check_Code($table, $column, $newimage);
          }else{
            return false;
          }
        }
      }else{
        return false;
      }
      return $newimage;
  }
  private function Get_CODE($table, $column, $key, $length){
       $gen_code = new TransGen($key, $length);
         $code = $gen_code->get_code();
         if($code){
             $check = $this->Check_Code($table, $column, $code);
              while ($check){
            $code = $gen_code->get_code();
            if($code){
              $check = $this->Check_Code($table, $column, $code);
            }else{
                  return false;
            }
        }
      }else{
        return false;
      }
          return $code;
        }
   private function Check_Code($table, $column, $code){
      $query = $this->db->select($column)->from($table)->where($column,$code)->get();
      if($query->num_rows() >= 1){ 
            return true;
        }else{
            return false;
          }
    }
    private function Generate_Random_Code($length,$type,$delimeter){
      $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $str = '';
      $max = mb_strlen($keyspace, '8bit') - 1;
      if ($max < 1) {
          throw new Exception('error');
      }
      for ($i = 0; $i < $length; ++$i){
          $str .= $keyspace[random_int(0, $max)];
      }
      return $type.$delimeter.$str;
    }
    private function _error($type,$description,$username){
       $sql="INSERT INTO tbl_error_execution (type,description,username) VALUES('$type','$description','$username')";
       $result=$this->crud->execute($sql);
       return true;
    } 
    function Get_Date($type,$id){
      switch($type){
        case"fetch_date_target":{
          $row = $this->db->select('YEAR(date_from) as from_year,YEAR(date_to) as to_year')->from('tbl_generate_date')->where('id',$id)->get()->row();
          if($row){
            return $row;
          }else{
            return false;
          }
          break;
        }
      }
    }
    private function Get_Region(){
    $data=array();
    $sql = $this->db->select('*')->from('refregion')->get();
    if(!$sql){
    }else{
      foreach ($sql->result() as $row) {
        $data['region'][] = array(
        'location' => $row->regDesc,
        'code' => $row->regCode
        );
      }
    }
      return $data;
  }
  private function Get_Province($region){
    $sql = $this->db->select('*')->from('refprovince')->where_in('regCode',$region)->get();
    if(!$sql){
    }else{
      foreach ($sql->result() as $row) {
        $data['province'][] = array(
        'location' => $row->provDesc,
        'code' => $row->provCode
        );
      }
    }
      return $data;
  }
  private function Get_City($province){
    $sql = $this->db->select('*')->from('refcitymun')->where_in('provCode',$province)->get();
    if(!$sql){
    }else{
      foreach ($sql->result() as $row) {
        $data['city'][] = array(
        'location' => $row->citymunDesc,
        'code' => $row->citymunCode
        );
      }
    }
      return $data;
  }
  private function Get_Barangay($city)
  {
    $sql = $this->db->select('*')->from('refbrgy')->where_in('citymunCode',$city)->get();
    if(!$sql){
    }else{
      foreach ($sql->result() as $row) {
        $data['brgy'][] = array(
        'location' => $row->brgyDesc,
        'code' => $row->brgyCode
        );
      }
    }
      return $data;
  }
      public function Address($type,$val){
      switch ($type) {
        case 'fetch_region':{
          return $this->Get_Region();
          break;
        }
        case 'fetch_province':{
          return $this->Get_Province($val);
          break;
        }
        case 'fetch_city':{
          return $this->Get_City($val);
          break;
        }
        case 'fetch_barangay':{
          return $this->Get_Barangay($val);
          break;
        }
        default:
          return false;
          break;
      }
    }
   public function Profile($type,$image,$tmp,$avatar,$imgtype){
    $data_country=array();
    $data_response=array();
    $data_avatar=array();
    switch ($type) {
      case 'profile':{
        $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
        if(!$result){
          return false;
          break;
        }else{
          $data_response['profile']=$result;
          //Select Country
            $sql = $this->db->select('*')->from('tbl_country')->get();
            if(!$sql){
            }else{
              foreach ($sql->result() as $row) {
                $data_country['country'][]=array(
                  'iso' => $row->iso,
                  'name' => $row->name,
                  'country_name' => $row->country_name,
                  'phonecode' => $row->phonecode
                  );
              } 
           }   
        }
        return array_merge($data_response,$data_avatar,$data_country);
        break;
      }
      case 'save_profile_image':{
        $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
        if(!$result){
          $data_response = array(
            'result' => false,
            'type' => 'error',
            'message' => 'Failed to upload image'        
          );
        }else{
          $arr = explode('-', $result->profile_img);
          if($result->profile_img != 'default.png' && $arr[0] != 'avatar'){
            if(file_exists("images/profile/".$result->profile_img)){
              unlink("images/profile/".$result->profile_img);
            }
          }
          if($imgtype == "avatar"){
                  $this->db->where('id',$id);
                  $result=$this->db->update('tbl_administrator',array('profile_img'=>$avatar));
                  if(!$result){
                    $data_response = array(
                      'result' => false,
                      'type' => 'info',
                      'message' => 'Nothing changes'        
                    );
                  }else{
                  $data=array();
                  $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
                  $data = $this->_set_data($result);
                  $remember=(isset($this->admin_remember))? $this->admin_remember:1;
                  $this->setCookies($data, $remember);
                  if($result){
                        $data_response = array(
                          'result' => true,
                          'type' => 'success',
                          'message' => 'Save changes',
                          'image' => $avatar        
                        );
                      }else{
                          $data_response = array(
                            'result' => true,
                            'type' => 'success',
                            'message' => 'Save changes',
                            'profile_img' => $avatar           
                          );
                      }
                  }
          }else{
            $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
            if($image){
                 $newimage=$this->move_to_folder_resize($image,$tmp,'images/profile/',200,200,'tbl_administrator','profile_img','IMAGE',14);
                  $this->db->where('id',$this->admin_id);
                  $result=$this->db->update('tbl_administrator',array('profile_img'=>$newimage));
                    if(!$result){
                              $data_response = array(
                          'result' => false,
                          'type' => 'info',
                          'message' => 'Nothing changes'        
                        );
                    }else{
                      $data=array();
                      $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
                      $data = $this->_set_data($result);
                      $remember=(isset($this->admin_remember))? $this->admin_remember:1;
                      $this->setCookies($data, $remember);
                    if($result){
                      $data_response = array(
                        'result' => true,
                        'type' => 'success',
                        'message' => 'Save changes',
                        'profile_img' => $newimage            
                      );
                    }else{
                        $data_response = array(
                        'result' => true,
                        'type' => 'success',
                        'message' => 'Save changes',
                        'profile_img' => $newimage            
                      );
                    }
                    }
                }else{
                      $data_response = array(
                    'result' => false,
                    'type' => 'error',
                    'message' => 'Failed to move upload image'        
                  );
                }
          }

        }
        return $data_response;
        break;
          
      }
      
      default:
        return false;
        break;
    }
  }
  public function Save_User_Profile($type,$fname,$lname,$mname,$city,$country,$phonecode,$mobile,$c_password,$n_password,$v_password){
        $data_response=array();
        switch ($type) {
          case 'save_personal_info':{
            $this->db->where('id',$this->admin_id);
            $result= $this->db->update('tbl_administrator',array('fname'=>$fname,'lname'=>$lname,'mname'=>$mname));
             if(!$result){
                return false;
              }else{
                  $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
                  if($result){
                    $data = $this->_set_data($result);
                    $remember=(isset($this->admin_remember))? $this->admin_remember:1;
                    $this->setCookies($data, $remember);
                    return true;
                  }else{
                    return true;
                  }
              }
            break;
          }
          case 'save_contact_info':{
            $this->db->where('id',$this->admin_id);
            $result= $this->db->update('tbl_administrator',array('country'=>$country,'city'=>$city,'phone_code'=>$phonecode,'phone'=>$mobile));
            if(!$result){
                return false;
              }else{
                  $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
                  if($result){
                  $data = $this->_set_data($result);
                  $remember=(isset($this->admin_remember))? $this->admin_remember:1;
                  $this->setCookies($data, $remember);
                  return true;
                }else{
                return true;
                }
              }
            break;
          }

          case 'save_change_pass':{
           $result = $this->db->select('*')->from('tbl_administrator')->where('id',$this->admin_id)->get()->row();
              if(!$result){
                return false;
                break;
              }else{
                if($result->password != md5($c_password)){
                  return 'incorrect_pass';
                  break;
                }else{
                    if(md5($n_password)!= md5($v_password)){
                      return false;
                      break;
                    }else{
                    $v_password = md5($v_password);
                    $this->db->where('id',$this->admin_id);
                    $result= $this->db->update('tbl_administrator',array('password'=>$v_password));
                      if(!$result){
                        return false;
                        break;
                      }else{
                        return true;
                        break;
                      }
                    }
                  }
              }
          }
          default:
          return false;
          break;
      }
    }


     public function Members($type,$val){
      $type = $this->crud->escape_string($type);
        $val = $this->customcrypt->getDecrypt(base64_decode($val));
        $data_country=array();
        $data_user=array();
        $data_dash=array();
        $data_link=array();
        $accounts=$this->Get_Accounts($this->Get_User_Name($val));
        switch ($type) {
          case 'view_members_user':{
            $sql="SELECT *,(SELECT IFNULL(SUM(amount),0.00) FROM tbl_user_commission WHERE owner='$val' AND status=1 AND (type<>'DS_COMM' AND type<>'WALLET_FUND' AND transfer<>1)) AS user_comm,(SELECT IFNULL(SUM(income),0.00) FROM tbl_payout_details WHERE user_id='$val' AND status='S') AS user_income,(SELECT IFNULL(SUM(amount),0.00) FROM tbl_user_gensales WHERE owner='$val') as generated_sales,(SELECT password FROM tbl_password_override WHERE password_type='member') as password,(SELECT IFNULL(SUM(d.price),0.00)  AS product_gensales  FROM tbl_cart_details d RIGHT JOIN tbl_cart_header h ON d.cart_id=h.id WHERE h.user_id IN ($accounts) AND (d.product_type='BUNDLE' OR d.product_type='ITEM') AND h.cart_type!='package' AND h.cart_type!='package-order' AND (h.status='REQUESTED' OR h.status='PROCESSING' OR h.status='IN-TRANSIT' OR h.status='DELIVERED' OR h.status='COMPLETED' OR h.status='REMITTED')) AS product_gensales,(SELECT direct_login FROM tbl_password_override WHERE password_type='member') as direct_login FROM tbl_user WHERE id='$val'";
              $this->db->query($sql);
          if(!$result){
             return false;
          }else{
            $data_user['user']=$result;
            $data = array();
                    $n="";
            if($result['direct_login'] == 1){
                        $n=$result['password'];
                    }
                array_push($data, $result['email'], $this->User_Data('admin_UID'));
            $token = base64_encode($this->customcrypt->getEncrypt(json_encode($data)));
              if($token){
                      if($n != ""){
                        $data_link['link']=$this->config->Link().'/members/login/?admin_token='.$token.'&user_email='.$result['email'].'&n='.$n; 
                    }else{
                        $data_link['link']=$this->config->Link().'/members/login/?admin_token='.$token.'&user_email='.$result['email']; 
                    }
                }else{
                  $data_link['link']=$this->config->Link();
                }
            $sql="SELECT * FROM tbl_country WHERE status=1";
            $result=$this->crud->getData($sql);
            if(!$result){
            }else{
              foreach ($result as $row) {
                  $data_country['country'][] = array (  
                      'name' => $row['name'],
                      'iso' => $row['iso'],
                      'phonecode' => $row['phonecode'],
                  );  
              }
            }
          
            return array_merge($data_user,$data_country,$data_link);
          }
          break;
          }

          default:
            return false;
            break;
        }
    }

    //PUBLIC END
    function Chart($type,$date){
      switch($type){
        case "chart_validation":{
           $data = false;
           $query = $this->db->select('*')->from('tbl_team')->where('status',1)->get();
            foreach($query->result() as $row){
              $sales = $this->db->select('sum(g.submitted) as submitted,sum(g.settled) as settled,sum(g.ac) as ac,sum(g.nsc) as nsc')->from('tbl_generate_sales as g')->join('tbl_advisor as a','g.advisor_code=a.advisor_code','LEFT')->join('tbl_team as t','t.id=a.team','LEFT')->where('g.generate_date',$date)->where('g.type',1)->where('t.id',$row->id)->group_by('a.team')->get()->row();
                if($sales){
                   $data[]= array('team'=>$row->name,
                                  'submitted'=>$sales->submitted,
                                  'settled'=>$sales->settled,
                                  'ac'=>$sales->ac,
                                  'nsc'=>$sales->nsc);
                }
            }
            return $data;
          break;
        }
         case "chart_validation_submitted":{
           $data = false;
           $query = $this->db->select('*')->from('tbl_team')->where('status',1)->get();
            foreach($query->result() as $row){
              $sales = $this->db->select('sum(g.submitted) as submitted,sum(g.settled) as settled')->from('tbl_generate_sales as g')->join('tbl_advisor as a','g.advisor_code=a.advisor_code','LEFT')->join('tbl_team as t','t.id=a.team','LEFT')->where('g.generate_date',$date)->where('g.type',1)->where('t.id',$row->id)->group_by('a.team')->get()->row();
                if($sales){
                   $data[]= array('team'=>$row->name,
                                 'submitted'=>$sales->submitted,
                                 'settled'=>$sales->settled);
                }
            }
            return $data;
          break;
        }
      }
    }
}
?>