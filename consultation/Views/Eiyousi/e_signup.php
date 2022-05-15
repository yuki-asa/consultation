<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');


$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

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
    <div class= 'midasi'><h1>新規登録</h1></div>
    <div class= 'zyouhou'>
        <p>お客様情報を入力してください</p>
    </div>
    <?php if(isset($login_err)):?>
        <p><?php echo htmlspecialchars($login_err);?></p>
    <?php endif; ?>
    <form enctype='multipart/form-data' action="new.php" method="post">
        <div class= 'touroku'>
            <dl>
                <dt><label for="name">名前</label><span class="required">必須</span></dt>
                <dd><input type="name" name="name" id="name" placeholder="名前"></dd>


                <dt><label for="furigana">フリガナ</label><span class="required">必須</span><dt>
                <dd><input type="furigana" name= "furigana" id="furigana" placeholder="フリガナ"></dd>


                <dt><label for="tell">電話番号</label><span class="required">必須</span><dt>
                <dd><input type="tell" name="tell" id="tell" placeholder="電話番号"></dd>


                <dt><label for="mail">メールアドレス</label><span class="required">必須</span><dt>
                <dd><input type="mail" name="mail" id="mail" placeholder="メールアドレス"></dd>


                <dt><label for="password">パスワード</label><span class="required">必須</span><dt>
                <dd><input type="password" name="password" id="password" placeholder="パスワード"></dd>
            

                <dt><label for="password_conf">パスワード確認</label><span class="required">必須</span><dt>
                <dd><input type="password" name="password_conf" id="password_conf" placeholder="パスワード確認用"></dd>

                <input type="file" name="img" accept="image/*">
            </dl>
        </div>
        <div class= 'sinki'>
            <input type="submit" value="登録する">
        </div>
    </form>

</body>
<html>