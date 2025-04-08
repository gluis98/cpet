/*
 Navicat Premium Data Transfer

 Source Server         : LOCAL
 Source Server Type    : MySQL
 Source Server Version : 80403 (8.4.3)
 Source Host           : localhost:3306
 Source Schema         : cpet

 Target Server Type    : MySQL
 Target Server Version : 80403 (8.4.3)
 File Encoding         : 65001

 Date: 08/04/2025 12:26:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for armamentos
-- ----------------------------
DROP TABLE IF EXISTS `armamentos`;
CREATE TABLE `armamentos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `calibre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `origen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `uso` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of armamentos
-- ----------------------------
INSERT INTO `armamentos` VALUES (1, 'Glock 17', 'Pistola', '9 mm', 'Austria', 'Policial', NULL);
INSERT INTO `armamentos` VALUES (2, 'AK-103', 'Fusil', '7.62 mm', 'Rusia', 'Militar', NULL);
INSERT INTO `armamentos` VALUES (3, 'Beretta Px4 Storm', 'Pistola', '9 mm', 'Italia', 'Policial', NULL);
INSERT INTO `armamentos` VALUES (4, 'FN Minimi', 'Ametralladora', '5.56 mm', 'Bélgica', 'Militar', NULL);
INSERT INTO `armamentos` VALUES (5, 'Mossberg 590', 'Escopeta', '12 ga', 'Estados Unidos', 'Policial', NULL);

-- ----------------------------
-- Table structure for cargos
-- ----------------------------
DROP TABLE IF EXISTS `cargos`;
CREATE TABLE `cargos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of cargos
-- ----------------------------
INSERT INTO `cargos` VALUES (1, 'Oficial');
INSERT INTO `cargos` VALUES (2, 'Primer Oficial');
INSERT INTO `cargos` VALUES (3, 'Oficial Jefe');
INSERT INTO `cargos` VALUES (4, 'Inspector');
INSERT INTO `cargos` VALUES (5, 'Primer Inspector');
INSERT INTO `cargos` VALUES (6, 'Inspector Jefe');
INSERT INTO `cargos` VALUES (7, 'Comisario');
INSERT INTO `cargos` VALUES (8, 'Primer Comisario');
INSERT INTO `cargos` VALUES (9, 'Comisario Jefe');
INSERT INTO `cargos` VALUES (10, 'Comisario General');
INSERT INTO `cargos` VALUES (11, 'Comisario Mayor');
INSERT INTO `cargos` VALUES (12, 'Comisario Superior');

-- ----------------------------
-- Table structure for estados
-- ----------------------------
DROP TABLE IF EXISTS `estados`;
CREATE TABLE `estados`  (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(75) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `descripcion`(`descripcion` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of estados
-- ----------------------------
INSERT INTO `estados` VALUES (1, 'DTTO. CAPITAL');
INSERT INTO `estados` VALUES (22, 'EDO. AMAZONAS');
INSERT INTO `estados` VALUES (2, 'EDO. ANZOATEGUI');
INSERT INTO `estados` VALUES (3, 'EDO. APURE');
INSERT INTO `estados` VALUES (4, 'EDO. ARAGUA');
INSERT INTO `estados` VALUES (5, 'EDO. BARINAS');
INSERT INTO `estados` VALUES (6, 'EDO. BOLIVAR');
INSERT INTO `estados` VALUES (7, 'EDO. CARABOBO');
INSERT INTO `estados` VALUES (8, 'EDO. COJEDES');
INSERT INTO `estados` VALUES (23, 'EDO. DELTA AMACURO');
INSERT INTO `estados` VALUES (9, 'EDO. FALCON');
INSERT INTO `estados` VALUES (10, 'EDO. GUARICO');
INSERT INTO `estados` VALUES (11, 'EDO. LARA');
INSERT INTO `estados` VALUES (12, 'EDO. MERIDA');
INSERT INTO `estados` VALUES (13, 'EDO. MIRANDA');
INSERT INTO `estados` VALUES (14, 'EDO. MONAGAS');
INSERT INTO `estados` VALUES (15, 'EDO. NVA. ESPARTA');
INSERT INTO `estados` VALUES (16, 'EDO. PORTUGUESA');
INSERT INTO `estados` VALUES (17, 'EDO. SUCRE');
INSERT INTO `estados` VALUES (18, 'EDO. TACHIRA');
INSERT INTO `estados` VALUES (19, 'EDO. TRUJILLO');
INSERT INTO `estados` VALUES (24, 'EDO. VARGAS');
INSERT INTO `estados` VALUES (20, 'EDO. YARACUY');
INSERT INTO `estados` VALUES (21, 'EDO. ZULIA');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (5, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- ----------------------------
-- Table structure for municipios
-- ----------------------------
DROP TABLE IF EXISTS `municipios`;
CREATE TABLE `municipios`  (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `estado_id` smallint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `estado_id`(`estado_id` ASC) USING BTREE,
  CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 339 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of municipios
-- ----------------------------
INSERT INTO `municipios` VALUES (1, 'MP. LIBERTADOR', 1);
INSERT INTO `municipios` VALUES (2, 'MP. INFANTE', 10);
INSERT INTO `municipios` VALUES (3, 'MP. LAS MERCEDES', 10);
INSERT INTO `municipios` VALUES (4, 'MP. EL SOCORRO', 10);
INSERT INTO `municipios` VALUES (5, 'MP. ORTIZ', 10);
INSERT INTO `municipios` VALUES (6, 'MP. S MARIA DE IPIRE', 10);
INSERT INTO `municipios` VALUES (7, 'MP. CHAGUARAMAS', 10);
INSERT INTO `municipios` VALUES (8, 'MP.SAN GERONIMO DE G', 10);
INSERT INTO `municipios` VALUES (9, 'MP. MELLADO', 10);
INSERT INTO `municipios` VALUES (10, 'MP. MIRANDA', 10);
INSERT INTO `municipios` VALUES (11, 'MP. MONAGAS', 10);
INSERT INTO `municipios` VALUES (12, 'MP. RIBAS', 10);
INSERT INTO `municipios` VALUES (13, 'MP. ROSCIO', 10);
INSERT INTO `municipios` VALUES (14, 'MP. ZARAZA', 10);
INSERT INTO `municipios` VALUES (15, 'MP. CAMAGUAN', 10);
INSERT INTO `municipios` VALUES (16, 'MP.S JOSE DE GUARIBE', 10);
INSERT INTO `municipios` VALUES (17, 'MP. CRESPO', 11);
INSERT INTO `municipios` VALUES (18, 'MP. IRIBARREN', 11);
INSERT INTO `municipios` VALUES (19, 'MP. JIMENEZ', 11);
INSERT INTO `municipios` VALUES (20, 'MP. MORAN', 11);
INSERT INTO `municipios` VALUES (21, 'MP. PALAVECINO', 11);
INSERT INTO `municipios` VALUES (22, 'MP. TORRES', 11);
INSERT INTO `municipios` VALUES (23, 'MP. URDANETA', 11);
INSERT INTO `municipios` VALUES (24, 'MP. ANDRES E BLANCO', 11);
INSERT INTO `municipios` VALUES (25, 'MP. SIMON PLANAS', 11);
INSERT INTO `municipios` VALUES (26, 'MP. ALBERTO ADRIANI', 12);
INSERT INTO `municipios` VALUES (27, 'MP. MIRANDA', 12);
INSERT INTO `municipios` VALUES (28, 'MP. ANTONIO PINTO S.', 12);
INSERT INTO `municipios` VALUES (29, 'MP.OB. RAMOS DE LORA', 12);
INSERT INTO `municipios` VALUES (30, 'MP. CARACCIOLO PARRA', 12);
INSERT INTO `municipios` VALUES (31, 'MP.CARDENAL QUINTERO', 12);
INSERT INTO `municipios` VALUES (32, 'MP. PUEBLO LLANO', 12);
INSERT INTO `municipios` VALUES (33, 'MP. RANGEL', 12);
INSERT INTO `municipios` VALUES (34, 'MP. RIVAS DAVILA', 12);
INSERT INTO `municipios` VALUES (35, 'MP. SUCRE', 12);
INSERT INTO `municipios` VALUES (36, 'MP. TOVAR', 12);
INSERT INTO `municipios` VALUES (37, 'MP. ANDRES BELLO', 12);
INSERT INTO `municipios` VALUES (38, 'MP. TULIO F CORDERO', 12);
INSERT INTO `municipios` VALUES (39, 'MP. PADRE NOGUERA', 12);
INSERT INTO `municipios` VALUES (40, 'MP. ARICAGUA', 12);
INSERT INTO `municipios` VALUES (41, 'MP. ZEA', 12);
INSERT INTO `municipios` VALUES (42, 'MP. ARZOBISPO CHACON', 12);
INSERT INTO `municipios` VALUES (43, 'MP. CAMPO ELIAS', 12);
INSERT INTO `municipios` VALUES (44, 'MP. GUARAQUE', 12);
INSERT INTO `municipios` VALUES (45, 'MP.JULIO CESAR SALAS', 12);
INSERT INTO `municipios` VALUES (46, 'MP. JUSTO BRICE#O', 12);
INSERT INTO `municipios` VALUES (47, 'MP. LIBERTADOR', 12);
INSERT INTO `municipios` VALUES (48, 'MP. SANTOS MARQUINA', 12);
INSERT INTO `municipios` VALUES (49, 'MP. ACEVEDO', 13);
INSERT INTO `municipios` VALUES (50, 'MP. URDANETA', 13);
INSERT INTO `municipios` VALUES (51, 'MP. ZAMORA', 13);
INSERT INTO `municipios` VALUES (52, 'MP. CRISTOBAL ROJAS', 13);
INSERT INTO `municipios` VALUES (53, 'MP. LOS SALIAS', 13);
INSERT INTO `municipios` VALUES (54, 'MP. ANDRES BELLO', 13);
INSERT INTO `municipios` VALUES (55, 'MP. SIMON BOLIVAR', 13);
INSERT INTO `municipios` VALUES (56, 'MP. BARUTA', 13);
INSERT INTO `municipios` VALUES (57, 'MP. CARRIZAL', 13);
INSERT INTO `municipios` VALUES (58, 'MP. CHACAO', 13);
INSERT INTO `municipios` VALUES (59, 'MP. EL HATILLO', 13);
INSERT INTO `municipios` VALUES (60, 'MP. BRION', 13);
INSERT INTO `municipios` VALUES (61, 'MP. BUROZ', 13);
INSERT INTO `municipios` VALUES (62, 'MP. PEDRO GUAL', 13);
INSERT INTO `municipios` VALUES (63, 'MP. GUAICAIPURO', 13);
INSERT INTO `municipios` VALUES (64, 'MP. INDEPENDENCIA', 13);
INSERT INTO `municipios` VALUES (65, 'MP. LANDER', 13);
INSERT INTO `municipios` VALUES (66, 'MP. PAEZ', 13);
INSERT INTO `municipios` VALUES (67, 'MP. PAZ CASTILLO', 13);
INSERT INTO `municipios` VALUES (68, 'MP. PLAZA', 13);
INSERT INTO `municipios` VALUES (69, 'MP. SUCRE', 13);
INSERT INTO `municipios` VALUES (70, 'MP. ACOSTA', 14);
INSERT INTO `municipios` VALUES (71, 'MP. SOTILLO', 14);
INSERT INTO `municipios` VALUES (72, 'MP. AGUASAY', 14);
INSERT INTO `municipios` VALUES (73, 'MP. SANTA BARBARA', 14);
INSERT INTO `municipios` VALUES (74, 'MP. URACOA', 14);
INSERT INTO `municipios` VALUES (75, 'MP. BOLIVAR', 14);
INSERT INTO `municipios` VALUES (76, 'MP. CARIPE', 14);
INSERT INTO `municipios` VALUES (77, 'MP. CEDE#O', 14);
INSERT INTO `municipios` VALUES (78, 'MP. EZEQUIEL ZAMORA', 14);
INSERT INTO `municipios` VALUES (79, 'MP. LIBERTADOR', 14);
INSERT INTO `municipios` VALUES (80, 'MP. MATURIN', 14);
INSERT INTO `municipios` VALUES (81, 'MP. PIAR', 14);
INSERT INTO `municipios` VALUES (82, 'MP. PUNCERES', 14);
INSERT INTO `municipios` VALUES (83, 'MP. ARISMENDI', 15);
INSERT INTO `municipios` VALUES (84, 'MP.ANTOLIN DEL CAMPO', 15);
INSERT INTO `municipios` VALUES (85, 'MP. GARCIA', 15);
INSERT INTO `municipios` VALUES (86, 'MP. DIAZ', 15);
INSERT INTO `municipios` VALUES (87, 'MP. GOMEZ', 15);
INSERT INTO `municipios` VALUES (88, 'MP. MANEIRO', 15);
INSERT INTO `municipios` VALUES (89, 'MP. MARCANO', 15);
INSERT INTO `municipios` VALUES (90, 'MP. MARI#O', 15);
INSERT INTO `municipios` VALUES (91, 'MP.PENIN. DE MACANAO', 15);
INSERT INTO `municipios` VALUES (92, 'MP.VILLALBA(I.COCHE)', 15);
INSERT INTO `municipios` VALUES (93, 'MP. TUBORES', 15);
INSERT INTO `municipios` VALUES (94, 'MP. ARAURE', 16);
INSERT INTO `municipios` VALUES (95, 'MP. AGUA BLANCA', 16);
INSERT INTO `municipios` VALUES (96, 'MP. PAPELON', 16);
INSERT INTO `municipios` VALUES (97, 'MP.GENARO BOCONOITO', 16);
INSERT INTO `municipios` VALUES (98, 'MP.S RAFAEL DE ONOTO', 16);
INSERT INTO `municipios` VALUES (99, 'MP. SANTA ROSALIA', 16);
INSERT INTO `municipios` VALUES (100, 'MP. ESTELLER', 16);
INSERT INTO `municipios` VALUES (101, 'MP. GUANARE', 16);
INSERT INTO `municipios` VALUES (102, 'MP. GUANARITO', 16);
INSERT INTO `municipios` VALUES (103, 'MP. OSPINO', 16);
INSERT INTO `municipios` VALUES (104, 'MP. PAEZ', 16);
INSERT INTO `municipios` VALUES (105, 'MP. SUCRE', 16);
INSERT INTO `municipios` VALUES (106, 'MP. TUREN', 16);
INSERT INTO `municipios` VALUES (107, 'MP. M.JOSE V DE UNDA', 16);
INSERT INTO `municipios` VALUES (108, 'MP. ARISMENDI', 17);
INSERT INTO `municipios` VALUES (109, 'MP. VALDEZ', 17);
INSERT INTO `municipios` VALUES (110, 'MP. ANDRES E BLANCO', 17);
INSERT INTO `municipios` VALUES (111, 'MP. LIBERTADOR', 17);
INSERT INTO `municipios` VALUES (112, 'MP. ANDRES MATA', 17);
INSERT INTO `municipios` VALUES (113, 'MP. BOLIVAR', 17);
INSERT INTO `municipios` VALUES (114, 'MP. CRUZ S ACOSTA', 17);
INSERT INTO `municipios` VALUES (115, 'MP. BENITEZ', 17);
INSERT INTO `municipios` VALUES (116, 'MP. BERMUDEZ', 17);
INSERT INTO `municipios` VALUES (117, 'MP. CAJIGAL', 17);
INSERT INTO `municipios` VALUES (118, 'MP. MARI#O', 17);
INSERT INTO `municipios` VALUES (119, 'MP. MEJIA', 17);
INSERT INTO `municipios` VALUES (120, 'MP. MONTES', 17);
INSERT INTO `municipios` VALUES (121, 'MP. RIBERO', 17);
INSERT INTO `municipios` VALUES (122, 'MP. SUCRE', 17);
INSERT INTO `municipios` VALUES (123, 'MP. AYACUCHO', 18);
INSERT INTO `municipios` VALUES (124, 'MP. CORDOBA', 18);
INSERT INTO `municipios` VALUES (125, 'MP. GARCIA DE HEVIA', 18);
INSERT INTO `municipios` VALUES (126, 'MP. GUASIMOS', 18);
INSERT INTO `municipios` VALUES (127, 'MP. MICHELENA', 18);
INSERT INTO `municipios` VALUES (128, 'MP. LIBERTADOR', 18);
INSERT INTO `municipios` VALUES (129, 'MP. PANAMERICANO', 18);
INSERT INTO `municipios` VALUES (130, 'MP. PEDRO MARIA UREÑA', 18);
INSERT INTO `municipios` VALUES (131, 'MP. SUCRE', 18);
INSERT INTO `municipios` VALUES (132, 'MP. ANDRES BELLO', 18);
INSERT INTO `municipios` VALUES (133, 'MP. FERNANDEZ FEO', 18);
INSERT INTO `municipios` VALUES (134, 'MP. BOLIVAR', 18);
INSERT INTO `municipios` VALUES (135, 'MP. LIBERTAD', 18);
INSERT INTO `municipios` VALUES (136, 'MP. SAMUEL MALDONADO', 18);
INSERT INTO `municipios` VALUES (137, 'MP. SEBORUCO', 18);
INSERT INTO `municipios` VALUES (138, 'MP. ANTONIO ROMULO C', 18);
INSERT INTO `municipios` VALUES (139, 'MP. FCO DE MIRANDA', 18);
INSERT INTO `municipios` VALUES (140, 'MP. JOSE MARIA VARGA', 18);
INSERT INTO `municipios` VALUES (141, 'MP. RAFAEL URDANETA', 18);
INSERT INTO `municipios` VALUES (142, 'MP. SIMON RODRIGUEZ', 18);
INSERT INTO `municipios` VALUES (143, 'MP. TORBES', 18);
INSERT INTO `municipios` VALUES (144, 'MP. SAN JUDAS TADEO', 18);
INSERT INTO `municipios` VALUES (145, 'MP. INDEPENDENCIA', 18);
INSERT INTO `municipios` VALUES (146, 'MP. CARDENAS', 18);
INSERT INTO `municipios` VALUES (147, 'MP. JAUREGUI', 18);
INSERT INTO `municipios` VALUES (148, 'MP. JUNIN', 18);
INSERT INTO `municipios` VALUES (149, 'MP. LOBATERA', 18);
INSERT INTO `municipios` VALUES (150, 'MP. SAN CRISTOBAL', 18);
INSERT INTO `municipios` VALUES (151, 'MP. URIBANTE', 18);
INSERT INTO `municipios` VALUES (152, 'MP. BETIJOQUE', 19);
INSERT INTO `municipios` VALUES (153, 'MP. MONTE CARMELO', 19);
INSERT INTO `municipios` VALUES (154, 'MP. MOTATAN', 19);
INSERT INTO `municipios` VALUES (155, 'MP. PAMPAN', 19);
INSERT INTO `municipios` VALUES (156, 'MP. SAN RAFAEL DE CARVAJAL', 19);
INSERT INTO `municipios` VALUES (157, 'MP. SUCRE', 19);
INSERT INTO `municipios` VALUES (158, 'MP. ANDRES BELLO', 19);
INSERT INTO `municipios` VALUES (159, 'MP. BOLIVAR', 19);
INSERT INTO `municipios` VALUES (160, 'MP. JOSE FELIPE MARQUEZ CAÑIZALES', 19);
INSERT INTO `municipios` VALUES (161, 'MP. JUAN VICENTE CAMPO ELIAS', 19);
INSERT INTO `municipios` VALUES (162, 'MP. LA CEIBA', 19);
INSERT INTO `municipios` VALUES (163, 'MP. BOCONÓ', 19);
INSERT INTO `municipios` VALUES (164, 'MP. PAMPANITO', 19);
INSERT INTO `municipios` VALUES (165, 'MP. CARACHE', 19);
INSERT INTO `municipios` VALUES (166, 'MP. ESCUQUE', 19);
INSERT INTO `municipios` VALUES (167, 'MP. TRUJILLO', 19);
INSERT INTO `municipios` VALUES (168, 'MP. URDANETA', 19);
INSERT INTO `municipios` VALUES (169, 'MP. VALERA', 19);
INSERT INTO `municipios` VALUES (170, 'MP. CANDELARIA', 19);
INSERT INTO `municipios` VALUES (171, 'MP. MIRANDA', 19);
INSERT INTO `municipios` VALUES (172, 'MP. ANACO', 2);
INSERT INTO `municipios` VALUES (173, 'MP. MONAGAS', 2);
INSERT INTO `municipios` VALUES (174, 'MP. PEÑALVER', 2);
INSERT INTO `municipios` VALUES (175, 'MP. SIMON RODRIGUEZ', 2);
INSERT INTO `municipios` VALUES (176, 'MP. SOTILLO', 2);
INSERT INTO `municipios` VALUES (177, 'MP. GUANIPA', 2);
INSERT INTO `municipios` VALUES (178, 'MP. GUANTA', 2);
INSERT INTO `municipios` VALUES (179, 'MP. PIRITU', 2);
INSERT INTO `municipios` VALUES (180, 'MP. DIEGO BAUTISTA U', 2);
INSERT INTO `municipios` VALUES (181, 'MP. CARVAJAL', 2);
INSERT INTO `municipios` VALUES (182, 'MP. SANTA ANA', 2);
INSERT INTO `municipios` VALUES (183, 'MP. ARAGUA', 2);
INSERT INTO `municipios` VALUES (184, 'MP. MC GREGOR', 2);
INSERT INTO `municipios` VALUES (185, 'MP.S JUAN CAPISTRANO', 2);
INSERT INTO `municipios` VALUES (186, 'MP. BOLIVAR', 2);
INSERT INTO `municipios` VALUES (187, 'MP. BRUZUAL', 2);
INSERT INTO `municipios` VALUES (188, 'MP. CAJIGAL', 2);
INSERT INTO `municipios` VALUES (189, 'MP. FREITES', 2);
INSERT INTO `municipios` VALUES (190, 'MP. INDEPENDENCIA', 2);
INSERT INTO `municipios` VALUES (191, 'MP. LIBERTAD', 2);
INSERT INTO `municipios` VALUES (192, 'MP. MIRANDA', 2);
INSERT INTO `municipios` VALUES (193, 'MP. BOLIVAR', 20);
INSERT INTO `municipios` VALUES (194, 'MP. COCOROTE', 20);
INSERT INTO `municipios` VALUES (195, 'MP. INDEPENDENCIA', 20);
INSERT INTO `municipios` VALUES (196, 'MP. ARISTIDES BASTID', 20);
INSERT INTO `municipios` VALUES (197, 'MP. MANUEL MONGE', 20);
INSERT INTO `municipios` VALUES (198, 'MP. VEROES', 20);
INSERT INTO `municipios` VALUES (199, 'MP. BRUZUAL', 20);
INSERT INTO `municipios` VALUES (200, 'MP. NIRGUA', 20);
INSERT INTO `municipios` VALUES (201, 'MP. SAN FELIPE', 20);
INSERT INTO `municipios` VALUES (202, 'MP. SUCRE', 20);
INSERT INTO `municipios` VALUES (203, 'MP. URACHICHE', 20);
INSERT INTO `municipios` VALUES (204, 'MP. PE#A', 20);
INSERT INTO `municipios` VALUES (205, 'MP.JOSE ANTONIO PAEZ', 20);
INSERT INTO `municipios` VALUES (206, 'MP. LA TRINIDAD', 20);
INSERT INTO `municipios` VALUES (207, 'MP. BARALT', 21);
INSERT INTO `municipios` VALUES (208, 'MP. LA CA#ADA DE U.', 21);
INSERT INTO `municipios` VALUES (209, 'MP. LAGUNILLAS', 21);
INSERT INTO `municipios` VALUES (210, 'MP. CATATUMBO', 21);
INSERT INTO `municipios` VALUES (211, 'MP. ROSARIO DE PERIJA', 21);
INSERT INTO `municipios` VALUES (212, 'MP. CABIMAS', 21);
INSERT INTO `municipios` VALUES (213, 'MP.VALMORE RODRIGUEZ', 21);
INSERT INTO `municipios` VALUES (214, 'MP. JESUS E LOSSADA', 21);
INSERT INTO `municipios` VALUES (215, 'MP. ALMIRANTE P', 21);
INSERT INTO `municipios` VALUES (216, 'MP. SAN FRANCISCO', 21);
INSERT INTO `municipios` VALUES (217, 'MP. JESUS M SEMPRUN', 21);
INSERT INTO `municipios` VALUES (218, 'MP. SANTA RITA', 21);
INSERT INTO `municipios` VALUES (219, 'MP. FRANCISCO J PULG', 21);
INSERT INTO `municipios` VALUES (220, 'MP. SIMON BOLIVAR', 21);
INSERT INTO `municipios` VALUES (221, 'MP. COLON', 21);
INSERT INTO `municipios` VALUES (222, 'MP. MARA', 21);
INSERT INTO `municipios` VALUES (223, 'MP. MARACAIBO', 21);
INSERT INTO `municipios` VALUES (224, 'MP. MIRANDA', 21);
INSERT INTO `municipios` VALUES (225, 'MP. PAEZ', 21);
INSERT INTO `municipios` VALUES (226, 'MP. MACHIQUES DE P', 21);
INSERT INTO `municipios` VALUES (227, 'MP. SUCRE', 21);
INSERT INTO `municipios` VALUES (228, 'MP. ATURES', 22);
INSERT INTO `municipios` VALUES (229, 'MP. ATABAPO', 22);
INSERT INTO `municipios` VALUES (230, 'MP. MAROA', 22);
INSERT INTO `municipios` VALUES (231, 'MP. RIO NEGRO', 22);
INSERT INTO `municipios` VALUES (232, 'MP. AUTANA', 22);
INSERT INTO `municipios` VALUES (233, 'MP. MANAPIARE', 22);
INSERT INTO `municipios` VALUES (234, 'MP. ALTO ORINOCO', 22);
INSERT INTO `municipios` VALUES (235, 'MP. TUCUPITA', 23);
INSERT INTO `municipios` VALUES (236, 'MP. PEDERNALES', 23);
INSERT INTO `municipios` VALUES (237, 'MP. ANTONIO DIAZ', 23);
INSERT INTO `municipios` VALUES (238, 'MP. CASACOIMA', 23);
INSERT INTO `municipios` VALUES (239, 'MP. VARGAS', 24);
INSERT INTO `municipios` VALUES (240, 'MP. ACHAGUAS', 3);
INSERT INTO `municipios` VALUES (241, 'MP. MU#OZ', 3);
INSERT INTO `municipios` VALUES (242, 'MP. PAEZ', 3);
INSERT INTO `municipios` VALUES (243, 'MP. PEDRO CAMEJO', 3);
INSERT INTO `municipios` VALUES (244, 'MP. ROMULO GALLEGOS', 3);
INSERT INTO `municipios` VALUES (245, 'MP. SAN FERNANDO', 3);
INSERT INTO `municipios` VALUES (246, 'MP. BIRUACA', 3);
INSERT INTO `municipios` VALUES (247, 'MP. GIRARDOT', 4);
INSERT INTO `municipios` VALUES (248, 'MP. JOSE ANGEL LAMAS', 4);
INSERT INTO `municipios` VALUES (249, 'MP. BOLIVAR', 4);
INSERT INTO `municipios` VALUES (250, 'MP. SANTOS MICHELENA', 4);
INSERT INTO `municipios` VALUES (251, 'MP. MARIO B IRAGORRY', 4);
INSERT INTO `municipios` VALUES (252, 'MP. TOVAR', 4);
INSERT INTO `municipios` VALUES (253, 'MP. CAMATAGUA', 4);
INSERT INTO `municipios` VALUES (254, 'MP. JOSE R REVENGA', 4);
INSERT INTO `municipios` VALUES (255, 'MP. FRANCISCO LINARES A.', 4);
INSERT INTO `municipios` VALUES (256, 'MP. OCUMARE D LA COSTA', 4);
INSERT INTO `municipios` VALUES (257, 'MP. SANTIAGO MARI#O', 4);
INSERT INTO `municipios` VALUES (258, 'MP. JOSE FELIX RIVAS', 4);
INSERT INTO `municipios` VALUES (259, 'MP. SAN CASIMIRO', 4);
INSERT INTO `municipios` VALUES (260, 'MP. SAN SEBASTIAN', 4);
INSERT INTO `municipios` VALUES (261, 'MP. SUCRE', 4);
INSERT INTO `municipios` VALUES (262, 'MP. URDANETA', 4);
INSERT INTO `municipios` VALUES (263, 'MP. ZAMORA', 4);
INSERT INTO `municipios` VALUES (264, 'MP. LIBERTADOR', 4);
INSERT INTO `municipios` VALUES (265, 'MP. ARISMENDI', 5);
INSERT INTO `municipios` VALUES (266, 'MP. A JOSE DE SUCRE', 5);
INSERT INTO `municipios` VALUES (267, 'MP. CRUZ PAREDES', 5);
INSERT INTO `municipios` VALUES (268, 'MP. ANDRES E. BLANCO', 5);
INSERT INTO `municipios` VALUES (269, 'MP. BARINAS', 5);
INSERT INTO `municipios` VALUES (270, 'MP. BOLIVAR', 5);
INSERT INTO `municipios` VALUES (271, 'MP. EZEQUIEL ZAMORA', 5);
INSERT INTO `municipios` VALUES (272, 'MP. OBISPOS', 5);
INSERT INTO `municipios` VALUES (273, 'MP. PEDRAZA', 5);
INSERT INTO `municipios` VALUES (274, 'MP. ROJAS', 5);
INSERT INTO `municipios` VALUES (275, 'MP. SOSA', 5);
INSERT INTO `municipios` VALUES (276, 'MP. ALBERTO ARVELO T', 5);
INSERT INTO `municipios` VALUES (277, 'MP. CARONI', 6);
INSERT INTO `municipios` VALUES (278, 'MP. EL CALLAO', 6);
INSERT INTO `municipios` VALUES (279, 'MP.PADRE PEDRO CHIEN', 6);
INSERT INTO `municipios` VALUES (280, 'MP. CEDE#O', 6);
INSERT INTO `municipios` VALUES (281, 'MP. HERES', 6);
INSERT INTO `municipios` VALUES (282, 'MP. PIAR', 6);
INSERT INTO `municipios` VALUES (283, 'MP. ROSCIO', 6);
INSERT INTO `municipios` VALUES (284, 'MP. SUCRE', 6);
INSERT INTO `municipios` VALUES (285, 'MP. SIFONTES', 6);
INSERT INTO `municipios` VALUES (286, 'MP. RAUL LEONI', 6);
INSERT INTO `municipios` VALUES (287, 'MP. GRAN SABANA', 6);
INSERT INTO `municipios` VALUES (288, 'MP. BEJUMA', 7);
INSERT INTO `municipios` VALUES (289, 'MP. MIRANDA', 7);
INSERT INTO `municipios` VALUES (290, 'MP. LOS GUAYOS', 7);
INSERT INTO `municipios` VALUES (291, 'MP. NAGUANAGUA', 7);
INSERT INTO `municipios` VALUES (292, 'MP. SAN DIEGO', 7);
INSERT INTO `municipios` VALUES (293, 'MP. LIBERTADOR', 7);
INSERT INTO `municipios` VALUES (294, 'MP. CARLOS ARVELO', 7);
INSERT INTO `municipios` VALUES (295, 'MP. DIEGO IBARRA', 7);
INSERT INTO `municipios` VALUES (296, 'MP. GUACARA', 7);
INSERT INTO `municipios` VALUES (297, 'MP. MONTALBAN', 7);
INSERT INTO `municipios` VALUES (298, 'MP. JUAN JOSE MORA', 7);
INSERT INTO `municipios` VALUES (299, 'MP. PUERTO CABELLO', 7);
INSERT INTO `municipios` VALUES (300, 'MP. SAN JOAQUIN', 7);
INSERT INTO `municipios` VALUES (301, 'MP. VALENCIA', 7);
INSERT INTO `municipios` VALUES (302, 'MP. ANZOATEGUI', 8);
INSERT INTO `municipios` VALUES (303, 'MP. FALCON', 8);
INSERT INTO `municipios` VALUES (304, 'MP. GIRARDOT', 8);
INSERT INTO `municipios` VALUES (305, 'MP. PAO SAN J BAUTISTA', 8);
INSERT INTO `municipios` VALUES (306, 'MP. RICAURTE', 8);
INSERT INTO `municipios` VALUES (307, 'MP. SAN CARLOS', 8);
INSERT INTO `municipios` VALUES (308, 'MP. TINACO', 8);
INSERT INTO `municipios` VALUES (309, 'MP. LIMA BLANCO', 8);
INSERT INTO `municipios` VALUES (310, 'MP. ROMULO GALLEGOS', 8);
INSERT INTO `municipios` VALUES (311, 'MP. ACOSTA', 9);
INSERT INTO `municipios` VALUES (312, 'MP. MIRANDA', 9);
INSERT INTO `municipios` VALUES (313, 'MP. PETIT', 9);
INSERT INTO `municipios` VALUES (314, 'MP. SILVA', 9);
INSERT INTO `municipios` VALUES (315, 'MP. ZAMORA', 9);
INSERT INTO `municipios` VALUES (316, 'MP. DABAJURO', 9);
INSERT INTO `municipios` VALUES (317, 'MP. MONS. ITURRIZA', 9);
INSERT INTO `municipios` VALUES (318, 'MP. LOS TAQUES', 9);
INSERT INTO `municipios` VALUES (319, 'MP. PIRITU', 9);
INSERT INTO `municipios` VALUES (320, 'MP. UNION', 9);
INSERT INTO `municipios` VALUES (321, 'MP. SAN FRANCISCO', 9);
INSERT INTO `municipios` VALUES (322, 'MP. BOLIVAR', 9);
INSERT INTO `municipios` VALUES (323, 'MP. JACURA', 9);
INSERT INTO `municipios` VALUES (324, 'MP. CACIQUE MANAURE', 9);
INSERT INTO `municipios` VALUES (325, 'MP. PALMA SOLA', 9);
INSERT INTO `municipios` VALUES (326, 'MP. SUCRE', 9);
INSERT INTO `municipios` VALUES (327, 'MP. URUMACO', 9);
INSERT INTO `municipios` VALUES (328, 'MP. TOCOPERO', 9);
INSERT INTO `municipios` VALUES (329, 'MP. BUCHIVACOA', 9);
INSERT INTO `municipios` VALUES (330, 'MP. CARIRUBANA', 9);
INSERT INTO `municipios` VALUES (331, 'MP. COLINA', 9);
INSERT INTO `municipios` VALUES (332, 'MP. DEMOCRACIA', 9);
INSERT INTO `municipios` VALUES (333, 'MP. FALCON', 9);
INSERT INTO `municipios` VALUES (334, 'MP. FEDERACION', 9);
INSERT INTO `municipios` VALUES (335, 'MP. MAUROA', 9);

-- ----------------------------
-- Table structure for oficiales
-- ----------------------------
DROP TABLE IF EXISTS `oficiales`;
CREATE TABLE `oficiales`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `documento_identidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tipo_sangre` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `talla_camisa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `talla_pantalon` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `talla_zapatos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `estado_civil` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `correo_electronico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `estatus` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'activo',
  `numero_placa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `parroquia_id` smallint UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `documento_identidad`(`documento_identidad` ASC) USING BTREE,
  INDEX `parroquia_id`(`parroquia_id` ASC) USING BTREE,
  CONSTRAINT `oficiales_ibfk_1` FOREIGN KEY (`parroquia_id`) REFERENCES `parroquias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales
-- ----------------------------
INSERT INTO `oficiales` VALUES (1, '27306869', 'Luis Fernando Gómez', '2025-03-24', 'A+', 'M', '32', '42', '2010-03-24', 'Soltero', 'Municipio Trujillo, Parroquia 3 Esquinas, Urb. Bucare Casa Nro 07', '04165324125', 'luisfgb919@gmail.com', 'activo', '0001', NULL);

-- ----------------------------
-- Table structure for oficiales_academico
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_academico`;
CREATE TABLE `oficiales_academico`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `tipo_formacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `institucion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_academico_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_academico
-- ----------------------------
INSERT INTO `oficiales_academico` VALUES (5, 1, 'Ingeniería', 'Universidad de los Andes', '2023-03-26', '2025-03-26', 'Carrera de civi', 'Civil');

-- ----------------------------
-- Table structure for oficiales_armamento
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_armamento`;
CREATE TABLE `oficiales_armamento`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `id_arma` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_asignacion` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  INDEX `id_arma`(`id_arma` ASC) USING BTREE,
  CONSTRAINT `oficiales_armamento_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `oficiales_armamento_ibfk_2` FOREIGN KEY (`id_arma`) REFERENCES `armamentos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oficiales_armamento
-- ----------------------------
INSERT INTO `oficiales_armamento` VALUES (1, 1, 1, 'Será utilizada como arma de apoyo en contingencia', 'EXCELENTES CODICIONES', '2025-03-26');

-- ----------------------------
-- Table structure for oficiales_cargos
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_cargos`;
CREATE TABLE `oficiales_cargos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `id_cargo` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  `is_actual` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  INDEX `id_cargo`(`id_cargo` ASC) USING BTREE,
  CONSTRAINT `oficiales_cargos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `oficiales_cargos_ibfk_2` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_cargos
-- ----------------------------
INSERT INTO `oficiales_cargos` VALUES (2, 1, 3, '2025-03-24', NULL, 1);
INSERT INTO `oficiales_cargos` VALUES (3, 1, 2, '2025-03-24', '2025-03-24', NULL);

-- ----------------------------
-- Table structure for oficiales_cursos
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_cursos`;
CREATE TABLE `oficiales_cursos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `institucion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_cursos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_cursos
-- ----------------------------
INSERT INTO `oficiales_cursos` VALUES (3, 1, 'Criminalistica y penal', 'Universidad Nacional Experimental de Seguridad (UNES)', 'Curso', 'is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', '2025-01-26', '2025-03-26');

-- ----------------------------
-- Table structure for oficiales_documentos
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_documentos`;
CREATE TABLE `oficiales_documentos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `tipo_documento` enum('Cedula de Identidad','Partida de Nacimiento','Carta de Residencia','Registro de Información Fiscal (RIF)','Referencia Personal 1','Referencia Personal 2','Inscripción en el CNE','Referencia Bancaria','Foto Tipo Carnet 1','Foto Tipo Carnet 2','Foto Cuerpo Completo Fondo Rojo','Tipo de Sangre','Tallas de Uniforme y Calzado','Carnet Laboral') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `archivo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_documentos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_documentos
-- ----------------------------
INSERT INTO `oficiales_documentos` VALUES (5, 1, 'Cedula de Identidad', 'archivos/1/Vny2K4YXNwfi551Oga5LlRhzb7y1zYHOLSr27cHr.jpg', '2025-03-26 12:58:40');

-- ----------------------------
-- Table structure for oficiales_emergencias
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_emergencias`;
CREATE TABLE `oficiales_emergencias`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NULL DEFAULT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `relacion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_emergencias_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_emergencias
-- ----------------------------

-- ----------------------------
-- Table structure for oficiales_familiares
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_familiares`;
CREATE TABLE `oficiales_familiares`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NULL DEFAULT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `parentesco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_familiares_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_familiares
-- ----------------------------
INSERT INTO `oficiales_familiares` VALUES (3, 1, 'Luis Fernando Gómez', 'Hijo(a)', '2025-03-24', '04165324125', 'Trujillo');

-- ----------------------------
-- Table structure for oficiales_familiares_documentos
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_familiares_documentos`;
CREATE TABLE `oficiales_familiares_documentos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `id_familiar` int NOT NULL,
  `tipo_documento` enum('Cédula de Identidad de los Padres','Partida de Nacimiento de los Padres','Acta de Matrimonio o Unión Estable de Hecho','Cédula de Identidad del Cónyuge','Partida de Nacimiento del Cónyuge','Foto Tamaño Carnet del Cónyuge','Partida de Nacimiento de los Hijos','Cédula de Identidad de los Hijos','Grupo Sanguíneo','Nivel Educativo y Grado Académico de los Hijos') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `archivo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  INDEX `id_familiar`(`id_familiar` ASC) USING BTREE,
  CONSTRAINT `oficiales_familiares_documentos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `oficiales_familiares_documentos_ibfk_2` FOREIGN KEY (`id_familiar`) REFERENCES `oficiales_familiares` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_familiares_documentos
-- ----------------------------

-- ----------------------------
-- Table structure for oficiales_reconocimientos
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_reconocimientos`;
CREATE TABLE `oficiales_reconocimientos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha` date NOT NULL,
  `autoridad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_reconocimientos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_reconocimientos
-- ----------------------------

-- ----------------------------
-- Table structure for oficiales_salud
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_salud`;
CREATE TABLE `oficiales_salud`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NULL DEFAULT NULL,
  `tipo_sangre` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alergias` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `condiciones_preexistentes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `fecha_revision` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_salud_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_salud
-- ----------------------------

-- ----------------------------
-- Table structure for oficiales_vacaciones
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_vacaciones`;
CREATE TABLE `oficiales_vacaciones`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NULL DEFAULT NULL,
  `fecha_emision` date NULL DEFAULT NULL,
  `fecha_reintegro` date NULL DEFAULT NULL,
  `estatus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `is_disfrutadas` int NULL DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_vacaciones_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of oficiales_vacaciones
-- ----------------------------
INSERT INTO `oficiales_vacaciones` VALUES (2, 1, '2025-03-26', '2025-04-26', 'APROBADAS', 1, NULL);

-- ----------------------------
-- Table structure for parroquias
-- ----------------------------
DROP TABLE IF EXISTS `parroquias`;
CREATE TABLE `parroquias`  (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `municipio_id` smallint UNSIGNED NOT NULL DEFAULT 0,
  `atencionfamilias` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `municipio_id`(`municipio_id` ASC) USING BTREE,
  CONSTRAINT `parroquias_ibfk_1` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1135 CHARACTER SET = utf8mb3 COLLATE = utf8mb3_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of parroquias
-- ----------------------------
INSERT INTO `parroquias` VALUES (1, 'PQ. ALTAGRACIA', 1, 0);
INSERT INTO `parroquias` VALUES (2, 'PQ. SUCRE', 1, 0);
INSERT INTO `parroquias` VALUES (3, 'PQ. 23 DE ENERO', 1, 0);
INSERT INTO `parroquias` VALUES (4, 'PQ. ANTIMANO', 1, 0);
INSERT INTO `parroquias` VALUES (5, 'PQ. EL RECREO', 1, 0);
INSERT INTO `parroquias` VALUES (6, 'PQ. EL VALLE', 1, 0);
INSERT INTO `parroquias` VALUES (7, 'PQ. LA VEGA', 1, 0);
INSERT INTO `parroquias` VALUES (8, 'PQ. MACARAO', 1, 0);
INSERT INTO `parroquias` VALUES (9, 'PQ. CARICUAO', 1, 0);
INSERT INTO `parroquias` VALUES (10, 'PQ. EL JUNQUITO', 1, 0);
INSERT INTO `parroquias` VALUES (11, 'PQ. COCHE', 1, 0);
INSERT INTO `parroquias` VALUES (12, 'PQ. CANDELARIA', 1, 0);
INSERT INTO `parroquias` VALUES (13, 'PQ. SAN PEDRO', 1, 0);
INSERT INTO `parroquias` VALUES (14, 'PQ. SAN BERNARDINO', 1, 0);
INSERT INTO `parroquias` VALUES (15, 'PQ. EL PARAISO', 1, 0);
INSERT INTO `parroquias` VALUES (16, 'PQ. CATEDRAL', 1, 0);
INSERT INTO `parroquias` VALUES (17, 'PQ. LA PASTORA', 1, 0);
INSERT INTO `parroquias` VALUES (18, 'PQ. SAN AGUSTIN', 1, 0);
INSERT INTO `parroquias` VALUES (19, 'PQ. SAN JOSE', 1, 0);
INSERT INTO `parroquias` VALUES (20, 'PQ. SAN JUAN', 1, 0);
INSERT INTO `parroquias` VALUES (21, 'PQ. SANTA ROSALIA', 1, 0);
INSERT INTO `parroquias` VALUES (22, 'PQ. SANTA TERESA', 1, 0);
INSERT INTO `parroquias` VALUES (23, 'PQ. VALLE DE LA PASCUA', 2, 0);
INSERT INTO `parroquias` VALUES (24, 'PQ. ESPINO', 2, 0);
INSERT INTO `parroquias` VALUES (25, 'PQ. LAS MERCEDES', 3, 0);
INSERT INTO `parroquias` VALUES (26, 'PQ. STA RITA DE MANAPIRE', 3, 0);
INSERT INTO `parroquias` VALUES (27, 'PQ. CABRUTA', 3, 0);
INSERT INTO `parroquias` VALUES (28, 'PQ. EL SOCORRO', 4, 0);
INSERT INTO `parroquias` VALUES (29, 'PQ. ORTIZ', 5, 0);
INSERT INTO `parroquias` VALUES (30, 'PQ. SAN FCO. DE TIZNADOS', 5, 0);
INSERT INTO `parroquias` VALUES (31, 'PQ. SAN JOSE DE TIZNADOS', 5, 0);
INSERT INTO `parroquias` VALUES (32, 'PQ. S LORENZO DE TIZNADOS', 5, 0);
INSERT INTO `parroquias` VALUES (33, 'PQ. SANTA MARIA DE IPIRE', 6, 0);
INSERT INTO `parroquias` VALUES (34, 'PQ. ALTAMIRA', 6, 0);
INSERT INTO `parroquias` VALUES (35, 'PQ. CHAGUARAMAS', 7, 0);
INSERT INTO `parroquias` VALUES (36, 'PQ. GUAYABAL', 8, 0);
INSERT INTO `parroquias` VALUES (37, 'PQ. CAZORLA', 8, 0);
INSERT INTO `parroquias` VALUES (38, 'PQ. EL SOMBRERO', 9, 0);
INSERT INTO `parroquias` VALUES (39, 'PQ. SOSA', 9, 0);
INSERT INTO `parroquias` VALUES (40, 'PQ. CALABOZO', 10, 0);
INSERT INTO `parroquias` VALUES (41, 'PQ. EL CALVARIO', 10, 0);
INSERT INTO `parroquias` VALUES (42, 'PQ. EL RASTRO', 10, 0);
INSERT INTO `parroquias` VALUES (43, 'PQ. GUARDATINAJAS', 10, 0);
INSERT INTO `parroquias` VALUES (44, 'PQ. ALTAGRACIA DE ORITUCO', 11, 0);
INSERT INTO `parroquias` VALUES (45, 'PQ. LEZAMA', 11, 0);
INSERT INTO `parroquias` VALUES (46, 'PQ. LIBERTAD DE ORITUCO', 11, 0);
INSERT INTO `parroquias` VALUES (47, 'PQ. SAN FCO DE MACAIRA', 11, 0);
INSERT INTO `parroquias` VALUES (48, 'PQ. SAN RAFAEL DE ORITUCO', 11, 0);
INSERT INTO `parroquias` VALUES (49, 'PQ. SOUBLETTE', 11, 0);
INSERT INTO `parroquias` VALUES (50, 'PQ. PASO REAL DE MACAIRA', 11, 0);
INSERT INTO `parroquias` VALUES (51, 'PQ. TUCUPIDO', 12, 0);
INSERT INTO `parroquias` VALUES (52, 'PQ. SAN RAFAEL DE LAYA', 12, 0);
INSERT INTO `parroquias` VALUES (53, 'PQ.SAN JUAN DE LOS MORROS', 13, 0);
INSERT INTO `parroquias` VALUES (54, 'PQ. PARAPARA', 13, 0);
INSERT INTO `parroquias` VALUES (55, 'PQ. CANTAGALLO', 13, 0);
INSERT INTO `parroquias` VALUES (56, 'PQ. ZARAZA', 14, 0);
INSERT INTO `parroquias` VALUES (57, 'PQ. SAN JOSE DE UNARE', 14, 0);
INSERT INTO `parroquias` VALUES (58, 'PQ. CAMAGUAN', 15, 0);
INSERT INTO `parroquias` VALUES (59, 'PQ. PUERTO MIRANDA', 15, 0);
INSERT INTO `parroquias` VALUES (60, 'PQ. UVERITO', 15, 0);
INSERT INTO `parroquias` VALUES (61, 'PQ. SAN JOSE DE GUARIBE', 16, 0);
INSERT INTO `parroquias` VALUES (62, 'PQ. FREITEZ', 17, 0);
INSERT INTO `parroquias` VALUES (63, 'PQ. JOSE MARIA BLANCO', 17, 0);
INSERT INTO `parroquias` VALUES (64, 'PQ. CATEDRAL', 18, 0);
INSERT INTO `parroquias` VALUES (65, 'PQ. JUAREZ', 18, 0);
INSERT INTO `parroquias` VALUES (66, 'PQ. LA CONCEPCION', 18, 0);
INSERT INTO `parroquias` VALUES (67, 'PQ. SANTA ROSA', 18, 0);
INSERT INTO `parroquias` VALUES (68, 'PQ. UNION', 18, 0);
INSERT INTO `parroquias` VALUES (69, 'PQ. EL CUJI', 18, 0);
INSERT INTO `parroquias` VALUES (70, 'PQ. TAMACA', 18, 0);
INSERT INTO `parroquias` VALUES (71, 'PQ. JUAN DE VILLEGAS', 18, 0);
INSERT INTO `parroquias` VALUES (72, 'PQ. AGUEDO F. ALVARADO', 18, 0);
INSERT INTO `parroquias` VALUES (73, 'PQ. BUENA VISTA', 18, 0);
INSERT INTO `parroquias` VALUES (74, 'PQ. JUAN B RODRIGUEZ', 19, 0);
INSERT INTO `parroquias` VALUES (75, 'PQ. DIEGO DE LOZADA', 19, 0);
INSERT INTO `parroquias` VALUES (76, 'PQ. SAN MIGUEL', 19, 0);
INSERT INTO `parroquias` VALUES (77, 'PQ. CUARA', 19, 0);
INSERT INTO `parroquias` VALUES (78, 'PQ. PARAISO DE SAN JOSE', 19, 0);
INSERT INTO `parroquias` VALUES (79, 'PQ. TINTORERO', 19, 0);
INSERT INTO `parroquias` VALUES (80, 'PQ. JOSE BERNARDO DORANTE', 19, 0);
INSERT INTO `parroquias` VALUES (81, 'PQ. CRNEL. MARIANO PERAZA', 19, 0);
INSERT INTO `parroquias` VALUES (82, 'PQ. BOLIVAR', 20, 0);
INSERT INTO `parroquias` VALUES (83, 'PQ. ANZOATEGUI', 20, 0);
INSERT INTO `parroquias` VALUES (84, 'PQ. GUARICO', 20, 0);
INSERT INTO `parroquias` VALUES (85, 'PQ. HUMOCARO ALTO', 20, 0);
INSERT INTO `parroquias` VALUES (86, 'PQ. HUMOCARO BAJO', 20, 0);
INSERT INTO `parroquias` VALUES (87, 'PQ. MORAN', 20, 0);
INSERT INTO `parroquias` VALUES (88, 'PQ. HILARIO LUNA Y LUNA', 20, 0);
INSERT INTO `parroquias` VALUES (89, 'PQ. LA CANDELARIA', 20, 0);
INSERT INTO `parroquias` VALUES (90, 'PQ. CABUDARE', 21, 0);
INSERT INTO `parroquias` VALUES (91, 'PQ. JOSE G. BASTIDAS', 21, 0);
INSERT INTO `parroquias` VALUES (92, 'PQ. AGUA VIVA', 21, 0);
INSERT INTO `parroquias` VALUES (93, 'PQ. TRINIDAD SAMUEL', 22, 0);
INSERT INTO `parroquias` VALUES (94, 'PQ. TORRES', 22, 0);
INSERT INTO `parroquias` VALUES (95, 'PQ. EL BLANCO', 22, 0);
INSERT INTO `parroquias` VALUES (96, 'PQ. MONTA A VERDE', 22, 0);
INSERT INTO `parroquias` VALUES (97, 'PQ. HERIBERTO ARROYO', 22, 0);
INSERT INTO `parroquias` VALUES (98, 'PQ. LAS MERCEDES', 22, 0);
INSERT INTO `parroquias` VALUES (99, 'PQ. CECILIO ZUBILLAGA', 22, 0);
INSERT INTO `parroquias` VALUES (100, 'PQ. REYES VARGAS', 22, 0);
INSERT INTO `parroquias` VALUES (101, 'PQ. ALTAGRACIA', 22, 0);
INSERT INTO `parroquias` VALUES (102, 'PQ. ANTONIO DIAZ', 22, 0);
INSERT INTO `parroquias` VALUES (103, 'PQ. CAMACARO', 22, 0);
INSERT INTO `parroquias` VALUES (104, 'PQ. CASTA#EDA', 22, 0);
INSERT INTO `parroquias` VALUES (105, 'PQ. CHIQUINQUIRA', 22, 0);
INSERT INTO `parroquias` VALUES (106, 'PQ. ESPINOZA LOS MONTEROS', 22, 0);
INSERT INTO `parroquias` VALUES (107, 'PQ. LARA', 22, 0);
INSERT INTO `parroquias` VALUES (108, 'PQ. MANUEL MORILLO', 22, 0);
INSERT INTO `parroquias` VALUES (109, 'PQ. MONTES DE OCA', 22, 0);
INSERT INTO `parroquias` VALUES (110, 'PQ. SIQUISIQUE', 23, 0);
INSERT INTO `parroquias` VALUES (111, 'PQ. SAN MIGUEL', 23, 0);
INSERT INTO `parroquias` VALUES (112, 'PQ. XAGUAS', 23, 0);
INSERT INTO `parroquias` VALUES (113, 'PQ. MOROTURO', 23, 0);
INSERT INTO `parroquias` VALUES (114, 'PQ. PIO TAMAYO', 24, 0);
INSERT INTO `parroquias` VALUES (115, 'PQ. YACAMBU', 24, 0);
INSERT INTO `parroquias` VALUES (116, 'PQ. QBDA. HONDA DE GUACHE', 24, 0);
INSERT INTO `parroquias` VALUES (117, 'PQ. SARARE', 25, 0);
INSERT INTO `parroquias` VALUES (118, 'PQ. GUSTAVO VEGAS LEON', 25, 0);
INSERT INTO `parroquias` VALUES (119, 'PQ. BURIA', 25, 0);
INSERT INTO `parroquias` VALUES (120, 'PQ. GABRIEL PICON G.', 26, 0);
INSERT INTO `parroquias` VALUES (121, 'PQ. HECTOR AMABLE MORA', 26, 0);
INSERT INTO `parroquias` VALUES (122, 'PQ. JOSE NUCETE SARDI', 26, 0);
INSERT INTO `parroquias` VALUES (123, 'PQ. PULIDO MENDEZ', 26, 0);
INSERT INTO `parroquias` VALUES (124, 'PQ. PTE. ROMULO GALLEGOS', 26, 0);
INSERT INTO `parroquias` VALUES (125, 'PQ. PRESIDENTE BETANCOURT', 26, 0);
INSERT INTO `parroquias` VALUES (126, 'PQ. PRESIDENTE PAEZ', 26, 0);
INSERT INTO `parroquias` VALUES (127, 'CM. TIMOTES', 27, 0);
INSERT INTO `parroquias` VALUES (128, 'PQ. ANDRES ELOY BLANCO', 27, 0);
INSERT INTO `parroquias` VALUES (129, 'PQ. PI#ANGO', 27, 0);
INSERT INTO `parroquias` VALUES (130, 'PQ. LA VENTA', 27, 0);
INSERT INTO `parroquias` VALUES (131, 'CM. STA CRUZ DE MORA', 28, 0);
INSERT INTO `parroquias` VALUES (132, 'PQ. MESA BOLIVAR', 28, 0);
INSERT INTO `parroquias` VALUES (133, 'PQ. MESA DE LAS PALMAS', 28, 0);
INSERT INTO `parroquias` VALUES (134, 'CM. STA ELENA DE ARENALES', 29, 0);
INSERT INTO `parroquias` VALUES (135, 'PQ. ELOY PAREDES', 29, 0);
INSERT INTO `parroquias` VALUES (136, 'PQ. PQ R DE ALCAZAR', 29, 0);
INSERT INTO `parroquias` VALUES (137, 'CM. TUCANI', 30, 0);
INSERT INTO `parroquias` VALUES (138, 'PQ. FLORENCIO RAMIREZ', 30, 0);
INSERT INTO `parroquias` VALUES (139, 'CM. SANTO DOMINGO', 31, 0);
INSERT INTO `parroquias` VALUES (140, 'PQ. LAS PIEDRAS', 31, 0);
INSERT INTO `parroquias` VALUES (141, 'CM. PUEBLO LLANO', 32, 0);
INSERT INTO `parroquias` VALUES (142, 'CM. MUCUCHIES', 33, 0);
INSERT INTO `parroquias` VALUES (143, 'PQ. MUCURUBA', 33, 0);
INSERT INTO `parroquias` VALUES (144, 'PQ. SAN RAFAEL', 33, 0);
INSERT INTO `parroquias` VALUES (145, 'PQ. CACUTE', 33, 0);
INSERT INTO `parroquias` VALUES (146, 'PQ. LA TOMA', 33, 0);
INSERT INTO `parroquias` VALUES (147, 'CM. BAILADORES', 34, 0);
INSERT INTO `parroquias` VALUES (148, 'PQ. GERONIMO MALDONADO', 34, 0);
INSERT INTO `parroquias` VALUES (149, 'CM. LAGUNILLAS', 35, 0);
INSERT INTO `parroquias` VALUES (150, 'PQ. CHIGUARA', 35, 0);
INSERT INTO `parroquias` VALUES (151, 'PQ. ESTANQUES', 35, 0);
INSERT INTO `parroquias` VALUES (152, 'PQ. SAN JUAN', 35, 0);
INSERT INTO `parroquias` VALUES (153, 'PQ. PUEBLO NUEVO DEL SUR', 35, 0);
INSERT INTO `parroquias` VALUES (154, 'PQ. LA TRAMPA', 35, 0);
INSERT INTO `parroquias` VALUES (155, 'PQ. EL LLANO', 36, 0);
INSERT INTO `parroquias` VALUES (156, 'PQ. TOVAR', 36, 0);
INSERT INTO `parroquias` VALUES (157, 'PQ. EL AMPARO', 36, 0);
INSERT INTO `parroquias` VALUES (158, 'PQ. SAN FRANCISCO', 36, 0);
INSERT INTO `parroquias` VALUES (159, 'CM. LA AZULITA', 37, 0);
INSERT INTO `parroquias` VALUES (160, 'CM. NUEVA BOLIVIA', 38, 0);
INSERT INTO `parroquias` VALUES (161, 'PQ. INDEPENDENCIA', 38, 0);
INSERT INTO `parroquias` VALUES (162, 'PQ. MARIA C PALACIOS', 38, 0);
INSERT INTO `parroquias` VALUES (163, 'PQ. SANTA APOLONIA', 38, 0);
INSERT INTO `parroquias` VALUES (164, 'CM. STA MARIA DE CAPARO', 39, 0);
INSERT INTO `parroquias` VALUES (165, 'CM. ARICAGUA', 40, 0);
INSERT INTO `parroquias` VALUES (166, 'PQ. SAN ANTONIO', 40, 0);
INSERT INTO `parroquias` VALUES (167, 'CM. ZEA', 41, 0);
INSERT INTO `parroquias` VALUES (168, 'PQ. CA#O EL TIGRE', 41, 0);
INSERT INTO `parroquias` VALUES (169, 'CM. CANAGUA', 42, 0);
INSERT INTO `parroquias` VALUES (170, 'PQ. CAPURI', 42, 0);
INSERT INTO `parroquias` VALUES (171, 'PQ. CHACANTA', 42, 0);
INSERT INTO `parroquias` VALUES (172, 'PQ. EL MOLINO', 42, 0);
INSERT INTO `parroquias` VALUES (173, 'PQ. GUAIMARAL', 42, 0);
INSERT INTO `parroquias` VALUES (174, 'PQ. MUCUTUY', 42, 0);
INSERT INTO `parroquias` VALUES (175, 'PQ. MUCUCHACHI', 42, 0);
INSERT INTO `parroquias` VALUES (176, 'PQ. ACEQUIAS', 43, 0);
INSERT INTO `parroquias` VALUES (177, 'PQ. JAJI', 43, 0);
INSERT INTO `parroquias` VALUES (178, 'PQ. LA MESA', 43, 0);
INSERT INTO `parroquias` VALUES (179, 'PQ. SAN JOSE', 43, 0);
INSERT INTO `parroquias` VALUES (180, 'PQ. MONTALBAN', 43, 0);
INSERT INTO `parroquias` VALUES (181, 'PQ. MATRIZ', 43, 0);
INSERT INTO `parroquias` VALUES (182, 'PQ. FERNANDEZ PE#A', 43, 0);
INSERT INTO `parroquias` VALUES (183, 'CM. GUARAQUE', 44, 0);
INSERT INTO `parroquias` VALUES (184, 'PQ. MESA DE QUINTERO', 44, 0);
INSERT INTO `parroquias` VALUES (185, 'PQ. RIO NEGRO', 44, 0);
INSERT INTO `parroquias` VALUES (186, 'CM. ARAPUEY', 45, 0);
INSERT INTO `parroquias` VALUES (187, 'PQ. PALMIRA', 45, 0);
INSERT INTO `parroquias` VALUES (188, 'CM. TORONDOY', 46, 0);
INSERT INTO `parroquias` VALUES (189, 'PQ. SAN CRISTOBAL DE T', 46, 0);
INSERT INTO `parroquias` VALUES (190, 'PQ. ARIAS', 47, 0);
INSERT INTO `parroquias` VALUES (191, 'PQ. LASSO DE LA VEGA', 47, 0);
INSERT INTO `parroquias` VALUES (192, 'PQ. CARACCIOLO PARRA P', 47, 0);
INSERT INTO `parroquias` VALUES (193, 'PQ. MARIANO PICON SALAS', 47, 0);
INSERT INTO `parroquias` VALUES (194, 'PQ. ANTONIO SPINETTI DINI', 47, 0);
INSERT INTO `parroquias` VALUES (195, 'PQ. EL MORRO', 47, 0);
INSERT INTO `parroquias` VALUES (196, 'PQ. LOS NEVADOS', 47, 0);
INSERT INTO `parroquias` VALUES (197, 'PQ. SAGRARIO', 47, 0);
INSERT INTO `parroquias` VALUES (198, 'PQ. MILLA', 47, 0);
INSERT INTO `parroquias` VALUES (199, 'PQ. EL LLANO', 47, 0);
INSERT INTO `parroquias` VALUES (200, 'PQ. JUAN RODRIGUEZ SUAREZ', 47, 0);
INSERT INTO `parroquias` VALUES (201, 'PQ. JACINTO PLAZA', 47, 0);
INSERT INTO `parroquias` VALUES (202, 'PQ. DOMINGO PE#A', 47, 0);
INSERT INTO `parroquias` VALUES (203, 'PQ. GONZALO PICON FEBRES', 47, 0);
INSERT INTO `parroquias` VALUES (204, 'PQ. OSUNA RODRIGUEZ', 47, 0);
INSERT INTO `parroquias` VALUES (205, 'CM. TABAY', 48, 0);
INSERT INTO `parroquias` VALUES (206, 'PQ. CAUCAGUA', 49, 0);
INSERT INTO `parroquias` VALUES (207, 'PQ. ARAGUITA', 49, 0);
INSERT INTO `parroquias` VALUES (208, 'PQ. AREVALO GONZALEZ', 49, 0);
INSERT INTO `parroquias` VALUES (209, 'PQ. CAPAYA', 49, 0);
INSERT INTO `parroquias` VALUES (210, 'PQ. PANAQUIRE', 49, 0);
INSERT INTO `parroquias` VALUES (211, 'PQ. RIBAS', 49, 0);
INSERT INTO `parroquias` VALUES (212, 'PQ. EL CAFE', 49, 0);
INSERT INTO `parroquias` VALUES (213, 'PQ. MARIZAPA', 49, 0);
INSERT INTO `parroquias` VALUES (214, 'PQ. CUA', 50, 0);
INSERT INTO `parroquias` VALUES (215, 'PQ. NUEVA CUA', 50, 0);
INSERT INTO `parroquias` VALUES (216, 'PQ. GUATIRE', 51, 0);
INSERT INTO `parroquias` VALUES (217, 'PQ. BOLIVAR', 51, 0);
INSERT INTO `parroquias` VALUES (218, 'PQ. CHARALLAVE', 52, 0);
INSERT INTO `parroquias` VALUES (219, 'PQ. LAS BRISAS', 52, 0);
INSERT INTO `parroquias` VALUES (220, 'PQ. SAN ANTONIO LOS ALTOS', 53, 0);
INSERT INTO `parroquias` VALUES (221, 'PQ.SAN JOSE DE BARLOVENTO', 54, 0);
INSERT INTO `parroquias` VALUES (222, 'PQ. CUMBO', 54, 0);
INSERT INTO `parroquias` VALUES (223, 'PQ. SAN FCO DE YARE', 55, 0);
INSERT INTO `parroquias` VALUES (224, 'PQ. S ANTONIO DE YARE', 55, 0);
INSERT INTO `parroquias` VALUES (225, 'PQ. BARUTA', 56, 0);
INSERT INTO `parroquias` VALUES (226, 'PQ. EL CAFETAL', 56, 0);
INSERT INTO `parroquias` VALUES (227, 'PQ. LAS MINAS DE BARUTA', 56, 0);
INSERT INTO `parroquias` VALUES (228, 'PQ. CARRIZAL', 57, 0);
INSERT INTO `parroquias` VALUES (229, 'PQ. CHACAO', 58, 0);
INSERT INTO `parroquias` VALUES (230, 'PQ. EL HATILLO', 59, 0);
INSERT INTO `parroquias` VALUES (231, 'PQ. HIGUEROTE', 60, 0);
INSERT INTO `parroquias` VALUES (232, 'PQ. CURIEPE', 60, 0);
INSERT INTO `parroquias` VALUES (233, 'PQ. TACARIGUA', 60, 0);
INSERT INTO `parroquias` VALUES (234, 'PQ. MAMPORAL', 61, 0);
INSERT INTO `parroquias` VALUES (235, 'PQ. CUPIRA', 62, 0);
INSERT INTO `parroquias` VALUES (236, 'PQ. MACHURUCUTO', 62, 0);
INSERT INTO `parroquias` VALUES (237, 'PQ. LOS TEQUES', 63, 0);
INSERT INTO `parroquias` VALUES (238, 'PQ. CECILIO ACOSTA', 63, 0);
INSERT INTO `parroquias` VALUES (239, 'PQ. PARACOTOS', 63, 0);
INSERT INTO `parroquias` VALUES (240, 'PQ. SAN PEDRO', 63, 0);
INSERT INTO `parroquias` VALUES (241, 'PQ. TACATA', 63, 0);
INSERT INTO `parroquias` VALUES (242, 'PQ. EL JARILLO', 63, 0);
INSERT INTO `parroquias` VALUES (243, 'PQ. ALTAGRACIA DE LA M', 63, 0);
INSERT INTO `parroquias` VALUES (244, 'PQ. STA TERESA DEL TUY', 64, 0);
INSERT INTO `parroquias` VALUES (245, 'PQ. EL CARTANAL', 64, 0);
INSERT INTO `parroquias` VALUES (246, 'PQ. OCUMARE DEL TUY', 65, 0);
INSERT INTO `parroquias` VALUES (247, 'PQ. LA DEMOCRACIA', 65, 0);
INSERT INTO `parroquias` VALUES (248, 'PQ. SANTA BARBARA', 65, 0);
INSERT INTO `parroquias` VALUES (249, 'PQ. RIO CHICO', 66, 0);
INSERT INTO `parroquias` VALUES (250, 'PQ. EL GUAPO', 66, 0);
INSERT INTO `parroquias` VALUES (251, 'PQ.TACARIGUA DE LA LAGUNA', 66, 0);
INSERT INTO `parroquias` VALUES (252, 'PQ. PAPARO', 66, 0);
INSERT INTO `parroquias` VALUES (253, 'PQ. SN FERNANDO DEL GUAPO', 66, 0);
INSERT INTO `parroquias` VALUES (254, 'PQ. SANTA LUCIA', 67, 0);
INSERT INTO `parroquias` VALUES (255, 'PQ. GUARENAS', 68, 0);
INSERT INTO `parroquias` VALUES (256, 'PQ. PETARE', 69, 0);
INSERT INTO `parroquias` VALUES (257, 'PQ. LEONCIO MARTINEZ', 69, 0);
INSERT INTO `parroquias` VALUES (258, 'PQ. CAUCAGUITA', 69, 0);
INSERT INTO `parroquias` VALUES (259, 'PQ. FILAS DE MARICHES', 69, 0);
INSERT INTO `parroquias` VALUES (260, 'PQ. LA DOLORITA', 69, 0);
INSERT INTO `parroquias` VALUES (261, 'CM. SAN ANTONIO', 70, 0);
INSERT INTO `parroquias` VALUES (262, 'PQ. SAN FRANCISCO', 70, 0);
INSERT INTO `parroquias` VALUES (263, 'CM. BARRANCAS', 71, 0);
INSERT INTO `parroquias` VALUES (264, 'LOS BARRANCOS DE FAJARDO', 71, 0);
INSERT INTO `parroquias` VALUES (265, 'CM. AGUASAY', 72, 0);
INSERT INTO `parroquias` VALUES (266, 'CM. SANTA BARBARA', 73, 0);
INSERT INTO `parroquias` VALUES (267, 'CM. URACOA', 74, 0);
INSERT INTO `parroquias` VALUES (268, 'CM. CARIPITO', 75, 0);
INSERT INTO `parroquias` VALUES (269, 'CM. CARIPE', 76, 0);
INSERT INTO `parroquias` VALUES (270, 'PQ. TERESEN', 76, 0);
INSERT INTO `parroquias` VALUES (271, 'PQ. EL GUACHARO', 76, 0);
INSERT INTO `parroquias` VALUES (272, 'PQ. SAN AGUSTIN', 76, 0);
INSERT INTO `parroquias` VALUES (273, 'PQ. LA GUANOTA', 76, 0);
INSERT INTO `parroquias` VALUES (274, 'PQ. SABANA DE PIEDRA', 76, 0);
INSERT INTO `parroquias` VALUES (275, 'CM. CAICARA', 77, 0);
INSERT INTO `parroquias` VALUES (276, 'PQ. AREO', 77, 0);
INSERT INTO `parroquias` VALUES (277, 'PQ. SAN FELIX', 77, 0);
INSERT INTO `parroquias` VALUES (278, 'PQ. VIENTO FRESCO', 77, 0);
INSERT INTO `parroquias` VALUES (279, 'CM. PUNTA DE MATA', 78, 0);
INSERT INTO `parroquias` VALUES (280, 'PQ. EL TEJERO', 78, 0);
INSERT INTO `parroquias` VALUES (281, 'CM. TEMBLADOR', 79, 0);
INSERT INTO `parroquias` VALUES (282, 'PQ. TABASCA', 79, 0);
INSERT INTO `parroquias` VALUES (283, 'PQ. LAS ALHUACAS', 79, 0);
INSERT INTO `parroquias` VALUES (284, 'PQ. CHAGUARAMAS', 79, 0);
INSERT INTO `parroquias` VALUES (285, 'PQ. EL FURRIAL', 80, 0);
INSERT INTO `parroquias` VALUES (286, 'PQ. SAN SIMON', 80, 0);
INSERT INTO `parroquias` VALUES (287, 'PQ. JUSEPIN', 80, 0);
INSERT INTO `parroquias` VALUES (288, 'PQ. EL COROZO', 80, 0);
INSERT INTO `parroquias` VALUES (289, 'PQ. SAN VICENTE', 80, 0);
INSERT INTO `parroquias` VALUES (290, 'PQ. LA PICA', 80, 0);
INSERT INTO `parroquias` VALUES (291, 'PQ. ALTO DE LOS GODOS', 80, 0);
INSERT INTO `parroquias` VALUES (292, 'PQ. BOQUERON', 80, 0);
INSERT INTO `parroquias` VALUES (293, 'PQ. LAS COCUIZAS', 80, 0);
INSERT INTO `parroquias` VALUES (294, 'PQ. SANTA CRUZ', 80, 0);
INSERT INTO `parroquias` VALUES (295, 'CM. ARAGUA', 81, 0);
INSERT INTO `parroquias` VALUES (296, 'PQ. CHAGUARAMAL', 81, 0);
INSERT INTO `parroquias` VALUES (297, 'PQ. GUANAGUANA', 81, 0);
INSERT INTO `parroquias` VALUES (298, 'PQ. APARICIO', 81, 0);
INSERT INTO `parroquias` VALUES (299, 'PQ. TAGUAYA', 81, 0);
INSERT INTO `parroquias` VALUES (300, 'PQ. EL PINTO', 81, 0);
INSERT INTO `parroquias` VALUES (301, 'PQ. LA TOSCANA', 81, 0);
INSERT INTO `parroquias` VALUES (302, 'CM. QUIRIQUIRE', 82, 0);
INSERT INTO `parroquias` VALUES (303, 'PQ. CACHIPO', 82, 0);
INSERT INTO `parroquias` VALUES (304, 'CM. LA ASUNCION', 83, 0);
INSERT INTO `parroquias` VALUES (305, 'CM.LA PLAZA DE PARAGUACHI', 84, 0);
INSERT INTO `parroquias` VALUES (306, 'CM. VALLE ESP SANTO', 85, 0);
INSERT INTO `parroquias` VALUES (307, 'PQ. FRANCISCO FAJARDO', 85, 0);
INSERT INTO `parroquias` VALUES (308, 'CM. SAN JUAN BAUTISTA', 86, 0);
INSERT INTO `parroquias` VALUES (309, 'PQ. ZABALA', 86, 0);
INSERT INTO `parroquias` VALUES (310, 'CM. SANTA ANA', 87, 0);
INSERT INTO `parroquias` VALUES (311, 'PQ. GUEVARA', 87, 0);
INSERT INTO `parroquias` VALUES (312, 'PQ. MATASIETE', 87, 0);
INSERT INTO `parroquias` VALUES (313, 'PQ. BOLIVAR', 87, 0);
INSERT INTO `parroquias` VALUES (314, 'PQ. SUCRE', 87, 0);
INSERT INTO `parroquias` VALUES (315, 'CM. PAMPATAR', 88, 0);
INSERT INTO `parroquias` VALUES (316, 'PQ. AGUIRRE', 88, 0);
INSERT INTO `parroquias` VALUES (317, 'CM. JUAN GRIEGO', 89, 0);
INSERT INTO `parroquias` VALUES (318, 'PQ. ADRIAN', 89, 0);
INSERT INTO `parroquias` VALUES (319, 'CM. PORLAMAR', 90, 0);
INSERT INTO `parroquias` VALUES (320, 'CM. BOCA DEL RIO', 91, 0);
INSERT INTO `parroquias` VALUES (321, 'PQ. SAN FRANCISCO', 91, 0);
INSERT INTO `parroquias` VALUES (322, 'CM. SAN PEDRO DE COCHE', 92, 0);
INSERT INTO `parroquias` VALUES (323, 'PQ. VICENTE FUENTES', 92, 0);
INSERT INTO `parroquias` VALUES (324, 'CM. PUNTA DE PIEDRAS', 93, 0);
INSERT INTO `parroquias` VALUES (325, 'PQ. LOS BARALES', 93, 0);
INSERT INTO `parroquias` VALUES (326, 'CM. ARAURE', 94, 0);
INSERT INTO `parroquias` VALUES (327, 'PQ. RIO ACARIGUA', 94, 0);
INSERT INTO `parroquias` VALUES (328, 'CM. AGUA BLANCA', 95, 0);
INSERT INTO `parroquias` VALUES (329, 'CM. PAPELON', 96, 0);
INSERT INTO `parroquias` VALUES (330, 'PQ. CA#O DELGADITO', 96, 0);
INSERT INTO `parroquias` VALUES (331, 'CM. BOCONOITO', 97, 0);
INSERT INTO `parroquias` VALUES (332, 'PQ. ANTOLIN TOVAR AQUINO', 97, 0);
INSERT INTO `parroquias` VALUES (333, 'CM. SAN RAFAEL DE ONOTO', 98, 0);
INSERT INTO `parroquias` VALUES (334, 'PQ. SANTA FE', 98, 0);
INSERT INTO `parroquias` VALUES (335, 'PQ. THERMO MORLES', 98, 0);
INSERT INTO `parroquias` VALUES (336, 'CM. EL PLAYON', 99, 0);
INSERT INTO `parroquias` VALUES (337, 'PQ. FLORIDA', 99, 0);
INSERT INTO `parroquias` VALUES (338, 'CM. PIRITU', 100, 0);
INSERT INTO `parroquias` VALUES (339, 'PQ. UVERAL', 100, 0);
INSERT INTO `parroquias` VALUES (340, 'CM. GUANARE', 101, 0);
INSERT INTO `parroquias` VALUES (341, 'PQ. CORDOBA', 101, 0);
INSERT INTO `parroquias` VALUES (342, 'PQ.SAN JUAN GUANAGUANARE', 101, 0);
INSERT INTO `parroquias` VALUES (343, 'PQ. VIRGEN DE LA COROMOTO', 101, 0);
INSERT INTO `parroquias` VALUES (344, 'PQ.SAN JOSE DE LA MONTA#A', 101, 0);
INSERT INTO `parroquias` VALUES (345, 'CM. GUANARITO', 102, 0);
INSERT INTO `parroquias` VALUES (346, 'PQ.TRINIDAD DE LA CAPILLA', 102, 0);
INSERT INTO `parroquias` VALUES (347, 'PQ. DIVINA PASTORA', 102, 0);
INSERT INTO `parroquias` VALUES (348, 'CM. OSPINO', 103, 0);
INSERT INTO `parroquias` VALUES (349, 'PQ. APARICION', 103, 0);
INSERT INTO `parroquias` VALUES (350, 'PQ. LA ESTACION', 103, 0);
INSERT INTO `parroquias` VALUES (351, 'CM. ACARIGUA', 104, 0);
INSERT INTO `parroquias` VALUES (352, 'PQ. PAYARA', 104, 0);
INSERT INTO `parroquias` VALUES (353, 'PQ. PIMPINELA', 104, 0);
INSERT INTO `parroquias` VALUES (354, 'PQ. RAMON PERAZA', 104, 0);
INSERT INTO `parroquias` VALUES (355, 'CM. BISCUCUY', 105, 0);
INSERT INTO `parroquias` VALUES (356, 'PQ. CONCEPCION', 105, 0);
INSERT INTO `parroquias` VALUES (357, 'PQ.SAN RAFAEL PALO ALZADO', 105, 0);
INSERT INTO `parroquias` VALUES (358, 'PQ. UVENCIO A VELASQUEZ', 105, 0);
INSERT INTO `parroquias` VALUES (359, 'PQ. SAN JOSE DE SAGUAZ', 105, 0);
INSERT INTO `parroquias` VALUES (360, 'PQ. VILLA ROSA', 105, 0);
INSERT INTO `parroquias` VALUES (361, 'CM. VILLA BRUZUAL', 106, 0);
INSERT INTO `parroquias` VALUES (362, 'PQ. CANELONES', 106, 0);
INSERT INTO `parroquias` VALUES (363, 'PQ. SANTA CRUZ', 106, 0);
INSERT INTO `parroquias` VALUES (364, 'PQ. SAN ISIDRO LABRADOR', 106, 0);
INSERT INTO `parroquias` VALUES (365, 'CM. CHABASQUEN', 107, 0);
INSERT INTO `parroquias` VALUES (366, 'PQ. PE#A BLANCA', 107, 0);
INSERT INTO `parroquias` VALUES (367, 'PQ. RIO CARIBE', 108, 0);
INSERT INTO `parroquias` VALUES (368, 'PQ. SAN JUAN GALDONAS', 108, 0);
INSERT INTO `parroquias` VALUES (369, 'PQ. PUERTO SANTO', 108, 0);
INSERT INTO `parroquias` VALUES (370, 'PQ. EL MORRO DE PTO SANTO', 108, 0);
INSERT INTO `parroquias` VALUES (371, 'PQ. ANTONIO JOSE DE SUCRE', 108, 0);
INSERT INTO `parroquias` VALUES (372, 'PQ. GUIRIA', 109, 0);
INSERT INTO `parroquias` VALUES (373, 'PQ. CRISTOBAL COLON', 109, 0);
INSERT INTO `parroquias` VALUES (374, 'PQ. PUNTA DE PIEDRA', 109, 0);
INSERT INTO `parroquias` VALUES (375, 'PQ. BIDEAU', 109, 0);
INSERT INTO `parroquias` VALUES (376, 'PQ. MARI#O', 110, 0);
INSERT INTO `parroquias` VALUES (377, 'PQ. ROMULO GALLEGOS', 110, 0);
INSERT INTO `parroquias` VALUES (378, 'PQ. TUNAPUY', 111, 0);
INSERT INTO `parroquias` VALUES (379, 'PQ. CAMPO ELIAS', 111, 0);
INSERT INTO `parroquias` VALUES (380, 'PQ. SAN JOSE DE AREOCUAR', 112, 0);
INSERT INTO `parroquias` VALUES (381, 'PQ. TAVERA ACOSTA', 112, 0);
INSERT INTO `parroquias` VALUES (382, 'CM. MARIGUITAR', 113, 0);
INSERT INTO `parroquias` VALUES (383, 'PQ. ARAYA', 114, 0);
INSERT INTO `parroquias` VALUES (384, 'PQ. MANICUARE', 114, 0);
INSERT INTO `parroquias` VALUES (385, 'PQ. CHACOPATA', 114, 0);
INSERT INTO `parroquias` VALUES (386, 'PQ. EL PILAR', 115, 0);
INSERT INTO `parroquias` VALUES (387, 'PQ. EL RINCON', 115, 0);
INSERT INTO `parroquias` VALUES (388, 'PQ. GUARAUNOS', 115, 0);
INSERT INTO `parroquias` VALUES (389, 'PQ. TUNAPUICITO', 115, 0);
INSERT INTO `parroquias` VALUES (390, 'PQ. UNION', 115, 0);
INSERT INTO `parroquias` VALUES (391, 'PQ. GRAL FCO. A VASQUEZ', 115, 0);
INSERT INTO `parroquias` VALUES (392, 'PQ. SANTA CATALINA', 116, 0);
INSERT INTO `parroquias` VALUES (393, 'PQ. SANTA ROSA', 116, 0);
INSERT INTO `parroquias` VALUES (394, 'PQ. SANTA TERESA', 116, 0);
INSERT INTO `parroquias` VALUES (395, 'PQ. BOLIVAR', 116, 0);
INSERT INTO `parroquias` VALUES (396, 'PQ. MACARAPANA', 116, 0);
INSERT INTO `parroquias` VALUES (397, 'PQ. YAGUARAPARO', 117, 0);
INSERT INTO `parroquias` VALUES (398, 'PQ. LIBERTAD', 117, 0);
INSERT INTO `parroquias` VALUES (399, 'PQ. PAUJIL', 117, 0);
INSERT INTO `parroquias` VALUES (400, 'PQ. IRAPA', 118, 0);
INSERT INTO `parroquias` VALUES (401, 'PQ. CAMPO CLARO', 118, 0);
INSERT INTO `parroquias` VALUES (402, 'PQ. SORO', 118, 0);
INSERT INTO `parroquias` VALUES (403, 'PQ. SAN ANTONIO DE IRAPA', 118, 0);
INSERT INTO `parroquias` VALUES (404, 'PQ. MARABAL', 118, 0);
INSERT INTO `parroquias` VALUES (405, 'CM. SAN ANT DEL GOLFO', 119, 0);
INSERT INTO `parroquias` VALUES (406, 'PQ. CUMANACOA', 120, 0);
INSERT INTO `parroquias` VALUES (407, 'PQ. ARENAS', 120, 0);
INSERT INTO `parroquias` VALUES (408, 'PQ. ARICAGUA', 120, 0);
INSERT INTO `parroquias` VALUES (409, 'PQ. COCOLLAR', 120, 0);
INSERT INTO `parroquias` VALUES (410, 'PQ. SAN FERNANDO', 120, 0);
INSERT INTO `parroquias` VALUES (411, 'PQ. SAN LORENZO', 120, 0);
INSERT INTO `parroquias` VALUES (412, 'PQ. CARIACO', 121, 0);
INSERT INTO `parroquias` VALUES (413, 'PQ. CATUARO', 121, 0);
INSERT INTO `parroquias` VALUES (414, 'PQ. RENDON', 121, 0);
INSERT INTO `parroquias` VALUES (415, 'PQ. SANTA CRUZ', 121, 0);
INSERT INTO `parroquias` VALUES (416, 'PQ. SANTA MARIA', 121, 0);
INSERT INTO `parroquias` VALUES (417, 'PQ. ALTAGRACIA', 122, 0);
INSERT INTO `parroquias` VALUES (418, 'PQ. AYACUCHO', 122, 0);
INSERT INTO `parroquias` VALUES (419, 'PQ. SANTA INES', 122, 0);
INSERT INTO `parroquias` VALUES (420, 'PQ. VALENTIN VALIENTE', 122, 0);
INSERT INTO `parroquias` VALUES (421, 'PQ. SAN JUAN', 122, 0);
INSERT INTO `parroquias` VALUES (422, 'PQ.GRAN MARISCAL', 122, 0);
INSERT INTO `parroquias` VALUES (423, 'PQ. RAUL LEONI', 122, 0);
INSERT INTO `parroquias` VALUES (424, 'CM. COLON', 123, 0);
INSERT INTO `parroquias` VALUES (425, 'PQ. RIVAS BERTI', 123, 0);
INSERT INTO `parroquias` VALUES (426, 'PQ. SAN PEDRO DEL RIO', 123, 0);
INSERT INTO `parroquias` VALUES (427, 'CM. STA. ANA  DEL TACHIRA', 124, 0);
INSERT INTO `parroquias` VALUES (428, 'CM. LA FRIA', 125, 0);
INSERT INTO `parroquias` VALUES (429, 'PQ. BOCA DE GRITA', 125, 0);
INSERT INTO `parroquias` VALUES (430, 'PQ. JOSE ANTONIO PAEZ', 125, 0);
INSERT INTO `parroquias` VALUES (431, 'CM. PALMIRA', 126, 0);
INSERT INTO `parroquias` VALUES (432, 'CM. MICHELENA', 127, 0);
INSERT INTO `parroquias` VALUES (433, 'CM. ABEJALES', 128, 0);
INSERT INTO `parroquias` VALUES (434, 'PQ. SAN JOAQUIN DE NAVAY', 128, 0);
INSERT INTO `parroquias` VALUES (435, 'PQ. DORADAS', 128, 0);
INSERT INTO `parroquias` VALUES (436, 'PQ. EMETERIO OCHOA', 128, 0);
INSERT INTO `parroquias` VALUES (437, 'CM. COLONCITO', 129, 0);
INSERT INTO `parroquias` VALUES (438, 'PQ. LA PALMITA', 129, 0);
INSERT INTO `parroquias` VALUES (439, 'CM. URE#A', 130, 0);
INSERT INTO `parroquias` VALUES (440, 'PQ. NUEVA ARCADIA', 130, 0);
INSERT INTO `parroquias` VALUES (441, 'CM. QUENIQUEA', 131, 0);
INSERT INTO `parroquias` VALUES (442, 'PQ. SAN PABLO', 131, 0);
INSERT INTO `parroquias` VALUES (443, 'PQ.ELEAZAR LOPEZ CONTRERA', 131, 0);
INSERT INTO `parroquias` VALUES (444, 'CM. CORDERO', 132, 0);
INSERT INTO `parroquias` VALUES (445, 'CM.SAN RAFAEL DEL PINAL', 133, 0);
INSERT INTO `parroquias` VALUES (446, 'PQ. SANTO DOMINGO', 133, 0);
INSERT INTO `parroquias` VALUES (447, 'PQ. ALBERTO ADRIANI', 133, 0);
INSERT INTO `parroquias` VALUES (448, 'CM. SAN ANT DEL TACHIRA', 134, 0);
INSERT INTO `parroquias` VALUES (449, 'PQ. PALOTAL', 134, 0);
INSERT INTO `parroquias` VALUES (450, 'PQ. JUAN VICENTE GOMEZ', 134, 0);
INSERT INTO `parroquias` VALUES (451, 'PQ. ISAIAS MEDINA ANGARIT', 134, 0);
INSERT INTO `parroquias` VALUES (452, 'CM. CAPACHO VIEJO', 135, 0);
INSERT INTO `parroquias` VALUES (453, 'PQ. CIPRIANO CASTRO', 135, 0);
INSERT INTO `parroquias` VALUES (454, 'PQ. MANUEL FELIPE RUGELES', 135, 0);
INSERT INTO `parroquias` VALUES (455, 'CM. LA TENDIDA', 136, 0);
INSERT INTO `parroquias` VALUES (456, 'PQ. BOCONO', 136, 0);
INSERT INTO `parroquias` VALUES (457, 'PQ. HERNANDEZ', 136, 0);
INSERT INTO `parroquias` VALUES (458, 'CM. SEBORUCO', 137, 0);
INSERT INTO `parroquias` VALUES (459, 'CM. LAS MESAS', 138, 0);
INSERT INTO `parroquias` VALUES (460, 'CM. SAN JOSE DE BOLIVAR', 139, 0);
INSERT INTO `parroquias` VALUES (461, 'CM. EL COBRE', 140, 0);
INSERT INTO `parroquias` VALUES (462, 'CM. DELICIAS', 141, 0);
INSERT INTO `parroquias` VALUES (463, 'CM. SAN SIMON', 142, 0);
INSERT INTO `parroquias` VALUES (464, 'CM. SAN JOSECITO', 143, 0);
INSERT INTO `parroquias` VALUES (465, 'CM. UMUQUENA', 144, 0);
INSERT INTO `parroquias` VALUES (466, 'CM. CAPACHO NUEVO', 145, 0);
INSERT INTO `parroquias` VALUES (467, 'PQ. JUAN GERMAN ROSCIO', 145, 0);
INSERT INTO `parroquias` VALUES (468, 'PQ. ROMAN CARDENAS', 145, 0);
INSERT INTO `parroquias` VALUES (469, 'CM. TARIBA', 146, 0);
INSERT INTO `parroquias` VALUES (470, 'PQ. LA FLORIDA', 146, 0);
INSERT INTO `parroquias` VALUES (471, 'PQ. AMENODORO RANGEL LAMU', 146, 0);
INSERT INTO `parroquias` VALUES (472, 'CM. LA GRITA', 147, 0);
INSERT INTO `parroquias` VALUES (473, 'PQ. EMILIO C. GUERRERO', 147, 0);
INSERT INTO `parroquias` VALUES (474, 'PQ. MONS. MIGUEL A SALAS', 147, 0);
INSERT INTO `parroquias` VALUES (475, 'CM. RUBIO', 148, 0);
INSERT INTO `parroquias` VALUES (476, 'PQ. BRAMON', 148, 0);
INSERT INTO `parroquias` VALUES (477, 'PQ. LA PETROLEA', 148, 0);
INSERT INTO `parroquias` VALUES (478, 'PQ. QUINIMARI', 148, 0);
INSERT INTO `parroquias` VALUES (479, 'CM. LOBATERA', 149, 0);
INSERT INTO `parroquias` VALUES (480, 'PQ. CONSTITUCION', 149, 0);
INSERT INTO `parroquias` VALUES (481, 'PQ. LA CONCORDIA', 150, 0);
INSERT INTO `parroquias` VALUES (482, 'PQ. PEDRO MARIA MORANTES', 150, 0);
INSERT INTO `parroquias` VALUES (483, 'PQ. SN JUAN BAUTISTA', 150, 0);
INSERT INTO `parroquias` VALUES (484, 'PQ. SAN SEBASTIAN', 150, 0);
INSERT INTO `parroquias` VALUES (485, 'PQ. DR. FCO. ROMERO LOBO', 150, 0);
INSERT INTO `parroquias` VALUES (486, 'CM. PREGONERO', 151, 0);
INSERT INTO `parroquias` VALUES (487, 'PQ. CARDENAS', 151, 0);
INSERT INTO `parroquias` VALUES (488, 'PQ. POTOSI', 151, 0);
INSERT INTO `parroquias` VALUES (489, 'PQ. JUAN PABLO PE#ALOZA', 151, 0);
INSERT INTO `parroquias` VALUES (490, 'PQ. BETIJOQUE', 152, 0);
INSERT INTO `parroquias` VALUES (491, 'PQ. JOSE G HERNANDEZ', 152, 0);
INSERT INTO `parroquias` VALUES (492, 'PQ. LA PUEBLITA', 152, 0);
INSERT INTO `parroquias` VALUES (493, 'PQ. EL CEDRO', 152, 0);
INSERT INTO `parroquias` VALUES (494, 'PQ. MONTE CARMELO', 153, 0);
INSERT INTO `parroquias` VALUES (495, 'PQ. BUENA VISTA', 153, 0);
INSERT INTO `parroquias` VALUES (496, 'PQ. STA MARIA DEL HORCON', 153, 0);
INSERT INTO `parroquias` VALUES (497, 'PQ. MOTATAN', 154, 0);
INSERT INTO `parroquias` VALUES (498, 'PQ. EL BAÑO', 154, 0);
INSERT INTO `parroquias` VALUES (499, 'PQ. JALISCO', 154, 0);
INSERT INTO `parroquias` VALUES (500, 'PQ. PAMPAN', 155, 0);
INSERT INTO `parroquias` VALUES (501, 'PQ. SANTA ANA', 155, 0);
INSERT INTO `parroquias` VALUES (502, 'PQ. LA PAZ', 155, 0);
INSERT INTO `parroquias` VALUES (503, 'PQ. FLOR DE PATRIA', 155, 0);
INSERT INTO `parroquias` VALUES (504, 'PQ. CARVAJAL', 156, 0);
INSERT INTO `parroquias` VALUES (505, 'PQ. ANTONIO N BRICEñO', 156, 0);
INSERT INTO `parroquias` VALUES (506, 'PQ. CAMPO ALEGRE', 156, 0);
INSERT INTO `parroquias` VALUES (507, 'PQ. JOSE LEONARDO SUAREZ', 156, 0);
INSERT INTO `parroquias` VALUES (508, 'PQ. SABANA DE MENDOZA', 157, 0);
INSERT INTO `parroquias` VALUES (509, 'PQ. JUNIN', 157, 0);
INSERT INTO `parroquias` VALUES (510, 'PQ. VALMORE RODRIGUEZ', 157, 0);
INSERT INTO `parroquias` VALUES (511, 'PQ. EL PARAISO', 157, 0);
INSERT INTO `parroquias` VALUES (512, 'PQ. SANTA ISABEL', 158, 2731);
INSERT INTO `parroquias` VALUES (513, 'PQ. ARAGUANEY', 158, 851);
INSERT INTO `parroquias` VALUES (514, 'PQ. EL JAGUITO', 158, 1784);
INSERT INTO `parroquias` VALUES (515, 'PQ. LA ESPERANZA', 158, 1684);
INSERT INTO `parroquias` VALUES (516, 'PQ. SABANA GRANDE', 159, 3252);
INSERT INTO `parroquias` VALUES (517, 'PQ. CHEREGUE', 159, 2055);
INSERT INTO `parroquias` VALUES (518, 'PQ. GRANADOS', 159, 0);
INSERT INTO `parroquias` VALUES (519, 'PQ. EL SOCORRO', 160, 0);
INSERT INTO `parroquias` VALUES (520, 'PQ. LOS CAPRICHOS', 160, 0);
INSERT INTO `parroquias` VALUES (521, 'PQ. ANTONIO JOSE DE SUCRE', 160, 0);
INSERT INTO `parroquias` VALUES (522, 'PQ. CAMPO ELIAS', 161, 0);
INSERT INTO `parroquias` VALUES (523, 'PQ. ARNOLDO GABALDON', 161, 0);
INSERT INTO `parroquias` VALUES (524, 'PQ. SANTA APOLONIA', 162, 0);
INSERT INTO `parroquias` VALUES (525, 'PQ. LA CEIBA', 162, 0);
INSERT INTO `parroquias` VALUES (526, 'PQ. EL PROGRESO', 162, 0);
INSERT INTO `parroquias` VALUES (527, 'PQ. TRES DE FEBRERO', 162, 0);
INSERT INTO `parroquias` VALUES (528, 'PQ. BOCONÓ', 163, 0);
INSERT INTO `parroquias` VALUES (529, 'PQ. SAN MIGUEL', 163, 0);
INSERT INTO `parroquias` VALUES (530, 'PQ. GUARAMACAL', 163, 0);
INSERT INTO `parroquias` VALUES (531, 'PQ. LA VEGA DE GUARAMACAL', 163, 0);
INSERT INTO `parroquias` VALUES (532, 'PQ. EL CARMEN', 163, 0);
INSERT INTO `parroquias` VALUES (533, 'PQ. MOSQUEY', 163, 0);
INSERT INTO `parroquias` VALUES (534, 'PQ. AYACUCHO', 163, 0);
INSERT INTO `parroquias` VALUES (535, 'PQ. BURBUSAY', 163, 0);
INSERT INTO `parroquias` VALUES (536, 'PQ. GENERAL RIVAS', 163, 0);
INSERT INTO `parroquias` VALUES (537, 'PQ. MONSEñOR JAUREGUI', 163, 0);
INSERT INTO `parroquias` VALUES (538, 'PQ. RAFAEL RANGEL', 163, 0);
INSERT INTO `parroquias` VALUES (539, 'PQ. SAN JOSE', 163, 0);
INSERT INTO `parroquias` VALUES (540, 'PQ. PAMPANITO', 164, 0);
INSERT INTO `parroquias` VALUES (541, 'PQ. PAMPANITO II', 164, 0);
INSERT INTO `parroquias` VALUES (542, 'PQ. LA CONCEPCION', 164, 0);
INSERT INTO `parroquias` VALUES (543, 'PQ. CARACHE', 165, 0);
INSERT INTO `parroquias` VALUES (544, 'PQ. LA CONCEPCION', 165, 0);
INSERT INTO `parroquias` VALUES (545, 'PQ. CUICAS', 165, 0);
INSERT INTO `parroquias` VALUES (546, 'PQ. PANAMERICANA', 165, 0);
INSERT INTO `parroquias` VALUES (547, 'PQ. SANTA CRUZ', 165, 0);
INSERT INTO `parroquias` VALUES (548, 'PQ. ESCUQUE', 166, 0);
INSERT INTO `parroquias` VALUES (549, 'PQ. SABANA LIBRE', 166, 0);
INSERT INTO `parroquias` VALUES (550, 'PQ. LA UNION', 166, 0);
INSERT INTO `parroquias` VALUES (551, 'PQ. SANTA RITA', 166, 0);
INSERT INTO `parroquias` VALUES (552, 'PQ. CRISTOBAL MENDOZA', 167, 0);
INSERT INTO `parroquias` VALUES (553, 'PQ. CHIQUINQUIRA', 167, 0);
INSERT INTO `parroquias` VALUES (554, 'PQ. MATRIZ', 167, 0);
INSERT INTO `parroquias` VALUES (555, 'PQ. MONSEÑOR CARRILLO', 167, 0);
INSERT INTO `parroquias` VALUES (556, 'PQ. CRUZ CARRILLO', 167, 0);
INSERT INTO `parroquias` VALUES (557, 'PQ. ANDRES LINARES', 167, 0);
INSERT INTO `parroquias` VALUES (558, 'PQ. TRES ESQUINAS', 167, 0);
INSERT INTO `parroquias` VALUES (559, 'PQ. LA QUEBRADA', 168, 0);
INSERT INTO `parroquias` VALUES (560, 'PQ. JAJO', 168, 0);
INSERT INTO `parroquias` VALUES (561, 'PQ. LA MESA', 168, 0);
INSERT INTO `parroquias` VALUES (562, 'PQ. SANTIAGO', 168, 0);
INSERT INTO `parroquias` VALUES (563, 'PQ. CABIMBU', 168, 0);
INSERT INTO `parroquias` VALUES (564, 'PQ. TUñAME', 168, 0);
INSERT INTO `parroquias` VALUES (565, 'PQ. MERCEDES DIAZ', 169, 0);
INSERT INTO `parroquias` VALUES (566, 'PQ. JUAN IGNACIO MONTILLA', 169, 0);
INSERT INTO `parroquias` VALUES (567, 'PQ. LA BEATRIZ', 169, 0);
INSERT INTO `parroquias` VALUES (568, 'PQ. MENDOZA', 169, 0);
INSERT INTO `parroquias` VALUES (569, 'PQ. LA PUERTA', 169, 0);
INSERT INTO `parroquias` VALUES (570, 'PQ. SAN LUIS', 169, 0);
INSERT INTO `parroquias` VALUES (571, 'PQ. CHEJENDE', 170, 0);
INSERT INTO `parroquias` VALUES (572, 'PQ. CARRILLO', 170, 0);
INSERT INTO `parroquias` VALUES (573, 'PQ. CEGARRA', 170, 0);
INSERT INTO `parroquias` VALUES (574, 'PQ. BOLIVIA', 170, 0);
INSERT INTO `parroquias` VALUES (575, 'PQ. MANUEL SALVADOR ULLOA', 170, 0);
INSERT INTO `parroquias` VALUES (576, 'PQ. SAN JOSE', 170, 0);
INSERT INTO `parroquias` VALUES (577, 'PQ. ARNOLDO GABALDON', 170, 0);
INSERT INTO `parroquias` VALUES (578, 'PQ. EL DIVIDIVE', 171, 0);
INSERT INTO `parroquias` VALUES (579, 'PQ. AGUA CALIENTE', 171, 0);
INSERT INTO `parroquias` VALUES (580, 'PQ. EL CENIZO', 171, 0);
INSERT INTO `parroquias` VALUES (581, 'PQ. AGUA SANTA', 171, 0);
INSERT INTO `parroquias` VALUES (582, 'PQ. VALERITA', 171, 0);
INSERT INTO `parroquias` VALUES (583, 'PQ. ANACO', 172, 0);
INSERT INTO `parroquias` VALUES (584, 'PQ. SAN JOAQUIN', 172, 0);
INSERT INTO `parroquias` VALUES (585, 'CM. MAPIRE', 173, 0);
INSERT INTO `parroquias` VALUES (586, 'PQ. PIAR', 173, 0);
INSERT INTO `parroquias` VALUES (587, 'PQ. SN DIEGO DE CABRUTICA', 173, 0);
INSERT INTO `parroquias` VALUES (588, 'PQ. SANTA CLARA', 173, 0);
INSERT INTO `parroquias` VALUES (589, 'PQ. UVERITO', 173, 0);
INSERT INTO `parroquias` VALUES (590, 'PQ. ZUATA', 173, 0);
INSERT INTO `parroquias` VALUES (591, 'CM. PUERTO PIRITU', 174, 0);
INSERT INTO `parroquias` VALUES (592, 'PQ. SAN MIGUEL', 174, 0);
INSERT INTO `parroquias` VALUES (593, 'PQ. SUCRE', 174, 0);
INSERT INTO `parroquias` VALUES (594, 'CM. EL TIGRE', 175, 0);
INSERT INTO `parroquias` VALUES (595, 'PQ. POZUELOS', 176, 0);
INSERT INTO `parroquias` VALUES (596, 'CM PTO. LA CRUZ', 176, 0);
INSERT INTO `parroquias` VALUES (597, 'CM. SAN JOSE DE GUANIPA', 177, 0);
INSERT INTO `parroquias` VALUES (598, 'PQ. GUANTA', 178, 0);
INSERT INTO `parroquias` VALUES (599, 'PQ. CHORRERON', 178, 0);
INSERT INTO `parroquias` VALUES (600, 'PQ. PIRITU', 179, 0);
INSERT INTO `parroquias` VALUES (601, 'PQ. SAN FRANCISCO', 179, 0);
INSERT INTO `parroquias` VALUES (602, 'PQ. LECHERIAS', 180, 0);
INSERT INTO `parroquias` VALUES (603, 'PQ. EL MORRO', 180, 0);
INSERT INTO `parroquias` VALUES (604, 'PQ. VALLE GUANAPE', 181, 0);
INSERT INTO `parroquias` VALUES (605, 'PQ. SANTA BARBARA', 181, 0);
INSERT INTO `parroquias` VALUES (606, 'PQ. SANTA ANA', 182, 0);
INSERT INTO `parroquias` VALUES (607, 'PQ. PUEBLO NUEVO', 182, 0);
INSERT INTO `parroquias` VALUES (608, 'CM. ARAGUA DE BARCELONA', 183, 0);
INSERT INTO `parroquias` VALUES (609, 'PQ. CACHIPO', 183, 0);
INSERT INTO `parroquias` VALUES (610, 'PQ. EL CHAPARRO', 184, 0);
INSERT INTO `parroquias` VALUES (611, 'PQ.TOMAS ALFARO CALATRAVA', 184, 0);
INSERT INTO `parroquias` VALUES (612, 'PQ. BOCA UCHIRE', 185, 0);
INSERT INTO `parroquias` VALUES (613, 'PQ. BOCA DE CHAVEZ', 185, 0);
INSERT INTO `parroquias` VALUES (614, 'PQ. EL CARMEN', 186, 0);
INSERT INTO `parroquias` VALUES (615, 'PQ. SAN CRISTOBAL', 186, 0);
INSERT INTO `parroquias` VALUES (616, 'PQ. BERGANTIN', 186, 0);
INSERT INTO `parroquias` VALUES (617, 'PQ. CAIGUA', 186, 0);
INSERT INTO `parroquias` VALUES (618, 'PQ. EL PILAR', 186, 0);
INSERT INTO `parroquias` VALUES (619, 'PQ. NARICUAL', 186, 0);
INSERT INTO `parroquias` VALUES (620, 'CM. CLARINES', 187, 0);
INSERT INTO `parroquias` VALUES (621, 'PQ. GUANAPE', 187, 0);
INSERT INTO `parroquias` VALUES (622, 'PQ. SABANA DE UCHIRE', 187, 0);
INSERT INTO `parroquias` VALUES (623, 'CM. ONOTO', 188, 0);
INSERT INTO `parroquias` VALUES (624, 'PQ. SAN PABLO', 188, 0);
INSERT INTO `parroquias` VALUES (625, 'CM. CANTAURA', 189, 0);
INSERT INTO `parroquias` VALUES (626, 'PQ. LIBERTADOR', 189, 0);
INSERT INTO `parroquias` VALUES (627, 'PQ. SANTA ROSA', 189, 0);
INSERT INTO `parroquias` VALUES (628, 'PQ. URICA', 189, 0);
INSERT INTO `parroquias` VALUES (629, 'CM. SOLEDAD', 190, 0);
INSERT INTO `parroquias` VALUES (630, 'PQ. MAMO', 190, 0);
INSERT INTO `parroquias` VALUES (631, 'CM. SAN MATEO', 191, 0);
INSERT INTO `parroquias` VALUES (632, 'PQ. EL CARITO', 191, 0);
INSERT INTO `parroquias` VALUES (633, 'PQ. SANTA INES', 191, 0);
INSERT INTO `parroquias` VALUES (634, 'CM. PARIAGUAN', 192, 0);
INSERT INTO `parroquias` VALUES (635, 'PQ. ATAPIRIRE', 192, 0);
INSERT INTO `parroquias` VALUES (636, 'PQ. BOCA DEL PAO', 192, 0);
INSERT INTO `parroquias` VALUES (637, 'PQ. EL PAO', 192, 0);
INSERT INTO `parroquias` VALUES (638, 'CM. AROA', 193, 0);
INSERT INTO `parroquias` VALUES (639, 'CM. COCOROTE', 194, 0);
INSERT INTO `parroquias` VALUES (640, 'CM. INDEPENDENCIA', 195, 0);
INSERT INTO `parroquias` VALUES (641, 'CM. SAN PABLO', 196, 0);
INSERT INTO `parroquias` VALUES (642, 'CM. YUMARE', 197, 0);
INSERT INTO `parroquias` VALUES (643, 'CM. FARRIAR', 198, 0);
INSERT INTO `parroquias` VALUES (644, 'PQ. EL GUAYABO', 198, 0);
INSERT INTO `parroquias` VALUES (645, 'CM. CHIVACOA', 199, 0);
INSERT INTO `parroquias` VALUES (646, 'PQ. CAMPO ELIAS', 199, 0);
INSERT INTO `parroquias` VALUES (647, 'CM. NIRGUA', 200, 0);
INSERT INTO `parroquias` VALUES (648, 'PQ. SALOM', 200, 0);
INSERT INTO `parroquias` VALUES (649, 'PQ. TEMERLA', 200, 0);
INSERT INTO `parroquias` VALUES (650, 'CM. SAN FELIPE', 201, 0);
INSERT INTO `parroquias` VALUES (651, 'PQ. ALBARICO', 201, 0);
INSERT INTO `parroquias` VALUES (652, 'PQ. SAN JAVIER', 201, 0);
INSERT INTO `parroquias` VALUES (653, 'CM. GUAMA', 202, 0);
INSERT INTO `parroquias` VALUES (654, 'CM. URACHICHE', 203, 0);
INSERT INTO `parroquias` VALUES (655, 'CM. YARITAGUA', 204, 0);
INSERT INTO `parroquias` VALUES (656, 'PQ. SAN ANDRES', 204, 0);
INSERT INTO `parroquias` VALUES (657, 'CM. SABANA DE PARRA', 205, 0);
INSERT INTO `parroquias` VALUES (658, 'CM. BORAURE', 206, 0);
INSERT INTO `parroquias` VALUES (659, 'PQ. GENERAL URDANETA', 207, 0);
INSERT INTO `parroquias` VALUES (660, 'PQ. LIBERTADOR', 207, 0);
INSERT INTO `parroquias` VALUES (661, 'PQ. MANUEL GUANIPA MATOS', 207, 0);
INSERT INTO `parroquias` VALUES (662, 'PQ. MARCELINO BRICE#O', 207, 0);
INSERT INTO `parroquias` VALUES (663, 'PQ. SAN TIMOTEO', 207, 0);
INSERT INTO `parroquias` VALUES (664, 'PQ. PUEBLO NUEVO', 207, 0);
INSERT INTO `parroquias` VALUES (665, 'PQ. ANDRES BELLO (KM 48)', 208, 0);
INSERT INTO `parroquias` VALUES (666, 'PQ. POTRERITOS', 208, 0);
INSERT INTO `parroquias` VALUES (667, 'PQ. EL CARMELO', 208, 0);
INSERT INTO `parroquias` VALUES (668, 'PQ. CHIQUINQUIRA', 208, 0);
INSERT INTO `parroquias` VALUES (669, 'PQ. CONCEPCION', 208, 0);
INSERT INTO `parroquias` VALUES (670, 'PQ. ELEAZAR LOPEZ C', 209, 0);
INSERT INTO `parroquias` VALUES (671, 'PQ. ALONSO DE OJEDA', 209, 0);
INSERT INTO `parroquias` VALUES (672, 'PQ. VENEZUELA', 209, 0);
INSERT INTO `parroquias` VALUES (673, 'PQ. CAMPO LARA', 209, 0);
INSERT INTO `parroquias` VALUES (674, 'PQ. LIBERTAD', 209, 0);
INSERT INTO `parroquias` VALUES (675, 'PQ. UDON PEREZ', 210, 0);
INSERT INTO `parroquias` VALUES (676, 'PQ. ENCONTRADOS', 210, 0);
INSERT INTO `parroquias` VALUES (677, 'PQ. DONALDO GARCIA', 211, 0);
INSERT INTO `parroquias` VALUES (678, 'PQ. SIXTO ZAMBRANO', 211, 0);
INSERT INTO `parroquias` VALUES (679, 'PQ. EL ROSARIO', 211, 0);
INSERT INTO `parroquias` VALUES (680, 'PQ. AMBROSIO', 212, 0);
INSERT INTO `parroquias` VALUES (681, 'PQ. GERMAN RIOS LINARES', 212, 0);
INSERT INTO `parroquias` VALUES (682, 'PQ. JORGE HERNANDEZ', 212, 0);
INSERT INTO `parroquias` VALUES (683, 'PQ. LA ROSA', 212, 0);
INSERT INTO `parroquias` VALUES (684, 'PQ. PUNTA GORDA', 212, 0);
INSERT INTO `parroquias` VALUES (685, 'PQ. CARMEN HERRERA', 212, 0);
INSERT INTO `parroquias` VALUES (686, 'PQ. SAN BENITO', 212, 0);
INSERT INTO `parroquias` VALUES (687, 'PQ. ROMULO BETANCOURT', 212, 0);
INSERT INTO `parroquias` VALUES (688, 'PQ. ARISTIDES CALVANI', 212, 0);
INSERT INTO `parroquias` VALUES (689, 'PQ. RAUL CUENCA', 213, 0);
INSERT INTO `parroquias` VALUES (690, 'PQ. LA VICTORIA', 213, 0);
INSERT INTO `parroquias` VALUES (691, 'PQ. RAFAEL URDANETA', 213, 0);
INSERT INTO `parroquias` VALUES (692, 'PQ. JOSE RAMON YEPEZ', 214, 0);
INSERT INTO `parroquias` VALUES (693, 'PQ. LA CONCEPCION', 214, 0);
INSERT INTO `parroquias` VALUES (694, 'PQ. SAN JOSE', 214, 0);
INSERT INTO `parroquias` VALUES (695, 'PQ. MARIANO PARRA LEON', 214, 0);
INSERT INTO `parroquias` VALUES (696, 'PQ. MONAGAS', 215, 0);
INSERT INTO `parroquias` VALUES (697, 'PQ. ISLA DE TOAS', 215, 0);
INSERT INTO `parroquias` VALUES (698, 'PQ. MARCIAL HERNANDEZ', 216, 0);
INSERT INTO `parroquias` VALUES (699, 'PQ. FRANCISCO OCHOA', 216, 0);
INSERT INTO `parroquias` VALUES (700, 'PQ. SAN FRANCISCO', 216, 0);
INSERT INTO `parroquias` VALUES (701, 'PQ. EL BAJO', 216, 0);
INSERT INTO `parroquias` VALUES (702, 'PQ. DOMITILA FLORES', 216, 0);
INSERT INTO `parroquias` VALUES (703, 'PQ. LOS CORTIJOS', 216, 0);
INSERT INTO `parroquias` VALUES (704, 'PQ. BARI', 217, 0);
INSERT INTO `parroquias` VALUES (705, 'PQ. JESUS M SEMPRUN', 217, 0);
INSERT INTO `parroquias` VALUES (706, 'PQ. PEDRO LUCAS URRIBARRI', 218, 0);
INSERT INTO `parroquias` VALUES (707, 'PQ. SANTA RITA', 218, 0);
INSERT INTO `parroquias` VALUES (708, 'PQ. JOSE CENOVIO URRIBARR', 218, 0);
INSERT INTO `parroquias` VALUES (709, 'PQ. EL MENE', 218, 0);
INSERT INTO `parroquias` VALUES (710, 'PQ. SIMON RODRIGUEZ', 219, 0);
INSERT INTO `parroquias` VALUES (711, 'PQ. CARLOS QUEVEDO', 219, 0);
INSERT INTO `parroquias` VALUES (712, 'PQ. FRANCISCO J PULGAR', 219, 0);
INSERT INTO `parroquias` VALUES (713, 'PQ. RAFAEL MARIA BARALT', 220, 0);
INSERT INTO `parroquias` VALUES (714, 'PQ. MANUEL MANRIQUE', 220, 0);
INSERT INTO `parroquias` VALUES (715, 'PQ. RAFAEL URDANETA', 220, 0);
INSERT INTO `parroquias` VALUES (716, 'PQ. SANTA CRUZ DEL ZULIA', 221, 0);
INSERT INTO `parroquias` VALUES (717, 'PQ. URRIBARRI', 221, 0);
INSERT INTO `parroquias` VALUES (718, 'PQ. MORALITO', 221, 0);
INSERT INTO `parroquias` VALUES (719, 'PQ. SAN CARLOS DEL ZULIA', 221, 0);
INSERT INTO `parroquias` VALUES (720, 'PQ. SANTA BARBARA', 221, 0);
INSERT INTO `parroquias` VALUES (721, 'PQ. LUIS DE VICENTE', 222, 0);
INSERT INTO `parroquias` VALUES (722, 'PQ. RICAURTE', 222, 0);
INSERT INTO `parroquias` VALUES (723, 'PQ. MONS.MARCOS SERGIO G', 222, 0);
INSERT INTO `parroquias` VALUES (724, 'PQ. SAN RAFAEL', 222, 0);
INSERT INTO `parroquias` VALUES (725, 'PQ. LAS PARCELAS', 222, 0);
INSERT INTO `parroquias` VALUES (726, 'PQ. TAMARE', 222, 0);
INSERT INTO `parroquias` VALUES (727, 'PQ. LA SIERRITA', 222, 0);
INSERT INTO `parroquias` VALUES (728, 'PQ. BOLIVAR', 223, 0);
INSERT INTO `parroquias` VALUES (729, 'PQ. CACIQUE MARA', 223, 0);
INSERT INTO `parroquias` VALUES (730, 'PQ. CECILIO ACOSTA', 223, 0);
INSERT INTO `parroquias` VALUES (731, 'PQ. RAUL LEONI', 223, 0);
INSERT INTO `parroquias` VALUES (732, 'PQ. FRANCISCO EUGENIO B', 223, 0);
INSERT INTO `parroquias` VALUES (733, 'PQ. MANUEL DAGNINO', 223, 0);
INSERT INTO `parroquias` VALUES (734, 'PQ. LUIS HURTADO HIGUERA', 223, 0);
INSERT INTO `parroquias` VALUES (735, 'PQ. VENANCIO PULGAR', 223, 0);
INSERT INTO `parroquias` VALUES (736, 'PQ. ANTONIO BORJAS ROMERO', 223, 0);
INSERT INTO `parroquias` VALUES (737, 'PQ. SAN ISIDRO', 223, 0);
INSERT INTO `parroquias` VALUES (738, 'PQ. COQUIVACOA', 223, 0);
INSERT INTO `parroquias` VALUES (739, 'PQ. CRISTO DE ARANZA', 223, 0);
INSERT INTO `parroquias` VALUES (740, 'PQ. CHIQUINQUIRA', 223, 0);
INSERT INTO `parroquias` VALUES (741, 'PQ. SANTA LUCIA', 223, 0);
INSERT INTO `parroquias` VALUES (742, 'PQ. OLEGARIO VILLALOBOS', 223, 0);
INSERT INTO `parroquias` VALUES (743, 'PQ. JUANA DE AVILA', 223, 0);
INSERT INTO `parroquias` VALUES (744, 'PQ.CARACCIOLO PARRA PEREZ', 223, 0);
INSERT INTO `parroquias` VALUES (745, 'PQ. IDELFONZO VASQUEZ', 223, 0);
INSERT INTO `parroquias` VALUES (746, 'PQ. FARIA', 224, 0);
INSERT INTO `parroquias` VALUES (747, 'PQ. SAN ANTONIO', 224, 0);
INSERT INTO `parroquias` VALUES (748, 'PQ. ANA MARIA CAMPOS', 224, 0);
INSERT INTO `parroquias` VALUES (749, 'PQ. SAN JOSE', 224, 0);
INSERT INTO `parroquias` VALUES (750, 'PQ. ALTAGRACIA', 224, 0);
INSERT INTO `parroquias` VALUES (751, 'PQ. GOAJIRA', 225, 0);
INSERT INTO `parroquias` VALUES (752, 'PQ. ELIAS SANCHEZ RUBIO', 225, 0);
INSERT INTO `parroquias` VALUES (753, 'PQ. SINAMAICA', 225, 0);
INSERT INTO `parroquias` VALUES (754, 'PQ. ALTA GUAJIRA', 225, 0);
INSERT INTO `parroquias` VALUES (755, 'PQ. SAN JOSE DE PERIJA', 226, 0);
INSERT INTO `parroquias` VALUES (756, 'PQ.BARTOLOME DE LAS CASAS', 226, 0);
INSERT INTO `parroquias` VALUES (757, 'PQ. LIBERTAD', 226, 0);
INSERT INTO `parroquias` VALUES (758, 'PQ. RIO NEGRO', 226, 0);
INSERT INTO `parroquias` VALUES (759, 'PQ. GIBRALTAR', 227, 0);
INSERT INTO `parroquias` VALUES (760, 'PQ. HERAS', 227, 0);
INSERT INTO `parroquias` VALUES (761, 'PQ. M.ARTURO CELESTINO A', 227, 0);
INSERT INTO `parroquias` VALUES (762, 'PQ. ROMULO GALLEGOS', 227, 0);
INSERT INTO `parroquias` VALUES (763, 'PQ. BOBURES', 227, 0);
INSERT INTO `parroquias` VALUES (764, 'PQ. EL BATEY', 227, 0);
INSERT INTO `parroquias` VALUES (765, 'PQ. FERNANDO GIRON TOVAR', 228, 0);
INSERT INTO `parroquias` VALUES (766, 'PQ. LUIS ALBERTO GOMEZ', 228, 0);
INSERT INTO `parroquias` VALUES (767, 'PQ. PARHUE#A', 228, 0);
INSERT INTO `parroquias` VALUES (768, 'PQ. PLATANILLAL', 228, 0);
INSERT INTO `parroquias` VALUES (769, 'CM. SAN FERNANDO DE ATABA', 229, 0);
INSERT INTO `parroquias` VALUES (770, 'PQ. UCATA', 229, 0);
INSERT INTO `parroquias` VALUES (771, 'PQ. YAPACANA', 229, 0);
INSERT INTO `parroquias` VALUES (772, 'PQ. CANAME', 229, 0);
INSERT INTO `parroquias` VALUES (773, 'CM. MAROA', 230, 0);
INSERT INTO `parroquias` VALUES (774, 'PQ. VICTORINO', 230, 0);
INSERT INTO `parroquias` VALUES (775, 'PQ. COMUNIDAD', 230, 0);
INSERT INTO `parroquias` VALUES (776, 'CM. SAN CARLOS DE RIO NEG', 231, 0);
INSERT INTO `parroquias` VALUES (777, 'PQ. SOLANO', 231, 0);
INSERT INTO `parroquias` VALUES (778, 'PQ. COCUY', 231, 0);
INSERT INTO `parroquias` VALUES (779, 'CM. ISLA DE RATON', 232, 0);
INSERT INTO `parroquias` VALUES (780, 'PQ. SAMARIAPO', 232, 0);
INSERT INTO `parroquias` VALUES (781, 'PQ. SIPAPO', 232, 0);
INSERT INTO `parroquias` VALUES (782, 'PQ. MUNDUAPO', 232, 0);
INSERT INTO `parroquias` VALUES (783, 'PQ. GUAYAPO', 232, 0);
INSERT INTO `parroquias` VALUES (784, 'CM. SAN JUAN DE MANAPIARE', 233, 0);
INSERT INTO `parroquias` VALUES (785, 'PQ. ALTO VENTUARI', 233, 0);
INSERT INTO `parroquias` VALUES (786, 'PQ. MEDIO VENTUARI', 233, 0);
INSERT INTO `parroquias` VALUES (787, 'PQ. BAJO VENTUARI', 233, 0);
INSERT INTO `parroquias` VALUES (788, 'CM. LA ESMERALDA', 234, 0);
INSERT INTO `parroquias` VALUES (789, 'PQ. HUACHAMACARE', 234, 0);
INSERT INTO `parroquias` VALUES (790, 'PQ. MARAWAKA', 234, 0);
INSERT INTO `parroquias` VALUES (791, 'PQ. MAVACA', 234, 0);
INSERT INTO `parroquias` VALUES (792, 'PQ. SIERRA PARIMA', 234, 0);
INSERT INTO `parroquias` VALUES (793, 'PQ. SAN JOSE', 235, 0);
INSERT INTO `parroquias` VALUES (794, 'PQ. VIRGEN DEL VALLE', 235, 0);
INSERT INTO `parroquias` VALUES (795, 'PQ. SAN RAFAEL', 235, 0);
INSERT INTO `parroquias` VALUES (796, 'PQ. JOSE VIDAL MARCANO', 235, 0);
INSERT INTO `parroquias` VALUES (797, 'PQ. LEONARDO RUIZ PINEDA', 235, 0);
INSERT INTO `parroquias` VALUES (798, 'PQ. MONS. ARGIMIRO GARCIA', 235, 0);
INSERT INTO `parroquias` VALUES (799, 'PQ.MCL.ANTONIO J DE SUCRE', 235, 0);
INSERT INTO `parroquias` VALUES (800, 'PQ. JUAN MILLAN', 235, 0);
INSERT INTO `parroquias` VALUES (801, 'PQ. PEDERNALES', 236, 0);
INSERT INTO `parroquias` VALUES (802, 'PQ. LUIS B PRIETO FIGUERO', 236, 0);
INSERT INTO `parroquias` VALUES (803, 'PQ. CURIAPO', 237, 0);
INSERT INTO `parroquias` VALUES (804, 'PQ. SANTOS DE ABELGAS', 237, 0);
INSERT INTO `parroquias` VALUES (805, 'PQ. MANUEL RENAUD', 237, 0);
INSERT INTO `parroquias` VALUES (806, 'PQ. PADRE BARRAL', 237, 0);
INSERT INTO `parroquias` VALUES (807, 'PQ. ANICETO LUGO', 237, 0);
INSERT INTO `parroquias` VALUES (808, 'PQ. ALMIRANTE LUIS BRION', 237, 0);
INSERT INTO `parroquias` VALUES (809, 'PQ. IMATACA', 238, 0);
INSERT INTO `parroquias` VALUES (810, 'PQ. ROMULO GALLEGOS', 238, 0);
INSERT INTO `parroquias` VALUES (811, 'PQ. JUAN BAUTISTA ARISMEN', 238, 0);
INSERT INTO `parroquias` VALUES (812, 'PQ. MANUEL PIAR', 238, 0);
INSERT INTO `parroquias` VALUES (813, 'PQ. 5 DE JULIO', 238, 0);
INSERT INTO `parroquias` VALUES (814, 'PQ. CARABALLEDA', 239, 0);
INSERT INTO `parroquias` VALUES (815, 'PQ. PQ RAUL LEONI', 239, 0);
INSERT INTO `parroquias` VALUES (816, 'PQ. PQ CARLOS SOUBLETTE', 239, 0);
INSERT INTO `parroquias` VALUES (817, 'PQ. CARAYACA', 239, 0);
INSERT INTO `parroquias` VALUES (818, 'PQ. CARUAO', 239, 0);
INSERT INTO `parroquias` VALUES (819, 'PQ. CATIA LA MAR', 239, 0);
INSERT INTO `parroquias` VALUES (820, 'PQ. LA GUAIRA', 239, 0);
INSERT INTO `parroquias` VALUES (821, 'PQ. MACUTO', 239, 0);
INSERT INTO `parroquias` VALUES (822, 'PQ. MAIQUETIA', 239, 0);
INSERT INTO `parroquias` VALUES (823, 'PQ. NAIGUATA', 239, 0);
INSERT INTO `parroquias` VALUES (824, 'PQ. EL JUNKO', 239, 0);
INSERT INTO `parroquias` VALUES (825, 'PQ. ACHAGUAS', 240, 0);
INSERT INTO `parroquias` VALUES (826, 'PQ. APURITO', 240, 0);
INSERT INTO `parroquias` VALUES (827, 'PQ. EL YAGUAL', 240, 0);
INSERT INTO `parroquias` VALUES (828, 'PQ. GUACHARA', 240, 0);
INSERT INTO `parroquias` VALUES (829, 'PQ. MUCURITAS', 240, 0);
INSERT INTO `parroquias` VALUES (830, 'PQ. QUESERAS DEL MEDIO', 240, 0);
INSERT INTO `parroquias` VALUES (831, 'PQ. BRUZUAL', 241, 0);
INSERT INTO `parroquias` VALUES (832, 'PQ. MANTECAL', 241, 0);
INSERT INTO `parroquias` VALUES (833, 'PQ. QUINTERO', 241, 0);
INSERT INTO `parroquias` VALUES (834, 'PQ. SAN VICENTE', 241, 0);
INSERT INTO `parroquias` VALUES (835, 'PQ. RINCON HONDO', 241, 0);
INSERT INTO `parroquias` VALUES (836, 'PQ. GUASDUALITO', 242, 0);
INSERT INTO `parroquias` VALUES (837, 'PQ. ARAMENDI', 242, 0);
INSERT INTO `parroquias` VALUES (838, 'PQ. EL AMPARO', 242, 0);
INSERT INTO `parroquias` VALUES (839, 'PQ. SAN CAMILO', 242, 0);
INSERT INTO `parroquias` VALUES (840, 'PQ. URDANETA', 242, 0);
INSERT INTO `parroquias` VALUES (841, 'PQ. SAN JUAN DE PAYARA', 243, 0);
INSERT INTO `parroquias` VALUES (842, 'PQ. CODAZZI', 243, 0);
INSERT INTO `parroquias` VALUES (843, 'PQ. CUNAVICHE', 243, 0);
INSERT INTO `parroquias` VALUES (844, 'PQ. ELORZA', 244, 0);
INSERT INTO `parroquias` VALUES (845, 'PQ. LA TRINIDAD', 244, 0);
INSERT INTO `parroquias` VALUES (846, 'PQ. SAN FERNANDO', 245, 0);
INSERT INTO `parroquias` VALUES (847, 'PQ. PE#ALVER', 245, 0);
INSERT INTO `parroquias` VALUES (848, 'PQ. EL RECREO', 245, 0);
INSERT INTO `parroquias` VALUES (849, 'PQ. SN RAFAEL DE ATAMAICA', 245, 0);
INSERT INTO `parroquias` VALUES (850, 'PQ. BIRUACA', 246, 0);
INSERT INTO `parroquias` VALUES (851, 'CM. LAS DELICIAS', 247, 0);
INSERT INTO `parroquias` VALUES (852, 'PQ. CHORONI', 247, 0);
INSERT INTO `parroquias` VALUES (853, 'PQ. MADRE MA DE SAN JOSE', 247, 0);
INSERT INTO `parroquias` VALUES (854, 'PQ. JOAQUIN CRESPO', 247, 0);
INSERT INTO `parroquias` VALUES (855, 'PQ. PEDRO JOSE OVALLES', 247, 0);
INSERT INTO `parroquias` VALUES (856, 'PQ. JOSE CASANOVA GODOY', 247, 0);
INSERT INTO `parroquias` VALUES (857, 'PQ. ANDRES ELOY BLANCO', 247, 0);
INSERT INTO `parroquias` VALUES (858, 'PQ. LOS TACARIGUAS', 247, 0);
INSERT INTO `parroquias` VALUES (859, 'CM. SANTA CRUZ', 248, 0);
INSERT INTO `parroquias` VALUES (860, 'CM. SAN MATEO', 249, 0);
INSERT INTO `parroquias` VALUES (861, 'CM. LAS TEJERIAS', 250, 0);
INSERT INTO `parroquias` VALUES (862, 'PQ. TIARA', 250, 0);
INSERT INTO `parroquias` VALUES (863, 'CM. EL LIMON', 251, 0);
INSERT INTO `parroquias` VALUES (864, 'PQ. CA A DE AZUCAR', 251, 0);
INSERT INTO `parroquias` VALUES (865, 'CM. COLONIA TOVAR', 252, 0);
INSERT INTO `parroquias` VALUES (866, 'CM. CAMATAGUA', 253, 0);
INSERT INTO `parroquias` VALUES (867, 'PQ. CARMEN DE CURA', 253, 0);
INSERT INTO `parroquias` VALUES (868, 'CM. EL CONSEJO', 254, 0);
INSERT INTO `parroquias` VALUES (869, 'CM. SANTA RITA', 255, 0);
INSERT INTO `parroquias` VALUES (870, 'PQ. FRANCISCO DE MIRANDA', 255, 0);
INSERT INTO `parroquias` VALUES (871, 'PQ. MONS FELICIANO G', 255, 0);
INSERT INTO `parroquias` VALUES (872, 'PQ. OCUMARE DE LA COSTA', 256, 0);
INSERT INTO `parroquias` VALUES (873, 'CM. TURMERO', 257, 0);
INSERT INTO `parroquias` VALUES (874, 'PQ. SAMAN DE GUERE', 257, 0);
INSERT INTO `parroquias` VALUES (875, 'PQ. ALFREDO PACHECO M', 257, 0);
INSERT INTO `parroquias` VALUES (876, 'PQ. CHUAO', 257, 0);
INSERT INTO `parroquias` VALUES (877, 'PQ. AREVALO APONTE', 257, 0);
INSERT INTO `parroquias` VALUES (878, 'CM. LA VICTORIA', 258, 0);
INSERT INTO `parroquias` VALUES (879, 'PQ. ZUATA', 258, 0);
INSERT INTO `parroquias` VALUES (880, 'PQ. PAO DE ZARATE', 258, 0);
INSERT INTO `parroquias` VALUES (881, 'PQ. CASTOR NIEVES RIOS', 258, 0);
INSERT INTO `parroquias` VALUES (882, 'PQ. LAS GUACAMAYAS', 258, 0);
INSERT INTO `parroquias` VALUES (883, 'CM. SAN CASIMIRO', 259, 0);
INSERT INTO `parroquias` VALUES (884, 'PQ. VALLE MORIN', 259, 0);
INSERT INTO `parroquias` VALUES (885, 'PQ. GUIRIPA', 259, 0);
INSERT INTO `parroquias` VALUES (886, 'PQ. OLLAS DE CARAMACATE', 259, 0);
INSERT INTO `parroquias` VALUES (887, 'CM. SAN SEBASTIAN', 260, 0);
INSERT INTO `parroquias` VALUES (888, 'CM. CAGUA', 261, 0);
INSERT INTO `parroquias` VALUES (889, 'PQ. BELLA VISTA', 261, 0);
INSERT INTO `parroquias` VALUES (890, 'CM. BARBACOAS', 262, 0);
INSERT INTO `parroquias` VALUES (891, 'PQ. SAN FRANCISCO DE CARA', 262, 0);
INSERT INTO `parroquias` VALUES (892, 'PQ. TAGUAY', 262, 0);
INSERT INTO `parroquias` VALUES (893, 'PQ. LAS PE#ITAS', 262, 0);
INSERT INTO `parroquias` VALUES (894, 'CM. VILLA DE CURA', 263, 0);
INSERT INTO `parroquias` VALUES (895, 'PQ. MAGDALENO', 263, 0);
INSERT INTO `parroquias` VALUES (896, 'PQ. SAN FRANCISCO DE ASIS', 263, 0);
INSERT INTO `parroquias` VALUES (897, 'PQ. VALLES DE TUCUTUNEMO', 263, 0);
INSERT INTO `parroquias` VALUES (898, 'PQ. PQ AUGUSTO MIJARES', 263, 0);
INSERT INTO `parroquias` VALUES (899, 'CM. PALO NEGRO', 264, 0);
INSERT INTO `parroquias` VALUES (900, 'PQ. SAN MARTIN DE PORRES', 264, 0);
INSERT INTO `parroquias` VALUES (901, 'PQ. ARISMENDI', 265, 0);
INSERT INTO `parroquias` VALUES (902, 'PQ. GUADARRAMA', 265, 0);
INSERT INTO `parroquias` VALUES (903, 'PQ. LA UNION', 265, 0);
INSERT INTO `parroquias` VALUES (904, 'PQ. SAN ANTONIO', 265, 0);
INSERT INTO `parroquias` VALUES (905, 'PQ. TICOPORO', 266, 0);
INSERT INTO `parroquias` VALUES (906, 'PQ. NICOLAS PULIDO', 266, 0);
INSERT INTO `parroquias` VALUES (907, 'PQ. ANDRES BELLO', 266, 0);
INSERT INTO `parroquias` VALUES (908, 'PQ. BARRANCAS', 267, 0);
INSERT INTO `parroquias` VALUES (909, 'PQ. EL SOCORRO', 267, 0);
INSERT INTO `parroquias` VALUES (910, 'PQ. MASPARRITO', 267, 0);
INSERT INTO `parroquias` VALUES (911, 'PQ. EL CANTON', 268, 0);
INSERT INTO `parroquias` VALUES (912, 'PQ. SANTA CRUZ DE GUACAS', 268, 0);
INSERT INTO `parroquias` VALUES (913, 'PQ. PUERTO VIVAS', 268, 0);
INSERT INTO `parroquias` VALUES (914, 'PQ. ALFREDO A LARRIVA', 269, 0);
INSERT INTO `parroquias` VALUES (915, 'PQ. RAMON I MENDEZ', 269, 0);
INSERT INTO `parroquias` VALUES (916, 'PQ. ALTO BARINAS', 269, 0);
INSERT INTO `parroquias` VALUES (917, 'PQ. MANUEL P FAJARDO', 269, 0);
INSERT INTO `parroquias` VALUES (918, 'PQ. JUAN A RODRIGUEZ D', 269, 0);
INSERT INTO `parroquias` VALUES (919, 'PQ. DOMINGA ORTIZ P', 269, 0);
INSERT INTO `parroquias` VALUES (920, 'PQ. BARINAS', 269, 0);
INSERT INTO `parroquias` VALUES (921, 'PQ. SAN SILVESTRE', 269, 0);
INSERT INTO `parroquias` VALUES (922, 'PQ. SANTA INES', 269, 0);
INSERT INTO `parroquias` VALUES (923, 'PQ. SANTA LUCIA', 269, 0);
INSERT INTO `parroquias` VALUES (924, 'PQ. TORUNOS', 269, 0);
INSERT INTO `parroquias` VALUES (925, 'PQ. EL CARMEN', 269, 0);
INSERT INTO `parroquias` VALUES (926, 'PQ. ROMULO BETANCOURT', 269, 0);
INSERT INTO `parroquias` VALUES (927, 'PQ. CORAZON DE JESUS', 269, 0);
INSERT INTO `parroquias` VALUES (928, 'PQ. ALTAMIRA', 270, 0);
INSERT INTO `parroquias` VALUES (929, 'PQ. BARINITAS', 270, 0);
INSERT INTO `parroquias` VALUES (930, 'PQ. CALDERAS', 270, 0);
INSERT INTO `parroquias` VALUES (931, 'PQ. SANTA BARBARA', 271, 0);
INSERT INTO `parroquias` VALUES (932, 'PQ.JOSE IGNACIO DEL PUMAR', 271, 0);
INSERT INTO `parroquias` VALUES (933, 'PQ. RAMON IGNACIO MENDEZ', 271, 0);
INSERT INTO `parroquias` VALUES (934, 'PQ. PEDRO BRICE#O MENDEZ', 271, 0);
INSERT INTO `parroquias` VALUES (935, 'PQ. EL REAL', 272, 0);
INSERT INTO `parroquias` VALUES (936, 'PQ. LA LUZ', 272, 0);
INSERT INTO `parroquias` VALUES (937, 'PQ. OBISPOS', 272, 0);
INSERT INTO `parroquias` VALUES (938, 'PQ. LOS GUASIMITOS', 272, 0);
INSERT INTO `parroquias` VALUES (939, 'PQ. CIUDAD BOLIVIA', 273, 0);
INSERT INTO `parroquias` VALUES (940, 'PQ. IGNACIO BRICE#O', 273, 0);
INSERT INTO `parroquias` VALUES (941, 'PQ. PAEZ', 273, 0);
INSERT INTO `parroquias` VALUES (942, 'PQ. JOSE FELIX RIBAS', 273, 0);
INSERT INTO `parroquias` VALUES (943, 'PQ. DOLORES', 274, 0);
INSERT INTO `parroquias` VALUES (944, 'PQ. LIBERTAD', 274, 0);
INSERT INTO `parroquias` VALUES (945, 'PQ. PALACIO FAJARDO', 274, 0);
INSERT INTO `parroquias` VALUES (946, 'PQ. SANTA ROSA', 274, 0);
INSERT INTO `parroquias` VALUES (947, 'PQ. CIUDAD DE NUTRIAS', 275, 0);
INSERT INTO `parroquias` VALUES (948, 'PQ. EL REGALO', 275, 0);
INSERT INTO `parroquias` VALUES (949, 'PQ. PUERTO DE NUTRIAS', 275, 0);
INSERT INTO `parroquias` VALUES (950, 'PQ. SANTA CATALINA', 275, 0);
INSERT INTO `parroquias` VALUES (951, 'PQ. RODRIGUEZ DOMINGUEZ', 276, 0);
INSERT INTO `parroquias` VALUES (952, 'PQ. SABANETA', 276, 0);
INSERT INTO `parroquias` VALUES (953, 'PQ. SIMON BOLIVAR', 277, 0);
INSERT INTO `parroquias` VALUES (954, 'PQ. POZO VERDE', 277, 0);
INSERT INTO `parroquias` VALUES (955, 'PQ. ONCE DE ABRIL', 277, 0);
INSERT INTO `parroquias` VALUES (956, 'PQ. VISTA AL SOL', 277, 0);
INSERT INTO `parroquias` VALUES (957, 'PQ. CHIRICA', 277, 0);
INSERT INTO `parroquias` VALUES (958, 'PQ. DALLA COSTA', 277, 0);
INSERT INTO `parroquias` VALUES (959, 'PQ. CACHAMAY', 277, 0);
INSERT INTO `parroquias` VALUES (960, 'PQ. UNIVERSIDAD', 277, 0);
INSERT INTO `parroquias` VALUES (961, 'PQ. UNARE', 277, 0);
INSERT INTO `parroquias` VALUES (962, 'PQ. YOCOIMA', 277, 0);
INSERT INTO `parroquias` VALUES (963, 'CM. EL CALLAO', 278, 0);
INSERT INTO `parroquias` VALUES (964, 'CM. EL PALMAR', 279, 0);
INSERT INTO `parroquias` VALUES (965, 'CM. CAICARA DEL ORINOCO', 280, 0);
INSERT INTO `parroquias` VALUES (966, 'PQ. ASCENSION FARRERAS', 280, 0);
INSERT INTO `parroquias` VALUES (967, 'PQ. ALTAGRACIA', 280, 0);
INSERT INTO `parroquias` VALUES (968, 'PQ. LA URBANA', 280, 0);
INSERT INTO `parroquias` VALUES (969, 'PQ. GUANIAMO', 280, 0);
INSERT INTO `parroquias` VALUES (970, 'PQ. PIJIGUAOS', 280, 0);
INSERT INTO `parroquias` VALUES (971, 'PQ. CATEDRAL', 281, 0);
INSERT INTO `parroquias` VALUES (972, 'PQ. AGUA SALADA', 281, 0);
INSERT INTO `parroquias` VALUES (973, 'PQ. LA SABANITA', 281, 0);
INSERT INTO `parroquias` VALUES (974, 'PQ. VISTA HERMOSA', 281, 0);
INSERT INTO `parroquias` VALUES (975, 'PQ. MARHUANTA', 281, 0);
INSERT INTO `parroquias` VALUES (976, 'PQ. JOSE ANTONIO PAEZ', 281, 0);
INSERT INTO `parroquias` VALUES (977, 'PQ. ORINOCO', 281, 0);
INSERT INTO `parroquias` VALUES (978, 'PQ. PANAPANA', 281, 0);
INSERT INTO `parroquias` VALUES (979, 'PQ. ZEA', 281, 0);
INSERT INTO `parroquias` VALUES (980, 'CM. UPATA', 282, 0);
INSERT INTO `parroquias` VALUES (981, 'PQ. ANDRES ELOY BLANCO', 282, 0);
INSERT INTO `parroquias` VALUES (982, 'PQ. PEDRO COVA', 282, 0);
INSERT INTO `parroquias` VALUES (983, 'CM. GUASIPATI', 283, 0);
INSERT INTO `parroquias` VALUES (984, 'PQ. SALOM', 283, 0);
INSERT INTO `parroquias` VALUES (985, 'CM. MARIPA', 284, 0);
INSERT INTO `parroquias` VALUES (986, 'PQ. ARIPAO', 284, 0);
INSERT INTO `parroquias` VALUES (987, 'PQ. LAS MAJADAS', 284, 0);
INSERT INTO `parroquias` VALUES (988, 'PQ. MOITACO', 284, 0);
INSERT INTO `parroquias` VALUES (989, 'PQ. GUARATARO', 284, 0);
INSERT INTO `parroquias` VALUES (990, 'CM. TUMEREMO', 285, 0);
INSERT INTO `parroquias` VALUES (991, 'PQ. DALLA COSTA', 285, 0);
INSERT INTO `parroquias` VALUES (992, 'PQ. SAN ISIDRO', 285, 0);
INSERT INTO `parroquias` VALUES (993, 'CM. CIUDAD PIAR', 286, 0);
INSERT INTO `parroquias` VALUES (994, 'PQ. SAN FRANCISCO', 286, 0);
INSERT INTO `parroquias` VALUES (995, 'PQ. BARCELONETA', 286, 0);
INSERT INTO `parroquias` VALUES (996, 'PQ. SANTA BARBARA', 286, 0);
INSERT INTO `parroquias` VALUES (997, 'CM. SANTA ELENA DE UAIREN', 287, 0);
INSERT INTO `parroquias` VALUES (998, 'PQ. IKABARU', 287, 0);
INSERT INTO `parroquias` VALUES (999, 'PQ. BEJUMA', 288, 0);
INSERT INTO `parroquias` VALUES (1000, 'PQ. CANOABO', 288, 0);
INSERT INTO `parroquias` VALUES (1001, 'PQ. SIMON BOLIVAR', 288, 0);
INSERT INTO `parroquias` VALUES (1002, 'PQ. MIRANDA', 289, 0);
INSERT INTO `parroquias` VALUES (1003, 'PQ. U LOS GUAYOS', 290, 0);
INSERT INTO `parroquias` VALUES (1004, 'PQ. NAGUANAGUA', 291, 0);
INSERT INTO `parroquias` VALUES (1005, 'PQ. URB SAN DIEGO', 292, 0);
INSERT INTO `parroquias` VALUES (1006, 'PQ. U TOCUYITO', 293, 0);
INSERT INTO `parroquias` VALUES (1007, 'PQ. U INDEPENDENCIA', 293, 0);
INSERT INTO `parroquias` VALUES (1008, 'PQ. GUIGUE', 294, 0);
INSERT INTO `parroquias` VALUES (1009, 'PQ. BELEN', 294, 0);
INSERT INTO `parroquias` VALUES (1010, 'PQ. TACARIGUA', 294, 0);
INSERT INTO `parroquias` VALUES (1011, 'PQ. MARIARA', 295, 0);
INSERT INTO `parroquias` VALUES (1012, 'PQ. AGUAS CALIENTES', 295, 0);
INSERT INTO `parroquias` VALUES (1013, 'PQ. GUACARA', 296, 0);
INSERT INTO `parroquias` VALUES (1014, 'PQ. CIUDAD ALIANZA', 296, 0);
INSERT INTO `parroquias` VALUES (1015, 'PQ. YAGUA', 296, 0);
INSERT INTO `parroquias` VALUES (1016, 'PQ. MONTALBAN', 297, 0);
INSERT INTO `parroquias` VALUES (1017, 'PQ. MORON', 298, 0);
INSERT INTO `parroquias` VALUES (1018, 'PQ. URAMA', 298, 0);
INSERT INTO `parroquias` VALUES (1019, 'PQ. DEMOCRACIA', 299, 0);
INSERT INTO `parroquias` VALUES (1020, 'PQ. FRATERNIDAD', 299, 0);
INSERT INTO `parroquias` VALUES (1021, 'PQ. GOAIGOAZA', 299, 0);
INSERT INTO `parroquias` VALUES (1022, 'PQ. JUAN JOSE FLORES', 299, 0);
INSERT INTO `parroquias` VALUES (1023, 'PQ. BARTOLOME SALOM', 299, 0);
INSERT INTO `parroquias` VALUES (1024, 'PQ. UNION', 299, 0);
INSERT INTO `parroquias` VALUES (1025, 'PQ. BORBURATA', 299, 0);
INSERT INTO `parroquias` VALUES (1026, 'PQ. PATANEMO', 299, 0);
INSERT INTO `parroquias` VALUES (1027, 'PQ. SAN JOAQUIN', 300, 0);
INSERT INTO `parroquias` VALUES (1028, 'PQ. CANDELARIA', 301, 0);
INSERT INTO `parroquias` VALUES (1029, 'PQ. CATEDRAL', 301, 0);
INSERT INTO `parroquias` VALUES (1030, 'PQ. EL SOCORRO', 301, 0);
INSERT INTO `parroquias` VALUES (1031, 'PQ. MIGUEL PE#A', 301, 0);
INSERT INTO `parroquias` VALUES (1032, 'PQ. SAN BLAS', 301, 0);
INSERT INTO `parroquias` VALUES (1033, 'PQ. SAN JOSE', 301, 0);
INSERT INTO `parroquias` VALUES (1034, 'PQ. SANTA ROSA', 301, 0);
INSERT INTO `parroquias` VALUES (1035, 'PQ. RAFAEL URDANETA', 301, 0);
INSERT INTO `parroquias` VALUES (1036, 'PQ. NEGRO PRIMERO', 301, 0);
INSERT INTO `parroquias` VALUES (1037, 'PQ. COJEDES', 302, 0);
INSERT INTO `parroquias` VALUES (1038, 'PQ. JUAN DE MATA SUAREZ', 302, 0);
INSERT INTO `parroquias` VALUES (1039, 'PQ. TINAQUILLO', 303, 0);
INSERT INTO `parroquias` VALUES (1040, 'PQ. EL BAUL', 304, 0);
INSERT INTO `parroquias` VALUES (1041, 'PQ. SUCRE', 304, 0);
INSERT INTO `parroquias` VALUES (1042, 'PQ. EL PAO', 305, 0);
INSERT INTO `parroquias` VALUES (1043, 'PQ. LIBERTAD DE COJEDES', 306, 0);
INSERT INTO `parroquias` VALUES (1044, 'PQ. EL AMPARO', 306, 0);
INSERT INTO `parroquias` VALUES (1045, 'PQ. SAN CARLOS DE AUSTRIA', 307, 0);
INSERT INTO `parroquias` VALUES (1046, 'PQ. JUAN ANGEL BRAVO', 307, 0);
INSERT INTO `parroquias` VALUES (1047, 'PQ. MANUEL MANRIQUE', 307, 0);
INSERT INTO `parroquias` VALUES (1048, 'PQ. GRL/JEFE JOSE L SILVA', 308, 0);
INSERT INTO `parroquias` VALUES (1049, 'PQ. MACAPO', 309, 0);
INSERT INTO `parroquias` VALUES (1050, 'PQ. LA AGUADITA', 309, 0);
INSERT INTO `parroquias` VALUES (1051, 'PQ. ROMULO GALLEGOS', 310, 0);
INSERT INTO `parroquias` VALUES (1052, 'PQ. SAN JUAN DE LOS CAYOS', 311, 0);
INSERT INTO `parroquias` VALUES (1053, 'PQ. CAPADARE', 311, 0);
INSERT INTO `parroquias` VALUES (1054, 'PQ. LA PASTORA', 311, 0);
INSERT INTO `parroquias` VALUES (1055, 'PQ. LIBERTADOR', 311, 0);
INSERT INTO `parroquias` VALUES (1056, 'PQ. SAN ANTONIO', 312, 0);
INSERT INTO `parroquias` VALUES (1057, 'PQ. SAN GABRIEL', 312, 0);
INSERT INTO `parroquias` VALUES (1058, 'PQ. SANTA ANA', 312, 0);
INSERT INTO `parroquias` VALUES (1059, 'PQ. GUZMAN GUILLERMO', 312, 0);
INSERT INTO `parroquias` VALUES (1060, 'PQ. MITARE', 312, 0);
INSERT INTO `parroquias` VALUES (1061, 'PQ. SABANETA', 312, 0);
INSERT INTO `parroquias` VALUES (1062, 'PQ. RIO SECO', 312, 0);
INSERT INTO `parroquias` VALUES (1063, 'PQ. CABURE', 313, 0);
INSERT INTO `parroquias` VALUES (1064, 'PQ. CURIMAGUA', 313, 0);
INSERT INTO `parroquias` VALUES (1065, 'PQ. COLINA', 313, 0);
INSERT INTO `parroquias` VALUES (1066, 'PQ. TUCACAS', 314, 0);
INSERT INTO `parroquias` VALUES (1067, 'PQ. BOCA DE AROA', 314, 0);
INSERT INTO `parroquias` VALUES (1068, 'PQ. PUERTO CUMAREBO', 315, 0);
INSERT INTO `parroquias` VALUES (1069, 'PQ. LA CIENAGA', 315, 0);
INSERT INTO `parroquias` VALUES (1070, 'PQ. LA SOLEDAD', 315, 0);
INSERT INTO `parroquias` VALUES (1071, 'PQ. PUEBLO CUMAREBO', 315, 0);
INSERT INTO `parroquias` VALUES (1072, 'PQ. ZAZARIDA', 315, 0);
INSERT INTO `parroquias` VALUES (1073, 'CM. DABAJURO', 316, 0);
INSERT INTO `parroquias` VALUES (1074, 'PQ. CHICHIRIVICHE', 317, 0);
INSERT INTO `parroquias` VALUES (1075, 'PQ. BOCA DE TOCUYO', 317, 0);
INSERT INTO `parroquias` VALUES (1076, 'PQ. TOCUYO DE LA COSTA', 317, 0);
INSERT INTO `parroquias` VALUES (1077, 'PQ. LOS TAQUES', 318, 0);
INSERT INTO `parroquias` VALUES (1078, 'PQ. JUDIBANA', 318, 0);
INSERT INTO `parroquias` VALUES (1079, 'PQ. PIRITU', 319, 0);
INSERT INTO `parroquias` VALUES (1080, 'PQ. SAN JOSE DE LA COSTA', 319, 0);
INSERT INTO `parroquias` VALUES (1081, 'PQ. STA.CRUZ DE BUCARAL', 320, 0);
INSERT INTO `parroquias` VALUES (1082, 'PQ. EL CHARAL', 320, 0);
INSERT INTO `parroquias` VALUES (1083, 'PQ. LAS VEGAS DEL TUY', 320, 0);
INSERT INTO `parroquias` VALUES (1084, 'CM. MIRIMIRE', 321, 0);
INSERT INTO `parroquias` VALUES (1085, 'PQ. SAN LUIS', 322, 0);
INSERT INTO `parroquias` VALUES (1086, 'PQ. ARACUA', 322, 0);
INSERT INTO `parroquias` VALUES (1087, 'PQ. LA PE#A', 322, 0);
INSERT INTO `parroquias` VALUES (1088, 'PQ. JACURA', 323, 0);
INSERT INTO `parroquias` VALUES (1089, 'PQ. AGUA LINDA', 323, 0);
INSERT INTO `parroquias` VALUES (1090, 'PQ. ARAURIMA', 323, 0);
INSERT INTO `parroquias` VALUES (1091, 'CM. YARACAL', 324, 0);
INSERT INTO `parroquias` VALUES (1092, 'CM. PALMA SOLA', 325, 0);
INSERT INTO `parroquias` VALUES (1093, 'PQ. SUCRE', 326, 0);
INSERT INTO `parroquias` VALUES (1094, 'PQ. PECAYA', 326, 0);
INSERT INTO `parroquias` VALUES (1095, 'PQ. URUMACO', 327, 0);
INSERT INTO `parroquias` VALUES (1096, 'PQ. BRUZUAL', 327, 0);
INSERT INTO `parroquias` VALUES (1097, 'CM. TOCOPERO', 328, 0);
INSERT INTO `parroquias` VALUES (1098, 'PQ. CAPATARIDA', 329, 0);
INSERT INTO `parroquias` VALUES (1099, 'PQ. BOROJO', 329, 0);
INSERT INTO `parroquias` VALUES (1100, 'PQ. SEQUE', 329, 0);
INSERT INTO `parroquias` VALUES (1101, 'PQ. ZAZARIDA', 329, 0);
INSERT INTO `parroquias` VALUES (1102, 'PQ. BARIRO', 329, 0);
INSERT INTO `parroquias` VALUES (1103, 'PQ. GUAJIRO', 329, 0);
INSERT INTO `parroquias` VALUES (1104, 'PQ. NORTE', 330, 0);
INSERT INTO `parroquias` VALUES (1105, 'PQ. CARIRUBANA', 330, 0);
INSERT INTO `parroquias` VALUES (1106, 'PQ. PUNTA CARDON', 330, 0);
INSERT INTO `parroquias` VALUES (1107, 'PQ. SANTA ANA', 330, 0);
INSERT INTO `parroquias` VALUES (1108, 'PQ. LA VELA DE CORO', 331, 0);
INSERT INTO `parroquias` VALUES (1109, 'PQ. ACURIGUA', 331, 0);
INSERT INTO `parroquias` VALUES (1110, 'PQ. GUAIBACOA', 331, 0);
INSERT INTO `parroquias` VALUES (1111, 'PQ. MACORUCA', 331, 0);
INSERT INTO `parroquias` VALUES (1112, 'PQ. LAS CALDERAS', 331, 0);
INSERT INTO `parroquias` VALUES (1113, 'PQ. PEDREGAL', 332, 0);
INSERT INTO `parroquias` VALUES (1114, 'PQ. AGUA CLARA', 332, 0);
INSERT INTO `parroquias` VALUES (1115, 'PQ. AVARIA', 332, 0);
INSERT INTO `parroquias` VALUES (1116, 'PQ. PIEDRA GRANDE', 332, 0);
INSERT INTO `parroquias` VALUES (1117, 'PQ. PURURECHE', 332, 0);
INSERT INTO `parroquias` VALUES (1118, 'PQ. PUEBLO NUEVO', 333, 0);
INSERT INTO `parroquias` VALUES (1119, 'PQ. ADICORA', 333, 0);
INSERT INTO `parroquias` VALUES (1120, 'PQ. BARAIVED', 333, 0);
INSERT INTO `parroquias` VALUES (1121, 'PQ. BUENA VISTA', 333, 0);
INSERT INTO `parroquias` VALUES (1122, 'PQ. JADACAQUIVA', 333, 0);
INSERT INTO `parroquias` VALUES (1123, 'PQ. MORUY', 333, 0);
INSERT INTO `parroquias` VALUES (1124, 'PQ. EL VINCULO', 333, 0);
INSERT INTO `parroquias` VALUES (1125, 'PQ. EL HATO', 333, 0);
INSERT INTO `parroquias` VALUES (1126, 'PQ. ADAURE', 333, 0);
INSERT INTO `parroquias` VALUES (1127, 'PQ. CHURUGUARA', 334, 0);
INSERT INTO `parroquias` VALUES (1128, 'PQ. AGUA LARGA', 334, 0);
INSERT INTO `parroquias` VALUES (1129, 'PQ. INDEPENDENCIA', 334, 0);
INSERT INTO `parroquias` VALUES (1130, 'PQ. MAPARARI', 334, 0);
INSERT INTO `parroquias` VALUES (1131, 'PQ. EL PAUJI', 334, 0);
INSERT INTO `parroquias` VALUES (1132, 'PQ. MENE DE MAUROA', 335, 0);
INSERT INTO `parroquias` VALUES (1133, 'PQ. CASIGUA', 335, 0);
INSERT INTO `parroquias` VALUES (1134, 'PQ. SAN FELIX', 335, 0);

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Luis Gomez', 'admin@mail.com', NULL, '$2y$12$pNdXa6/Xo5KI6qUN7w9YEO5uQKEhQd9l55Jaf.ZxClYQcTn7l1uE.', NULL, '2025-03-24 15:11:22', '2025-03-26 16:37:29', 'Administrador');
INSERT INTO `users` VALUES (2, 'Marianny Ávila', 'marianny@mail.com', NULL, '$2y$12$GzXwguuTSD31AP5OCOdlwOM2BVZhFjUEiYo0cV2zgMpKgD9F3KAFO', NULL, '2025-03-26 16:40:09', '2025-03-26 16:40:09', 'Usuario');

SET FOREIGN_KEY_CHECKS = 1;
