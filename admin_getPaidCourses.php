<?php
include './helpers/dbconnection.php';
include './helpers/authentication.php';
global $conn;
if (!isset($_POST['token'])){
echo json_encode(
    array(
        "success" => false,
        "message"=> "Not token provided!"
    )
    );
    die;
}
$token = $_POST['token'];
$userId = intval(getUserId($token));
$sql = "SELECT orders.order_id, orders.total, orders.order_date, orders.status, order_details.line_total, courses.course_id, courses.course_name, courses.category_id, courses.price, courses.image, courses.is_online, u.full_name, u.email, u.address, u.profile_img FROM orders JOIN order_details ON order_details.order_id = orders.order_id JOIN courses ON courses.course_id = order_details.course_id JOIN users u ON u.user_id = orders.user_id;";
$result = mysqli_query($conn,$sql);
$paidCourses=[];
while($response = mysqli_fetch_assoc($result)){
    $paidCourses[] = $response;
}
if($result){
    echo json_encode(
        array(
            "success" => true,
            "message"=> "Paid courses fetched!",
            "data" => $paidCourses,
        )
        );
}else{
    echo json_encode(
        array(
            "success" => false,
            "message"=> "Something went wrong in sql!"
        )
        );
}