<?php
include 'helpers/authentication.php';
include 'helpers/dbconnection.php';

if(!isset($_POST['token'])){
    echo json_encode(array(
        'success'=>false,
        'message'=>'Invalid token'
    ));
    die();
}
if(!isset($_POST['order_id'])&& isset($_POST['amount']) && isset($_POST['other_data'])){
echo json_encode(array(
    'success'=>false,
    'message'=>'Order ID, amount , other data is not provided',
));
}
global $conn;
$token = $_POST['token'];
$orderId = $_POST['order_id'];
$amount = $_POST['amount'];
$otherData = $_POST['other_data'];
$userId = getUserId($token);

$sql = "INSERT INTO `paymentS`( `user_id`, `order_id`, `amount`, `other_data`) VALUES ('$userId','$orderId','$amount','$otherData')";
$result = mysqli_query($conn, $sql);
if($result){
$updateordertopaidSQL = "UPDATE orders set status = 'paid' where order_id = '$orderId'";
$result = mysqli_query($conn,$updateordertopaidSQL);
if($result)
{
    echo json_encode(
        array(
            "success" => true,
            "message" => "Orders updated!"
        )
        );
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Orders update failed!"
        )
        );
}
}else{
    echo json_encode(
        array(
            "success" => false,
            "message" => "Payment garda failed".mysqli_error($conn)
        )
        );
}
?>