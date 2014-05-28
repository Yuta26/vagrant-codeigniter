<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" href="<?=base_url();?>css/bootstrap.min.css"　type="text/css">
  <link rel="stylesheet" href="<?=base_url();?>css/regist.css"　type="text/css">
  <title>ユーザー登録</title>
</head>
<body>
  <div id="container">
    <?php echo validation_errors(); ?>
    <?php echo form_open('regist/index'); ?>

    <label class="name-label">名前</label>
    <?php echo form_input(array(
        'name' => 'name',
        'value' => set_value('name'),
        'class' => 'name-input')); ?>
    <br />
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
        'value' => '新規登録',
        'class' => 'login-btn btn btn-warning btn-lg')); ?>
    </form>
  </div>
</body>
</html>