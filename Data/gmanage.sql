-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 04 月 10 日 15:08
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `gmanage`
--

-- --------------------------------------------------------

--
-- 表的结构 `gm_funds`
--

DROP TABLE IF EXISTS `gm_funds`;
CREATE TABLE IF NOT EXISTS `gm_funds` (
  `gm_fid` mediumint(8) unsigned NOT NULL auto_increment COMMENT 'id',
  `gm_ftype` char(2) collate utf8_bin default '1' COMMENT '变动种类1个人，2集体',
  `gm_num` int(14) unsigned NOT NULL COMMENT '学生学号',
  `gm_time` datetime NOT NULL COMMENT '操作时间',
  `gm_money` int(10) NOT NULL COMMENT '操作资金，有正负',
  `gm_lmoney` int(8) unsigned NOT NULL,
  `gm_details` text collate utf8_bin NOT NULL COMMENT '详细原因',
  PRIMARY KEY  (`gm_fid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=58 ;

--
-- 导出表中的数据 `gm_funds`
--


-- --------------------------------------------------------

--
-- 表的结构 `gm_message`
--

DROP TABLE IF EXISTS `gm_message`;
CREATE TABLE IF NOT EXISTS `gm_message` (
  `gm_id` mediumint(8) unsigned NOT NULL auto_increment,
  `gm_username` varchar(20) collate utf8_bin NOT NULL,
  `gm_num` int(14) unsigned NOT NULL,
  `gm_content` text collate utf8_bin NOT NULL,
  `gm_reply` text collate utf8_bin,
  `gm_replytime` datetime default NULL,
  `gm_systime` datetime NOT NULL,
  PRIMARY KEY  (`gm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

--
-- 导出表中的数据 `gm_message`
--

INSERT INTO `gm_message` (`gm_id`, `gm_username`, `gm_num`, `gm_content`, `gm_reply`, `gm_replytime`, `gm_systime`) VALUES
(15, 'Leo', 119074365, 0xe8bf99e4b8aae7b3bbe7bb9fe58a9fe883bde5be88e5bcbae5a4a7e593a60d0a0d0ae794a8e688b7e8a792e889b2e69c89efbc9ae8b685e7baa7e7aea1e79086e59198e38081e7aea1e79086e59198e38081e5ada6e7949f0d0ae59084e8a792e889b2e58a9fe883bde69c89e6988ee698bee58cbae588abefbc8ce4bdbfe7b3bbe7bb9fe689a7e8a18ce69588e78e87e5a4a7e5a4a7e68f90e9ab98efbc810d0a0d0ae8b685e7baa7e7aea1e79086e59198e79a84e5908ee58fb0e7aea1e79086e58a9fe883bde5bcbae5a4a7efbc8ce59ca8e982a3e9878ce58fafe4bba5e69bb4e694b9e5889de5a78be5af86e7a081e38081e698afe590a6e58581e8aeb8e6b3a8e5868ce38081e698afe590a6e5bc80e590afe9aa8ce8af81e7a081e38081e58886e9a1b5e7b1bbe59e8be38081e6af8fe9a1b5e69da1e79baee695b0e38081e7bd91e7ab99e6a087e9a298e7ad89e7ad89e8aebee7bdae7e7e0d0a0d0ae5ae89e585a8e696b9e99da2e69bb4e698afe88083e89991e4ba86e5be88e5a49aefbc8ce58fafe4bba5e69c89e69588e5ba94e5afb953516ce6b3a8e585a5e38081e8b7a8e9a1b5e99da2e694bbe587bbe38081e9a1b5e99da2e79b97e794a8e7ad89e7ad89e681b6e6848fe8a18ce4b8ba7e, 0xe698afe79a84efbc8ce8bf99e4b8aae7b3bbe7bb9fe7a1aee5ae9ee5bcbae5a4a7e5958a, '2013-04-10 23:02:59', '2013-04-10 23:02:31');

-- --------------------------------------------------------

--
-- 表的结构 `gm_notice`
--

DROP TABLE IF EXISTS `gm_notice`;
CREATE TABLE IF NOT EXISTS `gm_notice` (
  `gm_id` mediumint(8) unsigned NOT NULL auto_increment,
  `gm_title` varchar(100) collate utf8_bin NOT NULL,
  `gm_content` text collate utf8_bin NOT NULL,
  `gm_write` varchar(20) collate utf8_bin NOT NULL,
  `gm_time` datetime NOT NULL,
  PRIMARY KEY  (`gm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- 导出表中的数据 `gm_notice`
--

INSERT INTO `gm_notice` (`gm_id`, `gm_title`, `gm_content`, `gm_write`, `gm_time`) VALUES
(1, 'This’s a demo!!!!', 0x64617764617764617764, '1000', '2012-08-02 20:54:19'),
(2, '关于举办首届安徽工业大学计算机学院研究生艺术节的通知', 0x20e38080e38080e79086202020202020202020202020202020202020e8aebae4b88aefbc8ce999a4e59ba0e4b8a5e9878de8bf9de58f8de799bee7a791e58d8fe8aeaee8808ce8a2abe5b081e7a681e79a84e794a8e688b7e5a496efbc8ce585b6e4bb96e799bee5baa6e794a8e688b7e4baabe69c89e5b9b3e7ad89e7bc96e58699e8af8de69da1e79a84e69d83e588a9e38082e4bd86e4b8bae4ba86e5878fe5b091e8af8de69da1e8a2abe681b6e6848fe7bc96e8be91e79a84e4ba8be4bbb6efbc8ce799bee5baa6e5afb9e4b88de5908ce794a8e688b7e79a84e7bc96e8be91e69d83e69c89e4b880e5ae9ae79a84e99990e588b6e3808220202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020202020e4be8be5a682efbc9a0d0ae7a7afe58886e8bebee588b0e59b9be7baa7e38081e8af8de69da1e9809ae8bf87e78e87e59ca8383525e4bba5e4b88ae79a84e794a8e688b7e58fafe4bba5e7bc96e8be91e799bee7a791e5908de78987efbc8ce8808ce69caae5908ce697b6e8bebee588b0e4b8a4e69da1e6a087e58786e79a84e794a8e688b7e58899e697a0e69d83e4bfaee694b9e79bb8e5ba94e58685e5aeb9e38082e5afb9e5b091e695b0e58685e5aeb9e8be83e5ae8ce59684e79a84e8af8de69da1e79a84e7bc96e8be91efbc8ce4b99fe5ad98e59ca8e7b1bbe4bcbce79a84e99990e588b6e38082e58685e5aeb9e6b689e58f8ae6958fe6849fe79a84e8af9de9a298e68896e5b1a1e981ade681b6e6848fe7bc96e8be91e8808ce8a2abe69a82e697b6e99481e5ae9ae79a84e8af8de69da1efbc8ce697a0e6b395e8a2abe4bbbbe4bd95e794a8e688b7e7bc96e8be91efbc8ce5a682e794a8e688b7e8aea4e4b8bae69c89e5bf85e8a681e7bc96e8be91efbc8ce9a1bbe588b0e799bee7a791e68a95e8af89e590a7e68f90e4baa4e794b3e8afb7efbc8ce5be85e794b3e8afb7e9809ae8bf87e5908ee58db3e58fafe5afb9e79bb8e585b3e8af8de69da1e8bf9be8a18ce4bfaee694b9e380820d0a20e38080e38080e5afb9e799bee5baa6e799bee7a791e5819ae587bae4b880e5ae9ae8b4a1e78caee79a84e794a8e688b7efbc8ce58fafe4bba5e794b3e8afb7e68890e4b8bae58886e7b1bbe7aea1e79086e59198e38082e58886e7b1bbe7aea1e79086e59198e58fafe5afb9e799bee5baa6e799bee7a791e58886e7b1bb20202020202020202020e9a291e98193e9a1b5e8bf9be8a18ce7bc96e8be91efbc8ce5b9b6e4bda9e688b4e58886e7b1bbe7aea1e79086e59198e58b8be7aba0e380820d0a20e38080e38080e4b8bae4ba86e5b8a6e69da5e69bb4e58aa0e4b893e4b89ae38081e69d83e5a881e38081e58fafe99da0e79a84e4bfa1e681afefbc8ce799bee5baa6e799bee7a791e4b99fe5bc95e585a5e4ba86e69d83e5a881e8aea4e8af81e8af8de69da1e79a84e69cbae588b6e38082e69d83e5a881e8aea4e8af81e698afe68c87e9809ae8bf87e4b893e4b89ae69cbae69e84e5afb9e8af8de69da1e8bf9be8a18ce4b893e4b89ae8aea4e8af81efbc8ce4bba5e4bf9de8af81e8af8de69da1e58685e5aeb9e79a84e69d83e5a881e680a7efbc8ce7bb99e794a8e688b7e68f90e4be9be9ab98e8b4a8e9878fe79a84e4b893e4b89ae8a7a3e9878ae58c96e69c8de58aa1e38082, '1000', '2012-09-24 21:07:27'),
(4, '关于计算机学院新生迎接工作的通知', 0xe6b58be8af95e5958ae5958ae5958ae5958ae5958ae5958a, '1000', '2012-08-02 20:50:45'),
(6, '今年放寒假时间提前二个星期', 0xe5958ae5958ae5958ae5958a, '1000', '2012-08-02 20:49:19'),
(7, '冬季作息时间表', 0xe788b1e788b1e788b1200d0ae9a29de7bab7e7bab70d0ae698afe68891e79a84, '1000', '2012-08-02 21:03:41'),
(8, '2012年8月3日开始下雨啦', 0xe4b88be590a7e4b88be590a7e68891e8a681e5bc80e88ab1202020e58f91e88abd, '', '2012-08-09 15:12:35'),
(9, '学院研究生整顿的通知', 0xe5ada6e999a2e7a094e7a9b6e7949fe695b4e9a1bfe79a84e9809ae79fa5e5ada6e999a2e7a094e7a9b6e7949fe695b4e9a1bfe79a84e9809ae79fa5e5ada6e999a2e7a094e7a9b6e7949fe695b4e9a1bfe79a84e9809ae79fa5, '1000', '2012-08-02 22:20:25'),
(10, '关于举办2013年“合财”杯中国大学生 计算机设计大赛安徽省级赛的通知', 0xe69c89e585b3e9ab98e7ad89e5ada6e6a0a1efbc9a0d0ae38080e38080e38080e4b8bae4ba86e6bf80e58ab1e68891e79c81e5a4a7e5ada6e7949fe5ada6e4b9a0e8aea1e7ae97e69cbae5ba94e794a8e79fa5e8af86e5928ce68a80e883bde79a84e585b4e8b6a3efbc8ce68f90e58d87e5a4a7e5ada6e7949fe58f82e58aa0e585a8e59bbde5a4a7e5ada6e7949fe8aea1e7ae97e69cbae8aebee8aea1e5a4a7e8b59befbc88e4bba5e4b88be7ae80e7a7b0e2809ce5a4a7e8b59be2809defbc89e79a84e6b0b4e5b9b3e38082e7bb8fe4b8ade59bbde5a4a7e5ada6e7949fe8aea1e7ae97e69cbae8aebee8aea1e5a4a7e8b59be5ae89e5bebde79c81e7baa7e8b59be58cbae7bb84e7bb87e5a794e59198e4bc9aefbc8ce5ae89e5bebde79c81e9ab98e7ad89e5ada6e6a0a1e8aea1e7ae97e69cbae69599e882b2e7a094e7a9b6e4bc9ae7ab9ee8b59be5a794e59198e4bc9ae7a094e7a9b6efbc8ce68aa5e4b8ade59bbde5a4a7e5ada6e7949fe8aea1e7ae97e69cbae8aebee8aea1e5a4a7e8b59be7bb84e7bb87e5a794e59198e4bc9ae9809ae8bf87efbc9ae4b8bee58a9e32303133e5b9b4e2809ce59088e8b4a2e2809de69dafe4b8ade59bbde5a4a7e5ada6e7949fe8aea1e7ae97e69cbae8aebee8aea1e5a4a7e8b59be5ae89e5bebde79c81e7baa7e8b59be7ab9ee8b59be38082e78eb0e5b086e585b7e4bd93e7ab9ee8b59be4ba8be5ae9ce9809ae79fa5e5a682e4b88befbc9a0d0ae38080e38080e38080e58f82e8b59be5afb9e8b1a1efbc9ae59ca8e6a0a1e5a4a7e5ada6e69cace7a791e7949fe38081e9ab98e8818ce9ab98e4b893e7949f0d0ae38080e38080e38080e4b880e38081e7ab9ee8b59be58685e5aeb9e8a784e58899efbc9a0d0ae38080e38080e38080e8afa6e8a781e7bd91e7ab99efbc9a7777772e776b6a736a2e6f72670d0ae38080e38080e3808031efbc8ee8bdafe4bbb6e5ba94e794a8e4b88ee5bc80e58f91e7b1bbefbc8ce58c85e68bace4bba5e4b88be5b08fe7b1bbefbc9ae291a0e7bd91e7ab99e8aebee8aea1efbc9be291a1e695b0e68daee5ba93e5ba94e794a8efbc9be291a2e69599e5ada6e8afbee4bbb6efbc9be291a3e8999ae68b9fe5ae9ee9aa8ce5b9b3e58fb0e380820d0ae38080e38080e3808032efbc8ee695b0e5ad97e5aa92e4bd93e8aebee8aea1e7b1bbefbc8ce58c85e68bace4bba5e4b88be5b08fe7b1bbefbc9ae291a0e8aea1e7ae97e69cbae58aa8e794bbe38081e6b8b8e6888fefbc9be291a1e8aea1e7ae97e69cbae59bbee5bda2e59bbee5838fe8aebee8aea128e695b0e5ad97e7bb98e794bbe38081e59bbee5bda2e59bbee5838fe38081e8a786e8a789e8aebee8aea1e7ad8929efbc9be291a2e4baa4e4ba92e5aa92e4bd93e8aebee8aea128e794b5e5ad90e69d82e5bf97e38081e7a7bbe58aa8e7bb88e7abafe38081e695b0e5ad97e5b195e7a4bae38081e8999ae68b9fe78eb0e5ae9ee7ad8929efbc9be291a34456e5bdb1e78987e380820d0ae38080e38080e3808032303133e5b9b4e695b0e5ad97e5aa92e4bd93e8aebee8aea1e7b1bbe4bd9ce59381e79a84e58f82e8b59be4b8bbe9a298e4b8baefbc9ae6b0b4e38081e4b8ade58d8ee6b091e6978fe69687e58c96e58583e7b4a0e380820d0ae38080e38080e3808033efbc8ee8aea1e7ae97e69cbae99fb3e4b990e5889be4bd9ce7b1bbe38082e58c85e68bace4bba5e4b88be5b08fe7b1bbefbc9ae291a0e794b5e5ad90e99fb3e4b990efbc9be291a1e5889be7bc96e7b1bbefbc88e6ad8ce69bb2e68896e88085e4b8bae78bace5a58fe4b990e69bb2e5889be7bc96efbc89efbc9be291a2e8a786e9a291e9858de4b9900d0ae38080e38080e38080e4ba8ce38081e7ab9ee8b59be6b581e7a88befbc9a0d0a32303133e5b9b433e69c883331e697a5e5898de68aa5e5908de380820d0a34e69c883135e697a5e5898de7bd91e4b88ae68f90e4baa4e4bd9ce59381e380820d0a34e69c883330e697a5e5898de5a4a7e8b59be7bb84e5a794e4bc9ae5ae8ce68890e4bd9ce59381e5889de8af84e380820d0a20e59091e585a5e98089e8b59be9989fe68f90e587bae4bd9ce59381e694b9e8bf9be6848fe8a781e380820d0ae38080e38080e38080e291a42035e69c883135e697a5e5898de585a5e98089e8b59be9989fe59091e2809ce5a4a7e8b59be2809de7bb84e5a794e4bc9ae68f90e4baa4e69c80e7bb88e4bd9ce59381efbc88e68ea8e88d90e5898d343025e79a84e8b59be9989fe79bb4e68ea5e585a5e98089e2809ce5a4a7e8b59be2809de680bbe586b3e8b59be585ace7a4bae9989fe58897efbc89e380820d0a2036e69c883135e697a5e5898de88eb7e5a596e8b59be9989fe58f82e58aa0e58d8ee4b89ce8b59be58cbae78eb0e59cbae7ad94e8bea9efbc88e58fafe98089e9a1b9efbc89e380820d0ae38080e38080e38080e88194e7b3bbe4babaefbc9ae59088e882a5e8b4a2e7bb8fe8818ce4b89ae5ada6e999a22020e6b1aae69993e6aca30d0ae38080e38080e38080456d61696c20efbc9a3237303832383636394071712e636f6d200d0ae38080e38080e38080e794b52020e8af9defbc9a31353935353136383730350d0ae38080e38080e38080e4b889e38081e88eb7e5a596e6af94e4be8befbc88e7bb8fe4b8ade59bbde5a4a7e5ada6e7949fe8aea1e7ae97e69cbae8aebee8aea1e5a4a7e8b59be7bb84e7bb87e5a794e59198e4bc9ae8b083e695b4efbc89efbc9a0d0ae38080e38080e38080e4b880e7ad89e5a596efbc88e5ae9ee99985e58f82e8b59be9989fefbc89313525efbc9be4ba8ce7ad89e5a596efbc88e5ae9ee99985e58f82e8b59be9989fefbc89323525efbc9be4b889e7ad89e5a596efbc88e5ae9ee99985e58f82e8b59be9989fefbc89333025e380820d0ae38080e38080e38080e59b9be38081e7ab9ee8b59be69c8de58aa10d0ae38080e38080e38080e7bd91e7ab99e69c8de58aa1efbc9a7777772e61686a736a6a792e6e65740d0ae38080e38080e38080e68aa5e5908de8a1a8e68f90e4baa4efbc9a3237303832383636394071712e636f6d0d0ae38080e38080e38080e4bd9ce59381e68f90e4baa4efbc9a3237303832383636394071712e636f6d0d0ae38080e38080e38080e4bd9ce59381e5af84e98081e59cb0e59d80efbc9ae59088e882a5e8b4a2e7bb8fe8818ce4b89ae5ada6e999a22020e6b1aae69993e6aca320e694b60d0ae38080e38080e38080e982aee7bc96efbc9a3233303630310d0ae38080e38080e38080e592a8e8afa2efbc9ae6b1aae69993e6aca3efbc9a31353935353136383730350d0ae38080e38080e38080e38080e38080e38080e38080e5ad99e4b8ade8839cefbc9a31333031333132343431350d0ae38080e38080e380800d0ae38080e38080e380800d0ae38080e38080e380800d0a2020202020202020202020202020202020202020202020202020202032303133e5b9b433e69c883232e697a50d0a0d0a32303133e5b9b4e2809ce59088e8b4a2e2809de69dafe4b8ade59bbde5a4a7e5ada6e7949fe8aea1e7ae97e69cbae8aebee8aea1e5a4a7e8b59be5ae89e5bebde79c81e7baa7e8b59be68aa5e5908de8a1a80d0a0d0ae58f82e8b59be999a2e6a0a1090d0ae5ada6e6a0a1e7ab9ee8b59be88194e7b3bbe4baba09e5a79320202020e5908d0909e680a720202020e588ab090d0a09e8818c20202020e58aa10909e8818c20202020e7a7b0090d0a09e59bbae5ae9ae794b5e8af9d0909e7a7bbe58aa8e794b5e8af9d090d0a09e794b5e5ad90e982aee7aeb1090d0a09e9809ae4bfa1e59cb0e59d800909e982aee694bfe7bc96e7a081090d0ae4bd9ce59381310909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381320909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381330909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381340909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381350909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381360909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381370909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381380909e4bd9ce59381e7b1bbe588ab090d0ae4bd9ce59381390909e4bd9ce59381e7b1bbe588ab090d0ae38082e38082e38082e38082e38082e380820909e4bd9ce59381e7b1bbe588ab090d0a0d0ae6b3a8efbc9ae4bd9ce59381e68c897777772e776b6a736a2e6f7267e7bd91e7ab99e68980e58897e79a84e8a681e6b182e68f90e4baa4e380820d0a, '1000', '2013-04-10 22:57:54');

-- --------------------------------------------------------

--
-- 表的结构 `gm_stuinfo`
--

DROP TABLE IF EXISTS `gm_stuinfo`;
CREATE TABLE IF NOT EXISTS `gm_stuinfo` (
  `gm_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '学生id',
  `gm_active` char(1) character set utf8 collate utf8_bin NOT NULL default '0' COMMENT '是否审核',
  `gm_num` int(14) unsigned NOT NULL COMMENT '学号',
  `gm_username` varchar(20) NOT NULL COMMENT '姓名',
  `gm_teacher` varchar(20) default NULL,
  `gm_sex` char(1) character set utf8 collate utf8_bin NOT NULL COMMENT '性别',
  `gm_birth` date NOT NULL COMMENT '生日',
  `gm_start_time` date NOT NULL COMMENT '入学时间',
  `gm_grade` char(3) NOT NULL COMMENT '年级',
  `gm_contact` char(14) character set utf8 collate utf8_bin NOT NULL COMMENT '联系方式',
  `gm_address` varchar(40) character set utf8 collate utf8_bin NOT NULL COMMENT '家庭住址',
  `gm_saddress` varchar(30) character set utf8 collate utf8_bin NOT NULL COMMENT '学校内住址',
  `gm_subject` char(8) character set utf8 collate utf8_bin NOT NULL COMMENT '专业',
  `gm_type` char(4) character set utf8 collate utf8_bin NOT NULL COMMENT '培养管理类型',
  `gm_remarks` text character set utf8 collate utf8_bin COMMENT '备注',
  `gm_photoname` varchar(50) character set utf8 collate utf8_bin NOT NULL COMMENT '照片名称',
  PRIMARY KEY  (`gm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- 导出表中的数据 `gm_stuinfo`
--

INSERT INTO `gm_stuinfo` (`gm_id`, `gm_active`, `gm_num`, `gm_username`, `gm_teacher`, `gm_sex`, `gm_birth`, `gm_start_time`, `gm_grade`, `gm_contact`, `gm_address`, `gm_saddress`, `gm_subject`, `gm_type`, `gm_remarks`, `gm_photoname`) VALUES
(31, '1', 119074365, 'Leo', '', '男', '1992-10-13', '2011-09-01', '研二', '18777777777', '安徽省霍邱县安业村', '', '计算机软件与理论', '学术型', NULL, '/20130410145537.jpg'),
(32, '0', 119066876, '张三', NULL, '女', '1991-04-01', '2012-03-01', '研二', '18888887777', '安徽省寿县', '', '计算机应用技术', '专业型', NULL, '/20130410145630.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `gm_system`
--

DROP TABLE IF EXISTS `gm_system`;
CREATE TABLE IF NOT EXISTS `gm_system` (
  `gm_id` tinyint(2) unsigned NOT NULL auto_increment COMMENT 'id',
  `gm_webname` varchar(100) collate utf8_bin NOT NULL COMMENT '网站标题',
  `gm_initial_password` varchar(40) collate utf8_bin NOT NULL COMMENT '默认密码',
  `gm_register` char(1) collate utf8_bin NOT NULL COMMENT '是否允许注册',
  `gm_needcode` char(1) collate utf8_bin NOT NULL COMMENT '是否需要验证码',
  `gm_help_login` varchar(300) collate utf8_bin default '无' COMMENT '登录界面帮助信息',
  `gm_user_date_page` char(1) collate utf8_bin NOT NULL COMMENT '用户信息分页',
  `gm_stu_active_page` char(1) collate utf8_bin NOT NULL COMMENT '审核分页',
  `gm_stu_date_page` char(1) collate utf8_bin NOT NULL COMMENT '研究生信息分页',
  `gm_message_page` char(1) collate utf8_bin NOT NULL COMMENT '留言板分页',
  `gm_notice_page` char(1) collate utf8_bin NOT NULL COMMENT '公告中心分页',
  `gm_funds_admin_page` char(1) collate utf8_bin NOT NULL COMMENT '经费管理分页',
  `gm_user_date_pagesize` char(4) collate utf8_bin NOT NULL COMMENT '用户信息分页大小',
  `gm_stu_active_pagesize` char(4) collate utf8_bin NOT NULL COMMENT '审核分页大小',
  `gm_stu_date_pagesize` char(4) collate utf8_bin NOT NULL COMMENT '研究生信息分页大小',
  `gm_message_pagesize` char(4) collate utf8_bin NOT NULL COMMENT '留言板分页大小',
  `gm_notice_pagesize` char(4) collate utf8_bin NOT NULL COMMENT '公告中心分页大小',
  `gm_funds_admin_pagesize` char(4) collate utf8_bin NOT NULL COMMENT '经费管理分页大小',
  `gm_inputDetails` varchar(200) collate utf8_bin default NULL COMMENT '学生申请经费事由',
  PRIMARY KEY  (`gm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 导出表中的数据 `gm_system`
--

INSERT INTO `gm_system` (`gm_id`, `gm_webname`, `gm_initial_password`, `gm_register`, `gm_needcode`, `gm_help_login`, `gm_user_date_page`, `gm_stu_active_page`, `gm_stu_date_page`, `gm_message_page`, `gm_notice_page`, `gm_funds_admin_page`, `gm_user_date_pagesize`, `gm_stu_active_pagesize`, `gm_stu_date_pagesize`, `gm_message_pagesize`, `gm_notice_pagesize`, `gm_funds_admin_pagesize`, `gm_inputDetails`) VALUES
(1, '计算机学院研究生档案管理', '123456', '1', '0', '*用户名为学号<br/>*初始密码是：123456<br/>*如果你的密码不正确可能是被重置了<br/>*忘记密码请联系管理员', '2', '2', '2', '1', '2', '2', '40', '40', '40', '40', '40', '40', '发表论文补贴 成绩优秀奖励 进步显著奖励 乐于助人');

-- --------------------------------------------------------

--
-- 表的结构 `gm_teacher`
--

DROP TABLE IF EXISTS `gm_teacher`;
CREATE TABLE IF NOT EXISTS `gm_teacher` (
  `gm_id` mediumint(8) NOT NULL auto_increment,
  `gm_num` int(14) NOT NULL,
  `gm_username` varchar(20) collate utf8_bin NOT NULL,
  `gm_funds` int(8) default '0',
  `gm_zc` varchar(20) collate utf8_bin NOT NULL,
  `gm_student` varchar(150) collate utf8_bin default NULL,
  PRIMARY KEY  (`gm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- 导出表中的数据 `gm_teacher`
--


-- --------------------------------------------------------

--
-- 表的结构 `gm_user`
--

DROP TABLE IF EXISTS `gm_user`;
CREATE TABLE IF NOT EXISTS `gm_user` (
  `gm_id` mediumint(8) unsigned NOT NULL auto_increment COMMENT '用户id',
  `gm_active` char(1) character set utf8 collate utf8_bin NOT NULL default '0' COMMENT '是否审核',
  `gm_level` char(1) character set utf8 collate utf8_bin NOT NULL default '1' COMMENT '用户权限',
  `gm_username` varchar(20) character set utf8 collate utf8_bin NOT NULL COMMENT '用户名',
  `gm_num` int(14) unsigned NOT NULL COMMENT '用户编号',
  `gm_password` char(40) character set utf8 collate utf8_bin NOT NULL COMMENT '用户密码',
  `gm_reg_time` datetime NOT NULL COMMENT '注册时间',
  `gm_last_time` datetime NOT NULL COMMENT '上次登录时间',
  `gm_last_ip` varchar(20) character set utf8 collate utf8_bin NOT NULL COMMENT '上次登录IP',
  PRIMARY KEY  (`gm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- 导出表中的数据 `gm_user`
--

INSERT INTO `gm_user` (`gm_id`, `gm_active`, `gm_level`, `gm_username`, `gm_num`, `gm_password`, `gm_reg_time`, `gm_last_time`, `gm_last_ip`) VALUES
(1, '1', '3', 'sadmin', 1000, '356a192b7913b04c54574d18c28d46e6395428ab', '2012-07-28 16:08:56', '2013-04-10 23:02:38', '127.0.0.1'),
(42, '1', '2', 'admin', 1001, '356a192b7913b04c54574d18c28d46e6395428ab', '2012-08-28 13:15:57', '2012-10-18 11:22:13', '127.0.0.1'),
(48, '1', '1', 'Leo', 119074365, '7c4a8d09ca3762af61e59520943dc26494f8941b', '2013-04-10 22:55:37', '2013-04-10 22:58:50', '127.0.0.1'),
(49, '0', '1', '张三', 119066876, '356a192b7913b04c54574d18c28d46e6395428ab', '2013-04-10 22:56:30', '2013-04-10 22:56:30', '127.0.0.1');
