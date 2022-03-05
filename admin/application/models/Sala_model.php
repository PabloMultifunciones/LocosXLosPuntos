<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Sala_model (Sala Model)
 * Sala model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Sala_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function salaListingCount($searchText = '')
    {
        $this->db->select('Salas.salaId, Salas.locacion, Salas.hora, Salas.inscriptos, Salas.cupos, Salas.status, Salas.valor');
        $this->db->from('salas as Salas');
        if(!empty($searchText)) {
            $likeCriteria = "(Salas.salaId  LIKE '%".$searchText."%'
                            OR  Salas.locacion  LIKE '%".$searchText."%'
                            OR  Salas.hora  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('Salas.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function oepnSalaListingCount($searchText = '')
    {
        $this->db->select('Salas.salaId, Salas.locacion, Salas.hora, Salas.inscriptos, Salas.cupos, Salas.status, Salas.valor');
        $this->db->from('salas as Salas');
        if(!empty($searchText)) {
            $likeCriteria = "(Salas.salaId  LIKE '%".$searchText."%'
                            OR  Salas.locacion  LIKE '%".$searchText."%'
                            OR  Salas.hora  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('Salas.isDeleted', 0);
        $this->db->where('Salas.status !=', 3);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function partidosListingCount($searchText = '')
    {
        $this->db->select('Partidos.id');
        $this->db->from('partidos as Partidos');
        if(!empty($searchText)) {
            $likeCriteria = "(Partidos.id  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function partidosListing($searchText = '')
    {
        $this->db->select('id, idSala, invicto, goles, equipo, resultado, fairPlay, created');
        $this->db->from('partidos as Partidos');
        if(!empty($searchText)) {
            $likeCriteria = "(Partidos.id  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function salaListing($page, $segment, $searchText = '')
    {
        $this->db->select('Salas.salaId, Salas.locacion, Salas.hora, Salas.inscriptos, Salas.cupos, Salas.status, Salas.fecha, Salas.valor');
        $this->db->from('salas as Salas');
        if(!empty($searchText)) {
            $likeCriteria = "(Salas.salaId  LIKE '%".$searchText."%'
                            OR  Salas.locacion  LIKE '%".$searchText."%'
                            OR  Salas.fecha  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('Salas.isDeleted', 0);
        $this->db->order_by('Salas.salaId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewSala($salaInfo)
    {
        $this->db->select('Salas.salaId, Salas.locacion, Salas.hora, Salas.inscriptos, Salas.cupos, Salas.status, Salas.fecha, Salas.valor');
        $this->db->from('salas as Salas');
        $this->db->where('Salas.isDeleted', 0);
        $this->db->where('Salas.locacion',$salaInfo['locacion']);
        $this->db->where('Salas.hora',$salaInfo['hora']);
        $this->db->where('Salas.fecha',$salaInfo['fecha']);
        $query = $this->db->get();
        $result = $query->result();       
        $cantResults = sizeof($result);
  
        if($cantResults == 0){
            $this->db->trans_start();
            $this->db->insert('salas', $salaInfo);
            
            $insert_id = $this->db->insert_id();
            
            $this->db->trans_complete();
            
            return $insert_id;
        }else
        {
            return -1;
        }
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
        $this->db->where('isDeleted', 0);
        $this->db->where('salaId', $salaId);
        $query = $this->db->get();
        
        return $query->row();
    }

    function getCanchas()
    {
        $this->db->select('nombre, id, localidad');
        $this->db->from('canchas');
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editSala($salaInfo, $salaId)
    {
        $this->db->where('salaId', $salaId);
        $this->db->update('salas', $salaInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteSala($salaId, $salaInfo)
    {
        $this->db->where('salaId', $salaId);
        $this->db->update('salas', $salaInfo);
        
        return $this->db->affected_rows();
    }

     function deleteInscripcion($userId, $salaInfo)
    {
        $this->db->where('id', $userId);
        $this->db->update('inscripciones', $salaInfo);
        
        return $this->db->affected_rows();
    }

     function deleteInscripcionNumber($salaId, $salaInfo)
    {
        $this->db->where('id', $salaId);
        $this->db->update('salas', $salaInfo);
        
        return $this->db->affected_rows();
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    function getPlayerInfoById($userId)
    {
        $this->db->select('id, puntos');
        $this->db->from('users');
        $this->db->where('id', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

function jugadoresListingCount( $idSala, $searchText = '')
    {
        $this->db->select('id, idSala, idJugador, equipo, arquero, pago');
        $this->db->from('inscripciones');
        if(!empty($searchText)) {
            $likeCriteria = "(inscripciones.id  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('inscripciones.idSala', $idSala);
        $this->db->where('inscripciones.isDeleted', 0);
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
    function jugadoresListing($page, $segment, $idSala, $searchText = '')
    {
        $this->db->select('inscripciones.id, idSala, idJugador, equipo, arquero, pago, users.first_name, users.last_name');
        $this->db->from('inscripciones');
        if(!empty($searchText)) {
            $likeCriteria = "(inscripciones.id  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('inscripciones.idSala', $idSala);
        $this->db->where('inscripciones.isDeleted', 0);
        $this->db->join('users', 'users.id = inscripciones.idJugador');

        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

     function puntosListing($page, $segment, $idSala, $searchText = '')
    {
        $this->db->select('puntos_individuales.id, idSala, idJugador, penalMetido, penalAtajado, orden, promotor, penalErrado, tarjetaAmarilla, tarjetaRoja, inasistencia, inasistenciaAmigo, users.first_name, users.last_name');
        $this->db->from('puntos_individuales');
        if(!empty($searchText)) {
            $likeCriteria = "(inscripciones.id  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('puntos_individuales.idSala', $idSala);
        $this->db->join('users', 'users.id = puntos_individuales.idJugador');

        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function jugadoresPartido($idSala){
        $this->db->select('idJugador, equipo, puntos');
        $this->db->from('inscripciones');
        $this->db->where('inscripciones.idSala', $idSala);
        $this->db->where('inscripciones.isDeleted', 0);
        $this->db->join('users', 'users.id = inscripciones.idJugador');
        $query = $this->db->get();

        $result = $query->result();        
        return $result;
    }

    function addNewPartido($salaInfo)
    {
        $this->db->trans_start();
        $this->db->insert('partidos', $salaInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function addNewPlayerPoints($salaInfo)
    {
        $this->db->trans_start();
        $this->db->insert('puntos_individuales', $salaInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function pasarPuntos($puntosPartido, $playerId, $puntos){

        $this->db->where('id', $playerId);
        $this->db->set('puntos', $puntos + $puntosPartido);
                $this->db->update('users');
        
        return TRUE;
    }

}

  