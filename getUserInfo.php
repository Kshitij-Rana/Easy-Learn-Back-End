<?php
include './helpers/authentication.php';
include './helpers/dbconnection.php';

if(isset($_POST['token'])){
global $conn;
$token = $_POST['token'];
$userId = getUserId($token);

$sql = "SELECT `full_name`, `email`, `role`, `address`, `bio`, `otp`, `profile_img` FROM `users` WHERE `user_id`=$userId";
$result = mysqli_query($conn,$sql);

if($result){
    $row = mysqli_fetch_assoc($result);
    echo json_encode(
        array(
            "success" => true,
            "message" => "Information fetched successfully",
            "data" => $row
        )
        );
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Information fetched failed".mysqli_error($conn)
        )
        );
}
    
}
else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "You are not authorized".mysqli_error($conn)
        )
        );
}
?>