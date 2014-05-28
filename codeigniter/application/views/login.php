<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css"　type="text/css">
  <link rel="stylesheet" href="<?=base_url();?>css/login.css"　type="text/css">

  <title>ログイン</title>
</head>
<body>
  <div id="container">
    <?php echo validation_errors(); ?>
    <?php echo form_open('login/index'); ?>
      <label class="address-label">メールアドレス</label>
      <?php echo form_input(array(
          'name' => 'address',
          'value' => set_value('address'),
          'class' => 'address-input')); ?>
      <br />
      <label class="pass-label">パスワード</label>
      <?php echo form_password(array(
          'name' => 'password',
          'class' => 'pass-input')); ?>
      <br />
      <?php echo form_submit(array(
          'value' => 'ログイン',
          'class' => 'login-btn btn btn-warning btn-lg')); ?>
    </form>
    <div class="regist">
      <a href="<?=base_url();?>index.php/regist/index">ユーザ登録はこちらから</a>
    </div>
  </div>
</body>
</html>