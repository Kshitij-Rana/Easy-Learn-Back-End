<?php
include 'helpers/authentication.php';
include 'helpers/dbconnection.php';

if(!isset($_POST['token'])){
echo json_encode (array(
    'success'=>false,
    'message'=>"You are not authorized"
));
die();
}
if(isset($_POST['fullName'])&& isset($_POST['email'])&& isset($_POST['address'])&& isset($_POST['bio'])&& isset($_FILES['image'])){
    global $conn;
    $token = $_POST['token'];
    $userId = getUserId($token);
    $fullname = $_POST['fullName'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $bio=$_POST['bio'];

    //for image
    $image = $_FILES['image']['name'];
    $image_temp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];

    if($image_size > 10000000){
        echo json_encode(
            array(
                "success" => false,
                "message" => "Image size must be less than 10MB!:$image_size"
            )
            );
            die();
    }
    $image_new_name = time().'_'.$image;
    $upload_path = 'images/'.$image_new_name;
if(!move_uploaded_file($image_temp_name,$upload_path)){
    echo json_encode(
        array(
            "success" => false,
            "message" => "Image upload failed"
        )
        );
        die();
}
    $sql = "UPDATE `users` SET `full_name`='$fullname',`email`='$email',`address`='$address',`bio`='$bio',`profile_img`='$upload_path' WHERE user_id = $userId";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Users data updated!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Users data update failed".mysqli_error($conn)
            )
        );
    }

}
else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "All data is not set!".mysqli_error($conn)
        )
    );
}

?>