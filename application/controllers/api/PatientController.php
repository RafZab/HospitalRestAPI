<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';

use chriskacerguis\RestServer\RestController;

class PatientController extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model( 'PatientModel' );
        $this->load->library( array('form_validation') );
    }

    /*
    | LIST: Get REQUEST TYPE
    | INSERT: POST REQUEST TYPE
    | DELETE: DELETE REQUEST TYPE
    */

    // GET: <project_url>/index.php/api/patient
    // optional GET: <project_url>/index.php/api/patient?id={ id }
    public function patient_get()
    {
        $id = $this->get( 'id' );

        if($id === null ) /* Checks if the id exists, if it doesn't give the whole list of patients */
        {

            $patients = $this->PatientModel->getAll_patients();

            if ( $patients )
                $this->response( $patients, RestController::HTTP_OK );

            $this->response( [
                'status' => FALSE,
                'message' => 'No patients were found'
            ], RestController::HTTP_NOT_FOUND );
        }
        else /* Returns information for one patient */
        {
            $patient = $this->PatientModel->get_patient( $id );

            if ( $patient )
                $this->response( $patient, RestController::HTTP_OK );

            $this->response( [
                'status' => FALSE,
                'message' => 'No patient were found'
            ], RestController::HTTP_NOT_FOUND );
        }
    }

    // POST: <project_url>/index.php/api/doctor/{ id_doctor }/patient
    public function createPatient_post( $id_doctor )
    {
        $data = json_decode(file_get_contents("php://input"), TRUE);

        $this->form_validation->set_data( $data );

        $this->form_validation->set_rules("name", "Name", "required");
        $this->form_validation->set_rules("surname", "Surname", "required");
        $this->form_validation->set_rules("notes", "Notes", "required");

        if($this->form_validation->run() === FALSE)     /* Check validation */
        {
            $this->response( [
              "status" => FALSE,
              "message" => 'Incorrect data'
            ] , RestController::HTTP_BAD_REQUEST );
        }

        $this->load->model( 'DoctorModel' );
        $doctor = $this->DoctorModel->get_doctor( $id_doctor );
        if( !$doctor )      /* Checking if there is a doctor with ID */
        {
            $this->response( [
                'status' => FALSE,
                'message' => 'No doctor were found'
            ], RestController::HTTP_NOT_FOUND );
        }

        $result = $this->PatientModel->create_patient( $data, $id_doctor );
        if( $result )
        {
            $this->response( [
                'status' => TRUE,
                'message' => 'A patient was created'
            ], RestController::HTTP_CREATED );
        }
        else
        {
            $this->response( [
                'status' => FALSE,
                'message' => 'A patient was not created'
            ], RestController::HTTP_INTERNAL_ERROR );
        }
    }

    // Delete: <project_url>/index.php/api/patient?id={ id }
    public function patient_delete()
    {
        $this->load->helper("security");
        $id = $this->security->xss_clean( $this->input->get('id', TRUE) );

        $patient = $this->PatientModel->get_patient( $id );
        if( !$patient )     /* Checking if there is a patient with ID */
        {
            $this->response( [
                'status' => FALSE,
                'message' => 'No patient were found'
            ], RestController::HTTP_NOT_FOUND );
        }

        $result = $this->PatientModel->delete_patient( $id );
        if( $result )
        {
            $this->response( [
                'status' => TRUE,
                'message' => 'A patient was deleted'
            ], RestController::HTTP_CREATED );
        }
        else
        {
            $this->response( [
                'status' => FALSE,
                'message' => 'A patient was not deleted'
            ], RestController::HTTP_INTERNAL_ERROR );
        }
    }
}
?>