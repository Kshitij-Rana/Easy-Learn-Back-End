<?php
include('./helpers/dbconnection.php');
include('./helpers/authentication.php');

if (!isset($_POST["token"])) {
    echo json_encode(array(
        'success' => false,
        'message' => 'Login to your account!'
    ));
    die();
}

$token = $_POST['token'];
$userId = getUserId($token);

if ($userId == null) {
    echo json_encode(array(
        'success' => false,
        'message' => 'No user with that token!'
    ));
    die();
}

if (isset($_POST['password']) && isset($_POST['new_password'])) {
    $password = $_POST['password'];
    $newPassword = $_POST['new_password'];

    if (strlen($newPassword) < 8) {
        echo json_encode(array(
            'success' => false,
            'message' => "Password must be at least 8 characters long!"
        ));
        die();
    }

    $searchQuery = "SELECT * FROM users WHERE user_id = $userId";
    $result = mysqli_query($conn, $searchQuery);
    $num = mysqli_num_rows($result);

    if ($num > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $hashPassword = password_hash($newPassword, PASSWORD_ARGON2ID);
            $updatePassSql = "UPDATE users SET `password` = '$hashPassword' WHERE user_id = '$userId'";
            $result = mysqli_query($conn, $updatePassSql);
            if ($result) {
                echo json_encode(array(
                    'success' => true,
                    'message' => "Password Changed!"
                ));
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => "Password change failed! " . mysqli_error($conn)
                ));
            }
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => "Incorrect password!"
            ));
        }
    } else {
        echo json_encode(array(
            'success' => false,
            'message' => "No user found with that token"
        ));
    }
} else {
    echo json_encode(array(
        'success' => false,
        'message' => 'Enter all required fields!'
    ));
}
?>
