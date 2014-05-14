<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('tweet_model');
    }

    public function index()
    {
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('email');
        $this->load->helper('security');

        $this->form_validation->set_rules('adress', 'メールアドレス', 'required');
        $this->form_validation->set_rules('password', 'パスワード', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('login');
        } else {
            if ((valid_email($this->input->post('adress'))) === FALSE) {
                echo 'メールアドレスを正しく入力してください';
                echo '</br>';
                $this->load->view('login');
            } else {
                $adress = $this->input->post('adress');
                $pass = $this->input->post('password');
                $encryption_pass = do_hash($pass); // SHA1
                $login = $this->login_model->login_user($adress, $encryption_pass);
                if ($login == 'TRUE') {
                    $data['tweet'] = $this->tweet_model->get_tweet();
                    $this->load->view('contribute',$data);
                } else {
                    echo 'メールアドレスとパスワードが一致しません';
                    $this->load->view('login');
                }
            }
        }
    }
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */