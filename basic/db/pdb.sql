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
	-- Ϊp_community������
	adv_community_id bigint(11) NOT NULL COMMENT 'Ϊp_community������',
	-- �����λ����ʹ�ã�����ʾ�ͻ�����
	adv_name varchar(50) COMMENT '�����λ����ʹ�ã�����ʾ�ͻ�����',
	-- λ������
	adv_position varchar(255) NOT NULL COMMENT 'λ������',
	adv_starttime datetime,
	adv_endtime datetime,
	adv_image varchar(255),
	-- 0.���ݹ��
	-- 1.��բ���
	-- 2.���˹��
	-- 3.����
	-- 4.�����Ž�
	adv_property int(2) NOT NULL COMMENT '0.���ݹ��
1.��բ���
2.���˹��
3.����
4.�����Ž�',
	-- p_model����
	model_id binary(11) COMMENT 'p_model����',
	-- ��p_model���л��
	adv_model varchar(20) COMMENT '��p_model���л��',
	-- 0:δ��װ
	-- 1.��ά�ޣ��𻵣�
	-- 2.����ʹ��
	adv_install_status int(2) COMMENT '0:δ��װ
1.��ά�ޣ��𻵣�
2.����ʹ��',
	-- 0.����
	-- 1.δʹ��
	-- 2.��ʹ��
	adv_use_status int(2) COMMENT '0.����
1.δʹ��
2.��ʹ��',
	-- 0.����
	-- 1.����
	-- 2.�û�
	adv_sales_status int(2) COMMENT '0.����
1.����
2.�û�',
	-- 0.Ԥ��
	-- 1.���Ͽ�
	-- 2.���Ͽ�
	-- 3.���¿�
	-- 4.���¿�
	adv_pic_status int(2) COMMENT '0.Ԥ��
1.���Ͽ�
2.���Ͽ�
3.���¿�
4.���¿�',
	adv_note varchar(500),
	-- 0.�������
	-- 1.�����
	-- 2.�����
	-- 3.���ͨ��
	-- 4.���δͨ��
	adv_status int(2) COMMENT '0.�������
1.�����
2.�����
3.���ͨ��
4.���δͨ��',
	company_id bigint(11) NOT NULL,
	-- 0.��
	-- 1.��
	is_delete int(2) COMMENT '0.��
1.��',
	creator bigint(11),
	create_time datetime NOT NULL,
	updater bigint(11),
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_check
(
	id bigint(11) NOT NULL,
	-- 0.¥����Ϣ��p_community��
	-- 1.���λ��p_adv��
	-- 2.�豸�ͺű�(p_model)
	-- 3.��������(p_task)
	check_info int(2) NOT NULL COMMENT '0.¥����Ϣ��p_community��
1.���λ��p_adv��
2.�豸�ͺű�(p_model)
3.��������(p_task)',
	-- Ϊp_staff��Ա������
	staff_id bigint(11) NOT NULL COMMENT 'Ϊp_staff��Ա������',
	-- �ֱ�Ϊp_community��p_adv��p_model��p_task������
	check_id bigint(11) NOT NULL COMMENT '�ֱ�Ϊp_community��p_adv��p_model��p_task������',
	-- 0.��ͨ��
	-- 1.ͨ��
	check_status int(2) NOT NULL COMMENT '0.��ͨ��
1.ͨ��',
	create_time datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE p_check_control
(
	id bigint(11) NOT NULL,
	-- ��˾��p_company������
	company_id bigint(11) NOT NULL COMMENT '��˾��p_company������',
	-- 0.����Ҫ
	-- 1.��Ҫ��Ĭ�ϣ�
	control_community int(2) COMMENT '0.����Ҫ
1.��Ҫ��Ĭ�ϣ�',
	-- 0.����Ҫ��Ĭ�ϣ�
	-- 1.��Ҫ
	control_adv int(2) COMMENT '0.����Ҫ��Ĭ�ϣ�
1.��Ҫ',
	-- 0.����Ҫ
	-- 1.��Ҫ��Ĭ�ϣ�
	control_model int(2) COMMENT '0.����Ҫ
1.��Ҫ��Ĭ�ϣ�',
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
	-- 0.�½�¥��
	-- 1.��¥��
	-- 2.����¥��
	community_nature int(2) COMMENT '0.�½�¥��
1.��¥��
2.����¥��',
	community_opentime datetime NOT NULL,
	community_staytime datetime NOT NULL,
	community_units int(6) NOT NULL,
	community_households int(6) NOT NULL,
	community_taboos varchar(255),
	community_longitudex varchar(50),
	community_latitudey varchar(50),
	community_traffic varchar(255),
	community_facility varchar(255),
	-- Ĭ������ϴ�3����Ƭ
	community_image1 varchar(255) COMMENT 'Ĭ������ϴ�3����Ƭ',
	community_image2 varchar(255),
	community_image3 varchar(255),
	community_note varchar(500),
	-- 0.�������
	-- 1.�����
	-- 2.�����
	-- 3.���ͨ��
	-- 4.���δͨ��
	community_status int(2) COMMENT '0.�������
1.�����
2.�����
3.���ͨ��
4.���δͨ��',
	company_id binary(11) NOT NULL,
	-- 0.��
	-- 1.��
	is_delete int(2) COMMENT '0.��
1.��',
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
	-- ���������
	-- ���ݿ�� ������ ���� ��բ ���� �����
	-- ��ͬ�Ĺ�˾��������ĳ�������򣬼��ɶ�ѡ
	company_field int(2) COMMENT '���������
���ݿ�� ������ ���� ��բ ���� �����
��ͬ�Ĺ�˾��������ĳ�������򣬼��ɶ�ѡ',
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
	-- ���ͻ�����
	customer_contact varchar(20) NOT NULL COMMENT '���ͻ�����',
	customer_phone varchar(50),
	customer_email varchar(100),
	customer_industry varchar(50) NOT NULL,
	-- ��ӦΪ�ÿͻ�����Ĺ�˾
	company_id binary(11) NOT NULL COMMENT '��ӦΪ�ÿͻ�����Ĺ�˾',
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
	-- �ɴ洢���˵�id
	staff_ids varchar(50) NOT NULL COMMENT '�ɴ洢���˵�id',
	-- ��ǰֻ֧��������Ա��һ��������
	staff_sector bigint(11) COMMENT '��ǰֻ֧��������Ա��һ��������',
	company_id bigint(11) NOT NULL,
	-- 0.��
	-- 1.��
	is_delete int(2) COMMENT '0.��
1.��',
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
	-- 0 => ϵͳ���˵�
	-- 1 => ģ��˵�
	menu_level int(1) NOT NULL COMMENT '0 => ϵͳ���˵�
1 => ģ��˵�',
	menu_note varchar(255),
	create_time datetime NOT NULL,
	update_time datetime NOT NULL,
	PRIMARY KEY (id)
);


-- ������p_community��p_adv��p_model
CREATE TABLE p_message
(
	id bigint(11) NOT NULL,
	company_id bigint(11) NOT NULL,
	-- ��Ϣ���ݸ�����ӵ����ݲ�ͬ���Զ�����
	message_content varchar(255) COMMENT '��Ϣ���ݸ�����ӵ����ݲ�ͬ���Զ�����',
	create_time datetime,
	PRIMARY KEY (id)
) COMMENT = '������p_community��p_adv��p_model';


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
	-- 0.�������
	-- 1.�����
	-- 2.�����
	-- 3.���ͨ��
	-- 4.���δͨ��
	model_status int(2) COMMENT '0.�������
1.�����
2.�����
3.���ͨ��
4.���δͨ��',
	company_id bigint(11),
	-- 0.��
	-- 1.��
	is_delete int(2) COMMENT '0.��
1.��',
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
	-- Ϊp_adv������
	adv_di bigint(11) COMMENT 'Ϊp_adv������',
	sales_customer varchar(50),
	sales_company bigint(100),
	sales_starttime datetime,
	sales_endtime datetime,
	sales_person varchar(100),
	-- 0.������
	-- 1.Ԥ��
	-- 2.������
	sales_status int(2) COMMENT '0.������
1.Ԥ��
2.������',
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
	-- Ҳ�ǵ�¼�ʺ�
	staff_name varchar(20) NOT NULL COMMENT 'Ҳ�ǵ�¼�ʺ�',
	password varchar(255) NOT NULL,
	staff_level int(11),
	staff_aids_id bigint(11),
	staff_no bigint(10),
	staff_in datetime,
	staff_workplace varchar(100),
	-- p_company������
	company_id bigint(11) NOT NULL COMMENT 'p_company������',
	staff_sector bigint(11),
	staff_position varchar(50),
	staff_phone bigint(11),
	staff_email varchar(30),
	staff_lastlogin datetime,
	staff_logintime datetime,
	-- 0.��
	-- 1.��
	is_super int(2) COMMENT '0.��
1.��',
	-- 0.��
	-- 1.��
	is_delete int(2) COMMENT '0.��
1.��',
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
	-- 0.��װ
	-- 1.ά��
	-- 2.���
	task_category int(2) COMMENT '0.��װ
1.ά��
2.���',
	-- ��ʾ��Ӧ�Ĺ��λ��Ϣ��¥����Ϣ
	adv_id bigint(11) COMMENT '��ʾ��Ӧ�Ĺ��λ��Ϣ��¥����Ϣ',
	-- ��ʾ��Ӧ���豸��Ϣ
	model_id bigint(11) COMMENT '��ʾ��Ӧ���豸��Ϣ',
	-- ��ʾ��Ӧ�İ�װ��Ա
	group_id bigint(11) COMMENT '��ʾ��Ӧ�İ�װ��Ա',
	-- 0.δ��ʼ
	-- 1.������
	-- 3.�����
	task_status int(2) COMMENT '0.δ��ʼ
1.������
3.�����',
	-- 0.δ�Ͽ�
	-- 1.�Ͽ���
	-- 2.���Ͽ�
	task_adv_status int(2) COMMENT '0.δ�Ͽ�
1.�Ͽ���
2.���Ͽ�',
	task_deadline datetime,
	task_note varchar(500),
	company_id bigint(11),
	-- 0.��
	-- 1.��
	is_delete int(2) COMMENT '0.��
1.��',
	creator bigint(11),
	create_time datetime,
	updater bigint(11),
	update_time datetime,
	PRIMARY KEY (id)
);


CREATE TABLE p_task_accept
(
	id bigint(11) NOT NULL,
	-- p_task����
	task_id bigint(11) COMMENT 'p_task����',
	-- p_staff����
	staff_id bigint(11) COMMENT 'p_staff����',
	-- 0.δ����
	-- 1.������
	-- 2.����ɣ�������ɺ��Զ�����Ϊ��״̬��
	accept_status int(2) COMMENT '0.δ����
1.������
2.����ɣ�������ɺ��Զ�����Ϊ��״̬��',
	create_time datetime,
	accept_time datetime,
	-- ������ɺ��Զ�����
	complete_time datetime COMMENT '������ɺ��Զ�����',
	PRIMARY KEY (id)
);



