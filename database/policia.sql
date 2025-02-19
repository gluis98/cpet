/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : policia

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 19/02/2025 16:58:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ascensos
-- ----------------------------
DROP TABLE IF EXISTS `ascensos`;
CREATE TABLE `ascensos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `ascensos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ascensos
-- ----------------------------

-- ----------------------------
-- Table structure for cargos
-- ----------------------------
DROP TABLE IF EXISTS `cargos`;
CREATE TABLE `cargos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cargos
-- ----------------------------

-- ----------------------------
-- Table structure for cargos_desempeñados
-- ----------------------------
DROP TABLE IF EXISTS `cargos_desempeñados`;
CREATE TABLE `cargos_desempeñados`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `id_cargo` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  INDEX `id_cargo`(`id_cargo` ASC) USING BTREE,
  CONSTRAINT `cargos_desempeñados_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `cargos_desempeñados_ibfk_2` FOREIGN KEY (`id_cargo`) REFERENCES `cargos` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cargos_desempeñados
-- ----------------------------

-- ----------------------------
-- Table structure for documentos_familiares
-- ----------------------------
DROP TABLE IF EXISTS `documentos_familiares`;
CREATE TABLE `documentos_familiares`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `id_familiar` int NOT NULL,
  `tipo_documento` enum('Cédula de Identidad de los Padres','Partida de Nacimiento de los Padres','Acta de Matrimonio o Unión Estable de Hecho','Cédula de Identidad del Cónyuge','Partida de Nacimiento del Cónyuge','Foto Tamaño Carnet del Cónyuge','Partida de Nacimiento de los Hijos','Cédula de Identidad de los Hijos','Grupo Sanguíneo','Nivel Educativo y Grado Académico de los Hijos') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `archivo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  INDEX `id_familiar`(`id_familiar` ASC) USING BTREE,
  CONSTRAINT `documentos_familiares_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `documentos_familiares_ibfk_2` FOREIGN KEY (`id_familiar`) REFERENCES `familia` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of documentos_familiares
-- ----------------------------

-- ----------------------------
-- Table structure for documentos_ingreso
-- ----------------------------
DROP TABLE IF EXISTS `documentos_ingreso`;
CREATE TABLE `documentos_ingreso`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `tipo_documento` enum('Síntesis Curricular','Fondo Negro del Título de Bachiller','Copia del Título de Bachiller','Notas Certificadas de Bachiller','Copia y Fondo Negro de T.S.U, Licenciatura, Magíster, Especialidad y Doctorado','Reconocimientos y Diplomas Obtenidos','Copia de la Prueba de Conocimiento General','Antecedentes de Servicio (Si viene de otra institución)','Copia del Título si es ingresado de otra institución','Datos de las Pruebas Médicas, Psicológicas y Entrevista Personal','Constancia de la Fecha y Causa de la Baja del Cuerpo de Policía Anterior','Fechas de Ingreso y Egreso, Régimen Académico, Calificaciones y Especialidad Obtenida','Diploma Puesto en el Cuadro de Méritos','Observaciones','Causa o Motivo de Retiro') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `archivo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `documentos_ingreso_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of documentos_ingreso
-- ----------------------------

-- ----------------------------
-- Table structure for documentos_policias
-- ----------------------------
DROP TABLE IF EXISTS `documentos_policias`;
CREATE TABLE `documentos_policias`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `tipo_documento` enum('Cedula de Identidad','Partida de Nacimiento','Carta de Residencia','Registro de Información Fiscal (RIF)','Referencia Personal 1','Referencia Personal 2','Inscripción en el CNE','Referencia Bancaria','Foto Tipo Carnet 1','Foto Tipo Carnet 2','Foto Cuerpo Completo Fondo Rojo','Tipo de Sangre','Tallas de Uniforme y Calzado','Carnet Laboral') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `archivo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_subida` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `documentos_policias_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of documentos_policias
-- ----------------------------

-- ----------------------------
-- Table structure for emergencias
-- ----------------------------
DROP TABLE IF EXISTS `emergencias`;
CREATE TABLE `emergencias`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NULL DEFAULT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `relacion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `emergencias_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of emergencias
-- ----------------------------

-- ----------------------------
-- Table structure for familia
-- ----------------------------
DROP TABLE IF EXISTS `familia`;
CREATE TABLE `familia`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NULL DEFAULT NULL,
  `nombre_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `parentesco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `familia_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of familia
-- ----------------------------

-- ----------------------------
-- Table structure for felicitaciones
-- ----------------------------
DROP TABLE IF EXISTS `felicitaciones`;
CREATE TABLE `felicitaciones`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `autoridad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `felicitaciones_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of felicitaciones
-- ----------------------------

-- ----------------------------
-- Table structure for formacion_academica
-- ----------------------------
DROP TABLE IF EXISTS `formacion_academica`;
CREATE TABLE `formacion_academica`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `tipo_formacion` enum('Técnico Superior Universitario','Licenciatura','Especialización','Maestría','Doctorado','Pos-doctorado') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `institucion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `formacion_academica_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of formacion_academica
-- ----------------------------

-- ----------------------------
-- Table structure for formacion_continua
-- ----------------------------
DROP TABLE IF EXISTS `formacion_continua`;
CREATE TABLE `formacion_continua`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `tipo_formacion` enum('Diplomado','Curso') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre_formacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `institucion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `formacion_continua_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of formacion_continua
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
  CONSTRAINT `formacion_policial_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of formacion_policial
-- ----------------------------

-- ----------------------------
-- Table structure for medica
-- ----------------------------
DROP TABLE IF EXISTS `medica`;
CREATE TABLE `medica`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NULL DEFAULT NULL,
  `tipo_sangre` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alergias` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `condiciones_preexistentes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `fecha_revision` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `medica_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of medica
-- ----------------------------

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
  CONSTRAINT `nombramientos_provisionales_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of nombramientos_provisionales
-- ----------------------------

-- ----------------------------
-- Table structure for policias
-- ----------------------------
DROP TABLE IF EXISTS `policias`;
CREATE TABLE `policias`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `tipo_sangre` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `talla_ropa` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fotografia` blob NULL,
  `fecha_ingreso` date NOT NULL,
  `puesto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `estado_civil` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `correo_electronico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `documento_identidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `estatus` enum('activo','inactivo') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT 'activo',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `documento_identidad`(`documento_identidad` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of policias
-- ----------------------------

-- ----------------------------
-- Table structure for rangos_alcanzados
-- ----------------------------
DROP TABLE IF EXISTS `rangos_alcanzados`;
CREATE TABLE `rangos_alcanzados`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_policia` int NOT NULL,
  `rango` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `id_policia`(`id_policia` ASC) USING BTREE,
  CONSTRAINT `rangos_alcanzados_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rangos_alcanzados
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
  CONSTRAINT `reconocimientos_ibfk_1` FOREIGN KEY (`id_policia`) REFERENCES `policias` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of reconocimientos
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
