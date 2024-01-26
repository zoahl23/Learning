<?php
	include 'connectdb.php';
    // include '../role.php';

    function checkRole($conn, $taiKhoan) {
        $tenND = "SELECT * FROM `user` WHERE `tai_khoan` = '$taiKhoan'";
        $resultND = mysqli_query($conn, $tenND);
        while ($row = mysqli_fetch_array($resultND)) {
            if ($row['role'] == 1) {
                return true;
            }
        }
        return false;
    } 
?>