<?php

require_once '../connect.php';
require_once '../upload_image.php';

// Chi xu ly khi form gui bang POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: theloai_them.php');
    exit;
}

// Lay du lieu tu form
$name = trim($_POST['TenTL'] ?? '');

$order = filter_var(
    $_POST['ThuTu'] ?? '',
    FILTER_VALIDATE_INT
);

$visible = filter_var(
    $_POST['AnHien'] ?? '',
    FILTER_VALIDATE_INT
);

// Kiem tra du lieu
if ($name === '' ||
    $order === false ||
    !in_array($visible, [0, 1], true)) {

    exit(
        'Dữ liệu không hợp lệ. ' .
        '<a href="theloai_them.php">Quay lại</a>'
    );
}

$newImage = '';

try {

    // Luu anh
    $newImage = luuAnh($_FILES['image'] ?? null);

    // Them du lieu vao MySQL
    $stmt = mysqli_prepare(
        $connect,
        'INSERT INTO theloai
        (TenTL, ThuTu, AnHien, icon)
        VALUES (?, ?, ?, ?)'
    );

    mysqli_stmt_bind_param(
        $stmt,
        'siis',
        $name,
        $order,
        $visible,
        $newImage
    );

    mysqli_stmt_execute($stmt);

    // Quay ve trang danh sach
    header('Location: theloai.php?msg=them');
    exit;

} catch (Throwable $ex) {

    xoaAnh($newImage);

    http_response_code(400);

    echo 'Không thể thêm thể loại. ';
    echo 'Tên có thể đã tồn tại hoặc ảnh không hợp lệ.<br>';
    echo '<a href="theloai_them.php">Quay lại</a>';

}

?>