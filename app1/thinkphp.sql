/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : thinkphp

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-01-10 13:48:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `ike_actives`
-- ----------------------------
DROP TABLE IF EXISTS `ike_actives`;
CREATE TABLE `ike_actives` (
  `actives_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `actives_title` varchar(64) NOT NULL COMMENT '活动标题',
  `avatar_id` int(10) NOT NULL DEFAULT '2' COMMENT '活动头像',
  `actives_content` text NOT NULL COMMENT '活动内容',
  `actives_limit` mediumint(5) unsigned NOT NULL DEFAULT '0' COMMENT '活动限制人数(0为不限人数)',
  `actives_start` datetime NOT NULL COMMENT '活动开始时间',
  `actives_end` datetime NOT NULL COMMENT '活动结束时间',
  `actives_address` char(30) NOT NULL COMMENT '活动地点',
  `tu_id` char(20) NOT NULL COMMENT '活动创建人',
  `group_id` int(10) NOT NULL COMMENT '活动群id',
  PRIMARY KEY (`actives_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_actives
-- ----------------------------
INSERT INTO `ike_actives` VALUES ('1', '活动1', '1', '今天活动开始了', '100', '2016-12-12 16:12:20', '2016-12-14 16:12:20', '广州', '13025304563', '201359');
INSERT INTO `ike_actives` VALUES ('2', '22', '2', '11', '0', '2016-12-15 13:00:00', '2016-12-16 13:00:00', '11', '18819493906', '712458');
INSERT INTO `ike_actives` VALUES ('3', '111', '2', '11', '0', '2016-12-15 16:03:00', '2016-12-16 16:03:00', '11', '18819493900', '713567');
INSERT INTO `ike_actives` VALUES ('4', '搜索', '2', 'SSSSS发SSSSSSSSSSSSSSSSSSSSSSSSS', '0', '2016-12-30 17:00:00', '2016-12-30 17:00:00', '是多少', '18819493903', '902468');
INSERT INTO `ike_actives` VALUES ('5', 'DFS ', '2', '是大法师', '0', '2016-12-28 17:00:00', '2016-12-30 17:00:00', '胜多负少', '18819493903', '902468');
INSERT INTO `ike_actives` VALUES ('6', '空', '2', '空', '0', '2016-12-28 17:00:00', '2017-12-28 17:00:00', '空', '13025304562', '202689');
INSERT INTO `ike_actives` VALUES ('7', 'WW', '175', 'rere', '0', '2016-12-28 18:01:00', '2016-12-29 18:01:00', '12', '18819493903', '845678');
INSERT INTO `ike_actives` VALUES ('8', '头绪', '2', '图', '0', '2016-12-28 18:01:00', '2016-12-28 18:01:00', '弄', '13025304562', '516789');
INSERT INTO `ike_actives` VALUES ('9', 'sdsa', '177', '是打发', '0', '2016-12-29 09:03:00', '2016-12-30 09:03:00', '撒', '18819493903', '845678');
INSERT INTO `ike_actives` VALUES ('10', '阿斯蒂芬', '178', '是否', '0', '2016-12-29 09:03:00', '2016-12-30 09:03:00', 's安抚ssssssssssssssssssssss', '18819493903', '845678');
INSERT INTO `ike_actives` VALUES ('11', '咯', '187', '我我', '0', '2017-01-02 23:00:00', '2019-01-02 23:00:00', '我我', '13025304562', '302578');

-- ----------------------------
-- Table structure for `ike_actives_join`
-- ----------------------------
DROP TABLE IF EXISTS `ike_actives_join`;
CREATE TABLE `ike_actives_join` (
  `actives_id` int(10) NOT NULL COMMENT '活动id',
  `tu_id` char(20) NOT NULL COMMENT '用户id'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_actives_join
-- ----------------------------
INSERT INTO `ike_actives_join` VALUES ('1', '13025304562');
INSERT INTO `ike_actives_join` VALUES ('1', '13025304563');
INSERT INTO `ike_actives_join` VALUES ('2', '18819493906');
INSERT INTO `ike_actives_join` VALUES ('3', '18819493900');
INSERT INTO `ike_actives_join` VALUES ('4', '18819493903');
INSERT INTO `ike_actives_join` VALUES ('5', '18819493903');
INSERT INTO `ike_actives_join` VALUES ('6', '13025304562');
INSERT INTO `ike_actives_join` VALUES ('7', '18819493903');
INSERT INTO `ike_actives_join` VALUES ('8', '13025304562');
INSERT INTO `ike_actives_join` VALUES ('9', '18819493903');
INSERT INTO `ike_actives_join` VALUES ('10', '18819493903');
INSERT INTO `ike_actives_join` VALUES ('11', '13025304562');

-- ----------------------------
-- Table structure for `ike_add_friends_request`
-- ----------------------------
DROP TABLE IF EXISTS `ike_add_friends_request`;
CREATE TABLE `ike_add_friends_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `tu_id` char(20) NOT NULL COMMENT '用户id',
  `f_tu_id` char(20) NOT NULL COMMENT '被请求用户id',
  `nickname` varchar(64) DEFAULT NULL COMMENT '昵称',
  `note` varchar(255) DEFAULT NULL COMMENT '申请附言',
  `addtime` datetime NOT NULL COMMENT '申请时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0已拒绝 1已同意 2已忽略 3未读',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_add_friends_request
-- ----------------------------
INSERT INTO `ike_add_friends_request` VALUES ('37', '13025304562', '18819493903', '红米', '匿名', '2016-12-31 16:13:13', '2');
INSERT INTO `ike_add_friends_request` VALUES ('38', '18819493904', '18819493903', '小四', '小四', '2017-01-05 10:12:38', '1');
INSERT INTO `ike_add_friends_request` VALUES ('39', '15778884615', '13025304562', '花梨', '李东英', '2017-01-05 14:44:52', '1');
INSERT INTO `ike_add_friends_request` VALUES ('40', '13025304562', '18819493904', '红米', null, '2017-01-05 15:21:28', '2');
INSERT INTO `ike_add_friends_request` VALUES ('41', '18819493900', '18819493901', '小玲', '我是小玲', '2017-01-07 11:20:59', '0');
INSERT INTO `ike_add_friends_request` VALUES ('42', '18819493901', '18819493900', '小一', '我是小一', '2017-01-07 11:16:12', '0');
INSERT INTO `ike_add_friends_request` VALUES ('43', '18819493901', '18819493902', '小一', '我是小一', '2017-01-07 11:30:33', '0');
INSERT INTO `ike_add_friends_request` VALUES ('44', '18819493901', '18819493903', '小一', '我是小一', '2017-01-07 11:30:44', '0');
INSERT INTO `ike_add_friends_request` VALUES ('45', '18819493900', '18819493903', '小玲', '小玲', '2017-01-07 11:58:07', '0');
INSERT INTO `ike_add_friends_request` VALUES ('46', '18819493900', '18819493904', '小玲', '谢谢', '2017-01-07 11:58:14', '0');
INSERT INTO `ike_add_friends_request` VALUES ('47', '18819493900', '18819493905', '小玲', '收到', '2017-01-07 11:58:23', '0');
INSERT INTO `ike_add_friends_request` VALUES ('48', '18819493903', '18819493908', '小三', '我是下班', '2017-01-09 15:36:06', '1');

-- ----------------------------
-- Table structure for `ike_admin`
-- ----------------------------
DROP TABLE IF EXISTS `ike_admin`;
CREATE TABLE `ike_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `admin_name` char(20) NOT NULL COMMENT '管理员账号',
  `nickname` char(20) NOT NULL COMMENT '昵称',
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
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_name` (`admin_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_admin
-- ----------------------------
INSERT INTO `ike_admin` VALUES ('1', 'admin', '管理员', '25f9e794323b453885f5181f1b624d0b', '1', '130-2530-4562', '1451@qq.com', '1', '2', '2016-11-25 17:09:55', '2017-01-07 15:00:54', '2017-01-07 10:16:33', '127.0.0.1', '295');
INSERT INTO `ike_admin` VALUES ('2', 'ike', '普通管理员', 'e10adc3949ba59abbe56e057f20f883e', '20', '130-2530-4562', '1453171283@qq.com', '1', '2', '0000-00-00 00:00:00', '2016-12-31 11:01:48', '2016-12-31 11:02:10', '127.0.0.1', '71');

-- ----------------------------
-- Table structure for `ike_admintype`
-- ----------------------------
DROP TABLE IF EXISTS `ike_admintype`;
CREATE TABLE `ike_admintype` (
  `groupid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限类型id',
  `type_name` varchar(30) NOT NULL COMMENT '权限名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（0，禁止，1，正常）',
  `rules` char(80) NOT NULL DEFAULT '12,' COMMENT '规则id， 多个规则","隔开',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_admintype
-- ----------------------------
INSERT INTO `ike_admintype` VALUES ('1', '超级管理员', '1', '12,31,2,3,4,5,6,7,8,9,10,11,14,13,15,');
INSERT INTO `ike_admintype` VALUES ('2', '普通管理员', '1', '12,31,32,18,2,3,4,5,6,28,7,8,9,10,11,17,29,14,19,20,23,30,33,39,40,13,15,21,36,3');
INSERT INTO `ike_admintype` VALUES ('4', '游客', '1', '1');

-- ----------------------------
-- Table structure for `ike_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `ike_auth_rule`;
CREATE TABLE `ike_auth_rule` (
  `rule_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '权限规则id',
  `title` varchar(50) NOT NULL COMMENT '菜单标题',
  `model` char(10) NOT NULL COMMENT '所属模块',
  `sort` int(6) NOT NULL DEFAULT '1' COMMENT '排序',
  `pid` int(6) NOT NULL DEFAULT '0' COMMENT '父级菜单ID',
  `url` varchar(50) NOT NULL COMMENT '规则url英文标识',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态0禁用1正常',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_auth_rule
-- ----------------------------
INSERT INTO `ike_auth_rule` VALUES ('18', '系统', 'admin', '1', '0', '/admin/system', '1');
INSERT INTO `ike_auth_rule` VALUES ('2', '菜单管理', 'admin', '1', '18', '/admin/menus', '1');
INSERT INTO `ike_auth_rule` VALUES ('3', '菜单列表', 'admin', '1', '2', '/admin/menus/index', '1');
INSERT INTO `ike_auth_rule` VALUES ('4', '编辑菜单', 'admin', '1', '2', '/admin/menus/edit', '1');
INSERT INTO `ike_auth_rule` VALUES ('5', '添加菜单', 'admin', '2', '2', '/admin/menus/add', '1');
INSERT INTO `ike_auth_rule` VALUES ('6', '删除菜单', 'admin', '1', '2', '/admin/menus/del', '1');
INSERT INTO `ike_auth_rule` VALUES ('7', '权限管理', 'admin', '1', '18', '/admin/group', '1');
INSERT INTO `ike_auth_rule` VALUES ('8', '权限组显示', 'admin', '1', '7', '/admin/group/index', '1');
INSERT INTO `ike_auth_rule` VALUES ('9', '权限组编辑', 'admin', '1', '7', '/admin/group/edit', '1');
INSERT INTO `ike_auth_rule` VALUES ('10', '权限组添加', 'admin', '1', '7', '/admin/group/add', '1');
INSERT INTO `ike_auth_rule` VALUES ('11', '权限规则', 'admin', '1', '7', '/admin/group/access', '1');
INSERT INTO `ike_auth_rule` VALUES ('12', '首页', 'admin', '0', '0', '/admin/index/index', '1');
INSERT INTO `ike_auth_rule` VALUES ('13', '手机用户', 'admin', '1', '0', '/admin/user', '1');
INSERT INTO `ike_auth_rule` VALUES ('14', '管理员管理', 'admin', '1', '18', '/admin/adminuser', '1');
INSERT INTO `ike_auth_rule` VALUES ('15', '会员', 'admin', '1', '13', '/admin/appuser', '1');
INSERT INTO `ike_auth_rule` VALUES ('16', '会员群组管理', 'admin', '1', '13', '/admin/appgroup', '1');
INSERT INTO `ike_auth_rule` VALUES ('17', '删除权限', 'admin', '1', '7', '/admin/group/del', '1');
INSERT INTO `ike_auth_rule` VALUES ('19', '管理员修改', 'admin', '1', '14', '/admin/adminuser/edit', '1');
INSERT INTO `ike_auth_rule` VALUES ('20', '管理员删除', 'admin', '1', '14', '/admin/adminuser/del', '1');
INSERT INTO `ike_auth_rule` VALUES ('21', '会员列表', 'admin', '1', '15', '/admin/appuser/index', '1');
INSERT INTO `ike_auth_rule` VALUES ('22', '会员群列表', 'admin', '1', '16', '/admin/appgroup/index', '1');
INSERT INTO `ike_auth_rule` VALUES ('23', '管理员列表', 'admin', '1', '14', '/admin/adminuser/index', '1');
INSERT INTO `ike_auth_rule` VALUES ('27', '查看群成员', 'admin', '1', '16', '/admin/appgroup/get_group_users', '1');
INSERT INTO `ike_auth_rule` VALUES ('28', '状态操作', 'admin', '1', '2', '/admin/menus/menus_status', '1');
INSERT INTO `ike_auth_rule` VALUES ('29', '状态操作', 'admin', '1', '7', '/admin/group/group_status', '1');
INSERT INTO `ike_auth_rule` VALUES ('30', '状态操作', 'admin', '1', '14', '/admin/adminuser/adminuser_status', '1');
INSERT INTO `ike_auth_rule` VALUES ('31', '查看个人资料', 'admin', '1', '12', '/admin/admin/index', '1');
INSERT INTO `ike_auth_rule` VALUES ('32', '修改个人资料', 'admin', '1', '12', '/admin/admin/edit', '1');
INSERT INTO `ike_auth_rule` VALUES ('33', '添加管理员', 'admin', '1', '14', '/admin/adminuser/add', '1');
INSERT INTO `ike_auth_rule` VALUES ('36', '会员修改', 'admin', '1', '15', '/admin/appuser/edit', '1');
INSERT INTO `ike_auth_rule` VALUES ('35', '旅游列表', 'admin', '1', '34', '/admin/lv/index', '0');
INSERT INTO `ike_auth_rule` VALUES ('39', '日志管理', 'admin', '1', '18', '/admin/logsys', '1');
INSERT INTO `ike_auth_rule` VALUES ('38', '状态操作', 'admin', '1', '15', '/admin/appuser/status', '1');
INSERT INTO `ike_auth_rule` VALUES ('40', '日志设置', 'admin', '1', '39', '/admin/logsys/index', '1');

-- ----------------------------
-- Table structure for `ike_avatar`
-- ----------------------------
DROP TABLE IF EXISTS `ike_avatar`;
CREATE TABLE `ike_avatar` (
  `avatar_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '头像ID',
  `avatar_image` varchar(255) DEFAULT NULL COMMENT '头像图片',
  PRIMARY KEY (`avatar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=192 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_avatar
-- ----------------------------
INSERT INTO `ike_avatar` VALUES ('1', '/public/effect/assets/avatars/avatar.jpg');
INSERT INTO `ike_avatar` VALUES ('2', '/public/uploads/png');
INSERT INTO `ike_avatar` VALUES ('180', '/public/uploads/app/20161231\\f5a8ac394cdcce9d43adb616ca1ffdd9.jpg');
INSERT INTO `ike_avatar` VALUES ('181', '/public/uploads/app/20161231\\824025de2e14079029d78dabb3f166db.jpg');
INSERT INTO `ike_avatar` VALUES ('182', '/public/uploads/app/20161231\\26df30e17cb067b6df20bce792cadf70.jpg');
INSERT INTO `ike_avatar` VALUES ('183', '/public/uploads/app/20161231\\1e5a909adea4a77fa62afe97c7c0f6ba.jpg');
INSERT INTO `ike_avatar` VALUES ('184', '/public/uploads/app/20161231\\cb6d937c6d5e3ec53fa0b4e7080ca7cc.jpg');
INSERT INTO `ike_avatar` VALUES ('185', '/public/uploads/app/20161231\\9c08d88754bcb24830cd012a20d2065f.jpg');
INSERT INTO `ike_avatar` VALUES ('186', '/public/uploads/app/20170102\\a975f59cd0e7540d7682c02126195dee.jpg');
INSERT INTO `ike_avatar` VALUES ('187', '/public/uploads/app/20170102\\fbd53eff115fc3a0d575befb25c26bff.jpg');
INSERT INTO `ike_avatar` VALUES ('188', '/public/uploads/app/20170105\\0d5f56f336f0acb7a12530ba0938f5d6.jpg');
INSERT INTO `ike_avatar` VALUES ('189', '/public/uploads/app/20170105\\c12aba6df9684758798fd1ecc65ecf51.jpg');
INSERT INTO `ike_avatar` VALUES ('190', '/public/uploads/app/20170107\\6f7b8c2be37c7fcfd265a3b0a3c271da.jpg');
INSERT INTO `ike_avatar` VALUES ('191', '/public/uploads/app/20170107\\89726dc125f302d01780618fcbcabfab.jpg');

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
-- Table structure for `ike_friends_claim`
-- ----------------------------
DROP TABLE IF EXISTS `ike_friends_claim`;
CREATE TABLE `ike_friends_claim` (
  `tu_id` char(20) NOT NULL COMMENT '用户id',
  `claim_user` char(20) NOT NULL COMMENT '认领用户id',
  `claim_time` datetime NOT NULL COMMENT '认领时间'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_friends_claim
-- ----------------------------
INSERT INTO `ike_friends_claim` VALUES ('13025304562', '188194939031', '2017-01-06 17:03:34');
INSERT INTO `ike_friends_claim` VALUES ('13025304562', '18819493903', '2017-01-06 17:06:05');
INSERT INTO `ike_friends_claim` VALUES ('18819493900', '18819493903', '2017-01-06 17:38:11');
INSERT INTO `ike_friends_claim` VALUES ('15778884615', '18819493903', '2017-01-06 18:05:55');
INSERT INTO `ike_friends_claim` VALUES ('13025304562', '18819493901', '2017-01-06 18:08:44');
INSERT INTO `ike_friends_claim` VALUES ('18819493900', '18819493901', '2017-01-06 18:09:33');
INSERT INTO `ike_friends_claim` VALUES ('15778884615', '18819493901', '2017-01-06 18:10:03');

-- ----------------------------
-- Table structure for `ike_friends_user`
-- ----------------------------
DROP TABLE IF EXISTS `ike_friends_user`;
CREATE TABLE `ike_friends_user` (
  `tu_id` char(20) NOT NULL COMMENT '发送添加好友id',
  `friend_id` char(20) NOT NULL COMMENT '好友id',
  `addtime` datetime NOT NULL COMMENT '加好友时间',
  `displayname` char(20) DEFAULT NULL COMMENT '备注名'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_friends_user
-- ----------------------------
INSERT INTO `ike_friends_user` VALUES ('18819493903', '13025304562', '2016-12-31 16:13:43', '小雄');
INSERT INTO `ike_friends_user` VALUES ('13025304562', '18819493903', '2016-12-31 16:13:43', null);
INSERT INTO `ike_friends_user` VALUES ('18819493903', '18819493904', '2017-01-05 10:13:42', null);
INSERT INTO `ike_friends_user` VALUES ('18819493904', '18819493903', '2017-01-05 10:13:42', null);
INSERT INTO `ike_friends_user` VALUES ('13025304562', '15778884615', '2017-01-05 14:44:58', null);
INSERT INTO `ike_friends_user` VALUES ('15778884615', '13025304562', '2017-01-05 14:44:58', null);
INSERT INTO `ike_friends_user` VALUES ('18819493908', '18819493903', '2017-01-09 15:42:10', null);
INSERT INTO `ike_friends_user` VALUES ('18819493903', '18819493908', '2017-01-09 15:42:10', null);

-- ----------------------------
-- Table structure for `ike_group_name`
-- ----------------------------
DROP TABLE IF EXISTS `ike_group_name`;
CREATE TABLE `ike_group_name` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '群id',
  `group_name` varchar(30) NOT NULL COMMENT '群名称',
  `group_number` int(10) unsigned NOT NULL COMMENT '群号',
  `avatar_id` int(10) NOT NULL DEFAULT '1' COMMENT '群头像',
  `tu_id` char(20) NOT NULL COMMENT '创建群用户id',
  `addtime` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_number` (`group_number`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_group_name
-- ----------------------------
INSERT INTO `ike_group_name` VALUES ('75', '哈哈', '812569', '1', '18819493903', '2016-12-31 17:09:13');
INSERT INTO `ike_group_name` VALUES ('76', '他现在', '302578', '186', '13025304562', '2017-01-02 23:53:06');
INSERT INTO `ike_group_name` VALUES ('77', '牛', '702359', '190', '18819493903', '2017-01-07 16:12:54');
INSERT INTO `ike_group_name` VALUES ('78', '地方', '823467', '191', '18819493904', '2017-01-07 16:16:52');

-- ----------------------------
-- Table structure for `ike_group_notice`
-- ----------------------------
DROP TABLE IF EXISTS `ike_group_notice`;
CREATE TABLE `ike_group_notice` (
  `notice_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '群公告id',
  `group_id` int(10) unsigned NOT NULL COMMENT '群id',
  `tu_id` char(20) NOT NULL COMMENT '发布用户id',
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
  `tu_id` char(20) NOT NULL COMMENT '消息用户id',
  `type` tinyint(2) NOT NULL COMMENT '消息类型{1:申请加群,2:已加入群,3:退出群,4:踢出群,5:邀请加群}',
  `content` varchar(200) DEFAULT NULL COMMENT '消息内容',
  `addtime` datetime NOT NULL COMMENT '消息时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态{0:未读,1:已读}',
  PRIMARY KEY (`group_msg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_group_sys_msg
-- ----------------------------
INSERT INTO `ike_group_sys_msg` VALUES ('28', '76', '18819493904', '5', '群主拉人', '2017-01-07 14:47:16', '1');

-- ----------------------------
-- Table structure for `ike_group_user`
-- ----------------------------
DROP TABLE IF EXISTS `ike_group_user`;
CREATE TABLE `ike_group_user` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '群成员编号id',
  `group_id` int(10) unsigned NOT NULL COMMENT '群id',
  `tu_id` char(20) NOT NULL COMMENT '用户id',
  `nickname` char(20) DEFAULT NULL COMMENT '个人群昵称',
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_group_user
-- ----------------------------
INSERT INTO `ike_group_user` VALUES ('144', '75', '18819493903', '手机');
INSERT INTO `ike_group_user` VALUES ('145', '75', '13025304562', '红米');
INSERT INTO `ike_group_user` VALUES ('146', '76', '13025304562', '红米');
INSERT INTO `ike_group_user` VALUES ('147', '76', '18819493903', '小三');
INSERT INTO `ike_group_user` VALUES ('148', '76', '18819493904', '小四');
INSERT INTO `ike_group_user` VALUES ('149', '77', '18819493903', '小三');
INSERT INTO `ike_group_user` VALUES ('150', '77', '18819493904', '小四');
INSERT INTO `ike_group_user` VALUES ('151', '78', '18819493904', '小四');
INSERT INTO `ike_group_user` VALUES ('152', '78', '18819493903', '小三');

-- ----------------------------
-- Table structure for `ike_home_notification`
-- ----------------------------
DROP TABLE IF EXISTS `ike_home_notification`;
CREATE TABLE `ike_home_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知id',
  `tu_id` char(20) NOT NULL COMMENT '通知用户id',
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
) ENGINE=MyISAM AUTO_INCREMENT=569 DEFAULT CHARSET=utf8;

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
INSERT INTO `ike_loginlog` VALUES ('168', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-26 09:02:18');
INSERT INTO `ike_loginlog` VALUES ('169', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-26 09:23:40');
INSERT INTO `ike_loginlog` VALUES ('170', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-26 11:12:29');
INSERT INTO `ike_loginlog` VALUES ('171', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-26 14:45:16');
INSERT INTO `ike_loginlog` VALUES ('172', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-26 16:56:55');
INSERT INTO `ike_loginlog` VALUES ('173', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 10:11:10');
INSERT INTO `ike_loginlog` VALUES ('174', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 10:18:53');
INSERT INTO `ike_loginlog` VALUES ('175', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 11:20:38');
INSERT INTO `ike_loginlog` VALUES ('176', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 11:22:10');
INSERT INTO `ike_loginlog` VALUES ('177', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 11:31:00');
INSERT INTO `ike_loginlog` VALUES ('178', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 11:32:49');
INSERT INTO `ike_loginlog` VALUES ('179', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 11:39:56');
INSERT INTO `ike_loginlog` VALUES ('180', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 11:42:24');
INSERT INTO `ike_loginlog` VALUES ('181', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 12:04:37');
INSERT INTO `ike_loginlog` VALUES ('182', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 12:06:29');
INSERT INTO `ike_loginlog` VALUES ('183', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 12:48:49');
INSERT INTO `ike_loginlog` VALUES ('184', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 13:44:39');
INSERT INTO `ike_loginlog` VALUES ('185', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 13:45:19');
INSERT INTO `ike_loginlog` VALUES ('186', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 13:46:34');
INSERT INTO `ike_loginlog` VALUES ('187', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 14:21:12');
INSERT INTO `ike_loginlog` VALUES ('188', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 14:22:16');
INSERT INTO `ike_loginlog` VALUES ('189', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-28 15:50:07');
INSERT INTO `ike_loginlog` VALUES ('190', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 09:53:59');
INSERT INTO `ike_loginlog` VALUES ('191', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 09:54:30');
INSERT INTO `ike_loginlog` VALUES ('192', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 09:55:29');
INSERT INTO `ike_loginlog` VALUES ('193', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 09:56:40');
INSERT INTO `ike_loginlog` VALUES ('194', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 09:57:12');
INSERT INTO `ike_loginlog` VALUES ('195', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 09:58:20');
INSERT INTO `ike_loginlog` VALUES ('196', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:15:30');
INSERT INTO `ike_loginlog` VALUES ('197', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:16:34');
INSERT INTO `ike_loginlog` VALUES ('198', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:19:04');
INSERT INTO `ike_loginlog` VALUES ('199', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:22:16');
INSERT INTO `ike_loginlog` VALUES ('200', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:24:10');
INSERT INTO `ike_loginlog` VALUES ('201', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:27:46');
INSERT INTO `ike_loginlog` VALUES ('202', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:28:29');
INSERT INTO `ike_loginlog` VALUES ('203', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:29:54');
INSERT INTO `ike_loginlog` VALUES ('204', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:30:17');
INSERT INTO `ike_loginlog` VALUES ('205', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:31:03');
INSERT INTO `ike_loginlog` VALUES ('206', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:31:32');
INSERT INTO `ike_loginlog` VALUES ('207', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:32:21');
INSERT INTO `ike_loginlog` VALUES ('208', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:32:50');
INSERT INTO `ike_loginlog` VALUES ('209', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:40:34');
INSERT INTO `ike_loginlog` VALUES ('210', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:41:05');
INSERT INTO `ike_loginlog` VALUES ('211', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:41:44');
INSERT INTO `ike_loginlog` VALUES ('212', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:43:33');
INSERT INTO `ike_loginlog` VALUES ('213', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:44:30');
INSERT INTO `ike_loginlog` VALUES ('214', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:53:13');
INSERT INTO `ike_loginlog` VALUES ('215', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:53:38');
INSERT INTO `ike_loginlog` VALUES ('216', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:53:51');
INSERT INTO `ike_loginlog` VALUES ('217', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:54:26');
INSERT INTO `ike_loginlog` VALUES ('218', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:55:12');
INSERT INTO `ike_loginlog` VALUES ('219', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 14:58:44');
INSERT INTO `ike_loginlog` VALUES ('220', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 15:00:56');
INSERT INTO `ike_loginlog` VALUES ('221', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 15:02:41');
INSERT INTO `ike_loginlog` VALUES ('222', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 15:09:04');
INSERT INTO `ike_loginlog` VALUES ('223', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 15:09:41');
INSERT INTO `ike_loginlog` VALUES ('224', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 15:10:07');
INSERT INTO `ike_loginlog` VALUES ('225', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-29 15:10:27');
INSERT INTO `ike_loginlog` VALUES ('226', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 08:39:34');
INSERT INTO `ike_loginlog` VALUES ('227', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 09:01:37');
INSERT INTO `ike_loginlog` VALUES ('228', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 09:04:54');
INSERT INTO `ike_loginlog` VALUES ('229', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 09:05:52');
INSERT INTO `ike_loginlog` VALUES ('230', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:06:54');
INSERT INTO `ike_loginlog` VALUES ('231', ' 登录失败,密码出错, 账号名:[admin] password:[123111] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:07:29');
INSERT INTO `ike_loginlog` VALUES ('232', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:07:43');
INSERT INTO `ike_loginlog` VALUES ('233', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:10:11');
INSERT INTO `ike_loginlog` VALUES ('234', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:10:33');
INSERT INTO `ike_loginlog` VALUES ('235', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:11:16');
INSERT INTO `ike_loginlog` VALUES ('236', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:17:03');
INSERT INTO `ike_loginlog` VALUES ('237', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:32:32');
INSERT INTO `ike_loginlog` VALUES ('238', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:33:36');
INSERT INTO `ike_loginlog` VALUES ('239', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:35:07');
INSERT INTO `ike_loginlog` VALUES ('240', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:35:34');
INSERT INTO `ike_loginlog` VALUES ('241', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:36:35');
INSERT INTO `ike_loginlog` VALUES ('242', ' 登录失败,密码出错, 账号名:[admin] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:36:43');
INSERT INTO `ike_loginlog` VALUES ('243', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:38:37');
INSERT INTO `ike_loginlog` VALUES ('244', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:39:52');
INSERT INTO `ike_loginlog` VALUES ('245', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:40:20');
INSERT INTO `ike_loginlog` VALUES ('246', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:41:03');
INSERT INTO `ike_loginlog` VALUES ('247', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:42:02');
INSERT INTO `ike_loginlog` VALUES ('248', ' 账号已禁止，请联系管理员, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:42:34');
INSERT INTO `ike_loginlog` VALUES ('249', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:42:49');
INSERT INTO `ike_loginlog` VALUES ('250', ' 账号已禁止，请联系管理员, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:43:11');
INSERT INTO `ike_loginlog` VALUES ('251', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:43:31');
INSERT INTO `ike_loginlog` VALUES ('252', ' 账号已禁止，请联系管理员, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:44:11');
INSERT INTO `ike_loginlog` VALUES ('253', ' 登录失败,密码出错, 账号名:[ike] password:[1111111] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:44:29');
INSERT INTO `ike_loginlog` VALUES ('254', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:44:56');
INSERT INTO `ike_loginlog` VALUES ('255', ' 登录失败,密码出错, 账号名:[admin] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:45:02');
INSERT INTO `ike_loginlog` VALUES ('256', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:45:26');
INSERT INTO `ike_loginlog` VALUES ('257', ' 登录失败,密码出错, 账号名:[admin] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:45:46');
INSERT INTO `ike_loginlog` VALUES ('258', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:45:52');
INSERT INTO `ike_loginlog` VALUES ('259', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 10:47:17');
INSERT INTO `ike_loginlog` VALUES ('260', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 11:18:02');
INSERT INTO `ike_loginlog` VALUES ('261', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 11:18:08');
INSERT INTO `ike_loginlog` VALUES ('262', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 11:18:16');
INSERT INTO `ike_loginlog` VALUES ('263', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 11:23:47');
INSERT INTO `ike_loginlog` VALUES ('264', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-11-30 11:26:32');
INSERT INTO `ike_loginlog` VALUES ('265', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 10:13:44');
INSERT INTO `ike_loginlog` VALUES ('266', ' 账号不存在, admin_name:[admin1] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 10:13:54');
INSERT INTO `ike_loginlog` VALUES ('267', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 10:14:00');
INSERT INTO `ike_loginlog` VALUES ('268', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 11:35:05');
INSERT INTO `ike_loginlog` VALUES ('269', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 16:30:16');
INSERT INTO `ike_loginlog` VALUES ('270', ' 登录失败,密码出错, 账号名:[admin] password:[123456798] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 16:32:05');
INSERT INTO `ike_loginlog` VALUES ('271', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 16:32:15');
INSERT INTO `ike_loginlog` VALUES ('272', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 16:37:50');
INSERT INTO `ike_loginlog` VALUES ('273', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 16:42:43');
INSERT INTO `ike_loginlog` VALUES ('274', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 17:08:13');
INSERT INTO `ike_loginlog` VALUES ('275', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 17:31:50');
INSERT INTO `ike_loginlog` VALUES ('276', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 17:33:31');
INSERT INTO `ike_loginlog` VALUES ('277', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 17:46:15');
INSERT INTO `ike_loginlog` VALUES ('278', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 17:50:40');
INSERT INTO `ike_loginlog` VALUES ('279', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 17:52:55');
INSERT INTO `ike_loginlog` VALUES ('280', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-02 18:21:10');
INSERT INTO `ike_loginlog` VALUES ('281', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 08:47:29');
INSERT INTO `ike_loginlog` VALUES ('282', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 08:57:49');
INSERT INTO `ike_loginlog` VALUES ('283', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:06:20');
INSERT INTO `ike_loginlog` VALUES ('284', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:12:46');
INSERT INTO `ike_loginlog` VALUES ('285', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:14:55');
INSERT INTO `ike_loginlog` VALUES ('286', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:16:02');
INSERT INTO `ike_loginlog` VALUES ('287', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:20:06');
INSERT INTO `ike_loginlog` VALUES ('288', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:20:16');
INSERT INTO `ike_loginlog` VALUES ('289', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:23:11');
INSERT INTO `ike_loginlog` VALUES ('290', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:26:48');
INSERT INTO `ike_loginlog` VALUES ('291', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:27:11');
INSERT INTO `ike_loginlog` VALUES ('292', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:28:26');
INSERT INTO `ike_loginlog` VALUES ('293', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:34:51');
INSERT INTO `ike_loginlog` VALUES ('294', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:39:58');
INSERT INTO `ike_loginlog` VALUES ('295', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:46:35');
INSERT INTO `ike_loginlog` VALUES ('296', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 09:47:07');
INSERT INTO `ike_loginlog` VALUES ('297', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:06:22');
INSERT INTO `ike_loginlog` VALUES ('298', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:13:46');
INSERT INTO `ike_loginlog` VALUES ('299', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:13:58');
INSERT INTO `ike_loginlog` VALUES ('300', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:20:08');
INSERT INTO `ike_loginlog` VALUES ('301', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:22:49');
INSERT INTO `ike_loginlog` VALUES ('302', ' 登录失败,密码出错, 账号名:[ike] password:[test123] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:23:25');
INSERT INTO `ike_loginlog` VALUES ('303', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:23:33');
INSERT INTO `ike_loginlog` VALUES ('304', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:24:01');
INSERT INTO `ike_loginlog` VALUES ('305', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 10:50:37');
INSERT INTO `ike_loginlog` VALUES ('306', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:02:18');
INSERT INTO `ike_loginlog` VALUES ('307', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:02:24');
INSERT INTO `ike_loginlog` VALUES ('308', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:02:59');
INSERT INTO `ike_loginlog` VALUES ('309', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:08:16');
INSERT INTO `ike_loginlog` VALUES ('310', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:10:58');
INSERT INTO `ike_loginlog` VALUES ('311', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:11:36');
INSERT INTO `ike_loginlog` VALUES ('312', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:11:43');
INSERT INTO `ike_loginlog` VALUES ('313', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:16:17');
INSERT INTO `ike_loginlog` VALUES ('314', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:18:02');
INSERT INTO `ike_loginlog` VALUES ('315', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:18:30');
INSERT INTO `ike_loginlog` VALUES ('316', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:18:35');
INSERT INTO `ike_loginlog` VALUES ('317', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:23:45');
INSERT INTO `ike_loginlog` VALUES ('318', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:35:52');
INSERT INTO `ike_loginlog` VALUES ('319', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:56:24');
INSERT INTO `ike_loginlog` VALUES ('320', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-05 11:57:56');
INSERT INTO `ike_loginlog` VALUES ('321', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-06 11:30:10');
INSERT INTO `ike_loginlog` VALUES ('322', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-06 11:50:15');
INSERT INTO `ike_loginlog` VALUES ('323', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-06 14:58:33');
INSERT INTO `ike_loginlog` VALUES ('324', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-06 14:59:12');
INSERT INTO `ike_loginlog` VALUES ('325', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-06 16:52:33');
INSERT INTO `ike_loginlog` VALUES ('326', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-06 16:53:00');
INSERT INTO `ike_loginlog` VALUES ('327', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 11:29:10');
INSERT INTO `ike_loginlog` VALUES ('328', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:03:19');
INSERT INTO `ike_loginlog` VALUES ('329', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:12:42');
INSERT INTO `ike_loginlog` VALUES ('330', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:13:18');
INSERT INTO `ike_loginlog` VALUES ('331', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:13:25');
INSERT INTO `ike_loginlog` VALUES ('332', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:15:04');
INSERT INTO `ike_loginlog` VALUES ('333', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:36:03');
INSERT INTO `ike_loginlog` VALUES ('334', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:57:05');
INSERT INTO `ike_loginlog` VALUES ('335', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:57:11');
INSERT INTO `ike_loginlog` VALUES ('336', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 14:59:55');
INSERT INTO `ike_loginlog` VALUES ('337', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 15:02:06');
INSERT INTO `ike_loginlog` VALUES ('338', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 15:02:48');
INSERT INTO `ike_loginlog` VALUES ('339', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 15:03:27');
INSERT INTO `ike_loginlog` VALUES ('340', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:42:44');
INSERT INTO `ike_loginlog` VALUES ('341', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:42:58');
INSERT INTO `ike_loginlog` VALUES ('342', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:43:19');
INSERT INTO `ike_loginlog` VALUES ('343', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:54:46');
INSERT INTO `ike_loginlog` VALUES ('344', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:55:11');
INSERT INTO `ike_loginlog` VALUES ('345', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:56:41');
INSERT INTO `ike_loginlog` VALUES ('346', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:57:12');
INSERT INTO `ike_loginlog` VALUES ('347', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:58:48');
INSERT INTO `ike_loginlog` VALUES ('348', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 16:59:31');
INSERT INTO `ike_loginlog` VALUES ('349', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 17:02:20');
INSERT INTO `ike_loginlog` VALUES ('350', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 17:04:49');
INSERT INTO `ike_loginlog` VALUES ('351', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 17:05:01');
INSERT INTO `ike_loginlog` VALUES ('352', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 17:06:51');
INSERT INTO `ike_loginlog` VALUES ('353', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 17:07:20');
INSERT INTO `ike_loginlog` VALUES ('354', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 17:07:43');
INSERT INTO `ike_loginlog` VALUES ('355', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 17:08:20');
INSERT INTO `ike_loginlog` VALUES ('356', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-07 17:09:24');
INSERT INTO `ike_loginlog` VALUES ('357', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-07 18:21:02');
INSERT INTO `ike_loginlog` VALUES ('358', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-08 14:01:01');
INSERT INTO `ike_loginlog` VALUES ('359', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-08 16:13:29');
INSERT INTO `ike_loginlog` VALUES ('360', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.209] address:[广东广州]', '192.168.0.209', '广东广州', '2016-12-08 16:15:07');
INSERT INTO `ike_loginlog` VALUES ('361', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.209] address:[广东广州]', '192.168.0.209', '广东广州', '2016-12-08 16:16:16');
INSERT INTO `ike_loginlog` VALUES ('362', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-08 16:18:42');
INSERT INTO `ike_loginlog` VALUES ('363', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-08 16:35:20');
INSERT INTO `ike_loginlog` VALUES ('364', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-08 18:13:52');
INSERT INTO `ike_loginlog` VALUES ('365', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-09 09:41:31');
INSERT INTO `ike_loginlog` VALUES ('366', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-09 10:21:33');
INSERT INTO `ike_loginlog` VALUES ('367', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-09 11:24:07');
INSERT INTO `ike_loginlog` VALUES ('368', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-09 16:30:49');
INSERT INTO `ike_loginlog` VALUES ('369', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-10 11:13:15');
INSERT INTO `ike_loginlog` VALUES ('370', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-10 11:14:32');
INSERT INTO `ike_loginlog` VALUES ('371', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-10 11:15:03');
INSERT INTO `ike_loginlog` VALUES ('372', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-10 11:15:10');
INSERT INTO `ike_loginlog` VALUES ('373', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-10 11:15:23');
INSERT INTO `ike_loginlog` VALUES ('374', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-10 15:13:20');
INSERT INTO `ike_loginlog` VALUES ('375', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-10 15:38:44');
INSERT INTO `ike_loginlog` VALUES ('376', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-12 08:50:37');
INSERT INTO `ike_loginlog` VALUES ('377', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-12 10:49:27');
INSERT INTO `ike_loginlog` VALUES ('378', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-12 16:12:20');
INSERT INTO `ike_loginlog` VALUES ('379', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-13 17:04:56');
INSERT INTO `ike_loginlog` VALUES ('380', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 11:33:35');
INSERT INTO `ike_loginlog` VALUES ('381', ' 账号不存在, admin_name:[fafa] password:[afafafaf] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 11:36:39');
INSERT INTO `ike_loginlog` VALUES ('382', ' 账号不存在, admin_name:[fafaf] password:[affffffff] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 11:37:53');
INSERT INTO `ike_loginlog` VALUES ('383', ' 登录失败,密码出错, 账号名:[admin] password:[1234561] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 11:38:03');
INSERT INTO `ike_loginlog` VALUES ('384', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 11:38:30');
INSERT INTO `ike_loginlog` VALUES ('385', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 11:46:57');
INSERT INTO `ike_loginlog` VALUES ('386', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 11:47:02');
INSERT INTO `ike_loginlog` VALUES ('387', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:18:32');
INSERT INTO `ike_loginlog` VALUES ('388', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:18:37');
INSERT INTO `ike_loginlog` VALUES ('389', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:20:08');
INSERT INTO `ike_loginlog` VALUES ('390', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:25:27');
INSERT INTO `ike_loginlog` VALUES ('391', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:27:22');
INSERT INTO `ike_loginlog` VALUES ('392', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:28:45');
INSERT INTO `ike_loginlog` VALUES ('393', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:30:10');
INSERT INTO `ike_loginlog` VALUES ('394', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:30:55');
INSERT INTO `ike_loginlog` VALUES ('395', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:34:43');
INSERT INTO `ike_loginlog` VALUES ('396', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:35:57');
INSERT INTO `ike_loginlog` VALUES ('397', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-14 17:43:38');
INSERT INTO `ike_loginlog` VALUES ('398', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-15 11:02:11');
INSERT INTO `ike_loginlog` VALUES ('399', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-15 14:23:48');
INSERT INTO `ike_loginlog` VALUES ('400', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-15 18:24:55');
INSERT INTO `ike_loginlog` VALUES ('401', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-15 18:28:56');
INSERT INTO `ike_loginlog` VALUES ('402', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-16 08:46:07');
INSERT INTO `ike_loginlog` VALUES ('403', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 08:50:15');
INSERT INTO `ike_loginlog` VALUES ('404', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 08:51:46');
INSERT INTO `ike_loginlog` VALUES ('405', ' 登录失败,密码出错, 账号名:[admin] password:[23456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 10:00:43');
INSERT INTO `ike_loginlog` VALUES ('406', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 10:00:51');
INSERT INTO `ike_loginlog` VALUES ('407', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 10:15:58');
INSERT INTO `ike_loginlog` VALUES ('408', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 11:03:43');
INSERT INTO `ike_loginlog` VALUES ('409', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 13:58:01');
INSERT INTO `ike_loginlog` VALUES ('410', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 13:58:07');
INSERT INTO `ike_loginlog` VALUES ('411', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 13:58:56');
INSERT INTO `ike_loginlog` VALUES ('412', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 15:03:19');
INSERT INTO `ike_loginlog` VALUES ('413', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 15:42:09');
INSERT INTO `ike_loginlog` VALUES ('414', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 15:44:29');
INSERT INTO `ike_loginlog` VALUES ('415', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-16 16:04:10');
INSERT INTO `ike_loginlog` VALUES ('416', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.47] address:[广东广州]', '192.168.0.47', '广东广州', '2016-12-16 18:07:04');
INSERT INTO `ike_loginlog` VALUES ('417', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-17 08:49:55');
INSERT INTO `ike_loginlog` VALUES ('418', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.48] address:[广东广州]', '192.168.0.48', '广东广州', '2016-12-17 10:04:26');
INSERT INTO `ike_loginlog` VALUES ('419', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-17 10:14:26');
INSERT INTO `ike_loginlog` VALUES ('420', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-17 10:14:40');
INSERT INTO `ike_loginlog` VALUES ('421', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-17 10:55:11');
INSERT INTO `ike_loginlog` VALUES ('422', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-17 11:15:09');
INSERT INTO `ike_loginlog` VALUES ('423', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-17 14:41:53');
INSERT INTO `ike_loginlog` VALUES ('424', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-17 15:56:29');
INSERT INTO `ike_loginlog` VALUES ('425', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 09:42:36');
INSERT INTO `ike_loginlog` VALUES ('426', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 10:02:07');
INSERT INTO `ike_loginlog` VALUES ('427', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 11:27:27');
INSERT INTO `ike_loginlog` VALUES ('428', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 13:45:55');
INSERT INTO `ike_loginlog` VALUES ('429', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 14:46:05');
INSERT INTO `ike_loginlog` VALUES ('430', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 15:49:19');
INSERT INTO `ike_loginlog` VALUES ('431', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 16:51:12');
INSERT INTO `ike_loginlog` VALUES ('432', ' 登录失败,密码出错, 账号名:[admin] password:[12346789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 17:52:08');
INSERT INTO `ike_loginlog` VALUES ('433', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-19 17:52:20');
INSERT INTO `ike_loginlog` VALUES ('434', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 08:59:13');
INSERT INTO `ike_loginlog` VALUES ('435', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 10:36:25');
INSERT INTO `ike_loginlog` VALUES ('436', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 11:37:50');
INSERT INTO `ike_loginlog` VALUES ('437', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 12:47:06');
INSERT INTO `ike_loginlog` VALUES ('438', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 13:49:14');
INSERT INTO `ike_loginlog` VALUES ('439', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 14:53:40');
INSERT INTO `ike_loginlog` VALUES ('440', ' 登录失败,密码出错, 账号名:[admin] password:[123456879] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 15:55:20');
INSERT INTO `ike_loginlog` VALUES ('441', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 15:55:31');
INSERT INTO `ike_loginlog` VALUES ('442', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:02:20');
INSERT INTO `ike_loginlog` VALUES ('443', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:08:09');
INSERT INTO `ike_loginlog` VALUES ('444', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:12:42');
INSERT INTO `ike_loginlog` VALUES ('445', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:14:14');
INSERT INTO `ike_loginlog` VALUES ('446', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:14:50');
INSERT INTO `ike_loginlog` VALUES ('447', ' 登录失败,密码出错, 账号名:[ike] password:[123465] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:40:40');
INSERT INTO `ike_loginlog` VALUES ('448', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:40:47');
INSERT INTO `ike_loginlog` VALUES ('449', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 16:55:22');
INSERT INTO `ike_loginlog` VALUES ('450', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 17:43:40');
INSERT INTO `ike_loginlog` VALUES ('451', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-20 17:55:36');
INSERT INTO `ike_loginlog` VALUES ('452', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 08:55:58');
INSERT INTO `ike_loginlog` VALUES ('453', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 09:58:10');
INSERT INTO `ike_loginlog` VALUES ('454', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 11:28:32');
INSERT INTO `ike_loginlog` VALUES ('455', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 13:37:50');
INSERT INTO `ike_loginlog` VALUES ('456', ' 登录失败,密码出错, 账号名:[admin] password:[13456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 14:38:02');
INSERT INTO `ike_loginlog` VALUES ('457', ' 登录失败,密码出错, 账号名:[admin] password:[13456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 14:38:08');
INSERT INTO `ike_loginlog` VALUES ('458', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 14:38:16');
INSERT INTO `ike_loginlog` VALUES ('459', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 16:01:25');
INSERT INTO `ike_loginlog` VALUES ('460', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 17:01:41');
INSERT INTO `ike_loginlog` VALUES ('461', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 17:51:00');
INSERT INTO `ike_loginlog` VALUES ('462', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 17:52:06');
INSERT INTO `ike_loginlog` VALUES ('463', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-21 18:02:25');
INSERT INTO `ike_loginlog` VALUES ('464', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 09:27:52');
INSERT INTO `ike_loginlog` VALUES ('465', ' 登录失败,密码出错, 账号名:[admin] password:[12345679] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 10:28:30');
INSERT INTO `ike_loginlog` VALUES ('466', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 10:28:35');
INSERT INTO `ike_loginlog` VALUES ('467', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 11:24:37');
INSERT INTO `ike_loginlog` VALUES ('468', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 11:36:29');
INSERT INTO `ike_loginlog` VALUES ('469', ' 账号已禁止，请联系管理员, 账号名:[ike] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 11:43:28');
INSERT INTO `ike_loginlog` VALUES ('470', ' 账号已禁止，请联系管理员, 账号名:[admin] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 11:43:55');
INSERT INTO `ike_loginlog` VALUES ('471', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 11:49:59');
INSERT INTO `ike_loginlog` VALUES ('472', ' 账号已禁止，请联系管理员, 账号名:[ike] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 12:01:23');
INSERT INTO `ike_loginlog` VALUES ('473', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 12:01:33');
INSERT INTO `ike_loginlog` VALUES ('474', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 13:57:37');
INSERT INTO `ike_loginlog` VALUES ('475', ' 登录失败,密码出错, 账号名:[ike] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 15:00:47');
INSERT INTO `ike_loginlog` VALUES ('476', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 15:00:53');
INSERT INTO `ike_loginlog` VALUES ('477', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 16:20:11');
INSERT INTO `ike_loginlog` VALUES ('478', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 16:20:47');
INSERT INTO `ike_loginlog` VALUES ('479', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 16:21:28');
INSERT INTO `ike_loginlog` VALUES ('480', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 16:24:39');
INSERT INTO `ike_loginlog` VALUES ('481', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 16:27:03');
INSERT INTO `ike_loginlog` VALUES ('482', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 16:29:14');
INSERT INTO `ike_loginlog` VALUES ('483', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 16:33:34');
INSERT INTO `ike_loginlog` VALUES ('484', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 17:15:01');
INSERT INTO `ike_loginlog` VALUES ('485', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 17:17:01');
INSERT INTO `ike_loginlog` VALUES ('486', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 17:20:39');
INSERT INTO `ike_loginlog` VALUES ('487', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 17:21:36');
INSERT INTO `ike_loginlog` VALUES ('488', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 17:24:15');
INSERT INTO `ike_loginlog` VALUES ('489', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-22 17:27:33');
INSERT INTO `ike_loginlog` VALUES ('490', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-23 09:23:45');
INSERT INTO `ike_loginlog` VALUES ('491', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 09:48:40');
INSERT INTO `ike_loginlog` VALUES ('492', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 11:00:01');
INSERT INTO `ike_loginlog` VALUES ('493', ' 登录失败,密码出错, 账号名:[ike1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 11:11:11');
INSERT INTO `ike_loginlog` VALUES ('494', ' 登录失败,密码出错, 账号名:[ike1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 11:11:16');
INSERT INTO `ike_loginlog` VALUES ('495', ' 登录失败,密码出错, 账号名:[ike1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 11:11:29');
INSERT INTO `ike_loginlog` VALUES ('496', ' 登录失败,密码出错, 账号名:[ike1] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 11:11:37');
INSERT INTO `ike_loginlog` VALUES ('497', ' 登录成功, 账号名:[ike1] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 11:12:00');
INSERT INTO `ike_loginlog` VALUES ('498', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 11:12:38');
INSERT INTO `ike_loginlog` VALUES ('499', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 12:01:19');
INSERT INTO `ike_loginlog` VALUES ('500', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 13:35:52');
INSERT INTO `ike_loginlog` VALUES ('501', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.112] address:[广东广州]', '192.168.0.112', '广东广州', '2016-12-23 14:05:07');
INSERT INTO `ike_loginlog` VALUES ('502', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 14:36:03');
INSERT INTO `ike_loginlog` VALUES ('503', ' 登录失败,密码出错, 账号名:[admin] password:[13456798] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 15:13:06');
INSERT INTO `ike_loginlog` VALUES ('504', ' 登录失败,密码出错, 账号名:[admin] password:[134679] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 15:13:21');
INSERT INTO `ike_loginlog` VALUES ('505', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 15:13:36');
INSERT INTO `ike_loginlog` VALUES ('506', ' 登录失败,密码出错, 账号名:[ike] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 15:35:52');
INSERT INTO `ike_loginlog` VALUES ('507', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 15:36:08');
INSERT INTO `ike_loginlog` VALUES ('508', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 15:38:00');
INSERT INTO `ike_loginlog` VALUES ('509', ' 登录失败,密码出错, 账号名:[admin] password:[123465789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 16:41:46');
INSERT INTO `ike_loginlog` VALUES ('510', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-23 16:42:25');
INSERT INTO `ike_loginlog` VALUES ('511', ' 登录失败,密码出错, 账号名:[admin] password:[1346579] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 11:10:54');
INSERT INTO `ike_loginlog` VALUES ('512', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 11:10:59');
INSERT INTO `ike_loginlog` VALUES ('513', ' 登录失败,密码出错, 账号名:[admin] password:[12346579] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 13:50:16');
INSERT INTO `ike_loginlog` VALUES ('514', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 13:50:23');
INSERT INTO `ike_loginlog` VALUES ('515', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-26 13:52:43');
INSERT INTO `ike_loginlog` VALUES ('516', ' 登录失败,密码出错, 账号名:[admin] password:[1234679] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 14:50:20');
INSERT INTO `ike_loginlog` VALUES ('517', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 14:50:25');
INSERT INTO `ike_loginlog` VALUES ('518', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 15:09:52');
INSERT INTO `ike_loginlog` VALUES ('519', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-26 15:28:35');
INSERT INTO `ike_loginlog` VALUES ('520', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-26 18:04:44');
INSERT INTO `ike_loginlog` VALUES ('521', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 10:32:50');
INSERT INTO `ike_loginlog` VALUES ('522', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 11:32:14');
INSERT INTO `ike_loginlog` VALUES ('523', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 11:32:54');
INSERT INTO `ike_loginlog` VALUES ('524', ' 登录失败,密码出错, 账号名:[admin] password:[12346789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 14:11:42');
INSERT INTO `ike_loginlog` VALUES ('525', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 14:11:57');
INSERT INTO `ike_loginlog` VALUES ('526', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 15:11:50');
INSERT INTO `ike_loginlog` VALUES ('527', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 15:29:38');
INSERT INTO `ike_loginlog` VALUES ('528', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 16:17:36');
INSERT INTO `ike_loginlog` VALUES ('529', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 16:34:59');
INSERT INTO `ike_loginlog` VALUES ('530', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.133] address:[广东广州]', '192.168.0.133', '广东广州', '2016-12-27 17:19:26');
INSERT INTO `ike_loginlog` VALUES ('531', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-27 17:20:54');
INSERT INTO `ike_loginlog` VALUES ('532', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2016-12-27 17:24:52');
INSERT INTO `ike_loginlog` VALUES ('533', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-27 17:31:38');
INSERT INTO `ike_loginlog` VALUES ('534', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.139] address:[广东广州]', '192.168.0.139', '广东广州', '2016-12-27 17:46:06');
INSERT INTO `ike_loginlog` VALUES ('535', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-28 09:12:38');
INSERT INTO `ike_loginlog` VALUES ('536', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-28 10:12:58');
INSERT INTO `ike_loginlog` VALUES ('537', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-28 14:45:57');
INSERT INTO `ike_loginlog` VALUES ('538', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 10:03:02');
INSERT INTO `ike_loginlog` VALUES ('539', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 10:03:06');
INSERT INTO `ike_loginlog` VALUES ('540', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 14:10:29');
INSERT INTO `ike_loginlog` VALUES ('541', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 14:11:09');
INSERT INTO `ike_loginlog` VALUES ('542', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 14:12:50');
INSERT INTO `ike_loginlog` VALUES ('543', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 14:22:44');
INSERT INTO `ike_loginlog` VALUES ('544', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 14:47:32');
INSERT INTO `ike_loginlog` VALUES ('545', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 14:57:42');
INSERT INTO `ike_loginlog` VALUES ('546', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-29 16:21:27');
INSERT INTO `ike_loginlog` VALUES ('547', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-30 14:57:06');
INSERT INTO `ike_loginlog` VALUES ('548', ' 登录成功, 账号名:[ike] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-31 11:01:48');
INSERT INTO `ike_loginlog` VALUES ('549', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2016-12-31 11:02:19');
INSERT INTO `ike_loginlog` VALUES ('550', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-03 17:34:07');
INSERT INTO `ike_loginlog` VALUES ('551', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-03 17:35:38');
INSERT INTO `ike_loginlog` VALUES ('552', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-05 14:12:01');
INSERT INTO `ike_loginlog` VALUES ('553', ' 登录失败,密码出错, 账号名:[admin] password:[12345678] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-05 14:12:44');
INSERT INTO `ike_loginlog` VALUES ('554', ' 登录失败,密码出错, 账号名:[admin] password:[12345678] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-05 14:13:18');
INSERT INTO `ike_loginlog` VALUES ('555', ' 登录失败,密码出错, 账号名:[admin] password:[12345678] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-05 14:13:34');
INSERT INTO `ike_loginlog` VALUES ('556', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2017-01-06 10:45:49');
INSERT INTO `ike_loginlog` VALUES ('557', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-06 10:50:14');
INSERT INTO `ike_loginlog` VALUES ('558', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2017-01-06 14:58:56');
INSERT INTO `ike_loginlog` VALUES ('559', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2017-01-06 16:36:33');
INSERT INTO `ike_loginlog` VALUES ('560', ' 登录成功, 账号名:[admin] 访问者ip:[192.168.0.178] address:[广东广州]', '192.168.0.178', '广东广州', '2017-01-06 17:49:18');
INSERT INTO `ike_loginlog` VALUES ('561', ' 登录失败,密码出错, 账号名:[admin] password:[123456] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-06 18:06:40');
INSERT INTO `ike_loginlog` VALUES ('562', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-06 18:08:11');
INSERT INTO `ike_loginlog` VALUES ('563', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-06 18:11:02');
INSERT INTO `ike_loginlog` VALUES ('564', ' 账号不存在, admin_name:[13025304562] password:[123456789] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-07 10:10:33');
INSERT INTO `ike_loginlog` VALUES ('565', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-07 10:10:42');
INSERT INTO `ike_loginlog` VALUES ('566', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-07 10:16:44');
INSERT INTO `ike_loginlog` VALUES ('567', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-07 11:30:25');
INSERT INTO `ike_loginlog` VALUES ('568', ' 登录成功, 账号名:[admin] 访问者ip:[127.0.0.1] address:[广东广州]', '127.0.0.1', '广东广州', '2017-01-07 15:00:55');

-- ----------------------------
-- Table structure for `ike_messages`
-- ----------------------------
DROP TABLE IF EXISTS `ike_messages`;
CREATE TABLE `ike_messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '聊天信息id',
  `from_tu_id` char(20) NOT NULL COMMENT '发送信息用户id',
  `to_tu_id` char(20) NOT NULL COMMENT '收到信息用户id',
  `message_time` datetime NOT NULL COMMENT '发送时间',
  `message_status` tinyint(1) unsigned NOT NULL COMMENT '对方用户是否在线（0为不在线，1为在线）',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_messages
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_problem`
-- ----------------------------
DROP TABLE IF EXISTS `ike_problem`;
CREATE TABLE `ike_problem` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tu_id` char(20) NOT NULL COMMENT '用户id',
  `problem_title` char(30) NOT NULL COMMENT '设置问题标题',
  `answer` char(30) NOT NULL COMMENT '答案',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_problem
-- ----------------------------
INSERT INTO `ike_problem` VALUES ('1', '13025304562', '我是谁？', 'min');
INSERT INTO `ike_problem` VALUES ('4', '18819493900', '我是谁', '小玲');
INSERT INTO `ike_problem` VALUES ('2', '15778884615', 'aa', 'aa');
INSERT INTO `ike_problem` VALUES ('5', '18819493911', '123456', '123456');
INSERT INTO `ike_problem` VALUES ('6', '13810214748', '我的名字', '王政');
INSERT INTO `ike_problem` VALUES ('7', '18819493945', '11', '11');

-- ----------------------------
-- Table structure for `ike_user`
-- ----------------------------
DROP TABLE IF EXISTS `ike_user`;
CREATE TABLE `ike_user` (
  `tu_id` char(20) NOT NULL COMMENT '会员id',
  `token` varchar(100) NOT NULL COMMENT 'token',
  `nickname` varchar(64) NOT NULL COMMENT '昵称',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别(0保密，1男，2女)',
  `email` varchar(45) DEFAULT NULL COMMENT '邮箱',
  `mobile` varchar(20) DEFAULT NULL COMMENT '电话号码',
  `address` varchar(200) DEFAULT NULL COMMENT '地址',
  `birth_date` datetime DEFAULT NULL COMMENT '生日',
  `age` tinyint(3) unsigned DEFAULT NULL COMMENT '年龄',
  `avatar_id` int(10) unsigned DEFAULT '1' COMMENT '头像id',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '登录状态（0，禁止登录，1，正常登录）',
  `gen_time` datetime NOT NULL COMMENT '注册时间',
  `login_time` datetime NOT NULL COMMENT '登录时间',
  `last_login_time` datetime NOT NULL COMMENT '上一次登录时间',
  `login_ip` varchar(255) NOT NULL COMMENT '登录ip',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户在线状态(0不在线1在线)',
  `count` int(10) unsigned NOT NULL COMMENT '登录次数',
  PRIMARY KEY (`tu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_user
-- ----------------------------
INSERT INTO `ike_user` VALUES ('00001', '3Zd4EbE7Us6Vf5Z+pjOl8p6BwaanRHOVDxqwdRloLcvShQz8KGbAZfD/tJ15oqQoW1QjaiDdelPcDUAt8F0khA==', '系统用户', 'afafafsafsfa', '0', null, null, null, null, null, '1', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493903', 'tP4VqBo3VC6JYDHzpwckImu1eBnVvHicknDcpKKoK6cJhh9DWt8ZFQk0u9jwUUPlfO/lHiUGajaWcjWW9EhqA+bGduDaQtP8', '小三', 'e10adc3949ba59abbe56e057f20f883e', '1', null, '18819493903', null, '1998-01-07 00:00:00', '19', '181', '1', '2016-12-31 16:04:28', '2017-01-04 16:03:38', '0000-00-00 00:00:00', '127.0.0.1', '1', '28');
INSERT INTO `ike_user` VALUES ('13025304562', '/bBz91PrwIOXgRGQ0cqWhXiCnKkNYYa8CA6MHd/URqZig2r+OGkzECCyy1y4DdEeWap707a4OjzVIjeOK8R2nUn1GO8OfmtY', '红米', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '13025304562', null, null, null, '1', '1', '2017-01-06 10:25:26', '2017-01-07 16:39:52', '0000-00-00 00:00:00', '192.168.0.209', '1', '8');
INSERT INTO `ike_user` VALUES ('18826238489', 'KobX3AzkXba+GwuFfY8J5mu1eBnVvHicknDcpKKoK6cJhh9DWt8ZFXaizuF4u/w3y5XrpktsqbleXm1/1Bph1a6AjST9cJvi', 'afaf', 'e10adc3949ba59abbe56e057f20f883e', '0', null, null, null, null, null, '1', '1', '0000-00-00 00:00:00', '2017-01-07 16:22:12', '0000-00-00 00:00:00', '192.168.0.209', '1', '8');
INSERT INTO `ike_user` VALUES ('18819493904', 'zWGVFhIoWLKgpUCU/g8cqJ6BwaanRHOVDxqwdRloLcuLDy3ZD4AEnqgraaPhQIwcMrPnlkCaJmPXcdi5FB+43dAvb/Gjlhww', '小四', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493904', null, null, null, '188', '1', '2017-01-05 10:10:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('15778884615', 'CIdbbbbbCb5f0Cb7tuEGU3iCnKkNYYa8CA6MHd/URqZig2r+OGkzEDREsngxEsguRWNvHa8awhHAngbDjenx92N4nSu5aulo', '花梨', 'e99a18c428cb38d5f260853678922e03', '0', null, '15778884615', null, '2013-01-05 14:00:00', '4', '189', '1', '2017-01-05 14:34:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493908', '/ksHVbATMrbeqYmE1VFSjWu1eBnVvHicknDcpKKoK6cJhh9DWt8ZFUaltSK4zc9XgRAGVhy01QCWcjWW9EhqA3BHmcQoaFRz', '笑吧', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493908', null, null, null, '1', '1', '2017-01-06 11:37:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493901', 'KrokxQkKJM1gwKi+6jbismu1eBnVvHicknDcpKKoK6cJhh9DWt8ZFV1uuC+My1SoAjR9Ccscb5uWcjWW9EhqA+JNE3quV/sI', '小一', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493901', null, null, null, '1', '1', '2017-01-06 17:09:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493902', 'jNb3E6YMlup04ZoltpXol56BwaanRHOVDxqwdRloLcvShQz8KGbAZdaysIVNcaIqMrPnlkCaJmPXcdi5FB+43VJpohZyuQoN', '小二', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493902', null, null, null, '1', '1', '2017-01-06 17:11:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493905', '5YWQNDT0Gq8X+hv2rPmoK3iCnKkNYYa8CA6MHd/URqZig2r+OGkzEDRaeTmXIt3d5x6uhbZlI8fMDyl+oTjONZAmKzs62lG3', '小五', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493905', null, null, null, '1', '1', '2017-01-06 17:12:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493907', '5aUCEa7FZTb60cpAQ5vCHp6BwaanRHOVDxqwdRloLcvShQz8KGbAZTK1zrGJCwclMrPnlkCaJmPXcdi5FB+43SJRKGATIK9i', '小七', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493907', null, null, null, '1', '1', '2017-01-06 17:15:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493900', 'GVpKiuaZPDOH4b2vgJhI2Wu1eBnVvHicknDcpKKoK6cJhh9DWt8ZFZIyqhpbk6EHI0B3FJ5dqFOWcjWW9EhqAyPp0Mr64JNo', '小玲', '74c43b7ec689955c9c1517294e92500f', '0', null, '18819493900', null, null, null, '1', '1', '2017-01-06 17:35:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493911', 'yRzHQowmsrSgpUCU/g8cqJ6BwaanRHOVDxqwdRloLcvgRrPwIUd1UxGinkS2TxTTMrPnlkCaJmPXcdi5FB+43YQMHFTkIcmq', '122', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493911', null, null, null, '1', '1', '2017-01-07 13:38:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('13810214748', 'TD8azYUwnAkwQFYTQlD5fGu1eBnVvHicknDcpKKoK6cJhh9DWt8ZFdlxnP1NzFhzQv+ZzeNbWlLLz03rAZ2kjrI73jxFlvJ6', 'wx', '454b0949d708969a6af0930dbc62b97f', '0', null, '13810214748', null, null, null, '1', '1', '2017-01-07 13:39:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');
INSERT INTO `ike_user` VALUES ('18819493945', 'wyP5ZT+yFRB+Qq7yGCq7jWu1eBnVvHicknDcpKKoK6cJhh9DWt8ZFaePDxvyqBUDfO/lHiUGajaWcjWW9EhqA80kjKykuYXF', '阿达', 'e10adc3949ba59abbe56e057f20f883e', '0', null, '18819493945', null, null, null, '1', '1', '2017-01-07 14:38:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '1', '0');

-- ----------------------------
-- Table structure for `ike_vote_collect`
-- ----------------------------
DROP TABLE IF EXISTS `ike_vote_collect`;
CREATE TABLE `ike_vote_collect` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '投票结果id',
  `vote_id` int(10) NOT NULL COMMENT '投票主题id',
  `item_id` int(10) NOT NULL COMMENT '投票选项id',
  `tu_id` char(20) NOT NULL COMMENT '投票用户id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_vote_collect
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_vote_option`
-- ----------------------------
DROP TABLE IF EXISTS `ike_vote_option`;
CREATE TABLE `ike_vote_option` (
  `item_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '投票选项id',
  `vote_content` char(30) NOT NULL COMMENT '投票选项内容',
  `vote_id` int(10) NOT NULL COMMENT '投票主题id',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_vote_option
-- ----------------------------

-- ----------------------------
-- Table structure for `ike_vote_theme`
-- ----------------------------
DROP TABLE IF EXISTS `ike_vote_theme`;
CREATE TABLE `ike_vote_theme` (
  `vote_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '投票主题id',
  `vote_title` char(30) NOT NULL COMMENT '投票主题',
  `mode` bigint(1) NOT NULL DEFAULT '0' COMMENT '0表示单选  1表示多选',
  `add_time` datetime NOT NULL COMMENT '创建时间',
  `end_time` datetime NOT NULL COMMENT '投票结束时间',
  `tu_id` char(20) NOT NULL COMMENT '创建用户',
  `group_id` int(10) unsigned NOT NULL COMMENT '群id',
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ike_vote_theme
-- ----------------------------
