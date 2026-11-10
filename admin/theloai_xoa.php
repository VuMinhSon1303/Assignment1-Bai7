<?php

require_once '../connect.php';
require_once '../upload_image.php';

// Lay ID
$id = filter_input(
    INPUT_GET,
    'idTL',
    FILTER_VALIDATE_INT
);

if (!$id) {
    http_response_code(400);
    exit('ID không hợp lệ.');
}

// Lay thong tin the loai
$stmt = mysqli_prepare(
    $connect,
    'SELECT idTL, TenTL, icon
     FROM theloai WHERE idTL = ?'
);

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

$row = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

if (!$row) {
    http_response_code(404);
    exit('Không tìm thấy thể loại.');
}

// Khi nguoi dung xac nhan xoa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $delete = mysqli_prepare(
        $connect,
        'DELETE FROM theloai WHERE idTL = ?'
    );

    mysqli_stmt_bind_param($delete, 'i', $id);

    mysqli_stmt_execute($delete);

    // Xoa anh cua the loai
    xoaAnh($row['icon']);

    header('Location: theloai.php?msg=xoa');
    exit;
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xóa thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>XÁC NHẬN XÓA</h1>

<p>
    Bạn muốn xóa thể loại
    <strong><?= e($row['TenTL']) ?></strong>?
</p>

<form method="post">

    <button type="submit">
        Xác nhận xóa
    </button>

    <a href="theloai.php">Hủy</a>

</form>

</body>
</html>