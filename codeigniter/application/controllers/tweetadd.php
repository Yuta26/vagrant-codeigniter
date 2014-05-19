<?php
class Tweetadd extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tweet_model');
    }

    public function index() {
        // DBから名前と日時を取得しないと行けない
        $this->load->library('session');
        $this->load->library('form_validation');

        $user_id = $this->session->userdata('user_id');
        $content = $this->input->get("content");
        $content = $this->security->xss_clean($content);
        $this->tweet_model->insert_tweet($content, $user_id);
        $row = $this->tweet_model->get_name($user_id);
        $data = array(
            "content"=>$content,
            "name" => $row['name'],
            "time" => $row['create_at']
        );
        $result = $data;
        echo json_encode($result);
    }

     public function read() {
        /*
        [{"content":"\u304c\u3046","name":"\u60a0\u592a","time":"2014-05-19 17:02:21"}{"content": ""...}]
        */
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        //　ここが原因（ajaxができなくなる）
        $data = $this->tweet_model->read_tweet($user_id);
        $response = array();
        foreach($data as $result) {
            $response[] = array(
                "content" => $result["content"],
                "name" => $result["name"],
                "time" => $result["create_at"]
            );
        }
        echo json_encode($response);
    }
}
