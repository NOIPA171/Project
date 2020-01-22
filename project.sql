-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2020 年 01 月 22 日 09:32
-- 伺服器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `project`
--
CREATE DATABASE IF NOT EXISTS `project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `project`;

-- --------------------------------------------------------

--
-- 資料表結構 `platformAdmins`
--

CREATE TABLE `platformAdmins` (
  `aId` int(11) NOT NULL,
  `aRoleId` int(10) NOT NULL,
  `aFName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aLName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aEmail` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aPassword` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aActive` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aVerify` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT current_timestamp(),
  `aHash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aNotes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aLogoutTime` datetime DEFAULT NULL,
  `aLoginTime` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `platformAdmins`
--

INSERT INTO `platformAdmins` (`aId`, `aRoleId`, `aFName`, `aLName`, `aEmail`, `aPassword`, `aActive`, `aVerify`, `aHash`, `aNotes`, `aLogoutTime`, `aLoginTime`, `created_at`, `updated_at`) VALUES
(1, 1, 'vicky', 'test', 'vickysun2@hotmail.com', 'e79cab55eab4c0a1a63610829a51fd51d5cfb294', 'active', 'verified', '', 'asdf', '2020-01-22 07:55:46', '2020-01-22 07:21:53', '2020-01-15 04:01:20', '2020-01-15 04:01:20'),
(11, 3, 'dd', 'dd', 'radu000rider@gmail.com', 'bc7cafbd1f9bcb7a3065a603b98d5c45e60c67d9', 'active', 'verified', '3295c76acbf4caaed33c36b1b5fc2cb1', 'again\r\n', '2020-01-22 03:55:22', '2020-01-22 03:55:02', '2020-01-21 19:53:38', '2020-01-21 19:53:38'),
(13, 2, 'aa', 'aa', 'nightfallvs0923@gmail.com', 'e0c9035898dd52fc65c41454cec9c4d2611bfb37', 'active', 'verified', 'daca41214b39c5dc66674d09081940f0', 'aa', '2020-01-22 04:00:19', '2020-01-22 03:58:24', '2020-01-21 19:58:09', '2020-01-21 19:58:09');

-- --------------------------------------------------------

--
-- 資料表結構 `platformPermissions`
--

CREATE TABLE `platformPermissions` (
  `adminPrmId` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adminPrmName` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `platformPermissions`
--

INSERT INTO `platformPermissions` (`adminPrmId`, `adminPrmName`) VALUES
('prmA00', 'admin'),
('prmA01', 'vendors'),
('prmA02', 'charts'),
('prmA03', 'users'),
('prmA04', 'comments');

-- --------------------------------------------------------

--
-- 資料表結構 `platformResetPass`
--

CREATE TABLE `platformResetPass` (
  `aEmail` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aToken` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aHash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aExpireDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `platformRoles`
--

CREATE TABLE `platformRoles` (
  `aRoleId` int(10) NOT NULL,
  `aRoleName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `platformRoles`
--

INSERT INTO `platformRoles` (`aRoleId`, `aRoleName`) VALUES
(1, 'Owner'),
(2, 'Manager'),
(3, 'Staff');

-- --------------------------------------------------------

--
-- 資料表結構 `rel_platform_permissions`
--

CREATE TABLE `rel_platform_permissions` (
  `aId` int(10) NOT NULL COMMENT '管理者',
  `aPermissionId` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '權限'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `rel_platform_permissions`
--

INSERT INTO `rel_platform_permissions` (`aId`, `aPermissionId`) VALUES
(1, 'prmA01'),
(1, 'prmA03'),
(1, 'prmA00'),
(1, 'prmA02'),
(1, 'prmA04'),
(13, 'prmA00'),
(13, 'prmA01'),
(13, 'prmA02'),
(13, 'prmA03'),
(13, 'prmA04'),
(11, 'prmA01'),
(11, 'prmA02'),
(11, 'prmA03'),
(11, 'prmA04');

-- --------------------------------------------------------

--
-- 資料表結構 `rel_vendor_permissions`
--

CREATE TABLE `rel_vendor_permissions` (
  `vaId` int(10) NOT NULL,
  `vaPermissionId` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `rel_vendor_permissions`
--

INSERT INTO `rel_vendor_permissions` (`vaId`, `vaPermissionId`) VALUES
(150, 'prmV00'),
(150, 'prmV01'),
(150, 'prmV02'),
(150, 'prmV03'),
(150, 'prmV04'),
(152, 'prmV00'),
(152, 'prmV01'),
(152, 'prmV02'),
(152, 'prmV03'),
(152, 'prmV04'),
(153, 'prmV00'),
(153, 'prmV01'),
(153, 'prmV02'),
(153, 'prmV03'),
(153, 'prmV04'),
(151, 'prmV01'),
(151, 'prmV02'),
(151, 'prmV03'),
(151, 'prmV04');

-- --------------------------------------------------------

--
-- 資料表結構 `vendorAdmins`
--

CREATE TABLE `vendorAdmins` (
  `vaId` int(10) NOT NULL,
  `vId` int(10) DEFAULT NULL COMMENT '廠商',
  `vaRoleId` int(10) NOT NULL,
  `vaFName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名字',
  `vaLName` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '姓氏',
  `vaEmail` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaPassword` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaActive` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vaVerify` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT current_timestamp() COMMENT '驗證',
  `vaHash` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vaLogoutTime` datetime DEFAULT NULL,
  `vaLoginTime` datetime DEFAULT NULL,
  `vaNotes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `vendorAdmins`
--

INSERT INTO `vendorAdmins` (`vaId`, `vId`, `vaRoleId`, `vaFName`, `vaLName`, `vaEmail`, `vaPassword`, `vaActive`, `vaVerify`, `vaHash`, `vaLogoutTime`, `vaLoginTime`, `vaNotes`, `created_at`, `updated_at`) VALUES
(150, 52, 1, 'VICKY', NULL, 'vickysun2@hotmail.com', 'e79cab55eab4c0a1a63610829a51fd51d5cfb294', 'active', 'verified', 'd64a340bcb633f536d56e51874281454', '2020-01-22 07:11:39', '2020-01-22 07:55:57', NULL, '2020-01-21 15:52:22', '2020-01-21 15:52:22'),
(151, 52, 3, 'fall', 'night', 'nightfallvs0923@gmail.com', 'c52888225c6929961bb5fdd4c51fe46c239d9e11', 'active', 'verified', '16c222aa19898e5058938167c8ab6c57', '2020-01-22 06:50:59', '2020-01-22 06:50:11', 'okey dokey', '2020-01-21 16:06:23', '2020-01-21 16:06:23'),
(152, 52, 2, 'radu', 'rider', 'radu000rider@gmail.com', 'bc7cafbd1f9bcb7a3065a603b98d5c45e60c67d9', 'active', 'verified', 'dd8eb9f23fbd362da0e3f4e70b878c16', '2020-01-22 00:43:22', '2020-01-22 00:27:49', '', '2020-01-21 16:11:18', '2020-01-21 16:11:18'),
(153, 53, 1, 'NIGHT', NULL, 'nightfallvs0923@gmail.com', '1be2a44cb53dde903be8466c08dee9067da8ede3', 'active', 'verified', 'f1c1592588411002af340cbaedd6fc33', '2020-01-22 07:11:01', '2020-01-22 07:11:47', NULL, '2020-01-21 17:08:33', '2020-01-21 17:08:33');

-- --------------------------------------------------------

--
-- 資料表結構 `vendorPermissions`
--

CREATE TABLE `vendorPermissions` (
  `vendorPrmId` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendorPrmName` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `vendorPermissions`
--

INSERT INTO `vendorPermissions` (`vendorPrmId`, `vendorPrmName`) VALUES
('prmV00', 'admin'),
('prmV01', 'products'),
('prmV02', 'charts'),
('prmV03', 'marketing'),
('prmV04', 'orders');

-- --------------------------------------------------------

--
-- 資料表結構 `vendorResetPass`
--

CREATE TABLE `vendorResetPass` (
  `vaEmail` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaToken` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaHash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vaExpireDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `vendorRoles`
--

CREATE TABLE `vendorRoles` (
  `vaRoleId` int(10) NOT NULL,
  `vaRoleName` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `vendorRoles`
--

INSERT INTO `vendorRoles` (`vaRoleId`, `vaRoleName`) VALUES
(1, 'Owner'),
(2, 'Manager'),
(3, 'Staff');

-- --------------------------------------------------------

--
-- 資料表結構 `vendors`
--

CREATE TABLE `vendors` (
  `vId` int(10) NOT NULL,
  `vName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vEmail` varchar(254) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vInfo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vImg` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vActive` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vVerify` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT current_timestamp() COMMENT '驗證',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `vendors`
--

INSERT INTO `vendors` (`vId`, `vName`, `vEmail`, `vInfo`, `vImg`, `vActive`, `vVerify`, `created_at`, `updated_at`) VALUES
(52, 'VICKY', 'vickysun2@hotmail.com', 'test img', '20200122060317.jpg', 'active', 'verified', '2020-01-21 15:52:22', '2020-01-21 15:52:22'),
(53, 'NIGHT', 'nightfallvs0923@gmail.com', '', NULL, 'active', 'verified', '2020-01-21 17:08:33', '2020-01-21 17:08:33');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `platformAdmins`
--
ALTER TABLE `platformAdmins`
  ADD PRIMARY KEY (`aId`);

--
-- 資料表索引 `platformPermissions`
--
ALTER TABLE `platformPermissions`
  ADD PRIMARY KEY (`adminPrmId`);

--
-- 資料表索引 `platformRoles`
--
ALTER TABLE `platformRoles`
  ADD PRIMARY KEY (`aRoleId`);

--
-- 資料表索引 `vendorAdmins`
--
ALTER TABLE `vendorAdmins`
  ADD PRIMARY KEY (`vaId`);

--
-- 資料表索引 `vendorPermissions`
--
ALTER TABLE `vendorPermissions`
  ADD PRIMARY KEY (`vendorPrmId`);

--
-- 資料表索引 `vendorRoles`
--
ALTER TABLE `vendorRoles`
  ADD PRIMARY KEY (`vaRoleId`);

--
-- 資料表索引 `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vId`),
  ADD UNIQUE KEY `vEmail` (`vEmail`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `platformAdmins`
--
ALTER TABLE `platformAdmins`
  MODIFY `aId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `platformRoles`
--
ALTER TABLE `platformRoles`
  MODIFY `aRoleId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vendorAdmins`
--
ALTER TABLE `vendorAdmins`
  MODIFY `vaId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vendorRoles`
--
ALTER TABLE `vendorRoles`
  MODIFY `vaRoleId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
