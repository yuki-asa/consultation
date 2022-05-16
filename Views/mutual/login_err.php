<?php
session_start();
require_once(ROOT_PATH .'Models/User.php');

$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください。';
    header('Location: e_r_top.php');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインエラー</title>
</head>
<body>
    <h2>ログインに失敗しました。</h2>
    <a href="e_r_top.php">ログインに失敗しました。</a>
</body>
</html>