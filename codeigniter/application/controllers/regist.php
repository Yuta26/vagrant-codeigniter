<?php
class Regist extends CI_Controller {

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

        $this->form_validation->set_rules('name', '名前', 'required');
        $this->form_validation->set_rules('adress', 'メールアドレス', 'callback_adress_check');
        $this->form_validation->set_rules('password', 'パスワード', 'required|min_length[6]|alpha_numeric');

        if ($this->form_validation->run() === false) {
            $this->load->view('regist');
        } else {
            $adress = $this->input->post('adress');
            $pass = $this->input->post('password');
            $encryption_pass = do_hash($pass); // SHA1
            $name = $this->input->post('name');
            $this->user_model->add_user($name, $adress, $encryption_pass);

            $user_id = $this->user_model->get_user_id($adress);
            // sessionへのデータの書き込みを行う
            $this->session->set_userdata('user_id', $user_id);
            redirect('/tweet/','location');
        }
    }

    function adress_check($str)
    {
        if ($str == '') {
            $this->form_validation->set_message('adress_check', 'メールアドレスを入力してください');
            return false;
        } else if ((valid_email($str)) === false) {
            $this->form_validation->set_message('adress_check', 'メールアドレスの形式ではありません');
                return false;
        } else if ($this->user_model->check_adress($str) === true) {
            $this->form_validation->set_message('adress_check','既に登録されたアドレスです');
            return false;
        } else {
            return true;
        }
    }
}

