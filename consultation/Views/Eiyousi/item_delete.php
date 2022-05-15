<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');
require_once(ROOT_PATH. 'Controllers/EiyousiController.php');

$eiyousi = new UserController();
$eiyousi->item_delete();

$result = Eiyousi::checkLogin();

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
    <meta charset="utf-8">
    <title>削除完了</title>
  </head>
  <body>          
  <p>
      <a href="contact.php">問い合わせへ戻る</a>
  </p> 
  </body>
</html>