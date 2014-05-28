<?php
class User_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('date');
    }

    public function login_check($address, $encryption_pass)
    {
        $this->db->select('*')->from('user')->where(array('address' => $address, 'password' => $encryption_pass));
        $query_check = $this->db->get();
        if ($query_check->num_rows() > 0) {
             return true;
        }
        return false;
    }

    public function add_user($name, $address, $encryption_pass)
    {
        $format = 'DATE_ATOM';
        $time = time();
        $create_at = standard_date($format, $time); 

        $data = array(
            'create_at' => $create_at,
            'name' => $name,
            'address' => $address,
            'password' => $encryption_pass
        );
        $this->db->insert('user', $data);
        return;
    }

    public function get_user_id($address)
    {
        $this->db->select('user_id')->from('user')->where(array('address' => $address));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->row_array() as $row) {
                return $row;
            }
        }
    }

    public function get_user_name($user_id) {
        $this->db->select('name')->from('user')->where(array('user_id' => $user_id));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->row_array() as $row) {
                return $row;
            }
        }
    }

    public function check_address($str)
    {
        $this->db->select('*')->from('user')->where(array('address' => $str));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
}