<?php
class Tweet_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
        $this->load->helper('date');
        $this->load->library('mymemcache');
    }

    // ユーザーがログインした状態かチェック
    public function check_user($user_id)
    {
        $query = $this->db->get_where('user',array('user_id' => $user_id));
        $db_user_id = $query->row_array();
        if (empty($db_user_id)) {
            return false;
        }
        return true;
    }

    // 最初にツイートを１０件読み出す処理
    public function get_tweet($user_id, $tweet)
    {
        $first_tweet = $this->mymemcache->loadCache($user_id ,'first_tweet');
        if ($first_tweet === false ) {
            $this->db->join('user', 'user.user_id = tweet.user_id');
            $this->db->select('name, content, tweet.create_at');
            $this->db->order_by('tweet.create_at','desc');
            $this->db->where(array('tweet.user_id' => $user_id));
            $query = $this->db->get('tweet', $tweet)->result_array();
            // $query_array = $query->result_array();
            $this->mymemcache->saveCache($user_id, 'first_tweet', $query);
            return $query;
        }
        return $first_tweet;
    }

    public function insert_tweet($content, $user_id)
    {
        $format = 'DATE_ATOM';
        $time = time();
        $create_at = standard_date($format, $time);
        $data = array(
            'create_at' => $create_at,
            'content' => $content,
            'user_id' => $user_id,
        );
        $this->db->insert('tweet',$data);
        $this->mymemcache->deleteCache($user_id);
        return $this->db->insert_id();
    }

    public function tweet_info($tweet_id)
    {
        $this->db->from('tweet');
        $this->db->where(array('tweet_id' => $tweet_id));
        $this->db->join('user', 'user.user_id = tweet.user_id');
        $this->db->select('name, tweet.create_at');
        $query = $this->db->get();
        return $query->row_array();
    }

    //追加で１０件読み込む処理
    public function read_tweet($user_id, $limit, $offset)
    {
        $read_tweet = $this->mymemcache->loadCache($user_id, 'read_tweet'.$offset);
        if ($read_tweet === false ) {
            $this->db->join('user', 'user.user_id = tweet.user_id');
            $this->db->select('name, content, tweet.create_at');
            $this->db->where(array('tweet.user_id' => $user_id));
            $this->db->order_by('tweet.create_at', 'desc');
            $query = $this->db->get('tweet', $limit, $offset)->result_array();
            $this->mymemcache->saveCache($user_id, 'read_tweet_'.$offset, $query);
            return $query;
        }
        return $read_tweet;
    }

    public function all_tweet_num($user_id)
    {        
        $this->db->select('*')->from('tweet')->where(array('user_id' => $user_id));
        return $this->db->count_all_results();
    }
}