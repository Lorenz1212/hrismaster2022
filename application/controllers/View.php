<?php defined('BASEPATH') OR exit('No direct script access allowed');
class View extends CI_Controller {
    function __construct(){
       parent::__construct();
    }
    public function AdminView($view='dashboard'){
        $view = explode('_', strtolower($view))[0];
        if($this->session->userdata('adminview')){
             $this->load->view('admin/content');
             switch ($view){
                  case 'dashboard':{$this->session->set_userdata('adminview',$view);break;}
                  case 'profile':{$this->session->set_userdata('adminview',$view);break;}  
                  case 'employee':{$this->session->set_userdata('adminview',$view);break;}  
                  case 'employee-info':{$this->session->set_userdata('adminview',$view);break;}
                  default: {redirect(base_url().'view/adminview/dashboard');break;} 
             }
        }else{
             redirect(base_url().'authentication/adminlogin');
        }
   }
    public function adminpage(){
        if($this->input->post('page')){
            $view = explode('_', strtolower($this->input->post('page')))[0];
               $this->load->view('admin/view/'.$view);;
        }
    }
    public function logout(){
        $data = $this->session->userdata('adminview');
        foreach($data as $row => $rows_value){$this->session->unset_userdata($row);}
        delete_cookie($this->appinfo->sess_name().'_admin_user');
        delete_cookie($this->appinfo->sess_name().'_admin_auth');
        redirect(base_url().'authentication/adminlogin');
    }
}
?>