<?php
include './helpers/dbconnection.php';
include './helpers/authentication.php';

if(!isset($_POST['token'])){
    echo json_encode(
        array(
            "success" => false,
            "message" => "You are not authorized."
        )
        );
        die();
}
$sql = "SELECT * from course_content WHERE `is_deleted`= 0";
$result = mysqli_query($conn,$sql);
if($result){
    $courseContents=[];
    while($response=mysqli_fetch_assoc($result)){
        $courseContents[] = $response;
    }
    echo json_encode(
        array(
            "success" =>true,
            "message" =>"Course content fetched",
            "data"=>$courseContents
        )
        );
}
?>