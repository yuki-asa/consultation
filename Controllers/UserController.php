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
    

    public function user(){
        $create = $this->request['post'];
        $createuser =$this->User->user($create);
        $params =[
            'createuser' => $createuser,
        ];
        return $params;
    }

    public function r_edit() {
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        if($_POST) {
            require('../Views/mutual/validate.php');
            if (empty($err_name) && empty($err_furigana) && empty($err_tell) && empty($err_mail) && empty($err_file)){
                header("Location:r_mypage.php?id=".$_SESSION['login_user']['id']);
                $this ->User->update($this->request['get']['id']);
            }
        }

        $user = $this->User->requestFind($this->request['get']['id']);
        $params = [
            'user' => $user
        ];
        return $params;
    }

    public function r_delete(){
        if (empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }
        $this->User->r_delete($this->request['get']['id']);
        header('Location:/mutual/e_r_top.php');
    }


    public function usermatter(){
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }

        $user = $this->User->requestFind($this->request['get']['id']);
        $item = $this->User->reserveId($this->request['get']['id']);

        $params = [
            'user'=>$user,
            'item'=>$item,
        ];
        return $params;
    }

    public function cancelId(){
        if (empty($this->request['post']['item_id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }
        $this->User->canselflag($this->request['post']['id']);
        $this->User->cancelId($this->request['post']['item_id']);
        header('Location:r_mypage.php?id='.$_SESSION['login_user']['id']);
    }


    public function inform(){
        if(empty($this->request['get']['id'])) {
            echo '指定のパラメータが不正です。このページを表示できません。';
            exit;
        }
        $item = $this->Reserve->itemById($this->request['get']['id']);
        $params =[
            'item'=>$item
        ];
        return $params;
    }


    public function r_pass_reset(){
        $reset = $this->User->r_pass_reset();
    }

    public function r_findToken(){
        $reset = $this->User->r_findToken();
    }

    public function r_updatereset(){
        $reset = $this->User->r_updatereset();
    }


}


