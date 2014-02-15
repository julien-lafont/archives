/*
SQLyog Job Agent Version 8.82 Copyright(c) Webyog Softworks Pvt. Ltd. All Rights Reserved.


MySQL - 5.5.13-log : Database - play
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`play` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `play`;

/*Table structure for table `appellation` */

DROP TABLE IF EXISTS `appellation`;

CREATE TABLE `appellation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `appellation` */

insert  into `appellation`(`id`,`nom`) values (1,'Côtes de Provence');
insert  into `appellation`(`id`,`nom`) values (2,'Côtes de Provence Sainte Victoire');

/*Table structure for table `cepage` */

DROP TABLE IF EXISTS `cepage`;

CREATE TABLE `cepage` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `cepage` */

insert  into `cepage`(`id`,`nom`) values (3,'Cabernet');
insert  into `cepage`(`id`,`nom`) values (1,'Grenache');
insert  into `cepage`(`id`,`nom`) values (2,'Syrah');

/*Table structure for table `couleurvin` */

DROP TABLE IF EXISTS `couleurvin`;

CREATE TABLE `couleurvin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `couleurvin` */

insert  into `couleurvin`(`id`,`code`,`nom`) values (1,'#4C1B1B','Rouge');
insert  into `couleurvin`(`id`,`code`,`nom`) values (2,'#EFECCA','Blanc');

/*Table structure for table `domaine` */

DROP TABLE IF EXISTS `domaine`;

CREATE TABLE `domaine` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `adresse_domaine` longtext,
  `adresse_pt_vene` longtext,
  `bons_plans` longtext,
  `email` varchar(255) DEFAULT NULL,
  `descriptionProducteur` longtext,
  `nom` varchar(255) DEFAULT NULL,
  `nom_producteur` varchar(255) DEFAULT NULL,
  `photo_domaine` varchar(255) DEFAULT NULL,
  `photo_producteur` varchar(255) DEFAULT NULL,
  `vignoble_id` bigint(20) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `insolite` longtext,
  `photo_insolite` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`),
  KEY `FK6D86C421A0BCD31E` (`vignoble_id`),
  CONSTRAINT `FK6D86C421A0BCD31E` FOREIGN KEY (`vignoble_id`) REFERENCES `vignoble` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `domaine` */

insert  into `domaine`(`id`,`adresse_domaine`,`adresse_pt_vene`,`bons_plans`,`email`,`descriptionProducteur`,`nom`,`nom_producteur`,`photo_domaine`,`photo_producteur`,`vignoble_id`,`telephone`,`insolite`,`photo_insolite`) values (1,'29 rue Jean Froissart\r\n34090 Montpellier','Cave Coopérative \r\n1, av d\'Aix 13114 \r\nPuyloubier','Découverte accompagnée du \"Sentier vigneron\" en Septembre',' vignerons@xxxxxx.fr ','<text>Blablabla Description du producteur en FR</text>\r\n<text lang=\"en\">Blablabla Description du producteur en EN</text>','Les Vignerons du Mont Sainte Victoire','Georges Guinieri','dc15ae1e-ee01-4c05-8ac2-420396cf2499|image/png','a13fdea0-c66a-4b78-adc2-23a33760e449|image/jpeg',1,'0490516480','<text>Blablabla Description insolite en FR</text>\r\n<text lang=\"en\">Blablabla Description insolite en EN</text>','c8437791-3447-4869-9879-d3b28ec2f55b|image/jpeg');
insert  into `domaine`(`id`,`adresse_domaine`,`adresse_pt_vene`,`bons_plans`,`email`,`descriptionProducteur`,`nom`,`nom_producteur`,`photo_domaine`,`photo_producteur`,`vignoble_id`,`telephone`,`insolite`,`photo_insolite`) values (2,'','EARL Mas de Cadenet Négrel :  Chemin départemental 57, F13530 Trets','Soirées \"Musique au Caveau\"  à Noël','guy.negrel@masdecadenet.fr','','Mas de Cadenet','Guy Negrel','568e2b67-9147-4506-8ed5-78d587ef6edc|image/png','4c512a0b-dc63-401c-90f5-e027256fc2f3|image/png',2,'0490516480',NULL,NULL);
insert  into `domaine`(`id`,`adresse_domaine`,`adresse_pt_vene`,`bons_plans`,`email`,`descriptionProducteur`,`nom`,`nom_producteur`,`photo_domaine`,`photo_producteur`,`vignoble_id`,`telephone`,`insolite`,`photo_insolite`) values (3,'c','d','<text>Coucou ma poule</text>\r\n<text lang=\"en\">Hello</text>\r\n<text lang=\"fr\">Hi</text>','g','f','a','b','80af8db9-05f1-4edf-b3ae-01a1ed9522d3|image/jpeg','8af0704e-5f98-43f6-a081-7c9410648e9a|image/jpeg',1,'s',NULL,NULL);

/*Table structure for table `region` */

DROP TABLE IF EXISTS `region`;

CREATE TABLE `region` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `region` */

insert  into `region`(`id`,`nom`) values (1,'Provence');

/*Table structure for table `schema_version` */

DROP TABLE IF EXISTS `schema_version`;

CREATE TABLE `schema_version` (
  `version` varchar(32) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `duration` int(11) NOT NULL,
  UNIQUE KEY `version` (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `schema_version` */

/*Table structure for table `vignoble` */

DROP TABLE IF EXISTS `vignoble`;

CREATE TABLE `vignoble` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `region_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`),
  KEY `FK4A3E3066BCA0195E` (`region_id`),
  CONSTRAINT `FK4A3E3066BCA0195E` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `vignoble` */

insert  into `vignoble`(`id`,`nom`,`region_id`) values (1,'Puyloubier',1);
insert  into `vignoble`(`id`,`nom`,`region_id`) values (2,'Trets',1);
insert  into `vignoble`(`id`,`nom`,`region_id`) values (3,'Saint-Cannat',1);
insert  into `vignoble`(`id`,`nom`,`region_id`) values (4,'Jouques',1);

/*Table structure for table `vin` */

DROP TABLE IF EXISTS `vin`;

CREATE TABLE `vin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `millesime` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `photo_etiquette` varchar(255) DEFAULT NULL,
  `prix` float DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `appelation_id` bigint(20) DEFAULT NULL,
  `couleur_id` bigint(20) DEFAULT NULL,
  `domaine_id` bigint(20) DEFAULT NULL,
  `arome` text,
  `mets` text,
  `visuel` text,
  `audio` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`),
  KEY `FK1C81B30AFFA76` (`domaine_id`),
  KEY `FK1C81B29005D5B` (`couleur_id`),
  KEY `FK1C81B8102661A` (`appelation_id`),
  CONSTRAINT `FK1C81B29005D5B` FOREIGN KEY (`couleur_id`) REFERENCES `couleurvin` (`id`),
  CONSTRAINT `FK1C81B30AFFA76` FOREIGN KEY (`domaine_id`) REFERENCES `domaine` (`id`),
  CONSTRAINT `FK1C81B8102661A` FOREIGN KEY (`appelation_id`) REFERENCES `appellation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `vin` */

insert  into `vin`(`id`,`millesime`,`nom`,`photo_etiquette`,`prix`,`video`,`appelation_id`,`couleur_id`,`domaine_id`,`arome`,`mets`,`visuel`,`audio`) values (1,'','Cuvée des Terres Rouges ','9604bddf-b1fc-4dbb-b139-5d94a75e5b54|image/jpeg',35,'http://www.youtube.com/watch?v=9IBKVWqjKkc',2,1,1,'<text>Un vin  <strong>puissant</strong>, charpenté qui exhale des aromes de cassis avec une pointe de réglisse.</text>\r\n<text lang=\"en\">... English description here ...</text>\r\n','<text>Ce vin  s\'associe très bien avec des viandes en sauces, des gibiers ou des fromages.</text>\r\n<text lang=\"en\">... English description here ...</text>','<text>Un rouge de caractère à la robe rubis et pourpre.</text>\r\n<text lang=\"en\">... English description here ...</text>','<text>http://dev.studio-dev.fr/synthese_vocale.mp3</text>\r\n<text lang=\"en\">http://dev.studio-dev.fr/synthese_vocale.mp3</text>');
insert  into `vin`(`id`,`millesime`,`nom`,`photo_etiquette`,`prix`,`video`,`appelation_id`,`couleur_id`,`domaine_id`,`arome`,`mets`,`visuel`,`audio`) values (2,'','Mas de Cadenet Rouge','a1131926-d3c2-4612-8d99-a7c3e0fbe2fd|image/jpeg',NULL,'',2,1,2,'Un vin structuré et savoureux au nez de fruit noirs macérés, épicés et venaisons et une bouche ronde et délicate.','Ce vin  s\'associe très bien avec un dos d\'agneau en mitonnée Provençale ou une cannette rôtie en senteur de réglisse.','Sa robe est brillante pourpre cardinale.',NULL);

/*Table structure for table `vin_cepage` */

DROP TABLE IF EXISTS `vin_cepage`;

CREATE TABLE `vin_cepage` (
  `vins_id` bigint(20) NOT NULL,
  `cepages_id` bigint(20) NOT NULL,
  KEY `FK5CD05E959A025979` (`vins_id`),
  KEY `FK5CD05E95C94BAFED` (`cepages_id`),
  CONSTRAINT `FK5CD05E959A025979` FOREIGN KEY (`vins_id`) REFERENCES `vin` (`id`),
  CONSTRAINT `FK5CD05E95C94BAFED` FOREIGN KEY (`cepages_id`) REFERENCES `cepage` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `vin_cepage` */

insert  into `vin_cepage`(`vins_id`,`cepages_id`) values (2,1);
insert  into `vin_cepage`(`vins_id`,`cepages_id`) values (2,2);
insert  into `vin_cepage`(`vins_id`,`cepages_id`) values (1,3);
insert  into `vin_cepage`(`vins_id`,`cepages_id`) values (1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
