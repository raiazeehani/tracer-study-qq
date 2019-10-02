<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quetion_model extends CI_Model {

    var $tableName, $tableId;
    function __construct(){
        parent::__construct();
        $this->tableName = "question";
        $this->tableId = "question_id";
    }

    function create($data,$banyak=false){
        if ($data){
            if($banyak){
                $query = $this->db->insert_batch($this->tableName, $data);
            }else{
                $query = $this->db->insert($this->tableName, $data);
            }
                return $query;
        }
    }
    
    function get($id="",$field=""){
        if($id)   {
            if(!$field){
                $field=$this->tableId;
            }
            if (is_array($id)){
                $this->db->where_in($field,$id);
            }else {
                $this->db->where($field,$id);
            }
            
        }       
        
        $query = $this->db->get($this->tableName);
            return $query->result_array();
    }
}