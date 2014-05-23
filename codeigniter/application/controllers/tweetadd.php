<?php
class Tweetadd extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tweet_model');
    }

    public function index() {
        $this->load->library('session');
        $this->load->library('form_validation');

        $user_id = $this->session->userdata('user_id');
        $content = $this->input->post('content');
        $content = $this->security->xss_clean($content);
        $tweet_id = $this->tweet_model->insert_tweet($content, $user_id);
        $row = $this->tweet_model->get_name($user_id, $tweet_id);
        $data = array(
            'content' => $content,
            'name' => $row['name'],
            'time' => $row['create_at']
        );
        $result = $data;
        header('Content-type:application/json; charset=utf8');
        echo json_encode($result);
    }

     public function read() {
        $add_tweet = 10;
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        $num = $this->input->get("num");
        $contribute_num = $this->input->get('contribute_num');
        $data = $this->tweet_model->read_tweet($user_id ,$num, $contribute_num, $add_tweet);
        $response = array();
        foreach($data as $result) {
            $response[] = array(
                'content' => $result['content'],
                'name' => $result['name'],
                'time' => $result['create_at']
            );
        }
        header('Content-type:application/json; charset=utf8');
        echo json_encode($response);
    }
}
