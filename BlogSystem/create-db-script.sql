CREATE DATABASE IF NOT EXISTS `blog_system` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `blog_system`;

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


DROP TABLE IF EXISTS `blog_system`.`users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_system`.`users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NULL,
  `last_name` varchar(45) NULL,
  `username` varchar(45) NOT NULL,
  `pass_hash` varchar(45)  NULL,
  `email` varchar(45)  NULL,
  `is_admin` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `blog_system`.`tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_system`.`tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `blog_system`.`posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_system`.`posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `text` varchar(200) NOT NULL,
  `author_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `visits` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_authors_idx` (`author_id`),
  CONSTRAINT `fk_post_authors` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `blog_system`.`comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_system`.`comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(200) NOT NULL,
  `post_id` int(11) NOT NULL,
  `author` varchar(100) NOT NULL,
  `date` datetime DEFAULT NULL,
  `email` varchar(100)  DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_posts_idx` (`post_id`),
  CONSTRAINT `fk_comments_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

DROP TABLE IF EXISTS `blog_system`.`posts_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_system`.`posts_tags` (
  `post_id` int(11) NOT NULL ,
  `tag_id`int(11) NOT NULL,
   KEY `fk_posts_tags_idx` (`post_id`),
   CONSTRAINT `fk_posts_tags` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
   KEY `fk_tags_posts_idx` (`tag_id`),
   CONSTRAINT `fk_tags_posts` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users`*/;
INSERT INTO `users` VALUES (1,'fname', 'lname','user', NULL, NULL, 0);
INSERT INTO `users` VALUES (2, null, null,'admin', NULL, NULL, 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Demo title','demo text  PHP for Dummies', 1,NULL,NULL),(2,'Demo title 2','demo2 text  PHP for Dummies', 1,NULL,NULL),
 (3,'3Demo title','demo text  PHP for Dummies', 1,NULL,NULL),(4,'4Demo title','demo text  PHP for Dummies', 1,NULL,NULL),
 (5,'Demo title','demo text  PHP for Dummies', 1,NULL,NULL),(6,'Demo title','demo text  PHP for Dummies', 1,NULL,NULL),
 (7,'Demo title','demo text  PHP for Dummies', 1,NULL,NULL),(8,'Demo title','demo text  PHP for Dummies', 1,NULL,NULL),
(9,'Demo title','demo text  PHP for Dummies', 1,NULL,NULL),(10,'Demo title','demo text  PHP for Dummies', 1,NULL,NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;













