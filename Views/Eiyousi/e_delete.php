<?php
require_once(ROOT_PATH. 'Controllers/EiyousiController.php');
$eiyousi = new UserController(); 
$eiyousi->e_delete();




?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>削除完了</title>
  </head>
  <body>          
  <p>
      <a href="e_r_top.php">トップへ戻る</a>
  </p> 
  </body>
</html>