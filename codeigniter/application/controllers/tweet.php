<?php
class Tweet extends CI_Controller
{
    //ツイート読み込み件数　10件
    const TWEET = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tweet_model');
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('typography');
        $this->load->helper('url');
        $this->load->helper('form');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        //　ログインしていない場合、ログイン画面へ遷移
        $check_user = $this->tweet_model->check_user($user_id);

        if ($check_user === false) {
            redirect('/login/','location');
            return;
        }

        $this->form_validation->set_rules('content', 'ツイート', 'required');

        if ($this->form_validation->run() === false) {
            $user_name = $this->user_model->get_user_name($user_id);

            $data['tweet'] = $this->tweet_model->get_tweet($user_id, self::TWEET);
            $data['name'] = $user_name;
            $data['page'] = self::TWEET;

            $all_tweet_num = $this->tweet_model->all_tweet_num($user_id);
            if ($all_tweet_num < self::TWEET) {
                $data['button'] = "0";
            } else {
                $data['button'] = '1';
            }
            $this->load->view('contribute', $data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/login/','location');
    }

     public function insert()
     {
        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('content');

        if ((mb_strlen($content) > 0 and mb_strlen($content) < 140) == false) {
            return null;
        }

        $content = $this->typography->nl2br_except_pre($this->security->xss_clean($content));
        $tweet_id = $this->tweet_model->insert_tweet($content, $user_id);
        $row = $this->tweet_model->tweet_info($tweet_id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content, 'name' => $row['name'], 'time' => $row['create_at'])));
    }

     public function read()
     {
        $user_id = $this->session->userdata('user_id');
        $page = $this->input->get('page');

        $data = $this->tweet_model->read_tweet($user_id , self::TWEET, $page);
        $response = array();
        foreach($data as $result) {
            $response[] = array(
                'content' => $result['content'],
                'name' => $result['name'],
                'time' => $result['create_at']
            );
        }
        $tweet_num = count($response);
        $page += self::TWEET;
        $all_tweet_num = $this->tweet_model->all_tweet_num($user_id);
        if ($tweet_num < self::TWEET || $page == $all_tweet_num) {
            $button_appear = '0';
        } else {
            $button_appear = '1';
        }

        $response = array(
            'tweet' => $response,
            'page' => $page,
            'button' => $button_appear
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}