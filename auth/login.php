<?php
include('../helpers/dbconnection.php');
// if(isset($_POST['email'])&& isset($_POST['password'])){
//     global $conn;
//     $email = $_POST['email'];
//     $password = $_POST['password'];
    
//     $emailquery = "SELECT * FROM `users` WHERE email = '$email'";
//     $result = mysqli_query($conn,$emailquery);
//     $num = mysqli_num_rows($result);
//     if($num > 0){
//         $row =  mysqli_fetch_assoc($result);
//         $verify = password_verify($password,$row['password']);
//         if($verify == 1){
//             $accesstoken = bin2hex(openssl_random_pseudo_bytes(16));
//             $userId = $row['user_id'];
//             $role = $row['role'];
//             $inserttokensql = "INSERT INTO `personal_access_token`( `token`, `user_id`) VALUES ('$accesstoken','$userId')";
//             $result = mysqli_query($conn,$inserttokensql);
//             if ($result){
//                 echo json_encode(array(
//                     "success" => true,
//                     "token" => $accesstoken,
//                     "role" => $role,
//                     "message" => "Logged in"
//                 ));
//             }
//             else{
//                 echo json_encode(
//                     array(
//                         "success" => false,
//                         "message" => "Log in failed".mysqli_error($conn)
//                     )
//                     );
//             }
//         }
//         else{
//             echo json_encode(
//                 array(
//                     "success" => false,
//                     "message" => "Password is incorrect"
//                 )
//                 );
//         }
//     }
//     else{
//         echo json_encode(
//             array(
//                 "success" => false,
//                 "message" => "User info fetch failed".mysqli_error($conn),
//             )
//             );
//     }
// }
if(isset($_POST['email']) && isset($_POST['password'])){
    global $conn;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $emailquery = "select * from users where email = '$email'";
    $result = mysqli_query($conn,$emailquery);
    $num = mysqli_num_rows($result);
    if($num>0){
        $row = mysqli_fetch_assoc($result);
        $verify = password_verify($password,$row['password']);
        if($verify == 1){
            $accessToken = bin2hex(openssl_random_pseudo_bytes(16));
            $userId = $row['user_id'];
            $role = $row['role'];
            $inserttokensql = "INSERT INTO `personal_access_token`( `token`, `user_id`) VALUES ('$accessToken','$userId')";
            $result = mysqli_query($conn,$inserttokensql);
            if($result){
                echo json_encode(
                    array(
                        "success" => true,
                        "message" => "Logged in",
                        "role" =>$role,
                        "token" => $accessToken,
                        "user_id"=>$userId
                    )
                    );
            }else{
                echo json_encode(
                    array(
                        "success" => false,
                        "message" => "Log in failed".mysqli_error($conn)
                    )
                    );
            }

        }else{
            echo json_encode(
                array(
                    "success" => false,
                    "message" => "Email or password is incorrect"
                )
                );
        }
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Email or password is incorrect"
            )
            );
    }
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Email and password are not fetched"
        )
        );
}
?>