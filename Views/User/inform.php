<?php
session_start();
require_once(ROOT_PATH. 'Controllers/UserController.php');
$item = new UserController();
$params = $item->inform();

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
        <div class = "midasi"><h2>栄養士の詳細</h2></div>
        <div class = 'syousai'>
            <table>
                <tr>
                    <th>名前</th>
                    <td><?php echo htmlspecialchars($params['item']['name']); ?></td>
                </tr>
                <tr>
                    <th>フリガナ</th>
                    <td><?php echo htmlspecialchars($params['item']['furigana']); ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo htmlspecialchars($params['item']['mail']); ?></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?php echo htmlspecialchars($params['item']['tell']); ?></td>
                </tr>
    
                <tr>
                    <th>得意分野</th>
                    <td><?php echo htmlspecialchars($params['item']['specialty']); ?></td>
                </tr>
                <tr>
                    <th>予約可能日</th>
                    <td><?php echo htmlspecialchars($params['item']['possible_date']); ?></td>
                </tr>
                </tr>
                    <th>予約地域</th>
                    <td><?php echo htmlspecialchars($params['item']['area']); ?></td>
                </tr>
                <tr>
                    <th>料金</th>
                    <td><?php echo htmlspecialchars($params['item']['price']); ?></td>
                </tr>
                <tr>
                    <th>自己PR</th>
                    <td><?php echo htmlspecialchars($params['item']['self_pr']); ?></td>
                </tr>
            </table>
            <div class = "gazou"><img src="<?=$params['item']['file_path'] ?>"></div>
        </div>
        <div class = 'kakutei'>
            <a href="r_mypage.php?id=<?=$login_user['id'] ?>">マイページへ戻る</a>
        <div>
        <form action="cansel.php" method= "post">
            <input type ="hidden" name = "mail" value = "<?=$params['item']['mail'] ?>">
            <div class = 'kakutei'>
                <button><input type="hidden" name="item_id" onclick="return confirm('本当にキャンセルしますか')" value="<?=$params['item']['item_id'] ?>">キャンセルする</button>
            </div>
        </form>


</body>
</html>
