<?php
include '../helpers/dbconnection.php';
include '../helpers/authentication.php';
if(!isset($_POST["token"]) ){
    echo json_encode(array(
        'success'=>false,
        'message'=>'Login to your account'
    ));
    die();
}
$token = $_POST["token"];
$checkAdmin = isMainAdmin($token);
if(!$checkAdmin){
    echo json_encode(array(
        'success' => false,
        'message'=> 'You are not authorized'
    ));
    exit();
}

if(isset($_POST['isBlocked'])&& isset($_POST['userID'])){
    global $conn;
    $isBlocked = $_POST['isBlocked'];
    $userID = intval($_POST['userID']);
    
if($isBlocked=='0'){
    $sql = "UPDATE `users` SET `isBlocked` = '1'where `user_id` = $userID";
}else if($isBlocked=='1'){
    $sql = "UPDATE `users` SET `isBlocked` = '0'where `user_id` = $userID";
}
    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Success!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong while blocking user backend!".mysqli_error($conn)
            )
            );
}
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Input all fields!"
        )
        );
}
?>