<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
    <h1>TEST</h1>
    <!-- ログインに関するチェック -->
    <h2>ログインに関するテスト</h2>
      <?php foreach ($login_check as $login_check_item):?>
        <?php echo $login_check_item ?>
      <?php endforeach ?>

    <h2>新規登録に関するテスト</h2>
        <?php echo $add_user[0] ?>
        <?php foreach ($get_user_id as $get_user_id_item):?>
          <?php echo $get_user_id_item ?>
        <?php endforeach ?>
        <?php foreach ($get_user_name as $get_user_name_item):?>
          <?php echo $get_user_name_item ?>
        <?php endforeach ?>
        <?php foreach ($check_address as $check_address_item):?>
          <?php echo $check_address_item ?>
        <?php endforeach ?>
        <?php foreach ($check_address as $check_address_item):?>
          <?php echo $check_address_item ?>
        <?php endforeach ?>


    <h2>ツイートに関するテスト</h2>
        <!-- <?php echo $tweet ?> -->
</body>
</html>