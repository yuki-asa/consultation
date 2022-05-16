<?php
$err_possible_date = "";
$err_specialty= "";
$err_price= "";
$err_area= "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if(empty($_POST['possible_date'])) {
        $err_possible_date = '相談可能な日時を入力してください。';
    }
    if(empty($_POST['specialty'])) {
        $err_specialty = '得意分野を入力してください。';
    }
    if(empty($_POST['price'])) {
        $err_price = '料金を入力してください。';
    }
    if(empty($_POST['area'])) {
        $err_area = '相談可能なエリアを入力してください';
    }
    if($err_possible_date=="" && $err_specialty=="" && $err_price=="" && $err_area){
        header('Location:e_mypage.php');
    }
}
?>