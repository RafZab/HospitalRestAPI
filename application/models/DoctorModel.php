<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DoctorModel extends CI_Model {

    /**
     * Gives you all the doctors in the database
     *
     * @return doctors
     */
    public function getAll_doctors()
    {
        $query = $this->db->get( 'doctors' );
        $doctors = $query->result();
        return $doctors;
    }

    /**
     * The function takes the ID of the doctor
     * and returns the doctor along with all his patients
     *
     * @param id
     * @return info_doctor
     */
    public function get_doctor( $id )
    {
        $query_doctor = $this->db->get_where( 'doctors', array( 'id' => $id ) );
        $query_patients = $this->db
                                ->select('id, name, surname, notes')
                                ->get_where( 'patients', array( 'id_doctor' => $id ) );

        $doctor = $query_doctor->row();

        $info_doctor = [
            'id'  => $doctor->id,
            'name' => $doctor->name,
            'surname' => $doctor->surname,
            'specialisation' => $doctor->specialisation,
            'phone' => $doctor->phone,
            'patients' => $query_patients->result()
        ];

        return $info_doctor;
    }

    /**
     * The function retrieves data about a doctor and returns
     * TRUE if it was possible to create a doctor,
     * or FALSE if the operation was unsuccessful
     *
     * @param data
     * @return TRUE OR FALSE
     */
    public function create_doctor( $data )
    {
        $new_doctor = [
            'name' => $data['name'],
            'surname' => $data['surname'],
            'specialisation' => $data['specialisation'],
            'phone' => $data['phone']
        ];

        return $this->db->insert( 'doctors', $new_doctor );
    }

    /**
     * The function retrieves data about a doctor also ID doctor
     * and returns TRUE if it was possible to update a doctor,
     * or FALSE if the operation was unsuccessful
     *
     * @param data
     * @param id
     * @return TRUE OR FALSE
     */
    public function update_doctor( $data, $id )
    {
        $query_doctor = $this->db->get_where( 'doctors', array( 'id' => $id ) );
        $doctor = $query_doctor->row();

        if( !$doctor )
            return FALSE;

        $update_doctor = [
            'name' => !empty($data['name']) ? $data['name'] : $doctor->name,
            'surname' => !empty($data['surname']) ? $data['surname'] : $doctor->surname,
            'specialisation' => !empty($data['specialisation']) ? $data['specialisation'] : $doctor->specialisation,
            'phone' => !empty($data['phone']) ? $data['phone'] : $doctor->phone
        ];

        return $this->db->where( 'id', $id )->update( 'doctors',  $update_doctor );

    }
}
?>