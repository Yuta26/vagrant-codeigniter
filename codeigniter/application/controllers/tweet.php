<?php
class Tweet extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('tweet_model');
	}

	public function index()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('content', 'ツイート', 'required');
		$data['tweet'] = $this->tweet_model->get_tweet();
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('contribute',$data);
		}
		else
		{
			$content = $this->input->post('content');
			$this->tweet_model->set_tweet($content);
			$this->tweet_model->get_tweet();
			$this->load->view('contribute',$data);
		}
	}

	public function logout()
	{
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('form');
		$flag = $this->input->post('flag');
		if ($flag === '1')
		{
			$this->session->sess_destroy();
			$this->load->view('login');
		}
	}
}
