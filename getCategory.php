<?php
include './helpers/dbconnection.php';
global $conn;
$sql = "SELECT * from category where `is_deleted`= 0";
$result = mysqli_query($conn,$sql);
$category = [];
if($result){
    while($response = mysqli_fetch_assoc($result)){
        $category[] = $response;
    }
    if ($result) {
        echo json_encode(
            array(
                "success" => true,
                "message" => "Category fetched successfully",
                "data" => $category
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