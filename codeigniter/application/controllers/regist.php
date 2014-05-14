<?php
class Regist extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('tweet_model');
        //redirectするのでtweet_modelは必要ない
        //$this->load->model('tweet_model');
    }

    public function index()
    {
        $this->load->library('session');
        $this->load->helper('email');
        $this->load->helper('form');
        $this->load->library('form_validation');
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
            // redirectさせる
            $data['tweet'] = $this->tweet_model->get_tweet();
            $this->load->view('contribute',$data);
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
        } else if ($this->user_model->get_user($str) === true) {
            $this->form_validation->set_message('adress_check','既に登録されたアドレスです');
            return false;
        } else {
            return true;
        }
    }
}

