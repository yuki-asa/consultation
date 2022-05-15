<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');

$err_mes=[];

if(!$email=filter_input(INPUT_POST, 'mail')){
    $err_mes['mail'] = "メールアドレスを入力してください";
}

if(!$password = filter_input(INPUT_POST, 'password')){
    $err_mes['password'] = "パスワードを入力してください。";
}
if (count($err_mes) > 0){
    $_SESSION = $err_mes;
    header('Location: e_login_form.php');
}


$result = Eiyousi::login($email, $password);

if (!$result) {
    header('Location: e_login_form.php?id='.$_SESSION['login_user']['id']);
    return;
}
$login_user = $_SESSION['login_user'];

if(count($err_mes) == 0){
    header('Location:e_mypage.php?id='.$login_user['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了</title>
</head>
<body>
    <?php if(count($err_mes) > 0) :?>
        <?php foreach($err_mes as $e) :?>
            <p><?php echo htmlspecialchars($e); ?></p>
        <?php endforeach; ?>
    <?php else :?>
        <h2>ログインしました。</h2>
        <p>マイページよりアカウントの変更、案件投稿を行ってください。</p>
    <?php endif;?>
    <a href="e_mypage.php?id=<?= $login_user['id'] ?>">マイページへ</a>

</body>
</html>