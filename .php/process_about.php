<?php
include("config.php");

$sql = "select * from about ";
$result = $conn->query($sql);
?>
<?php
//xử lý dữ liệu
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
} 

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
 ?>       

        <h4 class="text-body mb-4"><?=htmlspecialchars($row["title"])?></h4>
        <div class="bg-light p-4">
            <ul class="nav nav-pills justify-content-between mb-3" id="pills-tab" role="tablist">
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link text-uppercase w-100 active" id="pills-1-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                        aria-selected="true">TRUNG TÂM QUẢN LÝ</button>
                </li>
                <li class="nav-item w-50" role="presentation">
                    <button class="nav-link text-uppercase w-100" id="pills-2-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2"
                        aria-selected="false">HỆ THỐNG THÔNG MINH</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                    <p class="mb-0"><?=htmlspecialchars($row["description"])?></p>
                </div>
                <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                    <p class="mb-0"><?=htmlspecialchars($row["content"])?> </p>
                </div>
            </div>
        </div>
        <?php
    }
}
$conn->close();
?>
