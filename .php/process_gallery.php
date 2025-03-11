<?php

include("config.php");

//kết nối với sql
$sql = "select * from gallery";
$result = $conn->query($sql);

//xử lý kết nối
if (!$result) {
    echo "kết nối thất bại ". $conn->error;
}

//xử lý code phần gallery
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="team-item">';
        echo '<div class="position-relative overflow-hidden">';
        echo '    <img class="img-fluid w-100" src="'. htmlspecialchars($row["image_path"]).'" alt="">';
        echo '     <div class="team-overlay">';
        echo '    </div>';
        echo ' </div>';
        echo ' <div class="bg-light text-center p-4">';
        echo '     <h5 class="text-uppercase">'. htmlspecialchars($row["title"]).'</h5>';
        echo '     <p class="m-0">'. htmlspecialchars($row["description"]).'</p>';
        echo ' </div>';
        echo ' </div>';
    }
} 

else {
 
}
?>