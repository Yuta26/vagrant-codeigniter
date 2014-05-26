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
            $data['tweet'] = $this->tweet_model->get_tweet($user_id, self::TWEET);
            $this->load->view('contribute',$data);
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
        $offset = $this->input->get('offset');
        $limit = $this->input->get('limit');
        $data = $this->tweet_model->read_tweet($user_id , $limit, $offset);
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

    // ツイート格納数が10件以上の場合、もっと見るボタンの表示
    public function tweet_num()
    {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $tweet_num = $this->tweet_model->db_tweet_num($user_id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('tweet_num' => $tweet_num)));
    }

    public function user_name()
    {
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        if ($user_id == true)
        $row = $this->user_model->get_user_name($user_id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('name' => $row)));
    }
}

