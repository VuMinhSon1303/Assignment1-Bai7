<?php

require_once '../connect.php';
require_once '../upload_image.php';

// Lay ID tu URL
$id = filter_input(
    INPUT_GET,
    'idTL',
    FILTER_VALIDATE_INT
);

if (!$id) {
    http_response_code(400);
    exit('ID không hợp lệ.');
}

// Lay thong tin the loai cu
$stmt = mysqli_prepare(
    $connect,
    'SELECT * FROM theloai WHERE idTL = ?'
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

$error = '';

// Xu ly khi nhan nut Sua
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['TenTL'] ?? '');

    $order = filter_var(
        $_POST['ThuTu'] ?? '',
        FILTER_VALIDATE_INT
    );

    $visible = filter_var(
        $_POST['AnHien'] ?? '',
        FILTER_VALIDATE_INT
    );

    if ($name === '' ||
        $order === false ||
        !in_array($visible, [0, 1], true)) {

        $error = 'Dữ liệu nhập chưa hợp lệ.';

    } else {

        $newImage = '';

        try {

            // Upload anh moi neu co
            $newImage = luuAnh($_FILES['image'] ?? null);

            // Neu khong co anh moi, giu anh cu
            $icon = $newImage !== ''
                ? $newImage
                : $row['icon'];

            // Cap nhat MySQL
            $update = mysqli_prepare(
                $connect,
                'UPDATE theloai
                 SET TenTL=?, ThuTu=?, AnHien=?, icon=?
                 WHERE idTL=?'
            );

            mysqli_stmt_bind_param(
                $update,
                'siisi',
                $name,
                $order,
                $visible,
                $icon,
                $id
            );

            mysqli_stmt_execute($update);

            // Xoa anh cu neu da thay anh moi
            if ($newImage !== '') {
                xoaAnh($row['icon']);
            }

            header('Location: theloai.php?msg=sua');
            exit;

        } catch (Throwable $ex) {

            xoaAnh($newImage);

            $error = 'Không thể sửa: tên thể loại có thể trùng hoặc ảnh không hợp lệ.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>SỬA THỂ LOẠI #<?= (int)$id ?></h1>

<?php if ($error !== ''): ?>

    <p class="notice"><?= e($error) ?></p>

<?php endif; ?>

<form method="post" enctype="multipart/form-data">

    <p>
        <label>
            Tên thể loại:

            <input type="text"
                   name="TenTL"
                   maxlength="255"
                   required
                   value="<?= e($row['TenTL']) ?>">
        </label>
    </p>

    <p>
        <label>
            Thứ tự:

            <input type="number"
                   name="ThuTu"
                   required
                   value="<?= (int)$row['ThuTu'] ?>">
        </label>
    </p>

    <p>
        <label>
            Ẩn / Hiện:

            <select name="AnHien">

                <option value="0"
                    <?= (int)$row['AnHien'] === 0 ? 'selected' : '' ?>>
                    Ẩn
                </option>

                <option value="1"
                    <?= (int)$row['AnHien'] === 1 ? 'selected' : '' ?>>
                    Hiện
                </option>

            </select>
        </label>
    </p>

    <p>
        Ảnh hiện tại:

        <?php if ($row['icon'] !== ''): ?>

            <img class="icon"
                 src="../image/<?= rawurlencode($row['icon']) ?>"
                 alt="Ảnh hiện tại">

        <?php else: ?>

            Chưa có ảnh

        <?php endif; ?>
    </p>

    <p>
        <label>
            Thay ảnh mới (không bắt buộc):

            <input type="file"
                   name="image"
                   accept=".jpg,.jpeg,.png,.gif,.webp">
        </label>
    </p>

    <button type="submit" name="Sua" value="1">
        Lưu thay đổi
    </button>

</form>

<p>
    <a href="theloai.php">Quay về danh sách</a>
</p>

</body>
</html>