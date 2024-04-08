<?php
include("../helpers/dbconnection.php");
if(isset($_POST['email']) && isset($_POST['full_name']) && isset($_POST['password']) && isset($_POST['role'])){
    global $conn;
    $email = $_POST['email'];

    $emailcheckSql="Select full_name from users where email = '$email'";
    $result = mysqli_query($conn,$emailcheckSql); 
    $num = mysqli_num_rows($result);
    if($num > 0){
        echo json_encode(array(
            "success" => false,
            "message" => "Email address already exists. Try new email."
        ));
        return;
    }else{
        $username = $_POST['full_name'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $insertQuery = "INSERT INTO `users`( `full_name`, `email`, `password`, `role`) VALUES ('$username','$email','$hashPassword','$role')";
        $result = mysqli_query($conn,$insertQuery);
        if($insertQuery){
            echo json_encode(
                array(
                    "message" =>"New account created",
                    "success"=> true,

                )
                );
        }else{
            echo json_encode(
                array(
                    "message"=>"Error",
                    "success"=> false
                )
                );
        }
    }
}
?>