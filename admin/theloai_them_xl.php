<?php //ob_start();
	include_once('../connect.php');
		// upload hinh anh	
	$icon=$_FILES['image']['name'];
    $anhminhhoa_tmp=$_FILES['image']['tmp_name'];
    move_uploaded_file($anhminhhoa_tmp,"../image/".$icon);

	$theloai = $_POST['TenTL'];
	$thutu = $_POST['ThuTu'];
	$an = $_POST['AnHien'];
	
	$sl = "insert into theloai (TenTL,ThuTu,AnHien,icon) Value('$theloai','$thutu','$an','$icon')";

	if(mysqli_query($connect,$sl))
	{
		header('Location: theloai_them.php?added=1');
		exit;
	}
	else
	{
		echo 'Lỗi: ',mysqli_error($connect);
	}
//mysqli_close($link);

?>