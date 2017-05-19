/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : signuppay

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-05-19 18:29:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for osc_admin
-- ----------------------------
DROP TABLE IF EXISTS `osc_admin`;
CREATE TABLE `osc_admin` (
  `admin_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) NOT NULL COMMENT '用户名',
  `passwd` varchar(128) NOT NULL,
  `true_name` varchar(20) NOT NULL COMMENT '真名',
  `telephone` varchar(40) NOT NULL,
  `email` varchar(64) NOT NULL,
  `login_count` mediumint(8) NOT NULL COMMENT '登录次数',
  `last_login_ip` varchar(40) NOT NULL COMMENT '最后登录ip',
  `last_ip_region` varchar(40) NOT NULL,
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL,
  `last_login_time` int(10) NOT NULL COMMENT '最后登录',
  `status` tinyint(4) NOT NULL COMMENT '状态',
  `group_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='后台管理员';

-- ----------------------------
-- Records of osc_admin
-- ----------------------------
INSERT INTO `osc_admin` VALUES ('1', 'admin', 'MDAwMDAwMDAwMH2Jf6qDqI5m', '', '', '', '147', '127.0.0.1', '', '0', '0', '1495155907', '1', '2');

-- ----------------------------
-- Table structure for osc_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `osc_auth_group`;
CREATE TABLE `osc_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `type` varchar(20) NOT NULL,
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_auth_group
-- ----------------------------
INSERT INTO `osc_auth_group` VALUES ('2', 'admin', '超级管理员', '后台超级管理员', '1', '1,2,13,38,46,57,113,121,122,123,124,125,126,127,128,129,130,131,132,134,135,136,137,138,139,140,141,142');

-- ----------------------------
-- Table structure for osc_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `osc_auth_group_access`;
CREATE TABLE `osc_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_auth_group_access
-- ----------------------------
INSERT INTO `osc_auth_group_access` VALUES ('1', '2');

-- ----------------------------
-- Table structure for osc_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `osc_auth_rule`;
CREATE TABLE `osc_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `group_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=309 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_auth_rule
-- ----------------------------
INSERT INTO `osc_auth_rule` VALUES ('244', '2', '141', 'member/menu/index');
INSERT INTO `osc_auth_rule` VALUES ('243', '2', '140', '');
INSERT INTO `osc_auth_rule` VALUES ('242', '2', '139', 'admin/user/index');
INSERT INTO `osc_auth_rule` VALUES ('237', '2', '134', 'item/option/index');
INSERT INTO `osc_auth_rule` VALUES ('238', '2', '135', '');
INSERT INTO `osc_auth_rule` VALUES ('239', '2', '136', 'payment/index/index');
INSERT INTO `osc_auth_rule` VALUES ('305', '6', '131', 'admin/file_manager/delete');
INSERT INTO `osc_auth_rule` VALUES ('241', '2', '138', 'admin/user_action/index');
INSERT INTO `osc_auth_rule` VALUES ('304', '6', '130', 'admin/file_manager/folder');
INSERT INTO `osc_auth_rule` VALUES ('303', '6', '129', 'admin/file_manager/upload');
INSERT INTO `osc_auth_rule` VALUES ('302', '6', '128', 'admin/file_manager/index');
INSERT INTO `osc_auth_rule` VALUES ('301', '6', '127', 'admin/index/logout');
INSERT INTO `osc_auth_rule` VALUES ('300', '6', '126', 'admin/auth_manager/index');
INSERT INTO `osc_auth_rule` VALUES ('299', '6', '125', '');
INSERT INTO `osc_auth_rule` VALUES ('298', '6', '124', 'admin/module/index');
INSERT INTO `osc_auth_rule` VALUES ('297', '6', '123', 'admin/menu/get_info');
INSERT INTO `osc_auth_rule` VALUES ('296', '6', '122', 'admin/menu/del');
INSERT INTO `osc_auth_rule` VALUES ('295', '6', '121', 'admin/menu/edit');
INSERT INTO `osc_auth_rule` VALUES ('294', '6', '120', 'admin/menu/add');
INSERT INTO `osc_auth_rule` VALUES ('240', '2', '137', 'payment/field/index');
INSERT INTO `osc_auth_rule` VALUES ('236', '2', '132', 'item/item_category/index');
INSERT INTO `osc_auth_rule` VALUES ('234', '2', '130', 'admin/file_manager/folder');
INSERT INTO `osc_auth_rule` VALUES ('235', '2', '131', 'admin/file_manager/delete');
INSERT INTO `osc_auth_rule` VALUES ('233', '2', '129', 'admin/file_manager/upload');
INSERT INTO `osc_auth_rule` VALUES ('232', '2', '128', 'admin/file_manager/index');
INSERT INTO `osc_auth_rule` VALUES ('231', '2', '127', 'admin/index/logout');
INSERT INTO `osc_auth_rule` VALUES ('230', '2', '126', 'admin/auth_manager/index');
INSERT INTO `osc_auth_rule` VALUES ('229', '2', '125', '');
INSERT INTO `osc_auth_rule` VALUES ('228', '2', '124', 'admin/module/index');
INSERT INTO `osc_auth_rule` VALUES ('227', '2', '123', 'admin/menu/get_info');
INSERT INTO `osc_auth_rule` VALUES ('226', '2', '122', 'admin/menu/del');
INSERT INTO `osc_auth_rule` VALUES ('225', '2', '121', 'admin/menu/edit');
INSERT INTO `osc_auth_rule` VALUES ('224', '2', '113', 'admin/settings/save');
INSERT INTO `osc_auth_rule` VALUES ('223', '2', '57', 'admin/index/index');
INSERT INTO `osc_auth_rule` VALUES ('222', '2', '46', 'admin/config/index');
INSERT INTO `osc_auth_rule` VALUES ('221', '2', '38', 'admin/settings/general');
INSERT INTO `osc_auth_rule` VALUES ('220', '2', '13', '');
INSERT INTO `osc_auth_rule` VALUES ('219', '2', '2', 'admin/menu/index');
INSERT INTO `osc_auth_rule` VALUES ('218', '2', '1', 'admin/settings/general');
INSERT INTO `osc_auth_rule` VALUES ('245', '2', '142', 'member/auth/index');
INSERT INTO `osc_auth_rule` VALUES ('293', '6', '113', 'admin/settings/save');
INSERT INTO `osc_auth_rule` VALUES ('292', '6', '57', 'admin/index/index');
INSERT INTO `osc_auth_rule` VALUES ('291', '6', '46', 'admin/config/index');
INSERT INTO `osc_auth_rule` VALUES ('289', '6', '13', '');
INSERT INTO `osc_auth_rule` VALUES ('290', '6', '38', 'admin/settings/general');
INSERT INTO `osc_auth_rule` VALUES ('288', '6', '2', 'admin/menu/index');
INSERT INTO `osc_auth_rule` VALUES ('287', '6', '1', 'admin/settings/general');
INSERT INTO `osc_auth_rule` VALUES ('306', '6', '132', 'item/item_category/index');
INSERT INTO `osc_auth_rule` VALUES ('307', '6', '134', 'item/option/index');
INSERT INTO `osc_auth_rule` VALUES ('308', '6', '138', 'admin/user_action/index');

-- ----------------------------
-- Table structure for osc_config
-- ----------------------------
DROP TABLE IF EXISTS `osc_config`;
CREATE TABLE `osc_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `info` varchar(255) NOT NULL COMMENT '描述',
  `module` varchar(40) NOT NULL,
  `module_name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_config
-- ----------------------------
INSERT INTO `osc_config` VALUES ('13', 'SITE_TITLE', '报名支付系统', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('14', 'SITE_NAME', '报名支付系统', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('15', 'SITE_DESCRIPTION', '报名支付系统1', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('16', 'SITE_KEYWORDS', '报名支付系统', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('17', 'SITE_URL', 'http://web.bmxt.com', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('19', 'SITE_ICP', '', 'ICP备案号', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('20', 'EMAIL', '', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('21', 'TELEPHONE', '', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('22', 'WEB_SITE_CLOSE', '1', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('53', 'SITE_ICON', 'images/hans2/logo.png', '网站图标', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('59', 'PWD_KEY', '(3oiu2)mkjh2U!w5>yk%nW1~q=[*VOL.:EiBM`@og_N)AH', '公共加密秘钥', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('70', 'page_num', '10', '', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('62', 'administrator', 'admin', '超级管理员账号', 'common', '网站公共配置');
INSERT INTO `osc_config` VALUES ('72', 'admin_group', '2', '超级管理员组', 'admin', '系统后台');
INSERT INTO `osc_config` VALUES ('73', 'default_group', '2', '会员注册默认组', 'member', '会员');
INSERT INTO `osc_config` VALUES ('74', 'reg_check', '0', '注册是否需要审核', 'member', '会员');
INSERT INTO `osc_config` VALUES ('75', 'item_check', '0', '活动是否要审核', 'member', '会员');

-- ----------------------------
-- Table structure for osc_item
-- ----------------------------
DROP TABLE IF EXISTS `osc_item`;
CREATE TABLE `osc_item` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '标题',
  `image` varchar(128) NOT NULL,
  `uid` mediumint(8) NOT NULL COMMENT '创建人',
  `username` varchar(20) NOT NULL,
  `contact` varchar(40) NOT NULL COMMENT '联系人',
  `contact_tel` varchar(20) NOT NULL COMMENT '联系电话',
  `is_pay` tinyint(2) NOT NULL COMMENT '是否需要支付',
  `price` decimal(8,2) NOT NULL COMMENT '金额',
  `total_num` mediumint(8) NOT NULL DEFAULT '-1' COMMENT '名额',
  `join_num` mediumint(8) NOT NULL COMMENT '参加人数',
  `start_apply_time` int(10) NOT NULL COMMENT '开始报名',
  `end_apply_time` int(10) NOT NULL COMMENT '结束报名',
  `start_time` int(10) NOT NULL COMMENT '活动开始',
  `end_time` int(10) NOT NULL COMMENT '活动结束',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `cid` mediumint(8) NOT NULL,
  `location` varchar(64) NOT NULL COMMENT '地点',
  `status` smallint(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='项目';

-- ----------------------------
-- Records of osc_item
-- ----------------------------
INSERT INTO `osc_item` VALUES ('1', '博鳌会论坛第一场', 'images/mosc5/df1.jpg', '5', 'cheny', '陈先生', '18825137275', '1', '0.01', '50', '1', '1495036800', '1500652800', '1500912000', '1501171200', '1495002536', '1495178118', '1', '广州天河科韵路', '1');
INSERT INTO `osc_item` VALUES ('2', '考研培训会议', 'images/mosc5/fgdgfd.jpg', '5', 'cheny', '陈先生', '18825137275', '1', '0.01', '1', '0', '1494950400', '1495123200', '1495209600', '1495209600', '1495005743', '1495178144', '2', '广州越秀区', '1');

-- ----------------------------
-- Table structure for osc_item_category
-- ----------------------------
DROP TABLE IF EXISTS `osc_item_category`;
CREATE TABLE `osc_item_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='分类';

-- ----------------------------
-- Records of osc_item_category
-- ----------------------------
INSERT INTO `osc_item_category` VALUES ('1', '0', '旅游', '自考', '自考', '1');
INSERT INTO `osc_item_category` VALUES ('2', '0', '学历', '学历', '学历', '2');
INSERT INTO `osc_item_category` VALUES ('3', '0', '考研', '考研', '考研', '3');
INSERT INTO `osc_item_category` VALUES ('4', '0', '语言', '', '', '4');
INSERT INTO `osc_item_category` VALUES ('5', '0', '留学', '', '', '5');
INSERT INTO `osc_item_category` VALUES ('6', '0', '活动营', '', '', '6');
INSERT INTO `osc_item_category` VALUES ('7', '0', '中小学', '', '', '7');
INSERT INTO `osc_item_category` VALUES ('8', '0', '文体', '', '', '8');
INSERT INTO `osc_item_category` VALUES ('9', '0', '商业', '', '', '9');
INSERT INTO `osc_item_category` VALUES ('10', '0', '金融', '', '', '10');
INSERT INTO `osc_item_category` VALUES ('11', '0', '财会', '', '', '11');
INSERT INTO `osc_item_category` VALUES ('12', '0', '企业', '', '', '12');
INSERT INTO `osc_item_category` VALUES ('13', '0', '工程', '', '', '13');
INSERT INTO `osc_item_category` VALUES ('14', '0', '医药', '', '', '14');
INSERT INTO `osc_item_category` VALUES ('15', '0', '健康', '', '', '15');
INSERT INTO `osc_item_category` VALUES ('16', '0', '美容', '', '', '16');
INSERT INTO `osc_item_category` VALUES ('17', '0', '餐饮', '', '', '17');
INSERT INTO `osc_item_category` VALUES ('18', '0', '计算机', '', '', '18');
INSERT INTO `osc_item_category` VALUES ('19', '0', '公务员', '', '', '19');
INSERT INTO `osc_item_category` VALUES ('20', '0', '卖场', '卖场', '卖场', '0');
INSERT INTO `osc_item_category` VALUES ('21', '20', 'test', 'test', 'tewst', '0');

-- ----------------------------
-- Table structure for osc_item_data
-- ----------------------------
DROP TABLE IF EXISTS `osc_item_data`;
CREATE TABLE `osc_item_data` (
  `item_data_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `item_id` mediumint(8) NOT NULL,
  `uid` int(8) NOT NULL,
  `cid` int(8) NOT NULL,
  `member_form` text NOT NULL COMMENT '用户报名表单',
  `summary` varchar(255) NOT NULL,
  `description` text NOT NULL COMMENT '详情描述',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`item_data_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_item_data
-- ----------------------------
INSERT INTO `osc_item_data` VALUES ('1', '1', '5', '1', '', '博鳌会论坛第一场', '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;http://web.bmxt.com/uploads/cache/images/ckeditor/20170517/2017051753495053-400x300.jpg&quot; style=&quot;height:300px; width:400px&quot; /&gt;&lt;/p&gt;\r\n', '1495178118');
INSERT INTO `osc_item_data` VALUES ('2', '2', '5', '2', '', '考研培训会议', '&lt;p&gt;考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议考研培训会议&lt;/p&gt;\r\n', '1495178144');

-- ----------------------------
-- Table structure for osc_item_option
-- ----------------------------
DROP TABLE IF EXISTS `osc_item_option`;
CREATE TABLE `osc_item_option` (
  `io_id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` mediumint(8) NOT NULL,
  `cid` mediumint(8) NOT NULL,
  `uid` int(8) NOT NULL,
  `option_id` mediumint(8) NOT NULL,
  `option_value_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`io_id`),
  KEY `option_value_id` (`option_value_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_item_option
-- ----------------------------

-- ----------------------------
-- Table structure for osc_member
-- ----------------------------
DROP TABLE IF EXISTS `osc_member`;
CREATE TABLE `osc_member` (
  `userid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` char(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT '密码',
  `checked` tinyint(1) NOT NULL COMMENT '是否审核',
  `sex` tinyint(4) NOT NULL DEFAULT '0' COMMENT '性别,1男,2女,0未知',
  `about` varchar(255) NOT NULL COMMENT '个人介绍',
  `praise` int(11) NOT NULL DEFAULT '0' COMMENT '被赞数',
  `attention` int(11) NOT NULL DEFAULT '0' COMMENT '关注数',
  `fans` int(11) NOT NULL DEFAULT '0' COMMENT '粉丝数',
  `share` int(11) NOT NULL DEFAULT '0' COMMENT '分享数',
  `nickname` char(20) NOT NULL COMMENT '昵称',
  `userpic` varchar(200) NOT NULL COMMENT '会员头像',
  `regdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `lastdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `regip` char(15) NOT NULL DEFAULT '' COMMENT '注册ip',
  `lastip` char(15) NOT NULL DEFAULT '' COMMENT '上次登录ip',
  `loginnum` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `email` char(32) NOT NULL DEFAULT '' COMMENT '电子邮箱',
  `groupid` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户组id',
  `areaid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '地区id',
  `amount` decimal(8,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '钱金总额',
  `point` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `message` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否有短消息',
  `islock` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否锁定',
  `vip` tinyint(1) NOT NULL COMMENT 'vip等级',
  `overduedate` int(10) NOT NULL COMMENT 'vip过期时间',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of osc_member
-- ----------------------------
INSERT INTO `osc_member` VALUES ('5', 'cheny', 'MDAwMDAwMDAwMH2Jf6qDqI5m', '1', '0', '', '0', '0', '0', '0', 'cheny', '', '1495001880', '1495001880', '', '', '0', '734865521@qq.com', '2', '0', '0.00', '0', '0', '0', '0', '0');
INSERT INTO `osc_member` VALUES ('6', 'ye', 'MDAwMDAwMDAwMH2Jf6qDqI5m', '1', '0', '', '0', '0', '0', '0', 'ye', '', '1495002630', '1495002630', '', '', '0', '12s6541f@qq.com', '2', '0', '0.00', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for osc_member_apply
-- ----------------------------
DROP TABLE IF EXISTS `osc_member_apply`;
CREATE TABLE `osc_member_apply` (
  `ma_id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `item_title` varchar(128) NOT NULL,
  `member_id` mediumint(8) NOT NULL,
  `cid` mediumint(8) NOT NULL COMMENT '分类',
  `uid` mediumint(8) NOT NULL COMMENT '创建人',
  `name` varchar(20) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `payment_code` varchar(20) NOT NULL,
  `money` double(8,2) NOT NULL,
  `order_num` varchar(64) NOT NULL,
  `pay_status` smallint(5) NOT NULL,
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `pay_time` int(10) NOT NULL,
  `is_pay` smallint(5) NOT NULL DEFAULT '0' COMMENT '是否需要支付,0不需要，1需要',
  PRIMARY KEY (`ma_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员报名记录';

-- ----------------------------
-- Records of osc_member_apply
-- ----------------------------
INSERT INTO `osc_member_apply` VALUES ('2', '1', '博鳌会论坛第一场', '6', '1', '5', '陈业', '18825137275', 'alipay', '0.01', '2017051857575110', '1', '1495005055', '1495079573', '1495079573', '1');
INSERT INTO `osc_member_apply` VALUES ('3', '2', '考研培训会议', '6', '2', '5', '小叶', '18545', 'weixin', '0.01', '2017051710010198', '0', '1495005959', '0', '0', '1');

-- ----------------------------
-- Table structure for osc_member_apply_data
-- ----------------------------
DROP TABLE IF EXISTS `osc_member_apply_data`;
CREATE TABLE `osc_member_apply_data` (
  `mad_id` int(10) NOT NULL AUTO_INCREMENT,
  `item_id` int(10) NOT NULL,
  `ma_id` int(10) NOT NULL,
  `extend_data` text NOT NULL COMMENT '其他数据',
  PRIMARY KEY (`mad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员报名附加数据';

-- ----------------------------
-- Records of osc_member_apply_data
-- ----------------------------

-- ----------------------------
-- Table structure for osc_member_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `osc_member_auth_group`;
CREATE TABLE `osc_member_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组id,自增主键',
  `type` varchar(20) NOT NULL,
  `title` char(20) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `description` varchar(80) NOT NULL DEFAULT '' COMMENT '描述信息',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '用户组状态：为1正常，为0禁用,-1为删除',
  `rules` varchar(500) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id，多个规则 , 隔开',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_member_auth_group
-- ----------------------------
INSERT INTO `osc_member_auth_group` VALUES ('2', '', '普通用户', '普通用户', '1', '1,2,4,5,6,7,10,11,12,13,14,15,16,17');

-- ----------------------------
-- Table structure for osc_member_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `osc_member_auth_group_access`;
CREATE TABLE `osc_member_auth_group_access` (
  `uid` int(10) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_member_auth_group_access
-- ----------------------------
INSERT INTO `osc_member_auth_group_access` VALUES ('5', '2');
INSERT INTO `osc_member_auth_group_access` VALUES ('6', '2');

-- ----------------------------
-- Table structure for osc_member_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `osc_member_auth_rule`;
CREATE TABLE `osc_member_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `group_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=186 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_member_auth_rule
-- ----------------------------
INSERT INTO `osc_member_auth_rule` VALUES ('183', '2', '15', 'member/account/password');
INSERT INTO `osc_member_auth_rule` VALUES ('182', '2', '14', 'member/account/profile');
INSERT INTO `osc_member_auth_rule` VALUES ('181', '2', '13', '');
INSERT INTO `osc_member_auth_rule` VALUES ('180', '2', '12', 'member/join/me');
INSERT INTO `osc_member_auth_rule` VALUES ('179', '2', '11', 'member/join/index');
INSERT INTO `osc_member_auth_rule` VALUES ('178', '2', '10', 'member/item/get_option_value');
INSERT INTO `osc_member_auth_rule` VALUES ('177', '2', '7', 'member/item/edit');
INSERT INTO `osc_member_auth_rule` VALUES ('176', '2', '6', 'member/item/del');
INSERT INTO `osc_member_auth_rule` VALUES ('175', '2', '5', 'member/item/copy_item');
INSERT INTO `osc_member_auth_rule` VALUES ('174', '2', '4', 'member/item/add');
INSERT INTO `osc_member_auth_rule` VALUES ('173', '2', '2', 'member/item/index');
INSERT INTO `osc_member_auth_rule` VALUES ('172', '2', '1', '');
INSERT INTO `osc_member_auth_rule` VALUES ('184', '2', '16', 'member/join/export_excel');
INSERT INTO `osc_member_auth_rule` VALUES ('185', '2', '17', 'member/join/export_me_excel');

-- ----------------------------
-- Table structure for osc_member_menu
-- ----------------------------
DROP TABLE IF EXISTS `osc_member_menu`;
CREATE TABLE `osc_member_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `module` varchar(20) NOT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `icon` varchar(64) NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `type` varchar(40) NOT NULL COMMENT 'nav,auth',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

-- ----------------------------
-- Records of osc_member_menu
-- ----------------------------
INSERT INTO `osc_member_menu` VALUES ('1', 'membe', '0', '活动报名', '', 'fa-pencil-square-o fa-lg', '2', 'nav');
INSERT INTO `osc_member_menu` VALUES ('2', 'member', '1', '活动列表', 'member/item/index', '', '1', 'nav');
INSERT INTO `osc_member_menu` VALUES ('4', 'member', '2', '新增项目', 'member/item/add', '', '0', 'auth');
INSERT INTO `osc_member_menu` VALUES ('5', 'member', '2', '复制', 'member/item/copy_item', '', '2', 'auth');
INSERT INTO `osc_member_menu` VALUES ('6', 'member', '2', '删除', 'member/item/del', '', '3', 'auth');
INSERT INTO `osc_member_menu` VALUES ('7', 'member', '2', '编辑', 'member/item/edit', '', '4', 'auth');
INSERT INTO `osc_member_menu` VALUES ('10', 'member', '2', '取得选项', 'member/item/get_option_value', '', '8', 'auth');
INSERT INTO `osc_member_menu` VALUES ('11', 'member', '1', '报名情况', 'member/join/index', '', '2', 'nav');
INSERT INTO `osc_member_menu` VALUES ('12', 'member', '1', '我参加的活动', 'member/join/me', '', '3', 'nav');
INSERT INTO `osc_member_menu` VALUES ('13', 'member', '0', '个人资料', '', 'fa-users fa-lg', '1', 'nav');
INSERT INTO `osc_member_menu` VALUES ('14', 'member', '13', '我的资料', 'member/account/profile', '', '1', 'nav');
INSERT INTO `osc_member_menu` VALUES ('15', 'member', '13', '修改密码', 'member/account/password', '', '2', 'nav');
INSERT INTO `osc_member_menu` VALUES ('16', 'member', '11', '导出', 'member/join/export_excel', '', '1', 'auth');
INSERT INTO `osc_member_menu` VALUES ('17', 'member', '12', '导出', 'member/join/export_me_excel', '', '1', 'auth');

-- ----------------------------
-- Table structure for osc_menu
-- ----------------------------
DROP TABLE IF EXISTS `osc_menu`;
CREATE TABLE `osc_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `module` varchar(20) NOT NULL,
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `icon` varchar(64) NOT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `type` varchar(40) NOT NULL COMMENT 'nav,auth',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

-- ----------------------------
-- Records of osc_menu
-- ----------------------------
INSERT INTO `osc_menu` VALUES ('1', 'system', '0', '系统', 'admin/settings/general', 'fa-cog fa-lg', '5', 'nav');
INSERT INTO `osc_menu` VALUES ('2', 'system', '1', '后台菜单管理', 'admin/menu/index', '', '10', 'nav');
INSERT INTO `osc_menu` VALUES ('13', 'extend', '0', '扩展', '', 'fa-puzzle-piece fa-lg', '4', 'nav');
INSERT INTO `osc_menu` VALUES ('38', 'system', '1', '基本信息', 'admin/settings/general', '', '1', 'nav');
INSERT INTO `osc_menu` VALUES ('46', 'system', '1', '配置管理', 'admin/config/index', '', '3', 'nav');
INSERT INTO `osc_menu` VALUES ('57', '', '0', '首页', 'admin/index/index', '', '8', 'auth');
INSERT INTO `osc_menu` VALUES ('113', 'system', '1', '保存配置', 'admin/settings/save', '', '8', 'auth');
INSERT INTO `osc_menu` VALUES ('120', '', '2', '新增', 'admin/menu/add', '', '1', 'auth');
INSERT INTO `osc_menu` VALUES ('121', '', '2', '编辑', 'admin/menu/edit', '', '2', 'auth');
INSERT INTO `osc_menu` VALUES ('122', '', '2', '删除', 'admin/menu/del', '', '3', 'auth');
INSERT INTO `osc_menu` VALUES ('123', '', '2', '获取信息', 'admin/menu/get_info', '', '4', 'auth');
INSERT INTO `osc_menu` VALUES ('124', '', '13', '模块管理', 'admin/module/index', '', '0', 'nav');
INSERT INTO `osc_menu` VALUES ('125', 'signup', '0', '报名', '', 'fa-pencil-square-o fa-lg', '1', 'nav');
INSERT INTO `osc_menu` VALUES ('126', 'system', '1', '权限管理', 'admin/auth_manager/index', '', '4', 'nav');
INSERT INTO `osc_menu` VALUES ('127', '', '0', '退出系统', 'admin/index/logout', '', '0', 'auth');
INSERT INTO `osc_menu` VALUES ('128', 'admin', '0', '图片管理器', 'admin/file_manager/index', '', '0', 'auth');
INSERT INTO `osc_menu` VALUES ('129', 'admin', '128', '上传图片', 'admin/file_manager/upload', '', '0', 'auth');
INSERT INTO `osc_menu` VALUES ('130', 'admin', '128', '新建文件夹', 'admin/file_manager/folder', '', '0', 'auth');
INSERT INTO `osc_menu` VALUES ('131', 'admin', '128', '删除', 'admin/file_manager/delete', '', '0', 'auth');
INSERT INTO `osc_menu` VALUES ('132', 'signup', '125', '分类', 'item/item_category/index', '', '1', 'nav');
INSERT INTO `osc_menu` VALUES ('143', 'member', '140', '会员列表', 'member/member/index', '', '3', 'nav');
INSERT INTO `osc_menu` VALUES ('134', 'signup', '125', '选项', 'item/option/index', '', '2', 'nav');
INSERT INTO `osc_menu` VALUES ('135', 'payment', '0', '支付', '', 'fa-credit-card fa-lg', '2', 'nav');
INSERT INTO `osc_menu` VALUES ('136', 'payment', '135', '支付接口', 'payment/index/index', '', '2', 'nav');
INSERT INTO `osc_menu` VALUES ('137', 'payment', '135', '字段管理', 'payment/field/index', '', '1', 'nav');
INSERT INTO `osc_menu` VALUES ('138', 'admin', '1', '用户行为', 'admin/user_action/index', '', '2', 'nav');
INSERT INTO `osc_menu` VALUES ('139', 'admin', '1', '系统用户', 'admin/user/index', '', '5', 'nav');
INSERT INTO `osc_menu` VALUES ('140', 'member', '0', '会员', '', 'fa-users fa-lg', '3', 'nav');
INSERT INTO `osc_menu` VALUES ('141', 'member', '140', '会员菜单', 'member/menu/index', '', '1', 'nav');
INSERT INTO `osc_menu` VALUES ('142', 'member', '140', '会员权限', 'member/auth/index', '', '2', 'nav');
INSERT INTO `osc_menu` VALUES ('144', 'item', '125', '活动列表', 'item/item/index', '', '3', 'nav');
INSERT INTO `osc_menu` VALUES ('145', 'item', '125', '报名列表', 'item/join/index', '', '4', 'nav');

-- ----------------------------
-- Table structure for osc_module
-- ----------------------------
DROP TABLE IF EXISTS `osc_module`;
CREATE TABLE `osc_module` (
  `module` varchar(15) NOT NULL COMMENT '模块',
  `modulename` varchar(20) NOT NULL COMMENT '模块名称',
  `base_module` varchar(64) NOT NULL COMMENT '依赖的模块',
  `sign` varchar(255) NOT NULL COMMENT '签名',
  `iscore` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '内置模块',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否可用',
  `version` varchar(50) NOT NULL DEFAULT '' COMMENT '版本',
  `author` varchar(40) NOT NULL,
  `setting` mediumtext NOT NULL COMMENT '设置信息',
  `installtime` int(10) NOT NULL COMMENT '安装时间',
  `updatetime` int(10) NOT NULL COMMENT '更新时间',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`module`),
  KEY `sign` (`sign`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='已安装模块列表';

-- ----------------------------
-- Records of osc_module
-- ----------------------------
INSERT INTO `osc_module` VALUES ('admin', '系统后台', '', '', '1', '1', '', '李梓钿', '', '0', '0', '0');
INSERT INTO `osc_module` VALUES ('item', '报名模块', '', '', '0', '1', '', '李梓钿', '', '0', '0', '0');
INSERT INTO `osc_module` VALUES ('mobile', '手机端', '', '', '0', '1', '', '李梓钿', '', '0', '0', '0');
INSERT INTO `osc_module` VALUES ('payment', '支付', '', '', '0', '1', '', '李梓钿', '', '0', '0', '0');
INSERT INTO `osc_module` VALUES ('member', '会员', '', '', '0', '1', '', '李梓钿', '', '0', '0', '0');

-- ----------------------------
-- Table structure for osc_option
-- ----------------------------
DROP TABLE IF EXISTS `osc_option`;
CREATE TABLE `osc_option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `form_type` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `update_time` datetime NOT NULL,
  `cid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '分类',
  `system` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否系统选项',
  `uid` mediumint(8) NOT NULL COMMENT '创建人',
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='选项';

-- ----------------------------
-- Records of osc_option
-- ----------------------------
INSERT INTO `osc_option` VALUES ('6', 'radio', '0', '年龄限制', '50-65|1,35-50|2,25-35,18-25', '2016-07-12 17:22:27', '1', '1', '1');
INSERT INTO `osc_option` VALUES ('7', 'radio', '0', '英语培训类', '商务英语,职称英语,出国英语', '2016-06-25 15:32:28', '4', '1', '1');
INSERT INTO `osc_option` VALUES ('8', 'radio', '0', '编程/软件开发', 'java,javascript,c,c++,php', '2016-06-25 15:35:54', '18', '1', '1');
INSERT INTO `osc_option` VALUES ('9', 'radio', '0', '系统/IT认证', '微软培训,思科培训', '2016-06-27 15:29:19', '18', '1', '1');
INSERT INTO `osc_option` VALUES ('10', 'radio', '0', '电脑基础', '计算机等级,电脑培训,职称计算机', '2016-06-27 15:30:58', '18', '1', '1');
INSERT INTO `osc_option` VALUES ('11', 'radio', '0', '网友活动', '户外活动,唱歌,看电影,卖场', '2016-07-08 15:36:14', '6', '1', '1');
INSERT INTO `osc_option` VALUES ('12', 'radio', '0', '二手买卖', '陶瓷,二手车,二手房', '2016-07-08 15:39:34', '20', '1', '1');
INSERT INTO `osc_option` VALUES ('13', 'radio', '0', '区域限制', '德化内,德化外', '2016-07-12 17:26:53', '1', '1', '1');

-- ----------------------------
-- Table structure for osc_option_value
-- ----------------------------
DROP TABLE IF EXISTS `osc_option_value`;
CREATE TABLE `osc_option_value` (
  `option_value_id` int(11) NOT NULL AUTO_INCREMENT,
  `option_id` int(11) NOT NULL,
  `value_name` varchar(128) NOT NULL,
  `value_sort_order` int(3) NOT NULL,
  `cid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '分类',
  `system` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否系统选项',
  PRIMARY KEY (`option_value_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='选项值';

-- ----------------------------
-- Records of osc_option_value
-- ----------------------------
INSERT INTO `osc_option_value` VALUES ('50', '13', '德化外', '2', '1', '1');
INSERT INTO `osc_option_value` VALUES ('49', '13', '德化内', '1', '1', '1');
INSERT INTO `osc_option_value` VALUES ('48', '6', '18-25', '1', '1', '1');
INSERT INTO `osc_option_value` VALUES ('47', '6', '25-35', '2', '1', '1');
INSERT INTO `osc_option_value` VALUES ('46', '6', '35-50', '3', '1', '1');
INSERT INTO `osc_option_value` VALUES ('12', '7', '商务英语', '1', '4', '1');
INSERT INTO `osc_option_value` VALUES ('13', '7', '职称英语', '2', '4', '1');
INSERT INTO `osc_option_value` VALUES ('14', '7', '出国英语', '3', '4', '1');
INSERT INTO `osc_option_value` VALUES ('15', '8', 'java', '1', '18', '1');
INSERT INTO `osc_option_value` VALUES ('16', '8', 'javascript', '2', '18', '1');
INSERT INTO `osc_option_value` VALUES ('17', '8', 'c', '3', '18', '1');
INSERT INTO `osc_option_value` VALUES ('18', '8', 'c++', '4', '18', '1');
INSERT INTO `osc_option_value` VALUES ('19', '8', 'php', '5', '18', '1');
INSERT INTO `osc_option_value` VALUES ('20', '9', '微软培训', '1', '18', '1');
INSERT INTO `osc_option_value` VALUES ('21', '9', '思科培训', '2', '18', '1');
INSERT INTO `osc_option_value` VALUES ('22', '10', '计算机等级', '1', '18', '1');
INSERT INTO `osc_option_value` VALUES ('23', '10', '电脑培训', '2', '18', '1');
INSERT INTO `osc_option_value` VALUES ('24', '10', '职称计算机', '3', '18', '1');
INSERT INTO `osc_option_value` VALUES ('34', '11', '看电影', '1', '6', '1');
INSERT INTO `osc_option_value` VALUES ('33', '11', '唱歌', '2', '6', '1');
INSERT INTO `osc_option_value` VALUES ('32', '11', '户外活动', '3', '6', '1');
INSERT INTO `osc_option_value` VALUES ('35', '11', '卖场', '4', '6', '1');
INSERT INTO `osc_option_value` VALUES ('36', '12', '陶瓷', '1', '20', '1');
INSERT INTO `osc_option_value` VALUES ('37', '12', '二手车', '2', '20', '1');
INSERT INTO `osc_option_value` VALUES ('38', '12', '二手房', '3', '20', '1');
INSERT INTO `osc_option_value` VALUES ('45', '6', '50-65', '4', '1', '1');

-- ----------------------------
-- Table structure for osc_payment
-- ----------------------------
DROP TABLE IF EXISTS `osc_payment`;
CREATE TABLE `osc_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(100) NOT NULL COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `info` varchar(255) NOT NULL COMMENT '描述',
  `payment_code` varchar(20) NOT NULL,
  `payment_name` varchar(20) NOT NULL,
  `status` smallint(3) NOT NULL COMMENT '0关闭，1启用',
  `sort_order` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of osc_payment
-- ----------------------------
INSERT INTO `osc_payment` VALUES ('1', 'account', '', '支付宝账号', 'alipay', '支付宝', '1', '1');
INSERT INTO `osc_payment` VALUES ('3', 'key', '', '交易安全校验码（key）', 'alipay', '支付宝', '1', '2');
INSERT INTO `osc_payment` VALUES ('4', 'partner', '', '合作者身份（partner ID）', 'alipay', '支付宝', '1', '3');
INSERT INTO `osc_payment` VALUES ('5', 'appid', 'wx36e024bc5d8bd505', 'appid', 'weixin', '微信', '1', '11');
INSERT INTO `osc_payment` VALUES ('6', 'token', 'mlxingwj2016', 'token', 'weixin', '微信', '1', '12');
INSERT INTO `osc_payment` VALUES ('7', 'appsecret', '6a4befe731f341b6730df87e12d686d0', 'appsecret', 'weixin', '微信', '1', '13');
INSERT INTO `osc_payment` VALUES ('8', 'encodingaeskey', '', 'encodingaeskey', 'weixin', '微信', '1', '14');
INSERT INTO `osc_payment` VALUES ('9', 'weixin_partner', '1240287702', 'partner（商户号）', 'weixin', '微信', '1', '15');
INSERT INTO `osc_payment` VALUES ('10', 'partnerkey', '55abgO8wwnspo0pud9AL4zIxmzpQNCRi', 'partnerkey', 'weixin', '微信', '1', '16');

-- ----------------------------
-- Table structure for osc_user_action
-- ----------------------------
DROP TABLE IF EXISTS `osc_user_action`;
CREATE TABLE `osc_user_action` (
  `ua_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `uname` varchar(40) NOT NULL COMMENT '用户名',
  `type` varchar(40) NOT NULL COMMENT 'frontend,backend',
  `info` varchar(255) NOT NULL COMMENT '行为描述',
  `add_time` varchar(40) NOT NULL COMMENT '加入时间',
  PRIMARY KEY (`ua_id`)
) ENGINE=MyISAM AUTO_INCREMENT=306 DEFAULT CHARSET=utf8 COMMENT='用户行为';

-- ----------------------------
-- Records of osc_user_action
-- ----------------------------
INSERT INTO `osc_user_action` VALUES ('269', '1', 'admin', '后台系统用户', '登录了后台系统', '2016-07-13 21:59:01');
INSERT INTO `osc_user_action` VALUES ('268', '4', 'lizz', '网站会员', '修改了报名项目 ', '2016-07-13 17:21:30');
INSERT INTO `osc_user_action` VALUES ('267', '1', 'admin', '后台系统用户', '清除了缓存', '2016-07-13 17:19:01');
INSERT INTO `osc_user_action` VALUES ('266', '4', 'lizz', '网站会员', '修改了报名项目 ', '2016-07-13 17:18:45');
INSERT INTO `osc_user_action` VALUES ('265', '4', 'lizz', '网站会员', '删除报名项目', '2016-07-13 17:18:15');
INSERT INTO `osc_user_action` VALUES ('264', '4', 'lizz', '网站会员', '删除报名项目', '2016-07-13 17:18:07');
INSERT INTO `osc_user_action` VALUES ('263', '4', 'lizz', '网站会员', '删除报名项目', '2016-07-13 17:18:05');
INSERT INTO `osc_user_action` VALUES ('262', '4', 'lizz', '网站会员', '删除报名项目', '2016-07-13 17:18:02');
INSERT INTO `osc_user_action` VALUES ('261', '4', 'lizz', '网站会员', '修改了报名项目 ', '2016-07-13 17:17:16');
INSERT INTO `osc_user_action` VALUES ('260', '1', 'admin', '后台系统用户', '修改了后台菜单，编辑', '2016-07-13 17:16:28');
INSERT INTO `osc_user_action` VALUES ('259', '1', 'admin', '后台系统用户', '删除了后台菜单，id=8', '2016-07-13 17:16:18');
INSERT INTO `osc_user_action` VALUES ('258', '1', 'admin', '后台系统用户', '删除了后台菜单，id=9', '2016-07-13 17:16:15');
INSERT INTO `osc_user_action` VALUES ('257', '1', 'admin', '后台系统用户', '修改了后台菜单，选项', '2016-07-13 17:02:31');
INSERT INTO `osc_user_action` VALUES ('256', '1', 'admin', '后台系统用户', '修改了后台菜单，活动列表', '2016-07-13 17:00:35');
INSERT INTO `osc_user_action` VALUES ('270', '1', 'admin', '后台系统用户', '登录了后台系统', '2016-07-13 22:39:34');
INSERT INTO `osc_user_action` VALUES ('271', '3', '5566', '网站会员', '登录了网站', '2016-07-13 22:40:38');
INSERT INTO `osc_user_action` VALUES ('272', '1', 'admin', '后台系统用户', '添加了用户组', '2016-07-13 22:43:10');
INSERT INTO `osc_user_action` VALUES ('273', '1', 'admin', '后台系统用户', '删除了系统用户', '2016-07-13 22:43:26');
INSERT INTO `osc_user_action` VALUES ('274', '1', 'admin', '后台系统用户', '修改了支付接口配置', '2016-07-13 22:49:30');
INSERT INTO `osc_user_action` VALUES ('275', '1', 'admin', '后台系统用户', '修改了支付接口配置', '2016-07-13 22:49:43');
INSERT INTO `osc_user_action` VALUES ('276', '1', 'admin', '后台系统用户', '退出了系统', '2016-07-13 22:50:33');
INSERT INTO `osc_user_action` VALUES ('277', '1', 'admin', '后台系统用户', '登录了后台系统', '2016-07-13 22:51:29');
INSERT INTO `osc_user_action` VALUES ('278', '1', 'admin', '后台系统用户', '登录了后台系统', '2017-05-17 12:18:14');
INSERT INTO `osc_user_action` VALUES ('279', '5', 'cheny', '网站会员', '注册成为会员', '2017-05-17 14:18:00');
INSERT INTO `osc_user_action` VALUES ('280', '5', 'cheny', '网站会员', '新增了报名项目 ', '2017-05-17 14:28:56');
INSERT INTO `osc_user_action` VALUES ('281', '6', 'ye', '网站会员', '注册成为会员', '2017-05-17 14:30:30');
INSERT INTO `osc_user_action` VALUES ('282', '1', 'admin', '后台系统用户', '修改了支付接口配置', '2017-05-17 14:43:21');
INSERT INTO `osc_user_action` VALUES ('283', '5', 'cheny', '网站会员', '登录了网站', '2017-05-17 14:45:40');
INSERT INTO `osc_user_action` VALUES ('284', '5', 'cheny', '网站会员', '修改了报名项目 ', '2017-05-17 14:45:59');
INSERT INTO `osc_user_action` VALUES ('285', '6', 'ye', '网站会员', '登录了网站', '2017-05-17 14:46:21');
INSERT INTO `osc_user_action` VALUES ('286', '5', 'cheny', '网站会员', '登录了网站', '2017-05-17 15:18:31');
INSERT INTO `osc_user_action` VALUES ('287', '5', 'cheny', '网站会员', '新增了报名项目 ', '2017-05-17 15:22:23');
INSERT INTO `osc_user_action` VALUES ('288', '6', 'ye', '网站会员', '登录了网站', '2017-05-17 15:22:48');
INSERT INTO `osc_user_action` VALUES ('289', '5', 'cheny', '网站会员', '登录了网站', '2017-05-17 15:24:01');
INSERT INTO `osc_user_action` VALUES ('290', '5', 'cheny', '网站会员', '修改了报名项目 ', '2017-05-17 15:24:27');
INSERT INTO `osc_user_action` VALUES ('291', '5', 'cheny', '网站会员', '修改了报名项目 ', '2017-05-17 15:24:57');
INSERT INTO `osc_user_action` VALUES ('292', '6', 'ye', '网站会员', '登录了网站', '2017-05-17 15:25:14');
INSERT INTO `osc_user_action` VALUES ('293', '1', 'admin', '后台系统用户', '登录了后台系统', '2017-05-18 09:23:06');
INSERT INTO `osc_user_action` VALUES ('294', '1', 'admin', '后台系统用户', '修改了用户组状态', '2017-05-18 09:27:54');
INSERT INTO `osc_user_action` VALUES ('295', '1', 'admin', '后台系统用户', '修改了用户组状态', '2017-05-18 09:27:56');
INSERT INTO `osc_user_action` VALUES ('296', '1', 'admin', '后台系统用户', '修改了会员用户组状态', '2017-05-18 09:31:27');
INSERT INTO `osc_user_action` VALUES ('297', '1', 'admin', '后台系统用户', '修改了会员用户组状态', '2017-05-18 09:31:29');
INSERT INTO `osc_user_action` VALUES ('298', '6', 'ye', '网站会员', '登录了网站', '2017-05-18 10:27:09');
INSERT INTO `osc_user_action` VALUES ('299', '6', 'ye', '网站会员', '登录了网站', '2017-05-18 18:08:43');
INSERT INTO `osc_user_action` VALUES ('300', '6', 'ye', '网站会员', '登录了网站', '2017-05-18 18:09:16');
INSERT INTO `osc_user_action` VALUES ('301', '1', 'admin', '后台系统用户', '登录了后台系统', '2017-05-19 09:05:07');
INSERT INTO `osc_user_action` VALUES ('302', '6', 'ye', '网站会员', '登录了网站', '2017-05-19 09:30:24');
INSERT INTO `osc_user_action` VALUES ('303', '5', 'cheny', '网站会员', '登录了网站', '2017-05-19 15:14:58');
INSERT INTO `osc_user_action` VALUES ('304', '5', 'cheny', '网站会员', '修改了报名项目 ', '2017-05-19 15:15:18');
INSERT INTO `osc_user_action` VALUES ('305', '5', 'cheny', '网站会员', '修改了报名项目 ', '2017-05-19 15:15:44');
SET FOREIGN_KEY_CHECKS=1;
