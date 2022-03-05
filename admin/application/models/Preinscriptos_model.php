<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Preinscriptos_model extends CI_Model
{

    function getPreinscriptos()
    {
        $this->db->select('id, nombreyapellido, whatsapp, email, localidad');
        $this->db->from('preinscriptos');
        $query = $this->db->get();
        $result = $query->result();        
        
        return $result;
    }

}

  