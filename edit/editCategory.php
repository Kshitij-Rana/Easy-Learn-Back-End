<?php
include '../helpers/dbconnection.php';
include '../helpers/authentication.php';

if(isset($_POST['token'])&&isset($_POST['category_id'])&&isset($_POST['category_image'])&&isset($_POST['category_name'])){
global $conn;
$token = $_POST['token'];


$checkAdmin = isAdmin($token);
if(!$checkAdmin){
    echo json_encode(array(
        'success'=>false,
        'message' => 'You are not authorized',
    ));
    die();
}
$category_id = intval($_POST['category_id']);
$category_name= $_POST['category_name'];
$category_image = $_POST['category_image'];
$sql = "SELECT * from category where category_name = '$category_name'";
$result = mysqli_query($conn, $sql);
 $num = mysqli_num_rows($result);
 if($num > 0){
    echo json_encode(array(
        "success"=> false,
        "message"=> "Title already exists! Choose another one."
    ));
    return;
 }else{
$updateSql = "UPDATE category SET category_name = '$category_name',category_image= '$category_image' WHERE category_id = $category_id";
$result = mysqli_query($conn,$updateSql);
if($result){
    echo json_encode(array(
        'success'=>true,
        'message'=>"Category updated!"
    )); 
}else{
    echo json_encode(array(
        'success'=>false,
        'message'=>"Category update failed!".mysqli_error($conn)
    )); 
}
}}else{
    echo json_encode(array(
        'success'=>false,
        'message'=>"Data is not fetched!"
    ));
}
?>