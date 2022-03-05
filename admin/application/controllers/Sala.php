<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Sala extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('sala_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Locos x los puntos : Salas';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function salaListing()
    {
      
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->sala_model->salaListingCount($searchText);

			$returns = $this->paginationCompress ( "salaListing/", $count, 10 );
            
            $data['salaRecords'] = $this->sala_model->salaListing( $returns["page"], $returns["segment"], $searchText);
            
            $this->global['pageTitle'] = 'Listado de salas';
            
            $this->loadViews("salas", $this->global, $data, NULL);
        
    }

    /**
     * This function is used to load the add new form
     */
    function addNewSala()
    {
 
            $this->load->model('sala_model');
            
            $data["canchas"] = $this->sala_model->getCanchas();
            
            $this->global['pageTitle'] = 'Agregar Nueva Sala';

            $this->loadViews("addNewSala", $this->global, $data, NULL);
        
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addSala()
    {

            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('locacion','Locacion','trim|required|max_length[128]');
            $this->form_validation->set_rules('cupos','Cupos','trim|required|max_length[128]');
            $this->form_validation->set_rules('fecha','Fecha','trim|required|max_length[128]');
            $this->form_validation->set_rules('valor','Valor','trim|required|max_length[128]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewSala();
            }
            else
            {
                $locacion = ucwords(strtolower($this->security->xss_clean($this->input->post('locacion'))));
                $cupos = strtolower($this->security->xss_clean($this->input->post('cupos')));
                $fecha = $this->input->post('fecha');
                $valor = $this->input->post('valor');
                $dia = substr($fecha, 0, 10);
                $hora = substr($fecha, 11, 8);
                $salaInfo = array('locacion'=>$locacion, 'cupos'=>$cupos, 'hora'=> $hora, "fecha"=> $dia, "valor"=> $valor  );
                $this->load->model('sala_model');
                $result = $this->sala_model->addNewSala($salaInfo);
                
                /*
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                */

                $this->session->set_flashdata('sala_success', 'New Sala created successfully');

                redirect('addNewSala');
            }
        
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOldSala($salaId)
    {

            if($salaId == null)
            {
                redirect('salaListing');
            }
            
            $data["canchas"] = $this->sala_model->getCanchas();
            $data['salaInfo'] = $this->sala_model->getSalaInfo($salaId);
            
            $this->global['pageTitle'] = 'CodeInsect : Edit Sala';
            
            $this->loadViews("editOldSala", $this->global, $data, NULL);
        
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editSala()
    {
            
            //$this->loadThis();

            $this->load->library('form_validation');
            
            $salaId = $this->input->post('salaId');
            
            $this->form_validation->set_rules('locacion','Locacion','trim|required|max_length[128]');
            $this->form_validation->set_rules('cupos','Cupos','trim|required|max_length[128]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOldSala($salaId);
            }
            else
            {
                $locacion = ucwords(strtolower($this->security->xss_clean($this->input->post('locacion'))));
                $cancha = ucwords(strtolower($this->security->xss_clean($this->input->post('cancha'))));
                $fecha = $this->input->post('fecha');
                $valor = $this->input->post('valor');
                $cupos = strtolower($this->security->xss_clean($this->input->post('cupos')));
                $dia = substr($fecha, 0, 10);
                $hora = substr($fecha, 11, 8);

                $salaInfo = array('locacion'=>$locacion, 'cupos'=>$cupos, 'hora'=> $hora, "fecha"=> $dia, "valor"=> $valor );
                
                
                $result = $this->sala_model->editSala($salaInfo, $salaId);

                //if($result == true)
                //{
                    $this->session->set_flashdata('sala_updated', 'Sala updated successfully');
                //}
                //else
                //{
                //    $this->session->set_flashdata('error', 'Sala updation failed');
                //}
                
                
                redirect("editOldSala/".$salaId);//ES ACA
                //echo $salaId;
            
            }
            
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteSala()
    {

            $salaId = $this->input->post('salaId');
            $salaInfo = array('isDeleted'=>1);
            
            $result = $this->sala_model->deleteSala($salaId, $salaInfo);
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        
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

    function inscripcionListing($salaId = NULL)
    {
 
            $this->load->model('user_model'); 
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            $data['salaInfo'] = $this->sala_model->getSalaInfo($salaId);
            $count = $this->sala_model->jugadoresListingCount( $salaId, $searchText);

            $returns = $this->paginationCompress ( "inscripcionListing/", $count, 10 );
            
            $data['jugadoresRecords'] = $this->sala_model->jugadoresListing( $returns["page"], $returns["segment"], $salaId, $searchText);

            $data["suplentes"] = $this->user_model->suplentesListing($salaId);

            $this->global['pageTitle'] = 'Inscriptos en la sala';
            $this->loadViews("inscriptos", $this->global, $data, NULL);
        
    }

     /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function pasarResultados($salaId = NULL)
    {
 
            $data['salaInfo'] = $this->sala_model->getSalaInfo($salaId);
            $data['playerInfo'] = $this->sala_model->jugadoresListing( "", "", $salaId, "");
            $data["puntosInfo"] = $this->sala_model->puntosListing( "", "", $salaId, "");

            $this->global['pageTitle'] = 'Pasar puntajes';
            
            $this->loadViews("pasarResultados", $this->global, $data, NULL);
       
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function confirmResultados($salaId = NULL)
    {
            
            $this->loadThis();

            $this->load->library('form_validation');
            
            $salaId = $this->input->post('salaId');
            
            $this->form_validation->set_rules('equipo1','Equipo 1','required|max_length[128]');
            $this->form_validation->set_rules('equipo2','Equipo 2','required|max_length[128]');
            


            if($this->form_validation->run() == FALSE)
            {
               $this->session->set_flashdata('error', 'Partido no cargado');
               redirect('pasarResultados/'.$salaId);
            }
            else
            {

                $idPartido = $this->input->post('salaId');
                $goles1 = $this->input->post('equipo1');
                $goles2 = $this->input->post('equipo2');
                $invicto = 0;
                $invicto2 = 0;
                $resultado = 0;
                $resultado2 = 0;


                // EQUIPO 1
         
                if ($goles1 > $goles2){
                    $resultado = 3;
                    $resultado2 = 0;
                } elseif ($goles1 == $goles2){
                    $resultado = 1;
                    $resultado2 = 1;
                } else {
                    $resultado = 0;
                    $resultado2 = 3;
                }

                if ($goles1 == "0"){
                    $invicto2 = 1;
                }

                if ($goles2 == "0"){
                    $invicto = 1;
                }

                $fairPlay = $this->input->post('fairPlay');
                 if (is_null($fairPlay)){
                    $fairPlay = 0;
                } else {
                    $fairPlay = 1;
                };

                $fairPlay2 = $this->input->post('fairPlay2');
                 if (is_null($fairPlay2)){
                    $fairPlay2 = 0;
                } else {
                    $fairPlay2 = 1;
                };

                $puntosEquipo1 = $goles1 + ($invicto * 5) + $resultado + ($fairPlay * 5);
                $puntosEquipo2 = $goles2 + ($invicto2 * 5) + $resultado2 + ($fairPlay2 * 5);

                $jugadores = $this->sala_model->jugadoresPartido($idPartido);
                foreach ($jugadores as $jugador){
                    if ($jugador->equipo == 2){
                        $this->sala_model->pasarPuntos($puntosEquipo2, $jugador->idJugador, $jugador->puntos);
                    } elseif ($jugador->equipo == 1){
                        $this->sala_model->pasarPuntos($puntosEquipo1, $jugador->idJugador, $jugador->puntos);
                    }
                }



                $salaInfo = array('idSala'=>$idPartido, "equipo"=> 1, 'goles'=>$goles1, 'invicto'=> $invicto, "resultado"=> $resultado, "fairPlay"=> $fairPlay );
                $salaInfo2 = array('idSala'=>$idPartido, "equipo"=> 2, 'goles'=>$goles2, 'invicto'=> $invicto2, "resultado"=> $resultado2, "fairPlay"=> $fairPlay2 );
                $updateStatus = array("status" => 3);

                $result = $this->sala_model->addNewPartido($salaInfo);
                $result2 = $this->sala_model->addNewPartido($salaInfo2);
                $status = $this->sala_model->editSala($updateStatus, $idPartido);


                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Partido cargado');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Partido no cargado');
                }
                
                redirect('pasarResultados/'.$idPartido);
            
        }
    }
    /**
     * This function is used to edit the user information
     */
    function confirmPuntosPlayer($salaId = NULL)
    {
            
            $this->loadThis();

            $this->load->library('form_validation');
            
            $salaId = $this->input->post('salaId');

            $idPartido = $this->input->post('salaId');
            $idJugador = $this->input->post('jugador');
            $penal = $this->input->post('penal');

            if (empty($penal)){
                $penal = 0;
            }
            $atajados = $this->input->post('atajados');
             if (empty($atajados)){
                $atajados = 0;
            }
            $orden = $this->input->post('orden');
             if (empty($orden)){
                $orden = 0;
            }
            $errado = $this->input->post('errado');
             if (empty($errado)){
                $errado = 0;
            }
            $promotor = $this->input->post('promotor');
             if (empty($promotor)){
                $promotor = 0;
            }
            $amarilla = $this->input->post('amarilla');
             if (empty($amarilla)){
                $amarilla = 0;
            }
            $roja = $this->input->post('roja');
             if (empty($roja)){
                $roja = 0;
            }
            $inasistencia = $this->input->post('inasistencia');
             if (empty($inasistencia)){
                $inasistencia = 0;
            }
            $inasistenciaAmigo = $this->input->post('inasistenciaAmigo');
             if (empty($inasistenciaAmigo)){
                $inasistenciaAmigo = 0;
            }


            $playerInfo = array('idSala'=>$idPartido, "idJugador"=> $idJugador, 'penalMetido'=>$penal, 'penalAtajado'=> $atajados, "orden"=> $orden, "promotor"=> $promotor, "penalErrado"=> $errado, "tarjetaAmarilla"=> $amarilla, "tarjetaRoja"=> $roja, "inasistencia"=> $inasistencia, "inasistenciaAmigo"=> $inasistenciaAmigo );


            $result = $this->sala_model->addNewPlayerPoints($playerInfo);

            $puntos = ($penal * 2) + ($atajados * 2) + $orden + ($errado * -5) + $promotor + ($amarilla * -3) + ($roja * -6) + ($inasistencia * -10) + ($inasistenciaAmigo * -5); 

            $jugador = $this->sala_model->getPlayerInfoById($idJugador);
            $this->sala_model->pasarPuntos($puntos, $jugador->id, $jugador->puntos);

            if($result == true)
            {
                $this->session->set_flashdata('success', 'Puntos cargados');
            }
            else
            {
                $this->session->set_flashdata('error', 'Puntos no cargados');
            }
            
            redirect('pasarResultados/'.$idPartido);

    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteInscripcion()
    {

            $userId = $_POST["userId"];
            $canchaInfo = array('isDeleted'=>1);

            $result = $this->sala_model->deleteInscripcion($userId, $canchaInfo);
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        
    }

}

?>