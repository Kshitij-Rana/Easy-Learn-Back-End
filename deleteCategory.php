<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';
if(isset($_POST['category_id'])&& isset($_POST['token']) ){
    global $conn;
    $token = $_POST['token'];
    $checkAdmin = isAdmin($token);
    if(!$checkAdmin){
        echo json_encode(array(
            'success' => false,
            'message'=> 'You are not authorized',
            'admin'=> $checkAdmin

        ));
        die();
    }
    $category_id = intval($_POST['category_id']);
    $sql = "UPDATE `category` SET `is_deleted` = 1 WHERE `category_id`=$category_id";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo json_encode(array(
            'success'=>true,
            'message'=>"Category Deleted!"
        )); 
    }else{
        echo json_encode(array(
            'success'=>false,
            'message'=>"Category deletion failed!".mysqli_error($conn)
        )); 
    }

}else{
    echo json_encode(array(
        'success' => false,
        'message'=> 'category ID not found'
    ));   
}
?>