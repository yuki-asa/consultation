<?php
session_start();

require_once(ROOT_PATH. 'Controllers/ReserveController.php');
$item = new UserController();
$params = $item->view();

if(!isset($_SESSION)) {
    session_start();
}

  
$post_id=$params['reserve']['id'];
  
$result = UserLogic::checkLogin();
  
$login_user = $_SESSION['login_user'];

$user_id = $_SESSION['login_user']['id'];


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
    <div class= 'midasi'><h1>栄養士の詳細</h1></div>
    <form action="detaile_confirm.php" method= "post">
        <div class = 'syousai'>
            <table>
                <input type="hidden" name ="e_id" value ="<?=$params['reserve']['id'] ?>">
                <input type="hidden" name ="item_id" value ="<?=$params['item']['id'] ?>">
                <tr>
                    <th>名前</th>
                    <td><?php echo htmlspecialchars($params['item']['name']); ?></td>
                </tr>
                <tr>
                    <th>フリガナ</th>
                    <td><?php echo htmlspecialchars($params['item']['furigana']); ?></td>
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
                    <td><?php echo htmlspecialchars($params['item']['self_pr']);?></td>
                </tr>
            </table>
        </div>
            <input type="hidden" name="mail" value="<?=$params['item']['mail'] ?>">
        <div class = 'kakutei'>
            <button><input type="hidden" name = "r_id" value="<?=$login_user['id']?>">予約を確定する</button>
        <div>
    </form>
    <div class = 'modoru'>
        <a href = 'reserve.php'>予約一覧に戻る</a>
    </div>

        <div class="like_btn <?php if($user_id)echo 'active';?>">
          <!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
          <i class="fa-solid fa-thumbs-up
            <?php if($user_id){ //いいね押したらハートが塗りつぶされる
              echo 'active far';
            }else{ //いいねを取り消したらハートのスタイルが取り消される
              echo ' active fas';
            }; ?>"></i>
        </div>
        
<script>
  var user_id = <?php echo $user_id; ?>;
  var post_id = <?php echo $post_id; ?>;

  $(document).on('click','.like_btn',function(e){
    e.stopPropagation();
    var $this = $(this);

    $.ajax({
      type: 'POST',
      url: 'favorite.php',
      dataType: 'script',
      data: { user_id: user_id,
              post_id: post_id}
        }).done(function(data){
        console.log(data);

        $this.children('i').toggleClass('fas'); //空洞ハート
        // いいね押した時のスタイル
        $this.children('i').toggleClass('far'); //塗りつぶしハート
        })
  });
</script>
</body>
</html>
