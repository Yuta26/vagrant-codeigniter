<?php
class Tweet extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('tweet_model');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('content', 'ツイート', 'required');
		$data['tweet'] = $this->tweet_model->get_tweet();
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('contribute',$data);
		}
		//echo var_export($data['tweet'], true);
		else
		{
			$content = $_POST['content'];
			$this->tweet_model->set_tweet();
			$this->tweet_model->get_tweet();
			$this->load->view('contribute',$data);
		}
	}
}
