<?php
session_start();
require_once(ROOT_PATH. 'Controllers/UserController.php');
require_once(ROOT_PATH .'Models/User.php');

$reset = new UserController();
$reset->r_pass_reset();

$err = $_SESSION;

$csrfToken = filter_input(INPUT_POST, '_csrf_token');

// csrf tokenを検証
if (
    empty($csrfToken)
    || empty($_SESSION['_csrf_token'])
    || $csrfToken !== $_SESSION['_csrf_token']
) {
    exit('不正なリクエストです');
}

$err_mes = [];
if(!$email=filter_input(INPUT_POST, 'mail')){
    $err_mes['mail'] = "メールアドレスを入力してください";
}
if (count($err_mes) > 0){
    $_SESSION = $err_mes;
    header('Location: request_form.php');
}

$result = UserLogic::getUserByEmail($_POST['mail']);
if(!$result){
    header('Location: request_form.php');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>栄養相談</title>
</head>
<body>
    <h2>メールの送信が完了しました。</h2>
    <p>送信されたメールのURLへアクセスし、パスワードの変更を完了してください。</p>
    <a href="/mutual/e_r_top.php">トップへ戻る</a>
</body>
</html>