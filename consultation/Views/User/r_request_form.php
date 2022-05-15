<?php
session_start();

$err = $_SESSION;

$_SESSION = array();

if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
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
    <div class= 'midasi'><h2>登録されているメールアドレスを入力してください</h2></div>
    <?php if(isset($err_mes['meg'])):?>
        <p><?php echo htmlspecialchars($err_mes['msg']);?></p>
    <?php endif; ?>
    <form action="r_reset.php" method="post">
        <input type="hidden" name="_csrf_token" value="<?= $_SESSION['_csrf_token']; ?>">
        <dl>
            <dt><label for="name">メールアドレス</label><dt>
            <dd><input type="mail" name="mail" id="mail" placeholder="メールアドレス"></dd>
            <?php if(isset($err_mes['mail'])):?>
                <p><?php echo htmlspecialchars($err_mes['mail']);?></p>
                <?php endif; ?>
            </div>
        </dl>

        <div class= 'roginform'>
            <input type="submit" value="送信する">
        </div>
    </form>



    <div class= 'yoko'>
        <div class= 'signup2'>
            <a href= 'r_signup.php'>新規登録はコチラ</a>
        </div>

        <div class= 'signup3'>
            <a href= 'r_login_form.php'>ログインする方はコチラ</a>
        </div>
    </div>
    

</body>
</html>