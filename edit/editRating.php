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
if(isset($_POST['rating_number'])&&isset($_POST['rating_description'])&&isset($_POST['rating_id'])){
    global $conn;
    $token = $_POST['token'];
    $userID = getUserId($token);
    $rating =doubleval($_POST['rating_number']) ;
    $rating_id=intval($_POST['rating_id']);
    $rating_description = $_POST['rating_description'];
    if($userID==null){
        echo json_encode(array(
            'success'=>false,
            'message'=>'Token not valid'
        ));
        die(); 
    }

    $sql = "UPDATE `rating`
        
    SET `rating_number` = '$rating', `rating_description` = '$rating_description'
    WHERE `rating_id` = '$rating_id' AND `user_id` = $userID
    ";

    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Rating edited!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong while editing rating backend!".mysqli_error($conn)
            )
            );
}
}
?>