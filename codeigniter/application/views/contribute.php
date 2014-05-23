<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="../css/contribute.css"　type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
  <script type="text/javascript" src="../js/contribute.js"></script>
  <title>ツイート</title>
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
    <?php $read_button = array('id' => 'read_button'); ?>
    <?php echo form_button($read_button,'もっと見る'); ?>
  </div>
</body>
</html>