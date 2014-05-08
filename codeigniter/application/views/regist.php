<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ユーザー登録</title>
</head>
<body>
	<div id="container">
		<?php echo validation_errors(); ?>
		<?php echo form_open('welcome/regist') ?>

		<label for="name">名前</label>
		<input type="input" name="name" /><br />

		<label for="adress">メールアドレス</label>
		<input type="input" name="adress" /><br />

		<label for="password">パスワード</label>
		<input type="password" name="password" /><br />
		<input type="submit" name="submit" value="新規登録" />
		</form>
	</div>
</body>
</html>