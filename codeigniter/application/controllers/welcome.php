<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('regist_model');
		$this->load->model('tweet_model');
	}

	//　ログイン画面view
	public function index()
	{
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('adress', 'メールアドレス', 'required');
		$this->form_validation->set_rules('password', 'パスワード', 'required');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('login');
		}
		else
		{
			$data = $this->session->all_userdata();
			$adress = $this->input->post('adress');
			$pass = $this->input->post('password');
			$login = $this->regist_model->login_user($adress, $pass);
			if ($login == 'TRUE')
			{
				$data['tweet'] = $this->tweet_model->get_tweet();
				$this->load->view('contribute',$data);
			}
			else
			{
				echo 'メールアドレスとパスワードが一致しません';
				$this->load->view('login');
			}
		}
	}

	// 会員登録画面view
	public function regist()
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


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */