<?php
class Tweet_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    // ユーザーがログインした状態かチェック
    public function check_user($user_id)
    {
        $query = $this->db->get_where('user',array('user_id' => $user_id));
        $db_user_id = $query->result_array();
        if ($db_user_id == true) {
            return true;
        } else {
            return false;
        }
    }

    // 最初にツイートを１０件読み出す処理
    public function get_tweet($user_id)
    {
        $this->db->join('user', 'user.user_id = tweet.user_id');
        $this->db->select('name, content, tweet.create_at');
        $this->db->order_by('tweet.create_at','desc');
        $this->db->where(array('tweet.user_id' => $user_id));
        $query = $this->db->get('tweet',10);
        return $query->result_array();
    }

    public function insert_tweet($content, $user_id)
    {
        $this->load->helper('date');

        $format = 'DATE_ATOM';
        $time = time();
        $create_at = standard_date($format, $time);
        $data = array(
            'create_at' => $create_at,
            'content' => $content,
            'user_id' => $user_id,
        );
        return $this->db->insert('tweet',$data);
    }

    // ツイート投稿に伴う、名前の取得
    public function get_name($user_id)
    {
        $this->db->join('user', 'user.user_id = tweet.user_id');
        $this->db->select('name, tweet.create_at');
        $this->db->where(array('tweet.user_id' => $user_id));
        $this->db->order_by('tweet.create_at', 'desc');
        $query = $this->db->get('tweet',1);
        return $query->row_array();
    }


    //追加で１０件読み込む処理
    public function read_tweet($user_id)
    {
        $this->db->join('user', 'user.user_id = tweet.user_id');
        $this->db->select('name, content, tweet.create_at');
        $this->db->where(array('tweet.user_id' => $user_id));
        $this->db->order_by('tweet.create_at', 'desc');
        //$num  = $this->db->count_all('tweet');
        //echo $num;
        //if ($num >= 10) {
        $query = $this->db->get('tweet',10,10);
        //}
        return $query->result_array();
    }
}