<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Sala_model (Sala Model)
 * Sala model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Partido_model extends CI_Model {
 
    function __construct(){
        // Call the Model constructor
        parent::__construct();        

    }

function getPartidosBySala($id){
        $this->db->select("partidos.*");
        $this->db->from("partidos");
        $this->db->where("idSala" ,$id);
        $query = $this->db->get();
        $result = $query->result(); 
        return $result;
    }


} 