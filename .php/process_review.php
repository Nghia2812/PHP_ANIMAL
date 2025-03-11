<?php
include("config.php");

//kết nối sql
$sql = " select * from reviews";
$result = $conn->query($sql);

//xử lý kết nối
if(!$result){
    echo "kết nối thất bại".$conn->error;
}

//xử lý code phần review
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
       echo ' <div class="testimonial-item text-center">';
       echo ' <div class="position-relative mb-4">';
       echo '     <img class="img-fluid mx-auto" src="'.htmlspecialchars($row["image"]).'" alt="">';
       echo '     <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">';
       echo '         <i class="bi bi-chat-square-quote text-primary"></i>';
       echo '      </div>';
       echo ' </div>';
       echo '  <p>'.htmlspecialchars($row["comment"]).'</p>';
       echo ' <hr class="w-25 mx-auto">';
       echo '  <h5 class="text-uppercase">'.htmlspecialchars($row["name"]).'</h5>';
       echo '  <span>'.htmlspecialchars($row["email"]).'</span>';
       echo '</div>';

    }
}else{
    echo "không hiện thị được reviews";
}
?>