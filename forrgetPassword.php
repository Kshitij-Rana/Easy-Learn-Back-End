<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

include './helpers/dbconnection.php';
if(isset($_POST['email'])){
    global $conn;
    $email = $_POST['email'];
    $sql = "Select email from users WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    $response = mysqli_num_rows($result);
    if($response>0){
        $otp = rand(1000,9999);
        $ExpiryDate = date("Y-m-d H:i:s", time() + (5 * 60)) ;
        $sql = "UPDATE `users` SET `otp`='$otp',`otpExpiryDate`='$ExpiryDate' WHERE email = '$email'";
        $result = mysqli_query($conn,$sql);
        if($result){
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ranakshitij32@gmail.com';
                $mail->Password = 'axqv dlji aifh drva';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('ranakshitij32@gmail.com','Kshitij Magar');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset OTP';
                $mail->Body    = "Your OTP is: $otp";
                $isSent=$mail->send();

                


            } catch (Exception $e) {
               echo  json_encode(array(
                    'success' => false,
                    'message' => 'Error sending OTP via email!:',
                ));
                //throw $th;
            }
            if($isSent){
                echo json_encode(array(
                    'success' => true,
                    'message' => 'OTP sent successfully!',

                ));
            }else{
                echo json_encode(array(
                    'success' => false,
                    'message' => 'OTP sent failed',
                ));
            }
        }
       
    }else{
        echo json_encode(array(
            'success'=> false,
            'message'=>"No email found".mysqli_error($conn)
        ));
    }
    
}
?>
