<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Preinscriptos_model extends CI_Model
{

    function insertarPreinscripto($d){
        $string = array(
            'nombreyapellido'=>$d['nombreyapellido'],
            'whatsapp'=>$d['whatsapp'],
            'email'=>$d['email'], 
            'localidad'=>$d['localidad']
        );
        $q = $this->db->insert_string('preinscriptos',$string);             
        $this->db->query($q);

        //return $this->db->insert_id();
    }
}

  