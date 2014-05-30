<?php
class Test extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tweet_model');
        $this->load->model('user_model');
        $this->load->library('unit_test');
        $this->load->helper('security');
    }    

    public function index()
    {
        // index(){}でlogin,regist,tweet画面のmodelの使い方をチェック
        // 各メソッドを呼び出し、login()の引数にテストしたい値を渡す。


        // login_checkテスト
        $test_1 = $this->user_model->login_check("", "");
        $test_2 = $this->user_model->login_check("abcdef", do_hash("abcdef"));
        $test_3 = $this->user_model->login_check("abc@gmail.com", do_hash("abcdef"));
        $test_4 = $this->user_model->login_check("yuta@yuta.jp", do_hash("yutayuta"));

        $data['login'] = array(
            $this->unit->run($test_1, false, "メールアドレス、パスワードは必須"),
            $this->unit->run($test_2, false, "メールアドレスは、メールアドレスの文字列フォーマットになっ ていない場合、エラーを表示"),
            $this->unit->run($test_3, false, "DBに登録されていない、メールアドレス、パスワードが入力されたとき"),
            $this->unit->run($test_4, true, "DBに登録されているメールアドレス、パスワードが入力されたとき")
        );

        $this->load->view('test',$data);
    }
}