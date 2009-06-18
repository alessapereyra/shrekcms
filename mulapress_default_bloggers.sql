-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-06-2009 a las 19:31:28
-- Versión del servidor: 5.0.67
-- Versión de PHP: 5.2.6-2ubuntu4.2


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `lamula`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mulapress_default_bloggers`
--

CREATE TABLE IF NOT EXISTS `mulapress_default_bloggers` (
  `id` int(11) NOT NULL auto_increment,
  `blogger_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=6 ;
