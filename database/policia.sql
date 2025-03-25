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

 Date: 24/03/2025 20:28:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for formacion_policial
-- ----------------------------
DROP TABLE IF EXISTS `formacion_policial`;
CREATE TABLE `formacion_policial`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `formacion_policial_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of formacion_policial
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
-- Table structure for nombramientos_provisionales
-- ----------------------------
DROP TABLE IF EXISTS `nombramientos_provisionales`;
CREATE TABLE `nombramientos_provisionales`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `nombramientos_provisionales_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of nombramientos_provisionales
-- ----------------------------

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
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `documento_identidad`(`documento_identidad` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales
-- ----------------------------
INSERT INTO `oficiales` VALUES (1, '27306869', 'Luis Fernando Gómez', '2025-03-24', 'A+', 'M', '32', '42', '2025-03-24', 'Soltero', 'Municipio Trujillo, Parroquia 3 Esquinas, Urb. Bucare Casa Nro 07', '04165324125', 'luisfgb919@gmail.com', 'activo', '0001');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_academico
-- ----------------------------
INSERT INTO `oficiales_academico` VALUES (4, 1, 'Ingeniería', 'Universidad de los Andes', '2025-03-24', '2025-03-24', 'Descripcon', 'Civil');

-- ----------------------------
-- Table structure for oficiales_ascensos
-- ----------------------------
DROP TABLE IF EXISTS `oficiales_ascensos`;
CREATE TABLE `oficiales_ascensos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `oficiales_ascensos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_ascensos
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_documentos
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_familiares_documentos
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of oficiales_salud
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for reconocimientos
-- ----------------------------
DROP TABLE IF EXISTS `reconocimientos`;
CREATE TABLE `reconocimientos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `reconocimientos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `oficiales` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of reconocimientos
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
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Luis Gomez', 'admin@mail.com', NULL, '$2y$12$pNdXa6/Xo5KI6qUN7w9YEO5uQKEhQd9l55Jaf.ZxClYQcTn7l1uE.', NULL, '2025-03-24 15:11:22', '2025-03-24 15:11:22');

SET FOREIGN_KEY_CHECKS = 1;
