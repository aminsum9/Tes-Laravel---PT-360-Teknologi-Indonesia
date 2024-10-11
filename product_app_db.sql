/*
 Navicat Premium Data Transfer

 Source Server         : Local Database
 Source Server Type    : MySQL
 Source Server Version : 80200 (8.2.0)
 Source Host           : localhost:3306
 Source Schema         : product_app_db

 Target Server Type    : MySQL
 Target Server Version : 80200 (8.2.0)
 File Encoding         : 65001

 Date: 10/10/2024 21:34:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for Price
-- ----------------------------
DROP TABLE IF EXISTS `Price`;
CREATE TABLE `Price` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Product_Id` int DEFAULT NULL,
  `Unit` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Product_Id_Ref_Product` (`Product_Id`),
  CONSTRAINT `Product_Id_Ref_Product` FOREIGN KEY (`Product_Id`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Table structure for PriceDetail
-- ----------------------------
DROP TABLE IF EXISTS `PriceDetail`;
CREATE TABLE `PriceDetail` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Price_Id` int DEFAULT NULL,
  `Tier` varchar(50) DEFAULT NULL,
  `Price` int DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Price_Id_Ref_Price` (`Price_Id`),
  CONSTRAINT `Price_Id_Ref_Price` FOREIGN KEY (`Price_Id`) REFERENCES `Price` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Table structure for Product
-- ----------------------------
DROP TABLE IF EXISTS `Product`;
CREATE TABLE `Product` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(150) DEFAULT NULL,
  `Product_Category` varchar(50) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

SET FOREIGN_KEY_CHECKS = 1;
