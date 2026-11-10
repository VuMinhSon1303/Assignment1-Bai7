<?php

// Ket noi co so du lieu MySQL
$connect = mysqli_connect(
    'localhost',
    'root',
    '',
    'tintuc'
);

// Kiem tra ket noi
if (!$connect) {
    die("Không thể kết nối MySQL: " . mysqli_connect_error());
}

// Cau hinh tieng Viet
mysqli_set_charset($connect, 'utf8mb4');

// Ham hien thi van ban an toan
function e($value) {
    return htmlspecialchars(
        (string)$value,
        ENT_QUOTES,
        'UTF-8'
    );
}

?>