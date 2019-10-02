<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class form extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('user/User_model','userM');
    }
	public function index()
	{
		$this->load->view('welcome_message');
    }
    
    public function show()
	{
        $this->load->view('public/header');
        $this->load->view('public/form_view');
        $this->load->view('public/footer');
    }
    
    public function proses()
	{
       $data = $this->input->post();
       $create = $this->userM->create($data);
       if ($create){
           echo "Sukses!!";
       }
    }

    public function tampil()
	{
       //$ids = array(1);
        $database = $this->userM->get();
       //echo "<pre>";
       //var_dump($database);
       $data['list'] = $database;
       $this->load->view('public/header');
       $this->load->view('public/User_list',$data);
       $this->load->view('public/footer');

    }

    public function detail($id)
	{
       
        $database = $this->userM->get($id);
        $data['detail'] = $database[0];
       
       // echo "<pre>";
       //var_dump($database[0]);
       $this->load->view('public/form_detail',$data);

    }

}
