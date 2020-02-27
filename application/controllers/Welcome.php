<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
	}
	
	public function index($module="dashboard")
	{
		$this->load->view('welcome_message');
	}
	public function test()
	{
		// Load the spreadsheet reader library
		if($_POST)
		{
			$fileName = $_FILES['csv_file']['name'];
			$uploadData = array();
			if (!empty($fileName)) {
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'txt|csv|xls|xlsx';
				$config['max_size'] = 2048;
				$config['remove_spaces'] = TRUE;
				$config['encrypt_name'] = TRUE;
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('csv_file')) {
					json_error("File Upload Error", $this->upload->display_errors(), 400);
				} else {
					$uploadData = array('upload_data' => $this->upload->data());
				}
			}//if
			if (!empty($uploadData)) {
				$fileName = $uploadData['upload_data']['file_name'];
				$data = array(); //empty array;
				$handle = fopen(base_url() . 'uploads/' . $fileName, "r");
				$i = 0;
				$row=0;
				$temp_data=array();
				$insert_data=array();
				$data = fgetcsv($handle, 1000, ",");
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					echo "<p> $num fields in line $row: <br /></p>\n";
					$row++;
					for ($c=0; $c < $num; $c++) {
						$temp_data['company_id']=$data[0];
						$temp_data['branch_id']=$data[1];
						$temp_data['name']=$data[2];
						$temp_data['marketing_id']=$data[3];
						$temp_data['owner_name']=$data[4];
						$temp_data['address']=$data[5];
						$temp_data['email']=$data[6];
						$temp_data['tel']=$data[7];
						$temp_data['national_id']=$data[8];
						$temp_data['trade']=$data[9];
						$temp_data['security_cheque']=$data[10];
						$temp_data['bank_id']=$data[11];
						$temp_data['amount']=$data[12];
						$temp_data['code']=$row;
					}
					$insert_data[$i]=$temp_data;
					$i++;
					echo "<br />\n";
				}
				debug_r($insert_data);
				// print_r($data);
				fclose($handle);
			}

		}
		$this->load->view('test');
		
	}
	
}
