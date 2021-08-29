<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PatientModel extends CI_Model {

    /**
     * Gives you all the patients in the database
     *
     * @return patients
     */
    public function getAll_patients()
    {
        $query = $this->db->get( 'patients' );
        $patients = $query->result();
        return $patients;
    }

    /**
     * The function takes the ID of the patient
     * and returns the patient
     *
     * @param id
     * @return patient
     */
    public function get_patient( $id )
    {
        $query = $this->db->get_where( 'patients', array( 'id' => $id ) );
        $patient = $query->row();
        return $patient;
    }

    /**
     * The function retrieves data about a patient also ID doctor
     * and returns TRUE if it was possible to create a patient,
     * or FALSE if the operation was unsuccessful
     *
     * @param data
     * @param id_doctor
     * @return TRUE OR FALSE
     */
    public function create_patient( $data, $id_doctor )
    {
        $new_patient = [
            'name' => $data['name'],
            'surname' => $data['surname'],
            'id_doctor' => $id_doctor,
            'notes' => $data['notes']
        ];

        return $this->db->insert( 'patients', $new_patient );
    }

    /**
     * The function retrieves ID patient and returns
     * TRUE if it was possible to delete a patient,
     * or FALSE if the operation was unsuccessful
     *
     * @param id
     * @return TRUE OR FALSE
     */
    public function delete_patient( $id )
    {
        return $this->db->delete( 'patients', array( 'id' => $id ) );
    }
}
?>