<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class SpreadSheetController extends CI_Controller {
    function __construct(){
       parent::__construct();
       $this->xlsx = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
       $this->csv = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
       $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();  
       $this->load->model('Spreadsheet_model');  
    }
     public function AdminAction(){
      $action = $this->input->post('action');
    

     }
      public function DownloadTemplate(){
             $spreadsheet = $this->spreadsheet;
             $sheet = $spreadsheet->getActiveSheet();
             $sheet->setCellValue('A1', 'Team');
             $sheet->setCellValue('B1', 'Code');
             $sheet->setCellValue('C1', 'Name');
             $sheet->setCellValue('D1', 'Submitted');
             $sheet->setCellValue('E1', 'Settled');
             $sheet->setCellValue('F1', 'AC');
             $sheet->setCellValue('G1', 'NSC');
             $sql = $this->db->select('*')->from('tbl_user')->get();
             $count = 2;
             foreach($sql->result() as $row){
                 $sheet->setCellValue('A' .$count, $row->name);
                 $sheet->setCellValue('B' .$count, $row->username);
                 $sheet->setCellValue('C' .$count, $row->fname.' '.$row->mname.' '.$row->lname);
                 $count++;
            }
            $file_name = 'template.xls';
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\xls($spreadsheet);
            $writer->save($file_name);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length:' . filesize($file_name));
            flush();
            readfile($file_name);
            exit;
      }
}
?>