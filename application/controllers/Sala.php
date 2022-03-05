<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sala extends CI_Controller {

    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('landing_model');
        $this->load->model('user_model');
        $this->load->model('partido_model');
        $this->load->library('form_validation');    
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Salas';
        
        $this->loadViews("salas", $this->global, NULL , NULL);
    }


    /**
     * This function is used to load the user list
     */
    public function salaListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            var_dump($_POST); die();
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->sala_model->salaListingCount($searchText);

			$returns = $this->paginationCompress ( "salaListing/", $count, 10 );
            
            $data['salaRecords'] = $this->sala_model->salaListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'Listado de salas';
            $this->loadViews("salas", $this->global, $data, NULL);
        }
    }


    public function salaListingFiltered()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        

            $searchText = $filter;
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->sala_model->salaListingCount($searchText);

            $returns = $this->paginationCompress ( "salaListing/", $count, 10 );
            
            $data['salaRecords'] = $this->sala_model->salaListing( $returns["page"], $returns["segment"], $searchText);
            
            $this->global['pageTitle'] = 'Listado de salas';
            
            $this->loadViews("salas", $this->global, $data, NULL);
        }
    }


    public function detalleSala($salaId)
    {
            
            $this->global['pageTitle'] = 'Detalle de sala';
            $this->load->view('partials/head');
            $this->load->view('partials/header');
            $this->load->view("landing", $this->global, $data , NULL);
        $this->load->view('partials/footer');
    }


    function misPartidos($idPlayer = NULL){

        $this->load->view('partials/head');
        $this->load->view('partials/header');
        
        $data["inscripciones"] = $this->user_model->playerInscripcionesListing($idPlayer);
        $data["jugados"] = array();
        $data["futuros"] = array();

        foreach ($data["inscripciones"] as $partido) {
           
            $jugado = $this->partido_model->getPartidosBySala($partido->idSala);
            $sala = $this->landing_model->getSalaInfo($partido->idSala);
            $fecha = strtotime($sala->fecha);


            if (!empty($jugado) && ($fecha < time()) ){
                            array_push($data["jugados"], $sala);
                        }


            if (empty($jugado) && ($fecha > time()) ){
                array_push($data["futuros"], $sala);
            }

        }
       
        $this->load->view("mispartidos", $data);
        $this->load->view('partials/footer');
    }
    

   

}

?>