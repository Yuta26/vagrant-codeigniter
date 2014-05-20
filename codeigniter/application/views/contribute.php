<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <title>ツイート</title>
    <style type="text/css">
        .tweet{display: inline;}

        #left,
        #result_add {
            padding-left: 30px;
            padding-right: 30px;
            float: left;
        }

        #right,
        #right_add {
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
        $(function() {
            // ツイート投稿時
            $("#tweet_button").click(function() {
                var text = $("#form_text").val();
                console.log(text);
                if (text == "") {
                    $("#alert").html("何も入力されていません");
                } else {
                    var str = $("#tweet_form").serialize();
                    $.getJSON("tweetadd",str, function(result) {
                        $("#tweetInsert").prepend(
                            "<div class='wrapper'>" +
                                "<div id='left_add'>" +
                                    result.name +
                                "</div>" +
                                "<div id='right_add'>" +
                                    result.time +
                                "</div>" +
                                "<p>" +
                                    result.content +
                                "</p>" +
                            "</div>"
                        );
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
                            $("#tweetRead").before(
                                "<div class='wrapper'>" +
                                    "<div id='left_add'>" +
                                        response[i].name +
                                    "</div>" +
                                    "<div id='right_add'>" +
                                        response[i].time +
                                    "</div>" +
                                    "<p>" +
                                        response[i].content +
                                    "</p>" +
                                "</div>"
                            );
                        }
                        contribute_num = 0;
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
        <div id="tweetInsert"></div>
        <?php foreach ($tweet as $tweet_item):?>
            <div class="wrapper">
                <div id="left">
                    <?php echo $tweet_item['name'] ?>
                </div>
                <div id='right'>
                    <?php echo $tweet_item['create_at'] ?>
                </div>
                <p class="tweet-sentence">
                    <?php echo $tweet_item['content'] ?>
                </p>
            </div>
        <?php endforeach ?>
        <div id="tweetRead"></div>
        </br>
        <?php $read_button = array('id' => "read_button"); ?>
        <?php echo form_button($read_button,'もっと見る'); ?>
    </div>
</body>
</html>