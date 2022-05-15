<?php
require_once(ROOT_PATH .'Controllers/ReserveController.php');

$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];

$favorite = new UserController;
$params = $favorite->favorite($user_id,$post_id);

?>
