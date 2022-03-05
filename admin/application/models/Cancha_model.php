<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Sala_model (Sala Model)
 * Sala model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Cancha_model extends CI_Model
{
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function canchaListingCount($searchText = '')
    {
        $this->db->select('id, nombre, direccion, telefono, localidad, imagen');
        $this->db->from('canchas');
        if(!empty($searchText)) {
            $likeCriteria = "(canchas.id  LIKE '%".$searchText."%'
                            OR  canchas.localidad  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('canchas.isDeleted', 0);
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
    function canchaListing( $page, $segment, $searchText = '')
    {
        $this->db->select('id, nombre, direccion, telefono, localidad, imagen');
        $this->db->from('canchas');
        if(!empty($searchText)) {
            $likeCriteria = "(canchas.id  LIKE '%".$searchText."%'
                            OR  canchas.localidad  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('canchas.isDeleted', 0);
        $this->db->order_by('canchas.id', 'DESC');
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
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewCancha($canchaInfo)
    {
        $this->db->trans_start();
        $this->db->insert('canchas', $canchaInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getCanchaInfo($canchaId)
    {
        $this->db->select('id, nombre, direccion, telefono, localidad, imagen');
        $this->db->from('canchas');
        $this->db->where('isDeleted', 0);
        $this->db->where('id', $canchaId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editCancha($canchaInfo, $canchaId)
    {

        $this->db->where('id', $canchaId);
        $this->db->update('canchas', $canchaInfo);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCancha($canchaId, $canchaInfo)
    {
        $this->db->where('id', $canchaId);
        $this->db->update('canchas', $canchaInfo);
        
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


}

  