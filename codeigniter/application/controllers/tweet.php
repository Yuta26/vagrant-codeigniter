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
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');


        $user_id = $this->session->userdata('user_id');
        //　ログインしていない場合、ログイン画面へ遷移
        $check_user = $this->tweet_model->check_user($user_id);

        if ($check_user === false) {
            redirect('/login/','location');
            return;
        }

        $this->form_validation->set_rules('content', 'ツイート', 'required');

        if ($this->form_validation->run() === false) {
            $data['tweet'] = $this->tweet_model->get_tweet($user_id);
            $this->load->view('contribute',$data);
        } else {
            $content = $this->input->post('content');
            $content = $this->security->xss_clean($content);
            $this->tweet_model->add_tweet($content, $user_id);
            // リロードによる再投稿を防ぐため
            redirect('/tweet/','location');
        }
    }

    public function logout()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');

        $this->session->sess_destroy();
        redirect('/login/','location');
    }
}