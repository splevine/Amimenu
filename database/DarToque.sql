-- 
-- Estructura de tabla para la tabla `jos_dartoque`
-- 

CREATE TABLE `jos_dartoque` (
  `idtoque` int(11) NOT NULL auto_increment,
  `idestablecimiento` varchar(64) NOT NULL,
  `nombreestablecimiento` varchar(64) NOT NULL,
  `fechatoque` date NOT NULL,
  `nombrecontacto` varchar(64) NOT NULL,
  `telefonocontacto` varchar(64) NOT NULL,
  PRIMARY KEY  (`idtoque`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 COMMENT='Guardo los valores de los toques a los restaurantes' AUTO_INCREMENT=24 ;

-- 
-- Volcar la base de datos para la tabla `jos_dartoque`
-- 

INSERT INTO `jos_dartoque` VALUES (1, '335', 'Prueba toque', '2012-05-23', 'Alberto', '652458534');
INSERT INTO `jos_dartoque` VALUES (2, '335', 'Prueba toque', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (3, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (4, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (5, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (6, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (7, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (8, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (9, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (10, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (11, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (12, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (13, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (14, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (15, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (16, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (17, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (18, '334', 'PEPE', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (19, '335', 'Prueba toque', '2012-05-23', 'alberto', '123123123');
INSERT INTO `jos_dartoque` VALUES (20, '335', 'Prueba toque', '2012-05-23', 'asdasd', '123123123');
INSERT INTO `jos_dartoque` VALUES (21, '335', 'Prueba toque', '2012-05-23', 'asdasd', '2123123');
INSERT INTO `jos_dartoque` VALUES (22, '335', 'Prueba toque', '2012-05-23', 'asdasd', '123123123');
INSERT INTO `jos_dartoque` VALUES (23, '335', 'Prueba toque', '2012-06-05', 'Alberto', '652458534');
