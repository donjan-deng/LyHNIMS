-- MySQL dump 10.13  Distrib 5.6.12, for Win32 (x86)
--
-- Host: localhost    Database: lyhnimsdb
-- ------------------------------------------------------
-- Server version	5.6.12-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('咨询','6',1433566566),('导医','5',1433566505),('竞价','3',1433565005),('竞价','4',1433565733),('管理员','1',1433573415),('管理员','2',1433556404),('管理员','3',1433565005);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('Channel',2,'渠道管理',NULL,NULL,1433552508,1433552508),('channel/cost',2,'渠道消费管理',NULL,NULL,1433552508,1433552508),('channel/costcreate',2,'添加渠道消费',NULL,NULL,1433552508,1433552508),('channel/costdel',2,'删除渠道消费',NULL,NULL,1433552508,1433552508),('channel/costedit',2,'编辑渠道消费',NULL,NULL,1433552508,1433552508),('channel/costlist',2,'查看渠道消费',NULL,NULL,1433552508,1433552508),('channel/create',2,'添加渠道',NULL,NULL,1433552508,1433552508),('channel/del',2,'删除渠道',NULL,NULL,1433552508,1433552508),('channel/edit',2,'编辑渠道',NULL,NULL,1433552508,1433552508),('channel/index',2,'渠道管理',NULL,NULL,1433552508,1433552508),('channel/list',2,'查看渠道',NULL,NULL,1433552508,1433552508),('department/create',2,'添加科室',NULL,NULL,1433552508,1433552508),('department/del',2,'删除科室',NULL,NULL,1433552508,1433552508),('department/edit',2,'编辑科室',NULL,NULL,1433552508,1433552508),('department/index',2,'科室管理',NULL,NULL,1433552508,1433552508),('department/list',2,'查看科室',NULL,NULL,1433552508,1433552508),('department/merge',2,'合并科室',NULL,NULL,1433552508,1433552508),('doctor/create',2,'添加医生',NULL,NULL,1433552509,1433552509),('doctor/del',2,'删除医生',NULL,NULL,1433552509,1433552509),('doctor/edit',2,'编辑医生',NULL,NULL,1433552509,1433552509),('doctor/index',2,'医生管理',NULL,NULL,1433552509,1433552509),('doctor/list',2,'查看医生',NULL,NULL,1433552509,1433552509),('Record',2,'患者管理',NULL,NULL,1433552508,1433552508),('record/allocate',2,'分诊',NULL,NULL,1433552508,1433552508),('record/appointment',2,'预约管理',NULL,NULL,1433552508,1433552508),('record/appointmentlist',2,'查看预约',NULL,NULL,1433552508,1433552508),('record/create',2,'添加对话',NULL,NULL,1433552508,1433552508),('record/del',2,'删除对话',NULL,NULL,1433552508,1433552508),('record/edit',2,'编辑对话',NULL,NULL,1433552508,1433552508),('record/index',2,'对话管理',NULL,NULL,1433552508,1433552508),('record/list',2,'查看对话',NULL,NULL,1433552508,1433552508),('Report',2,'统计报表',NULL,NULL,1433552509,1433552509),('report/channel',2,'渠道报表',NULL,NULL,1433552509,1433552509),('report/channelreport',2,'查看渠道报表',NULL,NULL,1433552509,1433552509),('report/user',2,'用户报表',NULL,NULL,1433552509,1433552509),('report/userreport',2,'查看用户报表',NULL,NULL,1433552509,1433552509),('User',2,'权限管理',NULL,NULL,1433572341,1433572341),('user/create',2,'添加用户',NULL,NULL,1433572341,1433572341),('user/del',2,'删除用户',NULL,NULL,1433572341,1433572341),('user/edit',2,'编辑用户',NULL,NULL,1433572341,1433572341),('user/index',2,'用户管理',NULL,NULL,1433572341,1433572341),('user/list',2,'查看用户',NULL,NULL,1433572341,1433572341),('user/role',2,'角色管理',NULL,NULL,1433572341,1433572341),('user/rolecreate',2,'添加角色',NULL,NULL,1433572342,1433572342),('user/roledel',2,'删除角色',NULL,NULL,1433572342,1433572342),('user/roleedit',2,'编辑角色',NULL,NULL,1433572342,1433572342),('user/rolelist',2,'查看角色',NULL,NULL,1433572342,1433572342),('咨询',1,NULL,NULL,NULL,1433566416,1433566416),('咨询主管',1,NULL,NULL,NULL,1433566448,1433566448),('导医',1,NULL,NULL,NULL,1433566477,1433566477),('竞价',1,NULL,NULL,NULL,1433552524,1433552524),('管理员',1,NULL,NULL,NULL,1433552560,1433552560),('网络总监',1,NULL,NULL,NULL,1433566686,1433566686);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('管理员','Channel'),('网络总监','Channel'),('管理员','channel/cost'),('网络总监','channel/cost'),('管理员','channel/costdel'),('管理员','channel/costedit'),('管理员','channel/costlist'),('网络总监','channel/costlist'),('管理员','channel/del'),('管理员','channel/edit'),('管理员','channel/index'),('网络总监','channel/index'),('管理员','channel/list'),('网络总监','channel/list'),('咨询主管','department/del'),('管理员','department/del'),('咨询主管','department/edit'),('管理员','department/edit'),('咨询主管','department/index'),('管理员','department/index'),('网络总监','department/index'),('咨询主管','department/list'),('管理员','department/list'),('网络总监','department/list'),('咨询主管','department/merge'),('管理员','department/merge'),('咨询主管','doctor/del'),('管理员','doctor/del'),('咨询主管','doctor/edit'),('管理员','doctor/edit'),('咨询主管','doctor/index'),('管理员','doctor/index'),('网络总监','doctor/index'),('咨询主管','doctor/list'),('管理员','doctor/list'),('网络总监','doctor/list'),('咨询','Record'),('咨询主管','Record'),('导医','Record'),('竞价','Record'),('管理员','Record'),('网络总监','Record'),('咨询主管','record/allocate'),('导医','record/allocate'),('管理员','record/allocate'),('咨询','record/appointment'),('咨询主管','record/appointment'),('导医','record/appointment'),('管理员','record/appointment'),('网络总监','record/appointment'),('咨询','record/appointmentlist'),('咨询主管','record/appointmentlist'),('导医','record/appointmentlist'),('管理员','record/appointmentlist'),('网络总监','record/appointmentlist'),('咨询主管','record/del'),('管理员','record/del'),('咨询','record/edit'),('咨询主管','record/edit'),('管理员','record/edit'),('咨询','record/index'),('咨询主管','record/index'),('管理员','record/index'),('网络总监','record/index'),('咨询','record/list'),('咨询主管','record/list'),('管理员','record/list'),('网络总监','record/list'),('咨询','Report'),('咨询主管','Report'),('竞价','Report'),('管理员','Report'),('网络总监','Report'),('管理员','report/channel'),('网络总监','report/channel'),('管理员','report/channelreport'),('网络总监','report/channelreport'),('咨询','report/user'),('咨询主管','report/user'),('竞价','report/user'),('管理员','report/user'),('网络总监','report/user'),('咨询','report/userreport'),('咨询主管','report/userreport'),('竞价','report/userreport'),('管理员','report/userreport'),('网络总监','report/userreport'),('管理员','User'),('管理员','user/del'),('管理员','user/edit'),('管理员','user/index'),('管理员','user/list'),('管理员','user/role'),('管理员','user/roledel'),('管理员','user/roleedit'),('管理员','user/rolelist');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1433477953);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_channel`
--

DROP TABLE IF EXISTS `tbl_channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_channel`
--

LOCK TABLES `tbl_channel` WRITE;
/*!40000 ALTER TABLE `tbl_channel` DISABLE KEYS */;
INSERT INTO `tbl_channel` VALUES (1,'百度竞价',1),(3,'百度网盟',1),(4,'百度健康',1);
/*!40000 ALTER TABLE `tbl_channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_channel_cost`
--

DROP TABLE IF EXISTS `tbl_channel_cost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_channel_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel_id` int(11) NOT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `fee` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_channel_cost`
--

LOCK TABLES `tbl_channel_cost` WRITE;
/*!40000 ALTER TABLE `tbl_channel_cost` DISABLE KEYS */;
INSERT INTO `tbl_channel_cost` VALUES (1,3,1433260800,1433347199,200.33),(2,4,1433260800,1435334399,1000.25),(3,3,1433347200,1433433599,200.33),(4,1,1433347200,1433519999,300);
/*!40000 ALTER TABLE `tbl_channel_cost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_department`
--

DROP TABLE IF EXISTS `tbl_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_department`
--

LOCK TABLES `tbl_department` WRITE;
/*!40000 ALTER TABLE `tbl_department` DISABLE KEYS */;
INSERT INTO `tbl_department` VALUES (8,'人流',1),(11,'产科',1),(12,'男科',1);
/*!40000 ALTER TABLE `tbl_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_doctor`
--

DROP TABLE IF EXISTS `tbl_doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_doctor`
--

LOCK TABLES `tbl_doctor` WRITE;
/*!40000 ALTER TABLE `tbl_doctor` DISABLE KEYS */;
INSERT INTO `tbl_doctor` VALUES (1,'张三',1),(2,'李四',1),(4,'张英',1);
/*!40000 ALTER TABLE `tbl_doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_record`
--

DROP TABLE IF EXISTS `tbl_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `appointment` int(11) NOT NULL,
  `arrived_at` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` varchar(200) NOT NULL,
  `is_valid` tinyint(1) NOT NULL,
  `is_reserve` tinyint(1) NOT NULL,
  `is_arrive` tinyint(1) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `channel_note` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_record`
--

LOCK TABLES `tbl_record` WRITE;
/*!40000 ALTER TABLE `tbl_record` DISABLE KEYS */;
INSERT INTO `tbl_record` VALUES (1,'张三','1325442114',8,1433218196,0,1433312203,1,1,'300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,300块,',1,0,1,4,'人流多少钱'),(2,'','',8,1433218376,0,0,0,1,'备注\r\n备注\r\n备注\r\n备注\r\n备注',1,1,0,3,'人流计划'),(4,'李丽','1352685625',11,1433234752,1433347200,0,4,1,'aaa',1,1,0,4,'人流多少钱'),(5,'','13637758526',12,1433307484,0,0,2,1,'',1,0,0,3,''),(6,'','',8,1433218196,0,0,0,1,'',1,0,0,3,''),(7,'张伟','1325234',12,1433218196,1434643200,0,1,1,'',1,1,0,1,'包皮'),(8,'张先生','1365824563',12,1433565601,0,0,0,2,'',1,1,0,1,'包皮过长');
/*!40000 ALTER TABLE `tbl_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_record_log`
--

DROP TABLE IF EXISTS `tbl_record_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_record_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `note` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_record_log`
--

LOCK TABLES `tbl_record_log` WRITE;
/*!40000 ALTER TABLE `tbl_record_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_record_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `auth_key` varchar(50) NOT NULL,
  `access_token` varchar(50) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'admin','$2y$13$J0lXtYNHmwUs1X8kUE62dOte45Cmdm68qM9RvVQx/0scKsM4mFTAS','uyd1EhlCtakkk4zP5ERN_PRjA7etK8CK','',1433556404,1433552266,1),(2,'user1','$2y$13$Wx77UBYyZMIMh1rjACmi/unNcpG8kF.s2.O2Pq/evSLo.No3IEQ4u','ctpNT1G3ioE1OYcHentQqmnU4tuIiVt7','',1433556404,1433568105,1),(4,'李某','$2y$13$CPvWlvjxkPsEPh.Zl549v.f0n1vNtVGV1tw1qAfWipzX6ON7z8A.u','_FnmPq_8ZFKFEmM07hM_zgkaX4_uTv_M','',1433565725,1433565942,1),(5,'user2','$2y$13$nCZUtNgU2dD5hP0eop6QkOo5oOCtsJvWmC9rWehzkvWZLS0SqgFUe','WP9M-LeKpVIHFOvqCKCTJp0n1c9wjSiu','',1433566505,1433573477,1),(6,'user3','$2y$13$.2dakXf/MLj.HKqBna37OOK38IE/FXuQKB1zNq0ns3TaBLzQxtPFC','HJtWAqBReSLhKOntnWb0Vgjc9KItf1IR','',1433566566,1433566579,1);
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-06 15:26:49
