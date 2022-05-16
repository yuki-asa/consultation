<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');
require_once(ROOT_PATH. 'Controllers/Eiyousi.php');
require_once(ROOT_PATH. 'Views/Players/validate.php');
$eiyousi = new UserController();
$params = $eiyousi->e_edit();

$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:e_signup.php');
    return;
}

$login_user = $_SESSION['login_user'];

$err_mes=[];
// ファイル関連の取得
$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];



$upload_dir = '../images';
$save_filename = date('Ymd').$filename;
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
            header("Location:e_mypage.php?id=".$_SESSION['login_user']['id']);
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
            <p><?php echo $e; ?></p>
        <?php endforeach; ?>
        <a href="e_signup.php">新規登録に戻る</a>
    <?php else :?>
        <p>登録が完了しました。</p>
    <?php endif;?>
    <a href="e_login.php">ログイン画面</a>
</body>
</html>