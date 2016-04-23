
--
-- 表的结构 `user` 用户表
--
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_name` varchar(50) DEFAULT '' COMMENT '用户名',
  `user_phone` varchar(20) NOT NULL COMMENT '手机号',
  `user_pwd` varchar(50) NOT NULL COMMENT '密码',
  `user_email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `avatar_url` varchar(200) DEFAULT '' COMMENT '头像URL',
  `last_address_id` int(10) DEFAULT '0' COMMENT '最近一次使用的地址ID',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  `updated_at` bigint(20) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `token` 身份标识表
--
CREATE TABLE IF NOT EXISTS `token` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '用户ID',
  `token` varchar(100) NOT NULL COMMENT '身份标识',
  `device_id` varchar(100) NOT NULL COMMENT '设备ID',
  `valid_second` int(11) NOT NULL COMMENT '有效时间,单位:秒',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `address` 收货地址表
--
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `summary` varchar(50) NOT NULL COMMENT '地址摘要',
  `detail` varchar(200) NOT NULL COMMENT '地址详情',
  `phone` varchar(20) NOT NULL COMMENT '联系电话',
  `name` varchar(20) NOT NULL COMMENT '联系人',
  `user_id` int(10) unsigned NOT NULL  COMMENT '用户ID',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  `updated_at` bigint(20) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `business` 商户表
--
CREATE TABLE IF NOT EXISTS `business` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(50) NOT NULL COMMENT '商户名称',
  `phone` varchar(20) NOT NULL COMMENT '商户电话',
  `address` varchar(100) NOT NULL COMMENT '商户地址',
  `pic_url` varchar(200) DEFAULT '' COMMENT '商户的logo',
  `shipping_fee` double NOT NULL DEFAULT '0' COMMENT '配送费',
  `package_fee` double NOT NULL DEFAULT '0' COMMENT '包装费',
  `min_price` double NOT NULL DEFAULT '0' COMMENT '起送价',
  `shipping_time` varchar(20) NOT NULL DEFAULT '' COMMENT '配送时间',
  `month_sales` int(11) NOT NULL COMMENT '月销量',
  `bulletin` varchar(300) NOT NULL DEFAULT '' COMMENT '商户公告',
  `category` int(11) NOT NULL COMMENT '商户类型：1=餐馆，2=茶饮店，3=便利店',
  `delivery_time` varchar(100) NOT NULL DEFAULT '' COMMENT '可预订的时间',
  `updated_at` bigint(20) NOT NULL COMMENT '修改时间',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `category` 商品分类表
--
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `business_id` int(11) NOT NULL COMMENT '商家ID',
  `name` varchar(30) NOT NULL COMMENT '名称',
  `description` varchar(50) NOT NULL DEFAULT '' COMMENT '描述',
  `icon_url` varchar(200) NOT NULL DEFAULT '' COMMENT '图标url',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `product` 商品表
--
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `business_id` int(11) NOT NULL COMMENT '商家ID',
  `category_id` int(11) NOT NULL COMMENT '分类ID',
  `name` varchar(100) NOT NULL COMMENT '名称',
  `price` double NOT NULL DEFAULT '0' COMMENT '单价',
  `description` text COMMENT '描述信息',
  `image_path` varchar(200) DEFAULT '' COMMENT '图片',
  `month_sales` int(11) NOT NULL DEFAULT '0' COMMENT '月销量',
  `rate` int(11) NOT NULL COMMENT '评分',
  `left_num` int(11) NOT NULL COMMENT '剩余的数量',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `order` 订单表
--
CREATE TABLE IF NOT EXISTS `order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `sign` varchar(100) NOT NULL COMMENT '签名',
  `user_id` bigint(20) unsigned NOT NULL COMMENT '用户ID',
  `business_id` bigint(20) unsigned NOT NULL COMMENT '商店ID',
  `device_id` varchar(100) NOT NULL COMMENT '设备ID',
  `device_type` varchar(20) NOT NULL COMMENT '设备类型',
  `status` int(1) NOT NULL COMMENT '订单状态,-1=待提交,0=待支付,1=待接单，2=待发货，3=待送达，4=待确认，5=已完成',
  `origin_price` double NOT NULL COMMENT '商品原价',
  `discount_price` double NOT NULL COMMENT '优惠价格',
  `total_price` double NOT NULL COMMENT '合计价格',
  `consignee` varchar(20) DEFAULT NULL COMMENT '联系人',
  `phone` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `address` varchar(100) DEFAULT NULL COMMENT '收货地址',
  `pay_method` int(1) unsigned NOT NULL COMMENT '支付方式',
  `remark` varchar(200) DEFAULT NULL COMMENT '备注',
  `order_num` varchar(50) NOT NULL COMMENT '订单编号',
  `booked_at` varchar(20) DEFAULT NULL COMMENT '预订时间',
  `created_at` bigint(20) NOT NULL COMMENT '下单时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `order_product` 订单商品关联表
--
CREATE TABLE IF NOT EXISTS `order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `order_id` bigint(20) NOT NULL COMMENT '订单ID',
  `product_id` int(10) unsigned NOT NULL COMMENT '商品ID',
  `name` varchar(50) NOT NULL COMMENT '商品名称',
  `quantity` int(11) NOT NULL COMMENT '商品数量',
  `unit_price` double NOT NULL COMMENT '商品单价',
  `total_price` double NOT NULL COMMENT '商品总价',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `order_extra` 订单额外费用表
--
CREATE TABLE IF NOT EXISTS `order_extra` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `order_id` bigint(20) NOT NULL COMMENT '订单ID',
  `name` varchar(50) NOT NULL COMMENT '名称',
  `description` varchar(100) DEFAULT NULL COMMENT '描述',
  `price` double NOT NULL COMMENT '价格',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `order_extra` 订单优惠表
--
CREATE TABLE IF NOT EXISTS `order_discount` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `order_id` bigint(20) NOT NULL COMMENT '订单ID',
  `activity_id` bigint(20) NOT NULL COMMENT '活动ID',
  `name` varchar(50) NOT NULL COMMENT '活动的名称',
  `price` double NOT NULL COMMENT '优惠的价格',
  `description` varchar(100) NOT NULL COMMENT '活动的描述',
  `icon_name` varchar(10) NOT NULL COMMENT '活动图标的文字',
  `icon_color` varchar(10) NOT NULL COMMENT '活动图标的颜色',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `discount` 活动表
--
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `name` varchar(50) NOT NULL COMMENT '活动的名称',
  `description` varchar(100) NOT NULL COMMENT '活动的描述',
  `icon_name` varchar(10) NOT NULL COMMENT '活动图标的文字',
  `icon_color` varchar(10) NOT NULL COMMENT '活动图标的颜色',
  `code` varchar(50) NOT NULL COMMENT '逻辑code',
  `is_share` int(1) NOT NULL COMMENT '是否和其他活动共享',
  `priority` int(11) NOT NULL COMMENT '活动的优先级',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `business_activity` 商户活动关联表
--
CREATE TABLE IF NOT EXISTS `business_activity` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `business_id` int(11) NOT NULL COMMENT '商户ID',
  `activity_id` int(11) NOT NULL COMMENT '活动ID',
  `attribute` varchar(100) NOT NULL COMMENT '解析description所用的json数据',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `code` 验证码表
--
CREATE TABLE IF NOT EXISTS `code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `mobile` varchar(20) NOT NULL COMMENT '手机号',
  `code` varchar(10) NOT NULL COMMENT '验证码',
  `valid_second` int(11) NOT NULL COMMENT '有效时间，单位：秒',
  `created_at` bigint(20) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `log` SAE日志表
--
CREATE TABLE IF NOT EXISTS `log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `log_time` double DEFAULT NULL,
  `prefix` text,
  `message` text,
  PRIMARY KEY (`id`),
  KEY `idx_log_level` (`level`),
  KEY `idx_log_category` (`category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `cache` SAE需要的缓存表
--
CREATE TABLE IF NOT EXISTS `cache` (
  `id` char(128) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` longblob,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


