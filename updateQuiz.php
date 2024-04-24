<?php
include 'helpers/dbconnection.php';
include 'helpers/authentication.php';
if(!isset($_POST["token"]) ){
    echo json_encode(array(
        'success'=>false,
        'message'=>'Login to your account'
    ));
    die();
}
$token = $_POST['token'];
$checkAdmin = isAdmin($token);
if(!$checkAdmin){
    echo json_encode(array(
        'success' => false,
        'message'=> 'You are not authorized'
    ));
    exit();
}
if(isset($_POST['quiz_id']) && isset($_POST['question_text'])&&isset($_POST['correct_option'])&&isset($_POST['option1'])&&isset($_POST['option2'])&&isset($_POST['option3'])&&isset($_POST['option4'])){
    global $conn;
    $quizId = intval($_POST['quiz_id']);
    $question = $_POST['question_text'];
    $correctOption = $_POST['correct_option'];
    $option1 = $_POST['option1'];
    $option2  = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $sql = "UPDATE `quizzes`
    SET `question_text` = '$question',
        `correct_option` = '$correctOption',
        `option1` = '$option1',
        `option2` = '$option2',
        `option3` = '$option3',
        `option4` = '$option4'
    WHERE `quiz_id` = '$quizId';
    ";

    $result = mysqli_query($conn,$sql);
    if($result){
        echo json_encode(
            array(
                "success" => true,
                "message" => "Rating added!"
            )
        );
    }else{
        echo json_encode(
            array(
                "success" => false,
                "message" => "Something went wrong while adding course backend!".mysqli_error($conn)
            )
            );
}
}
?>