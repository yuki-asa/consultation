<?php
session_start();
require_once(ROOT_PATH. 'Controllers/EiyousiController.php');
$customer = new UserController();
$params = $customer->customer();


$result = UserLogic::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:r_signup.php');
    return;
}

$login_user = $_SESSION['login_user'];
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
        <div class = "midasi"><h2>お客様の詳細</h2></div>
        <div class = 'syousai'>
            <table>
                <tr>
                    <th>名前</th>
                    <td><?php echo htmlspecialchars($params['customer']['name']); ?></td>
                    </tr>
                <tr>
                    <th>フリガナ</th>
                    <td><?php echo htmlspecialchars($params['customer']['furigana']); ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo htmlspecialchars($params['customer']['mail']); ?></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?php echo htmlspecialchars($params['customer']['tell']); ?></td>
                </tr>
            </table>
            <div class = "gazou"><img src="<?=$params['customer']['file_path'] ?>"></div>
        </div>

        <div class = 'kakutei'>
            <a href="e_mypage.php?id=<?=$login_user['id'] ?>">マイページへ戻る</a>
        <div>
    </form>

</body>
</html>
