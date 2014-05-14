<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ユーザー登録</title>
</head>
<body>
    <div id="container">
        <?php echo validation_errors(); ?>
        <?php echo form_open('regist/regist'); ?>

        <label>名前</label>
        <?php echo form_input('name',set_value('name')); ?>
        <br />

        <label>メールアドレス</label>
        <?php echo form_input('adress',set_value('adress')); ?>
        <br />

        <label>パスワード</label>
        <?php echo form_password('password'); ?>
        <br />
        <?php echo form_submit('','新規登録'); ?>
        </form>
    </div>
</body>
</html>