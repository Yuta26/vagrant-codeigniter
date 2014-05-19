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
        $this->load->library('session');
        $user_id = $this->session->userdata('user_id');
        //　ここが原因（ajaxができなくなる）
        //$data = $this->tweet_model->read_tweet($user_id);
        // foreach($result as $result_item){
        //     echo result_item["name"];
        //     echo result_item["create_at"];
        //     echo result_item["content"];
        // };

        //　サンプル
        $data = array(
            "content" => "大きな栗の",
            "name" => "にわ",
            "time" => "１時間前"
        );
        $result = $data;
        echo json_encode($result);
    }
}
