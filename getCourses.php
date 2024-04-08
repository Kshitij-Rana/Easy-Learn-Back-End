<?php
include './helpers/dbconnection.php';
global $conn;
$sql = "SELECT 
c.course_id,
c.course_name,
c.category_id,
u.full_name,
c.user_id,
c.price,
c.image,
c.location,c.contact_no,
c.description,
c.is_online,
cat.category_name,
cc.number_of_contents,
cc.total_duration,
r.avg_rating
FROM 
courses c
JOIN 
users u ON u.user_id = c.user_id
JOIN 
category cat ON c.category_id = cat.category_id
LEFT JOIN 
(
    SELECT 
        course_id, 
        COUNT(content_id) AS number_of_contents, 
        SUM(content_duration) AS total_duration
    FROM 
        course_content
    GROUP BY 
        course_id
) cc ON c.course_id = cc.course_id
LEFT JOIN 
(
    SELECT 
        course_id, 
        AVG(rating_number) AS avg_rating
    FROM 
        rating
    GROUP BY 
        course_id
) r ON c.course_id = r.course_id
WHERE 
c.is_deleted = 0
";
$result = mysqli_query($conn,$sql);
$products = [];
while($response=mysqli_fetch_assoc($result)){
    
    $products[] = $response;
}
if ($result) {
    echo json_encode(
        array(
            "success" => true,
            "message" => "Products fetched successfully",
            "data" => $products
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
?>