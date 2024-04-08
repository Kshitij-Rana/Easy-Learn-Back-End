<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';
if(isset($_POST['content_id']) && isset($_POST['token']) && isset($_POST['course_id'])) {
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
    $content_id = intval($_POST['content_id']);
    $course_id = $_POST['course_id'];
    // First, check if the course exists
    $checkSql = "SELECT * FROM `course_content` WHERE `content_id` = $content_id AND `course_id`=$course_id";
    $checkResult = mysqli_query($conn, $checkSql);

    // If no course is found, throw an error
    if (mysqli_num_rows($checkResult) == 0) {
        echo json_encode(array(
            'success'=>false,
            'message'=>"No content found with the provided Content ID!"
        ));
        exit(); // Stop further execution
    }
    // Use DELETE query instead of UPDATE
    $sql = "DELETE FROM `course_content` WHERE `content_id`=$content_id AND `course_id`=$course_id";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo json_encode(array(
            'success'=>true,
            'message'=>"Content Deleted!"
        )); 
    } else {
        echo json_encode(array(
            'success'=>false,
            'message'=>"Content deletion failed!".mysqli_error($conn)
        )); 
    }
} else {
    echo json_encode(array(
        'success' => false,
        'message'=> 'Course ID not found'
    ));    
}
?>
