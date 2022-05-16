<?php
session_start();

require_once(ROOT_PATH. 'Controllers/ReserveController.php');
$reserveitem = new UserController();
$params = $reserveitem->reserve();

$login_user = $_SESSION['login_user'];


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>栄養相談</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>

<body>
    <?php
    mb_language('japanese');
    mb_internal_encoding('UTF-8');

    $to = $_POST['mail'];
    $titele = '予約が入りました。';
    $message = "マイページより予約を確認して下さい";
    $headers = 'From: yuki.042448@gmail.com';
    mb_send_mail($to, $titele, $message, $headers);
?>
<h2>予約が確定しました</h2>
<p>マイページより予約を確認出来ます。</p>
<a href="/User/r_mypage.php?id=<?=$login_user['id']?>">マイページへ</a>

</body>
</html>