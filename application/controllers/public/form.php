<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class form extends CI_Controller {

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
        $database = $this->qM->get();
        if ($database){

            $questionArray = array();
            foreach ($database as $row){
                $questionInside = $row;

                if($row['type']=="select"){
                    $optionArray = explode(PHP_EOL,$row['options']);
                    //var_dump($optionArray);
                    $questionInside['options_array']= $optionArray;
                }
                $questionArray[]=$questionInside;
            }
           $data['questions'] = $questionArray;
         
        }
        $data['detail'] = $database;

        
        $this->load->view('public/header');
        $this->load->view('public/form_view',$data);
        $this->load->view('public/footer');
    }
    
    public function proses()
	{
       $data = $this->input->post();
       //echo "<pre>";
       //var_dump($data);
       //exit;
       
       $questions = $data['question'];
       unset($data['question']);

       $create = $this->userM->create($data);
       $lastID = $this->db->insert_id();
       $newQuestions=array();
       foreach($questions as $index=>$row){
           $newQuestions[] = array(
               'question_id' => $index,
               'the_answer'=>$row,
               'personal_info_id' => $lastID,
           );
       }
       //echo "<pre>";
       //var_dump($newQuestions);
       $insertBanyak = $this->aM->create($newQuestions,TRUE);

       if ($insertBanyak){
           echo "Sukses!!";
           }else {
               echo "Gagal!!";
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

        $answer = $this->aM->get($database[0]['id'],'personal_info_id');
       
       

       $data['answer'] = $answer;

       $questionIds=array();
       foreach ($answer as $row){
           $questionIds[] = $row['question_id'];
       }
       
       $question =$this->qM->get($questionIds);
       

       $questionNew=array();
       foreach($question as $row){
           $questionNew[$row['question_id']] = $row;
       }
       //echo "<pre>";
      // var_dump($questionNew);
      $data['question'] = $questionNew;

       $this->load->view('public/form_detail',$data);

    }

}
