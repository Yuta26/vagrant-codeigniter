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
        $this->form_validation->set_rules('address', 'メールアドレス', 'callback_address_check');
        $this->form_validation->set_rules('password', 'パスワード', 'required|min_length[6]|alpha_numeric');

        if ($this->form_validation->run() === false) {
            $this->load->view('regist');
            return;
        }
        $address = $this->input->post('address');
        $encryption_pass = do_hash($this->input->post('password'));
        $name = $this->input->post('name', TRUE);
        $this->user_model->add_user($name, $address, $encryption_pass);

        $this->session->set_userdata('user_id', $this->user_model->get_user_id($address));
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
        if ($this->user_model->check_address($str) === true) {
            $this->form_validation->set_message('address_check','既に登録されたアドレスです');
            return false;
        }
        return true;
    }
}

