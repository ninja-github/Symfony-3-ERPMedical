-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 01-02-2018 a las 21:42:06
-- Versión del servidor: 5.7.19
-- Versión de PHP: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `erp_medical`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address_ccaa`
--

DROP TABLE IF EXISTS `address_ccaa`;
CREATE TABLE IF NOT EXISTS `address_ccaa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ccaa` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address_city`
--

DROP TABLE IF EXISTS `address_city`;
CREATE TABLE IF NOT EXISTS `address_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cp` int(11) DEFAULT NULL,
  `city` varchar(500) DEFAULT NULL,
  `province` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_province` (`province`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56509 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address_province`
--

DROP TABLE IF EXISTS `address_province`;
CREATE TABLE IF NOT EXISTS `address_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ccaa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ccaa` (`ccaa`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `business`
--

DROP TABLE IF EXISTS `business`;
CREATE TABLE IF NOT EXISTS `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic` int(11) NOT NULL,
  `business_name` varchar(60) CHARACTER SET utf8mb4 NOT NULL,
  `type_business` int(11) NOT NULL,
  `CIF` varchar(11) CHARACTER SET utf8mb4 DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `business_name` (`business_name`),
  KEY `city` (`city`),
  KEY `type_business` (`type_business`),
  KEY `clinic` (`clinic`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clinic`
--

DROP TABLE IF EXISTS `clinic`;
CREATE TABLE IF NOT EXISTS `clinic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` int(11) DEFAULT NULL,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CIF` varchar(11) NOT NULL,
  `name_url` varchar(150) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(9) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `note_report` text NOT NULL,
  `note_invoice` text NOT NULL,
  `user_registerer` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_modifier` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clinic_name` (`name`),
  UNIQUE KEY `name_url` (`name_url`),
  UNIQUE KEY `email` (`email`),
  KEY `cp` (`city`) USING BTREE,
  KEY `user_registerer` (`user_registerer`) USING BTREE,
  KEY `user_modifier` (`user_modifier`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clinic_user`
--

DROP TABLE IF EXISTS `clinic_user`;
CREATE TABLE IF NOT EXISTS `clinic_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `clinic` int(11) DEFAULT NULL,
  `user_registerer` int(11) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `user_modifier` int(11) DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clinic` (`clinic`) USING BTREE,
  KEY `user_modifier` (`user_modifier`) USING BTREE,
  KEY `user_registered` (`user_registerer`) USING BTREE,
  KEY `user` (`user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `medical_history` int(11) DEFAULT NULL,
  `business` int(11) DEFAULT NULL,
  `invoice_number` varchar(7) NOT NULL,
  `note` text NOT NULL,
  `type_tax_invoice` int(11) NOT NULL,
  `registration_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medical_history` (`medical_history`),
  KEY `user` (`user`),
  KEY `business` (`business`),
  KEY `type_tax_invoice` (`type_tax_invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invoice_service`
--

DROP TABLE IF EXISTS `invoice_service`;
CREATE TABLE IF NOT EXISTS `invoice_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` int(11) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `tracing_service` int(11) DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tracing_service` (`tracing_service`),
  KEY `invoice` (`invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_history`
--

DROP TABLE IF EXISTS `medical_history`;
CREATE TABLE IF NOT EXISTS `medical_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medical_history_number` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `dni` varchar(10) DEFAULT NULL,
  `phone_home` int(9) DEFAULT NULL,
  `phone_mobile` int(9) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `height` float(10,2) DEFAULT NULL,
  `weight` float(10,2) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `note` text,
  `reason_consultation` varchar(512) DEFAULT NULL,
  `background` varchar(512) DEFAULT NULL,
  `patient_risk` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '	(DC2Type:json_array)',
  `allergic_diseases` varchar(512) DEFAULT NULL,
  `treatment_diseases` varchar(512) DEFAULT NULL,
  `patologies` text,
  `supplementary_test` varchar(512) DEFAULT NULL,
  `diagnostic` varchar(512) DEFAULT NULL,
  `treatment` varchar(512) DEFAULT NULL,
  `clinic` int(11) NOT NULL,
  `user_registerer` int(11) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `user_modifier` int(11) DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `address_city` (`city`) USING BTREE,
  KEY `user` (`user_registerer`) USING BTREE,
  KEY `user_modifier` (`user_modifier`) USING BTREE,
  KEY `clinic` (`clinic`) USING BTREE,
  KEY `gender` (`gender`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1611 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medical_history_doc`
--

DROP TABLE IF EXISTS `medical_history_doc`;
CREATE TABLE IF NOT EXISTS `medical_history_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medical_history` int(11) NOT NULL,
  `doc` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `type_doc` int(11) NOT NULL,
  `user_registerer` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_modifier` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_medical_history` (`medical_history`),
  KEY `id_user_registerer` (`user_registerer`),
  KEY `id_user_modifier` (`user_modifier`),
  KEY `id_type_doc` (`type_doc`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orthopodology_history`
--

DROP TABLE IF EXISTS `orthopodology_history`;
CREATE TABLE IF NOT EXISTS `orthopodology_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `medical_history` int(11) NOT NULL,
  `reason_consultation` varchar(512) DEFAULT NULL,
  `background` varchar(512) DEFAULT NULL,
  `articular_exploration_rotary_pattern_external_left` smallint(6) DEFAULT NULL,
  `articular_exploration_rotary_pattern_external_right` smallint(6) DEFAULT NULL,
  `articular_exploration_rotary_pattern_internal_left` smallint(6) DEFAULT NULL,
  `articular_exploration_rotary_pattern_internal_right` smallint(6) DEFAULT NULL,
  `articular_exploration_hip_left` smallint(6) DEFAULT NULL,
  `articular_exploration_hip_right` smallint(6) DEFAULT NULL,
  `articular_exploration_knee_left` varchar(150) DEFAULT NULL,
  `articular_exploration_knee_right` varchar(150) DEFAULT NULL,
  `articular_exploration_ankle_left` varchar(150) DEFAULT NULL,
  `articular_exploration_ankle_right` varchar(150) DEFAULT NULL,
  `articular_exploration_retro_pie_left` varchar(150) DEFAULT NULL,
  `articular_exploration_retro_pie_right` varchar(150) DEFAULT NULL,
  `articular_exploration_before_foot_left` varchar(150) DEFAULT NULL,
  `articular_exploration_before_foot_right` varchar(150) DEFAULT NULL,
  `articular_exploration_first_radio_left` varchar(150) DEFAULT NULL,
  `articular_exploration_first_radio_right` varchar(150) DEFAULT NULL,
  `articular_exploration_fifth_radio_left` varchar(150) DEFAULT NULL,
  `articular_exploration_fifth_radio_right` varchar(150) DEFAULT NULL,
  `articular_exploration_central_radios_left` varchar(150) DEFAULT NULL,
  `articular_exploration_central_radios_right` varchar(150) DEFAULT NULL,
  `articular_exploration_first_finger_left` varchar(150) DEFAULT NULL,
  `articular_exploration_first_finger_right` varchar(150) DEFAULT NULL,
  `articular_exploration_smaller_fingers_left` varchar(150) DEFAULT NULL,
  `articular_exploration_smaller_fingers_right` varchar(150) DEFAULT NULL,
  `torsions_femoral_left` varchar(150) DEFAULT NULL,
  `torsions_femoral_right` varchar(150) DEFAULT NULL,
  `torsions_genus_left` varchar(150) DEFAULT NULL,
  `torsions_genus_right` varchar(150) DEFAULT NULL,
  `torsions_angle_q_left` varchar(150) DEFAULT NULL,
  `torsions_angle_q_right` varchar(150) DEFAULT NULL,
  `torsions_tibial_left` varchar(150) DEFAULT NULL,
  `torsions_tibial_right` varchar(150) DEFAULT NULL,
  `torsions_helbing_left` varchar(150) DEFAULT NULL,
  `torsions_helbing_right` varchar(150) DEFAULT NULL,
  `dissimmetry` varchar(150) DEFAULT NULL,
  `muscular_exploration_dorsal_flexion_left` varchar(150) DEFAULT NULL,
  `muscular_exploration_dorsal_flexion_right` varchar(150) DEFAULT NULL,
  `muscular_exploration_plantar_flexion_left` varchar(150) DEFAULT NULL,
  `muscular_exploration_plantar_flexion_right` varchar(150) DEFAULT NULL,
  `muscular_exploration_eversion_left` varchar(150) DEFAULT NULL,
  `muscular_exploration_eversion_right` varchar(150) DEFAULT NULL,
  `muscular_exploration_reversal_left` varchar(150) DEFAULT NULL,
  `muscular_exploration_reversal_right` varchar(150) DEFAULT NULL,
  `dinamic_exploration` text,
  `signs_footprint` text,
  `suplementary_test` varchar(512) DEFAULT NULL,
  `diagnostic` varchar(512) DEFAULT NULL,
  `treatment` varchar(512) DEFAULT NULL,
  `user_registerer` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_modifier` int(11) DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user_registerer`) USING BTREE,
  KEY `user_modifier` (`user_modifier`) USING BTREE,
  KEY `orthopodology_history` (`medical_history`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orthopodology_history_doc`
--

DROP TABLE IF EXISTS `orthopodology_history_doc`;
CREATE TABLE IF NOT EXISTS `orthopodology_history_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orthopodology_history` int(11) NOT NULL,
  `doc` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `type_doc` int(11) NOT NULL,
  `user_registerer` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_modifier` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_orthopodology_history` (`orthopodology_history`),
  KEY `id_user_registerer` (`user_registerer`),
  KEY `id_user_modifier` (`user_modifier`),
  KEY `id_type_doc` (`type_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `report`
--

DROP TABLE IF EXISTS `report`;
CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `medical_history` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `reason_consultation` text CHARACTER SET utf8mb4,
  `diagnostic` text CHARACTER SET utf8mb4,
  `treatment` text CHARACTER SET utf8mb4,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `medical_history` (`medical_history`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `schedule_google_calendar`
--

DROP TABLE IF EXISTS `schedule_google_calendar`;
CREATE TABLE IF NOT EXISTS `schedule_google_calendar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `refresh_token` varchar(250) DEFAULT NULL,
  `google_calendar_id` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id` int(11) NOT NULL,
  `service` varchar(150) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `minimal_price` float DEFAULT NULL,
  `maximum_price` float DEFAULT NULL,
  `type_tax_service` int(11) DEFAULT '4',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `updated_service` int(11) DEFAULT NULL,
  `clinic` int(11) NOT NULL,
  `user_registerer` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_modifier` int(11) DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_tax` (`type_tax_service`) USING BTREE,
  KEY `user_registerer` (`user_registerer`) USING BTREE,
  KEY `user_modifier` (`user_modifier`) USING BTREE,
  KEY `clinic` (`clinic`) USING BTREE,
  KEY `service_parent` (`parent`) USING BTREE,
  KEY `updated_service` (`updated_service`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tracing`
--

DROP TABLE IF EXISTS `tracing`;
CREATE TABLE IF NOT EXISTS `tracing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `tracing` text,
  `user` int(11) NOT NULL,
  `orthopodology_history` int(11) DEFAULT NULL,
  `medical_history` int(11) DEFAULT NULL,
  `google_calendar_event` varchar(255) DEFAULT NULL,
  `type_tracing` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`) USING BTREE,
  KEY `medical_history` (`medical_history`) USING BTREE,
  KEY `orthopodology_history` (`orthopodology_history`) USING BTREE,
  KEY `type_tracing` (`type_tracing`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tracing_service`
--

DROP TABLE IF EXISTS `tracing_service`;
CREATE TABLE IF NOT EXISTS `tracing_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracing` int(11) NOT NULL,
  `service` int(11) DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `price` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `invoice` int(11) DEFAULT '0',
  `countable` tinyint(1) NOT NULL DEFAULT '1',
  `user_registerer` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_modifier` int(11) NOT NULL,
  `modification_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tracing` (`tracing`),
  KEY `id_service` (`service`),
  KEY `id_user_registerer` (`user_registerer`),
  KEY `id_user_modifier` (`user_modifier`),
  KEY `invoice` (`invoice`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_business`
--

DROP TABLE IF EXISTS `type_business`;
CREATE TABLE IF NOT EXISTS `type_business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(60) NOT NULL,
  `translate` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`),
  UNIQUE KEY `translate` (`translate`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_doc`
--

DROP TABLE IF EXISTS `type_doc`;
CREATE TABLE IF NOT EXISTS `type_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_doc` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_gender`
--

DROP TABLE IF EXISTS `type_gender`;
CREATE TABLE IF NOT EXISTS `type_gender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_tax_invoice`
--

DROP TABLE IF EXISTS `type_tax_invoice`;
CREATE TABLE IF NOT EXISTS `type_tax_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_level` varchar(25) NOT NULL,
  `percent` float NOT NULL,
  `registration_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_tax_service`
--

DROP TABLE IF EXISTS `type_tax_service`;
CREATE TABLE IF NOT EXISTS `type_tax_service` (
  `id` int(11) NOT NULL,
  `tax_level` varchar(50) NOT NULL,
  `percent` float NOT NULL,
  `registration_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_tracing`
--

DROP TABLE IF EXISTS `type_tracing`;
CREATE TABLE IF NOT EXISTS `type_tracing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `translate` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(190) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `surnames` varchar(100) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(190) DEFAULT NULL,
  `role` longtext NOT NULL COMMENT '(DC2Type:json_array)',
  `image` varchar(190) DEFAULT NULL,
  `gender` int(11) NOT NULL,
  `user_registerer` int(11) NOT NULL,
  `registration_date` datetime NOT NULL,
  `user_modifier` int(11) DEFAULT NULL,
  `modification_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_user_name` (`user_name`) USING BTREE,
  UNIQUE KEY `UNIQ_email` (`email`) USING BTREE,
  KEY `type_sex` (`gender`) USING BTREE,
  KEY `user_registerer` (`user_registerer`) USING BTREE,
  KEY `user_modifier` (`user_modifier`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_data_doctor`
--

DROP TABLE IF EXISTS `user_data_doctor`;
CREATE TABLE IF NOT EXISTS `user_data_doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `college_number` int(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=armscii8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_permission`
--

DROP TABLE IF EXISTS `user_permission`;
CREATE TABLE IF NOT EXISTS `user_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `user_list` tinyint(1) NOT NULL DEFAULT '0',
  `user_view` tinyint(1) NOT NULL DEFAULT '0',
  `user_create` tinyint(1) NOT NULL DEFAULT '0',
  `user_edit` tinyint(1) NOT NULL DEFAULT '0',
  `user_remove` tinyint(1) NOT NULL DEFAULT '0',
  `user_dump_view` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission` tinyint(1) NOT NULL DEFAULT '0',
  `clinic_view_other` tinyint(1) NOT NULL DEFAULT '0',
  `clinic_list` tinyint(1) NOT NULL DEFAULT '0',
  `clinic_view` tinyint(1) NOT NULL DEFAULT '0',
  `clinic_create` tinyint(1) NOT NULL DEFAULT '0',
  `clinic_edit` tinyint(1) NOT NULL DEFAULT '0',
  `clinic_remove` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_list` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_view` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_create` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_remove` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_registration_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_modification_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_user_registerer_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_user_modifier_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_list` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_view` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_create` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_remove` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_registration_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_modification_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_user_registerer_edit` tinyint(1) NOT NULL DEFAULT '0',
  `medical_history_doc_user_modifier_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_list` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_view` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_create` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_remove` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_registration_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_modification_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_user_registerer_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_user_modifier_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_list` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_view` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_create` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_remove` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_registration_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_modification_date_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_user_registerer_edit` tinyint(1) NOT NULL DEFAULT '0',
  `orthopodology_history_doc_user_modifier_edit` tinyint(1) NOT NULL DEFAULT '0',
  `report_list` tinyint(1) NOT NULL DEFAULT '0',
  `report_view` tinyint(1) NOT NULL DEFAULT '0',
  `report_create` tinyint(1) NOT NULL DEFAULT '0',
  `report_edit` tinyint(1) NOT NULL DEFAULT '0',
  `report_remove` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_list` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_view` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_create` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_edit` tinyint(1) NOT NULL DEFAULT '0',
  `invoice_remove` tinyint(1) NOT NULL DEFAULT '0',
  `service_list` tinyint(1) NOT NULL DEFAULT '0',
  `service_view` tinyint(1) NOT NULL DEFAULT '0',
  `service_create` tinyint(1) NOT NULL DEFAULT '0',
  `service_edit` tinyint(1) NOT NULL DEFAULT '0',
  `service_remove` tinyint(1) NOT NULL DEFAULT '0',
  `schedule_list` tinyint(1) NOT NULL DEFAULT '0',
  `schedule_view` tinyint(1) NOT NULL DEFAULT '0',
  `schedule_create` tinyint(1) NOT NULL DEFAULT '0',
  `schedule_edit` tinyint(1) NOT NULL DEFAULT '0',
  `schedule_remove` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_list` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_view` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_create` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_edit` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_remove` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_service_list` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_service_view` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_service_create` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_service_edit` tinyint(1) NOT NULL DEFAULT '0',
  `tracing_service_remove` tinyint(1) NOT NULL DEFAULT '0',
  `admin_section_access` tinyint(1) NOT NULL DEFAULT '0',
  `admin_general_data_access` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_2` (`user`) USING BTREE,
  KEY `user` (`user`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_permission_definition`
--

DROP TABLE IF EXISTS `user_permission_definition`;
CREATE TABLE IF NOT EXISTS `user_permission_definition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_list` varchar(100) DEFAULT NULL,
  `user_view` varchar(100) DEFAULT NULL,
  `user_create` varchar(100) DEFAULT NULL,
  `user_edit` varchar(100) DEFAULT NULL,
  `user_remove` varchar(100) DEFAULT NULL,
  `user_dump_view` varchar(100) DEFAULT NULL,
  `user_permission` varchar(100) DEFAULT NULL,
  `clinic_view_other` varchar(100) DEFAULT NULL,
  `clinic_list` varchar(100) DEFAULT NULL,
  `clinic_view` varchar(100) DEFAULT NULL,
  `clinic_create` varchar(100) DEFAULT NULL,
  `clinic_edit` varchar(100) DEFAULT NULL,
  `clinic_remove` varchar(100) DEFAULT NULL,
  `medical_history_list` varchar(100) DEFAULT NULL,
  `medical_history_view` varchar(100) DEFAULT NULL,
  `medical_history_create` varchar(100) DEFAULT NULL,
  `medical_history_edit` varchar(100) DEFAULT NULL,
  `medical_history_remove` varchar(100) DEFAULT NULL,
  `medical_history_registration_date_edit` varchar(100) DEFAULT NULL,
  `medical_history_modification_date_edit` varchar(255) DEFAULT NULL,
  `medical_history_user_registerer_edit` varchar(255) DEFAULT NULL,
  `medical_history_user_modifier_edit` varchar(255) DEFAULT NULL,
  `medical_history_doc_list` varchar(100) DEFAULT NULL,
  `medical_history_doc_view` varchar(100) DEFAULT NULL,
  `medical_history_doc_create` varchar(255) DEFAULT NULL,
  `medical_history_doc_edit` varchar(255) DEFAULT NULL,
  `medical_history_doc_remove` varchar(255) DEFAULT NULL,
  `medical_history_doc_registration_date_edit` varchar(255) DEFAULT NULL,
  `medical_history_doc_modification_date_edit` varchar(255) DEFAULT NULL,
  `medical_history_doc_user_registerer_edit` varchar(255) DEFAULT NULL,
  `medical_history_doc_user_modifier_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_list` varchar(255) DEFAULT NULL,
  `orthopodology_history_view` varchar(255) DEFAULT NULL,
  `orthopodology_history_create` varchar(255) DEFAULT NULL,
  `orthopodology_history_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_remove` varchar(255) DEFAULT NULL,
  `orthopodology_history_registration_date_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_modification_date_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_user_registerer_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_user_modifier_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_doc_list` varchar(100) DEFAULT NULL,
  `orthopodology_history_doc_view` varchar(100) DEFAULT NULL,
  `orthopodology_history_doc_create` varchar(255) DEFAULT NULL,
  `orthopodology_history_doc_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_doc_remove` varchar(255) DEFAULT NULL,
  `orthopodology_history_doc_registration_date_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_doc_modification_date_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_doc_user_registerer_edit` varchar(255) DEFAULT NULL,
  `orthopodology_history_doc_user_modifier_edit` varchar(255) DEFAULT NULL,
  `report_list` varchar(255) NOT NULL,
  `report_view` varchar(255) NOT NULL,
  `report_create` varchar(255) NOT NULL,
  `report_edit` varchar(255) NOT NULL,
  `report_remove` varchar(255) NOT NULL,
  `invoice_list` varchar(255) DEFAULT NULL,
  `invoice_view` varchar(255) DEFAULT NULL,
  `invoice_create` varchar(255) DEFAULT NULL,
  `invoice_edit` varchar(255) DEFAULT NULL,
  `invoice_remove` varchar(255) DEFAULT NULL,
  `service_list` varchar(100) DEFAULT NULL,
  `service_view` varchar(100) DEFAULT NULL,
  `service_create` varchar(255) DEFAULT NULL,
  `service_edit` varchar(255) DEFAULT NULL,
  `service_remove` varchar(255) DEFAULT NULL,
  `schedule_list` varchar(100) DEFAULT NULL,
  `schedule_view` varchar(100) DEFAULT NULL,
  `schedule_create` varchar(100) DEFAULT NULL,
  `schedule_edit` varchar(100) DEFAULT NULL,
  `schedule_remove` varchar(100) DEFAULT NULL,
  `tracing_list` varchar(100) DEFAULT NULL,
  `tracing_view` varchar(100) DEFAULT NULL,
  `tracing_create` varchar(255) DEFAULT NULL,
  `tracing_edit` varchar(255) DEFAULT NULL,
  `tracing_remove` varchar(255) DEFAULT NULL,
  `tracing_service_list` varchar(100) DEFAULT NULL,
  `tracing_service_view` varchar(100) DEFAULT NULL,
  `tracing_service_create` varchar(255) NOT NULL DEFAULT '0',
  `tracing_service_edit` varchar(255) NOT NULL DEFAULT '0',
  `tracing_service_remove` varchar(255) NOT NULL DEFAULT '0',
  `admin_section_access` varchar(255) DEFAULT NULL,
  `admin_general_data_access` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_session`
--

DROP TABLE IF EXISTS `user_session`;
CREATE TABLE IF NOT EXISTS `user_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `path_info` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `ip` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `address_city`
--
ALTER TABLE `address_city`
  ADD CONSTRAINT `FK_5017D2DF57DF7F5B` FOREIGN KEY (`province`) REFERENCES `address_province` (`id`);

--
-- Filtros para la tabla `address_province`
--
ALTER TABLE `address_province`
  ADD CONSTRAINT `FK_B4552A8A5A985C39` FOREIGN KEY (`ccaa`) REFERENCES `address_ccaa` (`id`);

--
-- Filtros para la tabla `business`
--
ALTER TABLE `business`
  ADD CONSTRAINT `business_ibfk_1` FOREIGN KEY (`city`) REFERENCES `address_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `business_ibfk_2` FOREIGN KEY (`type_business`) REFERENCES `type_business` (`id`),
  ADD CONSTRAINT `business_ibfk_3` FOREIGN KEY (`clinic`) REFERENCES `clinic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clinic`
--
ALTER TABLE `clinic`
  ADD CONSTRAINT `clinic_ibfk_1` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clinic_ibfk_2` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clinic_ibfk_3` FOREIGN KEY (`city`) REFERENCES `address_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `clinic_user`
--
ALTER TABLE `clinic_user`
  ADD CONSTRAINT `FK_DA1105D021B44D59` FOREIGN KEY (`clinic`) REFERENCES `clinic` (`id`),
  ADD CONSTRAINT `FK_DA1105D06B3CA4B` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `clinic_user_ibfk_1` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clinic_user_ibfk_2` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`medical_history`) REFERENCES `medical_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_4` FOREIGN KEY (`business`) REFERENCES `business` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_5` FOREIGN KEY (`type_tax_invoice`) REFERENCES `type_tax_invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `invoice_service`
--
ALTER TABLE `invoice_service`
  ADD CONSTRAINT `invoice_service_ibfk_1` FOREIGN KEY (`invoice`) REFERENCES `invoice` (`id`),
  ADD CONSTRAINT `invoice_service_ibfk_2` FOREIGN KEY (`tracing_service`) REFERENCES `tracing_service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medical_history`
--
ALTER TABLE `medical_history`
  ADD CONSTRAINT `medical_history_ibfk_1` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medical_history_ibfk_2` FOREIGN KEY (`gender`) REFERENCES `type_gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medical_history_ibfk_4` FOREIGN KEY (`clinic`) REFERENCES `clinic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medical_history_ibfk_6` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medical_history_ibfk_7` FOREIGN KEY (`city`) REFERENCES `address_city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `medical_history_doc`
--
ALTER TABLE `medical_history_doc`
  ADD CONSTRAINT `medical_history_doc_ibfk_1` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medical_history_doc_ibfk_2` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medical_history_doc_ibfk_3` FOREIGN KEY (`medical_history`) REFERENCES `medical_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `medical_history_doc_ibfk_4` FOREIGN KEY (`type_doc`) REFERENCES `type_doc` (`id`);

--
-- Filtros para la tabla `orthopodology_history`
--
ALTER TABLE `orthopodology_history`
  ADD CONSTRAINT `orthopodology_history_ibfk_1` FOREIGN KEY (`medical_history`) REFERENCES `medical_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orthopodology_history_ibfk_2` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orthopodology_history_ibfk_3` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `orthopodology_history_doc`
--
ALTER TABLE `orthopodology_history_doc`
  ADD CONSTRAINT `orthopodology_history_doc_ibfk_1` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orthopodology_history_doc_ibfk_2` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orthopodology_history_doc_ibfk_3` FOREIGN KEY (`orthopodology_history`) REFERENCES `orthopodology_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orthopodology_history_doc_ibfk_4` FOREIGN KEY (`type_doc`) REFERENCES `type_doc` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`medical_history`) REFERENCES `medical_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `schedule_google_calendar`
--
ALTER TABLE `schedule_google_calendar`
  ADD CONSTRAINT `schedule_google_calendar_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `parent` FOREIGN KEY (`parent`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_ibfk_1` FOREIGN KEY (`clinic`) REFERENCES `clinic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `service_ibfk_2` FOREIGN KEY (`updated_service`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `type_tax` FOREIGN KEY (`type_tax_service`) REFERENCES `type_tax_service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_modifier` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_registerer` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tracing`
--
ALTER TABLE `tracing`
  ADD CONSTRAINT `tracing_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracing_ibfk_2` FOREIGN KEY (`type_tracing`) REFERENCES `type_tracing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracing_ibfk_3` FOREIGN KEY (`orthopodology_history`) REFERENCES `orthopodology_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracing_ibfk_4` FOREIGN KEY (`medical_history`) REFERENCES `medical_history` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tracing_service`
--
ALTER TABLE `tracing_service`
  ADD CONSTRAINT `tracing_service_ibfk_1` FOREIGN KEY (`tracing`) REFERENCES `tracing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracing_service_ibfk_2` FOREIGN KEY (`service`) REFERENCES `service` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracing_service_ibfk_4` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracing_service_ibfk_5` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tracing_service_ibfk_6` FOREIGN KEY (`invoice`) REFERENCES `invoice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`gender`) REFERENCES `type_gender` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`user_registerer`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_3` FOREIGN KEY (`user_modifier`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_data_doctor`
--
ALTER TABLE `user_data_doctor`
  ADD CONSTRAINT `user_data_doctor_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_permission`
--
ALTER TABLE `user_permission`
  ADD CONSTRAINT `user_permission_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_session`
--
ALTER TABLE `user_session`
  ADD CONSTRAINT `user_session_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
