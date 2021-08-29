<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class DoctorController extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model( 'DoctorModel' );
        $this->load->library( array('form_validation') );
    }

    /*
    | LIST: Get REQUEST TYPE
    | INSERT: POST REQUEST TYPE
    | UPDATE: PUT REQUEST TYPE
    */

    // GET: <project_url>/index.php/api/doctors
    public function doctors_get()
    {
        $result_dr = $this->DoctorModel->getAll_doctors();

        if( $result_dr )
            $this->response( $result_dr, RestController::HTTP_OK );

        $this->response( [
            'status' => FALSE,
            'message' => 'No doctors were found'
        ], RestController::HTTP_NOT_FOUND );
    }

    // GET: <project_url>/index.php/api/doctor/{ id }
    public function doctor_get( $id )
    {
        $result_dr = $this->DoctorModel->get_doctor( $id );

        if( $result_dr )
            $this->response( $result_dr, RestController::HTTP_OK );

        $this->response( [
            'status' => FALSE,
            'message' => 'No doctor were found'
        ], RestController::HTTP_NOT_FOUND );
    }

    // POST: <project_url>/index.php/api/doctor
    public function doctor_post()
    {
        $data = json_decode(file_get_contents("php://input"), TRUE);

        $this->form_validation->set_data( $data );

        $this->form_validation->set_rules("name", "Name", "required");
        $this->form_validation->set_rules("surname", "Surname", "required");
        $this->form_validation->set_rules("specialisation", "Specialisation", "required");
        $this->form_validation->set_rules("phone", "Phone", "required|integer");

        if($this->form_validation->run() === FALSE)     /* Check validation */
        {
            $this->response( [
              "status" => FALSE,
              "message" => 'Incorrect data'
            ] , RestController::HTTP_BAD_REQUEST );
        }

        $result = $this->DoctorModel->create_doctor( $data );
        if( $result )
        {
            $this->response( [
                'status' => TRUE,
                'message' => 'A doctor was created'
            ], RestController::HTTP_CREATED );
        }
        else
        {
            $this->response( [
                'status' => FALSE,
                'message' => 'A doctor was not created'
            ], RestController::HTTP_INTERNAL_ERROR );
        }
    }

    // PUT: <project_url>/index.php/api/doctor?id={ id }
    public function doctor_put()
    {
        $id = $this->input->get('id', TRUE);

        $data = json_decode(file_get_contents("php://input"), TRUE);

        $result = $this->DoctorModel->update_doctor( $data, $id);
        if( $result )
        {
            $this->response( [
                'status' => TRUE,
                'message' => 'A doctor was update'
            ], RestController::HTTP_OK );
        }
        else
        {
            $this->response( [
                'status' => FALSE,
                'message' => 'A doctor was not update'
            ], RestController::HTTP_NOT_MODIFIED );
        }

    }
}
?>