<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');
require_once(ROOT_PATH. 'Controllers/UserController.php');
require_once(ROOT_PATH. 'Views/mutual/validate.php');

$user = new UserController();
$params = $user->r_edit();

$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:e_signup.php');
    return;
}

$login_user = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>栄養相談</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>

<body>
  <div class ='touroku'>
    <h2>■アカウント情報編集</h2>
    <form enctype='multipart/form-data' action="r_edit.php?id=<?= $params['user']['id'] ?>" method="POST">
      <dl>
        <dt>
          <label for="name">名前</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='text' name='name' value='<?php echo htmlspecialchars($params['user']['name']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_name); ?></p></dd>
        </dd>

        <dt>
          <label for="furigana">ふりがな</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='text' name='furigana' value='<?php echo htmlspecialchars($params['user']['furigana']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_furigana); ?></span></p>
        </dd>

        <dt>
          <label for="tell">電話番号</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='tell' name='tell' value='<?php echo htmlspecialchars($params['user']['tell']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_tell); ?></p></dd>
        </dd>

        <dt>
          <label for="mail">メールアドレス</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='email' name='mail' value='<?php echo htmlspecialchars($params['user']['mail']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_mail); ?></span></p>
        </dd>
        <div class = "edit_gazou"><img src="<?=$params['user']['file_path'] ?>">
        <input type="file" name="img" accept="image/*"></div>
        <dd><p><?php echo htmlspecialchars($err_file); ?></p></dd>
      </dl>
      <p><button type="submit" onclick="return confirm('更新しますか？')">更新</button></p>
    </form>
  </div>
  <div class = 'modoru'><a href="r_mypage.php?id=<?= $params['user']['id'] ?>">マイページへ戻る</a></div>
</body>
</html>