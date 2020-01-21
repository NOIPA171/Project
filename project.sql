-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- 主機： localhost
-- 產生時間： 2020 年 01 月 21 日 15:36
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

-- --------------------------------------------------------

--
-- 資料表結構 `platformPermissions`
--

CREATE TABLE `platformPermissions` (
  `adminPrmId` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adminPrmName` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- 資料表結構 `rel_vendor_permissions`
--

CREATE TABLE `rel_vendor_permissions` (
  `vaId` int(10) NOT NULL,
  `vaPermissionId` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- 資料表結構 `vendorPermissions`
--

CREATE TABLE `vendorPermissions` (
  `vendorPrmId` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendorPrmName` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `aId` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vendorAdmins`
--
ALTER TABLE `vendorAdmins`
  MODIFY `vaId` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vId` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
