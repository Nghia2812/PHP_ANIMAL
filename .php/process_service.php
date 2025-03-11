<?php
include("config.php");

$sql = " select * from services limit 6";
$result = $conn->query($sql);

if(! $result) {
    echo "xử lý dữ liệu thất bại". $conn->error;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='col-md-6'>";
        echo "<div class='service-item bg-light d-flex p-4'>";
        echo "<i class='" . htmlspecialchars($row["Icon"]) . " display-1 text-primary me-4'></i>";
        echo "<div>";
        echo "<h5 class='text-uppercase mb-3'>" . htmlspecialchars($row["service_name"]) . "</h5>";
        echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
        echo "<a class='read-more-link' href=''>Xem Thêm<i class='bi bi-chevron-right'></i></a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "<p>Không có dịch vụ nào.</p>";
}
?>