<?php
class Regist_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function set_user($name, $adress, $encryption_pass)
	{
		$this->load->library('session');
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


		// sessionへのデータの書き込み
		$this->db->insert('user', $data);
		$login_data = array(
				'adress' => $adress,
				'password' => $encryption_pass,
				'name' => $name
			);
		$this->session->set_userdata($login_data);
		$data = $this->session->all_userdata();
		return;
	}

	public function get_user($adress)
	{
		$this->load->library('session');
		$this->db->select('*')->from('user')->where(array('adress' => $adress));
		$query_check = $this->db->get();
		return $query_check;
	}
}