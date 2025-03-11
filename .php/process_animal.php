<?php
include("config.php");

//lấy dữ liệu từ sql
$sql ="select  * from animals ";
$result =$conn-> query($sql);

//xử lý kết quả lấy từ sql
if (! $result) {
    echo "kết quả bị lỗi" .$conn->error. "";
}

//Xử lý code phần gallery
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
                   echo ' <div class="pb-5">';
                   echo ' <div class="product-item position-relative bg-light d-flex flex-column text-center">';
                   echo '<div class="image-container"><img class="img-fluid mb-4" src="'. htmlspecialchars($row["image"]).'" alt=""></div>';
                   echo '     <h6 class="text-uppercase">'. htmlspecialchars(($row["name"])).'</h6>';
                   echo '     <h5 class="text-green mb-0">'.htmlspecialchars($row["description"]).'</h5>';                  
                   echo '  </div>';
                   echo '  </div>';
    }
}
    else{
        echo "không có ảnh gallery nào cả";
    }
?>