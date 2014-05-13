<?php
class Login_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function login_user($adress, $encryption_pass)
	{
		$this->load->library('session');
		$this->db->select('*')->from('user')->where(array('adress' => $adress, 'password' => $encryption_pass));
		$query_check = $this->db->get();

		if ($query_check->num_rows() > 0)
		{
			// アドレスとパスワードが一致する行から名前を取得する
			foreach ($query_check->result_array() as $row_record);
			$name = $row_record['name'];

			// sessionへのログイン情報の書き込み
			$login_data = array(
					'adress' => $adress,
					'password' => $encryption_pass,
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