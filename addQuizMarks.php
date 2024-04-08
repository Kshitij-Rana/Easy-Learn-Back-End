<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';
if(!isset($_POST["token"]) ){
    echo json_encode(array(
        'success'=>false,
        'message'=>'Login to your account!'
    ));
    die();
}
$token = $_POST['token'];
$userId = getUserId($token);
if($userId==null){
    echo json_encode(array(
        'success'=>false,
        'message'=>'No user with that token!'
    ));
    die();
}

if(isset($_POST['course_id']) && isset($_POST['obtained_marks'])&&isset($_POST['full_marks'])){
    global $conn;
    $course_id = intval($_POST['course_id']);
   $obtained_marks = intval($_POST['obtained_marks']);
   $full_marks=intval($_POST['full_marks']);
   $checkSql = "SELECT * from quiz_marks where user_id=$userId AND course_id=$course_id";
   $result = mysqli_query($conn,$checkSql);
   $num = mysqli_num_rows($result);

   if($num > 0){
    echo json_encode(array(
        "success"=> false,
        "message"=> "Already quiz given! Choose another one."
    ));
    return;
 }else{
    $sql = "INSERT INTO `quiz_marks`( `course_id`,`obtainedMarks`, `fullMarks`, `user_id`)  VALUES ('$course_id','$obtained_marks','$full_marks','$userId')";

    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => " Marks added!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong while adding quiz marks backend!".mysqli_error($conn)
            )
        );
    }
 }
   
}
?>