-- MySQL Script generated by MySQL Workbench
-- Fri May 31 15:13:33 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_sat
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `db_sat` ;

-- -----------------------------------------------------
-- Schema db_sat
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_sat` DEFAULT CHARACTER SET utf8mb4 ;
USE `db_sat` ;

-- -----------------------------------------------------
-- Table `db_sat`.`direccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_sat`.`direccion` ;

CREATE TABLE IF NOT EXISTS `db_sat`.`direccion` (
  `address_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `address_street` ENUM('Via', 'Calle', 'Pasaje') NOT NULL,
  `address_name` VARCHAR(40) NULL DEFAULT NULL,
  `address_cp` INT(6) UNSIGNED NOT NULL DEFAULT '03000',
  `address_ciudad` VARCHAR(40) NULL DEFAULT NULL,
  `address_provincia` VARCHAR(40) NULL DEFAULT NULL,
  `address_pais` VARCHAR(60) NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

INSERT INTO `db_sat`.`direccion` (`address_id`, `address_street`, `address_name`, `address_cp`, `address_ciudad`, `address_provincia`, `address_pais`) VALUES ('1', 'Calle', 'Lazaro 20', '03012', 'Alicante', 'Alicante', 'España');
INSERT INTO `db_sat`.`direccion` (`address_id`, `address_street`, `address_name`, `address_cp`, `address_ciudad`, `address_provincia`, `address_pais`) VALUES ('2', 'Calle', 'Lima 100', '03007', 'San Juan', 'Alicante', 'España');
INSERT INTO `db_sat`.`direccion` (`address_id`, `address_street`, `address_name`, `address_cp`, `address_ciudad`, `address_provincia`, `address_pais`) VALUES ('3', 'Calle', 'Los Docientos 5', '03011', 'Alicante', 'Alicante', 'España');


-- -----------------------------------------------------
-- Table `db_sat`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_sat`.`category` ;

CREATE TABLE IF NOT EXISTS `db_sat`.`category` (
  `category_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(55) NOT NULL,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

INSERT INTO `db_sat`.`category` (`category_id`, `category_name`) VALUES ('1', 'Electronica');
INSERT INTO `db_sat`.`category` (`category_id`, `category_name`) VALUES ('2', 'Albañilería');
INSERT INTO `db_sat`.`category` (`category_id`, `category_name`) VALUES ('3', 'Carpintería');
INSERT INTO `db_sat`.`category` (`category_id`, `category_name`) VALUES ('4', 'Aire Acondicionado');
INSERT INTO `db_sat`.`category` (`category_id`, `category_name`) VALUES ('5', 'Informatica');
INSERT INTO `db_sat`.`category` (`category_id`, `category_name`) VALUES ('6', 'Limpieza');


-- -----------------------------------------------------
-- Table `db_sat`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_sat`.`usuario` ;

CREATE TABLE IF NOT EXISTS `db_sat`.`usuario` (
  `usuario_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_nombre` VARCHAR(30) NOT NULL,
  `usuario_apellido` VARCHAR(30) NOT NULL,
  `usuario_email` VARCHAR(100) NOT NULL,
  `usuario_usuario` VARCHAR(30) NOT NULL,
  `usuario_clave` VARCHAR(255) NOT NULL,
  `usuario_foto` VARCHAR(535) NOT NULL,
  `usuario_rol` ENUM('Administrador', 'Colaborador', 'Tecnico', 'Cliente') NOT NULL,
  `address_id` INT(10) UNSIGNED NOT NULL,
  `usuario_creado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_actualizado` TIMESTAMP NULL,
  PRIMARY KEY (`usuario_id`),
  CONSTRAINT `fk_usuario_direccion`
    FOREIGN KEY (`address_id`)
    REFERENCES `db_sat`.`direccion` (`address_id`)
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- CREATE INDEX `idx_usuario_address_id` ON `db_sat`.`usuario` (`address_id` ASC) VISIBLE;

INSERT INTO `db_sat`.`usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_rol`, `address_id`) VALUES ('1', 'Administrador', 'Principal', 'admin@gmail.com', 'admin123', '$2y$10$F0J8k.lFjgGAK6I/tcbhyuMKSaitXy8ENMSBVZWErIoA6.VSU8MQy', 'null', 'Administrador', '1');
INSERT INTO `db_sat`.`usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_rol`, `address_id`) VALUES ('2', 'Roger', 'Hurtado', 'roger@hotmail.com', 'roger123', '$2y$10$cS5ftuGDKGH2WRexbVzrDeirbtmDP0AtaYkON.PR9fZGJKCouNfrO', 'null', 'Tecnico', '2');
INSERT INTO `db_sat`.`usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_rol`, `address_id`) VALUES ('3', 'Juan', 'Palomo', 'juan@hgmail.com', 'juan123', '$2y$10$PU6jI6YXcPO2UTnJsbNYXOADlvN8YT350DkNNeWCkmZzSAQP.CmcK', 'null', 'Cliente', '3');

-- -----------------------------------------------------
-- Table `db_sat`.`oficio_por`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_sat`.`oficio_por` ;

CREATE TABLE IF NOT EXISTS `db_sat`.`oficio_por` (
  `oficio_por_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  `category_id` INT(10) UNSIGNED NOT NULL,
  `service_tipo` ENUM('Instalacion', 'Mantenimiento', 'Reparacion', 'Desguace') NOT NULL,
  PRIMARY KEY (`oficio_por_id`),
  -- INDEX `fk_oficio_por_usuario_idx` (`usuario_id` ASC) VISIBLE,
  CONSTRAINT `fk_oficio_por_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `db_sat`.`usuario` (`usuario_id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
    CONSTRAINT `fk_oficio_por_category`
    FOREIGN KEY (`category_id`)
    REFERENCES `db_sat`.`category` (`category_id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT)
    ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8mb4;

-- CREATE INDEX `idx_off_usuario` ON `db_sat`.`oficio_usuario` (`usuario_id` ASC) VISIBLE;
-- CREATE INDEX `idx_off_oficio` ON `db_sat`.`oficio_usuario` (`oficio_id` ASC) VISIBLE;

INSERT INTO `db_sat`.`oficio_por` (`oficio_por_id`, `usuario_id`, `category_id`, `service_tipo`) VALUES ('1', '2', '1', 'Reparacion');
INSERT INTO `db_sat`.`oficio_por` (`oficio_por_id`, `usuario_id`, `category_id`, `service_tipo`) VALUES ('2', '2', '1', 'Instalacion');


-- -----------------------------------------------------
-- Table `db_sat`.`servicio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_sat`.`servicio` ;

CREATE TABLE IF NOT EXISTS `db_sat`.`servicio` (
  `service_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `service_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address_id` INT(10) UNSIGNED NOT NULL,
  `cliente_id` INT(10) UNSIGNED NOT NULL,
  `service_detalle` TEXT(200) NULL,
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`service_id`),
  CONSTRAINT `fk_servicio_direccion`
    FOREIGN KEY (`address_id`)
    REFERENCES `db_sat`.`direccion` (`address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servicio_oficio_por`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `db_sat`.`oficio_por` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_servicio_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `db_sat`.`usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- CREATE INDEX `idx_servicio_direccion` ON `db_sat`.`servicio` (`address_id` ASC) VISIBLE;
-- CREATE INDEX `idx_servicio_oficio_usuario` ON `db_sat`.`servicio` (`oficio_usuario` ASC) VISIBLE;
-- CREATE INDEX `fk_cliente_id_idx` ON `db_sat`.`servicio` (`cliente_id` ASC) VISIBLE;

INSERT INTO `db_sat`.`servicio` (`service_id`, `address_id`, `cliente_id`, `service_detalle`, `usuario_id`) VALUES ('1', '2', '1', 'reparacion de electrodomestico', '2');
INSERT INTO `db_sat`.`servicio` (`service_id`, `service_fecha`, `address_id`, `cliente_id`, `service_detalle`, `usuario_id`) VALUES ('2', '2024-06-02 11:32:21', '2', '1', 'asistencia tecnica', '2');


-- -----------------------------------------------------
-- Table `estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `estado` ;

CREATE TABLE IF NOT EXISTS `estado` (
  `state_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `state_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state_observacion` TEXT(200) NULL,
  `state_estado` ENUM('Abierto', 'Cerrado') NOT NULL,
  `service_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`state_id`),
  CONSTRAINT `fk_estado_servicio`
    FOREIGN KEY (`service_id`)
    REFERENCES `servicio` (`service_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

INSERT INTO `estado` (`state_id`, `state_observacion`, `state_estado`, `service_id`) VALUES ('1', 'Observacion inicial', 'Abierto', '1');

-- -----------------------------------------------------
-- Table `calificacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `calificacion` ;

CREATE TABLE IF NOT EXISTS `calificacion` (
  `rating_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `rating_puntaje` TINYINT(1) UNSIGNED NULL DEFAULT NULL,
  `rating_observacion` TEXT(200) NULL,
  `state_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`rating_id`),
  CONSTRAINT `fk_calificacion_estado`
    FOREIGN KEY (`state_id`)
    REFERENCES `estado` (`state_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

INSERT INTO `calificacion` (`rating_id`, `rating_puntaje`, `rating_observacion`, `state_id`) VALUES ('1', '5', 'Excelente trabajo', '1');

-- -----------------------------------------------------
-- Table `bitacora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bitacora` ;

CREATE TABLE IF NOT EXISTS `bitacora` (
  `bitacora_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bitacora_fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bitacora_tipo` ENUM('Inicio_sesion', 'Cerrar_sesion', 'Insertar', 'Modificar', 'Eliminar') NOT NULL,
  `bitacora_detalle` TEXT(200) NULL,
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`bitacora_id`),
  CONSTRAINT `fk_bitacora_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `usuario` (`usuario_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

INSERT INTO `bitacora` (`bitacora_id`, `bitacora_tipo`, `bitacora_detalle`, `usuario_id`) VALUES ('1', 'Inicio_sesion', 'Sesion iniciada correctamente', '2');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
