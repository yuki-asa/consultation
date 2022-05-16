<?php
session_start();
require_once(ROOT_PATH. 'Controllers/ReserveController.php');
require_once(ROOT_PATH .'Models/User.php');
$reserve = new UserController();
$params = $reserve->index();


?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>栄養相談</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <link rel="stylesheet" type="text/css" href="/css/favorite.css">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
  <script type="text/javascript" src="/js/main.js"></script>
  <script>
  FontAwesomeConfig = { searchPseudoElements: true };
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.0.10/font-awesome-animation.css" type="text/css" media="all" />
</head>
<body>
    <div class= 'midasi'><h1>予約一覧</h1></div>
    <div class="kennsaku">
        <ul>
            <form method="get" action="">
                <li><input type ='date' id='possible_date'></li>
                <li><input type ='text' id='area' placeholder="希望のエリアを入力"></li>
                <li><input type="button" value="絞り込む" id="button"></li>
                <li><input type="button" value="すべて表示" id="button2"></li>
            </form>
        </ul>   
        <div class = 'hyou'>
            <table>
                <tr>
                    <th>得意指導分野</th>
                    <th>相談可能エリア</th>
                    <th>日程</th>
                    <th>料金</th>
                </tr>
                <?php foreach($params['reserve'] as $reserve): ?>
                    <tr class = "data">
                        <td><?php echo htmlspecialchars($reserve['specialty']); ?></td>
                        <td><?php echo htmlspecialchars($reserve['area']); ?></td>
                        <td><?php echo htmlspecialchars($reserve['possible_date']); ?></td>
                        <td><?php echo htmlspecialchars($reserve['price']); ?></td>
                        <td><a href = "detaile.php?id=<?=$reserve['id']?>">詳細</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
  <div class = 'paging'>
      <?php
        for($i=0; $i<=$params['pages'];$i++) {
          if(isset($_GET['page']) && $_GET['page'] == $i){
              echo $i+1;
            }else {
              echo "<a href= '?page=".$i."'>" .($i+1)."</a>";
            }
        }
      ?>
</div>

    
</body>
</html>
