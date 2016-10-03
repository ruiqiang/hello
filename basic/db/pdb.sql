SET SESSION FOREIGN_KEY_CHECKS=0;

/* Drop Tables */

DROP TABLE IF EXISTS p_adv;
DROP TABLE IF EXISTS p_check;
DROP TABLE IF EXISTS p_check_control;
DROP TABLE IF EXISTS p_community;
DROP TABLE IF EXISTS p_company;
DROP TABLE IF EXISTS p_customer;
DROP TABLE IF EXISTS p_group;
DROP TABLE IF EXISTS p_menu;
DROP TABLE IF EXISTS p_message;
DROP TABLE IF EXISTS p_model;
DROP TABLE IF EXISTS p_role;
DROP TABLE IF EXISTS p_role_menu;
DROP TABLE IF EXISTS p_sales;
DROP TABLE IF EXISTS p_sales_adv;
DROP TABLE IF EXISTS p_sector;
DROP TABLE IF EXISTS p_staff;
DROP TABLE IF EXISTS p_staff_role;
DROP TABLE IF EXISTS p_task;
DROP TABLE IF EXISTS p_task_accept;




/* Create Tables */

CREATE TABLE p_adv
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	adv_id bigint(11) NOT NULL,
	-- 为p_community表主键
	adv_community_id bigint(11) NOT NULL COMMENT '为p_community表主键',
	-- 若广告位正在使用，则显示客户名称
	adv_name varchar(50) COMMENT '若广告位正在使用，则显示客户名称',
	-- 位置描述
	adv_position varchar(255) NOT NULL COMMENT '位置描述',
	adv_starttime datetime,
	adv_endtime datetime,
	adv_image varchar(255),
	-- 0.电梯广告
	-- 1.道闸广告
	-- 2.道杆广告
	-- 3.灯箱
	-- 4.行人门禁
	adv_property int(2) NOT NULL COMMENT '0.电梯广告
1.道闸广告
2.道杆广告
3.灯箱
4.行人门禁',
	-- p_model主键
	model_id binary(11) COMMENT 'p_model主键',
	-- 从p_model表中获得
	adv_model varchar(20) COMMENT '从p_model表中获得',
	-- 0:未安装
	-- 1.待维修（损坏）
	-- 2.正常使用
	adv_install_status int(2) COMMENT '0:未安装
1.待维修（损坏）
2.正常使用',
	-- 0.新增
	-- 1.未使用
	-- 2.已使用
	adv_use_status int(2) COMMENT '0.新增
1.未使用
2.已使用',
	-- 0.销售
	-- 1.赠送
	-- 2.置换
	adv_sales_status int(2) COMMENT '0.销售
1.赠送
2.置换',
	-- 0.预定
	-- 1.待上刊
	-- 2.已上刊
	-- 3.待下刊
	-- 4.已下刊
	adv_pic_status int(2) COMMENT '0.预定
1.待上刊
2.已上刊
3.待下刊
4.已下刊',
	adv_note varchar(500),
	-- 0.无需审核
	-- 1.待审核
	-- 2.审核中
	-- 3.审核通过
	-- 4.审核未通过
	adv_status int(2) COMMENT '0.无需审核
1.待审核
2.审核中
3.审核通过
4.审核未通过',
	company_id bigint(11) NOT NULL,
	-- 0.否
	-- 1.是
	is_delete int(2) COMMENT '0.否
1.是',
	creator bigint(11),
	create_time datetime NOT NULL,
	updater bigint(11),
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_check
(
	id bigint(11) NOT NULL,
	-- 0.楼盘信息（p_community）
	-- 1.广告位表（p_adv）
	-- 2.设备型号表(p_model)
	-- 3.任务分配表(p_task)
	check_info int(2) NOT NULL COMMENT '0.楼盘信息（p_community）
1.广告位表（p_adv）
2.设备型号表(p_model)
3.任务分配表(p_task)',
	-- 为p_staff人员表主键
	staff_id bigint(11) NOT NULL COMMENT '为p_staff人员表主键',
	-- 分别为p_community、p_adv、p_model、p_task的主键
	check_id bigint(11) NOT NULL COMMENT '分别为p_community、p_adv、p_model、p_task的主键',
	-- 0.不通过
	-- 1.通过
	check_status int(2) NOT NULL COMMENT '0.不通过
1.通过',
	create_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_check_control
(
	id bigint(11) NOT NULL,
	-- 公司（p_company）主键
	company_id bigint(11) NOT NULL COMMENT '公司（p_company）主键',
	-- 0.不需要
	-- 1.需要（默认）
	control_community int(2) COMMENT '0.不需要
1.需要（默认）',
	-- 0.不需要（默认）
	-- 1.需要
	control_adv int(2) COMMENT '0.不需要（默认）
1.需要',
	-- 0.不需要
	-- 1.需要（默认）
	control_model int(2) COMMENT '0.不需要
1.需要（默认）',
	updater bigint(11),
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_community
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	community_id bigint(11) NOT NULL,
	community_name varchar(100) NOT NULL,
	community_position varchar(255) NOT NULL,
	community_category varchar(100),
	community_level varchar(50),
	community_price varchar(20),
	community_cbd varchar(100) NOT NULL,
	-- 0.新建楼盘
	-- 1.老楼盘
	-- 2.改造楼盘
	community_nature int(2) COMMENT '0.新建楼盘
1.老楼盘
2.改造楼盘',
	community_opentime datetime NOT NULL,
	community_staytime datetime NOT NULL,
	community_units int(6) NOT NULL,
	community_households int(6) NOT NULL,
	community_taboos varchar(255),
	community_longitudex varchar(50),
	community_latitudey varchar(50),
	community_traffic varchar(255),
	community_facility varchar(255),
	-- 默认最多上传3张照片
	community_image1 varchar(255) COMMENT '默认最多上传3张照片',
	community_image2 varchar(255),
	community_image3 varchar(255),
	community_note varchar(500),
	-- 0.无需审核
	-- 1.待审核
	-- 2.审核中
	-- 3.审核通过
	-- 4.审核未通过
	community_status int(2) COMMENT '0.无需审核
1.待审核
2.审核中
3.审核通过
4.审核未通过',
	company_id binary(11) NOT NULL,
	-- 0.否
	-- 1.是
	is_delete int(2) COMMENT '0.否
1.是',
	creator bigint(11),
	create_time datetime,
	updater bigint(11),
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_company
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	company_name varchar(50) NOT NULL,
	-- 领域包括：
	-- 电梯框架 电梯门 灯箱 道闸 倒杆 广告牌
	-- 不同的公司可能制作某几个领域，即可多选
	company_field int(2) COMMENT '领域包括：
电梯框架 电梯门 灯箱 道闸 倒杆 广告牌
不同的公司可能制作某几个领域，即可多选',
	staff_number int,
	create_time datetime NOT NULL,
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_customer
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	customer_company varchar(100) NOT NULL,
	customer_address varchar(255) NOT NULL,
	-- 即客户姓名
	customer_contact varchar(20) NOT NULL COMMENT '即客户姓名',
	customer_phone varchar(50),
	customer_email varchar(100),
	customer_industry varchar(50) NOT NULL,
	-- 对应为该客户服务的公司
	company_id binary(11) NOT NULL COMMENT '对应为该客户服务的公司',
	creator binary(11),
	create_time datetime,
	updater bigint(11),
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_group
(
	id bigint(11) NOT NULL,
	group_name varchar(100) NOT NULL,
	-- 可存储多人的id
	staff_ids varchar(50) NOT NULL COMMENT '可存储多人的id',
	-- 当前只支持所有组员在一个部门中
	staff_sector bigint(11) COMMENT '当前只支持所有组员在一个部门中',
	company_id bigint(11) NOT NULL,
	-- 0.否
	-- 1.是
	is_delete int(2) COMMENT '0.否
1.是',
	updator bigint(11),
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_menu
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	menu_name varchar(50) NOT NULL,
	menu_url varchar(255) NOT NULL,
	parent_id bigint(11) NOT NULL,
	-- 0 => 系统主菜单
	-- 1 => 模块菜单
	menu_level int(1) NOT NULL COMMENT '0 => 系统主菜单
1 => 模块菜单',
	menu_note varchar(255),
	create_time datetime NOT NULL,
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


-- 适用于p_community、p_adv、p_model
CREATE TABLE p_message
(
	id bigint(11) NOT NULL,
	company_id bigint(11) NOT NULL,
	-- 消息内容根据添加的内容不同而自动生成
	message_content varchar(255) COMMENT '消息内容根据添加的内容不同而自动生成',
	create_time datetime,
	PRIMARY KEY (id)
) COMMENT = '适用于p_community、p_adv、p_model';


CREATE TABLE p_model
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	model_id varchar(50) NOT NULL,
	model_name varchar(20),
	model_category varchar(50) NOT NULL,
	model_desc varchar(255),
	model_size varchar(25),
	model_display varchar(25),
	model_factory varchar(100),
	model_use varchar(255),
	model_note varchar(500),
	-- 0.无需审核
	-- 1.待审核
	-- 2.审核中
	-- 3.审核通过
	-- 4.审核未通过
	model_status int(2) COMMENT '0.无需审核
1.待审核
2.审核中
3.审核通过
4.审核未通过',
	company_id bigint(11),
	-- 0.否
	-- 1.是
	is_delete int(2) COMMENT '0.否
1.是',
	creator bigint(11),
	create_time datetime,
	updater bigint(11),
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_role
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	role_name varchar(50) NOT NULL,
	role_code varchar(20) NOT NULL,
	create_time datetime NOT NULL,
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_role_menu
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	menu_id bigint(11) NOT NULL,
	role_id bigint(11) NOT NULL,
	create_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_sales
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	sales_community_id bigint(11),
	-- 为p_adv表主键
	adv_di bigint(11) COMMENT '为p_adv表主键',
	sales_customer varchar(50),
	sales_company bigint(100),
	sales_starttime datetime,
	sales_endtime datetime,
	sales_person varchar(100),
	-- 0.待销售
	-- 1.预定
	-- 2.已销售
	sales_status int(2) COMMENT '0.待销售
1.预定
2.已销售',
	sales_note varchar(500),
	company_id bigint(11),
	create_time datetime,
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_sales_adv
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	sales_id bigint(11) NOT NULL,
	adv_id bigint(11),
	company_id bigint(11),
	create_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_sector
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	company_id bigint(11) NOT NULL,
	sector_name varchar(50) NOT NULL,
	sector_financial_no varchar(30),
	sector_level int(2),
	sector_count int(4),
	sector_fid bigint(11),
	sector_order_no int(4),
	sector_sid bigint(11),
	sector_city varchar(20),
	create_time datetime NOT NULL,
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_staff
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	-- 也是登录帐号
	staff_name varchar(20) NOT NULL COMMENT '也是登录帐号',
	password varchar(255) NOT NULL,
	staff_level int(11),
	staff_aids_id bigint(11),
	staff_no bigint(10),
	staff_in datetime,
	staff_workplace varchar(100),
	-- p_company表主键
	company_id bigint(11) NOT NULL COMMENT 'p_company表主键',
	staff_sector bigint(11),
	staff_position varchar(50),
	staff_phone bigint(11),
	staff_email varchar(30),
	staff_lastlogin datetime,
	staff_logintime datetime,
	-- 0.否
	-- 1.是
	is_super int(2) COMMENT '0.否
1.是',
	-- 0.否
	-- 1.是
	is_delete int(2) COMMENT '0.否
1.是',
	create_time datetime NOT NULL,
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_staff_role
(
	id bigint(11) NOT NULL AUTO_INCREMENT,
	role_id bigint(11) NOT NULL,
	staff_id bigint(11),
	create_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_task
(
	id bigint(11) NOT NULL,
	-- 0.安装
	-- 1.维修
	-- 2.拆除
	task_category int(2) COMMENT '0.安装
1.维修
2.拆除',
	-- 显示相应的广告位信息、楼盘信息
	adv_id bigint(11) COMMENT '显示相应的广告位信息、楼盘信息',
	-- 显示相应的设备信息
	model_id bigint(11) COMMENT '显示相应的设备信息',
	-- 显示相应的安装人员
	group_id bigint(11) COMMENT '显示相应的安装人员',
	-- 0.未开始
	-- 1.进行中
	-- 3.已完成
	task_status int(2) COMMENT '0.未开始
1.进行中
3.已完成',
	-- 0.未上刊
	-- 1.上刊中
	-- 2.已上刊
	task_adv_status int(2) COMMENT '0.未上刊
1.上刊中
2.已上刊',
	task_deadline datetime,
	task_note varchar(500),
	company_id bigint(11),
	-- 0.否
	-- 1.是
	is_delete int(2) COMMENT '0.否
1.是',
	creator bigint(11),
	create_time datetime,
	updater bigint(11),
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_task_accept
(
	id bigint(11) NOT NULL,
	-- p_task主键
	task_id bigint(11) COMMENT 'p_task主键',
	-- p_staff主键
	staff_id bigint(11) COMMENT 'p_staff主键',
	-- 0.未受理
	-- 1.已受理
	-- 2.已完成（任务完成后自动更新为该状态）
	accept_status int(2) COMMENT '0.未受理
1.已受理
2.已完成（任务完成后自动更新为该状态）',
	create_time datetime,
	accept_time datetime,
	-- 任务完成后自动生成
	complete_time datetime COMMENT '任务完成后自动生成',
	PRIMARY KEY (id)
);



