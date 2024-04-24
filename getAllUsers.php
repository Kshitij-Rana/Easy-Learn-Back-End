<?php
include './helpers/authentication.php';
include './helpers/dbconnection.php';

if(isset($_POST['token'])){
global $conn;
$token = $_POST['token'];
$checkAdmin = isMainAdmin($token);
if(!$checkAdmin){
    echo json_encode(array(
        'success' => false,
        'message'=> 'You are not authorized'
    ));
    exit();
}
$sql = "SELECT `user_id`, `full_name`, `email`, `role`, `address`, `bio`, `otp`, `profile_img`,`isBlocked` FROM `users`";
$result = mysqli_query($conn,$sql);

// if($result){
//     $row = mysqli_fetch_assoc($result);
//     echo json_encode(
//         array(
//             "success" => true,
//             "message" => "Information fetched successfully",
//             "data" => $row
//         )
//         );
// }
if($result){
    $users=[];
    while($response=mysqli_fetch_assoc($result)){
        $users[] = $response;
    }
    echo json_encode(
        array(
            "success" =>true,
            "message" =>"Course content fetched",
            "data"=>$users
        )
        );
}
else{
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