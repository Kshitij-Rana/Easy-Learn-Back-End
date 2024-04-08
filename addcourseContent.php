<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';

if(isset($_POST['content_name']) && isset($_POST['content_description']) && isset($_POST['course_id']) && isset($_POST['content_video']) && isset($_POST['token'])&& isset($_POST['content_duration'])){
$token = $_POST['token'];
global $conn;
$checkAdmin = isAdmin($token);
if(!$checkAdmin){
    echo json_encode(array(
        'success'=>false,
        'message' => 'You are not authorized',
    ));
    die();
}
$contentName = $_POST['content_name'];
$contentDescription = $_POST['content_description'];
$courseId = $_POST['course_id'];
$contentVideo = $_POST['content_video'];
$contentDuration= $_POST['content_duration'];

$url = "INSERT INTO `course_content`( `content_name`, `content_description`, `course_id`, `content_video`, `content_duration`) VALUES('$contentName','$contentDescription','$courseId','$contentVideo','$contentDuration')";
$result = mysqli_query($conn,$url);
if($result){
    echo json_encode(
        array(
            "success" => true,
            "message" => "Course content added successfully!"
        )
    );
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Something went wrong while adding course backend!".mysqli_error($conn)
        )
        );
}
}else{
    echo json_encode(array(
        'success'=>false,
        'message' => 'Please fill all the fields'.mysqli_error($conn),
    ));
}
