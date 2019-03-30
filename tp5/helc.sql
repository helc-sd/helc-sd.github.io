/*
Navicat MySQL Data Transfer

Source Server         : HOME
Source Server Version : 50617
Source Host           : 192.168.55.101:3306
Source Database       : helc

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2018-05-07 19:41:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `helc_arrears`
-- ----------------------------
DROP TABLE IF EXISTS `helc_arrears`;
CREATE TABLE `helc_arrears` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` varchar(20) DEFAULT NULL COMMENT '生产工号',
  `contract_id` varchar(20) DEFAULT NULL COMMENT '合同号',
  `buyer` varchar(20) DEFAULT NULL COMMENT '买方单位',
  `big_customer` varchar(20) DEFAULT NULL COMMENT '大客户',
  `big_project` varchar(20) DEFAULT NULL COMMENT '大项目',
  `expire_date` date DEFAULT NULL COMMENT '到期应收日期',
  `arrears_amount` double(20,0) DEFAULT NULL COMMENT '欠款金额',
  `company` varchar(20) DEFAULT NULL COMMENT '分公司',
  `arrears_staff` varchar(20) DEFAULT NULL COMMENT '欠款人',
  `bu_name` varchar(20) DEFAULT NULL COMMENT '事业部名称',
  `arrears_type` varchar(20) DEFAULT NULL COMMENT '欠款类型',
  `arrears_adjust` double DEFAULT NULL COMMENT '欠款调整项',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_arrears
-- ----------------------------
INSERT INTO `helc_arrears` VALUES ('1', '18G12345', '美丽置业', '美丽置业', 'KA', '大项目', '2018-04-27', '4000', '潍坊分公司', '王颖', '王颖事业部', '设备', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `helc_authority`
-- ----------------------------
DROP TABLE IF EXISTS `helc_authority`;
CREATE TABLE `helc_authority` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_authority
-- ----------------------------

-- ----------------------------
-- Table structure for `helc_badcost`
-- ----------------------------
DROP TABLE IF EXISTS `helc_badcost`;
CREATE TABLE `helc_badcost` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(20) DEFAULT NULL COMMENT '申请人工号',
  `staff_bu` varchar(20) DEFAULT NULL COMMENT '所属事业部',
  `cost_content` text COMMENT '费用内容',
  `cost_amount` double(20,0) DEFAULT NULL COMMENT '费用金额',
  `buincome_subtract` double(20,0) DEFAULT NULL COMMENT '事业部 收入扣减',
  `quarter_pay_subtract` double(20,0) DEFAULT NULL COMMENT '季度薪酬池减少',
  `quarter_cost_subtract` double(20,0) DEFAULT NULL COMMENT '季度费用池减少',
  `year_pay_subtract` double(20,0) DEFAULT NULL COMMENT '财年薪酬池减少',
  `year_cost_subtract` double(20,0) DEFAULT NULL COMMENT '财年费用池减少',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_badcost
-- ----------------------------

-- ----------------------------
-- Table structure for `helc_bucost`
-- ----------------------------
DROP TABLE IF EXISTS `helc_bucost`;
CREATE TABLE `helc_bucost` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(11) DEFAULT NULL COMMENT '员工编号',
  `staff_name` varchar(20) DEFAULT NULL COMMENT '报销人',
  `staff_bu` varchar(20) DEFAULT NULL COMMENT '所属事业部',
  `cost_content` varchar(20) DEFAULT NULL COMMENT '报销单内容',
  `cost_sum` double(10,0) DEFAULT NULL COMMENT '报销金额',
  `reim_date` date DEFAULT NULL COMMENT '报销日期',
  `create_time` datetime DEFAULT NULL COMMENT '创建日期',
  `update_time` datetime DEFAULT NULL COMMENT '更新日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_bucost
-- ----------------------------
INSERT INTO `helc_bucost` VALUES ('11', '38516', '王传岩', '许朋朋事业部', '其他交际费', '4000', '2018-04-26', null, null);
INSERT INTO `helc_bucost` VALUES ('12', '28327', '许朋朋', '许朋朋事业部', '餐饮费', '215', '2018-04-26', null, null);
INSERT INTO `helc_bucost` VALUES ('13', '28327', '许朋朋', '许朋朋事业部', '酒水', '1000', '2018-04-26', null, null);
INSERT INTO `helc_bucost` VALUES ('14', '22112', '陈浩', '陈浩事业部', '交际费', '2177', '2018-04-25', null, null);
INSERT INTO `helc_bucost` VALUES ('15', '22112', '陈浩', '陈浩事业部', '办公费', '80', '2018-04-25', null, null);
INSERT INTO `helc_bucost` VALUES ('16', '32998', '金勇', '金勇事业部', '办公费', '219', '2018-04-25', null, null);
INSERT INTO `helc_bucost` VALUES ('17', '32998', '金勇', '金勇事业部', '行车费用-高速过桥等杂费', '40', '2018-04-25', null, null);
INSERT INTO `helc_bucost` VALUES ('18', '32998', '金勇', '金勇事业部', '交际费', '300', '2018-04-25', null, null);
INSERT INTO `helc_bucost` VALUES ('19', '41307', '高晓彤', '陈浩事业部', '交际费', '300', '2018-04-25', null, null);
INSERT INTO `helc_bucost` VALUES ('20', '22112', '陈浩', '陈浩事业部', '交际费', '500', '2018-04-25', null, null);
INSERT INTO `helc_bucost` VALUES ('21', '39626', '安国栋', '钟世国事业部', '办公费', '425', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('22', '5871', '苏本勋', '苏本勋事业部', '办公费', '770', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('23', '5871', '苏本勋', '苏本勋事业部', '交际费', '400', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('24', '36607', '钟世国', '钟世国事业部', '交际费', '464', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('25', '36607', '钟世国', '钟世国事业部', '交际费', '152', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('26', '39626', '安国栋', '钟世国事业部', '交际费', '300', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('27', '23428', '李乾', '李乾事业部', '交际费', '568', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('28', '23428', '李乾', '李乾事业部', '交际费', '300', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('29', '44027', '陈岩', '李乾事业部', '差旅费-国内', '431', '2018-04-24', null, null);
INSERT INTO `helc_bucost` VALUES ('30', '36623', '闫炳洋', '闫炳洋事业部', '办公费', '1350', '2018-04-26', null, null);
INSERT INTO `helc_bucost` VALUES ('31', '36623', '闫炳洋', '闫炳洋事业部', '行车费用-高速过桥等杂费', '135', '2018-04-26', null, null);
INSERT INTO `helc_bucost` VALUES ('32', '45139', '孙佳维', '王晓东事业部', '差旅费-国内', '234', '2018-04-26', null, null);
INSERT INTO `helc_bucost` VALUES ('33', '40468', '杜海洲', '杜海洲事业部', '办公费', '1220', '2018-04-26', null, null);
INSERT INTO `helc_bucost` VALUES ('34', '10790', '郑金庆', '赵法顺事业部', '交际费', '1025', '2018-04-17', null, null);
INSERT INTO `helc_bucost` VALUES ('35', '26674', '刘腾腾', '王颖事业部', '交际费', '849', '2018-04-17', null, null);
INSERT INTO `helc_bucost` VALUES ('36', '26674', '刘腾腾', '王颖事业部', '交际费', '600', '2018-04-17', null, '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `helc_budrawing`
-- ----------------------------
DROP TABLE IF EXISTS `helc_budrawing`;
CREATE TABLE `helc_budrawing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(10) DEFAULT NULL COMMENT '员工编号',
  `staff_name` varchar(20) DEFAULT NULL COMMENT '员工姓名',
  `staff_bu` varchar(20) DEFAULT NULL COMMENT '所属事业部',
  `drawing_amount` double(10,0) DEFAULT NULL COMMENT '计提金额',
  `drawing_date` date DEFAULT NULL COMMENT '计提日期',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_budrawing
-- ----------------------------
INSERT INTO `helc_budrawing` VALUES ('1', '6349', '王颖', '王颖事业部', '10000', '2018-05-04', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_budrawing` VALUES ('2', '38673', '李鹏', '李鹏事业部', '10000', '2018-05-03', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_budrawing` VALUES ('4', '38673', '刘腾腾', '王颖事业部', '10000', '2018-05-03', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `helc_bufinance`
-- ----------------------------
DROP TABLE IF EXISTS `helc_bufinance`;
CREATE TABLE `helc_bufinance` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bu_name` varchar(20) DEFAULT NULL COMMENT '事业部名称',
  `quarter_pay_balance` double(20,0) DEFAULT NULL COMMENT '季度薪酬池余额',
  `sum_drawing` double(20,0) DEFAULT NULL COMMENT '薪酬计提总额',
  `quarter_cost_balance` double(20,0) DEFAULT NULL COMMENT '季度费用池余额',
  `sum_cost` double(20,0) DEFAULT NULL COMMENT '费用支出总额',
  `year_pay_balance` double(20,0) DEFAULT NULL COMMENT '财年薪酬池余额',
  `year_cost_balance` double(20,0) DEFAULT NULL COMMENT '财年费用池余额',
  `year` int(11) DEFAULT NULL COMMENT '财年',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COMMENT='事业部薪酬费用池';

-- ----------------------------
-- Records of helc_bufinance
-- ----------------------------
INSERT INTO `helc_bufinance` VALUES ('1', '王颖事业部', null, null, null, '1449', null, null, '2018', '2018-05-07 16:21:01', '2018-05-07 16:21:01');
INSERT INTO `helc_bufinance` VALUES ('2', '李鹏事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('3', '杜鹏事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('4', '赵法顺事业部', null, null, null, '1025', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('5', '孟庆凯事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('6', '许朋朋事业部', null, null, null, '5215', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('7', '韩超事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('8', '李举臻事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('9', '李秀豪事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('10', '孙云鹏事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('11', '钟世国事业部', null, null, null, '1341', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('12', '罗鑫事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('13', '苏本勋事业部', null, null, null, '1170', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('14', '李乾事业部', null, null, null, '1299', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('15', '王竹君事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('16', '杜海洲事业部', null, null, null, '1220', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('17', '徐敏事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('18', '王晓东事业部', null, null, null, '234', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('19', '聂彬彬事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('20', '陈晓丽事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('21', '司艳滨事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('22', '罗宝义事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('23', '邹承帅事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('24', '闫炳洋事业部', null, null, null, '1485', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('25', '闫超事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('26', '耿广坛事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('27', '赵胜华事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('28', '刘雪事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('29', '姜文强事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('30', '陈浩事业部', null, null, null, '3057', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('31', '刘强事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('32', '金勇事业部', null, null, null, '559', null, null, '2018', '2018-05-07 14:41:13', '2018-05-07 14:41:13');
INSERT INTO `helc_bufinance` VALUES ('33', '刘政事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('34', '赵迁事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');
INSERT INTO `helc_bufinance` VALUES ('35', '丁翔事业部', null, null, null, null, null, null, '2018', '2018-05-07 14:29:52', '2018-05-07 14:29:52');

-- ----------------------------
-- Table structure for `helc_bustaff`
-- ----------------------------
DROP TABLE IF EXISTS `helc_bustaff`;
CREATE TABLE `helc_bustaff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `staff_id` varchar(10) NOT NULL COMMENT '工号',
  `staff_name` varchar(10) DEFAULT NULL COMMENT '姓名',
  `staff_post` varchar(20) DEFAULT NULL COMMENT '岗位',
  `staff_bu` varchar(20) DEFAULT NULL COMMENT '所属事业部',
  `company` varchar(20) DEFAULT NULL COMMENT '分公司',
  `if_ceo` varchar(5) DEFAULT NULL COMMENT '是否是CEO',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_bustaff
-- ----------------------------
INSERT INTO `helc_bustaff` VALUES ('1', '6349', '王颖', '营业员', '王颖事业部', '潍坊分公司', '1', '2018-04-23 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('2', '38673', '阎明', '营业员', '王颖事业部', '潍坊分公司', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('3', '26674', '刘腾腾', '项目经理', '王颖事业部', '潍坊分公司', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('4', '37482', '李鹏', '营业员', '李鹏事业部', '潍坊分公司', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('6', '38131', '麻公谨', '项目经理', '李鹏事业部', '潍坊分公司', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('7', '26896', '杜鹏', '营业员', '杜鹏事业部', '潍坊分公司', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('8', '27853', '张杰超', '项目经理', '杜鹏事业部', '潍坊分公司', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('9', '14125', '赵法顺', '营业员', '赵法顺事业部', '潍坊分公司', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('10', '10790', '郑金庆', '项目经理', '赵法顺事业部', '潍坊分公司', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('11', '35596', '孟庆凯', '营业员', '孟庆凯事业部', '潍坊分公司', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('12', '44416', '东彬', '项目经理', '孟庆凯事业部', '潍坊分公司', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_bustaff` VALUES ('13', '28327', '许朋朋', '营业员', '许朋朋事业部', '临沂分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('14', '44460', '李志勇', '营业员', '许朋朋事业部', '临沂分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('15', '28326', '赵学彬', '项目经理', '许朋朋事业部', '临沂分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('16', '38516', '王传岩', '项目经理', '许朋朋事业部', '临沂分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('17', '29139', '韩超', '营业员', '韩超事业部', '临沂分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('18', '8694', '秦田', '项目经理', '韩超事业部', '临沂分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('19', '37861', '李举臻', '营业员', '李举臻事业部', '临沂分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('20', '30647', '唐鑫', '项目经理', '李举臻事业部', '临沂分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('21', '31130', '李秀豪', '营业员', '李秀豪事业部', '临沂分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('22', '32364', '刘玉州', '项目经理', '李秀豪事业部', '临沂分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('23', '43846', '刘维洋', '营业员', '李秀豪事业部', '临沂分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('24', '10973', '孙云鹏', '营业员', '孙云鹏事业部', '青岛分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('25', '44485', '晁夫祥', '营业员', '孙云鹏事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('26', '5875', '王孟宗', '项目经理', '孙云鹏事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('27', '42402', '汪帅', '项目经理', '孙云鹏事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('28', '36607', '钟世国', '营业员', '钟世国事业部', '青岛分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('29', '39626', '安国栋', '营业员', '钟世国事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('30', '11155', '宰繁良', '项目经理', '钟世国事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('31', '41988', '苗炳雄', '项目经理', '钟世国事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('32', '30841', '罗鑫', '营业员', '罗鑫事业部', '青岛分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('33', '12878', '王学师', '营业员', '罗鑫事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('34', '32803', '李承睿', '项目经理', '罗鑫事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('35', '44167', '王慧臻', '项目经理', '罗鑫事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('36', '5871', '苏本勋', '营业员', '苏本勋事业部', '青岛分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('37', '30626', '高文风', '营业员', '苏本勋事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('38', '21227', '朱中亮', '项目经理', '苏本勋事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('39', '29634', '史涌涛', '项目经理', '苏本勋事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('40', '23428', '李乾', '营业员', '李乾事业部', '青岛分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('41', '44027', '陈岩', '营业员', '李乾事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('42', '16837', '刘书生', '项目经理', '李乾事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('43', '20336', '唐继玉', '项目经理', '李乾事业部', '青岛分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('44', '43957', '王竹君', '营业员', '王竹君事业部', '烟台分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('45', '35012', '吕亮', '项目经理', '王竹君事业部', '烟台分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('46', '40468', '杜海洲', '营业员', '杜海洲事业部', '烟台分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('47', '45721', '马康泰', '项目经理', '杜海洲事业部', '烟台分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('48', '15196', '徐敏', '营业员', '徐敏事业部', '烟台分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('49', '10344', '曲春亮', '项目经理', '徐敏事业部', '烟台分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('50', '39413', '王晓东', '营业员', '王晓东事业部', '烟台分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('51', '45139', '孙佳维', '营业员', '王晓东事业部', '烟台分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('52', '24838', '晋广超', '项目经理', '王晓东事业部', '烟台分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('53', '29257', '聂彬彬', '营业员', '聂彬彬事业部', '东营分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('54', '45093', '张云涛', '营业员', '聂彬彬事业部', '东营分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('55', '30167', '司寿松', '项目经理', '聂彬彬事业部', '东营分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('56', '34307', '陈晓丽', '营业员', '陈晓丽事业部', '东营分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('57', '33761', '李鹏飞', '项目经理', '陈晓丽事业部', '东营分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('58', '12742', '司艳滨', '营业员', '司艳滨事业部', '东营分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('59', '28098', '王绍森', '营业员', '司艳滨事业部', '东营分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('60', '37820', '赵程', '项目经理', '司艳滨事业部', '东营分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('61', '38017', '罗宝义', '营业员', '罗宝义事业部', '东营分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('62', '45443', '李长泽', '项目经理', '罗宝义事业部', '东营分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('63', '32619', '邹承帅', '营业员', '邹承帅事业部', '德州分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('64', '30838', '郭晓伟', '项目经理', '邹承帅事业部', '德州分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('65', '33527', '张猛', '项目经理', '邹承帅事业部', '德州分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('66', '36623', '闫炳洋', '营业员', '闫炳洋事业部', '德州分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('67', '44659', '牛佳', '营业员', '闫炳洋事业部', '德州分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('68', '43958', '于华鹏', '项目经理', '闫炳洋事业部', '德州分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('69', '29141', '闫超', '营业员', '闫超事业部', '德州分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('70', '40664', '白书岗', '营业员', '闫超事业部', '德州分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('71', '32996', '杨俊磊', '项目经理', '闫超事业部', '德州分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('72', '37290', '耿广坛', '营业员', '耿广坛事业部', '德州分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('73', '44827', '杜玉保', '项目经理', '耿广坛事业部', '德州分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('74', '31633', '赵胜华', '营业员', '赵胜华事业部', '济宁分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('75', '23891', '续宽宽', '营业员', '赵胜华事业部', '济宁分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('76', '14147', '刘超', '项目经理', '赵胜华事业部', '济宁分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('77', '25637', '夏志旭', '项目经理', '赵胜华事业部', '济宁分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('78', '31632', '刘雪', '营业员', '刘雪事业部', '济宁分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('79', '17813', '郭仁坡', '项目经理', '刘雪事业部', '济宁分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('80', '41792', '姜文强', '营业员', '姜文强事业部', '济宁分公司', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('81', '14215', '孙彦平', '项目经理', '姜文强事业部', '济宁分公司', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('82', '22112', '陈浩', '营业员', '陈浩事业部', '济南大区', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('83', '41307', '高晓彤', '营业员', '陈浩事业部', '济南大区', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('84', '30876', '张辉', '项目经理', '陈浩事业部', '济南大区', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('85', '30877', '赵义锋', '项目经理', '陈浩事业部', '济南大区', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('86', '32324', '刘强', '营业员', '刘强事业部', '济南大区', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('87', '29255', '王鹏德', '项目经理', '刘强事业部', '济南大区', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('88', '32998', '金勇', '营业员', '金勇事业部', '济南大区', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('89', '38132', '李涛', '项目经理', '金勇事业部', '济南大区', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('90', '39519', '刘政', '营业员', '刘政事业部', '济南大区', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('91', '33664', '赵迁', '营业员', '赵迁事业部', '济南大区', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('92', '32987', '陈建', '项目经理', '赵迁事业部', '济南大区', '0', null, null);
INSERT INTO `helc_bustaff` VALUES ('93', '28319', '丁翔', '项目经理', '丁翔事业部', '济南大区', '1', null, null);
INSERT INTO `helc_bustaff` VALUES ('94', '12747', '李智勇', '营业员', '丁翔事业部', '济南大区', '0', null, null);

-- ----------------------------
-- Table structure for `helc_income`
-- ----------------------------
DROP TABLE IF EXISTS `helc_income`;
CREATE TABLE `helc_income` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` varchar(20) NOT NULL COMMENT '工号',
  `contract_id` varchar(20) NOT NULL COMMENT '合同号',
  `income_type` varchar(20) DEFAULT NULL COMMENT '款项类型',
  `arrears_type` varchar(20) DEFAULT NULL COMMENT '欠款类型',
  `company` varchar(20) DEFAULT NULL COMMENT '分公司',
  `payee` varchar(20) DEFAULT NULL COMMENT '收款人',
  `receipt_id` varchar(20) DEFAULT NULL COMMENT '收款编号',
  `fund_name` varchar(20) DEFAULT NULL COMMENT '收款款项名称',
  `classification` varchar(20) DEFAULT NULL COMMENT '分类',
  `split_amount` double(20,0) DEFAULT NULL COMMENT '收款拆分金额',
  `income_way` varchar(20) DEFAULT NULL COMMENT '来款方式',
  `if_buyoff` varchar(5) DEFAULT NULL COMMENT '是否买断合同',
  `buyer` varchar(20) DEFAULT NULL COMMENT '买方单位',
  `big_customer` varchar(10) DEFAULT NULL COMMENT '大客户（普通/KA）',
  `big_project` varchar(10) DEFAULT NULL COMMENT '大项目(普通/大项目)',
  `bu_name` varchar(20) DEFAULT NULL COMMENT '事业部名称',
  `income_date` date DEFAULT NULL COMMENT '入金日期',
  `audit_status` varchar(20) DEFAULT NULL COMMENT '审核状态',
  `bu_income` double(20,0) DEFAULT NULL COMMENT '事业部收入',
  `quarter_pay_add` double(20,0) DEFAULT NULL COMMENT '季度薪酬包增加',
  `quarter_cost_add` double(20,0) DEFAULT NULL COMMENT '季度费用包增加',
  `year_pay_add` double(20,0) DEFAULT NULL COMMENT '财年薪酬包增加',
  `year_cost_add` double(20,0) DEFAULT NULL COMMENT '财年费用包增加',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_income
-- ----------------------------
INSERT INTO `helc_income` VALUES ('2', '18G12345', 'AH18', '欠款内', '历史欠款', '潍坊分公司', '王颖', '12345', '提货款', '销售收款', '2000', '汇款', '否', '美丽置业', '普通', '普通', '王颖事业部', '2018-04-27', '未审核', '24', '0', '0', '0', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_income` VALUES ('3', '18G', 'AH18', '进度款', '当年欠款', '潍坊分公司', '李鹏', '12345', '提货款', '销售收款', '1244', '汇款', '否', '爱德华', '普通', '普通', '李鹏事业部', '2018-04-26', '未审核', null, null, null, null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_income` VALUES ('4', '17G12347', 'AH18', '进度款', '当年欠款', '潍坊分公司', '李鹏', '12345', '提货款', '销售收款', '1244', '汇款', '否', '美丽置业', '普通', '普通', '王颖事业部', '0000-00-00', '已审核', null, null, null, null, null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- ----------------------------
-- Table structure for `helc_orgstructure`
-- ----------------------------
DROP TABLE IF EXISTS `helc_orgstructure`;
CREATE TABLE `helc_orgstructure` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `org_name` varchar(20) DEFAULT NULL COMMENT '组织名称',
  `org_id` varchar(5) DEFAULT NULL COMMENT '组织代码',
  `org_level` varchar(5) DEFAULT NULL,
  `parent_id` varchar(5) DEFAULT NULL COMMENT '父级代码',
  `manager` varchar(20) DEFAULT NULL COMMENT '部门负责人',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_orgstructure
-- ----------------------------
INSERT INTO `helc_orgstructure` VALUES ('1', '山东分公司', '1', '1', '1', null, null, null);
INSERT INTO `helc_orgstructure` VALUES ('2', '运营中心', '12', '2', '1', null, null, null);
INSERT INTO `helc_orgstructure` VALUES ('3', '工程服务中心', '13', '2', '1', null, null, null);
INSERT INTO `helc_orgstructure` VALUES ('4', '安装管理部', '14', '3', '11', null, '2018-04-20 00:00:00', '2018-04-20 00:00:00');
INSERT INTO `helc_orgstructure` VALUES ('5', '售后服务部', '15', '3', '11', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `helc_orgstructure` VALUES ('7', '财务中心', '11', '2', '1', null, null, null);
INSERT INTO `helc_orgstructure` VALUES ('8', '财务管理部', '21', '3', '11', null, null, null);
INSERT INTO `helc_orgstructure` VALUES ('9', '合同管理部', '22', '3', '11', null, null, null);

-- ----------------------------
-- Table structure for `helc_product`
-- ----------------------------
DROP TABLE IF EXISTS `helc_product`;
CREATE TABLE `helc_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` varchar(30) NOT NULL DEFAULT '' COMMENT '工号',
  `contract_id` varchar(20) DEFAULT NULL COMMENT '合同号',
  `elevator_id` varchar(50) DEFAULT NULL COMMENT '梯号',
  `status` varchar(20) DEFAULT NULL COMMENT '状态',
  `elevator_model` varchar(50) DEFAULT NULL COMMENT '电梯型号',
  `floor` int(10) DEFAULT NULL COMMENT '层',
  `stop` int(10) DEFAULT NULL COMMENT '站',
  `door` int(10) DEFAULT NULL COMMENT '门',
  `standard_equipment_price` double(20,2) DEFAULT NULL COMMENT '设备SPL价',
  `standard_transport_price` double(20,2) DEFAULT NULL COMMENT '运输SPL价',
  `standard_installation_price` double(20,2) DEFAULT NULL COMMENT '安装SPL价',
  `average_installation_expenditure` double(20,2) DEFAULT NULL COMMENT '平均安装支出',
  `contract_equipment_price` double(20,2) DEFAULT NULL COMMENT '设备期望价',
  `contract_transport_price` double(20,2) DEFAULT NULL COMMENT '运输期望价',
  `contract_installation_price` double(20,2) DEFAULT NULL COMMENT '安装期望价',
  `equipment_prices_fall` double(20,3) DEFAULT NULL COMMENT '设备下浮',
  `transport_prices_fall` double(20,3) DEFAULT NULL COMMENT '运输下浮',
  `install_prices_fall` double(20,3) DEFAULT NULL COMMENT '安装下浮',
  `if_into_force` varchar(10) DEFAULT NULL COMMENT '是否生效',
  `into_force_date` date DEFAULT NULL COMMENT '生效日期',
  `belong_to` varchar(50) DEFAULT NULL COMMENT '业绩归属',
  `product_inputer` varchar(20) DEFAULT NULL COMMENT '工号录入人',
  `product_input_date` date DEFAULT NULL COMMENT '工号信息录入时间',
  `if_advance_payment` varchar(20) DEFAULT NULL COMMENT '是否支付预付款',
  `first_production_date` date DEFAULT NULL COMMENT '一次排产日期',
  `design_completion_date` date DEFAULT NULL COMMENT '设计完成日期',
  `if_pay_install_cost` varchar(20) DEFAULT NULL COMMENT '是否支付安装费',
  `unpay_install_reason` varchar(50) DEFAULT NULL COMMENT '安装费未付原因',
  `promise_installation_cost_date` date DEFAULT NULL COMMENT '承诺支付安装费日期',
  `actual_installation_cost_date` date DEFAULT NULL COMMENT '实际支付安装费日期',
  `if_pay_lading` varchar(20) DEFAULT NULL COMMENT '是否支付提货款',
  `promise_pay_lading_date` date DEFAULT NULL COMMENT '承诺支付提货款日期',
  `actual_pay_lading_date` date DEFAULT NULL COMMENT '实际支付提货款日期',
  `if_second_production_without_pay` varchar(20) DEFAULT NULL COMMENT '是否无款上二次',
  `second_production_date` date DEFAULT NULL COMMENT '二次下达日期',
  `factory_second_scheduled_date` date DEFAULT NULL COMMENT '工厂二次计划日期',
  `storage_date` date DEFAULT NULL COMMENT '入仓日期',
  `delivery_report_date` date DEFAULT NULL COMMENT '发货流程提报日期',
  `delivery_scheduled_date` date DEFAULT NULL COMMENT '发货计划日期',
  `delivery_date` date DEFAULT NULL COMMENT '出仓日期',
  `supervisor` varchar(20) DEFAULT NULL COMMENT '监理员',
  `scheduled_inputer` varchar(20) DEFAULT NULL COMMENT '排产录入员',
  `scheduled_input_date` date DEFAULT NULL COMMENT '排产录入日期',
  `performance_status` varchar(20) DEFAULT NULL COMMENT '绩效状态',
  `bonus_install` int(20) DEFAULT NULL COMMENT '安装部分奖金',
  `bonus_pay` int(20) DEFAULT NULL COMMENT '付款方式奖金',
  `bonus_sale` int(20) DEFAULT NULL COMMENT '合同销量奖金',
  `sum_bonus` int(20) DEFAULT NULL COMMENT '奖金合计',
  `node1_money` int(20) DEFAULT NULL COMMENT '兑现节点1金额',
  `node1_date` date DEFAULT NULL COMMENT '兑现节点1日期',
  `node2_money` int(20) DEFAULT NULL COMMENT '兑现节点2金额',
  `node2_date` date DEFAULT NULL COMMENT '兑现节点2日期',
  `node3_money` int(20) DEFAULT NULL COMMENT '兑现节点3金额',
  `node3_date` date DEFAULT NULL COMMENT '兑现节点3日期',
  `node4_money` int(20) DEFAULT NULL COMMENT '兑现节点4金额',
  `node4_date` date DEFAULT NULL COMMENT '兑现节点4日期',
  `sales_person` varchar(20) DEFAULT '' COMMENT '营业员',
  `close_date` date DEFAULT NULL COMMENT '关闭日期',
  `complete_date` date DEFAULT NULL COMMENT '完工日期',
  `pda_intime` varchar(10) DEFAULT '' COMMENT 'pda录入是否及时',
  `installation_expenditure` double(20,0) DEFAULT NULL COMMENT '实际安装支出',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `contract_id` (`contract_id`),
  KEY `contract_id_2` (`contract_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22892 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_product
-- ----------------------------
INSERT INTO `helc_product` VALUES ('1', '10G046645', 'AH1005757', '', '正常', 'HGP-825-CO90', '18', '18', '18', '0.00', '0.00', '46210.00', '0.00', '177000.00', '8400.00', '40000.00', '-176.000', '-8.000', '0.134', '是', '2016-04-11', '潍坊分公司', '谭萍', null, '是', '2016-04-12', '2016-04-22', '是', '', '0000-00-00', '2016-09-29', '是', '0000-00-00', '2016-09-29', '否', '2016-10-18', '2016-11-07', '2016-11-07', '2016-10-18', '2016-11-08', '2016-11-08', '徐延伟', '谭萍', '2016-11-14', '已审核', '0', '400', '200', '600', '180', '2016-06-30', '180', '2017-06-30', '60', '2017-06-30', '180', '2017-04-30', '杜鹏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('2', '10G046646', 'AH1005757', '', '正常', 'HGP-825-CO90', '18', '18', '18', '0.00', '0.00', '46210.00', null, '177000.00', '8400.00', '40000.00', '-176.000', '-8.000', '0.134', '是', '2016-04-11', '潍坊分公司', '谭萍', null, '是', '2016-04-12', '2016-04-22', '是', '', '0000-00-00', '2016-09-29', '是', '0000-00-00', '2016-09-29', '否', '2016-10-18', '2016-11-07', '2016-11-07', '2016-10-18', '2016-11-08', '2016-11-08', '徐延伟', '谭萍', '2016-11-14', '已审核', '0', '400', '200', '600', '180', '2016-06-30', '180', '2017-06-30', '60', '2017-06-30', '180', '2017-04-30', '杜鹏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('3', '10G046647', 'AH1005757', '', '正常', 'HGP-825-CO90', '18', '18', '18', '0.00', '0.00', '46210.00', null, '177000.00', '8400.00', '40000.00', '-176999.000', '-8399.000', '0.134', '是', '2016-04-11', '潍坊分公司', '谭萍', null, '是', '2016-04-12', '2016-04-22', '是', '', '0000-00-00', '2016-09-29', '是', '0000-00-00', '2016-09-29', '否', '2016-10-18', '2016-11-07', '2016-11-07', '2016-10-18', '2016-11-08', '2016-11-08', '徐延伟', '谭萍', '2016-11-14', '已审核', '0', '400', '200', '600', '180', '2016-06-30', '180', '2017-06-30', '60', '2017-06-30', '180', '2017-04-30', '杜鹏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('4', '10G046648', 'AH1005757', '', '正常', 'HGP-825-CO90', '18', '18', '18', '0.00', '0.00', '46210.00', '0.00', '177000.00', '8400.00', '40000.00', '-176.000', '-8.000', '0.134', '是', '2016-08-15', '潍坊分公司', '谭萍', null, '是', '2016-09-07', '2016-09-22', '否', '', '0000-00-00', '2017-02-10', '是', '0000-00-00', '2017-02-10', '', '2017-02-15', '2017-03-15', '2017-03-15', '2017-02-15', '2017-03-19', '2017-03-19', '', '谭萍', '2017-03-21', '已审核', '0', '400', '800', '1200', '360', '2016-09-30', '360', '2017-03-31', '120', '2017-06-30', '360', '2017-04-30', '杜鹏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('5', '10G046649', 'AH1005757', '', '正常', 'HGP-825-CO90', '18', '18', '18', '0.00', '0.00', '46210.00', '0.00', '177000.00', '8400.00', '40000.00', '-176.000', '-8.000', '0.134', '是', '2016-08-15', '潍坊分公司', '谭萍', null, '是', '2016-09-07', '2016-09-22', '是', '', '0000-00-00', '2017-02-10', '是', '0000-00-00', '2017-02-10', '否', '2017-02-15', '2017-03-15', '2017-03-15', '2017-02-15', '2017-03-18', '2017-03-18', '', '谭萍', '2017-03-21', '已审核', '0', '400', '800', '1200', '360', '2016-09-30', '360', '2017-03-31', '120', '2017-06-30', '360', '2017-04-30', '杜鹏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('6', '10G046650', 'AH1005757', '', '正常', 'HGP-825-CO90', '18', '18', '18', '0.00', '0.00', '46210.00', '0.00', '177000.00', '8400.00', '40000.00', '-176.000', '-8.000', '0.134', '是', '2016-08-15', '潍坊分公司', '谭萍', null, '是', '2016-09-07', '2016-09-22', '是', '', '0000-00-00', '2017-02-10', '是', '0000-00-00', '2017-02-10', '否', '2017-02-15', '2017-03-15', '2017-03-15', '2017-02-15', '2017-03-18', '2017-03-18', '', '谭萍', '2017-03-21', '已审核', '0', '400', '800', '1200', '360', '2016-09-30', '360', '2017-03-31', '120', '2017-06-30', '360', '2017-04-30', '杜鹏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('7', '11G003871', 'AH1100393', '', '取消', 'HGP-1050-CO105', '19', '19', '19', '0.00', '0.00', '4800.00', '0.00', '196000.00', '8400.00', '4800.00', '-195.000', '-8.000', '0.000', '', '0000-00-00', '青岛分公司', '陈玉芳', null, '', null, null, '', '', null, null, '', null, null, '', null, null, null, null, null, null, '', '陈玉芳', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '徐敏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('8', '11G003872', 'AH1100393', '', '取消', 'HGP-1050-CO105', '19', '19', '19', '0.00', '0.00', '4800.00', '0.00', '196000.00', '8400.00', '4800.00', '-195999.000', '-8399.000', '0.000', '', '0000-00-00', '青岛分公司', '陈玉芳', null, '', null, null, '', '', null, null, '', null, null, '', null, null, null, null, null, null, '', '陈玉芳', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '徐敏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('9', '11G003877', 'AH1100393', '', '取消', 'HGP-1050-CO105', '19', '19', '19', '0.00', '0.00', '4800.00', '0.00', '198000.00', '8400.00', '4800.00', '-197999.000', '-8399.000', '0.000', '', '0000-00-00', '青岛分公司', '陈玉芳', null, '', null, null, '', '', null, null, '', null, null, '', null, null, null, null, null, null, '', '陈玉芳', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '徐敏', null, null, null, null, null, null);
INSERT INTO `helc_product` VALUES ('10', '11G003878', 'AH1100393', '', '取消', 'HGP-1050-CO105', '19', '19', '19', '0.00', '0.00', '4800.00', '0.00', '198000.00', '8400.00', '4800.00', '-197999.000', '-8399.000', '0.000', '', '0000-00-00', '青岛分公司', '陈玉芳', null, '', null, null, '', '', null, null, '', null, null, '', null, null, null, null, null, null, '', '陈玉芳', null, null, null, null, null, null, null, null, null, null, null, null, null, null, '徐敏', null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `helc_profit`
-- ----------------------------
DROP TABLE IF EXISTS `helc_profit`;
CREATE TABLE `helc_profit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bu_name` varchar(20) DEFAULT NULL COMMENT '事业部名称',
  `bu_eq_average` double(20,0) DEFAULT NULL COMMENT '事业部平均设备签约价',
  `co_eq_average` double(20,0) DEFAULT NULL,
  `bu_in_price` double(20,0) DEFAULT NULL,
  `spl_in_price` double(20,0) DEFAULT NULL COMMENT '标准安装价',
  `install_pay` double(20,0) DEFAULT NULL COMMENT '安装支出',
  `bad_cost` double(20,0) DEFAULT NULL COMMENT '不良费用',
  `profit_bonus` double(20,0) DEFAULT NULL COMMENT '盈利分享奖金',
  `if_reach` varchar(10) DEFAULT NULL COMMENT '是否达标',
  `financial_year` int(10) DEFAULT NULL COMMENT '财年',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_profit
-- ----------------------------
INSERT INTO `helc_profit` VALUES ('1', '王颖事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('2', '李鹏事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('3', '杜鹏事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('4', '赵法顺事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('5', '孟庆凯事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('6', '许朋朋事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('7', '韩超事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('8', '李举臻事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('9', '李秀豪事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('10', '孙云鹏事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('11', '钟世国事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('12', '罗鑫事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('13', '苏本勋事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('14', '李乾事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('15', '王竹君事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('16', '杜海洲事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('17', '徐敏事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('18', '王晓东事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('19', '聂彬彬事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('20', '陈晓丽事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('21', '司艳滨事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('22', '罗宝义事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('23', '邹承帅事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('24', '闫炳洋事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('25', '闫超事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('26', '耿广坛事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('27', '赵胜华事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('28', '刘雪事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('29', '姜文强事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('30', '陈浩事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('31', '刘强事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('32', '金勇事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('33', '刘政事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('34', '赵迁事业部', null, null, null, null, null, null, null, null, null);
INSERT INTO `helc_profit` VALUES ('35', '丁翔事业部', null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `helc_role`
-- ----------------------------
DROP TABLE IF EXISTS `helc_role`;
CREATE TABLE `helc_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_name` varchar(20) DEFAULT NULL COMMENT '角色名称',
  `report` text COMMENT '报表',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_role
-- ----------------------------
INSERT INTO `helc_role` VALUES ('1', '系统管理员', '<li class=\"cative\"><a class=\"glyphicon glyphicon-stats\" href=\"{:url(\'Login/welcome\')}\"></a></li>');

-- ----------------------------
-- Table structure for `helc_staff`
-- ----------------------------
DROP TABLE IF EXISTS `helc_staff`;
CREATE TABLE `helc_staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` varchar(20) DEFAULT NULL COMMENT '员工编号',
  `staff_name` varchar(20) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL COMMENT '密码',
  `role` varchar(20) DEFAULT NULL COMMENT '角色',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of helc_staff
-- ----------------------------
INSERT INTO `helc_staff` VALUES ('1', '11824', '耿传涛', '1', '5f383784a8ce262fa222357d503768412ee75518', '系统管理员', '2018-04-25 00:00:00', '2018-04-25 00:00:00');
INSERT INTO `helc_staff` VALUES ('2', '9071', '张丽雅', '0', '5f383784a8ce262fa222357d503768412ee75518', '系统管理员', '2018-04-25 00:00:00', '2018-04-25 00:00:00');
INSERT INTO `helc_staff` VALUES ('3', '40362', '徐晓凤', '0', '5f383784a8ce262fa222357d503768412ee75518', '系统管理员', '2018-04-25 00:00:00', '2018-04-25 00:00:00');
INSERT INTO `helc_staff` VALUES ('4', '39090', '刘倩倩', '0', '5f383784a8ce262fa222357d503768412ee75518', '系统管理员', '2018-04-25 00:00:00', '2018-04-25 00:00:00');

-- ----------------------------
-- Table structure for `wwwlog`
-- ----------------------------
DROP TABLE IF EXISTS `wwwlog`;
CREATE TABLE `wwwlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wwwlog
-- ----------------------------

-- ----------------------------
-- View structure for `登陆`
-- ----------------------------
DROP VIEW IF EXISTS `登陆`;
