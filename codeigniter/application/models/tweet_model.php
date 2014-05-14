<?php
class Tweet_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    // ユーザーがログインした状態かチェック
    public function check_user($check_user_id)
    {
        $query = $this->db->get_where('user',array('user_id' => $check_user_id));
        $db_user_id = $query->result_array();
        if ($db_user_id == true) {
            return true;
        } else {
            return false;
        }
    }

    public function get_tweet()
    {
        $this->load->library('session');
        $data = $this->session->all_userdata();
        $adress = $data['adress'];
        // ログインアドレスの投稿ツイートを１０件取得
        $this->db->order_by("create_tweet", "desc");
        // DBテーブル'tweet'にadressというカラムがないというエラー
        //$query = $this->db->get_where('tweet',array('adress' => $adress),10);
       // return $query->result_array();
        return;
    }

    public function set_tweet($content)
    {
        $this->load->library('session');
        $this->load->helper('date');

        $format = 'DATE_ATOM';
        $time = time();
        $create_at = standard_date($format, $time); 

        $data = $this->session->all_userdata();
        $name = $data['name'];
        $adress = $data['adress'];

        $data = array(
            'create_tweet' => $create_at,
            'content' => $content,
            'name' => $name,
            'adress' => $adress
        );
        return $this->db->insert('tweet',$data);
    }
}