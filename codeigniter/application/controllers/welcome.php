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

	//　ログイン画面view
	public function index()
	{
		$this->load->view('login');
	}

	// 会員登録画面view
	public function regist()
	{		
		$this->load->view('regist');
	}

	// ツイート画面view
	public function contribute()
	{
		$this->load->view('contribute');
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */