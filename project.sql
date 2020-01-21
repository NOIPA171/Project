-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2020 年 01 月 21 日 16:02
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

INSERT INTO `platformAdmins` (`aId`, `aFName`, `aLName`, `aEmail`, `aPassword`, `aActive`, `aVerify`, `aHash`, `aNotes`, `aLogoutTime`, `aLoginTime`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'vickysun2@hotmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'active', 'verified', '', 'asdf', '2020-01-20 20:23:32', '2020-01-20 20:14:39', '2020-01-15 04:01:20', '2020-01-15 04:01:20'),
(5, 'test', 'limited', 'limited@limited.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'active', 'verified', '2ab56412b1163ee131e1246da0955bd1', 'asdf', '2020-01-20 13:45:17', '2020-01-20 13:44:24', '2020-01-20 04:09:31', '2020-01-20 04:09:31'),
(6, 'test', 'all', 'all@all.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'active', '2020-01-20 12:10:17', '6c524f9d5d7027454a783c841250ba71', 'I give you all access', NULL, '2020-01-20 13:45:41', '2020-01-20 04:10:17', '2020-01-20 04:10:17'),
(7, 'vvv', 'vvv', 'test@test.com', '1c19ce439c9beaf3fde4452dcf9781928e9b6946', 'inactive', '2020-01-20 12:25:38', 'fa83a11a198d5a7f0bf77a1987bcd006', 'test', NULL, NULL, '2020-01-20 04:25:38', '2020-01-20 04:25:38'),
(8, 'a', 'a', 'qwer@qwer.com', '46494cce673f7314dc366b3968cc6c10b5bbd63d', 'inactive', '2020-01-20 12:27:04', '087408522c31eeb1f982bc0eaf81d35f', '', NULL, NULL, '2020-01-20 04:27:04', '2020-01-20 04:27:04');

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
  `aExpireDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(6, 'prmA00'),
(6, 'prmA01'),
(6, 'prmA02'),
(6, 'prmA03'),
(6, 'prmA04'),
(7, 'prmA01'),
(7, 'prmA02'),
(7, 'prmA03'),
(7, 'prmA04'),
(8, 'prmA01'),
(8, 'prmA02'),
(8, 'prmA03'),
(8, 'prmA04'),
(1, 'prmA01'),
(1, 'prmA03'),
(1, 'prmA00'),
(5, 'prmA03'),
(5, 'prmA04');

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
(145, 'prmV00'),
(145, 'prmV01'),
(145, 'prmV02'),
(145, 'prmV03'),
(145, 'prmV04');

-- --------------------------------------------------------

--
-- 資料表結構 `vendorAdmins`
--

CREATE TABLE `vendorAdmins` (
  `vaId` int(10) NOT NULL,
  `vId` int(10) DEFAULT NULL COMMENT '廠商',
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

INSERT INTO `vendorAdmins` (`vaId`, `vId`, `vaFName`, `vaLName`, `vaEmail`, `vaPassword`, `vaActive`, `vaVerify`, `vaHash`, `vaLogoutTime`, `vaLoginTime`, `vaNotes`, `created_at`, `updated_at`) VALUES
(145, 51, 'VICKY', NULL, 'vickysun2@hotmail.com', 'e79cab55eab4c0a1a63610829a51fd51d5cfb294', 'active', 'verified', 'bbf94b34eb32268ada57a3be5062fe7d', '2020-01-21 15:56:58', '2020-01-21 15:57:05', NULL, '2020-01-21 07:56:08', '2020-01-21 07:56:08');

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
(51, 'VICKY', 'vickysun2@hotmail.com', NULL, NULL, 'active', 'verified', '2020-01-21 07:56:08', '2020-01-21 07:56:08');

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
  MODIFY `aId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vendorAdmins`
--
ALTER TABLE `vendorAdmins`
  MODIFY `vaId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
