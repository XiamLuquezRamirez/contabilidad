/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.30 : Database - contabilidad
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
 /*CREATE DATABASE!32312 IF NOT EXISTS*/ /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `contabilidad`;

/*Table structure for table `compromiso_empresa` */

DROP TABLE IF EXISTS `compromiso_empresa`;

CREATE TABLE `compromiso_empresa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `empresa` int DEFAULT NULL,
  `compromiso` int DEFAULT NULL,
  `fecha_presentacion` date DEFAULT NULL,
  `dias_anticipacion_pre` int DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `dias_anticipacion_ven` int DEFAULT NULL,
  `observacion` text COLLATE utf8mb4_general_ci,
  `estado_pres` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado_venc` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compromiso_empresa` */

LOCK TABLES `compromiso_empresa` WRITE;

insert  into `compromiso_empresa`(`id`,`empresa`,`compromiso`,`fecha_presentacion`,`dias_anticipacion_pre`,`fecha_vencimiento`,`dias_anticipacion_ven`,`observacion`,`estado_pres`,`estado_venc`,`remember_token`,`created_at`,`update_at`) values 
(5,1,1,'2025-01-01',5,'2025-12-31',5,'','pendiente','pendiente',NULL,'2024-12-06 09:13:34','2024-12-06 09:13:34'),
(6,1,4,'2024-12-10',5,'2024-12-15',5,'','pendiente','pendiente',NULL,'2024-12-06 09:14:19','2024-12-06 09:14:19'),
(7,1,5,'2024-12-18',5,'2024-12-24',4,'','pendiente','pendiente',NULL,'2024-12-06 09:14:38','2024-12-06 09:14:38'),
(8,1,6,'2024-12-19',4,'2024-12-27',3,'','pendiente','pendiente',NULL,'2024-12-06 09:15:02','2024-12-06 09:15:02'),
(9,1,7,'2024-12-30',3,'2024-12-31',3,'','pendiente','pendiente',NULL,'2024-12-06 09:15:26','2024-12-06 09:15:26'),
(10,4,6,'2024-12-11',6,'2024-12-14',6,'','pendiente','pendiente',NULL,'2024-12-06 09:26:45','2024-12-06 09:26:45'),
(11,4,4,'2024-12-04',4,'2024-12-07',3,'','presentado','pendiente',NULL,'2024-12-06 10:33:41','2024-12-06 10:33:41'),
(12,4,5,'2024-12-04',2,'2024-12-05',2,'','presentado','pendiente',NULL,'2024-12-06 10:34:10','2024-12-06 10:34:10'),
(13,4,1,'2024-12-06',2,'2024-12-08',2,'','pendiente','pendiente',NULL,'2024-12-06 11:22:02','2024-12-06 11:22:02'),
(14,4,4,'2024-12-06',7,'2024-12-09',7,'','pendiente','pendiente',NULL,'2024-12-06 11:28:00','2024-12-06 11:28:00'),
(15,1,5,'2024-12-02',1,'2024-12-06',1,'','presentado','pendiente',NULL,'2024-12-06 11:28:38','2024-12-06 11:28:38');

UNLOCK TABLES;

/*Table structure for table `compromisos` */

DROP TABLE IF EXISTS `compromisos`;

CREATE TABLE `compromisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `observacion` text COLLATE utf8mb4_general_ci,
  `estado` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo_compromiso` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `periocidad` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compromisos` */

LOCK TABLES `compromisos` WRITE;

insert  into `compromisos`(`id`,`descripcion`,`observacion`,`estado`,`tipo_compromiso`,`periocidad`,`remember_token`,`created_at`,`update_at`) values 
(1,'EXOGENA','seses','ACTIVO','informes','mensual',NULL,'2024-11-22 11:19:04','2024-11-22 11:19:04'),
(2,'RETENCIÓN EN LA FUENTE','edwedwed','ELIMINADO','pago_cuotas','mensual',NULL,'2024-11-22 15:40:11','2024-11-22 15:40:11'),
(3,'prueba de nuevo','eded','ELIMINADO',NULL,'mensual',NULL,'2024-11-22 15:41:16','2024-11-22 15:41:16'),
(4,'IVA','dede','ACTIVO','impuestos',NULL,NULL,'2024-11-22 15:41:43','2024-11-22 15:41:43'),
(5,'Informe A','','ACTIVO','informes','mensual',NULL,'2024-12-06 09:10:41','2024-12-06 09:10:41'),
(6,'Informe B','','ACTIVO','informes','trimestral',NULL,'2024-12-06 09:11:15','2024-12-06 09:11:15'),
(7,'Pago Banco','','ACTIVO','pago_cuotas','trimestral',NULL,'2024-12-06 09:11:56','2024-12-06 09:11:56');

UNLOCK TABLES;

/*Table structure for table `conceptos_asignados` */

DROP TABLE IF EXISTS `conceptos_asignados`;

CREATE TABLE `conceptos_asignados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_empresa` int NOT NULL,
  `id_concepto_pago` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `frecuencia_pago` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dias_anticipacion` int DEFAULT NULL,
  `observacion` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `conceptos_asignados` */

LOCK TABLES `conceptos_asignados` WRITE;

insert  into `conceptos_asignados`(`id`,`id_empresa`,`id_concepto_pago`,`fecha_inicio`,`frecuencia_pago`,`dias_anticipacion`,`observacion`) values 
(62,1,1,'2024-01-15','Mensual',3,''),
(64,1,2,'2024-01-24','Mensual',5,''),
(65,1,3,'2024-01-11','Trimestral',2,''),
(66,1,4,'2024-01-28','Mensual',2,''),
(67,1,5,'2024-01-28','Bimestral',2,''),
(68,1,6,'2024-01-10','Semestral',2,''),
(69,1,7,'2024-01-12','Mensual',1,''),
(70,4,1,'2024-01-03','Mensual',1,''),
(71,4,7,'2024-01-17','Bimestral',8,''),
(72,4,2,'2024-01-31','Mensual',6,''),
(73,4,8,'2024-06-18','Mensual',2,''),
(74,4,3,'2024-07-17','Bimestral',1,''),
(76,4,6,'2024-02-14','Anual',2,''),
(77,1,1,'2025-01-10','Mensual',3,'');

UNLOCK TABLES;

/*Table structure for table `conceptos_pago` */

DROP TABLE IF EXISTS `conceptos_pago`;

CREATE TABLE `conceptos_pago` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_concepto` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `observacion` text COLLATE utf8mb4_general_ci,
  `estado` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `conceptos_pago` */

LOCK TABLES `conceptos_pago` WRITE;

insert  into `conceptos_pago`(`id`,`nombre_concepto`,`observacion`,`estado`,`create_at`,`update_at`) values 
(1,'Pago de luz','','ACTIVO','2024-12-05 09:12:06','2024-12-05 09:12:06'),
(2,'Pago de agua','','ACTIVO','2024-12-05 09:12:22','2024-12-05 09:12:22'),
(3,'Pago de gas','','ACTIVO','2024-12-05 09:12:29','2024-12-05 09:12:29'),
(4,'Nomina','','ACTIVO','2024-12-06 08:56:43','2024-12-06 08:56:43'),
(5,'Nomina electronica','','ACTIVO','2024-12-07 08:26:45','2024-12-07 08:26:45'),
(6,'Impuesto IVA','','ACTIVO','2024-12-07 08:26:55','2024-12-07 08:26:55'),
(7,'Pago internet','','ACTIVO','2024-12-09 08:22:36','2024-12-09 08:22:36'),
(8,'pago medio año','','ACTIVO','2024-12-09 15:39:07','2024-12-09 15:39:07');

UNLOCK TABLES;

/*Table structure for table `empresas` */

DROP TABLE IF EXISTS `empresas`;

CREATE TABLE `empresas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_general_ci,
  `nit` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `representante` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo_ident_representante` char(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ident_representante` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `color` text COLLATE utf8mb4_general_ci,
  `logo` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `empresas` */

LOCK TABLES `empresas` WRITE;

insert  into `empresas`(`id`,`nombre`,`nit`,`representante`,`tipo_ident_representante`,`ident_representante`,`email`,`estado`,`remember_token`,`created_at`,`update_at`,`color`,`logo`) values 
(1,'CSI DESARROLLOS E INGENIERIA SAS','123456','PEPE RMIREZ','cc','28363563','alexanderx105@hotmail.com','ACTIVO',NULL,'2024-11-19 15:35:50','2024-11-19 15:35:50','csi.png','8d03ff_csi.png'),
(4,'LEER SAS','123454','Leider','cc','2353555454','leersas587@gmail.com','ACTIVO',NULL,'2024-12-06 09:25:40','2024-12-06 09:25:40','leer.png','fb45d7_leer.png');

UNLOCK TABLES;

/*Table structure for table `pagos_pendientes` */

DROP TABLE IF EXISTS `pagos_pendientes`;

CREATE TABLE `pagos_pendientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_concepto_asignado` int NOT NULL,
  `fecha_pago` date NOT NULL,
  `estado` enum('pendiente','pagado','N/A') COLLATE utf8mb4_general_ci DEFAULT 'pendiente',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=255 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pagos_pendientes` */

LOCK TABLES `pagos_pendientes` WRITE;

insert  into `pagos_pendientes`(`id`,`id_concepto_asignado`,`fecha_pago`,`estado`) values 
(126,62,'2024-01-15','pagado'),
(127,62,'2024-02-15','N/A'),
(128,62,'2024-03-15','pagado'),
(129,62,'2024-04-15','pagado'),
(130,62,'2024-05-15','pagado'),
(131,62,'2024-06-15','pendiente'),
(132,62,'2024-07-15','pendiente'),
(133,62,'2024-08-15','pendiente'),
(134,62,'2024-09-15','pendiente'),
(135,62,'2024-10-15','pendiente'),
(136,62,'2024-11-15','pendiente'),
(137,62,'2024-12-15','pendiente'),
(139,64,'2024-01-24','pagado'),
(140,64,'2024-02-24','pendiente'),
(141,64,'2024-03-24','pendiente'),
(142,64,'2024-04-24','pendiente'),
(143,64,'2024-05-24','pendiente'),
(144,64,'2024-06-24','pendiente'),
(145,64,'2024-07-24','pendiente'),
(146,64,'2024-08-24','pendiente'),
(147,64,'2024-09-24','pendiente'),
(148,64,'2024-10-24','pendiente'),
(149,64,'2024-11-24','pendiente'),
(150,64,'2024-12-24','pendiente'),
(163,66,'2024-01-28','N/A'),
(164,66,'2024-02-28','pendiente'),
(165,66,'2024-03-28','pendiente'),
(166,66,'2024-04-28','pendiente'),
(167,66,'2024-05-28','pendiente'),
(168,66,'2024-06-28','pendiente'),
(169,66,'2024-07-28','pendiente'),
(170,66,'2024-08-28','pendiente'),
(171,66,'2024-09-28','pendiente'),
(172,66,'2024-10-28','pendiente'),
(173,66,'2024-11-28','pendiente'),
(174,66,'2024-12-28','pendiente'),
(175,67,'2024-01-28','N/A'),
(176,67,'2024-03-28','pendiente'),
(177,67,'2024-05-28','pendiente'),
(178,67,'2024-07-28','pendiente'),
(179,67,'2024-09-28','pendiente'),
(180,67,'2024-11-28','pendiente'),
(181,68,'2024-01-10','pagado'),
(182,68,'2024-07-10','pendiente'),
(183,69,'2024-01-12','pagado'),
(184,69,'2024-02-12','pendiente'),
(185,69,'2024-03-12','pendiente'),
(186,69,'2024-04-12','pendiente'),
(187,69,'2024-05-12','pendiente'),
(188,69,'2024-06-12','pendiente'),
(189,69,'2024-07-12','pendiente'),
(190,69,'2024-08-12','pendiente'),
(191,69,'2024-09-12','pendiente'),
(192,69,'2024-10-12','pendiente'),
(193,69,'2024-11-12','pendiente'),
(194,69,'2024-12-12','pendiente'),
(195,70,'2024-01-03','pagado'),
(196,70,'2024-02-03','N/A'),
(197,70,'2024-03-03','pagado'),
(198,70,'2024-04-03','N/A'),
(199,70,'2024-05-03','pagado'),
(200,70,'2024-06-03','pagado'),
(201,70,'2024-07-03','pagado'),
(202,70,'2024-08-03','pagado'),
(203,70,'2024-09-03','pagado'),
(204,70,'2024-10-03','pagado'),
(205,70,'2024-11-03','pagado'),
(206,70,'2024-12-03','pendiente'),
(207,71,'2024-01-17','pagado'),
(208,71,'2024-03-17','pendiente'),
(209,71,'2024-05-17','pendiente'),
(210,71,'2024-07-17','pendiente'),
(211,71,'2024-09-17','pendiente'),
(212,71,'2024-11-17','pendiente'),
(213,72,'2024-01-31','pagado'),
(214,72,'2024-02-29','pendiente'),
(215,72,'2024-03-31','pendiente'),
(216,72,'2024-04-30','pendiente'),
(217,72,'2024-05-31','pendiente'),
(218,72,'2024-06-30','pendiente'),
(219,72,'2024-07-31','pendiente'),
(220,72,'2024-08-31','pendiente'),
(221,72,'2024-09-30','pendiente'),
(222,72,'2024-10-31','pendiente'),
(223,72,'2024-11-30','pendiente'),
(224,72,'2024-12-31','pendiente'),
(225,73,'2024-06-18','pendiente'),
(226,73,'2024-07-18','pendiente'),
(227,73,'2024-08-18','pendiente'),
(228,73,'2024-09-18','pendiente'),
(229,73,'2024-10-18','pendiente'),
(230,73,'2024-11-18','pendiente'),
(231,73,'2024-12-18','pendiente'),
(232,74,'2024-07-17','pendiente'),
(233,74,'2024-09-17','pendiente'),
(234,74,'2024-11-17','pendiente'),
(238,65,'2024-01-11','pagado'),
(239,65,'2024-04-11','pendiente'),
(240,65,'2024-07-11','pendiente'),
(241,65,'2024-10-11','pendiente'),
(242,76,'2024-02-14','pendiente'),
(243,77,'2025-01-10','pendiente'),
(244,77,'2025-02-10','pendiente'),
(245,77,'2025-03-10','pendiente'),
(246,77,'2025-04-10','pendiente'),
(247,77,'2025-05-10','pendiente'),
(248,77,'2025-06-10','pendiente'),
(249,77,'2025-07-10','pendiente'),
(250,77,'2025-08-10','pendiente'),
(251,77,'2025-09-10','pendiente'),
(252,77,'2025-10-10','pendiente'),
(253,77,'2025-11-10','pendiente'),
(254,77,'2025-12-10','pendiente');

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(200) COLLATE utf8mb3_spanish_ci NOT NULL,
  `login_usuario` varchar(45) COLLATE utf8mb3_spanish_ci NOT NULL,
  `pasword_usuario` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tipo_usuario` varchar(45) COLLATE utf8mb3_spanish_ci NOT NULL,
  `email_usuario` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `foto_usuario` varchar(30) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `estado_usuario` varchar(10) COLLATE utf8mb3_spanish_ci NOT NULL,
  `estado` varchar(10) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1684 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

insert  into `users`(`id`,`nombre_usuario`,`login_usuario`,`pasword_usuario`,`tipo_usuario`,`email_usuario`,`foto_usuario`,`estado_usuario`,`estado`,`remember_token`,`created_at`,`updated_at`) values 
(1,'ADMINITRADOR DEL SISTEMA','admin','$2y$10$KulERZ0c2oPEqRBzJEGbQOVNqURlv8tojGuCZBani4l2FqdshWGDy','Administrador','admin@hotmail.com','avatar-13.png','Habilitada','ACTIVO',NULL,NULL,NULL);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
