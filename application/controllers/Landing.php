<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

	
    public $status; 
    public $roles;


    public function __construct()
    {
        parent::__construct();
        $this->load->model('landing_model');
        $this->load->model('user_model');
        $this->load->model('preinscriptos_model');
        $this->load->library('form_validation');    
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->status = $this->config->item('status'); 
        $this->roles = $this->config->item('roles');
    }
    
    
    public function index()
    {
        //FUNCION PARA GUARDAR LOS DATOS DE LA PREINSCRIPCION
        $data['inscribed'] = $this->guardarPreinscripcion(
            $this->input->post('nombreyapellido'),
            $this->input->post('whatsapp'),
            $this->input->post('email'),
            $this->input->post('localidad')
        );

        //------------------------------------------------------
        
        $this->global['pageTitle'] = 'Home';

        $data['salaRecords'] = $this->landing_model->salaListing();

        $data['filterRecords'] = $this->landing_model->salaListing();
        $data['tablaRecords'] = $this->landing_model->tablaListing();

        foreach ($data["salaRecords"] as $sala) {
            $sala->inscriptos = $this->landing_model->getInscriptosPorSala($sala->salaId);
        }

        $puesto = 1;

        foreach ($data["tablaRecords"] as $jugador) {
            $jugador->puesto = $puesto;
            $partidos = count($this->user_model->playerMatchListing($jugador->id));
            $jugador->partidos = $partidos / 2;
            $jugador->amarillas = count($this->user_model->playerYellowCardListing($jugador->id));
            $jugador->rojas = count($this->user_model->playerRedCardListing($jugador->id));
            $puesto ++;
        }

        $this->load->view("landing", $data );
    }
    
    function guardarPreinscripcion($nombreyapellido = '',$whatsapp = '',$email = '',$localidad = ''){
        if($nombreyapellido != '' && $whatsapp != '' && $email != '' && $localidad != '')
        {
            $this->form_validation->set_rules('nombreyapellido', 'Nombreyapellido', 'required');
            $this->form_validation->set_rules('localidad', 'Localidad', 'required');    
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');  
            $this->form_validation->set_rules('whatsapp', 'Whatsapp', 'required|numeric|min_length[10]|max_length[10]');    
    
            if ($this->form_validation->run()) {  
                $preinscripto = array('nombreyapellido' => $nombreyapellido, 'whatsapp' => $whatsapp, 'email' => $email,'localidad' => $localidad);
                $this->preinscriptos_model->insertarPreinscripto($preinscripto);
                return true;
            }
        }
        return false;
    }

    public function salaListingFiltered()
    {


        //FUNCION PARA GUARDAR LOS DATOS DE LA PREINSCRIPCION
        $data['inscribed'] = $this->guardarPreinscripcion(
            $this->input->post('nombreyapellido'),
            $this->input->post('whatsapp'),
            $this->input->post('email'),
            $this->input->post('localidad')
        );

        //------------------------------------------------------
        $this->global['pageTitle'] = 'Home';

        $data['filterRecords'] = $this->landing_model->salaListing();
        $data['salaRecords'] = $this->landing_model->salaListing($_POST["jugador"]);
        $data['tablaRecords'] = $this->landing_model->tablaListing();

        foreach ($data["salaRecords"] as $sala) {
            $sala->inscriptos = $this->landing_model->getInscriptosPorSala($sala->salaId);
        }


        $puesto = 1;

        foreach ($data["tablaRecords"] as $jugador) {
            $jugador->puesto = $puesto;
            $partidos = count($this->user_model->playerMatchListing($jugador->id));
            $jugador->partidos = $partidos / 2;
            $jugador->amarillas = count($this->user_model->playerYellowCardListing($jugador->id));
            $jugador->rojas = count($this->user_model->playerRedCardListing($jugador->id));
            $puesto ++;
        }

        $this->load->view("landing", $data );
    }

   
    function salaListing()
    {

        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;

        $this->load->library('pagination');

        $count = $this->landing_model->salaListingCount($searchText);

		//$returns = $this->paginationCompress ( "salaListing/", $count, 10 );

        $data['salaRecords'] = $this->landing_model->salaListing( );

        $this->global['pageTitle'] = 'Listado de salas';

    }

    public function detalleSala($salaId)
    {

        $data["sala"] = $this->landing_model->getsalaInfo($salaId);
        $this->load->view('partials/head');
        $this->load->view('partials/header');

        if($this->session->userdata("id")){
            $userId = $this->session->userdata("id");
            if ($this->user_model->checkInscripcion($userId, $salaId)){
                $data["inscripto"] = true;
            }
        }
        $data["jugadores"] = $this->user_model->getPlayersBySala($salaId);
        $data["sala"]->inscriptos = count($data["jugadores"]);

        $this->load->view("detalleSala", $data);
        
    }

    public function suplente($salaId)
    {

        if(null !== $this->session->userdata("id")){
            $this->session->set_flashdata('suscripto', 'Ya estas anotado en lista de espera, si se libera un cupo te avisaremos');
            $suplente = array();
            $suplente["salaId"] = $salaId;
            $suplente["id"] = $_SESSION["id"];
            $suplente["nombre"] = $_SESSION["first_name"];
            $suplente["apellido"] = $_SESSION["last_name"];
            $suplente["email"] = $_SESSION["email"];
            $suplente["phone"] = $_SESSION["phone"];
            
            $this->landing_model->inscribirSuplente($suplente);
            redirect(site_url().'landing');
        }else {
            $this->session->set_flashdata('ingresa', 'Por favor ingresa para inscribirte en esta sala');
            redirect(site_url().'landing');
        }
        
    }

    public function register()
    {

        $this->form_validation->set_rules('firstname', 'First Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');    
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');  
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric');    

        if ($this->form_validation->run() == FALSE) {   
            $this->load->view('partials/head');
            $this->load->view('partials/header');
            $this->load->view('register');
        }else{                
            if($this->user_model->isDuplicate($this->input->post('email'))){
                $this->session->set_flashdata('flash_message', 'User email already exists');
                redirect(site_url().'landing/login');
            }else{

                $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
                $id = $this->user_model->insertUser($clean); 

                $token = $this->user_model->insertToken($id);                                        

                $qstring = $this->base64url_encode($token);                      
                $url = site_url() . 'landing/complete/token/' . $qstring;
                $link = '<a href="' . $url . '">AQUI</a>'; 

                $message = '';                     
                $message .= '<strong>Gracias por registrarte a Locos X Los Puntos</strong>';
                $message .= '<strong>Para validar tu cuenta haz click en el siguiente codigo:</strong> ' . $link;                          

                $data["message"] = $message;
                $this->load->view('partials/head');
                $this->load->view('partials/header');
                $this->load->view("partials/completeRegister", $data );


            };              
        }

    }

    public function base64url_encode($data) { 
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
    } 


    public function base64url_decode($data) { 
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
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

            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');              
            
            if ($this->form_validation->run() == FALSE) {   
                $this->load->view('partials/head');
                $this->load->view('partials/header');
                $this->load->view('complete', $data);
                //$this->load->view('footer');
            }else{

                $this->load->library('password');                 
                $post = $this->input->post(NULL, TRUE);
                
                $cleanPost = $this->security->xss_clean($post);
                
                $hashed = $this->password->create_hash($cleanPost['password']);                
                $cleanPost['password'] = $hashed;
                unset($cleanPost['passconf']);
                $userInfo = $this->user_model->updateUserInfo($cleanPost ,$data);

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
                redirect(site_url().'landing/');
                
            }
        }   

        public function logout()
        {
            $this->session->sess_destroy();
            redirect("");
        }

        public function login()
        {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');    
            $this->form_validation->set_rules('password', 'Password', 'required'); 
            var_dump("si perro");
            if($this->form_validation->run() == FALSE) {

                $this->session->set_flashdata('flash_message', 'El usuario o contraseña no son correctos');
                redirect(site_url().'landing');
            }else{

                $post = $this->input->post();  
                $clean = $this->security->xss_clean($post);
                
                $userInfo = $this->user_model->checkLogin($clean);
                
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'El usuario o contraseña no son correctos');
                    redirect(site_url().'landing');
                    $this->session->flashdata('flash_message');
                }                
                foreach($userInfo as $key=>$val){
                    $this->session->set_userdata($key, $val);
                }
                $this->load->view('partials/head');
                $this->load->view('partials/header');
                redirect(site_url());
            }
            
        }  


            
            
            /*
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email'); 
            
            if($this->form_validation->run() == FALSE) {
                $this->load->view('partials/head');
                $this->load->view('partials/header');
                $this->load->view('forgot');
                //$this->load->view('footer');
            }else{
                $email = $this->input->post('email');  
                $clean = $this->security->xss_clean($email);
                $userInfo = $this->user_model->getUserInfoByEmail($clean);
                
                if(!$userInfo){
                    $this->session->set_flashdata('flash_message', 'We cant find your email address');
                    $this->load->view('partials/head');
                    $this->load->view('partials/header');
                    redirect(site_url().'landing/login');
                }   
                
                if($userInfo->status != $this->status[1]){ //if status is not approved
                    $this->session->set_flashdata('flash_message', 'Your account is not in approved status');
                    $this->load->view('partials/head');
                    $this->load->view('partials/header');
                    redirect(site_url().'landing/login');
                }
                
                //build token 
                
                $token = $this->user_model->insertToken($userInfo->id);                    
                $qstring = $this->base64url_encode($token);                      
                $url = site_url() . 'landing/reset_password/token/' . $qstring;
                $link = '<a href="' . $url . '">' . $url . '</a>'; 
                
                $message = '';                     
                $message .= '<strong>A password reset has been requested for this email account</strong>
                ';
                $message .= '<strong>Please click:</strong> ' . $link;             
                echo $message; //send this through mail
                exit;
                
            }*/
            
        


        public function inscripcion()
        {       
            $players = $this->user_model->getPlayersBySala($this->input->post("sala"));
            $salaInfo = $this->landing_model->getsalaInfo($this->input->post("sala"));
            $limitEquipo = $salaInfo->cupos / 2;


            $yaInscripto = 0;
            $inscriptos = 0;

            $equipo1 = $limitEquipo;
            $equipo2 = $limitEquipo;

            foreach ($players as $inscripto) {
                if((($this->session->userdata("id")) != null ) && (($this->session->userdata("id") == $inscripto->id ))){
                    $yaInscripto = 1;
                }
                if ($inscripto->equipo == 1){
                    $equipo1 --;
                }
                if ($inscripto->equipo == 2){
                    $equipo2 --;
                }
            } 

            if( ($this->session->userdata("id")) != null ){

                $datos = array();
                $datos["sala"] = $this->input->post("sala");
                $esAmigo = 0; 
                $datos["pago"] = $this->input->post("pago");



                    // CHECK SI HAY CUPO
                foreach ($_POST["jugador"] as $puesto) {

                    if(($puesto["equipo"] == 1) && (isset($puesto["inscripto"]))){
                        $equipo1 --;
                    }

                    if(($puesto["equipo"] == 2) && (isset($puesto["inscripto"]))){
                        $equipo2 --;
                    } 

                    if($equipo1 < 0){

                        $this->session->set_flashdata('CUPOS', "No hay cupos disponibles para la inscripcion, por favor elige otro equipo");
                        redirect(site_url().'sala/'.$datos["sala"]);
                    }


                }

                    // INSCRIBE A CADA JUGADOR
                foreach ($_POST["jugador"] as $puesto) {

                    if (isset($puesto["inscripto"])){

                        if (isset($puesto["arquero"]) && ($puesto["arquero"] === "on")){
                            $datos["arquero"] = 1;    
                        } else{
                            $datos["arquero"] = 0;
                        }
                        $datos["equipo"] = $puesto["equipo"];
                        $datos["userId"] = $this->session->userdata("id");

                        $datos["amigo"] = 0;
                        if($esAmigo > 0){
                            $datos["amigo"] = 1;
                        }
                        if ($yaInscripto != 0){
                         $this->session->set_flashdata('SUSCRIPTO', "Ya estas anotado en esta sala");
                         redirect(site_url().'sala/'.$datos["sala"]);
                     } else {
                         if ($datos["pago"] == 0) {
                            $this->landing_model->inscribirUser($datos);
                        }elseif ($datos["pago"] == 1){
                            $_SESSION["fullInscripcion"]["inscripto"][$inscriptos] = $datos;     

                        }

                    }
                    $esAmigo ++;
                    $inscriptos ++;
                }
            }

                            // SI HAY INSCRIPTOS TIRA EL GRACIAS, SINO TE DICE QUE TE ANOTES
            if ($inscriptos > 0 ){

             if($datos["pago"] == 1){
                // SDK de Mercado Pago
                require __DIR__ .  '/../vendor/autoload.php';

                // Agrega credenciales
                MercadoPago\SDK::setAccessToken('APP_USR-1532967727451503-121018-bb6ac77e21686c0825eeda8745c217ee-679423245');

                // Crea un objeto de preferencia
                $preference = new MercadoPago\Preference();



                // Crea un ítem en la preferencia
                $item = new MercadoPago\Item();
                $item->title = 'Mi producto';
                $item->quantity = count($_SESSION["fullInscripcion"]["inscripto"]);

                $item->unit_price = floatval($salaInfo->valor);

                $preference->back_urls = array(
                    "success" => "https://locosxlospuntos.com.ar/success/". ($salaInfo->salaId) ."" ,
                    "failure" => "https://locosxlospuntos.com.ar/failure/". ($salaInfo->salaId) .""
                );

                $preference->items = array($item);
                $preference->save();

                $link = $preference->init_point;

                header("Location: ".$link);
            } else {
             $this->session->set_flashdata('GRACIAS', "Gracias por inscribirte, nos vemos en la cancha!<br>* Por favor no te olvides tu barbijo y bebida personal
                <br>* Debes llegar 15 minutos antes del horario de inicio del partido
                <br>* Se podrá pagar en efectivo o Mercado Pago en la cancha");

             redirect(site_url().'sala/'.$datos["sala"]);
         }


    } else {
        $this->session->set_flashdata('INSCRIBIR', "Por favor anotate y elige un equipo");
        redirect(site_url().'sala/'.$datos["sala"]);
    }

    } else {
        $this->session->set_flashdata('LOG IN', "Por favor ingresa para inscribirte en esta sala!");
        $datos["sala"] = $this->input->post("sala");
        redirect(site_url().'sala/'.$datos["sala"]);
    }

    }

    public function failure($salaId){

        $this->session->set_flashdata('NO INSCRIPTO', "La inscripcion no se pudo completar, por favor intentalo nuevamente.");
        redirect(site_url().'sala/'.$salaId);
    }

    public function success($salaId){
        

        foreach ($_SESSION["fullInscripcion"]["inscripto"] as $jugador) {
             $this->landing_model->inscribirUser($jugador);
        }

        $this->session->set_flashdata('GRACIAS', "Gracias por inscribirte, nos vemos en la cancha!<br>* Por favor no te olvides tu barbijo y bebida personal
                <br>* Debes llegar 15 minutos antes del horario de inicio del partido
                <br>* Se podrá pagar en efectivo o Mercado Pago en la cancha");
        redirect(site_url().'sala/'.$salaId);
    }

    public function deBaja($salaId){
        $userId = $this->session->userdata("id");
        if($this->user_model->darDeBaja($userId, $salaId)){
            $this->session->set_flashdata('BAJADOS', "Ya te has dado de baja de este partido, en caso de que hayas pagado por MercadoPago, el dinero te quedará de credito para tu proximo partido");
        } else {
        $this->session->set_flashdata('NO BAJA', "Error al borrar inscripcion, por favor contactanos para darte de baja");
    }
    redirect(site_url().'sala/'.$salaId);
    }

         /**
     * This function is used to load the user list
     */
         function userListing()
         {
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

            $returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'CodeInsect : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }

        public function queEs()
        {
           $this->load->view('partials/head');
           $this->load->view('partials/header');
           $this->load->view("partials/queEs");
           $this->load->view('partials/footer');
       }

       public function puntos()
       {
           $this->load->view('partials/head');
           $this->load->view('partials/header');
           $this->load->view("partials/puntos");
           $this->load->view('partials/footer');
       }

       public function contact()
       {
        $this->load->helper(array('form','url'));
        $this->load->library(array('session', 'form_validation', 'email'));
        $this->load->view('partials/head');
        $this->load->view('partials/header');
        $this->load->view('partials/footer');

          //configure email settings
             //set validation rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Emaid ID', 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');

        //run validation on form input
        if ($this->form_validation->run() == FALSE)
        {
            //validation fails
            $this->load->view('contact');
        }
        else
        {
            //get the form data
            $name = $this->input->post('name');
            $from_email = $this->input->post('email');
            $subject = $this->input->post('subject');
            $phone = $this->input->post('phone');
            $message = $this->input->post('message');

            $message = $message . " " ."Telefono: ". $phone;

            //set to_email id to which you want to receive mails
            $to_email = 'locosxlospuntos@gmail.com';

            //configure email settings
            $config['protocol'] = 'mail';
            $config['smtp_host'] = 'localhost';
            $config['smtp_port'] = 587;
            /*$config['smtp_user'] = '';
            $config['smtp_pass'] = '';*/
            $config['mailtype'] = 'html';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n"; //use double quotes
            //$this->load->library('email', $config);
            $this->email->initialize($config);                        

            //send mail
            $this->email->from($from_email, $name);
            $this->email->to($to_email);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($this->email->send())
            {
                // mail sent
                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">Gracias por contactarte con nosotros, te responderemos a la brevedad!</div>');
                redirect('landing/contact');
            }
            else
            {
                //error
                $this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Hubo un error en el envio, por favor intenta nuevamente en un rato.</div>');
                redirect('landing/contact');
            }
        }
    }


    public function gracias()
    {
       $jugadores = $_SESSION["fullInscripcion"]["inscripto"];

       foreach ($jugadores as $jugador) {
        $jugador["pago"] = 1;
            $this->landing_model->inscribirUser($jugador);  # code...
        }
        $this->session->set_flashdata('GRACIAS', "Gracias por inscribirte, nos vemos en la cancha!<br>* Por favor no te olvides tu barbijo y bebida personal
            <br>* Debes llegar 15 minutos antes del horario de inicio del partido
            <br>* Se podrá pagar en efectivo o Mercado Pago en la cancha");
        redirect(site_url().'sala/'.$jugadores[0]["sala"]);

    }

    public function forgot()
    {
        $email = $this->input->post('email');

        if(isset($email)){
            $this->session->set_flashdata('email',$email);
        }

        if($this->user_model->existEmail($this->session->flashdata('email'))){
            $data['existEmail'] = true;
            $this->session->set_flashdata('authenticated',false);

            if($this->input->post('provisionalPassword')){
                $results =$this->user_model->getProvisionalPassword($this->session->flashdata('email'));
                   
                $provisionalPassword = $this->input->post('provisionalPassword');
                $esIgual = $this->user_model->compareProvisionalPassword($this->session->flashdata('email'),$provisionalPassword);
                if($esIgual){
                    $this->session->set_flashdata('authenticated',true);
                    //redirect("landing/changePassword");
                    $this->changePassword();
                }else{
                    $data['esIgual'] = false;
                    $this->loadViewForgot($data);
                }
            }else{
                $this->load->library('phpmailer_lib');
                $provisionalPassword = $this->phpmailer_lib->load($email);
                $this->user_model->setProvisionalPassword($email,$provisionalPassword);
                $this->loadViewForgot($data);
            }
        }else{
            $data['existEmail'] = false;
            $this->loadViewForgot($data);
        }
        
        
    }   

    private function loadViewForgot($data){
        $this->load->view('partials/head');
        $this->load->view('partials/header');
        $this->load->view("provisionalPassword",$data);
        $this->load->view('partials/footer');
    }

    public function changePassword($pass = false){
        $password = $this->input->post('password');
        $confirmPassword = $this->input->post('confirmPassword');     
        $email = $this->input->post('email');
        
        if($pass){
            $this->session->set_flashdata('authenticated',true);
        }
        
        if(isset($password) or isset($confirmPassword) or isset($email)){
            $this->session->set_flashdata('authenticated',true);
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
            $this->form_validation->set_rules('confirmPassword', 'Password Confirmation', 'required|matches[password]');              
            
            if($this->form_validation->run()){        
                $this->load->library('password');     
                $post = $this->input->post(NULL, TRUE);
                $cleanPost = $this->security->xss_clean($post);
                $hashed = $this->password->create_hash($cleanPost['password']);                
                $this->user_model->updatedPassword($email,$hashed);
                $data['state'] = 'success';
                $this->loadViewChangePassword($data);
                    
            }else{
                $this->session->set_flashdata('email',$email);
                $data['state'] = 'failed';
                $this->loadViewChangePassword($data);
            }
        }else{
            $data['state'] = 'inProgress';
            $this->loadViewChangePassword($data);
        }
    }
    
    private function loadViewChangePassword($data){
        $this->load->view('partials/head');
        $this->load->view('partials/header');
        $this->load->view("changePassword",$data);
        $this->load->view('partials/footer');
    }
}
?>