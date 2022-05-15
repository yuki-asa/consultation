<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');
require_once(ROOT_PATH. 'Controllers/EiyousiController.php');
require_once(ROOT_PATH. 'Views/mutual/validate.php');
$eiyousi = new UserController();
$params = $eiyousi->e_edit();

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
    <form enctype='multipart/form-data' action="e_edit.php?id=<?= $params['eiyousi']['id'] ?>" method="POST">
      <dl>
        <dt>
          <label for="name">名前</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='text' name='name' value='<?php echo htmlspecialchars($params['eiyousi']['name']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_name); ?></p></dd>
        </dd>

        <dt>
          <label for="furigana">ふりがな</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='text' name='furigana' value='<?php echo htmlspecialchars($params['eiyousi']['furigana']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_furigana); ?></p></dd>
        </dd>

        <dt>
          <label for="tell">電話番号</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='tell' name='tell' value='<?php echo htmlspecialchars($params['eiyousi']['tell']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_tell); ?></p></dd>
        </dd>

        <dt>
          <label for="mail">メールアドレス</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='email' name='mail' value='<?php echo htmlspecialchars($params['eiyousi']['mail']); ?>'>
          <dd><p><?php echo htmlspecialchars($err_mail); ?></p></dd>
        </dd>

        <div class = "edit_gazou"><img src="<?=$params['eiyousi']['file_path'] ?>">
        <input type="file" name="img" accept="image/*"></div>
        <dd><p><?php echo htmlspecialchars($err_file); ?></p></dd>
      </dl>
      <p><button type="submit" onclick="return confirm('更新しますか？')">更新</button></p>
    </form>
  </div>
  <div class = 'modoru'><a href="e_mypage.php?id=<?= $params['eiyousi']['id'] ?>">マイページへ戻る</a></div>
</body>
</html>