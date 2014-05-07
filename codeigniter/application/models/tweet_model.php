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
}