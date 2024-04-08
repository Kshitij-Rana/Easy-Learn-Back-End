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
$sql = "SELECT 
orders.order_id, 
orders.total, 
orders.order_date, 
orders.status, 
order_details.line_total, 
courses.course_id, 
courses.course_name, 
courses.category_id, 
courses.price, 
courses.image, 
courses.is_online, 
courses.description, 
course_counts.number_of_courses, 
course_content_counts.number_of_contents, 
users.full_name 
FROM 
orders 
JOIN 
order_details ON order_details.order_id = orders.order_id 
JOIN 
courses ON courses.course_id = order_details.course_id 
LEFT JOIN 
(
    SELECT 
        order_id, 
        COUNT(course_id) AS number_of_courses 
    FROM 
        order_details 
    GROUP BY 
        order_id
) course_counts ON orders.order_id = course_counts.order_id 
LEFT JOIN 
(
    SELECT 
        course_id, 
        COUNT(content_id) AS number_of_contents 
    FROM 
        course_content 
    GROUP BY 
        course_id
) course_content_counts ON courses.course_id = course_content_counts.course_id 
JOIN 
users ON users.user_id = orders.user_id 
WHERE 
orders.user_id = $userId;
";
$result = mysqli_query($conn,$sql);
$paidCourses=[];
try {
    while($response = mysqli_fetch_assoc($result)){
        $paidCourses[] = $response;
    }} catch (\Throwable $th) {
echo("error");}

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
            "message"=> "Something went wrong in sql!".mysqli_error($conn)
        )
        );
}