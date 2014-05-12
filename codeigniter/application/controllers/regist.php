<?php
class Regist extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('regist_model');
		$this->load->model('tweet_model');
	}

	// 会員登録画面
	public function index()
	{
		$this->load->library('session');
		$data = $this->session->all_userdata();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', '名前', 'required');
		$this->form_validation->set_rules('adress', 'メールアドレス', 'required');
		$this->form_validation->set_rules('password', 'パスワード', 'required');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('regist');
		}
		else
		{ 
			$adress = $this->input->post('adress');
			$pass = $this->input->post('password');
			$name = $this->input->post('name');
			$this->regist_model->set_user($name, $adress, $pass);
			
			$data['tweet'] = $this->tweet_model->get_tweet();
			$this->load->view('contribute',$data);
		}
	}


}
