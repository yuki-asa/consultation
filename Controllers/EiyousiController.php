<?php
require_once(ROOT_PATH .'/Models/Favorite.php');
require_once(ROOT_PATH .'/Models/Reserve.php');
require_once(ROOT_PATH .'/Models/User.php');
require_once(ROOT_PATH .'/Models/Eiyousi.php');

class UserController{
    private $request; //リクエストパラメータ(GET,POST)
    private $Favorite;  //Favoriteモデル
    private $Reserve;    //Reserveモデル
    private $User;   //Userモデル
    private $Eiyousi; //Eiyousiモデル

    public function __construct() {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        

       // モデルオブジェクトの生成
       $this->Favorite = new Favorite();
       // 別モデルと連携
       $dbh = $this->Favorite->get_db_handler();
       $this->Reserve = new Reserve($dbh);
       $this->User = new UserLogic($dbh);
       $this->Eiyousi = new Eiyousi($dbh);
    }
    
    public function createUser() {
        $create = $this->request['post'];
        $createuser =$this->Eiyousi->createUser($create);
        $params =[
            'createuser' => $createuser,
        ];
        return $params;
    }

    public function e_edit() {
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        if($_POST) {
            require('../Views/mutual/validate.php');
            if (empty($err_name) && empty($err_furigana) && empty($err_tell) && empty($err_mail) && empty($err_file)){
                header("Location:e_mypage.php?id=".$_SESSION['login_user']['id']);
                $this ->Eiyousi->e_update($this->request['get']['id']);
            }
        }

        $eiyousi = $this->Eiyousi->eiyousiFind($this->request['get']['id']);
        $params = [
            'eiyousi' => $eiyousi
        ];
        return $params;
    }

    public function e_post() {
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        if($_POST) {
            require('../Views/Eiyousi/e_validate.php');
            if (empty($err_possible_date) && empty($err_specialty) && empty($err_price) && empty($err_area)){
                header('Location:e_mypage.php?id='.$_SESSION['login_user']['id']);
                $this ->Eiyousi->e_matter($this->request['get']['id']);
            }
        }
        $eiyousi = $this->Eiyousi->eiyousiFind($this->request['get']['id']);
        $params = [
            'eiyousi' => $eiyousi
        ];
        return $params;
    }

    public function e_delete(){
        if (empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }
        $this->Eiyousi->e_delete($this->request['get']['id']);
        header('Location:/mutual/e_r_top.php');
    }

    public function item_delete(){
        if (empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }
        $this->Eiyousi->item_delete($this->request['get']['id']);
        header('Location:e_mypage.php?id='.$_SESSION['login_user']['id']);
    }

    


    public function matter(){
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        $item = $this->Eiyousi->matterId($this->request['get']['id']);
        $eiyousi = $this->Eiyousi->eiyousifind($this->request['get']['id']);
        $params = [
            'item' => $item,
            'eiyousi'=>$eiyousi
        ];
        return $params;
    }

    public function customer(){
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }
        $customer = $this->Eiyousi->customerId($this->request['get']['id']);
        $params =[
            'customer'=>$customer
        ];
        return $params;
    }

    public function e_pass_reset(){
        $reset = $this->Eiyousi->e_pass_reset();
    }

    public function e_findToken(){
        $reset = $this->Eiyousi->e_findToken();
    }

    public function e_updatereset(){
        $reset = $this->Eiyousi->e_updatereset();
    }
    
}