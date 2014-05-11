<?php
class Tweet_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	public function get_tweet()
	{
		$query = $this->db->get('tweet');
		return $query->result_array();
	}

	public function set_tweet()
	{
		$this->load->helper('url');
		$this->load->helper('date');
		$format = 'DATE_ATOM';
		$time = time();
		$create_at = standard_date($format, $time); 

		$data = array(
			'create_tweet' => $create_at,
			'content' => $this->input->post('content')
		);
		return $this->db->insert('tweet',$data);
	}
}