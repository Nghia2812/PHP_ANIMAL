<?php
include("config.php");

$sql = " select * from blog_posts limit 2";
$result = $conn->query($sql);

if(! $result) {
    echo "xử lý dữ liệu thất bại". $conn->error;
}

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
           echo ' <div class="col-lg-6">';
           echo '  <div class="blog-item">';
           echo '     <div class="row g-0 bg-light overflow-hidden">';
           echo '        <div class="col-12 col-sm-5 h-100">';
           echo '            <img class="img-fluid h-100" src="'.htmlspecialchars($row["image"]).'" style="object-fit: cover;">';
           echo '       </div>';
           echo '      <div class="col-12 col-sm-7 h-100 d-flex flex-column justify-content-center">';
           echo '          <div class="p-4">';
           echo '             <div class="d-flex mb-3">';
           echo '                 <small class="me-3"><i class="bi bi-bookmarks me-2"></i>Web Design</small>';
           echo '                 <small><i class="bi bi-calendar-date me-2"></i>' . date("F d, Y", strtotime($row["created_at"])) . '</small>';
           echo '             </div>';
           echo '             <h5 class="text-uppercase mb-3">'.htmlspecialchars($row["title"]).'</h5>';
           echo '             <p>'.htmlspecialchars($row["content"]).'</p>';
           echo '<a class="text-primary text-uppercase" href="detail_blog.php?id=' . htmlspecialchars($row['post_id']) . '">Xem Thêm<i class="bi bi-chevron-right"></i></a>';
           echo '         </div>';
           echo '     </div>';
           echo ' </div>';
           echo ' </div>';
           echo ' </div>';
    }
}
else {
    echo "không có bài viết";
}
?>