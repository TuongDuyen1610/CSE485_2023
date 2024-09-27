-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 10:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `btth01_cse485_ex`
--

-- --------------------------------------------------------

--
-- Table structure for table `baiviet`
--

CREATE TABLE `baiviet` (
  `ma_bviet` int(10) UNSIGNED NOT NULL,
  `tieude` varchar(200) NOT NULL,
  `ten_bhat` varchar(100) NOT NULL,
  `ma_tloai` int(10) UNSIGNED NOT NULL,
  `tomtat` text NOT NULL,
  `noidung` text DEFAULT NULL,
  `ma_tgia` int(10) UNSIGNED NOT NULL,
  `ngayviet` datetime NOT NULL DEFAULT current_timestamp(),
  `hinhanh` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `baiviet`
--

INSERT INTO `baiviet` (`ma_bviet`, `tieude`, `ten_bhat`, `ma_tloai`, `tomtat`, `noidung`, `ma_tgia`, `ngayviet`, `hinhanh`) VALUES
(1, 'Lòng mẹ', 'Lòng mẹ', 2, 'Và mẹ ơi đừng khóc nhé! Cả đời này mẹ đã khóc nhiều lắm rồi, hãy cười lên vì con đã trưởng thành! Con sẽ lại về dậy sớm nấu cơm cho mẹ, nấu nước cho mẹ tắm như ngày xưa. “Dù cho vai nắng nhưng lòng thương chẳng nhạt màu, vẫn mơ quay về vui vầy dưới bóng mẹ yêu”', NULL, 1, '2012-07-23 00:00:00', NULL),
(2, 'Cảm ơn em đã rời xa anh', 'Vết mưa', 2, 'Cảm ơn em đã cho anh những tháng ngày hạnh phúc, cho anh biết yêu và được yêu. Em cho anh được nếm trải hương vị ngọt ngào của tình yêu nhưng cũng đầy đau khổ và nước mắt. Những tháng ngày đó có lẽ suốt cuộc đời anh không bao giờ quên', NULL, 3, '2012-02-12 00:00:00', NULL),
(3, 'Cuộc đời có mấy ngày mai?', 'Phôi pha', 2, 'Đêm nay, trời quang mây tạnh, trong người nghe hoang vắng và tôi ngồi đây “Ôm lòng đêm, Nhìn vầng trăng mới về” mà ngậm ngùi “Nhớ chân giang hồ. Ôi phù du, từng tuổi xuân đã già”', NULL, 4, '2014-03-13 00:00:00', NULL),
(4, 'Quê tôi!', 'Quê hương', 5, 'Quê hương là gì mà chở đầy kí ức nhỏ xinh. Có đám trẻ nô đùa bên nhau dưới gốc ổi nhà bà Năm giữa trưa nắng gắt chỉ để chờ bà đi vắng là hái trộm. Có hai anh em tôi bì bõm lội sình bắt cua đem về nhà cho mẹ nấu canh, nấu cháo… Có ba chị em tôi lục đục tự nấu ăn khi mẹ vắng nhà. Có anh tôi luôn dắt tôi đi cùng đường ngõ xóm chỉ để em được vui. Có cả những trận cãi nhau nảy lửa của ba anh em nữa…', NULL, 5, '2014-02-20 00:00:00', NULL),
(5, 'Đất nước', 'Đất nước', 5, 'Đã bao nhiêu lần tôi tự hỏi: liệu trên Thế giới này có nơi nào chiến tranh tang thương mà lại rất đổi anh hùng như nước mình không? Liệu có mảnh đất nào mà mỗi tấc đất hôm nay đã thấm máu xương của những thế hệ đi trước nhiều như nước mình không? Và, liệu có một đất nước nào lại có nhiều bà mẹ đau khổ nhưng cũng hết sức gan góc như đất nước mình không?', NULL, 1, '2010-05-25 00:00:00', NULL),
(6, 'Hard Rock Hallelujah', 'Hard Rock Hallelujah', 7, 'Những linh hồn đang lạc lối, mù quáng mất phương hướng trong cõi trần gian đầy nghiệt ngã hãy nên lắng nghe \"Hard Rock Hallelujah\" để có thể quên tất cả mọi thứ để tìm về đúng bản chất sâu thẳm nhất trong tâm hồn chính mình!', NULL, 6, '2013-09-12 00:00:00', NULL),
(7, 'The Unforgiven', 'The Unforgiven', 7, 'Lâu lắm rồi mới nghe lại The Unforgiven II, vì bài này không phải là bài mà tôi thích. Anh bạn tôi lúc trước, đi đâu cũng nghêu ngao bài này ấy, chỉ tại vì hắn đang... thất tình mà lị. Mà sao Metallica có The Unforgiven rồi lại có thêm bài này chi nữa vậy không biết nữa, làm cho tôi cảm thấy hình như hơi bị đúng so với tâm trạng của tôi lúc này.', NULL, 1, '2010-05-25 00:00:00', NULL),
(8, 'Nơi tình yêu bắt đầu', 'Nơi tình yêu bắt đầu', 1, 'Nhiều người sẽ nghĩ làm gì có yêu nhất và làm gì có yêu mãi. Ừ! Chẳng có gì là mãi mãi cả, vì chúng ta không trường tồn vĩnh cửu', NULL, 1, '2014-02-03 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tacgia`
--

CREATE TABLE `tacgia` (
  `ma_tgia` int(10) UNSIGNED NOT NULL,
  `ten_tgia` varchar(100) NOT NULL,
  `hinh_tgia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tacgia`
--

INSERT INTO `tacgia` (`ma_tgia`, `ten_tgia`, `hinh_tgia`) VALUES
(1, 'Nhacvietplus', NULL),
(2, 'Sưu tầm', NULL),
(3, 'Sandy', NULL),
(4, 'Lê Trung Ngân', NULL),
(5, 'Khánh Ngọc', NULL),
(6, 'Night Stalker', NULL),
(7, 'Phạm Phương Anh', NULL),
(8, 'Tâm tình', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

CREATE TABLE `theloai` (
  `ma_tloai` int(10) UNSIGNED NOT NULL,
  `ten_tloai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `theloai`
--

INSERT INTO `theloai` (`ma_tloai`, `ten_tloai`) VALUES
(1, 'Nhạc trẻ'),
(2, 'Nhạc trữ tình'),
(3, 'Nhạc cách mạng'),
(4, 'Nhạc thiếu nhi'),
(5, 'Nhạc quê hương'),
(6, 'POP'),
(7, 'Rock'),
(8, 'R&B');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin_user', 'admin_password', 'admin', '2024-09-20 12:04:56'),
(2, 'user1', 'user1_password', 'user', '2024-09-20 12:04:56'),
(3, 'user2', 'user2_password', 'user', '2024-09-20 12:04:56'),
(4, 'user3', 'user3_password', 'user', '2024-09-20 12:04:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baiviet`
--
ALTER TABLE `baiviet`
  ADD PRIMARY KEY (`ma_bviet`),
  ADD KEY `ma_tloai` (`ma_tloai`),
  ADD KEY `ma_tgia` (`ma_tgia`);

--
-- Indexes for table `tacgia`
--
ALTER TABLE `tacgia`
  ADD PRIMARY KEY (`ma_tgia`);

--
-- Indexes for table `theloai`
--
ALTER TABLE `theloai`
  ADD PRIMARY KEY (`ma_tloai`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baiviet`
--
ALTER TABLE `baiviet`
  MODIFY `ma_bviet` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tacgia`
--
ALTER TABLE `tacgia`
  MODIFY `ma_tgia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `theloai`
--
ALTER TABLE `theloai`
  MODIFY `ma_tloai` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baiviet`
--
ALTER TABLE `baiviet`
  ADD CONSTRAINT `baiviet_ibfk_1` FOREIGN KEY (`ma_tloai`) REFERENCES `theloai` (`ma_tloai`),
  ADD CONSTRAINT `baiviet_ibfk_2` FOREIGN KEY (`ma_tgia`) REFERENCES `tacgia` (`ma_tgia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
