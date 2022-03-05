<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Preinscriptos extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('sala_model');
        $this->load->model('preinscriptos_model');
        $this->isLoggedIn();   
    }
    
    public function index()
    {
       
            if(!$this->isEmployee())
            {
                $this->loadThis();
            }
            else
            {        
                //$searchText = $this->security->xss_clean($this->input->post('searchText'));
                //$data['searchText'] = $searchText;
                
                //$this->load->library('pagination');
                
                //$count = $this->user_model->playerListingCount($searchText);
    
                //$returns = $this->paginationCompress ( "preinscriptos/", $count, 10 );
                
                $data['preinscriptos'] = $this->preinscriptos_model->getPreinscriptos();
    
                /*foreach ($data["playerRecords"] as $jugador) {
                    $partidos = $this->user_model->playerMatchListing($jugador->id);
                    $jugador->pj = count($partidos) / 2;
                }*/
                
                $this->global['pageTitle'] = 'Listado de jugadores';
       
                $this->loadViews("preinscriptos", $this->global, $data, NULL);
            }
        
    }
  


}

?>