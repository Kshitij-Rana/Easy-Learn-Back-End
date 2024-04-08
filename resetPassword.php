<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';
if(isset($_POST['new_password'])&& isset($_POST['userId'])){
    global $conn;
    $userId =$_POST['userId'];
    $newPassword = $_POST['new_password'];
    
    $newPasswordHash= password_hash($newPassword, PASSWORD_BCRYPT);
    $insertQuery = "UPDATE `users` SET `password`='$newPasswordHash' WHERE user_id = '$userId'";
    $result = mysqli_query($conn,$insertQuery);
    if($result){
        echo json_encode(array(
            "success" => true,
            "message" => "Password changed.".mysqli_error($conn),
            "userid"=> $userId
        ));
    }else{
        echo json_encode(array(
            "success" => false,
            "message" => "Password change failed."
        ));
    }
}else{
    echo json_encode(array(
        "success" => false,
        "message" => "No email or password."
    ));
}
?>