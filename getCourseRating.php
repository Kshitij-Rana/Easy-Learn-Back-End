<?php
include './helpers/dbconnection.php';
include './helpers/authentication.php';

global $conn;
if(!isset($_POST['token'])){
    echo json_encode(
        array(
            "success" => false,
            "message" => "You are not authorized."
        )
        );
        die();
}
if(!isset($_POST['course_id'])){
    echo json_encode(
        array(
            "success" => false,
            "message" => "Provide courseId."
        )
        );
        die();
}
$token= $_POST['token'];
$courseId = $_POST['course_id'];
$sql = "SELECT rating.*, users.full_name
FROM `rating`
INNER JOIN `users` ON rating.user_id = users.user_id
WHERE rating.course_id = '$courseId'";

$result = mysqli_query($conn,$sql);
$rating = [];
if($result){
    while($response = mysqli_fetch_assoc($result)){
        $rating[] = $response;
    }
    if ($result) {
        echo json_encode(
            array(
                "success" => true,
                "message" => "Rating fetched successfully",
                "data" => $rating
            )
        );
    } else {
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong"
            )
        );
    }
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Something went wrong".mysqli_error($conn)
        )
    );
}

?>