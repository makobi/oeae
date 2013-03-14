-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2013 at 09:43 AM
-- Server version: 5.0.95
-- PHP Version: 5.1.6
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

 --
-- Database: `Avaluo`
--
 -- --------------------------------------------------------
 --
-- Table structure for table `Actividades`
--

DROP TABLE IF EXISTS `Actividades`;


CREATE TABLE IF NOT EXISTS `Actividades` (`act_id` int(11) NOT NULL auto_increment, `nombre_act` varchar(500) NOT NULL, `logro_esperado` int(11) NOT NULL, `fecha_dado` date DEFAULT NULL, `ultima_modif` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON
                                          UPDATE CURRENT_TIMESTAMP, `rub_id` int(11) NOT NULL, PRIMARY KEY (`act_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

 -- --------------------------------------------------------
 --
-- Table structure for table `ActividadesCurso`
--

DROP TABLE IF EXISTS `ActividadesCurso`;


CREATE TABLE IF NOT EXISTS `ActividadesCurso` (`act_id` int(11) NOT NULL, `curso_id` int(11) NOT NULL, KEY `act_id` (`act_id`), KEY `curso_id` (`curso_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 -- --------------------------------------------------------
 --
-- Table structure for table `CriterioPertenece`
--

DROP TABLE IF EXISTS `CriterioPertenece`;


CREATE TABLE IF NOT EXISTS `CriterioPertenece` (`dom_id` int(11) NOT NULL, `crit_id` int(11) NOT NULL, KEY `dom_id` (`dom_id`), KEY `crit_id` (`crit_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 -- --------------------------------------------------------
 --
-- Table structure for table `Criterios`
--

DROP TABLE IF EXISTS `Criterios`;


CREATE TABLE IF NOT EXISTS `Criterios` (`crit_id` int(11) NOT NULL auto_increment, `nombre_crit` varchar(300) NOT NULL, PRIMARY KEY (`crit_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

 -- --------------------------------------------------------
 --
-- Table structure for table `Cursos`
--

DROP TABLE IF EXISTS `Cursos`;


CREATE TABLE IF NOT EXISTS `Cursos` (`curso_id` int(11) NOT NULL auto_increment, `codificacion` char(8) NOT NULL, `seccion` char(3) NOT NULL, `nombre_curso` varchar(30) NOT NULL, `fac_curso` varchar(40) NOT NULL, `prog_curso` varchar(40) NOT NULL, PRIMARY KEY (`curso_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

 -- --------------------------------------------------------
 --
-- Table structure for table `Dominios`
--

DROP TABLE IF EXISTS `Dominios`;


CREATE TABLE IF NOT EXISTS `Dominios` (`dom_id` int(11) NOT NULL auto_increment, `nombre_dom` varchar(300) NOT NULL, `valor_esperado` int(11) NOT NULL, PRIMARY KEY (`dom_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

 -- --------------------------------------------------------
 --
-- Table structure for table `EscalaCriterio`
--

DROP TABLE IF EXISTS `EscalaCriterio`;


CREATE TABLE IF NOT EXISTS `EscalaCriterio` (`crit_id` int(11) NOT NULL, `valor` int(11) NOT NULL, `descripcion` varchar(5000) NOT NULL, KEY `crit_id` (`crit_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 -- --------------------------------------------------------
 --
-- Table structure for table `Estudiantes`
--

DROP TABLE IF EXISTS `Estudiantes`;


CREATE TABLE IF NOT EXISTS `Estudiantes` (`est_id` int(11) NOT NULL auto_increment, `nombre_est` varchar(70) NOT NULL, `no_est` char(9) NOT NULL, PRIMARY KEY (`est_id`), UNIQUE KEY `no_est` (`no_est`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

 -- --------------------------------------------------------
 --
-- Table structure for table `Evaluacion`
--

DROP TABLE IF EXISTS `Evaluacion`;


CREATE TABLE IF NOT EXISTS `Evaluacion` (`act_id` int(11) NOT NULL, `crit_id` int(11) NOT NULL, `ptos_obtenidos` int(11) DEFAULT NULL, `mat_id` int(11) NOT NULL, `rub_id` int(11) NOT NULL, UNIQUE KEY `act_id_2` (`act_id`,`crit_id`,`mat_id`), KEY `act_id` (`act_id`), KEY `crit_id` (`crit_id`), KEY `mat_id` (`mat_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 -- --------------------------------------------------------
 --
-- Table structure for table `Matricula`
--

DROP TABLE IF EXISTS `Matricula`;


CREATE TABLE IF NOT EXISTS `Matricula` (`curso_id` int(11) NOT NULL, `est_id` int(11) NOT NULL, `mat_id` int(11) NOT NULL auto_increment, PRIMARY KEY (`mat_id`), KEY `curso_id` (`curso_id`), KEY `est_id` (`est_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

 -- --------------------------------------------------------
 --
-- Table structure for table `NombresRubricas`
--

DROP TABLE IF EXISTS `NombresRubricas`;


CREATE TABLE IF NOT EXISTS `NombresRubricas` (`rub_id` int(11) NOT NULL, `nombre_rub` varchar(200) NOT NULL, PRIMARY KEY (`rub_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 -- --------------------------------------------------------
 --
-- Table structure for table `Profesores`
--

DROP TABLE IF EXISTS `Profesores`;


CREATE TABLE IF NOT EXISTS `Profesores` (`prof_id` int(11) NOT NULL auto_increment, `nombre_prof` varchar(70) NOT NULL, `email` varchar(35) NOT NULL, `passwd` varchar(32) NOT NULL, `dpto_prof` varchar(40) DEFAULT NULL, `fac_prof` varchar(40) DEFAULT NULL, PRIMARY KEY (`prof_id`), UNIQUE KEY `email` (`email`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

 -- --------------------------------------------------------
 --
-- Table structure for table `ProfesorImparte`
--

DROP TABLE IF EXISTS `ProfesorImparte`;


CREATE TABLE IF NOT EXISTS `ProfesorImparte` (`prof_id` int(11) NOT NULL, `curso_id` int(11) NOT NULL, KEY `curso_id` (`curso_id`), KEY `prof_id` (`prof_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 -- --------------------------------------------------------
 --
-- Table structure for table `RubricaCreadaPor`
--

DROP TABLE IF EXISTS `RubricaCreadaPor`;


CREATE TABLE IF NOT EXISTS `RubricaCreadaPor` (`prof_id` int(11) NOT NULL, `fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON
                                               UPDATE CURRENT_TIMESTAMP, `rub_id` int(11) NOT NULL, PRIMARY KEY (`rub_id`), KEY `prof_id` (`prof_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 -- --------------------------------------------------------
 --
-- Table structure for table `RubricaLocal`
--

DROP TABLE IF EXISTS `RubricaLocal`;


CREATE TABLE IF NOT EXISTS `RubricaLocal` (`rub_id` int(11) NOT NULL, `crit_id` int(11) NOT NULL, `prof_id` int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;

 -- --------------------------------------------------------
 --
-- Table structure for table `Rubricas`
--

DROP TABLE IF EXISTS `Rubricas`;


CREATE TABLE IF NOT EXISTS `Rubricas` (`rub_id` int(11) NOT NULL, `crit_id` int(11) NOT NULL, KEY `crit_id` (`crit_id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 --
-- Constraints for dumped tables
--
 --
-- Constraints for table `CriterioPertenece`
--

ALTER TABLE `CriterioPertenece` ADD CONSTRAINT `CriterioPertenece_ibfk_4`
FOREIGN KEY (`crit_id`) REFERENCES `Criterios` (`crit_id`), ADD CONSTRAINT `CriterioPertenece_ibfk_1`
FOREIGN KEY (`dom_id`) REFERENCES `Dominios` (`dom_id`), ADD CONSTRAINT `CriterioPertenece_ibfk_2`
FOREIGN KEY (`crit_id`) REFERENCES `Criterios` (`crit_id`), ADD CONSTRAINT `CriterioPertenece_ibfk_3`
FOREIGN KEY (`dom_id`) REFERENCES `Dominios` (`dom_id`);

 --
-- Constraints for table `EscalaCriterio`
--

ALTER TABLE `EscalaCriterio` ADD CONSTRAINT `EscalaCriterio_ibfk_1`
FOREIGN KEY (`crit_id`) REFERENCES `Criterios` (`crit_id`) ON
DELETE CASCADE;

 --
-- Constraints for table `Evaluacion`
--

ALTER TABLE `Evaluacion` ADD CONSTRAINT `Evaluacion_ibfk_1`
FOREIGN KEY (`act_id`) REFERENCES `Actividades` (`act_id`), ADD CONSTRAINT `Evaluacion_ibfk_2`
FOREIGN KEY (`crit_id`) REFERENCES `Criterios` (`crit_id`), ADD CONSTRAINT `Evaluacion_ibfk_3`
FOREIGN KEY (`mat_id`) REFERENCES `Matricula` (`mat_id`);

 --
-- Constraints for table `Matricula`
--

ALTER TABLE `Matricula` ADD CONSTRAINT `Matricula_ibfk_4`
FOREIGN KEY (`curso_id`) REFERENCES `Cursos` (`curso_id`) ON
DELETE CASCADE, ADD CONSTRAINT `Matricula_ibfk_1`
FOREIGN KEY (`curso_id`) REFERENCES `Cursos` (`curso_id`), ADD CONSTRAINT `Matricula_ibfk_2`
FOREIGN KEY (`est_id`) REFERENCES `Estudiantes` (`est_id`), ADD CONSTRAINT `Matricula_ibfk_3`
FOREIGN KEY (`est_id`) REFERENCES `Estudiantes` (`est_id`) ON
DELETE CASCADE;

 --
-- Constraints for table `ProfesorImparte`
--

ALTER TABLE `ProfesorImparte` ADD CONSTRAINT `ProfesorImparte_ibfk_1`
FOREIGN KEY (`curso_id`) REFERENCES `Cursos` (`curso_id`), ADD CONSTRAINT `ProfesorImparte_ibfk_2`
FOREIGN KEY (`prof_id`) REFERENCES `Profesores` (`prof_id`);

 --
-- Constraints for table `RubricaCreadaPor`
--

ALTER TABLE `RubricaCreadaPor` ADD CONSTRAINT `RubricaCreadaPor_ibfk_1`
FOREIGN KEY (`prof_id`) REFERENCES `Profesores` (`prof_id`);

 --
-- Constraints for table `Rubricas`
--

ALTER TABLE `Rubricas` ADD CONSTRAINT `Rubricas_ibfk_1`
FOREIGN KEY (`crit_id`) REFERENCES `Criterios` (`crit_id`);