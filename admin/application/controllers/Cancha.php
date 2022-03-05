<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Cancha extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cancha_model');
        $this->isLoggedIn();  
        $this->load->helper('form');
        $this->load->helper('url');
        $config['upload_path'] = "../assets/imgs/";
        $config['allowed_types'] = 'gif|jpg|png/jpeg';
        $config['max_size'] = 200000;
        $config['max_width'] = 150000;
        $config['max_height'] = 150000;  


        $this->load->library('upload', $config); 
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Locos x los puntos : Canchas';
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }
    
    /**
     * This function is used to load the user list
     */
    function canchaListing()
    {
            
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->cancha_model->canchaListingCount($searchText);

            $returns = $this->paginationCompress ( "canchaListing/", $count, 10 );
            
            $data['canchaRecords'] = $this->cancha_model->canchaListing( $returns["page"], $returns["segment"], $searchText);
            
            $this->global['pageTitle'] = 'Listado de canchas';
            
            $this->loadViews("canchas", $this->global, $data, NULL);
        
    }

    /**
     * This function is used to load the add new form
     */
    function addNewCancha()
    {

            $this->load->model('cancha_model');
            
            $this->global['pageTitle'] = 'Agregar Nueva Cancha';

            $this->loadViews("addNewCancha", $this->global,NULL);

    }
    
    /**
     * This function is used to add new user to the system
     */
    function addCancha()
    {

            $this->load->library('form_validation');
            $this->load->library('upload');
            
            $this->form_validation->set_rules('nombre','Nombre','required|max_length[128]');
            $this->form_validation->set_rules('direccion','Direccion','required|max_length[128]');
            $this->form_validation->set_rules('localidad','Localidad','required|max_length[128]');
            $this->form_validation->set_rules('telefono','Telefono','required|max_length[128]');

             if (!$this->upload->do_upload("imagen")) {
            $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('image_metadata' => $this->upload->data());

            }
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewCancha();
            }
            else
            {

                $nombre = $this->input->post('nombre');
                $direccion = $this->input->post('direccion');
                $localidad = $this->input->post('localidad');
                $telefono = $this->input->post('telefono');
                $imagen = $_FILES["imagen"]["name"];
                
                $canchaInfo = array('nombre'=>$nombre, 'direccion'=>$direccion, 'localidad'=> $localidad, 'telefono'=> $telefono, 'imagen'=> $imagen );
                
                $this->load->model('cancha_model');
                $result = $this->cancha_model->addNewCancha($canchaInfo);
                $this->do_upload();
                
                //if($result > 0)
                //{
                    $this->session->set_flashdata('cancha_success', 'New Cancha created successfully');
                //}
                //else
                //{
                //    $this->session->set_flashdata('error', 'User creation failed');
                //}
                
                redirect('addNewCancha');
            }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOldCancha($canchaId = NULL)
    {

            if($canchaId == null)
            {
                redirect('canchaListing');
            }
            
            $data['canchaInfo'] = $this->cancha_model->getCanchaInfo($canchaId);

            
            $this->global['pageTitle'] = 'CodeInsect : Edit Cancha';
            
            $this->loadViews("editOldCancha", $this->global, $data, NULL);
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editCancha()
    {

        $this->loadThis();

        $this->load->library('form_validation');

        $this->form_validation->set_rules('nombre','Nombre','required|max_length[128]');
        $this->form_validation->set_rules('direccion','Direccion','required|max_length[128]');
        $this->form_validation->set_rules('localidad','Localidad','required|max_length[128]');
        $this->form_validation->set_rules('telefono','Telefono','required|max_length[128]');

         if (!$this->upload->do_upload("imagen")) {
            $error = array('error' => $this->upload->display_errors());
            } else {
                $data = array('image_metadata' => $this->upload->data());


        if($this->form_validation->run() == FALSE)
        {
            $this->editOldCancha($canchaId);
        }
        else
        {
            $nombre = $this->input->post('nombre');
            $direccion = $this->input->post('direccion');
            $localidad = $this->input->post('localidad');
            $telefono = $this->input->post('telefono');
            $imagen = $_FILES["imagen"]["name"];
            $canchaId = $this->input->post('canchaId');


            $canchaInfo = array('nombre'=>$nombre, 'direccion'=>$direccion, 'localidad'=>$localidad, 'telefono'=>$telefono, 'imagen'=>$imagen, 'id'=>$canchaId );

            $result = $this->cancha_model->editCancha($canchaInfo, $canchaId);

            //if($result == true)
            //{
                $this->session->set_flashdata('cancha_updated', 'Cancha updated successfully');
            //}
            //else
            //{
            //   $this->session->set_flashdata('error', 'Cancha updation failed');
            //}

            redirect('editOldCancha/'.$canchaId);
            
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCancha()
    {
        echo "asd";
            //$canchaId = $this->input->post('canchaId');
            $canchaInfo = array('isDeleted'=>1);
            
            $result = $this->cancha_model->deleteCancha($canchaId, $canchaInfo);
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

    }
    function do_upload(){

        $config = array(
            'upload_path' => "../assets/imgs/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'max_height' => "768",
            'max_width' => "1024"
            );
        $this->load->library('upload', $config);
        if($this->upload->do_upload())
        {
            $data["upload"] = array('upload_data' => $this->upload->data());
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            //$this->load->view('custom_view', $error);
        }
    }
    function deleteCancha()
    {
            $canchaId = $this->input->post('canchaId');
            $canchaInfo = array('isDeleted'=>1);
            
            $result = $this->cancha_model->deleteCancha($canchaId, $canchaInfo);
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
    }
 }