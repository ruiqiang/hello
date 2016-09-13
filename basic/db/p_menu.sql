/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : p_db

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-09-13 19:20:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for p_menu
-- ----------------------------
DROP TABLE IF EXISTS `p_menu`;
CREATE TABLE `p_menu` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `menu_name` varchar(50) NOT NULL COMMENT '菜单名称',
  `menu_url` varchar(255) NOT NULL COMMENT '菜单地址',
  `parent_id` bigint(11) NOT NULL COMMENT '父级id',
  `menu_level` int(1) NOT NULL COMMENT '菜单级别 : 0 => 系统主菜单\r\n1 => 模块菜单',
  `menu_note` varchar(255) DEFAULT NULL COMMENT '菜单备注',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of p_menu
-- ----------------------------
INSERT INTO `p_menu` VALUES ('1', '控制台', '/admin/index', '0', '1', '主页面', '2016-09-12 15:56:47', '2016-09-12 15:56:49');
INSERT INTO `p_menu` VALUES ('2', '企业管理', '/', '0', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('3', '客户管理', '/admin/customer/manager', '0', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('4', '小区管理', '/admin/community/manager', '0', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('5', '广告店管理', '/admin/adv/manager', '0', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('6', '流程中心', '/', '0', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('7', '权限管理', '/', '0', '1', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('8', '部门管理', '/admin/company/sectormanager', '2', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('9', '员工管理', '/admin/company/staffmanager', '2', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('10', '开发', '/admin/flow/devmanager', '6', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('11', '销售', '/admin/flow/salemanager', '6', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('12', '维修', '/admin/flow/maintainmanager', '6', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('13', '用户管理', '/admin/auth/usermanager', '7', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('14', '角色管理', '/admin/auth/rolemanager', '7', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('15', '菜单管理', '/admin/auth/menumanager', '7', '2', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `p_menu` VALUES ('16', '一个菜单', '/admin', '2', '2', null, '2016-09-13 10:47:25', '2016-09-13 10:47:25');
INSERT INTO `p_menu` VALUES ('17', '一个三级菜单', '/admin/T', '16', '3', null, '2016-09-13 10:47:41', '2016-09-13 10:47:41');
