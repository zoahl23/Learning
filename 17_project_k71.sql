-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 17, 2023 lúc 04:19 PM
-- Phiên bản máy phục vụ: 10.4.27-MariaDB
-- Phiên bản PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `17_project_k71`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cau_hoi`
--

CREATE TABLE `cau_hoi` (
  `id_cau_hoi` int(11) NOT NULL,
  `ten_cau_hoi` varchar(200) NOT NULL,
  `loai_cau_hoi` varchar(50) NOT NULL,
  `anh_cau_hoi` varchar(200) NOT NULL,
  `trang_thai` int(1) NOT NULL DEFAULT 0,
  `id_user` int(11) NOT NULL,
  `id_khoa_hoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cau_hoi`
--

INSERT INTO `cau_hoi` (`id_cau_hoi`, `ten_cau_hoi`, `loai_cau_hoi`, `anh_cau_hoi`, `trang_thai`, `id_user`, `id_khoa_hoc`) VALUES
(95, 'HTML là viết tắt của gì?', 'Một đáp án', '', 0, 11, 6),
(96, 'CSS được sử dụng để làm gì trong lập trình web?', 'Một đáp án', '', 1, 11, 6),
(97, 'JavaScript là ngôn ngữ lập trình nào?', 'Một đáp án', '', 0, 11, 6),
(99, 'CSS viết tắt của gì?', 'Một đáp án', '', 0, 11, 6),
(100, 'HTML là ngôn ngữ đánh dấu cho việc gì?', 'Điền', '', 0, 11, 6),
(101, 'JavaScript có thể được sử dụng để thực hiện các phép toán toán học như nào?', 'Điền', '', 0, 11, 6),
(102, 'JavaScript là ngôn ngữ lập trình nào?', 'Nhiều đáp án', '', 0, 11, 6),
(103, 'Trí tuệ Nhân tạo (AI) là gì?', 'Một đáp án', '', 0, 11, 9),
(104, 'Machine Learning (Học Máy) là phần nào của Trí tuệ Nhân tạo?', 'Một đáp án', '', 0, 11, 9),
(107, 'Ứng dụng của AI trong y tế là gì?', 'Điền', '', 1, 9, 9),
(108, 'AI Mạnh (Strong AI) có đặc điểm gì?', 'Điền', '', 0, 9, 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dap_an`
--

CREATE TABLE `dap_an` (
  `id_dap_an` int(11) NOT NULL,
  `ten_dap_an` varchar(200) NOT NULL,
  `kiem_tra` int(1) NOT NULL DEFAULT 0,
  `id_cau_hoi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dap_an`
--

INSERT INTO `dap_an` (`id_dap_an`, `ten_dap_an`, `kiem_tra`, `id_cau_hoi`) VALUES
(74, 'HyperText Markup Language', 1, 95),
(75, 'HyperTransfer Modern Language', 0, 95),
(76, 'HighTech Markup Language', 0, 95),
(77, 'HyperText Modeling Language', 0, 95),
(78, 'Xử lý logic phía máy chủ', 0, 96),
(79, 'Thiết kế giao diện và định dạng trang web', 1, 96),
(80, 'Xử lý dữ liệu từ cơ sở dữ liệu', 0, 96),
(81, 'Tạo và quản lý cơ sở dữ liệu', 0, 96),
(82, 'Ngôn ngữ lập trình server-side', 0, 97),
(83, 'Ngôn ngữ lập trình client-side', 1, 97),
(84, 'Ngôn ngữ lập trình cả server-side và client-side', 0, 97),
(85, 'Ngôn ngữ lập trình chỉ sử dụng cho mobile development', 0, 97),
(90, 'Counter Style Sheet', 0, 99),
(91, 'Cascading Style Sheet', 1, 99),
(92, 'Computer Style Sheet', 0, 99),
(93, 'Creative Style Sheet', 0, 99),
(94, 'Trình bày dữ liệu trên trang web', 1, 100),
(95, 'Thực hiện cộng, trừ, nhân, chia và nhiều phép toán khác', 1, 101),
(96, 'Ngôn ngữ lập trình client-side', 1, 102),
(97, 'Ngôn ngữ lập trình client-side', 1, 102),
(98, 'Ngôn ngữ lập trình cả server-side và client-side', 0, 102),
(99, 'Ngôn ngữ lập trình chỉ sử dụng cho mobile development', 0, 102),
(100, 'Một loại máy tính thông thường', 0, 103),
(101, 'Khả năng của máy tính thực hiện nhiệm vụ mà đòi hỏi sự thông minh như con người', 1, 103),
(102, 'Chỉ là một phần mềm đơn giản', 0, 103),
(103, 'Một loại robot tự động', 0, 103),
(104, 'Không liên quan', 0, 104),
(105, 'Là một thành phần quan trọng của AI', 1, 104),
(106, 'Chỉ là một phương pháp lập trình thông thường', 0, 104),
(107, 'Là một loại robot thông minh', 0, 104),
(116, 'Chuẩn đoán bệnh', 1, 107),
(117, 'Có khả năng suy nghĩ và hoạt động giống như con người', 1, 108);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diem`
--

CREATE TABLE `diem` (
  `id_diem` int(11) NOT NULL,
  `id_khoa_hoc` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `diem` double NOT NULL,
  `thoi_gian_lam_bai` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `diem`
--

INSERT INTO `diem` (`id_diem`, `id_khoa_hoc`, `id_user`, `diem`, `thoi_gian_lam_bai`) VALUES
(53, 6, 11, 0, '20:54:25 13/12/2023'),
(54, 6, 11, 0, '21:02:10 13/12/2023'),
(55, 6, 11, 100, '21:04:23 13/12/2023'),
(56, 6, 11, 100, '21:06:50 13/12/2023'),
(57, 6, 11, 0, '21:07:55 13/12/2023');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `khoa_hoc`
--

CREATE TABLE `khoa_hoc` (
  `id_khoa_hoc` int(11) NOT NULL,
  `ten_kh` varchar(200) NOT NULL,
  `anh` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `khoa_hoc`
--

INSERT INTO `khoa_hoc` (`id_khoa_hoc`, `ten_kh`, `anh`) VALUES
(6, 'Nền tảng phát triển Web', 'web.png'),
(9, 'Trí tuệ nhân tạo', 'ai.jpg'),
(35, 'Lập trình mạng', 'ccna.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `tai_khoan` varchar(50) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id_user`, `tai_khoan`, `password`, `role`) VALUES
(1, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 1),
(9, 'tk3', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(11, 'tk1', 'c4ca4238a0b923820dcc509a6f75849b', 0),
(43, 'admin3', 'c4ca4238a0b923820dcc509a6f75849b', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cau_hoi`
--
ALTER TABLE `cau_hoi`
  ADD PRIMARY KEY (`id_cau_hoi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_khoa_hoc` (`id_khoa_hoc`);

--
-- Chỉ mục cho bảng `dap_an`
--
ALTER TABLE `dap_an`
  ADD PRIMARY KEY (`id_dap_an`),
  ADD KEY `id_cau_hoi` (`id_cau_hoi`);

--
-- Chỉ mục cho bảng `diem`
--
ALTER TABLE `diem`
  ADD PRIMARY KEY (`id_diem`),
  ADD KEY `id_khoa_hoc` (`id_khoa_hoc`),
  ADD KEY `id_user` (`id_user`);

--
-- Chỉ mục cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  ADD PRIMARY KEY (`id_khoa_hoc`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cau_hoi`
--
ALTER TABLE `cau_hoi`
  MODIFY `id_cau_hoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT cho bảng `dap_an`
--
ALTER TABLE `dap_an`
  MODIFY `id_dap_an` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT cho bảng `diem`
--
ALTER TABLE `diem`
  MODIFY `id_diem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `khoa_hoc`
--
ALTER TABLE `khoa_hoc`
  MODIFY `id_khoa_hoc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cau_hoi`
--
ALTER TABLE `cau_hoi`
  ADD CONSTRAINT `cau_hoi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `cau_hoi_ibfk_2` FOREIGN KEY (`id_khoa_hoc`) REFERENCES `khoa_hoc` (`id_khoa_hoc`);

--
-- Các ràng buộc cho bảng `dap_an`
--
ALTER TABLE `dap_an`
  ADD CONSTRAINT `dap_an_ibfk_1` FOREIGN KEY (`id_cau_hoi`) REFERENCES `cau_hoi` (`id_cau_hoi`);

--
-- Các ràng buộc cho bảng `diem`
--
ALTER TABLE `diem`
  ADD CONSTRAINT `diem_ibfk_1` FOREIGN KEY (`id_khoa_hoc`) REFERENCES `khoa_hoc` (`id_khoa_hoc`),
  ADD CONSTRAINT `diem_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
