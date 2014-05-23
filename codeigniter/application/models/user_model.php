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

        // DBへのデータの書き込み
        $data = array(
            'create_at' => $create_at,
            'name' => $name,
            'adress' => $adress,
            'password' => $encryption_pass
        );
        $this->db->insert('user', $data);
        return;
    }

    // user_idの取得
    public function get_user_id($adress)
    {
        $this->db->select('user_id')->from('user')->where(array('adress' => $adress));
        $query_check = $this->db->get();
        if ($query_check->num_rows() > 0) {
            foreach ($query_check->row_array() as $row);
            return $row['user_id'];
        }
    }

    public function check_adress($str)
    {
        $this->db->select('*')->from('user')->where(array('adress' => $str));
        $query_check = $this->db->get();
        if ($query_check->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}