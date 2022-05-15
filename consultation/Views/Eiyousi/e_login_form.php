<?php
session_start();
require_once(ROOT_PATH .'Models/Eiyousi.php');

$err = $_SESSION;

$_SESSION = array();
session_destroy();
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
    
        <div class='login'>
            <h1>栄養相談予約サイト</h1>
            <h2>栄養指導を予約したい方は</br>依頼者の方はコチラをクリック</h2>
        </div>
        <?php if(isset($err['meg'])):?>
            <p><?php echo $err['msg'];?></p>
        <?php endif; ?>
        <form action="e_login.php" method="post">
            <dl>
                <input type ="hidden" name="id" value = "id">
                <dt><label for="name">メールアドレス</label><dt>
                <dd><input type="mail" name="mail" id="mail" placeholder="メールアドレス"></dd>
                <?php if(isset($err['mail'])):?>
                    <p><?php echo htmlspecialchars($err['mail']);?></p>
                    <?php endif; ?>
                </div>

                <dt><label for="name">パスワード</label></dt>
                <dd><input type="password" name="password" id="password" placeholder="パスワード"></dd>
                <?php if(isset($err['password'])):?>
                    <p><?php echo htmlspecialchars($err['password']);?></p>
                <?php endif; ?>
            </dl>

            <div class= 'roginform'>
                <input type="submit" value="ログイン">
            </div>
        </form>
        <div class= 'signup1'>
            <a href= 'e_request_form.php'>パスワードを忘れた方はコチラ</a>
        </div>

        <div class= 'yoko'>
            <div class= 'signup2'>
                <a href= 'e_signup.php'>新規登録はコチラ</a>
            </div>

            <div class= 'signup3'>
                <a href= '/User/r_login_form.php'>依頼者の方はコチラ</a>
            </div>
        </div>
    

</body>
</html>