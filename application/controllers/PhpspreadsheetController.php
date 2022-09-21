<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    class PhpspreadsheetController extends CI_Controller 
    {
            public function __construct()
            {
                     parent::__construct();
            }

            public function index()
            {
                $this->load->view('spreadsheet');
            }

                public function export()
        {
                        /*
                        * File path $rootfile
                        */
                $rootfile='name-of-the-generated-file.xlsx';//template file name
                 $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                 $spreadsheet = $reader->load($rootfile);
                    $writer = new Xlsx($spreadsheet);
                    
                    $sheetData = $spreadsheet->getActiveSheet();//->toArray();

                    /**
                    *Dynamic Data will write in the existed sheet
                    *
                    **/

                    for ($i=2; $i < 20; $i++) 
                { 
                    //writing Name
                    $sheetData->setCellValue('A'.$i,'Ramesh');
                   

                    //writing Roll Number
                    $sheetData->setCellValue('B'.$i,'100'.$i);
                
                }
                   

                $filename = rand(100,999)."test";

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
                header('Cache-Control: max-age=0');
                $writer->save('php://output'); /* download file */
        }

    public function import()
    {
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
            if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes))
            {
                        $arr_file = explode('.', $_FILES['upload_file']['name']);
                        $extension = end($arr_file);

                        if('csv' == $extension)
                        {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        } 
                        else 
                        {
                        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        }


                        /*
                        * File path $rootfile
                        */
                        $rootfile='name-of-the-generated-file.xlsx';

                    //$spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
                        $spreadsheet = $reader->load($rootfile);
                    
                    $sheetData = $spreadsheet->getActiveSheet()->toArray();
                    echo "<pre>";
                    print_r($sheetData);
            }
    }
}