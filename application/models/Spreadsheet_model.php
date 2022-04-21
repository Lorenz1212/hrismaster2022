<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Spreadsheet_model extends CI_Model {
    function __construct() {
      $cookie = json_decode($this->encryption->decrypt($this->input->cookie('sunlife_admin_user', TRUE)),TRUE);
      $this->admin_id = element('TREE_ADMIN_ID', $cookie);
      $this->admin_role = element('TREE_ADMIN_ROLE', $cookie);
      $this->admin_remember = $this->session->userdata('admin_days_to_remember');
    }
	private function _getmonth($month) {
		switch($month){
			case"1":{return 'January'; break;}
			case"2":{return 'February'; break;}
			case"3":{return 'March'; break;}
			case"4":{return 'April'; break;}
			case"5":{return 'May'; break;}
			case"6":{return 'June'; break;}
			case"7":{return 'July'; break;}
			case"8":{return 'August'; break;}
			case"9":{return 'September'; break;}
			case"10":{return 'October'; break;}
			case"11":{return 'November'; break;}
			case"12":{return 'December'; break;}
		}
	}
   
}
?>
