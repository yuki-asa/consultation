<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Favorite extends Db{
    private $table = 'favorite';
    public function __construct($dbh = null){
        parent::__construct($dbh);
    }

    public function check_favorite($user_id, $post_id){
        $result = false;
        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );
    
        try{
            $sql = ' SELECT * FROM favorite WHERE user_id = :user_id AND post_id = :post_id';
            $sth = $dbh->prepare($sql);
            $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $sth->execute();
            $favorite = $sth->fetch();
            if(!empty($favorite)) {
                $result = true;
            }
            return $result;
        }catch(PDOException $e) {
            echo "接続失敗".$e->getMessage();
            $this->dbh->rollBack();
            exit();
        }
    }
    

    
    public function delete_favorite($user_id, $post_id){
        $result = false;
        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );

        try{
            $sql = ' DELETE FROM favorite WHERE :user_id = user_id AND :post_id = post_id';
            $sth = $dbh->prepare($sql);
            $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $sth->execute();
            return $result;
        }catch(PDOException $e) {
            echo "接続失敗".$e->getMessage();
            $this->dbh->rollBack();
            exit();
        }
    }


    public function new_favorite($user_id, $post_id){
        $result = false;
        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );
    
        try{
            $sql = ' INSERT INTO favorite ( post_id, user_id ) VALUE ( :post_id, :user_id )';
            $sth = $dbh->prepare($sql);
            $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
            $sth->execute();
            return $result;
        }catch(PDOException $e) {
            echo "接続失敗".$e->getMessage();
            $this->dbh->rollBack();
            exit();
        }
    }

}
