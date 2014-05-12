<?php
class Regist_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function set_user()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('date');
		$format = 'DATE_ATOM';
		$time = time();
		$create_at = standard_date($format, $time); 

		// DBへのデータの書き込み
		$data = array(
			'create_at' => $create_at,
			'name' => $this->input->post('name'),
			'adress' => $this->input->post('adress'),
			'password' => $this->input->post('password')
		);
		return $this->db->insert('user', $data);
	}
	
	public function login_user($adress, $pass)
	{
		$this->load->library('session');
		$this->load->helper('url');

		//　泉谷さんが教えてくれたDBからのデータの取得方法
		//$query = $this->db->select("*")->from("user")->where(("adress" => $adress) AND ("password" => $pass));
		//$query_pass = $this->db->select("password")->from("user")->where(array("password" => $pass))

		// SQLインジェクション対策を行う必要がある
		$query_check = $this->db->query("select * from user where adress='$adress' and password='$pass'");

		if ($query_check->num_rows() > 0)
		{
			foreach ($query_check->result_array() as $row_record);
			$name = $row_record['name'];
			// sessionへのログイン情報の書き込み
			$login_data = array(
					'adress' => $adress,
					'password' => $pass,
					'name' => $name
				);
			$this->session->set_userdata($login_data);
			return 'TRUE';
		}
		else
		{
			return 'FALSE';
		}
	}
}