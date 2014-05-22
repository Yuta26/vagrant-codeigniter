<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <title>ツイート</title>
    <style type="text/css">
        .tweet{display: inline;}

        .left {
            padding-left: 30px;
            padding-right: 30px;
            float: left;
        }

        .right {
            float: right;
            padding-left: 30px;
            padding-right: 30px;
        }

        .wrapper{
            border: 1px solid #000;
            margin-right: 300px;
        }

    </style>
    <script type="text/javascript">
        var num = 0;
        var contribute_num = 0;

        function timeChange(tweetTime) {
            var registTime = new Date(tweetTime);
            var tweetChangeTime = registTime.getTime();

            var myNow = new Date();
            var changeTime =  myNow.getTime();

            var time = changeTime - tweetChangeTime;
            var hour_time = Math.floor(time/ 1000 / 60 / 60);
            if (hour_time >= 24) {
                var day_time = Math.floor(hour_time / 24);
                return (day_time + "日前");
            } else if (hour_time == 0) {
                return ("１時間以内");
            } else {
                return (hour_time + "時間前");
            }
        };

        $(function() {
            $("#add_wrapper").hide();
            //　時刻変換処理の記述
            $(".right").each(function() {
                var tweetTime = $(this).text();
                resultTime = timeChange(tweetTime);
                $(this).html(resultTime);
            });

            // ツイート投稿時
            $("#tweet_button").click(function() {
                var text = $("#form_text").val();
                if (text == "") {
                    $("#alert").html("何も入力されていません");
                } else {
                    var str = $("#tweet_form").serialize();
                    $.post("tweetadd",str, function(result) {
                        result.time = timeChange(result.time);
                        var div = $("#add_wrapper").children().clone().prependTo("#tweet_list"); 
                        $(".left",div).text(result.name);
                        $(".right",div).text(result.time);
                        $(".tweet-sentence",div).text(result.content);
                    },"json");
                    $("#form_text").attr("value", "");
                    contribute_num++;
                }
            });

            //　「もっと見る」ボタンの実装
            $("#read_button").click(function() {
                num++;
                $.getJSON("tweetadd/read", {"num" : num, "contribute_num" : contribute_num}, function(response) {
                    if (response.length == false) {
                        $("#tweetRead").before("<p>読み込めるツイートはありません</p>");
                        $("#read_button").hide();
                    } else {
                        for (var i = 0 ; i < response.length ; i++) {
                            response[i].time = timeChange(response[i].time);
                            var div = $("#add_wrapper").children().clone().appendTo("#tweet_list");
                            $(".left",div).text(response[i].name);
                            $(".right",div).text(response[i].time);
                            $(".tweet-sentence",div).text(response[i].content);
                        }
                    }
                },"json")
                .error(function(json) {
                    console.log("失敗");
                });
            });
        });
    </script>
</head>
<body>
    <div id="container">
        <!-- ログアウトボタンの実装 -->
        <?php echo validation_errors(); ?>
        <?php echo form_open('tweet/logout'); ?>
            <?php echo form_submit('','ログアウト') ?>
        </form>
        <?php echo '</br>'; ?>

        <!-- ツイート機能の実装 -->
        <div id="alert"></div>
        <?php $attributes = array('id' => 'tweet_form'); ?>
        <?php echo form_open('tweetadd', $attributes); ?>
            <?php
                $tweet_data = array(
                    'name' => 'content',
                    'id' => 'form_text',
                    'rows' => '3',
                    'cols' => '40',
                    'maxlength' => '139'
                );
                echo form_textarea($tweet_data);
            ?>
            <?php
                $tweet_button = array('id' => 'tweet_button');
            ?>
            </br>
            <?php echo form_button($tweet_button,'ツイート'); ?>
        </form>
        </br>

        <!-- ツイート投稿による追加 -->
        <div id="add_wrapper">
            <div class="wrapper">
                <div class="left"></div>
                <div class="right"></div>
                <p class="tweet-sentence"></p>
            </div>
        </div>
        <div id="tweet_list">
            <?php foreach ($tweet as $tweet_item):?>
                <div class="wrapper">
                    <div class="left">
                        <?php echo $tweet_item['name'] ?>
                    </div>
                    <div class='right'>
                        <?php echo $tweet_item['create_at'] ?>
                    </div>
                    <p class="tweet-sentence">
                        <?php echo $tweet_item['content'] ?>
                    </p>
                </div>
            <?php endforeach ?>
        </div>
        <div id="tweetRead"></div>
        </br>
        <?php $read_button = array('id' => "read_button"); ?>
        <?php echo form_button($read_button,'もっと見る'); ?>
    </div>
</body>
</html>