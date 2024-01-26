<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quản lý tài khoản</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->
    <style>
        img{
            max-width: 400px;
        }
        a{
            text-decoration: none;
            color: white;
        }
        a:hover {
            color: white;
        }
        .tach {
            margin: 8px 0px;
        }
        th, td {
            text-align: center;
        }
        td {
            overflow: hidden;
        }
    </style>
</head>
<body>
    <?php 
        include 'navbar.php';
        include '../connectdb.php';
        include '../role.php';
        $dir = "../images/"; 

        // kiểm tra đăng nhập chưa
		if (!isset($_SESSION['name'])) {
			header("Location: dang_nhap.php");
			exit;
		}
        
        if (!checkRole($conn, $_SESSION['name'])) {
			header("Location: khoa_hoc.php");
			exit;
		}

        // ==================================

        $_SESSION['xoa_tai_khoan_php'] = 1;
        $_SESSION['them_tai_khoan_php'] = 1;
        $_SESSION['chinh_sua_tai_khoan_php'] = 1;

        // ==================================
    ?>
    <?php 
        // khong cho truy cap vao trang

        if (isset($_SESSION['chinh_sua_khoa_hoc_php'])) {
            unset($_SESSION['chinh_sua_khoa_hoc_php']);
        }

        if (isset($_SESSION['diem_thi_php'])) {
            unset($_SESSION['diem_thi_php']);
        }

        if (isset($_SESSION['ket_qua_php'])) {
            unset($_SESSION['ket_qua_php']);
        }

        if (isset($_SESSION['luyen_tap_php'])) {
            unset($_SESSION['luyen_tap_php']);
        }

        if (isset($_SESSION['them_cau_hoi_php'])) {
            unset($_SESSION['them_cau_hoi_php']);
        }

        if (isset($_SESSION['xem_truoc_php'])) {
            unset($_SESSION['xem_truoc_php']);
        }

        if (isset($_SESSION['xoa_cau_hoi_php'])) {
            unset($_SESSION['xoa_cau_hoi_php']);
        }

        if (isset($_SESSION['xoa_diem_php'])) {
            unset($_SESSION['xoa_diem_php']);
        }

        if (isset($_SESSION['xoa_khoa_hoc_php'])) {
            unset($_SESSION['xoa_khoa_hoc_php']);
        }
    ?>
	<main style="min-height: 100vh; max-width: 100%;">
        <div id="action" style="margin: 20px 0 0 13%;">
            <a href="khoa_hoc.php" class="btn btn-primary">Trở lại</a>
            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">Thêm tài khoản</button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?php echo "them_tai_khoan.php?loai=1" ?>" >Thêm người biên tập</a></li>
                <li><a class="dropdown-item tach" href="<?php echo "them_tai_khoan.php?loai=2" ?>" >Thêm quản trị viên</a></li>
                <li><a class="dropdown-item" href="<?php echo "them_tai_khoan.php?loai=3" ?>" >Thêm nhiều người biên tập</a></li>
            </ul>
            <button type="button" class="btn btn-success" id="exportExcel">Xuất Excel</button>
        </div>
        <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 15% 0; ">
            <p class="h3">Danh sách tài khoản</p>
            <table  class="table table-striped table-bordered">
                <tr>
                    <th style="width: 10%;">STT</th>
                    <th style="width: 30%;">Tên tài khoản</th>
                    <th style="width: 30%;">Admin</th>
                    <th style="width: 30%;">Thao tác</th>
                </tr>
                <?php 
                    $taiKhoan = "SELECT * FROM `user`";
                    $resultTK = mysqli_query($conn, $taiKhoan);
                    $stt = 1;
                    $flag = true;
                    while ($row = mysqli_fetch_array($resultTK)) {
                        $idth = $row['id_user'];
                        $tenTK = $row['tai_khoan'];
                        $matKhau = $row['password'];
                        $role = $row['role'];
                        
                        echo '<tr>
                        <td>'.$stt.'</td>
                        <td>'.$tenTK.'</td>
                        <td>';
                        if ($role == 1) {
                            echo '<input type="checkbox" checked disabled></td><td></td>
                            </tr>';
                        }
                        else {
                            echo '<input type="checkbox" disabled></td>
                            <td>
                            <button type="button" class="btn btn-danger">
                                <a href="xoa_tai_khoan.php?id_user='.$idth.'">Xóa tài khoản</a>
                            </button>
                            <button type="button" class="btn btn-primary">
                                <a href="chinh_sua_tai_khoan.php?id_user='.$idth.'">Chỉnh sửa</a>
                            </button></td>
                            </tr>';
                        }

                        $stt++;
                        $flag = false;
                    }

                    if ($flag) {
                        echo '<tr><td align="center" colspan="4">Không có tài khoản nào</td></tr>';
                    }
                ?>
            </table>
        </div>
	</main>
    <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.17.5/dist/xlsx.full.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#exportExcel').click(function () {
                exportToExcel();
            });

            function exportToExcel() {
                let table = document.querySelector('.table');
                let tableData = [];
                let headers = [];
                for (let i = 0; i < table.rows[0].cells.length-1; i++) {
                    headers[i] = table.rows[0].cells[i].innerText.trim();
                }
                tableData.push(headers);

                for (let i = 1; i < table.rows.length; i++) {
                    let rowData = [];
                    for (let j = 0; j < table.rows[i].cells.length; j++) {
                        if (j !== 3) { 
                            if (j === 2) { 
                                let checkbox = table.rows[i].cells[j].querySelector('input[type="checkbox"]');
                                rowData[j] = checkbox.checked ? "Admin" : "";
                            } else {
                                rowData[j] = table.rows[i].cells[j].innerText.trim();
                            }
                        }
                    }
                    tableData.push(rowData);
                }

                let wb = XLSX.utils.book_new();
                let ws = XLSX.utils.aoa_to_sheet(tableData);
                XLSX.utils.book_append_sheet(wb, ws, "Danh sách tài khoản");

                XLSX.writeFile(wb, 'danh_sach_tai_khoan.xlsx');
            }


        });
    </script>
</body>
</html>