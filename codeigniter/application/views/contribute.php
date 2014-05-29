<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css"　type="text/css">
  <link rel="stylesheet" href="<?=base_url();?>css/contribute.css"　type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
  <script type="text/javascript" src="<?=base_url();?>js/contribute.js"></script>
  <script type="text/javascript" src="<?=base_url();?>js/underscore.js"></script>

  <title>ツイート</title>
</head>
<body>
  <!-- 「もっと見る」でDBからツイートを取り出す際に使用 -->
  <input type="hidden" value="10" id="page" />
  <div id="container">
    <div id="topLine">
      <?php echo form_open('tweet/logout'); ?>
        <div id="userName"><?php echo $name; ?></div>
      <?php echo form_submit(array(
        'value' => 'ログアウト',
        'class' => 'logout-btn btn btn-lg ')); ?>
      </form>
    </div>

    <!-- ツイート機能の実装 -->
    <div id="tweetArea">
    <div id="alert"></div>
    <?php echo validation_errors(); ?>
    <?php echo form_open('tweetadd', array('id ' => 'tweetForm')); ?>
      <?php
        echo form_textarea(array(
          'name' => 'content',
          'id' => 'formText',
          'rows' => '4',
          'cols' => '80',
          'maxlength' => '139')); ?>
      </div>
      <?php echo form_button(array(
        'class' => 'btn btn-warning',
        'id' => 'tweetButton'),'ツイート'); ?>
    </form>
    </br>

    <!-- ツイート追加テンプレート -->
    <script type="text/template" id="addWrapper">
      <div id="addWrapper">
        <div class="wrapper">
          <div class="left"><%= name %></div>
          <div class="right"><%= time %></div>
          <p class="tweet-sentence"><%= content %></p>
        </div>
      </div>
    </script>

    <div id="tweetViewArea">
      <div id="tweetList">
        <div id="addTweet"></div>
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
        <div id="readTweet"></div>
      </div>
      <div id="tweetRead"></div>
      </br>
      <?php echo form_button(array(
        'class' => 'btn btn-warning btn-lg',
        'id' => 'readButton'),'もっと見る'); ?>
    </div>
  </div>
</body>
</html>