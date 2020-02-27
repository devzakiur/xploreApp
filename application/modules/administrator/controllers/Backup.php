<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backup extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        /*
        |=============
        |   set header Cache control
        |=============
        */
        $this->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

        $this->session->set_userdata('set_active', "administrator");
        $this->session->set_userdata('top_menu', "administrator");

    }
    public function index()
    {
        if (!hasPermission("backup", VIEW)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }
        $this->session->set_userdata('sub_menu', "backup");
        $this->data['add'] = true;
        $this->layout->title("Backup Manage");
        $this->layout->view('backup', $this->data);
    }

    public function truncate()
    {
        // $this->db->truncate('batch');
        // $this->db->truncate('course');
        // $this->db->truncate('department');
        // $this->db->truncate('employee');
        // $this->db->truncate('employee_deg');
        // $this->db->truncate('form');
        // $this->db->truncate('payment');
        // $this->db->truncate('student');
    }
    /*
    |===============
    |   backup create
    |===============
    */
    public function create($type="all")
    {
        $this->load->dbutil();
        $tables = array('');
        $options = array(
            'format' => 'txt', // gzip, zip, txt
            'add_drop' => TRUE, // Whether to add DROP TABLE statements to backup file
            'add_insert' => TRUE, // Whether to add INSERT data to backup file
            'newline' => "\n"               // Newline character used in backup file
        );
        $file_name = 'system_backup_' . date("d-m-Y");
        $backup = &$this->dbutil->backup($options);
        write_file('uploads/backup/' . $file_name . '.sql', $backup);
        $this->load->helper('download');
        force_download($file_name . '.sql', $backup);
        setMessage("msg", "success", "Backup Created Sucessfully.");
        redirect("administrator/backup");
    }
    public function restore()
    {
        if($_POST)
        {
            if (isset($_FILES['file']['name']))
            {
                if($this->check_file_type())
                {
                    $this->restore_backup($_FILES['file']['name']);
                }
            }
        }
    }
    public function check_file_type()
    {
        if (isset($_FILES['file']['name'])) {
            $name = $_FILES['file']['name'];
            $arr = explode('.', $name);
            $ext = end($arr);
            if ($ext == 'sql') {
                return TRUE;
            } else {
                setMessage("msg", "success", "File Type Not Allowed.");
                redirect("administrator/backup");
            }
        }
    }
    /*
    |===============
    |   backup restore
    |===============
    */
    public function restore_backup($file_name)
    {
        $filePath = './uploads/backup/' . $file_name;
        if (file_exists($filePath)) {
            if ($this->restoreDatabaseTables($filePath)) {
                setMessage("msg", "success", "Backup Restored Sucessfully.");
                redirect("administrator/backup");
            }
        } else {
            setMessage("msg", "success", "File Not Exits.");
            redirect("administrator/backup");
        }
    }

    public function restoreDatabaseTables($filePath)
    {
        // Temporary variable, used to store current query
        $templine = '';

        // Read in entire file
        $lines = file($filePath);

        $error = '';

        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                if (!$this->db->query($templine)) {
                    $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $error . '<br /><br />';
                }
                // Reset temp variable to empty
                $templine = '';
            }
        }
        return !empty($error) ? $error : true;
    }
}

/* Location: ./application/modules/install/controllers/Install.php */
