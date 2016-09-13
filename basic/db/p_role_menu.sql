/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : p_db

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-09-13 19:20:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for p_role_menu
-- ----------------------------
DROP TABLE IF EXISTS `p_role_menu`;
CREATE TABLE `p_role_menu` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `menu_id` bigint(11) NOT NULL COMMENT '菜单id',
  `role_id` bigint(11) NOT NULL COMMENT '权限id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='权限与菜单关系表';

-- ----------------------------
-- Records of p_role_menu
-- ----------------------------
INSERT INTO `p_role_menu` VALUES ('1', '1', '2', '0000-00-00 00:00:00');
INSERT INTO `p_role_menu` VALUES ('2', '8', '2', '0000-00-00 00:00:00');
INSERT INTO `p_role_menu` VALUES ('3', '1', '3', '0000-00-00 00:00:00');
INSERT INTO `p_role_menu` VALUES ('4', '11', '3', '0000-00-00 00:00:00');
INSERT INTO `p_role_menu` VALUES ('5', '12', '3', '0000-00-00 00:00:00');
