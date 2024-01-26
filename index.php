<?php 

	include 'function.php';

	if (isLogin()) {
		header("Location: src/khoa_hoc.php");
	}
	else {
		header ("Location: src/dang_nhap.php");
	}
	
?>