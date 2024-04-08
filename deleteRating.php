<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';
if(!isset($_POST["token"]) ){
    echo json_encode(array(
        'success'=>false,
        'message'=>'Login to your account'
    ));
    die();
}
if(isset($_POST['rating_id'])){
    global $conn;
    $token = $_POST['token'];
    $rating_id=intval($_POST['rating_id']);
    $userID = getUserId($token);

    if($userID==null){
        echo json_encode(array(
            'success'=>false,
            'message'=>'Token not valid'
        ));
        die(); 
    }

    $sql = "DELETE FROM `rating`
    WHERE `rating_id` = '$rating_id' AND `user_id` = $userID";

    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Rating deleted!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong while deleting rating backend!".mysqli_error($conn)
            )
            );
}
}
?>