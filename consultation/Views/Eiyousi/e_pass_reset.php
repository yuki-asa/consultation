<?php

session_start();
require_once(ROOT_PATH. 'Controllers/EiyousiController.php');
require_once(ROOT_PATH .'Models/Eiyousi.php');

$reset = new UserController();
$reset->e_updatereset();

    $request = filter_input_array(INPUT_POST);

    // csrf tokenが正しければOK
    if (
        empty($request['_csrf_token'])
        || empty($_SESSION['_csrf_token'])
        || $request['_csrf_token'] !== $_SESSION['_csrf_token']
    ){
    exit('不正なリクエストです');
    }

$err_mes=[];

$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
    $err_mes[] = 'パスワードは英数字8文字以上100文字以下にしてください。';
}

$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf){
    $err_mes[] = "確認用パスワードと異なっています";
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
    <?php if(count($err_mes) > 0) :?>
        <?php foreach($err_mes as $e) :?>
            <p><?php echo htmlspecialchars($e); ?></p>
        <?php endforeach; ?>
        <a href="e_signup.php">新規登録に戻る</a>
    <?php else :?>
        <p>登録が完了しました。</p>
    <?php endif;?>
    <a href="e_login_form.php">ログイン画面</a>
</body>
</html>