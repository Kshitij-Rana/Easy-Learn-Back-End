<?php
// include 'helpers/dbconnection.php';
// include 'helpers/authentication.php';

// if(isset($_POST['course_name']) && isset($_POST['category_id']) && isset($_POST['price']) && $_FILES['image'] && $_POST['description'] && isset($_POST['is_online'])&& isset($_POST['token'])){
//     global $conn;

//     $token = $_POST['token'];
//     $checkAdmin = isAdmin($token);
//     if(!$checkAdmin){
//         echo json_encode(array(
//             'success' => false,
//             'message'=> 'You are not authorized'
//         ));

//     }
//     $userId = getUserId($token);
//         $course_name = $_POST['course_name'];
//         $course_price = $_POST['price'];
//         $course_description = $_POST['description'];
//         $category_id = $_POST['category_id'];
//         $isOnline = $_POST['is_online'];

//         $image = $_FILES['image']['name'];
//         $image_temp_name=$_FILES['image']['tmp_name'];
//         $image_size = $_FILES['image']['size'];

//         if($image_size > 5000000){
//             echo json_encode(
//                 array(
//                     "success" => false,
//                     "message" => "Image size must be less than 5MB!"
//                 )
//                 );
//                 die();
//     }
//     $image_new_name = time().'_'. $image;
//     $upload_path = 'images/'.$image_new_name;

//     if(!move_uploaded_file($image_temp_name,$upload_path)){
//         echo json_encode(
//             array(
//                 "success" => false,
//                 "message" => "Image upload failed"
//             )
//             );
//             die();
//     }
//     $sql = "INSERT INTO `courses`( `course_name`, `category_id`, `price`, `image`, `description`,`is_online`,`user_id`) VALUES ('$course_name','$category_id','$course_price','$upload_path','$course_description','$isOnline',$userId)";
//     $result = mysqli_query($conn,$sql);
//     if($result){
//         echo json_encode(
//             array(
//                 "success" => true,
//                 "message" => "Course added successfully!"
//             )
//         );
//     }else{
//         echo json_encode(
//             array(
//                 "success" => false,
//                 "message" => "Something went wrong".mysqli_error($conn)
//             )
//             );
//     }
// }else{
//     echo json_encode(
//         array(
//             "success" => false,
//             "message" => "Please fill all the fields",
//         )
//     );
// }

include 'helpers/dbconnection.php';
include 'helpers/authentication.php';

if(isset($_POST['course_name']) && isset($_POST['category_id']) && isset($_POST['price']) && isset($_POST['description']) && isset($_POST['is_online']) && isset($_POST['token']) && isset($_FILES['image'])) {
    global $conn;

    $token = $_POST['token'];
    $checkAdmin = isAdmin($token);
    if(!$checkAdmin){
        echo json_encode(array(
            'success' => false,
            'message'=> 'You are not authorized'
        ));
        exit();
    }
    $userId = getUserId($token);
    $course_name = $_POST['course_name'];
    $course_price = $_POST['price'];
    $course_description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $isOnline = $_POST['is_online'];

    $image = $_FILES['image']['name'];
    $image_temp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];

    if($image_size > 5000000){
        echo json_encode(
            array(
                "success" => false,
                "message" => "Image size must be less than 5MB!"
            )
        );
        exit();
    }
    $image_new_name = time().'_'. $image;
    $upload_path = 'images/'.$image_new_name;

    if(!move_uploaded_file($image_temp_name, $upload_path)){
        echo json_encode(
            array(
                "success" => false,
                "message" => "Image upload failed"
            )
        );
        exit();
    }

    // Check if is_online is 0 and add additional fields
    $additionalFields = "";
    if ($isOnline == '0') {
        $location = $_POST['location'];
        $contact_no = $_POST['contact_no'];
        $additionalFields = ", `location`, `contact_no`";
        $values = ",'$location','$contact_no'";
    }

    $sql = "INSERT INTO `courses`(`course_name`, `category_id`, `price`, `image`, `description`, `is_online`, `user_id` $additionalFields) VALUES ('$course_name','$category_id','$course_price','$upload_path','$course_description','$isOnline',$userId $values)";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Course added successfully!"
            )
        );
    } else {
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong".mysqli_error($conn)
            )
        );
    }
} else {
    echo json_encode(
        array(
            "success" => false,
            "message" => "Please fill all the fields",
        )
    );
}
?>
