<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Serverside_Controller extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Serverside_model');
    }
    public function Serverside_Members(){
        error_reporting(0);
        $table = 'tbl_user';
        $column_where = false;
        $column_order = array(null, 'username','email','fname','lname','position','status');
        $column_search = array('username','email','fname','lname','position','status');
        $order = array('id' => 'asc');
        $data = $row = array();
        $selection ="*,DATE_FORMAT(date_registration,'%m/%d/%Y') AS date_registrations, CONCAT_WS(' ', fname, mname, lname) AS fullname,IF(cast(date_registration as Date) = cast(now() as Date),'new','old') AS new_member,(SELECT position FROM tbl_position WHERE id=tbl_user.position) as position";
        $memData = $this->Serverside_model->getRows($_POST,$table,$column_order,$column_search,$order,$column_where,$selection);
        $count = $_POST['start'];
        foreach($memData as $row){
            $count++;
             if($row->new_member=='new'){
                $user= '<div class="d-flex align-items-center flex-lg-row flex-column m-2 ribbon ribbon-clip ribbon-left">
                <div class="ribbon-target font-size-xs" style="top: -8px;padding: 1px 5px;">
                   <span class="ribbon-inner bg-danger"></span>New
                  </div>
                            <div class="symbol symbol-40  flex-shrink-0">
                                <img class="tba_image border border-dark" src="'.base_url('images/user_images/'.$row->image.'').'" >
                            </div>
                            <div class="ml-3"><span class="text-dark-75 font-weight-bold line-height-sm d-block pb-2">'.$row->fullname.'</span></div>
                        </div>';
            }else{
                $user= '<div class="d-flex align-items-center flex-lg-row flex-column m-2">
                            <div class="symbol symbol-40  flex-shrink-0">
                                <img class="tba_image border border-dark" src="../images/user_images/'.$row->image.'" alt="User profile">
                            </div>
                            <div class="ml-3"><span class="text-dark-75 font-weight-bold line-height-sm d-block pb-2">'.$row->fullname.'</span></div>
                        </div>';

            }
              $data[]=array($count,
                            $user,
                            $row->username,
                            $row->position,
                            $row->date_registrations,
                            $row->email,
                            $row->mobile,
                            $row->status,
                            $this->encryption->encrypt($row->id),
                          );
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside_model->countAll($table,$column_where,$selection),
            "recordsFiltered" => $this->Serverside_model->countFiltered($_POST,$table,$column_order,$column_search,$order,$column_where,$selection),
            "data" => $data,
        );
        echo json_encode($output);
    }
 
}