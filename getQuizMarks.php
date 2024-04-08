<?php
include './helpers/dbconnection.php';
include './helpers/authentication.php';
global $conn;
if (!isset($_POST['token'])){
echo json_encode(
    array(
        "success" => false,
        "message"=> "Not token provided!"
    )
    );
    die;
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
$course_id = intval($_POST['course_id']);
$sql = "SELECT * FROM quiz_marks WHERE course_id = $course_id AND user_id = $userId";
$result = mysqli_query($conn,$sql);
$quizData=[];
try {
    while($response = mysqli_fetch_assoc($result)){
        $quizData[] = $response;
    }} catch (\Throwable $th) {
echo("error");}
if($result){
    echo json_encode(
        array(
            "success" => true,
            "message"=> "Quiz fetched!",
            "data" => $quizData,
        )
        );
}else{
    echo json_encode(
        array(
            "success" => false,
            "message"=> "Something went wrong in sql!".mysqli_error($conn)
        )
        );
}