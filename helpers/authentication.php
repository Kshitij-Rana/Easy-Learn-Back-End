<?php
function getUserId($token){
    global $conn;
    $sql = "SELECT * FROM `personal_access_token` WHERE token = '$token'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    
    if($num == 0){
        return null;

    }else{
        $row = mysqli_fetch_array($result);
        return $row["user_id"];

    }
}
// function isAdmin($token){
//     global $conn;
//     $userId = getUserId($token);
//     $sql = "SELECT 'role' from users where user_id = '$userId'";
//     $result = mysqli_query($conn,$sql);
//     if($result){
//         $row = mysqli_fetch_assoc($result);
//         if($row['role'] == 'admin'){
//             return true;
//         }else{
//             return false ;
//         }
        
//     }else{
//         return false;
//     }
// }
function isAdmin($token){
    $userId = getUserId($token);
    global $conn;
    if ($userId === null) {
        return false; // or handle this case differently based on your requirements
    }
    $sql = "Select * from users where user_id = '$userId'";
    $result = mysqli_query($conn,$sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        if ($row['role'] == 'admin'){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

?>