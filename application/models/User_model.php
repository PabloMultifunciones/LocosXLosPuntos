<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class : Sala_model (Sala Model)
 * Sala model class to get to handle user related data 
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User_model extends CI_Model {
    
    public $status; 
    public $roles;

    function __construct()
    {
        parent::__construct();        
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }

    public function existEmail($email)
    {
        $this->db->select("users.email");
        $this->db->from("users");
        $this->db->where("email" ,$email);
        $query = $this->db->get();
        $result = $query->result(); 
        return sizeof($result) >0;
    }

    public function setProvisionalPassword($email,$provisionalPassword)
    {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('users.email',$email);
        $this->db->update('users',array('provisionalPassword' => $provisionalPassword)); 
        $success = $this->db->affected_rows();
    }

    public function getProvisionalPassword($email)
    {
        $q = $this->db->get_where('users', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row->provisionalPassword;
        }
    }

    public function compareProvisionalPassword($email,$provisionalPassword)
    {
        return $this->getProvisionalPassword($email) == $provisionalPassword;
    }

    public function updatedPassword($email,$newPassword)
    {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->where('users.email',$email);
        $this->db->update('users',array('password' => $newPassword)); 
        //$counRowsAffected = $this->db->affected_rows();
        //return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }

    public function insertUser($d)
    {  
            $string = array(
                'first_name'=>$d['firstname'],
                'last_name'=>$d['lastname'],
                'email'=>$d['email'],
                'phone'=>$d['phone'],
                'role'=>$this->roles[0], 
                'status'=>$this->status[0]
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

    public function getUserInfo($id)
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
               'last_login' => date('Y-m-d h:i:s A'), 
               'status' => $this->status[1]
            );
        $this->db->where('id', $userInfo['user_id']);
        $this->db->update('users', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updateUserInfo('.$userInfo['user_id'].')');
            return false;
        }

        $user_info = $this->getUserInfo($userInfo['user_id']); 
        return $user_info; 
    }

    public function checkLogin($post)
    {
        $this->load->library('password');       
        $this->db->select('*');
        $this->db->where('email', $post['email']);
        $query = $this->db->get('users');
        $userInfo = $query->row();
        
        if(!$this->password->validate_password($post['password'], $userInfo->password)){
            error_log('Unsuccessful login attempt('.$post['email'].')');
            return false; 
        }
        
        $this->updateLoginTime($userInfo->id);
        
        unset($userInfo->password);
        return $userInfo; 
    }
    
    public function updateLoginTime($id)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array('last_login' => date('Y-m-d h:i:s A')));
        return;
    }

    public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('users', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }

     function playerMatchListing($id){
        $this->db->select("partidos.*, inscripciones.idJugador");
        $this->db->from("partidos");
        $this->db->join('inscripciones', 'partidos.idSala = inscripciones.idSala');
        $this->db->where("idJugador" ,$id);
        $this->db->where("amigo" ,0);
        $this->db->where("isDeleted" ,0);
        $query = $this->db->get();
        $result = $query->result(); 
        return $result;
    }

    function playerInscripcionesListing($id){
        $this->db->select("inscripciones.idSala, inscripciones.idJugador");
        $this->db->from("inscripciones");
        $this->db->where("idJugador" ,$id);
        $this->db->where("amigo" ,0);
        $this->db->where("isDeleted" ,0);
        $query = $this->db->get();
        $result = $query->result(); 
        return $result;
    }

     function playerRedCardListing($id){
        $this->db->select("tarjetaRoja");
        $this->db->from("puntos_individuales");
        $this->db->where("idJugador" ,$id);
        $this->db->where("tarjetaRoja" ,1);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function playerYellowCardListing($id){
        $this->db->select("tarjetaAmarilla");
        $this->db->from("puntos_individuales");
        $this->db->where("idJugador" ,$id);
        $this->db->where("tarjetaAmarilla" ,1);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function getPlayersBySala($id){
        $this->db->select("users.first_name, users.last_name, users.id, inscripciones.idJugador, inscripciones.equipo, inscripciones.amigo");
        $this->db->from('inscripciones');
        $this->db->join('users','users.id = inscripciones.idJugador');
        $this->db->where("idSala" ,$id);
        $this->db->where("inscripciones.isDeleted" ,0);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;

    }

    function checkInscripcion($idPlayer, $idSala){
        $this->db->select("inscripciones.idSala, inscripciones.idJugador");
        $this->db->from('inscripciones');
        $this->db->where("idJugador" ,$idPlayer);
        $this->db->where("idSala" ,$idSala);
        $this->db->where("isDeleted" ,0);
        $this->db->where("amigo" ,0);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    function darDeBaja($idPlayer, $idSala){
        $this->db->where("idJugador" ,$idPlayer);
        $this->db->where("idSala" ,$idSala);
        $this->db->update('inscripciones', array('isDeleted' => 1));
        return;
    }
} 