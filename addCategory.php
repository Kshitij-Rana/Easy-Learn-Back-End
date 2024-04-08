<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';

if(isset($_POST['category_name'])&& isset($_POST['token'])&& isset($_POST['category_image'])){
    global $conn;
    $title = $_POST['category_name'];
    $category_image = $_POST['category_image'];
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
    $sql = "SELECT * from category where category_name = '$title'";
    $result = mysqli_query($conn, $sql);
     $num = mysqli_num_rows($result);
     if($num > 0){
        echo json_encode(array(
            "success"=> false,
            "message"=> "Title already exists! Choose another one."
        ));
        return;
     }else{
        $insertQuery = "INSERT INTO `category`( `category_name`,`category_image`) VALUES ('$title','$category_image')";
        $result = mysqli_query($conn,$insertQuery);
        if($result){
            echo json_encode(array(
                "success"=> true,
                "message"=> "Category added"
            ));
        }else{
            echo json_encode(array(
                'success' => false,
                'message'=> 'Something went wrong in query'
            ));
        }
     }
     

}else{
    echo json_encode(array(
        'success' => false,
        'message'=> 'category name or token not found'
    ));
}
?>