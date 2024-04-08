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
if(isset($_POST['course_id']))
$token = $_POST['token'];
$course_id=intval($_POST['course_id']);
$userId = intval(getUserId($token));
$sql = "SELECT rating.*, users.full_name
FROM `rating`
INNER JOIN `users` ON rating.user_id = users.user_id
WHERE rating.user_id = '$userId' AND rating.course_id = '$course_id'
";

$result = mysqli_query($conn,$sql);
$ratings=[];
try {
    while($response = mysqli_fetch_assoc($result)){
        $ratings[] = $response;
    }} catch (\Throwable $th) {
echo("error");}

if($result){
    echo json_encode(
        array(
            "success" => true,
            "message"=> "Rating of user fetched!",
            "data" => $ratings,
        )
        );
}else{
    echo json_encode(
        array(
            "success" => false,
            "message"=> "Something went wrong in sql!"
        )
        );
}