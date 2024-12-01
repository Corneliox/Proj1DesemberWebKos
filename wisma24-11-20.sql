/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 10.6.15-MariaDB-cll-lve : Database - mesy7597_purbadanarta
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mesy7597_purbadanarta` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;

USE `mesy7597_purbadanarta`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `admin` */

insert  into `admin`(`id`,`username`,`password`,`created_at`) values 
(1,'admin','$2y$10$Wl/MaNsPNGDNLBzyOMWmOe4GSZCIz78xbMb.y5ngJLBcFTYCHSh.u','2024-10-08 06:43:35'),
(7,'adminrapip','$2y$10$KkTB2UsLDhKhZlvcmXbvF.ZngRvPrfyJv/Z0bB3DxLBRI0faRFlPe','2024-10-08 07:45:17'),
(9,'Arya','$2y$10$/W4yknTRFzrzIqfZ6OzCKeAGNORSnwdaeU1MQmJUtpRhvUUR3LqQ2','2024-10-15 07:25:14'),
(10,'admin123','$2y$10$bcm8Tw1ucJlhND1jZEd/M.VqlDOplygHco72ReczrIJhg3TyW7jga','2024-10-15 08:20:08'),
(13,'admin1234','$2y$10$x3noXIrtLg/Hm1h7brWFE.udj4IG6klSdgBFIpfOq1X/5T0LpO2.y','2024-10-15 08:21:59'),
(14,'Cornel','$2y$10$ekVy6nRkr4.sYUVAkntbteeNxDlX050VUwaaZ4wdbk08KkNzF3aQm','2024-11-19 13:29:41');

/*Table structure for table `kamar` */

DROP TABLE IF EXISTS `kamar`;

CREATE TABLE `kamar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipe_kamar` enum('Ekonomi','Standart','Deluxe') NOT NULL,
  `harga_per_malam` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kamar` */

insert  into `kamar`(`id`,`tipe_kamar`,`harga_per_malam`) values 
(2,'A',165000.00),
(3,'B',220000.00),
(4,'C',110000.00),
(5,'D',165000.00),
(6,'E',220000.00);

/*Table structure for table `transaksi` */

DROP TABLE IF EXISTS `transaksi`;

CREATE TABLE `transaksi` (
  `referenceId` varchar(25) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `userEmail` varchar(40) NOT NULL,
  `userPhone` varchar(20) NOT NULL,
  `remarks` text NOT NULL,
  `total_harga` bigint(20) unsigned NOT NULL,
  `items` text NOT NULL,
  `invoiceId` varchar(25) NOT NULL,
  `status` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`invoiceId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `transaksi` */

insert  into `transaksi`(`referenceId`,`userName`,`userEmail`,`userPhone`,`remarks`,`total_harga`,`items`,`invoiceId`,`status`,`timestamp`) values 
('YPD1015222937','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','7kHXPy2A9B3GURlhvWMA','NEW','2024-10-15 22:29:38'),
('YPD1028143649','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-21\nCheck-out: 2024-10-22',110000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":110000}]','7wh4m4N2IHm2jYTAUniJ','NEW','2024-10-28 14:36:50'),
('YPD1011134240','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','8KrRP1OMGj09m8ZmM2qC','NEW','2024-10-11 13:42:41'),
('YPD1011115624','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','8ntQr84rcCPPCapMoj7K','NEW','2024-10-11 11:56:24'),
('YPD1115105844','Arya','dimaschaqti2u@gmail.com','+6282242227643','Check-in: 2024-11-15\nCheck-out: 2024-11-16',220000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":220000}]','a7qaEVyrxooYzCVNl5Ce','NEW','2024-11-15 10:58:45'),
('YPD1011102835','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','ATHl5YhkU6bzvKUSuDCy','NEW','2024-10-11 10:28:35'),
('YPD1013114630','RAFIF ','dimaschaqti2u@gmail.com','082143202131','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','aXE0BMJLP33t0DvHQfne','NEW','2024-10-13 11:46:31'),
('YPD1015091009','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','BaFj2aQJJS5ZTLowzrtt','NEW','2024-10-15 09:10:09'),
('YPD1011102827','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','BB6fWwiuzzuXQYLQhhSV','NEW','2024-10-11 10:28:28'),
('YPD1014230232','RAFIF ','dimaschaqti2u@gmail.com','08224222','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','BFtzUPgL3zxdur3er2xJ','NEW','2024-10-14 23:02:33'),
('YPD1015230350','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','bJn9Ftog9lj8XkUMWNYf','NEW','2024-10-15 23:03:51'),
('YPD1011133507','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','bQkSto3n3ldCG6AMsclV','NEW','2024-10-11 13:35:08'),
('YPD1011131518','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','bSXFTQUwad57T8bo8EPj','NEW','2024-10-11 13:15:18'),
('YPD1011124837','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','C72e13jzLmHhl56G2K0s','NEW','2024-10-11 12:48:37'),
('YPD1011105516','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','cIsoF5cmvsrL8NSat0e8','NEW','2024-10-11 10:55:16'),
('YPD1011132126','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','D0kGyWcec0eubhvMu4rO','NEW','2024-10-11 13:21:27'),
('YPD1015062754','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','dhHaHXoCnyMeUWjN1Lxz','NEW','2024-10-15 06:27:55'),
('YPD1011125019','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Dn2aqPfXnx3VUv9NsK3S','NEW','2024-10-11 12:50:20'),
('YPD1011163520','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Dngkx5YahH4kZ5ICW8NK','NEW','2024-10-11 16:35:20'),
('YPD1013114215','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','DVrcOShXIRxFEAx88JPt','NEW','2024-10-13 11:42:15'),
('YPD1011131218','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','E1e4f3jEG2GsD0Kdu08E','NEW','2024-10-11 13:12:18'),
('YPD1015141200','Rafif Pradiva','rafif.arsya.pradiva@gmail.com','085155356177','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','EHxdMK60LMtP3hFjhHZ3','NEW','2024-10-15 14:12:01'),
('YPD1014105043','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','eiDGnjw1I3LdMijzyvIX','NEW','2024-10-14 10:50:44'),
('YPD1015102333','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','eNn2eYpn6GQtwE79wf4l','NEW','2024-10-15 10:23:33'),
('YPD1019172557','rafif','rafif.arsya.pradiva@gmail.com','085155356177','Check-in: 2024-10-19\nCheck-out: 2024-10-20',120000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":120000}]','eWFQcTC5NXzs4Umeg43Z','NEW','2024-10-19 17:25:58'),
('YPD1014110210','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','F0rb2gZ9BS8x8JBv3Vup','NEW','2024-10-14 11:02:11'),
('YPD1015103905','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','FJAo4QQNuutO0v41RS4r','NEW','2024-10-15 10:39:06'),
('YPD1011131825','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','FMnTy0LIrBXyoZWrS9dP','NEW','2024-10-11 13:18:25'),
('YPD1014110214','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','funUBtVEvmdlFo6K3nWm','NEW','2024-10-14 11:02:14'),
('YPD1011105356','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','fWdxNTJhDbFzhXDEgU1I','NEW','2024-10-11 10:53:56'),
('YPD1011125714','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','FWiW8UJthe6a5ZMndvQK','NEW','2024-10-11 12:57:14'),
('YPD1011132951','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','fYooH29wqLNKDoL8UF87','NEW','2024-10-11 13:29:52'),
('YPD1015102947','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',20000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":20000}]','gmB7dsUmeudUuCnUES4j','NEW','2024-10-15 10:29:48'),
('YPD1028145544','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-28\nCheck-out: 2024-10-29',110000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":110000}]','gTy4tDL1ffG2Aa1D8Pdq','NEW','2024-10-28 14:55:44'),
('YPD1015014338','RAFIF ','dimaschaqti2u@gmail.com','08224222','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','h2LC75SYsu7AvmtoWrqj','NEW','2024-10-15 01:43:39'),
('YPD1011135357','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','hH8hNZMb2JJh1DmIGnut','NEW','2024-10-11 13:53:58'),
('YPD1011111128','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','IHl5kfHs95Q1D6nF2S3n','NEW','2024-10-11 11:11:29'),
('YPD1011132646','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','IpYWmYSJk6PnfUC6u2zi','NEW','2024-10-11 13:26:46'),
('YPD1011112419','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','JfAQAvtUJtFjIyfU4QSd','NEW','2024-10-11 11:24:20'),
('YPD1011142155','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','jJSFpGoLgtIMEEcThqu8','NEW','2024-10-11 14:21:56'),
('YPD1013133503','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Kjzjyvsqqi4CnBOxHp7x','NEW','2024-10-13 13:35:04'),
('YPD1014221304','RAFIF ','dimaschaqti2u@gmail.com','085228437014','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','kUe5523bU6CG63kX7yRw','NEW','2024-10-14 22:13:05'),
('YPD1011105932','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','LVWYygyCNJTboSC3BqfH','NEW','2024-10-11 10:59:33'),
('YPD1014122154','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','lxMFvm458vD3mNzpuZo7','NEW','2024-10-14 12:21:55'),
('YPD1015100552','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','mBM6YPp4Jq8hGWZcTmZC','NEW','2024-10-15 10:05:52'),
('YPD1015090935','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','mH3ekazvbgcbkQRd5A2r','NEW','2024-10-15 09:09:36'),
('YPD1011232255','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','mONlEJwMSutRJdoutilr','NEW','2024-10-11 23:23:40'),
('YPD1015224803','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','mUICeWz5VRYxWgi0aT33','NEW','2024-10-15 22:48:04'),
('YPD1011163324','RAFIF ','dimaschaqti2u@gmail.com','087809963420','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','NcQZLej2P6H2P8jKH8Bb','NEW','2024-10-11 16:33:24'),
('YPD1015100207','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Nm6zeAqy3W5lA5Rvc9kZ','NEW','2024-10-15 10:02:08'),
('YPD1011133629','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','nrHo3bxNdsREFChNljrP','NEW','2024-10-11 13:36:29'),
('YPD1011105147','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','nZYnN8vxwzf35lmUUfOo','NEW','2024-10-11 10:51:48'),
('YPD1011102357','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','OerbWxOgwpKmXxSHwN3g','NEW','2024-10-11 10:23:58'),
('YPD1028142215','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-28\nCheck-out: 2024-10-29',110000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":110000}]','oOtzdPpUx3ck4B82ALvu','NEW','2024-10-28 14:22:16'),
('YPD1015174734','aryaaa','22n40009@student.unika.ac.id','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','orag9hDVp98gcmdu4TYp','NEW','2024-10-15 17:47:35'),
('YPD1015230339','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Os7Mts4QO9rBzdz1vDL5','NEW','2024-10-15 23:03:40'),
('YPD1014221938','RAFIF ','dimaschaqti2u@gmail.com','085228437014','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','OSHxriwlNl6sNAzROeTo','NEW','2024-10-14 22:19:39'),
('YPD1014222448','RAFIF ','dimaschaqti2u@gmail.com','085228437014','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','oUnCEia2z7z47kFD9rfa','NEW','2024-10-14 22:24:49'),
('YPD1011131153','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','p04nYT0DhVisozIpWKEh','NEW','2024-10-11 13:11:54'),
('YPD1011140811','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','PCowl1cFbtsqPFeXEF2q','NEW','2024-10-11 14:08:12'),
('YPD1013204825','RAFIF ','dimaschaqti2u@gmail.com','8871292051','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','PEshCLDgXCkkkIHDOPPq','NEW','2024-10-13 20:51:27'),
('YPD1011133337','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','pphc2EzFkNIJ1mc1hHKu','NEW','2024-10-11 13:33:38'),
('YPD1015085753','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','q0NGk0vEYYCjXl8JMEkv','NEW','2024-10-15 08:59:42'),
('YPD1014110456','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','qFwMVN2eCM0Zh3z6FqqB','NEW','2024-10-14 11:04:57'),
('YPD1015104910','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','QR3MIhSdiPxsYi7vPTjQ','NEW','2024-10-15 10:49:10'),
('YPD1018142326','Arya','dimaschaqti2u@gmail.com','+6282242227643','Check-in: 2024-10-18\nCheck-out: 2024-10-19',360000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":360000}]','R271w7NvqTrN0PABQTJI','NEW','2024-10-18 14:23:27'),
('YPD1015180617','aryaaa','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','R9gHulgjArlBqB7WqZAZ','NEW','2024-10-15 18:06:18'),
('YPD1011131056','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','r9jVeDqLdbSa66nwx2Rq','NEW','2024-10-11 13:10:57'),
('YPD1014222233','RAFIF ','dimaschaqti2u@gmail.com','085228437014','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','rbhu5809dSLw1AHnOPdW','NEW','2024-10-14 22:22:33'),
('YPD1011115618','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','rHgLMmoVhuqreKH8H7XZ','NEW','2024-10-11 11:56:19'),
('YPD1016065922','V.arya','dimaschaqti2u@gmail.com','+6282242227643','Check-in: 2024-10-16\nCheck-out: 2024-10-17',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','RlveXZYqh8IAQDUc9kif','NEW','2024-10-16 06:59:22'),
('YPD1014221812','RAFIF ','dimaschaqti2u@gmail.com','085228437014','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','RlZ2ul8N3DIkQKKfsKlO','NEW','2024-10-14 22:18:12'),
('YPD1011102846','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','ROGwoDLXRVyMvfuKoVzh','NEW','2024-10-11 10:28:47'),
('YPD1015221712','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','RUBsm2SsxJMROmlles9p','NEW','2024-10-15 22:17:13'),
('YPD1015225954','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','rWGsKDU9UQFsCIG3zrUB','NEW','2024-10-15 22:59:54'),
('YPD1014122427','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','S1TJCvlLy7gpGV0Kv1W3','NEW','2024-10-14 12:24:27'),
('YPD1016112807','Wisaji','userxxxxname@gmail.com','08979020232','Check-in: 2024-10-16\nCheck-out: 2024-10-17',120000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":120000}]','SfLisBoJN5gh05uHxkx3','NEW','2024-10-16 11:28:08'),
('YPD1011141612','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','SiHBJ6mZ4dfKnkrfCfsb','NEW','2024-10-11 14:16:12'),
('YPD1013204605','RAFIF ','dimaschaqti2u@gmail.com','+6282242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Sl6kpiDgm7HmzPKdUOIr','NEW','2024-10-13 20:46:05'),
('YPD1014222030','RAFIF ','dimaschaqti2u@gmail.com','085228437014','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','sviAbebZBaCcpqKutGSL','NEW','2024-10-14 22:20:31'),
('YPD1028142032','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-28\nCheck-out: 2024-10-27',220000,'[{\"itemName\":\"Kamar Deluxe\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":220000}]','tgYfz00oaB0tg3rHTzCn','NEW','2024-10-28 14:20:32'),
('YPD1011105831','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','tijAPcRhPcpnZhVez9Ew','NEW','2024-10-11 10:58:31'),
('YPD1016112653','Wisaji','userxxxxname@gmail.com','08979020232','Check-in: 2024-10-16\nCheck-out: 2024-10-17',110000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":110000}]','tZjTXNe4Y7uUdGxCL85t','NEW','2024-10-16 11:26:53'),
('YPD1013120549','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','u9O8zyQu9twrQTqzsBhy','NEW','2024-10-13 12:05:49'),
('YPD1015231108','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',110000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":110000}]','uahkhszQM86YtE5zF6tI','NEW','2024-10-15 23:11:09'),
('YPD1016184538','Arya','dimaschaqti2u@gmail.com','+6282242227643','Check-in: 2024-10-16\nCheck-out: 2024-10-17',120000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":120000}]','UBOrQLLwFzIPh1jaIK5y','NEW','2024-10-16 18:45:38'),
('YPD1014110205','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','uh5LSSMSeJXs1ovpgIrq','NEW','2024-10-14 11:02:05'),
('YPD1014122605','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','ukFB76bPBomhBNFPEXN4','NEW','2024-10-14 12:26:06'),
('YPD1015231514','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','uURBTwubZ2MQPSBcx7I4','NEW','2024-10-15 23:15:15'),
('YPD1015230759','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','VACVZ5wefxUSp4nPSCe9','NEW','2024-10-15 23:08:00'),
('YPD1021100702','Rafif Pradiva','rafif.arsya.pradiva@gmail.com','085155356177','Check-in: 2024-10-21\nCheck-out: 2024-10-22',120000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":120000}]','vAYI2hslLon9w4ti2g9J','NEW','2024-10-21 10:07:02'),
('YPD1015094922','RAFIF ','ezra@gmail.com','08988989898','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','VDo9atdSRGJEKpROTm6f','NEW','2024-10-15 09:49:23'),
('YPD1012194700','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','VSVpCz0wmOR9Nmm9zOXr','NEW','2024-10-12 19:47:01'),
('YPD1011105240','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','WbGofD7nQjwSjhZ7E4TO','NEW','2024-10-11 10:52:40'),
('YPD1015224819','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','WG46mSI61vpN497MrCIY','NEW','2024-10-15 22:48:21'),
('YPD1029133337','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-29\nCheck-out: 2024-10-30',110000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":110000}]','WYTMOuldGWHhJPdVPQ6U','NEW','2024-10-29 13:33:38'),
('YPD1014115331','RAFIF ','rafif.arsya.pradiva@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','wyx4UWMMfD8fdVmV5UZO','NEW','2024-10-14 11:53:31'),
('YPD1011115707','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','xiGCS0396wL9b6Hi36DB','NEW','2024-10-11 11:57:07'),
('YPD1015110042','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','xuzrUNrwEyUz5dg94vsa','NEW','2024-10-15 11:00:43'),
('YPD1013194856','RAFIF ','dimaschaqti2uu@gmail.com','+6282242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','xY7gC6XDb3Q6XUsHWeWi','NEW','2024-10-13 19:48:56'),
('YPD1011184518','RAFIF ','dimaschaqti2u@gmail.com','082242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','YfHNdGS3zTgxSlcrdKQ5','NEW','2024-10-11 18:46:03'),
('YPD1011130417','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','yJN9jQkmqKKss1NgJkYA','NEW','2024-10-11 13:04:17'),
('YPD1016114244','Wisaji','userxxxxname@gmail.com','08979020232','Check-in: 2024-10-16\nCheck-out: 2024-10-18',240000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":240000}]','z1DXwp07dwVhgQ1Hf70i','NEW','2024-10-16 11:42:44'),
('YPD1015105646','RAFIF ','dimaschaqti2u@gmail.com','085155356177','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Z3ZBMY2PNEMRdbKLPqUo','NEW','2024-10-15 10:56:47'),
('YPD1015233613','arya','dimaschaqti2u@gmail.com','082242227643','Check-in: 2024-10-15\nCheck-out: 2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','Z5a4Usm6JTsX21F6yyyc','NEW','2024-10-15 23:36:13'),
('YPD1014132016','RAFIF ','dimaschaqti2u@gmail.com','+6282242227643','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','z5O1T4zO5F3zgHPYsjZh','NEW','2024-10-14 13:21:21'),
('YPD1015014243','RAFIF ','dimaschaqti2u@gmail.com','08154864846','2024-10-15 /2024-10-16',10000,'[{\"itemName\":\"Kamar Ekonomi\",\"itemType\":\"ITEM\",\"itemCount\":\"1\",\"itemTotalPrice\":10000}]','z6yMjvnEZQI3mA2PXChy','NEW','2024-10-15 01:42:43');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`nama`,`email`,`no_hp`,`password`,`created_at`) values 
(26,'Abi Satya Pradana','abites@gmail.com','112233445566','$2y$10$kC09H/CteLnU5c8gyNcszulbJocQVG4UsN4JPBigKmMe7uSbGTx6m','2024-10-07 16:07:04'),
(27,'arya','yanto@gmail.com','082242227643','$2y$10$7fLL9Cmix6w0xW7Y9b8zEOyo4UVrpdNld8oPyFA0J.VzPE6rFl5aW','2024-10-07 16:20:41'),
(28,'arya','dimaschaqti2uuu@gmail.com','082242227643','$2y$10$7eJ0e5xkbxOKSmTjP0.ofelvCKMj5yAUzYU19rRMVhCmrhTkQ4phe','2024-10-07 16:23:01'),
(29,'Wisaji','userxxxxname@gmail.com','08979020232','$2y$10$UFZlKX0RZiqXWjnBuTwRAuNjE93ndNoe1Lpis2MoaS5UkdB4gAl/O','2024-10-08 02:14:44'),
(30,'mikhayla','mikhayla@gmail.com','08988989898','$2y$10$lAhHvmzSa9O12nChdEAU4u24mIRphNTtNZv6oOfm3W1QchhbegRg6','2024-10-08 07:35:49'),
(32,'RAFIF PRADIVA','rafif.arsya.pradiva@gmail.com','085155356177','$2y$10$n6g0ktXLtVL.XZei0xn3rOyR0aU73M3MYEwSY1.pHmwt227KpPcSe','2024-10-08 08:03:28'),
(33,'RAFIF PRADIVA','aryakontol@gmail.com','085155356177','$2y$10$aPaUqClVFjNQXHfMSRZzmezEcPYXmMkLrY4uPnjrdWSyKKhqPGM.2','2024-10-08 08:27:59'),
(34,'maxi','studenthidjo19@gmail.com','087809963420','$2y$10$NXo5ZxScxogT1KsLWCRGoewRYcFt/tAgoAF5IIIKT3wLw93SNrBoS','2024-10-13 12:23:45'),
(37,'arya','dimaschaqti2u@gmail.com','082242227643','$2y$10$M2RtnVrKkP7PkKZl9UqYv.sJumVjTRiYHBBIkH7cHzMkHBZ4RfLYy','2024-10-15 13:37:34'),
(38,'Kevin','bkevingiovano@ymail.com','085228437014','$2y$10$T26akrNeRch80u1aeTnwYO5QAhAxQvq5wUfO0OZliql.s2YUtgKki','2024-10-16 13:03:43'),
(39,'Harimau meledak','harimaugila@gmail.com','083195435484','$2y$10$z4CEW98eiwWdkUFGqO2mJuMcfFNb32ZHOmwmdxKy2U4XaTB.1BDGe','2024-10-18 17:09:29'),
(40,'Tengjason','tengjason@gmail.com','02138534984','$2y$10$GTkKQuRwdbo8.Jr8UYNwYOxbCV1M5hi/T3B3HUrilzi.97rIvDcz6','2024-10-18 17:10:43'),
(41,'Rafif Pradiva','rafif.arsya.pradiva145@gmail.com','085155356177','$2y$10$27ftdkdfxWZJifd0c4cgl.DK5VqqeqYhYDgES5QAeIJNZj3milTGa','2024-10-21 10:01:45'),
(42,'test','test@gmail','08190000000','$2y$10$gqVuAbY3NEjp3pXQRf8gKe8MDFiZYInIGTRSNM981fNmpMO41LX/y','2024-10-21 23:06:41'),
(43,'rPip','ajaiskylar@gmail.com','+62 851-5535-6177','$2y$10$tHMupDl2yooIc0FayxzmsO0aGDj1elDvVAGoOtpYDCfv86CEGud4u','2024-10-24 11:02:59'),
(44,'Arya','dimaschaqti2uu@gmail.com','+6282242227643','$2y$10$SeTaNsnxgR3Asqybe7wqUulLalSchmauFze7d4La3QW5cRjL4C2Xa','2024-11-19 13:33:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
