<?php
	include 'connectdb.php';
	session_start();
	// hàm kiểm tra đã đăng nhập chưa 
	function isLogin() {
		// trả về true nếu session tồn tại và khác rỗng 
		if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
			return true;
		}
		else {
			header("Location: dang_nhap.php");
		}
	}

	function checkLogin($conn, $username, $password) {
		$sql = "SELECT * FROM `user`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $maUser = $row['id_user'];
            $tkUser = $row['tai_khoan'];
            $mkUser = $row['password'];
			
			if ($username == $tkUser && $password == $mkUser) {
				$_SESSION['name'] = $tkUser;
				return true;
			}
        }
		return false;
	}
?>
  