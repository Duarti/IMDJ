-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema imdj
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `imdj` ;

-- -----------------------------------------------------
-- Schema imdj
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `imdj` DEFAULT CHARACTER SET utf8 ;
USE `imdj` ;

-- -----------------------------------------------------
-- Table `imdj`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imdj`.`usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(128) NOT NULL,
  `senha` VARCHAR(32) NOT NULL,
  `nome` VARCHAR(128) NOT NULL,
  `imagem` VARCHAR(32),
  `token` VARCHAR(32),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `imdj`.`musicas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `imdj`.`musica` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(128) NOT NULL,
  `usuario_id` INT NOT NULL,
  `file` VARCHAR(32) NOT NULL,
  `extensao` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_musicas_usuario_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_musicas_usuario`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `imdj`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

INSERT INTO usuario (email, senha, nome, imagem) VALUES ('admin@imdj.com',md5('admin'),'Administrador',null);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
