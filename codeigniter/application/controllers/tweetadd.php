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
        $row = $this->tweet_model->get_name($tweet_id);
        $this->output->set_content_type('application/json')->set_output(json_encode(array('content' => $content, 'name' => $row['name'], 'time' => $row['create_at'])));
    }

     public function read() {
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
}
