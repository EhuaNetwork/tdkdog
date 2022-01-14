/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : tp_cn

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 14/01/2022 08:10:36
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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_admin
-- ----------------------------
INSERT INTO `ecms_admin` VALUES (1, 'admin', '$2y$10$kMHsEVXp8b3iibXwSFG28ut09hZLATejuEdl34FfeoDT2AX43ku9C', '127.0.0.1', '2021-03-18 14:25:41');

-- ----------------------------
-- Table structure for ecms_article
-- ----------------------------
DROP TABLE IF EXISTS `ecms_article`;
CREATE TABLE `ecms_article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '新闻表',
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `body` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `create_time` datetime NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `status` int(3) NULL DEFAULT 1,
  `view` int(255) NULL DEFAULT 0,
  `top` int(255) NULL DEFAULT 0,
  `d` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `k` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `t` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_article
-- ----------------------------

-- ----------------------------
-- Table structure for ecms_banner
-- ----------------------------
DROP TABLE IF EXISTS `ecms_banner`;
CREATE TABLE `ecms_banner`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `img` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `img2` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_banner
-- ----------------------------

-- ----------------------------
-- Table structure for ecms_echo
-- ----------------------------
DROP TABLE IF EXISTS `ecms_echo`;
CREATE TABLE `ecms_echo`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '外部用户表单',
  `area` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '面积',
  `budget` decimal(65, 2) NULL DEFAULT NULL COMMENT '预算',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `phone`(`phone`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_echo
-- ----------------------------

-- ----------------------------
-- Table structure for ecms_link
-- ----------------------------
DROP TABLE IF EXISTS `ecms_link`;
CREATE TABLE `ecms_link`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` int(1) NULL DEFAULT 1,
  `top` int(255) NULL DEFAULT 0,
  `create_time` datetime NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_link
-- ----------------------------

-- ----------------------------
-- Table structure for ecms_mod
-- ----------------------------
DROP TABLE IF EXISTS `ecms_mod`;
CREATE TABLE `ecms_mod`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `m` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` int(255) NULL DEFAULT NULL,
  `upid` int(11) NULL DEFAULT NULL,
  `c` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `a` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `upid_all` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `top` int(255) NULL DEFAULT NULL,
  `is_nav` int(255) NULL DEFAULT 1,
  `nourl` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `t` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `d` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `k` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 155 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_mod
-- ----------------------------
INSERT INTO `ecms_mod` VALUES (1, '网站首页', 'index', 1, 0, 'index', 'index', '[0]', 90, 1, '/', NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (2, '关于我们', 'index', 1, 0, 'about', 'info', '[0]', 80, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (3, '产品展示', 'index', 2, 0, 'pro', 'index', '[0]', 75, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (4, '新闻资讯', 'index', 2, 0, 'news', 'index', '[0]', 70, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (6, '联系我们', 'index', 2, 0, 'about', 'link', '[0]', 30, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (93, '公司新闻', 'index', 2, 4, 'news', 'index', '[0][4]', 0, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (94, '行业新闻', 'index', 2, 4, 'news', 'index', '[0][4]', 0, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (152, '分类一', 'index', 2, 3, 'pro', 'index', '[0][3]', 0, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (153, '分类二', 'index', 2, 3, 'pro', 'index', '[0][3]', 0, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ecms_mod` VALUES (154, '分类三', 'index', 2, 3, 'pro', 'index', '[0][3]', 0, 1, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for ecms_system
-- ----------------------------
DROP TABLE IF EXISTS `ecms_system`;
CREATE TABLE `ecms_system`  (
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `as` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `top` int(255) NULL DEFAULT 0
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of ecms_system
-- ----------------------------
INSERT INTO `ecms_system` VALUES ('company', 'Ecms建站系统', '公司名称', NULL);
INSERT INTO `ecms_system` VALUES ('address', '中国 烟台', '联系地址', NULL);
INSERT INTO `ecms_system` VALUES ('mail', ' admin@admin.com', '联系邮箱', NULL);
INSERT INTO `ecms_system` VALUES ('info', '公司简介...', '公司简介', NULL);
INSERT INTO `ecms_system` VALUES ('web_keywords', 'Ecms建站系统', 'K', NULL);
INSERT INTO `ecms_system` VALUES ('web_description', 'Ecms建站系统', 'D', NULL);
INSERT INTO `ecms_system` VALUES ('web_title', 'Ecms建站系统', 'T', NULL);
INSERT INTO `ecms_system` VALUES ('link_phone', '188-8888-888', '联系电话', NULL);
INSERT INTO `ecms_system` VALUES ('icp', '鲁ICP备xxxxxxx号', '备案信息', NULL);
INSERT INTO `ecms_system` VALUES ('map', '121.004258,37.663399', '地图坐标', 0);
INSERT INTO `ecms_system` VALUES ('link_name', '马牛逼', '联系人', 0);
INSERT INTO `ecms_system` VALUES ('link_tel', '188-8888-888', '电话', 0);

-- ----------------------------
-- Table structure for ecms_user
-- ----------------------------
DROP TABLE IF EXISTS `ecms_user`;
CREATE TABLE `ecms_user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime NULL DEFAULT NULL,
  `money` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ecms_user
-- ----------------------------

-- ----------------------------
-- Table structure for ecms_view
-- ----------------------------
DROP TABLE IF EXISTS `ecms_view`;
CREATE TABLE `ecms_view`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `source` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `create_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ecms_view
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
