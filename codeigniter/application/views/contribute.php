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
            float:right;
            padding-left: 30px;
            padding-right: 30px;
        }

        .wrapper{
            border: 1px solid #000;
            margin-right: 300px;
        }

    </style>
    <script type="text/javascript">
        //submitボタンが押されたら、csrf_test_nameを送信する
        $(function() {
            $("#tweet_button").click(function() {
                // ツイートの内容をテキスト化する
                var str = $("#tweet_form").serialize();
                console.log(str);
                var hiddenStr = $(":hidden").serializeArray();
                var csrf_value = hiddenStr[0];
                var csrf_test_name = $(csrf_value).attr('name');
                var csrf_test_value = $(csrf_value).attr('value');

                // ツイートの内容と、csrf_test_nameの値をサーバーに送信
                $.getJSON("tweetadd",{csrf_test_name:csrf_test_value}, function(){},"json");
                $.getJSON("tweetadd",str, function(result) {
                    $("#left_add").append(result.name);
                    $("#right_add").append(result.time);
                    $("#tweet_sentence_add").append(result.content);
                },"json");
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
        <?php $attributes = array('id' => 'tweet_form'); ?>
        <?php echo form_open('tweetadd', $attributes); ?>
            <?php
                $tweet_data = array(
                    'name' => 'content',
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
        <div class="wrapper">
            <div id="left_add">
                 <!-- <?php echo $tweet_item['name'] ?> -->
            </div>
            <div id='right_add'>
                <!-- <?php echo $tweet_item['create_at'] ?> -->
            </div>
            <p id="tweet_sentence_add">
                <!-- <?php echo $tweet_item['content'] ?> -->
            </p>
        </div>
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
        </br>
        <input type="button" value="もっと見る">
    </div>
</body>
</html>