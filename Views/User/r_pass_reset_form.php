<?php
session_start();
require_once(ROOT_PATH. 'Controllers/UserController.php');
require_once(ROOT_PATH .'Models/User.php');

$reset = new UserController();
$reset->r_findToken();

$passwordResetToken = filter_input(INPUT_GET, 'token');

if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}


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
<div class= 'midasi'><h1>パスワードを変更してください</h1></div>

<form action="r_pass_reset.php" method="post">
    <div class= 'touroku'>
        <input type = "hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
        <input type="hidden" name="password_reset_token" value="<?= $passwordResetToken ?>">
        <dl>
            <dt><label for="password">パスワード</label><span class="required">必須</span><dt>
            <dd><input type="password" name="password" id="password" placeholder="パスワード"></dd>
            

            <dt><label for="password_conf">パスワード確認</label><span class="required">必須</span><dt>
            <dd><input type="password" name="password_conf" id="password_conf" placeholder="パスワード確認用"></dd>
        </dl>
    </div>
        <div class= 'sinki'>
            <input type="submit" value="変更する">
        </div>
</form>

</body>

</html>