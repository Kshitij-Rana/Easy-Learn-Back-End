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
if(isset($_POST['progress_number']) && isset($_POST['lesson_id'])){
    global $conn;
    $token = $_POST['token'];
    $userID = intval(getUserId($token));
    $progress_number=$_POST['progress_number'];
    $lesson_id =intval( $_POST['lesson_id']);
    $lesson_check = "SELECT * FROM `progress_tracking` WHERE `lesson_id` = '$lesson_id' AND `user_id` = '$userID'";
    $result = mysqli_query($conn, $lesson_check);
     $num = mysqli_num_rows($result);
     if($num > 0){
        echo json_encode(array(
            "success"=> false,
            "message"=> "Progress already tracked."
        ));
        return;
     }
    $sql = "INSERT INTO `progress_tracking`(`progress_number`, `lesson_id`, `user_id`) VALUES ('$progress_number','$lesson_id','$userID')";

    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Rating added!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong while adding course backend!".mysqli_error($conn)
            )
            );
}
}
?>