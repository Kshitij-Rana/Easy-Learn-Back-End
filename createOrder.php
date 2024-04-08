<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';

if(!isset($_POST['token'])){
    echo json_encode(
        array(
            "success" => false,
            "message" => "You are not authorized"
        )
        );
        die();
}
if(!isset($_POST['cart'])&& $_POST['total']){
    echo json_encode(
        array(
            "success" =>  false,
            "message" => "Cart and total is required"

        )
        );
        die;
}
global $conn;
$token = $_POST['token'];
$total = $_POST['total'];
$cart= $_POST['cart'];

$userId = getUserId($token);
$sql = "INSERT INTO `orders`( `user_id`, `total`) VALUES ('$userId','$total')";
$result = mysqli_query($conn, $sql);
if($result){
    $orderId = mysqli_insert_id($conn);
    $cartList=json_decode($cart);
    foreach($cartList as $cartItem){
        $course = $cartItem->course->course_id;
        $price =$cartItem->course->price;

        $sql = "INSERT INTO `order_details`(`order_id`, `course_id`, `line_total`) VALUES ('$orderId','$course','$price')";
        $result = mysqli_query($conn, $sql);
         
    }
    echo json_encode(
        array(
            "success" => true,
            "message" => "Order created successfully!",
            "order_id"=>$orderId,
        )
        );
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Order Creation failed".mysqli_error($conn),
        )
        );
}

?>