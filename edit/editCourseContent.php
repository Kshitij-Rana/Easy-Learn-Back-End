<?php
// include '../helpers/dbconnection.php';
// include '../helpers/authentication.php';

// if(isset($_POST['content_id'])&&isset($_POST['content_name']) && isset($_POST['content_description']) && isset($_POST['course_id']) && isset($_POST['content_video']) && isset($_POST['token'])&& isset($_POST['content_duration'])){
// $token = $_POST['token'];
// global $conn;
// $checkAdmin = isAdmin($token);
// if(!$checkAdmin){
//     echo json_encode(array(
//         'success'=>false,
//         'message' => 'You are not authorized',
//     ));
//     die();
// }
// $contentName = $_POST['content_name'];
// $contentDescription = $_POST['content_description'];
// $courseId = $_POST['course_id'];
// $contentVideo = $_POST['content_video'];
// $contentDuration= $_POST['content_duration'];
// $content_id = $_POST['content_id'];
// //change this
// $url = "UPDATE `course_content`
// SET `content_name` = '$contentName',
//     `content_description` = '$contentDescription',
//     `content_video` = '$contentVideo',
//     `content_duration` = '$contentDuration'
// WHERE `content_id` = '$content_id';
// ";
// $result = mysqli_query($conn,$url);
// if($result){
//     echo json_encode(
//         array(
//             "success" => true,
//             "message" => "Course content updated successfully!"
//         )
//     );
// }else{
//     echo json_encode(
//         array(
//             "success" => false,
//             "message" => "Something went wrong while adding course backend!".mysqli_error($conn)
//         )
//         );
// }
// }else{
//     echo json_encode(array(
//         'success'=>false,
//         'message' => 'Please fill all the fields'.mysqli_error($conn),
//     ));
// }
include '../helpers/dbconnection.php';
include '../helpers/authentication.php';

if(isset($_POST['content_id']) && isset($_POST['content_name']) && isset($_POST['content_description']) && isset($_POST['course_id']) && isset($_POST['token'])){
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
    $content_id = $_POST['content_id'];

   // Start building the SQL query
$url = "UPDATE `course_content` SET `content_name` = '$contentName', `content_description` = '$contentDescription'";

// Check if a new video URL is provided
if(isset($_POST['content_video']) && !empty($_POST['content_video'])){
    $contentDuration= $_POST['content_duration'];
    $contentVideo = $_POST['content_video'];
    $url .= ", `content_video` = '$contentVideo', `content_duration` = '$contentDuration'"; 
}

// Add the WHERE clause
$url .= " WHERE `content_id` = '$content_id'";

// Execute the query
$result = mysqli_query($conn, $url);

    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Course content updated successfully!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "url"=>$url,
                "message" => "Something went wrong while updating course content!".mysqli_error($conn)
            )
        );
    }
}else{
    echo json_encode(array(
        'success'=>false,
        'message' => 'Please fill all the required fields',
    ));
}
?>
