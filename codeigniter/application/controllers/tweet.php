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
        // 更新されるまでの間、ページを３０分間キャシングする
        $this->output->cache(60);
        $this->load->driver('cache', array('adapter' => 'memcached'));
    }

    // memcachedのテストのためのコード
    public function test()
    {
        $this->load->driver('cache', array('adapter' => 'memcached'));
        $this->cache->save('foo', '111', 3600);
        $this->cache->save('yuta', 'gagaga', 3600);

        $foo = $this->cache->memcached->get('foo');
        echo $foo;
        $yuta = $this->cache->memcached->get('yuta');
        echo $yuta;
        // var_dump($this->cache->get('foo'));
        exit;
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

        $user_name = $this->user_model->get_user_name($user_id);

        $data['tweet'] = $this->cache->get("first_tweet");
        // log_message('error',$data['tweet']);
        var_dump($data['tweet']);
        if ($data['tweet'] === false) {
            $data['tweet'] = $this->tweet_model->get_tweet($user_id, self::TWEET);
            $this->cache->save("first_tweet", $data['tweet'], 60);
        }
        $tweet = $this->tweet_model->get_tweet($user_id, self::TWEET);
        $data['name'] = $user_name;
        $data['page'] = self::TWEET;

        $all_tweet_num = $this->tweet_model->all_tweet_num($user_id);
        if ($all_tweet_num <= self::TWEET) {
            $data['button'] = "false";
        } else {
            $data['button'] = "true";
        }
        $this->load->view('contribute', $data);
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

        $this->form_validation->set_rules('content', 'ツイート', 'required|max_length[139]');
        if ($this->form_validation->run() === false) {
            return;
        }

        $content = $this->typography->nl2br_except_pre($this->security->xss_clean($content));
        $tweet_id = $this->tweet_model->insert_tweet($content, $user_id);
        $row = $this->tweet_model->tweet_info($tweet_id);
        // $this->cache->save("add_tweet", $content, 60);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content, 'name' => $row['name'], 'time' => $row['create_at'])));
    }

     public function read()
     {
        $user_id = $this->session->userdata('user_id');
        $page = $this->input->get('page');

        $response = $this->cache->get('read_tweet'.$page);
        if ($response == false) {
            $data = $this->tweet_model->read_tweet($user_id , self::TWEET, $page);
            $response = array();
            foreach($data as $result) {
                $response[] = array(
                    'content' => $result['content'],
                    'name' => $result['name'],
                    'time' => $result['create_at']
                );
            }
        }
        $this->cache->save('read_tweet_'.$page, $response, 60);

        $tweet_num = count($response);
        $page += self::TWEET;
        $all_tweet_num = $this->tweet_model->all_tweet_num($user_id);
        if ($tweet_num < self::TWEET || $page == $all_tweet_num) {
            $button_appear = "false";
        } else {
            $button_appear = "true";
        }

        $response = array(
            'tweet' => $response,
            'page' => $page,
            'button' => $button_appear
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}