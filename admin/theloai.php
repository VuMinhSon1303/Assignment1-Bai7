<?php

require_once '../connect.php';

// Lay danh sach the loai
$result = mysqli_query(
    $connect,
    'SELECT * FROM theloai ORDER BY ThuTu ASC, idTL ASC'
);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>QUẢN LÝ THỂ LOẠI</h1>

<p>
    <a href="theloai_them.php">+ Thêm thể loại</a>
</p>

<?php if (isset($_GET['msg'])): ?>
    <p class="notice">
        Đã thực hiện thao tác thành công.
    </p>
<?php endif; ?>

<table>

    <tr>
        <th>ID</th>
        <th>Tên thể loại</th>
        <th>Thứ tự</th>
        <th>Ẩn / Hiện</th>
        <th>Biểu tượng</th>
        <th>Thao tác</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>

        <tr>

            <td>
                <?= (int)$row['idTL'] ?>
            </td>

            <td>
                <?= e($row['TenTL']) ?>
            </td>

            <td>
                <?= (int)$row['ThuTu'] ?>
            </td>

            <td>
                <?= (int)$row['AnHien'] === 1 ? 'Hiện' : 'Ẩn' ?>
            </td>

            <td>
                <?php if ($row['icon'] !== ''): ?>

                    <img
                        class="icon"
                        src="../image/<?= rawurlencode($row['icon']) ?>"
                        alt="Ảnh thể loại">

                <?php else: ?>

                    Chưa có ảnh

                <?php endif; ?>
            </td>

            <td class="actions">

                <a href="theloai_sua.php?idTL=<?= (int)$row['idTL'] ?>">
                    Sửa
                </a>

                <a href="theloai_xoa.php?idTL=<?= (int)$row['idTL'] ?>">
                    Xóa
                </a>

            </td>

        </tr>

    <?php endwhile; ?>

</table>

</body>
</html>