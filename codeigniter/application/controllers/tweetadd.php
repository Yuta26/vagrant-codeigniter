<?php
class Tweetadd extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tweet_model');
    }

    public function index() {
        // DBから名前と日時を取得しないと行けない
        $content = $this->input->get("content");
        $data = array(
            "content"=>$content
            //　名前をDBから取得
            //"name" => $name,
            //　時間もDBから取得
            //"time" => $time
        );
        $result = $data;
        echo json_encode($result);
    }
}
