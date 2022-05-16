<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Eiyousi extends Db{
    private $table = 'eiyousi_matter';
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    public function createUser($userData) {
        $result = false;

        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];

        $upload_dir = '../images/';
        $save_filename = date('Ymd'). $filename;
        $save_path = $upload_dir.$save_filename;

        $this->dbh->beginTransaction();
        try{
            $sql = ' INSERT INTO eiyousi_matter (name, furigana, tell, mail,file_name,file_path,password) VALUES (:name, :furigana, :tell, :mail, :file_name,:file_path,:password) ';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':name', $userData['name'], PDO::PARAM_STR);
            $sth->bindParam(':furigana', $userData['furigana'], PDO::PARAM_STR);
            $sth->bindParam(':tell', $userData['tell'], PDO::PARAM_STR);
            $sth->bindParam(':mail', $userData['mail'], PDO::PARAM_STR);
            $sth->bindParam(':file_name', $save_filename, PDO::PARAM_STR);
            $sth->bindParam(':file_path', $save_path, PDO::PARAM_STR);
            $sth->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $password_hash = password_hash($userData['password'], PASSWORD_DEFAULT);
            $sth->execute();
            $this->dbh->commit();
        } catch (PDOException $e) {
            echo '接続失敗'. $e->getMessage();
            $dbh->rollBack();
        }
    }

    public static function login($email, $password){

        $result = false;

        $user = self::getUserByEmail($email);

        if(!$user){
            $_SESSION['msg'] = 'アドレスが一致しません。';
            return $result;
        }

        if(password_verify($password, $user['password'])){

            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;

        }

        $_SESSION['msg'] = 'パスワードがが一致しません。';
            return $result;
    }

    
    public static function getUserByEmail($email){

        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );

        $sql = ' SELECT * FROM eiyousi_matter WHERE mail = :mail';
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':mail', $email, PDO::PARAM_STR);

        try {
            $sth->execute();
            $user = $sth->fetch();
            return $user;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function password($email){
        $result = false;

        $user = self::getUserByEmail($email);

        if(!$user){
            $_SESSION['msg'] = 'アドレスが一致しません。';
            return $result;
        }
        $_SESSION['user'] = $user;
        return $_SESSION['user'];
    }
    

    public function e_pass_reset(){
        // 既にパスワードリセットのフロー中（もしくは有効期限切れ）かどうかを確認
        // $passwordResetUserが取れればフロー中、取れなければ新規のリクエストということ
        $sql = 'SELECT * FROM `eiyousi_matter` WHERE `mail` = :mail';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':mail', $_POST['mail'], \PDO::PARAM_STR);
        $sth->execute();
        $passwordResetUser = $sth->fetch(\PDO::FETCH_OBJ);

        if (!$passwordResetUser) {
            // $passwordResetUserがいなければ、仮登録としてテーブルにインサート
            $sql = 'INSERT INTO `eiyousi_matter`(`mail`, `token`,`token_sent_at`) VALUES(:mail, :token, :token_sent_at)';
        } else {
            // 既にフロー中の$passwordResetUserがいる場合、tokenの再発行と有効期限のリセットを行う
            $sql = 'UPDATE `eiyousi_matter` SET `token` = :token, `token_sent_at` = :token_sent_at WHERE `mail` = :mail';
        }
        // password reset token生成
        $passwordResetToken = bin2hex(random_bytes(32));

        // password_resetsテーブルへの変更とメール送信は原子性を保ちたいため、トランザクションを設置する
        // メール送信に失敗した場合は、パスワードリセット処理自体も失敗させる
        try {
            $this->dbh->beginTransaction();

            // ユーザーを仮登録
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':mail', $_POST['mail'], \PDO::PARAM_STR);
            $sth->bindValue(':token', $passwordResetToken, \PDO::PARAM_STR);
            $sth->bindValue(':token_sent_at', (new \DateTime())->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
            $sth->execute();
    
            mb_language("Japanese");
            mb_internal_encoding("UTF-8");

            // URLはご自身の環境に合わせてください
            $url = "http://localhost/Eiyousi/e_pass_reset_form.php?token={$passwordResetToken}";

            $subject =  'パスワードリセット用URLをお送りします';

            $body = <<<EOD
                24時間以内に下記URLへアクセスし、パスワードの変更を完了してください。
                {$url}
                EOD;

            // Fromはご自身の環境に合わせてください
            $headers = "From : yuki.042448@gmail.com\n";
            // text/htmlを指定し、html形式で送ることも可能
            $headers .= "Content-Type : text/plain";

            // mb_send_mailは成功したらtrue、失敗したらfalseを返す
            $isSent = mb_send_mail($_POST['mail'], $subject, $body, $headers);

            if (!$isSent) throw new \Exception('メール送信に失敗しました。');

            // メール送信まで成功したら、password_resetsテーブルへの変更を確定
            $this->dbh->commit();
        } catch (\Exception $e) {
            $this->dbh->rollBack();
            exit($e->getMessage());
            // 送信済み画面を表示
            require_once '../views/Eiyousi/e_reset.php';
        }
    }

    public function e_findToken(){
        $passwordResetToken = filter_input(INPUT_GET, 'token');

        // tokenに合致するユーザーを取得
        $sql = 'SELECT * FROM `eiyousi_matter` WHERE `token` = :token';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':token', $passwordResetToken, \PDO::PARAM_STR);
        $sth->execute();
        $passwordResetuser = $sth->fetch(\PDO::FETCH_OBJ);

        // 合致するユーザーがいなければ無効なトークンなので、処理を中断
        if (!$passwordResetuser) exit('無効なURLです');

        // 今回はtokenの有効期間を24時間とする
        $tokenValidPeriod = (new \DateTime())->modify("-24 hour")->format('Y-m-d H:i:s');

        // パスワードの変更リクエストが24時間以上前の場合、有効期限切れとする
        if ($passwordResetuser->token_sent_at < $tokenValidPeriod) {
            exit('有効期限切れです');
        }

        // formに埋め込むcsrf tokenの生成
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }

        // パスワードリセットフォームを読み込む
        require_once '../views/Eiyousi/e_pass_reset_form.php';
    }

    public function e_updatereset(){
        $request = filter_input_array(INPUT_POST);

        // csrf tokenが正しければOK
        if (
            empty($request['_csrf_token'])
            || empty($_SESSION['_csrf_token'])
            || $request['_csrf_token'] !== $_SESSION['_csrf_token']
        ) {
            exit('不正なリクエストです');
        }
        $sql = 'SELECT * FROM `eiyousi_matter` WHERE `token` = :token';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':token', $request['password_reset_token'], \PDO::PARAM_STR);
        $sth->execute();
        $passwordResetuser = $sth->fetch(\PDO::FETCH_OBJ);

        if (!$passwordResetuser) exit('無効なURLです');


        // テーブルに保存するパスワードをハッシュ化
        $hashedPassword = password_hash($request['password'], PASSWORD_BCRYPT);

        // usersテーブルとpassword_resetsテーブルの原子性を原始性を保証するため、トランザクションを設置
        try {
            $this->dbh->beginTransaction();

            // 該当ユーザーのパスワードを更新
            $sql = 'UPDATE `eiyousi_matter` SET `password` = :password WHERE `token` = :token';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':password', $hashedPassword, \PDO::PARAM_STR);
            $sth->bindValue(':token', $passwordResetuser->token, \PDO::PARAM_STR);
            $sth->execute();
            $this->dbh->commit();
        }catch (\Exception $e) {
            $this->dbh->rollBack();
        
            exit($e->getMessage());
        }
        echo 'パスワードの変更が完了しました。';
    
    }

    public static function checkLogin() {
        
        $result = false;
    
        if (isset($_SESSION['login_user']) && isset($_SESSION['login_user']['id']) > 0) {
            return $result = true;
        }

        return $result;
    }
    

    public function eiyousiFind($id = 0):Array{
        $sql = 'SELECT * FROM eiyousi_matter';    
        $sql .= ' WHERE eiyousi_matter.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function e_update($id = 0) {
        $result = false;

        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];

        $upload_dir = '../images/';
        $save_filename = $filename;
        $save_path = $upload_dir.$save_filename;
        
        $this->dbh->beginTransaction();
        try{
            $sql = ' UPDATE eiyousi_matter 
                    SET id = id, name = :name, furigana = :furigana, tell = :tell, mail = :mail, file_name = :file_name, file_path = :file_path
                    WHERE id = :id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            $sth->bindParam(':furigana', $_POST['furigana'], PDO::PARAM_STR);
            $sth->bindParam(':tell', $_POST['tell'], PDO::PARAM_STR);
            $sth->bindParam(':mail', $_POST['mail'], PDO::PARAM_STR);
            $sth->bindParam(':file_name', $save_filename, PDO::PARAM_STR);
            $sth->bindParam(':file_path', $save_path, PDO::PARAM_STR);
            $sth->execute();
            $this->dbh->commit();
        }catch(PDOExeption $e){
            echo '接続失敗'.$e->getMessage();
            $this->dbh->rollBack();
            exit;
        }
    }




    public function e_matter($id = 0) {
        $this->dbh->beginTransaction();
        try{
            $sql = ' INSERT INTO eiyousi_item(possible_date, specialty, price, area, self_pr,e_id) VALUES (:possible_date, :specialty, :price, :area, :self_pr,
                    (SELECT id FROM eiyousi_matter WHERE id=:e_id))';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':possible_date', $_POST['possible_date'], PDO::PARAM_STR);
            $sth->bindParam(':specialty', $_POST['specialty'], PDO::PARAM_STR);
            $sth->bindParam(':price', $_POST['price'], PDO::PARAM_STR);
            $sth->bindParam(':area', $_POST['area'], PDO::PARAM_STR);
            $sth->bindParam(':self_pr', $_POST['self_pr'], PDO::PARAM_STR);
            $sth->bindParam(':e_id', $id, PDO::PARAM_STR);
            $sth->execute();
            $this->dbh->commit();
        }catch(PDOExeption $e){
            echo '接続失敗'.$e->getMessage();
            $this->dbh->rollBack();
            exit;
        }
    }

    public function e_delete($id=0){
        $this->dbh->beginTransaction();
        try{
            $sql = 'DELETE FROM eiyousi_matter WHERE id=:id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            $sth->execute();
            $this->dbh->commit();
        }catch(PDOException $e){
            echo '接続に失敗しました。'.$e->getMessage();
            $this->dbh->rollBack();
            exit;
        }
    }

    public function item_delete($id=0){
        $this->dbh->beginTransaction();
        try{
            $sql = 'DELETE FROM eiyousi_item WHERE id=:id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':id',$id,PDO::PARAM_INT);
            $sth->execute();
            $this->dbh->commit();
        }catch(PDOException $e){
            echo '接続に失敗しました。'.$e->getMessage();
            $this->dbh->rollBack();
            exit;
        }
    }

    public function matterId($id=0){
        $sql = ' SELECT * FROM eiyousi_matter
                INNER JOIN eiyousi_item ON eiyousi_matter.id = eiyousi_item.e_id
                WHERE eiyousi_matter.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function customerId($id=0){
        $sql = ' SELECT * FROM eiyousi_item 
                LEFT JOIN reserve ON eiyousi_item.id = reserve.item_id
                LEFT JOIN request_matter ON reserve.r_id = request_matter.id
                WHERE eiyousi_item.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    } 



}

?>