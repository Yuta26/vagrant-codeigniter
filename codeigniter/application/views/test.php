<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <h1>TEST</h1>
    <!-- ログインに関するチェック -->
    <h2>ログインに関するテスト</h2>
      <?php foreach ($login_check as $login_item):?>
        <?php echo $login_item ?>
      <?php endforeach ?>

    <h2>新規登録に関するテスト</h2>
        <?php echo $add_user[0] ?>
        <?php echo $get_user_id[0] ?>
        <?php echo $get_user_name[0] ?>
      <?php foreach ($check_address as $address_item):?>
        <?php echo $address_item ?>
      <?php endforeach ?>
    <h2>ツイートに関するテスト</h2>
        <!-- <?php echo $tweet ?> -->
</body>
</html>