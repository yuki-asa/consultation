<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');
require_once(ROOT_PATH .'Controllers/EiyousiController.php');

$eiyousi= new UserController();
$params = $eiyousi->createUser();

$err_mes=[];

if(!$name=filter_input(INPUT_POST, 'name')){
    $err_mes[] = "名前を入力してください";
}

if(!$furigana=filter_input(INPUT_POST, 'furigana')){
    $err_mes[] = "フリガナを入力してください";
}

$tell=filter_input(INPUT_POST, 'tell');
if(!preg_match('/^[0-9]+$/', $tell)) {
    $err_mes[]  = '電話番号は0−9の数字で入力してください';
}

if(!$email=filter_input(INPUT_POST, 'mail')){
    $err_mes[] = "メールアドレスを入力してください";
}

$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)) {
    $err_mes[] = 'パスワードは英数字8文字以上100文字以下にしてください。';
}

$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf){
    $err_mes[] = "確認用パスワードと異なっています";
}

// ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];



$upload_dir = 'images/';
$save_filename =date('Ymd'). $filename;
$save_path = $upload_dir.$save_filename;


// $caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS);

// 拡張は画像形式か
$allow_ext = array('jpg', 'jpeg', 'png');
$file_ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array(strtolower ($file_ext), $allow_ext)){
    $err_mes[] = '画像ファイルを添付してください';
}

// ファイルはあるかどうか
if(count($err_mes) === 0){
    if(is_uploaded_file($tmp_path)){
        if(move_uploaded_file($tmp_path, $save_path)){
        }else {
            $err_mes[] = 'ファイルが保存できませんでした。';
        }
    }else{
        $err_mes [] = 'ファイルが選択されていません。';
    }
}


// if (count($err_mes) === 0){
    // $hasCreated = UserLogic::createUser($_POST);

    // if($hasCreated){
        // $err_mes[] = "登録に失敗しました";
    // }
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録完了</title>
</head>
<body>
    <?php if(count($err_mes) > 0) :?>
        <?php foreach($err_mes as $e) :?>
            <p><?php echo htmlspecialchars($e); ?></p>
        <?php endforeach; ?>
        <a href="e_signup.php">新規登録に戻る</a>
    <?php else :?>
        <h2>登録が完了しました</h2>
        <p>ログイン画面よりログインしてください。</p>
    <?php endif;?>
    <a href="e_login_form.php">ログイン画面</a>
</body>
</html>