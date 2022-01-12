/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : tdk

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 12/01/2022 12:52:53
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ecms_admin
-- ----------------------------
DROP TABLE IF EXISTS `ecms_admin`;
CREATE TABLE `ecms_admin`  (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `uptime` datetime NULL DEFAULT NULL,
  `num` int(11) NULL DEFAULT NULL,
  `kill` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `out_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_admin
-- ----------------------------
INSERT INTO `ecms_admin` VALUES (1, 'admin', '$2y$10$.0tRO1ROLvwFwCMzDnto8Oc1e.EKnuOzqrPfJXlHyfAZTPZUx5PxO', '127.0.0.1', '2021-03-18 14:25:41', 999, 'bob|博彩|娱乐|赌场|游戏|欧洲杯|半决赛|竞猜|竞彩|赛事|欧冠|球迷|决赛|彩票|无码|波多野结衣|直播|无法访问|体育|欧宝|私服|世界杯|足球|电竞|足球|联赛|国产亚洲|404|403', '2021-08-30 13:51:53');

-- ----------------------------
-- Table structure for ecms_article
-- ----------------------------
DROP TABLE IF EXISTS `ecms_article`;
CREATE TABLE `ecms_article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `del` int(255) NULL DEFAULT 0,
  `top` int(255) NULL DEFAULT 0,
  `log` int(255) NULL DEFAULT NULL,
  `type` int(255) NULL DEFAULT NULL,
  `server` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `uid` int(11) NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `create_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ecms_article
-- ----------------------------
INSERT INTO `ecms_article` VALUES (2, '宝塔面板', 'bt.cn', 0, 0, 10, 1, '1', NULL, '2022-01-12 12:44:58', '2022-01-12 12:44:58');

-- ----------------------------
-- Table structure for ecms_mod
-- ----------------------------
DROP TABLE IF EXISTS `ecms_mod`;
CREATE TABLE `ecms_mod`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `upid` int(11) NULL DEFAULT NULL,
  `upid_all` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `top` int(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 159 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_mod
-- ----------------------------
INSERT INTO `ecms_mod` VALUES (1, '优化站', 3, '[0][3]', 0);
INSERT INTO `ecms_mod` VALUES (2, '非优化站', 3, '[0][3]', 0);
INSERT INTO `ecms_mod` VALUES (3, '默认分类', 0, '[0]', 75);

-- ----------------------------
-- Table structure for ecms_run_log
-- ----------------------------
DROP TABLE IF EXISTS `ecms_run_log`;
CREATE TABLE `ecms_run_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NULL DEFAULT NULL,
  `create_time` datetime NULL DEFAULT NULL,
  `t` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `d` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `k` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `error` int(255) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ecms_run_log
-- ----------------------------
INSERT INTO `ecms_run_log` VALUES (10, 2, '2022-01-12 12:51:56', '宝塔面板 - 简单好用的Linux/Windows服务器运维管理面板', 'LAMP/LNMP一键安装包,运维,服务器运维,免费主机管理系统,linux面板,windows面板,堡塔云控平台,宝塔', '宝塔，让运维简单高效。面板支持Linux与Windows系统。一键配置：LAMP/LNMP、网站、数据库、FTP、SSL，通过Web端轻松管理服务器。', 0);

-- ----------------------------
-- Table structure for ecms_system
-- ----------------------------
DROP TABLE IF EXISTS `ecms_system`;
CREATE TABLE `ecms_system`  (
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `as` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `top` int(255) NULL DEFAULT 0,
  `view` int(255) NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_system
-- ----------------------------
INSERT INTO `ecms_system` VALUES ('web_keywords', 'EFRPC内网映射', 'K', NULL, 0);
INSERT INTO `ecms_system` VALUES ('web_description', 'EFRPC内网映射', 'D', NULL, 0);
INSERT INTO `ecms_system` VALUES ('web_title', 'EFRPC内网映射', 'T', NULL, 0);
INSERT INTO `ecms_system` VALUES ('company', 'TDK巡逻狗Pro', '站点名称', 0, 1);
INSERT INTO `ecms_system` VALUES ('info', '抓取TDK前，建议将本站IP加入服务器白名单，防止被墙。\r\rby马牛逼', '站点信息', 0, 1);

SET FOREIGN_KEY_CHECKS = 1;
