-- MySQL dump 10.17  Distrib 10.3.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: college_shop
-- ------------------------------------------------------
-- Server version       10.3.22-MariaDB-1:10.3.22+maria~bionic-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `flag`
--

DROP TABLE IF EXISTS `flag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `flag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flag`
--

LOCK TABLES `flag` WRITE;
/*!40000 ALTER TABLE `flag` DISABLE KEYS */;
INSERT INTO `flag` VALUES (1,'Распродажа'),(2,'Хит'),(3,'Новинка');
/*!40000 ALTER TABLE `flag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folder`
--

DROP TABLE IF EXISTS `folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `_left` int(10) unsigned NOT NULL,
  `_right` int(10) unsigned NOT NULL,
  `_lvl` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folder`
--

LOCK TABLES `folder` WRITE;
/*!40000 ALTER TABLE `folder` DISABLE KEYS */;
INSERT INTO `folder` VALUES (1,'Категория 3',0,1,1);
/*!40000 ALTER TABLE `folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `folder_has_product`
--

DROP TABLE IF EXISTS `folder_has_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `folder_has_product` (
  `folder_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`folder_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `folder_has_product`
--

LOCK TABLES `folder_has_product` WRITE;
/*!40000 ALTER TABLE `folder_has_product` DISABLE KEYS */;
INSERT INTO `folder_has_product` VALUES (1,1);
/*!40000 ALTER TABLE `folder_has_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `type` set('avatar','product') NOT NULL,
  `path` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` VALUES (1,'Image1','product','/assets/dynamic/images/product/img_lights.jpg'),(2,'Image2','product','/assets/dynamic/images/product/one-tree-hill-1360813.jpg'),(3,'Image3','product','/assets/dynamic/images/product/tree-736885__340.jpg'),(4,'Logo','product','/assets/dynamic/images/product/logo.jpg'),(5,'Slider1','product','/assets/dynamic/images/product/main_slider_1.jpg'),(6,'Slider2','product','/assets/dynamic/images/product/main_slider_2.jpg'),(7,'Brand1','product','/assets/dynamic/images/product/brand_1.jpg'),(8,'Brand2','product','/assets/dynamic/images/product/brand_2.jpg'),(9,'Brand3','product','/assets/dynamic/images/product/brand_3.jpg'),(10,'Brand4','product','/assets/dynamic/images/product/brand_4.jpg');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Меню 1'),(2,'Меню 2'),(3,'Меню 3');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `status` set('waiting','paid','done','archived') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `count` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `article` varchar(255) NOT NULL,
  `image_id` int(10) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `vendor_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'Товар','18su5',1,'Some description for this tovar',5000.00,25,1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_comment`
--

DROP TABLE IF EXISTS `product_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `rating` decimal(5,2) unsigned NOT NULL DEFAULT 0.00,
  `value` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_comment`
--

LOCK TABLES `product_comment` WRITE;
/*!40000 ALTER TABLE `product_comment` DISABLE KEYS */;
INSERT INTO `product_comment` VALUES (1,1,1,4.00,'Хороший товар и конкурсы интересные');
/*!40000 ALTER TABLE `product_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_has_flag`
--

DROP TABLE IF EXISTS `product_has_flag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_has_flag` (
  `product_id` int(10) unsigned NOT NULL,
  `flag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`product_id`,`flag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_has_flag`
--

LOCK TABLES `product_has_flag` WRITE;
/*!40000 ALTER TABLE `product_has_flag` DISABLE KEYS */;
INSERT INTO `product_has_flag` VALUES (1,1),(1,2),(1,3);
/*!40000 ALTER TABLE `product_has_flag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_param`
--

DROP TABLE IF EXISTS `product_param`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_param` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_param`
--

LOCK TABLES `product_param` WRITE;
/*!40000 ALTER TABLE `product_param` DISABLE KEYS */;
INSERT INTO `product_param` VALUES (1,'Доска');
/*!40000 ALTER TABLE `product_param` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_param_value`
--

DROP TABLE IF EXISTS `product_param_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_param_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `param_id` int(10) unsigned NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_param_value`
--

LOCK TABLES `product_param_value` WRITE;
/*!40000 ALTER TABLE `product_param_value` DISABLE KEYS */;
INSERT INTO `product_param_value` VALUES (1,1,1,'Есть');
/*!40000 ALTER TABLE `product_param_value` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `route` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `real_url` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `_left` int(10) unsigned NOT NULL,
  `_right` int(10) unsigned NOT NULL,
  `_lvl` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `is_hidden` tinyint(1) DEFAULT 0,
  `template_id` int(10) unsigned NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `route`
--

LOCK TABLES `route` WRITE;
/*!40000 ALTER TABLE `route` DISABLE KEYS */;
INSERT INTO `route` VALUES (1,'/as','Страница с текстом','as',0,5,1,1,0,1,'{\"text\":\"<p>123<\\/p>\"}'),(5,'/as/a','Страница с текстом','a',1,4,2,1,0,1,'{\"text\":\"<h1>Why not?<\\/h1><p>Hey<\\/p><p>I will kill u<\\/p><ol><li>u&nbsp;<\\/li><li>u too<\\/li><\\/ol><p>asd<\\/p>\"}'),(6,'/as/a/dfadg','afdg','dfadg',2,3,3,1,0,1,'{\"text\":\"asdasd\"}'),(11,'/asd','Фотоальбом','asd',6,7,1,1,0,2,'{\"images\":[\"1\",\"2\",\"3\"],\"text\":\"<p><strong>asdasdasdf<\\/strong><\\/p>\"}'),(12,'/asdd','dsa','asdd',8,9,1,1,0,2,'{\"images\":[\"1\",\"3\"],\"text\":\"<p><sup>asd<\\/sup><\\/p>\"}'),(13,'/menu','asd','menu',10,11,1,1,0,3,'{\"menu\":\"1\",\"text\":\"Some textd\"}'),(14,'/text','Multiply text','text',12,13,1,1,0,4,'{\"text\":[\"some\",\"text\",\"not\",\"found\",\"this\",\"d\"]}'),(15,'/ddd','dddd','ddd',14,17,1,2,0,1,'{\"text\":\"<p>ddd<\\/p>\"}'),(16,'/ddd/asdasdasd','asdasdasd','asdasdasd',15,16,2,2,0,1,'{\"text\":\"<p>asdasdasd<\\/p>\"}'),(17,'/','Титульная','',18,19,1,3,0,5,'{\"brands\":[\"7\",\"8\",\"9\",\"10\"],\"slider\":[\"5\",\"6\"],\"about\":\"<p class=\\\"title\\\" style=\\\"font-size: 20px; line-height: 24px; padding-bottom: 18px; font-weight: bold; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, sans-serif; text-align: center; background-color: rgb(238, 238, 238);\\\">\\u041e \\u043c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d\\u0435<\\/p><p class=\\\"text\\\" style=\\\"font-size: 14px; line-height: 22px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, sans-serif; text-align: center; background-color: rgb(238, 238, 238);\\\">\\u0418\\u043d\\u0442\\u0435\\u0440\\u043d\\u0435\\u0442-\\u043c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d \\u00abCoffee Time\\u00bb \\u043f\\u0440\\u0435\\u0434\\u043b\\u0430\\u0433\\u0430\\u0435\\u0442 \\u0448\\u0438\\u0440\\u043e\\u043a\\u0438\\u0439 \\u0430\\u0441\\u0441\\u043e\\u0440\\u0442\\u0438\\u043c\\u0435\\u043d\\u0442 \\u043a\\u043e\\u0444\\u0435 \\u043e\\u0442 \\u0438\\u0437\\u0432\\u0435\\u0441\\u0442\\u043d\\u044b\\u0445 \\u043f\\u0440\\u043e\\u0438\\u0437\\u0432\\u043e\\u0434\\u0438\\u0442\\u0435\\u043b\\u0435\\u0439. \\u0412 \\u043d\\u0430\\u0448\\u0435\\u043c \\u043a\\u0430\\u0442\\u0430\\u043b\\u043e\\u0433\\u0435 \\u2013 \\u0442\\u043e\\u043b\\u044c\\u043a\\u043e \\u043a\\u0430\\u0447\\u0435\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u0430\\u044f \\u043d\\u0430\\u0442\\u0443\\u0440\\u0430\\u043b\\u044c\\u043d\\u0430\\u044f \\u043f\\u0440\\u043e\\u0434\\u0443\\u043a\\u0446\\u0438\\u044f \\u0434\\u043b\\u044f \\u043f\\u0440\\u0438\\u0433\\u043e\\u0442\\u043e\\u0432\\u043b\\u0435\\u043d\\u0438\\u044f \\u043b\\u0430\\u0442\\u0442\\u0435, \\u044d\\u0441\\u043f\\u0440\\u0435\\u0441\\u0441\\u043e, \\u043a\\u0430\\u043f\\u0443\\u0447\\u0438\\u043d\\u043e, \\u043c\\u0430\\u043a\\u0438\\u0430\\u0442\\u043e \\u0432 \\u043a\\u043e\\u0444\\u0435\\u0432\\u0430\\u0440\\u043a\\u0435, \\u043a\\u043e\\u0444\\u0435\\u043c\\u0430\\u0448\\u0438\\u043d\\u0435, \\u0444\\u0440\\u0435\\u043d\\u0447-\\u043f\\u0440\\u0435\\u0441\\u0441\\u0435 \\u0438\\u043b\\u0438 \\u0442\\u0443\\u0440\\u043a\\u0435. \\u0423 \\u043d\\u0430\\u0441 \\u043c\\u043e\\u0436\\u043d\\u043e \\u043a\\u0443\\u043f\\u0438\\u0442\\u044c \\u043a\\u043e\\u0444\\u0435 \\u0432 \\u0437\\u0435\\u0440\\u043d\\u0430\\u0445, \\u043a\\u0430\\u043f\\u0441\\u0443\\u043b\\u0430\\u0445, \\u0447\\u0430\\u043b\\u0434\\u0430\\u0445, \\u0430 \\u0442\\u0430\\u043a\\u0436\\u0435 \\u043c\\u043e\\u043b\\u043e\\u0442\\u044b\\u0439 \\u0438 \\u0440\\u0430\\u0441\\u0442\\u0432\\u043e\\u0440\\u0438\\u043c\\u044b\\u0439. \\u0421\\u043b\\u0435\\u0434\\u0438\\u0442\\u0435 \\u0437\\u0430 \\u0430\\u043a\\u0446\\u0438\\u044f\\u043c\\u0438 \\u0438 \\u0441\\u043f\\u0435\\u0446\\u0438\\u0430\\u043b\\u044c\\u043d\\u044b\\u043c\\u0438 \\u043f\\u0440\\u0435\\u0434\\u043b\\u043e\\u0436\\u0435\\u043d\\u0438\\u044f\\u043c\\u0438 \\u2013 \\u043d\\u0435 \\u0443\\u043f\\u0443\\u0441\\u0442\\u0438\\u0442\\u0435 \\u0432\\u043e\\u0437\\u043c\\u043e\\u0436\\u043d\\u043e\\u0441\\u0442\\u044c \\u0437\\u0430\\u043a\\u0430\\u0437\\u0430\\u0442\\u044c \\u043a\\u043e\\u0444\\u0435 \\u0438 \\u0434\\u0440\\u0443\\u0433\\u0438\\u0435 \\u0442\\u043e\\u0432\\u0430\\u0440\\u044b \\u043f\\u043e \\u0435\\u0449\\u0435 \\u0431\\u043e\\u043b\\u0435\\u0435 \\u0432\\u044b\\u0433\\u043e\\u0434\\u043d\\u044b\\u043c \\u0446\\u0435\\u043d\\u0430\\u043c. \\u0412\\u044b\\u0431\\u0435\\u0440\\u0438\\u0442\\u0435 \\u043f\\u043e\\u043d\\u0440\\u0430\\u0432\\u0438\\u0432\\u0448\\u0438\\u0439\\u0441\\u044f \\u0441\\u043e\\u0440\\u0442 \\u0438 \\u043e\\u0444\\u043e\\u0440\\u043c\\u0438\\u0442\\u0435 \\u043f\\u043e\\u043a\\u0443\\u043f\\u043a\\u0443. \\u0412\\u0430\\u0448 \\u0437\\u0430\\u043a\\u0430\\u0437 \\u0431\\u0443\\u0434\\u0435\\u0442 \\u043e\\u043f\\u0435\\u0440\\u0430\\u0442\\u0438\\u0432\\u043d\\u043e \\u0434\\u043e\\u0441\\u0442\\u0430\\u0432\\u043b\\u0435\\u043d \\u0432 \\u043b\\u044e\\u0431\\u043e\\u0439 \\u0440\\u0435\\u0433\\u0438\\u043e\\u043d \\u0423\\u043a\\u0440\\u0430\\u0438\\u043d\\u044b.<\\/p>\"}'),(18,'/123','Титульная','123',20,21,1,3,0,5,'{\"about\":\"<p>\\u041c\\u0430\\u0433\\u0430\\u0437\\u0438\\u043d \\u0445\\u043e\\u0440\\u043e\\u0448\\u0438\\u0439<\\/p>\"}');
/*!40000 ALTER TABLE `route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_params`
--

DROP TABLE IF EXISTS `site_params`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `site_params` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vars` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_params`
--

LOCK TABLES `site_params` WRITE;
/*!40000 ALTER TABLE `site_params` DISABLE KEYS */;
INSERT INTO `site_params` VALUES (1,'{\"logo\": {\"type\": \"image\", \"title\": \"Логотип\"}, \"menu1\": {\"type\": \"menu\", \"title\": \"Верхнее Меню\"}, \"menu2\": {\"type\": \"menu\", \"title\": \"Нижнее Меню\"}, \"phones\": {\"type\": \"text\", \"title\": \"Телефоны\", \"multiply\": true}}','{\"logo\":\"4\",\"menu1\":\"1\",\"menu2\":\"2\",\"phones\":[\"8 800 555 35 35\",\"8 777 777 77 77\"]}');
/*!40000 ALTER TABLE `site_params` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `template`
--

DROP TABLE IF EXISTS `template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `params` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template`
--

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
INSERT INTO `template` VALUES (1,'Страница с текстом','custom_templates/page_with_text.html.twig','{\"text\": {\"type\": \"html\", \"title\": \"Текст\"}}'),(2,'Фотогалерея','custom_templates/galery.html.twig','{\"text\": {\"type\": \"html\", \"title\": \"Текст\"}, \"images\": {\"type\": \"image\", \"title\": \"Фотографии\", \"multiply\": \"true\"}}'),(3,'Дерево меню','custom_templates/links.html.twig','{\"menu\": {\"type\": \"menu\", \"title\": \"Меню\"}, \"text\": {\"type\": \"text\", \"title\": \"Текст\"}}'),(4,'Multiply text','custom_templates/text.html.twig','{\"text\": {\"type\": \"text\", \"title\": \"Текста\", \"multiply\": true}}'),(5,'Титульная','custom_templates/title.html.twig','{\"about\": {\"type\": \"html\", \"title\": \"О магазине\"}, \"brands\": {\"type\": \"image\", \"title\": \"Партнеры\", \"multiply\": true}, \"slider\": {\"type\": \"image\", \"title\": \"Слайдер\", \"multiply\": true}}');
/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(10) unsigned DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,NULL,'Михаил','Сюрсин','mihha1818@ya.ru','+77714392646','bf88d7030997b401b1776ca0c98e0106');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor`
--

DROP TABLE IF EXISTS `vendor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vendor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor`
--

LOCK TABLES `vendor` WRITE;
/*!40000 ALTER TABLE `vendor` DISABLE KEYS */;
INSERT INTO `vendor` VALUES (1,'eBosh');
/*!40000 ALTER TABLE `vendor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-13 10:33:24