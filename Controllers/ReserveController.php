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

    public function index() {
        $page = 0;
        if(isset($this->request['get']['page'])){
            $page = $this->request['get']['page'];
        }

        $reserve = $this->Reserve->find($page);
        $reserve_count = $this->Reserve->countAll();
        $params = [
            'reserve' => $reserve,
            'pages' => $reserve_count /8,
        ];
        return $params;
    }
    
    public function view(){
        if(empty($this->request['get']['id'])){
            echo '指定のパラメータが不正です。このページは表示できません。';
            exit;
        }
        $reserve = $this->Reserve->findById($this->request['get']['id']);
        $item = $this->Reserve->itemById($this->request['get']['id']);
        $confirm = $this->Reserve->reserveId($this->request['post']);
        $delflag = $this->Reserve->delflag($this->request['post']);
        $params = [
            'reserve'=>$reserve,
            'item' => $item,
            'confirm' => $confirm,
            'delflag' => $delflag
        ];
        return $params;
    }

    public function reserve(){
        $reserve = $this->request['post'];
        $reserveitem = $this->Reserve->reserveId($reserve);
        $delflag = $this->Reserve->delflag($this->request['post']);
        $params = [
            'reserveitem' => $reserveitem,
            'delflag'=>$delflag
        ];
        return $params;

    }
    
    public function favorite($user_id, $post_id) {
        $favorite = $this->Favorite->check_favorite($user_id, $post_id);
        
        if(!$favorite){
            $new_favorite = $this->Favorite->new_favorite($user_id, $post_id);
        }else{
            $delete_favorite = $this->Favorite->delete_favorite($user_id, $post_id);
        }
    }
    

}