<?php
class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index()
    {
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('email');
        $this->load->helper('form');
        $this->load->helper('security');

        $this->form_validation->set_rules('address', 'メールアドレス', 'callback_address_check');
        $this->form_validation->set_rules('password', 'パスワード', 'required');

        if ($this->form_validation->run() === false) {
            $this->load->view('login');
            return;
        }

        $address = $this->input->post('address');
        $pass = $this->input->post('password');
        $encryption_pass = do_hash($pass);
        $login_check = $this->user_model->login_check($address, $encryption_pass);

        if ($login_check === false) {
            echo '<div id="alert">ログインできません</br>メールアドレス、パスワードを確認してください</div>';
            $this->load->view('login');
            return;
        }

        $user_id = $this->user_model->get_user_id($address);
        $this->session->set_userdata('user_id', $user_id);
        redirect('/tweet/','location');
    }

    function address_check($str)
    {
        if (!$str) {
            $this->form_validation->set_message('address_check', 'メールアドレスを入力してください');
            return false;
        }
        if ((valid_email($str)) === false) {
            $this->form_validation->set_message('address_check', 'メールアドレスの形式ではありません');
            return false;
        }
        return true;
    }
}
