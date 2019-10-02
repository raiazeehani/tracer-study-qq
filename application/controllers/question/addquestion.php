<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class addquestion extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('user/User_model','userM');
        $this->load->model('question/Quetion_model','qM');
        $this->load->model('answer/Answer_model','aM');
    }

    public function index()
	{
		$this->load->view('welcome_message');
    }
    public function show()
    {
        
        $this->load->view('public/header');
        $this->load->view('public/form_add');
        $this->load->view('public/footer');

    }

    public function proses()
	{
		$data = $this->input->post();
        $create = $this->qM->create($data);
        

        if ($create){
            echo "Sukses!!";
            }else {
                echo "Gagal!!";
    }
    }
    public function getJson()
	{
        $data=$this->qM->get();
        echo json_encode($data);
    }

}