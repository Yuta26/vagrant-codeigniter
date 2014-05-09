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
	
	public function login_user($adress, $pass)
	{
		$this->load->helper('url');

		//　泉谷さんが教えてくれたDBからのデータの取得方法
		//$query_adress = $this->db->select("address")->where(array("address" => $address))->from("user");
		// SQLインジェクション対策を行う必要がある
		$query_adress = $this->db->query("select adress from user where adress='$adress'");
		$query_pass = $this->db->query("select password from user where password='$pass'");

		foreach ($query_adress->result_array() as $row_adress);
		foreach ($query_pass->result_array() as $row_pass);
		if(($row_adress == TRUE)&&($row_pass == TRUE)) {
			return 'TRUE';
		}
		else{
			return NULL;
		}
	}
}