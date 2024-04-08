<?php
include './helpers/dbconnection.php';
include'./helpers/authentication.php';
global $conn;
if(!isset($_POST["token"]) ){
    echo json_encode(array(
        'success'=>false,
        'message'=>'Login to your account'
    ));
    die();
}
$token=$_POST["token"];
if(getUserId($token)==null){
    echo json_encode(array(
        'success'=>false,
        'message'=>'No user with the given token'.$userID
    ));
    die();
}
$userID = intval(getUserId($token));

$sql= "SELECT * FROM `progress_tracking` WHERE `user_id` = '$userID'";

$result = mysqli_query($conn,$sql);
$products = [];
while($response=mysqli_fetch_assoc($result)){
    
    $products[] = $response;
}
if ($result) {
    echo json_encode(
        array(
            "success" => true,
            "message" => "Products fetched successfully",
            "data" => $products
        )
    );
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Something went wrong".mysqli_error($conn)
        )
    );
}
?>