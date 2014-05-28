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
            $user_name = $this->user_model->get_user_name($user_id);
            $data['tweet'] = $this->tweet_model->get_tweet($user_id, self::TWEET);
            $data['name'] = $user_name;
            $this->load->view('contribute', $data);
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

     public function insert()
     {
        $this->load->library('session');
        $this->load->library('form_validation');

        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('content');
        $content = $this->security->xss_clean($content);
        $tweet_id = $this->tweet_model->insert_tweet($content, $user_id);
        $row = $this->tweet_model->tweet_info($tweet_id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content, 'name' => $row['name'], 'time' => $row['create_at'])));
    }

     public function read()
     {
        $this->load->library('session');
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
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function page() {
        $page = $this->input->get('page');
        $pages = array('page' => ($page + self::TWEET));
        $this->output->set_content_type('application/json')->set_output(json_encode($pages));
    }

    public function tweet_num()
    {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $all_tweet_num = $this->tweet_model->db_tweet_num($user_id);
        $result = array(
            'tweet_read_num' => self::TWEET,
            'all_tweet_num' => $all_tweet_num
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

