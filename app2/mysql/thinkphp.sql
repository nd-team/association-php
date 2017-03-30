/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : thinkphp

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-11-26 08:41:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ike_add_friends_request`
-- ----------------------------
DROP TABLE IF EXISTS `ike_add_friends_request`;
CREATE TABLE `ike_add_friends_request` (
  `tu_id` int(10) NOT NULL COMMENT '用户id',
  `f_tu_id` int(10) unsigned NOT NULL COMMENT '被请求用户id',
  `vsername` varchar(30) NOT NULL COMMENT '被请求用户昵称',
  `note` varchar(255) DEFAULT NULL COMMENT '申请附言',
  `addtime` datetime NOT NULL COMMENT '申请时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_add_friends_request
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_admin`
-- ----------------------------
DROP TABLE IF EXISTS `ike_admin`;
CREATE TABLE `ike_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `admin_name` char(20) NOT NULL COMMENT '管理员账号',
  `vsername` char(20) NOT NULL COMMENT '昵称',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `avatar_id` int(10) unsigned DEFAULT NULL COMMENT '头像id',
  `mobile` varchar(20) DEFAULT NULL COMMENT '电话',
  `email` varchar(30) DEFAULT NULL COMMENT '邮箱',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '登录状态（0，禁止登录，1，正常登录）',
  `groupid` tinyint(3) unsigned NOT NULL COMMENT '权限类型',
  `gen_time` datetime NOT NULL COMMENT '注册时间',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `last_login_time` datetime NOT NULL COMMENT '上一次登录时间',
  `login_ip` varchar(20) NOT NULL COMMENT '登录ip',
  `count` int(10) unsigned NOT NULL COMMENT '登录次数',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_admin
-- ----------------------------
INSERT INTO `ike_admin` VALUES ('1', 'admin', '管理员', 'e10adc3949ba59abbe56e057f20f883e', null, null, null, '1', '1', '2016-11-25 17:09:55', '2016-11-25 18:16:40', '2016-11-25 18:16:31', '127.0.0.1', '4');

-- ----------------------------
-- Table structure for `ike_admintype`
-- ----------------------------
DROP TABLE IF EXISTS `ike_admintype`;
CREATE TABLE `ike_admintype` (
  `groupid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限类型id',
  `type_name` varchar(30) NOT NULL COMMENT '权限名称',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_admintype
-- ----------------------------
INSERT INTO `ike_admintype` VALUES ('1', '超级管理员');

-- ----------------------------
-- Table structure for `ike_avatar`
-- ----------------------------
DROP TABLE IF EXISTS `ike_avatar`;
CREATE TABLE `ike_avatar` (
  `avatar_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '头像ID',
  `avatar_image` varchar(255) DEFAULT NULL COMMENT '头像图片',
  PRIMARY KEY (`avatar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_avatar
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_config`
-- ----------------------------
DROP TABLE IF EXISTS `ike_config`;
CREATE TABLE `ike_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) NOT NULL COMMENT '配置类型 0.数字 1.字符 2.文本 3.数组 4.枚举',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `group` tinyint(3) NOT NULL DEFAULT '0' COMMENT '配置分组 0.不分组 1.基础 2.内容 3.用户 4.系统',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL COMMENT '配置说明',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text NOT NULL COMMENT '配置值',
  `sort` smallint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `hide` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否隐藏 0.表示否 1表示是（该字段用于标注该配置项是否在后台配置列表中显示出来）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_config
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_friends_user`
-- ----------------------------
DROP TABLE IF EXISTS `ike_friends_user`;
CREATE TABLE `ike_friends_user` (
  `tu_id` int(10) unsigned NOT NULL COMMENT '发送添加好友id',
  `friend_id` int(10) unsigned NOT NULL COMMENT '好友id',
  `addtime` datetime NOT NULL COMMENT '加好友时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_friends_user
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_group_name`
-- ----------------------------
DROP TABLE IF EXISTS `ike_group_name`;
CREATE TABLE `ike_group_name` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '群id',
  `group_name` varchar(30) NOT NULL COMMENT '群名称',
  `group_number` int(10) unsigned NOT NULL COMMENT '群号',
  `tu_id` int(10) NOT NULL COMMENT '创建群用户id',
  `addtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_group_name
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_group_notice`
-- ----------------------------
DROP TABLE IF EXISTS `ike_group_notice`;
CREATE TABLE `ike_group_notice` (
  `notice_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '群公告id',
  `group_id` int(10) unsigned NOT NULL COMMENT '群id',
  `tu_id` int(10) unsigned NOT NULL COMMENT '发布用户id',
  `nitece_content` varchar(255) NOT NULL COMMENT '公告内容',
  `addtime` datetime NOT NULL COMMENT '添加公告时间',
  PRIMARY KEY (`notice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_group_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_group_sys_msg`
-- ----------------------------
DROP TABLE IF EXISTS `ike_group_sys_msg`;
CREATE TABLE `ike_group_sys_msg` (
  `group_msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '群系统消息id',
  `group_id` int(10) unsigned NOT NULL COMMENT '群id',
  `tu_id` int(10) unsigned NOT NULL COMMENT '消息用户id',
  `type` tinyint(2) NOT NULL COMMENT '消息类型{1:申请加群,2:已加入群,3:退出群,4:踢出群,5:邀请加群}',
  `content` varchar(200) DEFAULT NULL COMMENT '消息内容',
  `addtime` datetime NOT NULL COMMENT '消息时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态{0:未读,1:已读}',
  PRIMARY KEY (`group_msg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_group_sys_msg
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_group_user`
-- ----------------------------
DROP TABLE IF EXISTS `ike_group_user`;
CREATE TABLE `ike_group_user` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '群成员编号id',
  `group_id` int(10) unsigned NOT NULL COMMENT '群id',
  `tu_id` int(10) unsigned NOT NULL COMMENT '用户id',
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_group_user
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_home_notification`
-- ----------------------------
DROP TABLE IF EXISTS `ike_home_notification`;
CREATE TABLE `ike_home_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知id',
  `tu_id` int(10) unsigned NOT NULL COMMENT '通知用户id',
  `type` varchar(20) NOT NULL COMMENT '通知类型{“friend”好友申请}',
  `new` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '通知是否为新:"1"为新通知,"0"为通知已读 ',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_home_notification
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_loginlog`
-- ----------------------------
DROP TABLE IF EXISTS `ike_loginlog`;
CREATE TABLE `ike_loginlog` (
  `id_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_content` varchar(200) NOT NULL COMMENT '后台登录失败日志内容',
  `log_ip` char(30) NOT NULL COMMENT '登录ip',
  `log_address` varchar(50) NOT NULL COMMENT '访问地址',
  `log_login_time` datetime NOT NULL COMMENT '登录时间',
  PRIMARY KEY (`id_log`)
) ENGINE=MyISAM AUTO_INCREMENT=168 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_loginlog
-- ----------------------------
INSERT INTO `ike_loginlog` VALUES ('1', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1]', '127.0.0.1', '', '2016-11-17 14:29:23');
INSERT INTO `ike_loginlog` VALUES ('2', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1]', '127.0.0.1', '', '2016-11-17 14:32:39');
INSERT INTO `ike_loginlog` VALUES ('3', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] ', '127.0.0.1', '', '2016-11-17 14:58:41');
INSERT INTO `ike_loginlog` VALUES ('4', ' 登录失败, login_name:[123123] password:[123123] 访问者ip:[127.0.0.1] ', '127.0.0.1', '', '2016-11-17 14:59:01');
INSERT INTO `ike_loginlog` VALUES ('5', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] ', '127.0.0.1', '', '2016-11-17 15:08:13');
INSERT INTO `ike_loginlog` VALUES ('6', ' 登录失败, login_name:[fafaf] password:[fafaf] 访问者ip:[127.0.0.1] ', '127.0.0.1', '', '2016-11-17 15:08:31');
INSERT INTO `ike_loginlog` VALUES ('7', ' 登录失败, login_name:[fffff] password:[fffff] 访问者ip:[192.168.0.175] ', '192.168.0.175', '', '2016-11-17 15:08:54');
INSERT INTO `ike_loginlog` VALUES ('8', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:11:11');
INSERT INTO `ike_loginlog` VALUES ('9', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:11:24');
INSERT INTO `ike_loginlog` VALUES ('10', ' 登录失败, login_name:[打发] password:[打发] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:12:49');
INSERT INTO `ike_loginlog` VALUES ('11', ' 登录失败, login_name:[打发] password:[打发] 访问者ip:[127.0.0.1] ', '127.0.0.1', '', '2016-11-17 15:13:11');
INSERT INTO `ike_loginlog` VALUES ('12', ' 登录失败, login_name:[打发] password:[打发] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:13:40');
INSERT INTO `ike_loginlog` VALUES ('13', ' 登录失败, login_name:[打发] password:[打发] 访问者ip:[127.0.0.1] ', '127.0.0.1', '', '2016-11-17 15:14:15');
INSERT INTO `ike_loginlog` VALUES ('14', ' 登录失败, login_name:[打发] password:[打发] 访问者ip:[] address:[]', '127.0.0.1', '', '2016-11-17 15:14:59');
INSERT INTO `ike_loginlog` VALUES ('15', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:16:10');
INSERT INTO `ike_loginlog` VALUES ('16', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:16:21');
INSERT INTO `ike_loginlog` VALUES ('17', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:16:49');
INSERT INTO `ike_loginlog` VALUES ('18', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[]', '127.0.0.1', '', '2016-11-17 15:20:02');
INSERT INTO `ike_loginlog` VALUES ('19', ' 登录失败, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '', '2016-11-17 15:20:26');
INSERT INTO `ike_loginlog` VALUES ('20', ' 登录失败, login_name:[ff] password:[ff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-18 17:02:24');
INSERT INTO `ike_loginlog` VALUES ('21', ' 登录失败, login_name:[ff] password:[ff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-18 17:22:51');
INSERT INTO `ike_loginlog` VALUES ('22', ' 登录失败, login_name:[ff] password:[ff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-18 17:23:56');
INSERT INTO `ike_loginlog` VALUES ('23', ' 登录失败, login_name:[ff] password:[ff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-18 17:24:40');
INSERT INTO `ike_loginlog` VALUES ('24', ' 登录失败, login_name:[1111] password:[1111] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-18 18:16:23');
INSERT INTO `ike_loginlog` VALUES ('25', ' 登录失败, login_name:[AAA] password:[AAA] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 08:44:49');
INSERT INTO `ike_loginlog` VALUES ('26', ' 登录失败, login_name:[ADMIN] password:[ADMIN] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 08:56:58');
INSERT INTO `ike_loginlog` VALUES ('27', ' 登录失败, login_name:[ADMIN] password:[ADMIN] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 08:57:11');
INSERT INTO `ike_loginlog` VALUES ('28', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:30:35');
INSERT INTO `ike_loginlog` VALUES ('29', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:31:37');
INSERT INTO `ike_loginlog` VALUES ('30', ' 登录成功, login_name:[afaf] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:40:02');
INSERT INTO `ike_loginlog` VALUES ('31', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:40:12');
INSERT INTO `ike_loginlog` VALUES ('32', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:48:41');
INSERT INTO `ike_loginlog` VALUES ('33', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:56:37');
INSERT INTO `ike_loginlog` VALUES ('34', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:56:45');
INSERT INTO `ike_loginlog` VALUES ('35', ' 登录成功, login_name:[fffffffff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:57:45');
INSERT INTO `ike_loginlog` VALUES ('36', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:58:33');
INSERT INTO `ike_loginlog` VALUES ('37', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 09:58:55');
INSERT INTO `ike_loginlog` VALUES ('38', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:00:08');
INSERT INTO `ike_loginlog` VALUES ('39', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:01:40');
INSERT INTO `ike_loginlog` VALUES ('40', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:03:21');
INSERT INTO `ike_loginlog` VALUES ('41', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:08:48');
INSERT INTO `ike_loginlog` VALUES ('42', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:10:30');
INSERT INTO `ike_loginlog` VALUES ('43', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:11:33');
INSERT INTO `ike_loginlog` VALUES ('44', ' 登录失败,密码出错, login_name:[admin] password:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:12:33');
INSERT INTO `ike_loginlog` VALUES ('45', ' 登录失败,密码出错, login_name:[admin] password:[fffffffffffaaa] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:13:30');
INSERT INTO `ike_loginlog` VALUES ('46', ' 登录失败,密码出错, login_name:[admin] password:[ffffffff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:14:30');
INSERT INTO `ike_loginlog` VALUES ('47', ' 登录失败,密码出错, login_name:[admin] password:[fffffffffff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:14:44');
INSERT INTO `ike_loginlog` VALUES ('48', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:14:56');
INSERT INTO `ike_loginlog` VALUES ('49', ' 登录失败,密码出错, login_name:[admin] password:[fafafff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:15:48');
INSERT INTO `ike_loginlog` VALUES ('50', ' 登录失败,密码出错, login_name:[admin] password:[fafafff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:15:58');
INSERT INTO `ike_loginlog` VALUES ('51', ' 账号不存在, login_name:[admindd] password:[fafafff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:16:06');
INSERT INTO `ike_loginlog` VALUES ('52', ' 账号不存在, login_name:[\' or 1=1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:16:47');
INSERT INTO `ike_loginlog` VALUES ('53', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:18:40');
INSERT INTO `ike_loginlog` VALUES ('54', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:18:56');
INSERT INTO `ike_loginlog` VALUES ('55', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:21:47');
INSERT INTO `ike_loginlog` VALUES ('56', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:21:57');
INSERT INTO `ike_loginlog` VALUES ('57', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:25:45');
INSERT INTO `ike_loginlog` VALUES ('58', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:26:08');
INSERT INTO `ike_loginlog` VALUES ('59', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:26:31');
INSERT INTO `ike_loginlog` VALUES ('60', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:26:43');
INSERT INTO `ike_loginlog` VALUES ('61', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 10:26:59');
INSERT INTO `ike_loginlog` VALUES ('62', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 11:31:50');
INSERT INTO `ike_loginlog` VALUES ('63', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 11:32:03');
INSERT INTO `ike_loginlog` VALUES ('64', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 11:32:29');
INSERT INTO `ike_loginlog` VALUES ('65', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 11:34:29');
INSERT INTO `ike_loginlog` VALUES ('66', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 14:35:35');
INSERT INTO `ike_loginlog` VALUES ('67', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 14:45:53');
INSERT INTO `ike_loginlog` VALUES ('68', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 14:46:17');
INSERT INTO `ike_loginlog` VALUES ('69', ' 账号不存在, login_name:[amdin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:00:07');
INSERT INTO `ike_loginlog` VALUES ('70', ' 账号不存在, login_name:[amdin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:00:23');
INSERT INTO `ike_loginlog` VALUES ('71', ' 账号不存在, login_name:[amdin1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:00:39');
INSERT INTO `ike_loginlog` VALUES ('72', ' 账号不存在, login_name:[amdin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:00:54');
INSERT INTO `ike_loginlog` VALUES ('73', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:04:05');
INSERT INTO `ike_loginlog` VALUES ('74', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:04:26');
INSERT INTO `ike_loginlog` VALUES ('75', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:12:27');
INSERT INTO `ike_loginlog` VALUES ('76', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:12:36');
INSERT INTO `ike_loginlog` VALUES ('77', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:13:45');
INSERT INTO `ike_loginlog` VALUES ('78', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:13:58');
INSERT INTO `ike_loginlog` VALUES ('79', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:15:42');
INSERT INTO `ike_loginlog` VALUES ('80', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:16:50');
INSERT INTO `ike_loginlog` VALUES ('81', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:17:06');
INSERT INTO `ike_loginlog` VALUES ('82', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:17:55');
INSERT INTO `ike_loginlog` VALUES ('83', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:19:03');
INSERT INTO `ike_loginlog` VALUES ('84', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:21:25');
INSERT INTO `ike_loginlog` VALUES ('85', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:21:54');
INSERT INTO `ike_loginlog` VALUES ('86', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:22:32');
INSERT INTO `ike_loginlog` VALUES ('87', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:22:43');
INSERT INTO `ike_loginlog` VALUES ('88', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:23:14');
INSERT INTO `ike_loginlog` VALUES ('89', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:24:08');
INSERT INTO `ike_loginlog` VALUES ('90', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:24:41');
INSERT INTO `ike_loginlog` VALUES ('91', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:24:57');
INSERT INTO `ike_loginlog` VALUES ('92', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:26:04');
INSERT INTO `ike_loginlog` VALUES ('93', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:27:03');
INSERT INTO `ike_loginlog` VALUES ('94', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:27:19');
INSERT INTO `ike_loginlog` VALUES ('95', ' 登录成功, login_name:[admin1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:27:32');
INSERT INTO `ike_loginlog` VALUES ('96', ' 账号不存在, login_name:[admin1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:28:20');
INSERT INTO `ike_loginlog` VALUES ('97', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:28:31');
INSERT INTO `ike_loginlog` VALUES ('98', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:29:13');
INSERT INTO `ike_loginlog` VALUES ('99', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:29:24');
INSERT INTO `ike_loginlog` VALUES ('100', ' 账号不存在, login_name:[admin2111] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:29:45');
INSERT INTO `ike_loginlog` VALUES ('101', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:31:08');
INSERT INTO `ike_loginlog` VALUES ('102', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:31:39');
INSERT INTO `ike_loginlog` VALUES ('103', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:31:54');
INSERT INTO `ike_loginlog` VALUES ('104', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:33:00');
INSERT INTO `ike_loginlog` VALUES ('105', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:33:13');
INSERT INTO `ike_loginlog` VALUES ('106', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:33:36');
INSERT INTO `ike_loginlog` VALUES ('107', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:34:35');
INSERT INTO `ike_loginlog` VALUES ('108', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:34:46');
INSERT INTO `ike_loginlog` VALUES ('109', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:35:20');
INSERT INTO `ike_loginlog` VALUES ('110', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:35:32');
INSERT INTO `ike_loginlog` VALUES ('111', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:35:44');
INSERT INTO `ike_loginlog` VALUES ('112', ' 账号不存在, login_name:[1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:36:03');
INSERT INTO `ike_loginlog` VALUES ('113', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:36:11');
INSERT INTO `ike_loginlog` VALUES ('114', ' 账号不存在, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:36:26');
INSERT INTO `ike_loginlog` VALUES ('115', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:36:45');
INSERT INTO `ike_loginlog` VALUES ('116', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:36:59');
INSERT INTO `ike_loginlog` VALUES ('117', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:37:09');
INSERT INTO `ike_loginlog` VALUES ('118', ' 账号不存在, login_name:[1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:37:21');
INSERT INTO `ike_loginlog` VALUES ('119', ' 登录成功, login_name:[1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:38:05');
INSERT INTO `ike_loginlog` VALUES ('120', ' 账号不存在, login_name:[1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:38:40');
INSERT INTO `ike_loginlog` VALUES ('121', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 15:55:57');
INSERT INTO `ike_loginlog` VALUES ('122', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 16:59:42');
INSERT INTO `ike_loginlog` VALUES ('123', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 17:03:00');
INSERT INTO `ike_loginlog` VALUES ('124', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 17:27:59');
INSERT INTO `ike_loginlog` VALUES ('125', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 17:31:17');
INSERT INTO `ike_loginlog` VALUES ('126', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-19 17:39:16');
INSERT INTO `ike_loginlog` VALUES ('127', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-21 09:05:38');
INSERT INTO `ike_loginlog` VALUES ('128', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-21 09:09:20');
INSERT INTO `ike_loginlog` VALUES ('129', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-21 09:09:59');
INSERT INTO `ike_loginlog` VALUES ('130', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-21 09:10:30');
INSERT INTO `ike_loginlog` VALUES ('131', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-21 10:35:11');
INSERT INTO `ike_loginlog` VALUES ('132', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-21 10:37:18');
INSERT INTO `ike_loginlog` VALUES ('133', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-22 11:22:18');
INSERT INTO `ike_loginlog` VALUES ('134', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-22 11:23:13');
INSERT INTO `ike_loginlog` VALUES ('135', ' 登录成功, login_name:[admin] 访问者ip:[192.168.0.139] address:[广东广州]', '192.168.0.139', '广东广州', '2016-11-22 11:29:23');
INSERT INTO `ike_loginlog` VALUES ('136', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-22 11:30:51');
INSERT INTO `ike_loginlog` VALUES ('137', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-22 11:57:20');
INSERT INTO `ike_loginlog` VALUES ('138', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 09:44:40');
INSERT INTO `ike_loginlog` VALUES ('139', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 09:50:51');
INSERT INTO `ike_loginlog` VALUES ('140', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 09:51:31');
INSERT INTO `ike_loginlog` VALUES ('141', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 09:57:36');
INSERT INTO `ike_loginlog` VALUES ('142', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 09:58:15');
INSERT INTO `ike_loginlog` VALUES ('143', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 09:59:23');
INSERT INTO `ike_loginlog` VALUES ('144', ' 账号已禁止，请联系管理员, login_name:[ike] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:04:20');
INSERT INTO `ike_loginlog` VALUES ('145', ' 账号已禁止，请联系管理员, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:05:05');
INSERT INTO `ike_loginlog` VALUES ('146', ' 账号已禁止，请联系管理员, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:05:13');
INSERT INTO `ike_loginlog` VALUES ('147', ' 账号已禁止，请联系管理员, login_name:[ike] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:05:23');
INSERT INTO `ike_loginlog` VALUES ('148', ' 账号已禁止，请联系管理员, login_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:05:30');
INSERT INTO `ike_loginlog` VALUES ('149', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:08:44');
INSERT INTO `ike_loginlog` VALUES ('150', ' 登录成功, login_name:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:09:03');
INSERT INTO `ike_loginlog` VALUES ('151', ' 登录成功, login_name:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:09:27');
INSERT INTO `ike_loginlog` VALUES ('152', ' 账号已禁止，请联系管理员, login_name:[ike] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:10:16');
INSERT INTO `ike_loginlog` VALUES ('153', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:10:24');
INSERT INTO `ike_loginlog` VALUES ('154', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:12:33');
INSERT INTO `ike_loginlog` VALUES ('155', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 10:39:45');
INSERT INTO `ike_loginlog` VALUES ('156', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 17:29:21');
INSERT INTO `ike_loginlog` VALUES ('157', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 17:32:00');
INSERT INTO `ike_loginlog` VALUES ('158', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-23 18:23:31');
INSERT INTO `ike_loginlog` VALUES ('159', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-24 11:40:50');
INSERT INTO `ike_loginlog` VALUES ('160', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-24 11:48:16');
INSERT INTO `ike_loginlog` VALUES ('161', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-24 11:50:14');
INSERT INTO `ike_loginlog` VALUES ('162', ' 登录成功, login_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-24 11:52:26');
INSERT INTO `ike_loginlog` VALUES ('163', ' 账号不存在, admin_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-25 17:08:56');
INSERT INTO `ike_loginlog` VALUES ('164', ' 账号不存在, admin_name:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-25 17:09:04');
INSERT INTO `ike_loginlog` VALUES ('165', ' 登录成功, admin_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-25 17:10:25');
INSERT INTO `ike_loginlog` VALUES ('166', ' 登录成功, admin_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-25 18:15:05');
INSERT INTO `ike_loginlog` VALUES ('167', ' 登录成功, admin_name:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-25 18:16:40');

-- ----------------------------
-- Table structure for `ike_messages`
-- ----------------------------
DROP TABLE IF EXISTS `ike_messages`;
CREATE TABLE `ike_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '聊天信息id',
  `from_tu_id` int(10) unsigned NOT NULL COMMENT '发送信息用户id',
  `to_tu_id` int(10) unsigned NOT NULL COMMENT '收到信息用户id',
  `message_time` datetime NOT NULL COMMENT '发送时间',
  `message_status` tinyint(1) unsigned NOT NULL COMMENT '对方用户是否在线（0为不在线，1为在线）',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_messages
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_user`
-- ----------------------------
DROP TABLE IF EXISTS `ike_user`;
CREATE TABLE `ike_user` (
  `tu_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '会员id',
  `token` varchar(64) NOT NULL COMMENT 'token',
  `login_name` char(20) NOT NULL COMMENT '登录账号',
  `vsername` varchar(64) NOT NULL COMMENT '昵称',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别(0保密，1男，2女)',
  `email` varchar(45) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(20) DEFAULT NULL COMMENT '电话号码',
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `birth_date` date DEFAULT NULL COMMENT '生日',
  `age` tinyint(3) unsigned DEFAULT NULL COMMENT '年龄',
  `avatar_id` int(10) unsigned DEFAULT NULL COMMENT '头像id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '登录状态（0，禁止登录，1，正常登录）',
  `gen_time` datetime NOT NULL COMMENT '注册时间',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `last_login_time` datetime NOT NULL COMMENT '上一次登录时间',
  `login_ip` varchar(255) NOT NULL COMMENT '登录ip',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户在线状态(0不在线1在线)',
  `count` int(10) unsigned NOT NULL COMMENT '登录次数',
  PRIMARY KEY (`tu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_user
-- ----------------------------
INSERT INTO `ike_user` VALUES ('1', 'cakhfklafa1341646464', '13025304562', '小明', '123456', '0', '1453171@qq.com', '13025304562', '广州市', '2016-11-25', '16', null, '1', '2016-11-25 17:14:04', '2016-11-25 17:14:07', '2016-11-25 17:14:09', '127.0.0.1', '1', '1');
INSERT INTO `ike_user` VALUES ('2', 'afafafaf4646464', '13568530477', '小红', '123456', '1', '145341@qq.com', null, null, null, null, null, '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
