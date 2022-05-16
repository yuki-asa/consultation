<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');
require_once(ROOT_PATH. 'Controllers/EiyousiController.php');
$eiyousi = new UserController();
$params = $eiyousi->matter();

$result = Eiyousi::checkLogin();

if(!$result){
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:e_signup.php');
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

    <div class = 'mypage'><h2><?php echo htmlspecialchars($params['eiyousi']['name']); ?>さんのマイページ</h2></div>

    <div class = 'list'>
        <ul>
            <li><a href="e_post.php?id=<?=$login_user['id']?>">案件投稿</a></li>
            <li><a href="e_edit.php?id=<?=$login_user['id']?>">登録内容の修正</a></li>
            <li><a href="e_delete.php?id=<?php echo $login_user['id'] ?>"onclick="return confirm('削除しますか')">アカウントの消去</a></li>
        </ul>
    </div>
    
    <div class = 'syousai'>
        <table>
            <tr>
                <th>名前</th>
                <td><?php echo htmlspecialchars($params['eiyousi']['name']); ?></td>
            </tr>
            <tr>
                <th>フリガナ</th>
                <td><?php echo htmlspecialchars($params['eiyousi']['furigana']); ?></td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td><?php echo htmlspecialchars($params['eiyousi']['tell']); ?></td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td><?php echo htmlspecialchars($params['eiyousi']['mail']); ?></td>
            </tr>
        </table>
        <div class = "gazou"><img src="<?=$params['eiyousi']['file_path'] ?>"></div>
    </div>


    <div class = 'mypage1'><h2>投稿中の案件</h2></div>
    <div class = 'mypagehyou'>
        <table>
            <tr>
                <th>得意指導分野</th>
                <th>相談可能エリア</th>
                <th>日程</th>
                <th>料金</th>
                <th>自己ＰＲ</th>
            </tr>
            <?php foreach($params['item'] as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['specialty']); ?></td>
                    <td><?php echo htmlspecialchars($item['area']); ?></td>
                    <td><?php echo htmlspecialchars($item['possible_date']); ?></td>
                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                    <td><?php echo htmlspecialchars($item['self_pr']); ?></td>
                    <td><a href = "customer.php?id=<?=$item['id'] ?>">お客様情報</a></td>
                    <td><a href="item_delete.php?id=<?php echo $item['id'] ?>"onclick="return confirm('削除しますか')">案件を消去する</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </diV> 
        <form action="/mutual/logout.php" method="POST">
            <div class = 'logout'><input type="submit" name="logout" value="ログアウト"></div>
        </form>

</body>
</html>