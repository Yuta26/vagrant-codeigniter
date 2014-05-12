<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ログイン</title>
</head>
<body>
	<div id="container">
		<?php echo validation_errors(); ?>
		<?php echo form_open('login/index') ?>
			<label>メールアドレス</label>
			<?php echo form_input('adress'); ?>
			<br />
			<label>パスワード</label>
			<?php echo form_password('password'); ?>
			<br />
			<?php echo form_submit('','ログイン'); ?>
		</form>
		<a href="http://vagrant-codeigniter.local/index.php/regist/index">ユーザ登録情報はこちら</a>
 	</div>
</body>
</html>