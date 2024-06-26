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


-- --------------------------------------------------
-- Estructura de tabla para la tabla `empresa`
-- --------------------------------------------------

DROP TABLE IF EXISTS `empresa` ;

CREATE TABLE IF NOT EXISTS `empresa` (
  `empresa_id` int(2) NOT NULL,
  `empresa_nombre` varchar(90) NOT NULL,
  `empresa_email` varchar(70) NOT NULL,
  `empresa_telefono` varchar(20) NOT NULL,
  `address_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`empresa_id`),
  CONSTRAINT `fk_empresa_direccion`
    FOREIGN KEY (`address_id`)
    REFERENCES `db_sat`.`direccion` (`address_id`)
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_sat`.`direccion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `direccion` ;

CREATE TABLE IF NOT EXISTS `direccion` (
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

INSERT INTO `direccion` (`address_id`, `address_street`, `address_name`, `address_cp`, `address_ciudad`, `address_provincia`, `address_pais`) VALUES ('1', 'Calle', 'Lazaro 20', '03012', 'Alicante', 'Alicante', 'España');
INSERT INTO `direccion` (`address_id`, `address_street`, `address_name`, `address_cp`, `address_ciudad`, `address_provincia`, `address_pais`) VALUES ('2', 'Calle', 'Lima 100', '03007', 'San Juan', 'Alicante', 'España');
INSERT INTO `direccion` (`address_id`, `address_street`, `address_name`, `address_cp`, `address_ciudad`, `address_provincia`, `address_pais`) VALUES ('3', 'Calle', 'Los Docientos 5', '03011', 'Alicante', 'Alicante', 'España');


-- -----------------------------------------------------
-- Tabla `item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `item` ;

CREATE TABLE IF NOT EXISTS `item` (
  `item_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_codigo` varchar(50) NOT NULL,
  `item_nombre` varchar(150) NOT NULL,
  `item_stock` int(10) NOT NULL,
  `item_estado` varchar(20) NOT NULL,
  `item_detalle` varchar(200) NOT NULL,
  PRIMARY KEY (`item_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_sat`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `category` ;

CREATE TABLE IF NOT EXISTS `category` (
  `category_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` VARCHAR(55) NOT NULL,
  PRIMARY KEY (`category_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

INSERT INTO `category` (`category_id`, `category_name`) VALUES ('1', 'Electronica');
INSERT INTO `category` (`category_id`, `category_name`) VALUES ('2', 'Albañilería');
INSERT INTO `category` (`category_id`, `category_name`) VALUES ('3', 'Carpintería');
INSERT INTO `category` (`category_id`, `category_name`) VALUES ('4', 'Aire Acondicionado');
INSERT INTO `category` (`category_id`, `category_name`) VALUES ('5', 'Informatica');
INSERT INTO `category` (`category_id`, `category_name`) VALUES ('6', 'Limpieza');


-- -----------------------------------------------------
-- Table `db_sat`.`cliente`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cliente` ;

CREATE TABLE IF NOT EXISTS `cliente` (
  `cliente_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente_dni` varchar(30) NOT NULL,
  `cliente_nombre` varchar(30) NOT NULL,
  `cliente_apellido` varchar(30) NOT NULL,
  `cliente_email` VARCHAR(100) NOT NULL,
  `cliente_telefono` varchar(20) NOT NULL,
  `address_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`cliente_id`),
  CONSTRAINT `fk_cliente_direccion`
    FOREIGN KEY (`address_id`)
    REFERENCES `db_sat`.`direccion` (`address_id`)
    ON UPDATE CASCADE)
  ENGINE = InnoDB
	DEFAULT CHARACTER SET = utf8mb4;

INSERT INTO `cliente` (`cliente_id`, `cliente_dni`, `cliente_nombre`, `cliente_apellido`, `cliente_email`, `cliente_telefono`, `address_id`) VALUES ('3', '55544332K', 'Juan', 'Palomo', 'juan@gmail.com', '888777666', '3');


-- -----------------------------------------------------
-- Table `db_sat`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `usuario` ;

CREATE TABLE IF NOT EXISTS `usuario` (
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

INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_rol`, `address_id`) VALUES ('1', 'Administrador', 'Principal', 'admin@gmail.com', 'admin123', '$2y$10$F0J8k.lFjgGAK6I/tcbhyuMKSaitXy8ENMSBVZWErIoA6.VSU8MQy', 'null', 'Administrador', '1');
INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_rol`, `address_id`) VALUES ('2', 'Roger', 'Hurtado', 'roger@hotmail.com', 'roger123', '$2y$10$cS5ftuGDKGH2WRexbVzrDeirbtmDP0AtaYkON.PR9fZGJKCouNfrO', 'null', 'Tecnico', '2');
INSERT INTO `usuario` (`usuario_id`, `usuario_nombre`, `usuario_apellido`, `usuario_email`, `usuario_usuario`, `usuario_clave`, `usuario_foto`, `usuario_rol`, `address_id`) VALUES ('5', 'Jonas', 'Ballena', 'jonas@hgmail.com', 'jonas123', '$2y$10$PU6jI6YXcPO2UTnJsbNYXOADlvN8YT350DkNNeWCkmZzSAQP.CmcK', 'null', 'Tecnico', '1');

-- -----------------------------------------------------
-- Table `db_sat`.`oficio_por`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `oficio_por` ;

CREATE TABLE IF NOT EXISTS `oficio_por` (
  `oficio_por_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_id` INT(10) UNSIGNED NOT NULL,
  `category_id` INT(10) UNSIGNED NOT NULL,
  `service_tipo` ENUM('Instalacion', 'Mantenimiento', 'Reparacion', 'Desguace') NOT NULL,
  `estado` VARCHAR(25) NULL DEFAULT 'Activo',
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

INSERT INTO `oficio_por` (`oficio_por_id`, `usuario_id`, `category_id`, `service_tipo`, `estado`) VALUES ('1', '2', '2', 'Reparacion', 'Activo');
INSERT INTO `oficio_por` (`oficio_por_id`, `usuario_id`, `category_id`, `service_tipo`, `estado`) VALUES ('2', '2', '5', 'Instalacion', 'Activo');
INSERT INTO `oficio_por` (`oficio_por_id`, `usuario_id`, `category_id`, `service_tipo`, `estado`) VALUES ('3', '2', '6', 'Mantenimiento', 'Activo');
INSERT INTO `oficio_por` (`oficio_por_id`, `usuario_id`, `category_id`, `service_tipo`, `estado`) VALUES ('4', '2', '4', 'Reparacion', 'Activo');


-- -----------------------------------------------------
-- Table `db_sat`.`servicio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `servicio` ;

CREATE TABLE IF NOT EXISTS `servicio` (
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

INSERT INTO `servicio` (`service_id`, `address_id`, `cliente_id`, `service_detalle`, `usuario_id`) VALUES ('1', '2', '1', 'reparacion de electrodomestico', '2');
INSERT INTO `servicio` (`service_id`, `service_fecha`, `address_id`, `cliente_id`, `service_detalle`, `usuario_id`) VALUES ('2', '2024-06-02 11:32:21', '2', '1', 'asistencia tecnica', '2');


-- -----------------------------------------------------
-- Table `db_sat`.`pedido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pedido` ;

CREATE TABLE IF NOT EXISTS `pedido` (
  `pedido_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_codigo` VARCHAR(30) NOT NULL,
  `pedido_fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pedido_detalle` TEXT NOT NULL,
  `pedido_estado` ENUM('Pendiente', 'En Proceso', 'Finalizado') NOT NULL,
  `pedido_precio` FLOAT NOT NULL,
  `cliente_id` INT(10) UNSIGNED NOT NULL,
  `item_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`pedido_id`),
  CONSTRAINT `fk_pedido_cliente`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `db_sat`.`cliente` (`cliente_id`)
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pedido_item`
    FOREIGN KEY (`item_id`)
    REFERENCES `db_sat`.`item` (`item_id`)
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_sat`.`factura`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `factura` ;

CREATE TABLE IF NOT EXISTS `factura` (
  `factura_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `factura_codigo` VARCHAR(30) NOT NULL,
  `factura_fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `factura_detalle` TEXT NOT NULL,
  `factura_total` FLOAT NOT NULL,
  `cliente_id` INT(10) UNSIGNED NOT NULL,
  `pedido_id` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`factura_id`),
  CONSTRAINT `fk_factura_cliente`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `db_sat`.`cliente` (`cliente_id`)
    ON UPDATE CASCADE,
  CONSTRAINT `fk_factura_pedido`
    FOREIGN KEY (`pedido_id`)
    REFERENCES `db_sat`.`pedido` (`pedido_id`)
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


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


----------------------------------------------------
-- Procedure structure for procedure `rewards_report`
----------------------------------------------------


DELIMITER $$
CREATE PROCEDURE sp_agregarServicio(
OUT msj VARCHAR(30),
IN codigo_usuario INT,
IN codigo_oficio INT,
IN fechaInicio DATE
)

BEGIN

DECLARE exit handler for sqlexception
BEGIN
	-- ERROR
    SET msj = 'ERROR AL AGREGAR';
    ROLLBACK;
END;

START TRANSACTION;
	INSERT INTO servicio VALUES(null, codigo_usuario, fechaInicio, DATE_add(fechaInicio, interval 1 day), 'En Curso');
    UPDATE oficio_por SET Estado='INDISPONIBLE' WHERE usuario_id=codigo_usuario AND oficio_por_id=codigo_oficio;
    
COMMIT;
SET msj = 'EXITO';
END
$$
DELIMITER ;

 call sp_agregarServicio(@msj,1,'1','2017-10-17');
 call sp_agregarServicio(@msj,3,'2','2019-05-21');
 
 
 DELIMITER $$
 CREATE procedure sp_oficioAdisponible(
 IN codigo_usuario INT)
 
 BEGIN
 UPDATE oficio_por Set estado='DISPONIBLE' WHERE usuario_id IN(
 SELECT usuario_id
 FROM usuario WHERE usuario_id = codigo_usuario AND estado='Activo');
 END
 $$
 DELIMITER ;
 



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
