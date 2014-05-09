<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ログイン</title>
</head>
<body>
	<div id="container">
		<?php echo form_open('welcome/index') ?>
			<label for="name">メールアドレス</label>
			<input type="input" name="adress" /><br />

			<label for="password">パスワード</label>
			<input type="password" name="password" /><br />
			<input type="submit" name="submit" value="ログイン" />
		</form>
		<a href="http://vagrant-codeigniter.local/index.php/welcome/regist">ユーザ登録情報はこちら</a>
 	</div>
</body>
</html>