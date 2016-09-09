SET SESSION FOREIGN_KEY_CHECKS=0;


/* Create Tables */

CREATE TABLE p_staff
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	staff_name varchar(20) NOT NULL COMMENT '员工姓名',
	staff_level int(11) COMMENT '员工等级',
	staff_aids_id bigint(11) COMMENT '员工助理id',
	staff_no bigint(10) NOT NULL COMMENT '员工工号',
	staff_in datetime COMMENT '员工入职时间',
	staff_workplace varchar(100) COMMENT '员工工作地',
	staff_sector bigint(11) COMMENT '员工部门',
	staff_position varchar(50) COMMENT '员工职位',
	staff_phone bigint(11) COMMENT '员工手机号码',
	staff_email varchar(30) COMMENT '员工邮件',
	staff_lastlogin datetime COMMENT '员工上次登录时间',
	staff_logintime datetime COMMENT '员工本次登录时间',
	create_time datetime NOT NULL COMMENT '创建时间',
	update_time datetime NOT NULL COMMENT '更新时间',
	PRIMARY KEY (id)
) COMMENT = '公司员工表';


CREATE TABLE p_adv
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	adv_community_id bigint(11) COMMENT '点位地区',
	adv_position varchar(255) COMMENT '点位详细位置',
	-- 0:未安装
	-- 1:安装未投放广告
	-- 2:使用中(投放了广告)
	-- 3:等待安装(马上要去安装广告)
	adv_status int(2) COMMENT '点位状态 : 0:未安装
1:安装未投放广告
2:使用中(投放了广告)
3:等待安装(马上要去安装广告)',
	adv_image varchar(255) COMMENT '广告图',
	create_time datetime NOT NULL COMMENT '创建时间',
	update_time datetime NOT NULL COMMENT '更新时间',
	PRIMARY KEY (id)
) COMMENT = '广告位表';


CREATE TABLE p_model
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	model_name varchar(20) NOT NULL COMMENT '型号名称',
	model_desc varchar(255) NOT NULL COMMENT '型号参数解释',
	PRIMARY KEY (id)
) COMMENT = '型号对照表';


CREATE TABLE p_customer
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	customer_name varchar(50) COMMENT '客户名称',
	customer_contact varchar(20) COMMENT '客户联系人',
	customer_industry varchar(50) COMMENT '客户行业',
	customer_address varchar(100) COMMENT '客户地址',
	PRIMARY KEY (id)
) COMMENT = '客户报备表';


CREATE TABLE p_media
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	media_name varchar(20) COMMENT '媒体名称',
	PRIMARY KEY (id)
) COMMENT = '媒体表';


CREATE TABLE p_company
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	company_name varchar(50) NOT NULL COMMENT '公司名称',
	-- 领域包括：
	-- 电梯框架 电梯门 灯箱 道闸 倒杆 广告牌
	-- 不同的公司可能制作某几个领域，即可多选
	company_field int(2) NOT NULL COMMENT '公司行业 : 领域包括：
电梯框架 电梯门 灯箱 道闸 倒杆 广告牌
不同的公司可能制作某几个领域，即可多选',
	staff_number int COMMENT '员工规模',
	create_time datetime NOT NULL COMMENT '创建时间',
	update_time datetime NOT NULL COMMENT '更新时间',
	PRIMARY KEY (id)
) COMMENT = '公司表';


CREATE TABLE p_community
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	community_name varchar(100) COMMENT '社区名称',
	community_region varchar(20) COMMENT '社区行政区',
	community_city varchar(20) COMMENT '社区城市',
	community_position varchar(100) COMMENT '社区详细地址',
	community_longitudex decimal(9,6) COMMENT '社区经度',
	community_latitudey decimal(9,6) COMMENT '社区纬度',
	community_category int(2) COMMENT '社区类型',
	community_cbd varchar(50) COMMENT '社区所属商圈',
	community_property varchar(50) COMMENT '社区物业公司',
	community_scale varchar(50) COMMENT '社区规模',
	community_buildings int(4) COMMENT '社区楼栋数量',
	community_households bigint(11) COMMENT '社区总户数',
	community_units bigint(11) COMMENT '社区总户数',
	community_parking_over bigint(11) COMMENT '社区地上车位数',
	community_parking_under bigint(11) COMMENT '社区地下车位数',
	community_avg_price int(6) COMMENT '社区均价',
	community_traffic varchar(255) COMMENT '社区交通特征',
	community_opentime datetime COMMENT '社区开盘时间',
	community_lowest int(3) COMMENT '社区最低层数',
	community_highest int(3) COMMENT '社区最高层数',
	community_facility varchar(255) COMMENT '社区配套设施',
	community_taboos varchar(255) COMMENT '社区禁忌行业',
	community_elevators bigint(11) COMMENT '社区签约电梯数',
	community_boards bigint(11) COMMENT '社区板位数',
	create_time datetime NOT NULL COMMENT '创建时间',
	update_time datetime NOT NULL COMMENT '更新时间',
	PRIMARY KEY (id)
) COMMENT = '社区信息表';


CREATE TABLE p_sector
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	sector_name varchar(50) NOT NULL COMMENT '部门名称',
	sector_financial_no varchar(30) COMMENT '部门财务编码',
	sector_level int(2) COMMENT '部门等级',
	sector_count int(4) COMMENT '部门人数',
	sector_fid bigint(11) COMMENT '部门上级部门id',
	sector_order_no int(4) COMMENT '部门顺序号',
	sector_sid bigint(11) COMMENT '部门负责人id',
	sector_city varchar(20) COMMENT '部门所在城市',
	create_time datetime NOT NULL COMMENT '创建时间',
	update_time datetime NOT NULL COMMENT '更新时间',
	PRIMARY KEY (id)
) COMMENT = '部门表';


CREATE TABLE p_sales
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	sales_customer varchar(50) NOT NULL COMMENT '客户名称',
	sales_adv_info varchar(255) COMMENT '广告信息',
	sales_community_id bigint(11) COMMENT '社区id',
	sales_status int(2) COMMENT '销售状态',
	PRIMARY KEY (id)
) COMMENT = '销售单表';


CREATE TABLE p_sales_adv
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	sales_id bigint(11) NOT NULL COMMENT '销售表id',
	adv_id bigint(11) COMMENT '广告位id',
	PRIMARY KEY (id)
) COMMENT = '客户广告位关系表';


CREATE TABLE p_task
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	task_name varchar(50) COMMENT '任务名称',
	task_contract varchar(50) COMMENT '任务合同名称',
	task_contract_img varchar(11) COMMENT '任务合同图片地址',
	task_community_id bigint(11) COMMENT '任务小区id',
	task_staff_id bigint(11) COMMENT '任务开发人员(负责人)',
	task_server_id bigint(11) COMMENT '任务维护人id',
	task_status int(2) COMMENT '任务状态',
	task_level int(2) COMMENT '任务级别',
	-- 0 否, 没有合同
	-- 1 是, 有合同
	task_is_contract enum("0","1") COMMENT '任务是否有合同 : 0 否, 没有合同
1 是, 有合同',
	PRIMARY KEY (id)
) COMMENT = '任务表';


CREATE TABLE p_menu
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	menu_name varchar(50) NOT NULL COMMENT '菜单名称',
	menu_url varchar(255) NOT NULL COMMENT '菜单地址',
	parent_id bigint(11) NOT NULL COMMENT '父级id',
	menu_level int(1) NOT NULL COMMENT '菜单级别',
	menu_note varchar(255) COMMENT '菜单备注',
	create_time datetime NOT NULL COMMENT '创建时间',
	update_time datetime NOT NULL COMMENT '更新时间',
	PRIMARY KEY (id)
) COMMENT = '菜单表';


CREATE TABLE p_role
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	role_name varchar(50) NOT NULL COMMENT '权限名称',
	role_code varchar(20) NOT NULL COMMENT '权限编码',
	create_time datetime NOT NULL COMMENT '创建时间',
	update_time datetime NOT NULL COMMENT '更新时间',
	PRIMARY KEY (id)
) COMMENT = '权限表';


CREATE TABLE p_role_menu
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	menu_id bigint(11) NOT NULL COMMENT '菜单id',
	role_id bigint(11) NOT NULL COMMENT '权限id',
	create_time datetime NOT NULL COMMENT '创建时间',
	PRIMARY KEY (id)
) COMMENT = '权限与菜单关系表';


CREATE TABLE p_staff_role
(
	id bigint(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
	role_id bigint(11) NOT NULL COMMENT '权限id',
	staff_id bigint(11) COMMENT '员工id',
	create_time datetime NOT NULL COMMENT '创建时间',
	PRIMARY KEY (id)
) COMMENT = '用户与权限关系表';



