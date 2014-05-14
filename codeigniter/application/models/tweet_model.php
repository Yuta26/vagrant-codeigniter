<?php
class Tweet_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function check_user()
    {
        $this->load->library('session');
        $data = $this->session->all_userdata();
        $query = $this->db->get_where('user',array('adress' => $data['adress']));
        $db_adress = $query->result_array();
        if($db_adress == true) {
            return true;
        }
        else return;
    }

    public function get_tweet()
    {
        $this->load->library('session');
        $data = $this->session->all_userdata();
        $adress = $data['adress'];
        // ログインアドレスの投稿ツイートを１０件取得
        $this->db->order_by("create_tweet", "desc");
        $query = $this->db->get_where('tweet',array('adress' => $adress),10);
        return $query->result_array();
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