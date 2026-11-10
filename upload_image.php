<?php

// Ham luu anh vao thu muc image
function luuAnh($file) {

    // Khong chon anh
    if (!isset($file) ||
        ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return '';
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Tải ảnh lên bị lỗi.');
    }

    // Gioi han 2MB
    if ($file['size'] > 2 * 1024 * 1024) {
        throw new RuntimeException('Ảnh không được lớn hơn 2 MB.');
    }

    // Kiem tra dinh dang that cua anh
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file(
        $file['tmp_name']
    );

    $types = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp'
    ];

    if (!isset($types[$mime])) {
        throw new RuntimeException(
            'Chỉ chấp nhận ảnh JPG, PNG, GIF hoặc WEBP.'
        );
    }

    // Tao ten anh khong trung
    $name = bin2hex(random_bytes(12)) . '.' . $types[$mime];

    $destination = __DIR__ . '/image/' . $name;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException(
            'Không thể lưu ảnh vào thư mục image.'
        );
    }

    return $name;
}

// Ham xoa anh cu
function xoaAnh($name) {

    if ($name !== '' && basename($name) === $name) {

        $path = __DIR__ . '/image/' . $name;

        if (is_file($path)) {
            unlink($path);
        }
    }
}

?>