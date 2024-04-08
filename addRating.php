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
if(isset($_POST['rating_number']) && isset($_POST['course_id'])&&isset($_POST['rating_description'])){
    global $conn;
    $token = $_POST['token'];
    $userID = getUserId($token);
    $rating = $_POST['rating_number'];
    $course_id = intval($_POST['course_id']);
    $rating_description = $_POST['rating_description'];
    $sql = "INSERT INTO `rating`( `user_id`,`course_id`, `rating_number`, `rating_description`) VALUES ('$userID','$course_id','$rating','$rating_description')";

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