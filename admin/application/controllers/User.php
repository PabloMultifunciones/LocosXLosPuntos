<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('sala_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'CodeInsect : Dashboard';
        $data["userHistorico"] = $this->user_model->playerListingCount();
        
        $jugadores = $this->user_model->playerListingMonth();
        $partidos =  $this->sala_model->partidosListing();
        $timeNow = strtotime(date("Y-m-d"));
        $data["playersUltimoMes"] = 0;
        foreach ($jugadores as $player) {
            $timeCreated = strtotime($player->created);
            
            if ($timeNow - $timeCreated < 2629746){
                $data["playersUltimoMes"] ++;
            }
        }

        $data["partidosUltimoMes"] = 0;

        foreach ($partidos as $partido) {
            $timeCreated = strtotime($partido->created);
            
            if ($timeNow - $timeCreated < 2629746){
                $data["partidosUltimoMes"] ++;
            }
        }

        $data["partidosUltimoMes"] = $data["partidosUltimoMes"] / 2;

        $data["partidosHistorico"] = ($this->sala_model->partidosListingCount() / 2);
        
        $data["salasActuales"] = $this->sala_model->oepnSalaListingCount();
        $data["cantidadSalasActuales"] = count($data["salasActuales"]);

        $data["abiertos"] = 0;
        $data["cerrados"] = 0;

        foreach ($data["salasActuales"] as $sala) {
            if($sala->status == 0) {
                $data["abiertos"] ++;
            } elseif ($sala->status == 1){
                $data["cerrados"] ++;
            }
        }
        
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        //if($this->isAdmin() == TRUE)
        if(!$this->isEmployee())
        {
            $this->loadThis();
        }
        else
        {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

            $returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing( $returns["page"], $returns["segment"], $searchText);
            
            $this->global['pageTitle'] = 'CodeInsect : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'CodeInsect : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {

                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                //if($result > 0)
                //{
                $this->session->set_flashdata('user_success', 'New User created successfully');
                //}
                //else
                //{
                //    $this->session->set_flashdata('error', 'User creation failed');
                //}
                
                redirect('addNew');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        //if($this->isAdmin() == TRUE || $userId == 1)
        if(false)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit User';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        //if($this->isAdmin() == TRUE)
        if(false)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                        'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                //if($result == true)
                //{
                    $this->session->set_flashdata('user_success', 'User updated successfully');
                //}
                //else
                //{
                //    $this->session->set_flashdata('error', 'User updation failed');
                //}
                
                redirect('editOld/'.$userId);
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

        /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deletePlayer()
    {
        //if($this->isAdmin() == TRUE)   
        if(false)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1);
            
            $result = $this->user_model->deletePlayer($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'CodeInsect : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->loginHistoryCount($userId, $fromDate, $toDate, $searchText);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $fromDate, $toDate, $returns["page"], $returns["segment"], $searchText);
            
            $this->global['pageTitle'] = 'CodeInsect : User Login History';
            
            $this->loadViews("loginHistory", $this->global, $data, NULL);
        }        
    }

    /**
     * This function is used to show users profile
     */
    function profile($active = "details")
    {
        $data["userInfo"] = $this->user_model->getUserInfoWithRole($this->vendorId);
        $data["active"] = $active;
        
        $this->global['pageTitle'] = $active == "details" ? 'CodeInsect : My Profile' : 'CodeInsect : Change Password';
        $this->loadViews("profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    function profileUpdate($active = "details")
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|callback_emailExists');        
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            
            $userInfo = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->editUser($userInfo, $this->vendorId);
            
            if($result == true)
            {
                $this->session->set_userdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Profile updation failed');
            }

            redirect('profile/'.$active);
        }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                    'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('profile/'.$active);
            }
        }
    }

    /**
     * This function is used to check whether email already exist or not
     * @param {string} $email : This is users email
     */
    function emailExists($email)
    {
        $userId = $this->vendorId;
        $return = false;

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ $return = true; }
        else {
            $this->form_validation->set_message('emailExists', 'The {field} already taken');
            $return = false;
        }

        return $return;
    }

    function playerListing()
    {
        //if($this->isAdmin() == TRUE)
        if(!$this->isEmployee())
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->playerListingCount($searchText);

            $returns = $this->paginationCompress ( "playerListing/", $count, 10 );
            
            $data['playerRecords'] = $this->user_model->playerListing($returns["page"], $returns["segment"], $searchText);

            foreach ($data["playerRecords"] as $jugador) {
                $partidos = $this->user_model->playerMatchListing($jugador->id);
                $jugador->pj = count($partidos) / 2;
            }
            
            $this->global['pageTitle'] = 'Listado de jugadores';
   
            $this->loadViews("jugadores", $this->global, $data, NULL);
        }
    }

    function addNewPlayer()
    {
        //if($this->isAdmin() == TRUE)
        if(false)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'CodeInsect : Add New User';

            $this->loadViews("addNewPlayer", $this->global, $data, NULL);
        }
    }

        function addPlayer()
    {
        //if($this->isAdmin() == TRUE)
        if(false)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('nombre','Nombre','trim|required|max_length[128]');
            $this->form_validation->set_rules('apellido','Apellido','required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewPlayer();
            }
            else
            {   

                $nombre = ucwords(strtolower($this->security->xss_clean($this->input->post('nombre'))));
                $apellido = ucwords(strtolower($this->security->xss_clean($this->input->post('apellido'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $mobile = $this->input->post('mobile');
                
                $userInfo = array('email'=>$email, 'role'=>"suscriber", 'first_name'=> $nombre,
                    'phone'=>$mobile, 'last_name'=>$apellido, 'status'=>"approved");
                
                $this->load->model('user_model');
                $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                $id = $this->user_model->insertUser($clean); 

                $token = $this->user_model->insertToken($id);                                        

                $qstring = $this->base64url_encode($token);                      
                $url = site_url() . 'landing/complete/token/' . $qstring;
                $link = '<a href="' . $url . '">AQUI</a>'; 

                //$message = '';                     
                //$message .= '<strong>Gracias por registrarte a Locos Xasdasdasd Los Puntos</strong>';
                //$message .= '<strong>Para validar tu cuenta haz click en el siguiente codigo:</strong> ' . $link;     

                //$data["message"] = $message;
                  

                //if($result > 0)
                //{
                    $this->session->set_flashdata('jugador_success', 'New Jugador created successfully');
                //}
                //else
                //{
                //    $this->session->set_flashdata('error', 'User creation failed');
                //}
                redirect('addPlayer');

                //$this->load->model('user_model');
                //$data['roles'] = $this->user_model->getUserRoles();
            
                //$this->global['pageTitle'] = 'CodeInsect : Add New User';
                //$this->loadViews("addNewPlayer", $data, NULL);
            }
        }
    }

     public function base64url_encode($data) { 
            return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
        } 


        public function base64url_decode($data) { 
            return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
        }  

     /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOldPlayer($userId = NULL)
    {
        //if($this->isAdmin() == FALSE || $userId == 1)
        if(false)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('playerListing');
            }else
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getPlayerInfoById($userId);

            $token = $this->user_model->insertToken($userId);                                        
            $qstring = $this->base64url_encode($token);      
            
                           
            //$url = site_url() . 'user/complete/token/' . $qstring;
            //$link = '<a href="' . $url . '">AQUI</a>'; 

            $message = '';   
            //$message .= '<strong>Para validar tu cuenta haz click:</strong> ' . $link;                          

            $data["message"] = $message;
            
            $this->global['pageTitle'] = 'CodeInsect : Edit Player';
            
            //$this->loadViews("editOldPlayer", $this->global, $data, NULL);
            $this->loadViews("editOldPlayer", $this->global, $data, NULL);

        }
    }
    
    /**
     * This function is used to edit the user information
     */
    function editPlayer()
    {
        //if($this->isAdmin() == TRUE)
        if(FALSE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('first_name','Nombre','required|max_length[128]');
            $this->form_validation->set_rules('last_name','Apellido','required|max_length[128]');
            $this->form_validation->set_rules('phone','Phone','required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOldPlayer($userId);
            }
            else
            {
                $name = $this->input->post('first_name');
                $surname = $this->input->post('last_name');
                $phone = $this->input->post('phone');
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                
                
                $userInfo = array();
                

                $userInfo = array('email'=>$email, 'first_name'=>$name, 'last_name'=>$surname, 'phone'=>$phone);
   
                
                $result = $this->user_model->editPlayer($userInfo, $userId);
                
                //if($result == true)
                //{
                    $this->session->set_flashdata('jugador_updated', 'Jugador updated successfully');
                //}
                //else
                //{
                //    $this->session->set_flashdata('error', 'User updation failed');
                //}
                
                redirect('editOldPlayer/'.$userId);
            }
        }
    }

        public function complete()
        {                                   
            $token = base64_decode($this->uri->segment(4));       
            $cleanToken = $this->security->xss_clean($token);
            
            $user_info = $this->user_model->isTokenValid($cleanToken); //either false or array();           
            
            if(!$user_info){
                $this->session->set_flashdata('flash_message', 'Token is invalid or expired');
                redirect(site_url().'landing/login');
            }            
            $data = array(
                'firstName'=> $user_info->first_name, 
                'email'=>$user_info->email,
                'user_id'=>$user_info->id, 
                'token'=>$this->base64url_encode($token)
            );

            $pass["password"] = $user_info->password;


                $this->load->library('password');                 
                /*
                $hashed = $this->password->create_hash($pass);                
                $cleanPost['password'] = $hashed;
                unset($cleanPost['passconf']);
           */
                $userInfo = $this->user_model->updateUserInfo($pass ,$data);
                var_dump($userInfo);
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'There was a problem updating your record');
                    $this->load->view('partials/head');
                    $this->load->view('partials/header');
                    redirect(site_url().'landing/login');
                }
                
                unset($userInfo->password);
                
                foreach($userInfo as $key=>$val){
                    $this->session->set_userdata($key, $val);
                }
            
                redirect("playerListing");

        }
    
    function puntosListing()
    {

            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            $this->load->library('pagination');           
            $count = $this->user_model->playerListingCount($searchText);
            $returns = $this->paginationCompress ( "playerListing/", $count, 10 );   

            // TRAIGO USUARIOS QUE ESTEN APROBADOS         
            $data['playerRecords'] = $this->user_model->activePlayerListingPoints( $returns["page"], $returns["segment"], $searchText);

            // CONTEO DE RESULTADO POR JUGADOR POR EQUIPO
            foreach ($data["playerRecords"] as $player) {

                // TRAIGO TODOS LOS PARTIDOS QUE MATCHEEN SALA CON INSCRIPCIONES DE ESE JUGADOR
                $partidos = $this->user_model->playerMatchListing($player->id);

                

                $player->jugados = count($partidos) / 2;
                $player->ganados = 0;
                $player->empatados = 0;
                $player->perdidos = 0;
                $player->goles = 0;
                $player->invicto = 0;
                $player->fairPlay = 0;
                $player->penales = 0;
                $player->atajados = 0;
                $player->orden = 0;
                $player->promotor = 0;
                $player->errados = 0;
                $player->amarilla = 0;
                $player->roja = 0;
                $player->inasistencia = 0;
                $player->inasistenciaAmigo = 0;


               // var_dump($partidos); die();
               // CONTEO DE RESULTADO POR PARTIDO
                 foreach ($partidos as $partido) {

                   // TRAIGO LA DATA DEL PARTIDO QUE MATCHEE CON EL ID SALA Y EL EQUIPO 
                   $matchData = $this->user_model->playerResultListing($partido->idSala, $partido->equipo);
                   $playerEquipo = $this->user_model->playerEquipo($partido->idSala, $player->id);
     
                   if ($partido->equipo == $playerEquipo[0]->equipo){
                    $i = 0;
                   if(isset($matchData)){
                        $resultado = $matchData[$i]->resultado;
                       if ($resultado == 3){
                        $player->ganados ++;
                       } elseif ($resultado == 1){
                        $player->empatados ++;
                       } elseif ($resultado == 0){
                        $player->perdidos ++;
                       }
                  
                       $player->goles = $player->goles + $matchData[$i]->goles;
                       $player->invicto = $matchData[$i]->invicto;

                       $player->fairPlay = $matchData[$i]->fairPlay;
                       $i ++;
                   }
                   }
                   
                }
            }
             
 
            $this->global['pageTitle'] = 'Listado de jugadores';
   
            $this->loadViews("puntos", $this->global, $data, NULL);
        
    }



}

?>