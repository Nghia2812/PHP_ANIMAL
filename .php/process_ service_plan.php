<?php
include("config.php");

$sql = "SELECT * FROM service_plans";
$result = $conn->query($sql);

if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
} 

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){

     echo '   <div class="col-lg-4">';
      echo '               <div class="bg-light text-center pt-5 mt-lg-5">';
      echo '                   <h2 class="text-uppercase">'.htmlspecialchars($row["name_service"]).'</h2>';
      echo '                   <h6 class="text-body mb-5">'.htmlspecialchars($row["tagline"]).'</h6>';
      echo '                   <div class="text-center bg-primary p-4 mb-2">';
      echo '                       <h1 class="display-4 text-white mb-0">';
      echo '                           <small class="align-top"';
      echo '                               style="font-size: 22px; line-height: 45px;">$</small>'.htmlspecialchars($row["price"]).'<small';
      echo '                               class="align-bottom" style="font-size: 16px; line-height: 40px;">/';
      echo '                               $</small>';
      echo '                       </h1>';
      echo '                   </div>';
      echo '                   <div class="text-center p-4">';
      echo '                       <div class="d-flex align-items-center justify-content-between mb-1">';
      echo '                           <span>'.htmlspecialchars($row["content"]).'</span>';
      echo '                           <i class="bi bi-check2 fs-4 text-primary"></i>';
      echo '                       </div>  ';                          
      echo '                       <a href="" class="btn btn-primary text-uppercase py-2 px-4 my-3">MUA NGAY</a>';
      echo '                   </div>';
      echo '               </div>';
      echo '           </div>';
    }
}else{
    echo "lấy dữ liệu không thành công";
}
?>