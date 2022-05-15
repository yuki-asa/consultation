<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

if(!$logout = filter_input(INPUT_POST,'logout')){
    exit('不正なリクエストです。');
}

$result = UserLogic::checkLogin();

if(!$result){
   exit('セッションが切れたので、ログインし直してください。');
}

UserLogic::logout();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログアウト</title>
</head>
<body>
    <h2>ログアウト完了</h2>
    <p>ログアウトしました。</p>
    <a href="e_r_top.php">ログイン画面</a>
</body>
</html>