<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';
if(isset($_POST['course_id'])&& isset($_POST['token']) ){
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
    $course_id = intval($_POST['course_id']);
    // First, check if the course exists
    $checkSql = "SELECT * FROM `courses` WHERE `course_id` = $course_id";
    $checkResult = mysqli_query($conn, $checkSql);

    // If no course is found, throw an error
    if (mysqli_num_rows($checkResult) == 0) {
    echo json_encode(array(
        'success'=>false,
        'message'=>"No course found with the provided course ID!"
    ));
    exit(); // Stop further execution
    }
    $sql = "UPDATE `courses` SET `is_deleted` = 1 WHERE `course_id`=$course_id";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo json_encode(array(
            'success'=>true,
            'message'=>"Course Deleted!"
        )); 
    }else{
        echo json_encode(array(
            'success'=>false,
            'message'=>"Course deletion failed!".mysqli_error($conn)
        )); 
    }

}else{
    echo json_encode(array(
        'success' => false,
        'message'=> 'Course ID not found'
    ));   
}
?>