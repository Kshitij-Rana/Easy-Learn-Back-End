<?php
// include '../helpers/dbconnection.php';
// include '../helpers/authentication.php';

// if(isset($_POST['is_online'])&&isset($_POST['token'])&&isset($_POST['course_id'])&&isset($_FILES['image'])&&isset($_POST['course_name'])&&isset($_POST['price'])&&isset($_POST['description'])&&isset($_POST['category_id'])){
// global $conn;
// $token = $_POST['token'];


// $checkAdmin = isAdmin($token);
// if(!$checkAdmin){
//     echo json_encode(array(
//         'success'=>false,
//         'message' => 'You are not authorized',
//     ));
//     die();
// }
// $course_id = intval($_POST['course_id']);
// $course_name= $_POST['course_name'];
// $description = $_POST['description'];
// $categoryid = intval($_POST['category_id']);
// $price = intval($_POST['price']);
// $is_online = $_POST['is_online'];

// //FOR IMAGE
// $course_image = $_FILES['image']['name'];
// $image_temp_name = $_FILES['image']['tmp_name'];
// $image_size = $_FILES['image']['size'];
// if($image_size > 5000000){
//     echo json_encode(
//         array(
//             "success" => false,
//             "message" => "Image size must be less than 5MB!"
//         )
//         );
//         die();
// }
// $image_new_name = time().'_'. $course_image;
// // $image_new_name = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', $course_image);

// $upload_path = '../images/'.$image_new_name;
// $upload_path_in_database = 'images/'.$image_new_name;

// // $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/finalyearproject_api/images/' . $image_new_name;

// if(!move_uploaded_file($image_temp_name,$upload_path)){
//     echo json_encode(
//         array(
//             "success" => false,
//             "message" => "Image upload failed".$upload_path
//         )
//         );
//         die();
// }
// $additionalFields = "";
// if ($isOnline == '0') {
//     $location = $_POST['location'];
//     $contact_no = $_POST['contact_no'];
//     $additionalFields = ", `location`, `contact_no`";
//     $values = ",'$location','$contact_no'";
// }
// // $sql = "SELECT * from courses where course_name = '$course_name'";
// // $result = mysqli_query($conn, $sql);
// //  $num = mysqli_num_rows($result);
// //  if($num > 0){
// //     echo json_encode(array(
// //         "success"=> false,
// //         "message"=> "Title already exists! Choose another one."
// //     ));
// //     return;
// //  }else{
// $updateSql = "UPDATE courses SET `course_name` = '$course_name',`image` = '$upload_path_in_database',`price` = $price,`is_online`='$is_online',`category_id`='$categoryid',`description`='$description' WHERE course_id = '$course_id'";
// $result = mysqli_query($conn,$updateSql);
// if($result){
//     echo json_encode(array(
//         'success'=>true,
//         'message'=>"Course updated!".$upload_path
//     )); 
// }else{
//     echo json_encode(array(
//         'success'=>false,
//         'message'=>"Course update failed!".mysqli_error($conn)
//     )); 
// }
// }else{
//     echo json_encode(array(
//         'success'=>false,
//         'message'=>"Data is not fetched!"
//     ));
// }
include '../helpers/dbconnection.php';
include '../helpers/authentication.php';

if(isset($_POST['is_online'])&&isset($_POST['token'])&&isset($_POST['course_id'])&&isset($_FILES['image'])&&isset($_POST['course_name'])&&isset($_POST['price'])&&isset($_POST['description'])&&isset($_POST['category_id'])){
    global $conn;
    $token = $_POST['token'];

    $checkAdmin = isAdmin($token);
    if(!$checkAdmin){
        echo json_encode(array(
            'success'=>false,
            'message' => 'You are not authorized',
        ));
        die();
    }
    $course_id = intval($_POST['course_id']);
    $course_name= $_POST['course_name'];
    $description = $_POST['description'];
    $categoryid = intval($_POST['category_id']);
    $price = intval($_POST['price']);
    $is_online = $_POST['is_online'];

    //FOR IMAGE
    $course_image = $_FILES['image']['name'];
    $image_temp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    if($image_size > 5000000){
        echo json_encode(
            array(
                "success" => false,
                "message" => "Image size must be less than 5MB!"
            )
        );
        die();
    }
    $image_new_name = time().'_'. $course_image;
    $upload_path = '../images/'.$image_new_name;
    $upload_path_in_database = 'images/'.$image_new_name;

    if(!move_uploaded_file($image_temp_name,$upload_path)){
        echo json_encode(
            array(
                "success" => false,
                "message" => "Image upload failed".$upload_path
            )
        );
        die();
    }

    // Prepare the SQL query
    $updateSql = "UPDATE courses SET `course_name` = '$course_name',`image` = '$upload_path_in_database',`price` = $price,`is_online`='$is_online',`category_id`='$categoryid',`description`='$description'";

    // Check if is_online is 0 and add additional fields
    if ($is_online == '0') {
        $location = $_POST['location'];
        $contact_no = $_POST['contact_no'];
        $updateSql .= ", `location` = '$location', `contact_no` = '$contact_no'";
    }

    $updateSql .= " WHERE course_id = '$course_id'";

    $result = mysqli_query($conn,$updateSql);
    if($result){
        echo json_encode(array(
            'success'=>true,
            'message'=>"Course updated!"
        )); 
    }else{
        echo json_encode(array(
            'success'=>false,
            'message'=>"Course update failed!".mysqli_error($conn)
        )); 
    }
}else{
    echo json_encode(array(
        'success'=>false,
        'message'=>"Data is not fetched!".mysqli_error($conn)
    ));
}
?>

