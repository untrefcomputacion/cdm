SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

DROP TABLE IF EXISTS `alumno`;
CREATE TABLE IF NOT EXISTS `alumno` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(45) DEFAULT NULL,
  `apellido` VARCHAR(45) DEFAULT NULL,
  `cohorte` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COMMENT='Tabla de alumnos, cada uno es un usuario del sistema.' ;

DROP TABLE IF EXISTS `curricula`;
CREATE TABLE IF NOT EXISTS `curricula` (
  `alumno_id` INT(11) UNSIGNED NOT NULL,
  `materia_id` INT(11) UNSIGNED NOT NULL,
  `regular` INT(11) UNSIGNED DEFAULT '0',
  `final` INT(11) UNSIGNED DEFAULT '0',
  `nota` INT(11) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`alumno_id`,`materia_id`),
  KEY `fk_materia` (`materia_id`),
  KEY `fk_alumno` (`alumno_id`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COMMENT='Tabla de relaciones entre alumnos y materias.';

DROP TABLE IF EXISTS `estado`;
CREATE TABLE IF NOT EXISTS `estado` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `class` VARCHAR(50) NOT NULL,
  `bgcolor` VARCHAR(50) NOT NULL DEFAULT '#ffffff',
  `fontcolor` VARCHAR(50) NOT NULL DEFAULT '#000000',
  `descripcion` TEXT NOT NULL,
  PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COMMENT='Estado de cada una de las relaciones de alumnos y materias.' ;

INSERT INTO `estado` (`nombre`, `class`, `bgcolor`, `fontcolor`, `descripcion`) VALUES
('Deshabilitada', 'disabled', '#ffffff', '#aaaaaa', 'Materias sin la correlatividad cumplida.'),
('Habilitada', 'enabled', '#90ee90', '#000000', 'Materias disponibles para cursar.'),
('Pendiente', 'pending', '#ffff66', '#000000', 'Materias con final pendiente.'),
('Completa', 'complete', '#add8e6', '#000000', 'Materias completadas.'),
('Atencion', 'warning', '#ff6666', '#000000', 'Materias con correlatividad incumplida.');

DROP TABLE IF EXISTS `estado_condicion`;
CREATE TABLE IF NOT EXISTS `estado_condicion` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `estado_id` INT(11) UNSIGNED DEFAULT NULL,
  `regular_correlativa` INT(11) UNSIGNED DEFAULT NULL,
  `final_correlativa` INT(11) UNSIGNED DEFAULT NULL,
  `regular` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  `final` INT(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_estado` (`estado_id`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COMMENT='Condiciones que deben cumplir las cursadas.' ;

INSERT INTO `estado_condicion` (`estado_id`, `regular_correlativa`, `final_correlativa`, `regular`, `final`) VALUES
(2, NULL, NULL, 0, 0),
(3, NULL, NULL, 1, 0),
(4, NULL, NULL, 0, 1),
(4, NULL, NULL, 1, 1),
(1, 0, 0, 0, 0),
(5, 0, 0, 0, 1),
(3, 0, 0, 1, 0),
(5, 0, 0, 1, 1),
(2, 0, 1, 0, 0),
(4, 0, 1, 0, 1),
(3, 0, 1, 1, 0),
(4, 0, 1, 1, 1),
(2, 1, 0, 0, 0),
(5, 1, 0, 0, 1),
(3, 1, 0, 1, 0),
(5, 1, 0, 1, 1),
(2, 1, 1, 0, 0),
(4, 1, 1, 0, 1),
(3, 1, 1, 1, 0),
(4, 1, 1, 1, 1);

DROP TABLE IF EXISTS `materia`;
CREATE TABLE IF NOT EXISTS `materia` (
  `id` INT(11) UNSIGNED NOT NULL COMMENT 'Código de materia',
  `codigo` INT(11) UNSIGNED NOT NULL COMMENT 'Código interno utilizado por la Universidad Nacionar de Tres de Febrero',
  `nombre` VARCHAR(255) NOT NULL,
  `anio` INT(11) UNSIGNED NOT NULL COMMENT 'Año en que se cursa la materia.',
  `cuatrimestre` INT(11) UNSIGNED NOT NULL COMMENT 'Cuantrimestre en que se cursa la materia.',
  `correlativa` INT(11) UNSIGNED DEFAULT NULL COMMENT 'Código de la materia que debe estar aprobada para poder cursar la actual.',
  `horas` INT(11) UNSIGNED NOT NULL COMMENT 'Carga horaria por cuatrimestre.',
  PRIMARY KEY (`id`),
  KEY `fk_materia` (`correlativa`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COMMENT='Tabla de materias.';

INSERT INTO `materia` (`id`, `codigo`, `nombre`, `anio`, `cuatrimestre`, `correlativa`, `horas`) VALUES
(0, 0, 'Sin correlatividad', 0, 0, 0, 0),
(111, 939, 'Física I', 1, 1, 0, 90),
(112, 861, 'Análisis Matemático I', 1, 1, 0, 90),
(113, 742, 'Matemática Discreta I', 1, 1, 0, 60),
(114, 743, 'Estructuras de Datos I', 1, 1, 0, 60),
(115, 862, 'Algebra I', 1, 1, 0, 60),
(116, 591, 'Problemas de Historia del Siglo 20', 1, 1, 0, 60),
(117, 592, 'Taller de Introducción a la Problemática del Mundo Contemporáneo', 1, 1, 0, 30),
(121, 942, 'Física II', 1, 2, 111, 90),
(122, 941, 'Análisis Matemático II', 1, 2, 112, 90),
(123, 744, 'Matemática Discreta II', 1, 2, 113, 60),
(124, 745, 'Lenguaje de Programación I', 1, 2, 114, 60),
(125, 952, 'Algebra II', 1, 2, 115, 60),
(126, 2, 'Cultura Contemporánea', 1, 2, 0, 60),
(127, 592, 'Taller de Introducción a la Problemática del Mundo Contemporáneo', 1, 2, 0, 30),
(211, 746, 'Probabilidad y Estadística I', 2, 1, 112, 60),
(212, 943, 'Análisis Matemático III', 2, 1, 122, 90),
(213, 747, 'Estructuras de Datos II', 2, 1, 114, 60),
(214, 748, 'Teoría de Sistemas', 2, 1, 123, 60),
(215, 749, 'Lenguaje de Programación II', 2, 1, 124, 60),
(216, 3, 'Cuestiones de Sociología, Economía y Política', 2, 1, 0, 60),
(221, 750, 'Física III', 2, 2, 121, 90),
(222, 751, 'Probabilidad y Estadística II', 2, 2, 211, 60),
(223, 752, 'Arquitectura de Computadoras', 2, 2, 121, 60),
(224, 753, 'Estructuras de Datos III', 2, 2, 213, 60),
(225, 754, 'Análisis y Diseño Estructurado', 2, 2, 214, 60),
(226, 104, 'Investigación Operativa', 2, 2, 122, 60),
(311, 755, 'Química', 3, 1, 221, 90),
(312, 756, 'Bases de Datos I', 3, 1, 224, 90),
(313, 757, 'Teoría de la Información', 3, 1, 222, 60),
(314, 758, 'Lenguaje de Programación III', 3, 1, 215, 60),
(315, 1, 'Metodología de la Información', 3, 1, 0, 60),
(316, 759, 'Inglés Básico', 3, 1, 0, 60),
(321, 760, 'Análisis y Diseño Orientado a Objetos', 3, 2, 225, 60),
(322, 761, 'Bases de Datos II', 3, 2, 312, 90),
(323, 762, 'Sistemas Operativos', 3, 2, 223, 120),
(324, 763, 'Lenguaje de Programación IV', 3, 2, 314, 60),
(325, 764, 'Teleinformática', 3, 2, 313, 60),
(326, 765, 'Inglés Técnico', 3, 2, 316, 60),
(411, 766, 'Análisis y Diseño de Sistemas en Tiempo Real', 4, 1, 321, 60),
(412, 767, 'Compiladores e Intérpretes', 4, 1, 324, 60),
(413, 768, 'Procesos Estocásticos', 4, 1, 222, 60),
(414, 769, 'Ingeniería en Software', 4, 1, 321, 60),
(415, 770, 'Procesamiento de Señales I', 4, 1, 212, 60),
(421, 771, 'Simulación de Sistemas', 4, 2, 226, 60),
(422, 772, 'Seguridad Informática', 4, 2, 221, 90),
(423, 773, 'Inteligencia Artificial', 4, 2, 224, 60),
(424, 774, 'Procesamiento de Imágenes', 4, 2, 415, 60),
(425, 775, 'Circuitos Electrónicos', 4, 2, 121, 90),
(511, 1101, 'Sistemas de Adquisición de Datos', 5, 1, 425, 60),
(512, 777, 'Bioinformática', 5, 1, 311, 60),
(513, 778, 'Robótica', 5, 1, 111, 90),
(514, 779, 'Laboratorio de Electrónica', 5, 1, 425, 90),
(515, 780, 'Informática Médica', 5, 1, 312, 60),
(521, 781, 'Software Legal', 5, 2, 0, 60),
(522, 782, 'Procesamiento de Señales II', 5, 2, 415, 60),
(523, 783, 'Auditoría de Sistemas', 5, 2, 422, 60),
(524, 784, 'Informática Industrial', 5, 2, 513, 60),
(525, 785, 'Trabajo de Tesis', 5, 2, 414, 60);

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(50) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_unique` (`nombre`)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COMMENT='Usuarios para la administración del sistema' ;

INSERT INTO `usuario` (`id`, `nombre`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

DROP VIEW IF EXISTS `get_estado`;
CREATE VIEW `get_estado` AS SELECT `alumno`.`id` AS `alumno_id`, `materia`.`id` AS `materia_id`, `estado`.`id` AS `estado_id`, `estado`.`class` AS `class` FROM ((((`alumno` JOIN `curricula` `c1` ON((`alumno`.`id` = `c1`.`alumno_id`))) JOIN `materia` ON((`c1`.`materia_id` = `materia`.`id`))) LEFT JOIN `curricula` `c2` ON(((`materia`.`correlativa` = `c2`.`materia_id`) and (`alumno`.`id` = `c2`.`alumno_id`)))) JOIN (`estado` JOIN `estado_condicion` ON((`estado`.`id` = `estado_condicion`.`estado_id`))) ON(((`c2`.`regular` <=> `estado_condicion`.`regular_correlativa`) AND (`c2`.`final` <=> `estado_condicion`.`final_correlativa`) AND (`c1`.`regular` = `estado_condicion`.`regular`) AND (`c1`.`final` = `estado_condicion`.`final`)))) ORDER BY `materia`.`id`;

ALTER TABLE `curricula`
  ADD CONSTRAINT `fk_alumno_has_materia_alumno`
  FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alumno_has_materia_materia`
  FOREIGN KEY (`materia_id`) REFERENCES `materia` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `estado_condicion`
  ADD CONSTRAINT `fk_estado`
  FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `materia`
  ADD CONSTRAINT `fk_materia_has_materia_correlativa`
  FOREIGN KEY (`correlativa`) REFERENCES `materia` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
