<?php
session_start();

require_once(ROOT_PATH. 'Controllers/EiyousiController.php');
require_once(ROOT_PATH. 'Views/Eiyousi/e_validate.php');
$eiyousi = new UserController();
$params = $eiyousi->e_post();

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
  <div class ='touroku'>
    <h2>■アカウント情報編集</h2>
    <form action="e_post.php?id=<?= $params['eiyousi']['id'] ?>" method="POST">
      <dl>
        <dt>
          <label for="name">名前</label>
        </dt>
        <dd>
          <input readonly type='text' name='name' value='<?php echo htmlspecialchars($params['eiyousi']['name']); ?>'>

        </dd>

        <dt>
          <label for="furigana">ふりがな</label>
        </dt>
        <dd>
          <input readonly type='text' name='furigana' value='<?php echo htmlspecialchars($params['eiyousi']['furigana']); ?>'>
        </dd>

        <dt>
          <label for="tell">電話番号</label>
        </dt>
        <dd>
          <input readonly type='text' name='tell' value='<?php echo htmlspecialchars($params['eiyousi']['tell']); ?>'>
        </dd>

        <dt>
          <label for="mail">メールアドレス</label>
        </dt>
        <dd>
          <input readonly type='text' name='mail' value='<?php echo htmlspecialchars($params['eiyousi']['mail']); ?>'>
        </dd>

        <dt>
          <label for="possible_date">日時</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='datetime-local' name='possible_date' id="possible_date">
          <dd><p><?php echo htmlspecialchars($err_possible_date); ?></p></dd>
        </dd>

        <dt>
          <label for="specialty">得意分野</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='text' name='specialty' id="sqecialty" placeholder="例)ダイエット">
          <dd><p><?php echo htmlspecialchars($err_specialty); ?></p></dd>
        </dd>

        <dt>
          <label for="price">料金</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='text' name='price' id="price" placeholder="例)30分1500円">
          <dd><p><?php echo htmlspecialchars($err_price); ?></p></dd>
        </dd>

        <dt>
          <label for="area">相談可能エリア</label><span class="required">必須</span>
        </dt>
        <dd>
          <input type='text' name='area' id="area" placeholder="例)東京">
          <dd><p><?php echo htmlspecialchars($err_area); ?></p></dd>
        </dd>

        <dt>
          <label for="self_pr">自己PR</label>
        </dt>
        <dd>
          <textarea name="self_pr" id="self_pr" placeholder="例)指導歴5年。1か月で2kgの減量を成功させました。"></textarea>
        </dd>

      </dl>
      <p><button type="submit" onclick="return confirm('投稿しますか？')">案件を投稿する</button></p>
    </form>
  </div>
  <div class = 'modoru'><a href="e_mypage.php?id=<?= $params['eiyousi']['id'] ?>">マイページへ戻る</a></div>
</body>
</html>