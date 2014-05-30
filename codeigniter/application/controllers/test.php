<?php
class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tweet_model');
        $this->load->model('user_model');
        $this->load->library('unit_test');
        $this->load->library('session');
        $this->load->helper('security');
    }    

    public function index()
    {
        // user_modelに関するテスト

        // add_userテスト
        $test_1 = $this->user_model->add_user("abc", "abc@abc.com", do_hash("aaaaaa"));
        $data['add_user'] = array(
            $this->unit->run($test_1, true, "新規ユーザー登録ができる")
        );


        // login_checkテスト
        $test_2 = $this->user_model->login_check("abc@gmail.com", do_hash("aaaaaa"));
        $test_3 = $this->user_model->login_check("abc@abc.com", do_hash("aaaaaa"));

        $data['login_check'] = array(
            $this->unit->run($test_2, false, "DBに登録されていない、メールアドレス、パスワードが入力されたとき、ログイン失敗"),
            $this->unit->run($test_3, true, "DBに登録されているメールアドレス、パスワードが入力されたときログイン成功")
        );


        // get_user_idテスト
        // id=1 yuta@yuta.jpがある場合
        $test_4 = $this->user_model->get_user_id("yuta@yuta.jp");
        $data['get_user_id'] = array(
            $this->unit->run($test_4, is_int(1), "メールアドレスからユーザーIDを取得")
        );


        // get_user_nameテスト
        $test_5 = $this->user_model->get_user_name("1");
        $data['get_user_name'] = array(
            $this->unit->run($test_5, "にわ", "ユーザーIDからユーザー名を取得")
        );

        // check_adressテスト
        $test_6 = $this->user_model->check_address('abc@abc.com');
        $test_7 = $this->user_model->check_address('abc@yahoo.com');
        $data['check_address'] = array(
            $this->unit->run($test_6, true, "入力されたアドレスがDBに登録されていれば、新規登録不可"),
            $this->unit->run($test_7, false, "入力されたアドレスがDBに登録されていなければ、登録可能")
        );

        //



        $this->load->view('test',$data);
    }
}