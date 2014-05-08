<?php
class Regist_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function set_user()
	{
		$this->load->helper('url');

		$data = array(
			'name' => $this->input->post('name'),
			'adress' => $this->input->post('adress'),
			'password' => $this->input->post('password')
		);
	return $this->db->insert('user', $data);
	}
}