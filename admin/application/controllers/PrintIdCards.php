<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PrintIdCards extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->isLogedIn();
        $this->load->model('PrintIdCards_model', 'model');
        $this->load->library('excel');
    }

    public function index($batch_id) {
        
        $requests = array(
          'batch_id'=>$batch_id
        );
        $data['cards'] = $this->model->getAllStudentsIdCardDetails($requests);
        $data['batch_id'] = $batch_id;
        $this->load->view('print_id_cards_view', $data);
    }

    public function copyStudentsImages($data) {
        foreach ($data as $val) {
            $src = $val->file_url;
            $dest = 'cards/images/' . $val->id . '.jpg';
            $data = file_get_contents($src);
            file_put_contents($dest, $data);
            //echo '<img src="' . base_url('cards/images/' . $val->id . '.jpg') . '" height="200">';
        }
    }

    public function printCards() {
        
        $requests = array(
          'batch_id'=>$this->input->post('batch_id')
        );

        $response = $this->model->getAllStudentsIdCardDetails($requests);
        
                
        $valid_from = dateFromat($this->input->post('valid_from'));
        $valid_to = dateFromat($this->input->post('valid_to'));
        
        $filename = "bluecards_".$requests['batch_id'].".xls";
        $data = $response->payload->cards;
        $this->copyStudentsImages($data);
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle('Yellow Cards');
        //set cell A1 content with some text
        //$this->excel->getActiveSheet()->setCellValue('A1', 'Balance Report');
        $this->excel->getActiveSheet()->setCellValue('A1', 'Id');
        $this->excel->getActiveSheet()->setCellValue('B1', 'Registration No.');
        $this->excel->getActiveSheet()->setCellValue('C1', 'Name');
        $this->excel->getActiveSheet()->setCellValue('D1', 'Course');
        $this->excel->getActiveSheet()->setCellValue('E1', 'Date Of Admission');
        $this->excel->getActiveSheet()->setCellValue('F1', 'Validity');
        $this->excel->getActiveSheet()->setCellValue('G1', 'Temporary Address');
        $this->excel->getActiveSheet()->setCellValue('H1', 'Permanent Address');

        $exceldata = "";
        foreach ($data as $row) {
            $exceldata[] = array(
              $row->id,
              getRegNo($row),
              $row->fname,
              $row->course_code,
              $valid_from,
              $valid_to,
              $row->local_address,
              $row->permanant_address
            );
        }

        //Fill data 
        $this->excel->getActiveSheet()->fromArray($exceldata, null, 'A2');
        //header('Content-Type: application/vnd.ms-excel'); //mime type
        //header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
        //force user to download the Excel file without writing it to server's HD
        //$objWriter->save('php://output');
        $objWriter->save('cards/' . $filename);
        $this->createZipFile();
    }

    public function createZipFile() {
        $dir = 'cards';
        $zip_file = 'cards/cards.zip';

// Get real path for our folder
        $rootPath = realpath($dir);

// Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
          new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }

// Zip archive will be created only after closing object
        $zip->close();

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($zip_file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zip_file));
        readfile($zip_file);
    }

}
