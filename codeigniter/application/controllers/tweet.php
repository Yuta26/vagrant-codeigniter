<?php
class Tweet extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('tweet_model');
	}

	public function index()
	{
		$data['tweet'] = $this->tweet_model->get_tweet();
		//echo var_export($data['tweet'], true);
		$this->load->view('contribute',$data);
	}
}
