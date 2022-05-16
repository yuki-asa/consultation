<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');
require_once(ROOT_PATH. 'Controllers/UserController.php');
$user = new UserController();
$user->cancelId();

$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:r_signup.php');
    return;
}

$login_user = $_SESSION['login_user'];




?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>削除完了</title>
  </head>
  <body>          
  <?php
    mb_language('japanese');
    mb_internal_encoding('UTF-8');

    $to = $_POST["mail"];
    $titele = "予約がキャンセルになりました。";
    $message = "マイページより予約を確認して下さい";
    $headers = 'From: yuki.042448@gmail.com';
    mb_send_mail($to, $titele, $message, $headers);
?>
  </body>
</html>