<?php
include 'helpers/dbconnection.php';
if(isset($_POST['otp'])&&isset($_POST['email'])){
    global $conn;
    $otp = $_POST['otp'];
    $email = $_POST['email'];

    $sql = "SELECT  `otpExpiryDate` FROM `users` WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    if(!$result){
        echo json_encode(
            array(
                "success" => false,
                "message" => "Email query failed".mysqli_error($conn),
            )
            );
            die();
    }
    $row = mysqli_fetch_assoc($result);
    $expiryDate = $row['otpExpiryDate'];
    $date = date("Y-m-d H:i:s",time());
    if(!$date>$expiryDate){
        echo json_encode(
            array(
                "success" => false,
                "message" => "Email query failed".mysqli_error($conn),
            )
            );
            die();
    }

    $sql = "SELECT `user_id`, `full_name`, `otpExpiryDate` FROM `users` WHERE otp = '$otp'";
    $result = mysqli_query($conn,$sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        
        if ($row==null){
            echo json_encode(array(
                'success' => false,
                'message' => 'OTP entered  is incorrect!'.mysqli_error($conn),
            ));
        }else{
            $userId = $row['user_id'];

        echo json_encode(
            array(
                "success" => true,
                "message" => "OTP matched!",
                "userId" => $userId
            )
            );}

        
    }else{
        echo json_encode(array(
            'success' => false,
            'message' => 'OTP entered  is incorrect!'.mysqli_error($conn),
        ));
    }
}else{
    echo json_encode(array(
        'success' => false,
        'message' => 'No OTP found!'.mysqli_error($conn),
    ));
}
?>