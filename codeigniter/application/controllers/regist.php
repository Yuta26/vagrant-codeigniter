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
		$this->load->helper('email');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('form_validation');
		$this->load->helper('security');

		$this->form_validation->set_rules('name', '名前', 'required');
		$this->form_validation->set_rules('adress', 'メールアドレス', 'required');
		$this->form_validation->set_rules('password', 'パスワード', 'required|min_length[6]|alpha_numeric');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('regist');
		}
		else
		{
			if((valid_email($this->input->post('adress'))) === FALSE)
			{
				echo 'メールアドレスを正しく入力してください';
				echo '</br>';
				$this->load->view('regist');
			}
			else
			{
				$adress = $this->input->post('adress');
				$pass = $this->input->post('password');
				$encryption_pass = do_hash($pass); // SHA1
				$name = $this->input->post('name');
				$query_check = $this->regist_model->get_user($adress);
				if ($query_check->num_rows() > 0)
				{
					// 入力されたアドレスがDBに登録されていないのか確認
					echo '既に登録済のメールアドレスです';
					echo '</br>';
					$this->load->view('regist');
				}
				else
				{
					$this->regist_model->set_user($name, $adress, $encryption_pass);
					$data['tweet'] = $this->tweet_model->get_tweet();
					$this->load->view('contribute',$data);
				}
			}
		}
	}
}
