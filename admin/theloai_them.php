<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm thể loại</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<h1>THÊM THỂ LOẠI</h1>

<form action="theloai_them_xl.php"
      method="post"
      enctype="multipart/form-data">

    <p>
        <label>
            Tên thể loại:
            <input type="text"
                   name="TenTL"
                   required
                   maxlength="255">
        </label>
    </p>

    <p>
        <label>
            Thứ tự:
            <input type="number"
                   name="ThuTu"
                   value="0"
                   required>
        </label>
    </p>

    <p>
        <label>
            Ẩn / Hiện:

            <select name="AnHien">
                <option value="0">Ẩn</option>
                <option value="1" selected>Hiện</option>
            </select>
        </label>
    </p>

    <p>
        <label>
            Biểu tượng:
            <input type="file"
                   name="image"
                   accept=".jpg,.jpeg,.png,.gif,.webp">
        </label>
    </p>

    <button type="submit" name="Them" value="1">
        Thêm
    </button>

    <button type="reset">
        Hủy nhập
    </button>

</form>

<p>
    <a href="theloai.php">Quay về danh sách</a>
</p>

</body>
</html>