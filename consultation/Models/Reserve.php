<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Reserve extends Db{
    private $table = 'eiyousi_item';
    public function __construct($dbh = null){
        parent::__construct($dbh);
    }

    /** 
    * @param integer $page ページ番号
    * @return Array $result 予約一覧 (8件ごと)
    */
    public function find($page = 0):Array{
        $sql = 'SELECT * FROM eiyousi_item
                WHERE del_flg = 0';
        $sql .= ' LIMIT 20 OFFSET '.(8 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function countAll():Int{
        $sql = 'SELECT count(*) as count FROM eiyousi_item';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }

    public function findById($id=0):Array{
        $sql = 'SELECT * FROM eiyousi_item
                WHERE id =:id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }    


    public function itemById($id = 0):Array {
        $sql = 'SELECT * FROM eiyousi_item
                LEFT JOIN reserve ON eiyousi_item.id = reserve.item_id
                LEFT JOIN eiyousi_matter ON eiyousi_item.e_id = eiyousi_matter.id';
        $sql .= ' WHERE eiyousi_item.id = :id';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }    

    public function reserveId($id=0){
        $this->dbh->beginTransaction();
        try{
            $sql = ' INSERT INTO reserve(item_id,r_id) SELECT eiyousi_item.id, request_matter.id
                    FROM eiyousi_item, request_matter WHERE eiyousi_item.id=:e_id AND request_matter.id =:r_id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':e_id', $_POST['e_id'], PDO::PARAM_INT);
            $sth->bindParam(':r_id', $_POST['r_id'], PDO::PARAM_INT);
            $sth->execute();
            $this->dbh->commit();
        }catch(PDOExeption $e){
            echo '接続失敗'.$e->getMessage();
            $this->dbh->rollBack();
            exit;
        }
    }

    public function delflag(){
        $this->dbh->beginTransaction();
        try{
            $sql = ' UPDATE eiyousi_item SET del_flg = 1 WHERE id=:id';
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $_POST['e_id'], PDO::PARAM_INT);
            $sth->execute();
            $this->dbh->commit();
        }catch(PDOExeption $e){
            echo '接続失敗'.$e->getMessage();
            $this->dbh->rollBack();

        }
    }


}

?>



