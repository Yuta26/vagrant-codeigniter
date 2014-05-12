<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ツイート</title>
	<style type="text/css">
		.tweet{display: inline;}
		#left{
			padding-left: 30px;
			padding-right: 30px;
			float: left;
		}
		#right{
			float:right;
			padding-left: 30px;
			padding-right: 30px;
		}
		.wrapper{
			border: 1px solid #000;
			margin-right: 300px;
		}
		.tweet-sentence{

		}
	</style>
</head>
<body>
	<div id="container">

		<!-- ログアウトボタンの実装 -->
		<?php echo validation_errors(); ?>
		<?php echo form_open('tweet/logout'); ?>
		<input type="hidden" name="flag" value="1">
		<input type="submit" value="ログアウト">
		</form>

		<!-- ツイート機能の実装 -->
		<?php echo form_open('tweet/index'); ?>
		<?php echo '</br>'; ?>
		<textarea name="content" rows="4" cols="40"></textarea>
		</br>
		<input type="submit" value="ツイート">
		</form>
		</br>
		<?php foreach ($tweet as $tweet_item):?>
			<div class="wrapper">
				<div id="left">
					<?php echo $tweet_item['name'] ?>
				</div>
				<div id='right'>
					<?php echo $tweet_item['create_tweet'] ?>
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