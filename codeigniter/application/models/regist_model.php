<?php
class Regist_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}


	public function set_user($name, $adress, $pass)
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
			'name' => $name,
			'adress' => $adress,
			'password' => $pass
		);


		// sessionへのデータの書き込み
		$this->db->insert('user', $data);
		$login_data = array(
				'adress' => $adress,
				'password' => $pass,
				'name' => $name
			);
		$this->session->set_userdata($login_data);
		$data = $this->session->all_userdata();
		var_dump($data);
		return;
	}


	public function login_user($adress, $pass)
	{
		$this->load->library('session');
		$this->load->helper('url');

		$this->db->select('*')->from('user')->where(array('adress' => $adress, 'password' => $pass));
		$query_check = $this->db->get();

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