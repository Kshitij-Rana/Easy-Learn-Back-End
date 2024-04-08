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
$checkAdmin = isAdmin($token);

$course_id = $_POST['course_id'];
$sql = "SELECT * FROM quizzes WHERE course_id = $course_id";
$result = mysqli_query($conn,$sql);
$quizzes=[];
try {
    while($response = mysqli_fetch_assoc($result)){
        $quizzes[] = $response;
    }} catch (\Throwable $th) {
echo("error");}

if($result){
    echo json_encode(
        array(
            "success" => true,
            "message"=> "Quiz fetched!",
            "data" => $quizzes,
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