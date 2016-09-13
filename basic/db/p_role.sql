/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : p_db

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-09-13 19:20:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for p_role
-- ----------------------------
DROP TABLE IF EXISTS `p_role`;
CREATE TABLE `p_role` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `role_name` varchar(50) NOT NULL COMMENT '权限名称',
  `role_code` varchar(20) NOT NULL COMMENT '权限编码',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of p_role
-- ----------------------------
INSERT INTO `p_role` VALUES ('1', '超级管理员', 'xadmin', '2016-09-12 15:51:35', '2016-09-12 15:51:37');
INSERT INTO `p_role` VALUES ('2', 'admin', 'sadmin', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_role` VALUES ('3', 'staff', 'xstaff', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
