<?php
$err_name = "";
$err_furigana= "";
$err_tell= "";
$err_mail= "";
$err_file= "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
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
        $err_file = '画像ファイルを添付してください';
    }
    if(empty($_POST['name'])) {
        $err_name = '名前を入力してください。';
    }
    if(empty($_POST['furigana'])) {
        $err_furigana = 'フリガナを入力してください。';
    }
    if(empty($_POST['tell'])) {
        $err_tell = '電話番号を入力してください。';
    }else if(!preg_match('/^[0-9]+$/', $_POST['tell'])) {
        $err_tell  = '電話番号は0−9の数字で入力してください';
    }
    if(empty($_POST['mail'])) {
        $err_mail = 'メールアドレスを入力してください';
    } else if(!preg_match('/^[a-zA-Z0-9_+-]+(\.[a-zA-Z0-9_+-]+)*@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/',$_POST['mail'])) {
        $err_mail = '正しいメールアドレスを入力してください';
    }
    if($err_name=="" && $err_furigana=="" && $err_tell=="" && $err_mail=="" && $err_file){
        if(is_uploaded_file($tmp_path)){
            if(move_uploaded_file($tmp_path, $save_path)){
            }
        }
    }
}

?>