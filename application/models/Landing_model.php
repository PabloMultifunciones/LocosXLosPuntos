<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Sala_model (Sala Model)
 * Sala model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Landing_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function salaListingCount($searchText = '')
    {
        $this->db->select('Salas.salaId, Salas.locacion, Salas.hora, Salas.inscriptos, Salas.cupos, Salas.status');
        $this->db->from('salas as Salas');
        if(!empty($searchText)) {
            $likeCriteria = "(Salas.salaId  LIKE '%".$searchText."%'
                            OR  Salas.locacion  LIKE '%".$searchText."%'
                            OR  Salas.hora  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('salas.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function salaListing($searchText = '')
    {
        $this->db->select('Salas.salaId, Salas.locacion, Salas.hora, Salas.cupos, Salas.status, Salas.fecha, canchas.imagen, canchas.localidad');
        $this->db->from('salas as Salas');
        $this->db->join('canchas','canchas.nombre = Salas.locacion');
        if(!empty($searchText)) {
            $likeCriteria = "(Salas.salaId  LIKE '%".$searchText."%'
                            OR  canchas.localidad  LIKE '%".$searchText."%'
                            OR  Salas.cupos  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('Salas.isDeleted', 0);
        $this->db->where('canchas.isDeleted', 0);
        $this->db->order_by('Salas.salaId', 'DESC');
        $query = $this->db->get();
        
        $result = $query->result();  
        
        //echo "resultado".sizeof($result)."<br>";
        return $result;
    }

     function tablaListing($searchText = '')
    {
        $this->db->select('Users.id, Users.first_name, Users.last_name, Users.email, Users.status, Users.puntos, Users.isDeleted');
        $this->db->from('users as Users');
        if(!empty($searchText)) {
            $likeCriteria = "(Users.id  LIKE '%".$searchText."%'
                            OR  Users.email  LIKE '%".$searchText."%'
                            OR  Users.last_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
            $this->db->where("Users.status" ,"approved");
            $this->db->where("Users.isDeleted" , 0);
        $this->db->order_by('Users.puntos', 'DESC');

        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getsalaInfo($salaId)
    {
        $this->db->select('salaId, locacion, inscriptos, cupos, hora, fecha, valor');
        $this->db->from('salas');
        $this->db->where('salaId', $salaId);
        $query = $this->db->get();
        
        return $query->row();
    }

    function inscribirUser($d){
        $string = array(
                'idSala'=>$d['sala'],
                'idJugador'=>$d['userId'],
                'equipo'=>$d['equipo'],
                'arquero'=>$d['arquero'], 
                'amigo'=>$d['amigo'], 
                'pago'=>$d['pago']
            );
            $q = $this->db->insert_string('inscripciones',$string);             
            $this->db->query($q);


        $this->db->set('inscriptos', 'inscriptos+1', FALSE);
        $this->db->where('salaId', $d["sala"]);
        $this->db->update('salas');

        return $this->db->insert_id();
    }

    function inscribirSuplente($data){
        $string = array(
                'idSala'=>$data['salaId'],
                'idJugador'=>$data['id'],
                'nombre'=>$data['nombre'],
                'apellido'=>$data['apellido'], 
                'email'=>$data['email'], 
                'telefono'=>$data['phone']
            );
            $q = $this->db->insert_string('suplentes',$string);             
            $this->db->query($q);

    }

    function getInscriptosPorSala($idSala){
        $this->db->select('*');
        $this->db->from('inscripciones as inscripto');
        $this->db->where('inscripto.isDeleted', 0);
        $this->db->where('inscripto.idSala', $idSala);
        $query = $this->db->get();
        
        return $query->num_rows();
    }



}

  