<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : User_model (User Model)
 * User model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User_model extends CI_Model
{
public $status; 
    public $roles;    
    function __construct(){
        // Call the Model constructor
        parent::__construct();        
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    } 
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
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
    function userListing($page, $segment, $searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->order_by('BaseTbl.userId', 'DESC');
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
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
		$this->db->where('roleId !=', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }
    
    
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }

    function deletePlayer($userId, $userInfo)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     */
    function loginHistoryCount($userId, $fromDate, $toDate, $searchText)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->from('tbl_last_login as BaseTbl');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function loginHistory($userId, $fromDate, $toDate, $page, $segment, $searchText)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        $this->db->from('tbl_last_login as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
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

    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getUserInfoWithRole($userId)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.roleId, Roles.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }

    function getPlayerInfoById($userId)
    {
        $this->db->select('id, first_name, last_name, email, phone');
        $this->db->from('users');
        $this->db->where('id ', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

      function playerListing($page, $segment, $searchText = '')
    {
        $this->db->select('Users.id, Users.first_name, Users.last_name, Users.email, Users.status, Users.created');
        $this->db->from('users as Users');
        if(!empty($searchText)) {
            $likeCriteria = "(Users.id  LIKE '%".$searchText."%'
                            OR  Users.email  LIKE '%".$searchText."%'
                            OR  Users.last_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('Users.id', 'DESC');
        $this->db->limit($page, $segment);
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function suplentesListing($idSala)
    {
        $this->db->select('nombre, apellido, idJugador, telefono, email');
        $this->db->from('suplentes');
        $this->db->where('idSala ', $idSala);

        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

      function playerListingMonth( $searchText = '')
    {
        $this->db->select('Users.id, Users.first_name, Users.last_name, Users.email, Users.status, Users.created');
        $this->db->from('users as Users');
        if(!empty($searchText)) {
            $likeCriteria = "(Users.id  LIKE '%".$searchText."%'
                            OR  Users.email  LIKE '%".$searchText."%'
                            OR  Users.last_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->order_by('Users.id', 'DESC');

        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

      function activePlayerListing($page, $segment, $searchText = '')
    {
        $this->db->select('Users.id, Users.first_name, Users.last_name, Users.email, Users.status, Users.puntos');
        $this->db->from('users as Users');
        if(!empty($searchText)) {
            $likeCriteria = "(Users.id  LIKE '%".$searchText."%'
                            OR  Users.email  LIKE '%".$searchText."%'
                            OR  Users.last_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
            $this->db->where("Users.status" ,"approved");
        $this->db->order_by('Users.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

     function activePlayerListingPoints($page, $segment, $searchText = '')
    {
        $this->db->select('Users.id, Users.first_name, Users.last_name, Users.email, Users.status, Users.puntos');
        $this->db->from('users as Users');
        if(!empty($searchText)) {
            $likeCriteria = "(Users.id  LIKE '%".$searchText."%'
                            OR  Users.email  LIKE '%".$searchText."%'
                            OR  Users.last_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where("Users.status" ,"approved");
        $this->db->order_by('Users.puntos', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function playerMatchListing($id){
        $this->db->select("partidos.*");
        $this->db->from("partidos");
        $this->db->join('inscripciones', 'partidos.idSala = inscripciones.idSala');
        $this->db->where("idJugador" ,$id);
        $this->db->where("amigo" ,0);
        $this->db->where("isDeleted" ,0);
        $query = $this->db->get();
        $result = $query->result(); 
        return $result;
    }

    function playerResultListing($id, $equipo){
        $this->db->select("goles, invicto, resultado, fairPlay, equipo");
        $this->db->from("partidos");
        $this->db->where("idSala" ,$id);
        $this->db->where("equipo" ,$equipo);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function puntosPartido($id){
        $this->db->select("idSala, penalMetido, penalAtajado, orden, promotor, penalErrado, tarjetaAmarilla, tarjetaRoja, inasistencia, inasistenciaAmigo");
        $this->db->from("puntos_individuales");
        $this->db->where("idJugador" ,$id);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function playerListingCount($searchText = '')
    {
        $this->db->select('Users.id, Users.first_name, Users.last_name, Users.email, Users.status');
        $this->db->from('users as Users');
        if(!empty($searchText)) {
            $likeCriteria = "(Users.id  LIKE '%".$searchText."%'
                            OR  Users.email  LIKE '%".$searchText."%'
                            OR  Users.last_name  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }

        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function playerEquipo($idSala, $idPlayer){
         $this->db->select("equipo");
        $this->db->from("inscripciones");
        $this->db->where("idJugador" ,$idPlayer);
        $this->db->where("idSala" ,$idSala);
        $this->db->where("isDeleted" ,0);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }


        function addNewPlayer($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

    function editPlayer($userInfo, $userId)
    {
        $this->db->where('id', $userId);
        $this->db->update('users', $userInfo);
        
        return TRUE;
    }

    
    public function insertUser($d)
    {  
            var_dump($d);
            $string = array(
                'first_name'=>$d['nombre'],
                'last_name'=>$d['apellido'],
                'email'=>$d['email'],
                'phone'=>$d['mobile'],
                'role'=> "subscriber",
                'status'=>"pending"
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }
    
    public function isDuplicate($email)
    {     
        $this->db->get_where('users', array('email' => $email), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
    
    public function insertToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');
        
        $string = array(
                'token'=> $token,
                'user_id'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }

    public function isTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn, 
            'tokens.user_id' => $uid), 1);      
        
        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);
            
            if($createdTS != $todayTS){
                return false;
            }
            
            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
            
        }else{
            return false;
        }
        
    } 

    public function getUserInfoToken($id)
    {
        $q = $this->db->get_where('users', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }


    public function updateUserInfo($post, $userInfo)
    {
        
        $data = array(
               'password' => $post['password'],
               'last_login' => date('Y-m-d h:i:s A')
            );
        $this->db->where('id', $userInfo['user_id']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updateUserInfo('.$userInfo['user_id'].')');
            return false;
        }

        $user_info = $this->getUserInfoToken($userInfo['user_id']); 
        return $user_info; 
    }

}

  