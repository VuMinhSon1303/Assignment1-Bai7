<?php

$connect = mysqli_connect(
    "localhost",
    "root",
    "",
    "tintuc"
);

if ($connect) {
    echo "Kết nối Database thành công!";
} else {
    echo "Kết nối Database thất bại!";
}

?>