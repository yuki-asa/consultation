<?php
require_once(ROOT_PATH. 'Controllers/UserController.php');
$user = new UserController();
$user->r_delete();




?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>削除完了</title>
  </head>
  <body>          
  <p>
      <a href="e_r_top.php">トップ画面へ戻る</a>
  </p> 
  </body>
</html>