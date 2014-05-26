<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function login_check($adress, $encryption_pass)
    {
        $this->db->select('*')->from('user')->where(array('adress' => $adress, 'password' => $encryption_pass));
        $query_check = $this->db->get();
        if ($query_check->num_rows() > 0) {
             return true;
        } else {
            return false;
        }
    }

    public function add_user($name, $adress, $encryption_pass)
    {
        $this->load->helper('date');
        $format = 'DATE_ATOM';
        $time = time();
        $create_at = standard_date($format, $time); 

        $data = array(
            'create_at' => $create_at,
            'name' => $name,
            'adress' => $adress,
            'password' => $encryption_pass
        );
        $this->db->insert('user', $data);
        return;
    }

    public function get_user_id($adress)
    {
        $this->db->select('user_id')->from('user')->where(array('adress' => $adress));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->row_array() as $row);
            return $row['user_id'];
        }
    }

    public function get_user_name($user_id) {
        $this->db->select('name')->from('user')->where(array('user_id' => $user_id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->row_array() as $row);
            return $row;
        }
    }

    public function check_adress($str)
    {
        $this->db->select('*')->from('user')->where(array('adress' => $str));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}