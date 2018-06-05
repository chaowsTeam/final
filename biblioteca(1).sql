-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-06-2018 a las 01:47:26
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id_autor` int(11) NOT NULL,
  `nom_autor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id_autor`, `nom_autor`) VALUES
(1, 'Robert W. Jhonson'),
(2, 'Steve Maguire'),
(3, 'Roger G. Schroeder'),
(4, ' Richard Bronson'),
(5, ' Katsuhiko Ogata'),
(6, ' Michael Hammer'),
(7, 'James Champy ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor_libro`
--

CREATE TABLE `autor_libro` (
  `id_libro` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `autor_libro`
--

INSERT INTO `autor_libro` (`id_libro`, `id_autor`) VALUES
(3, 1),
(2, 2),
(3, 3),
(4, 4),
(3, 3),
(5, 5),
(6, 6),
(6, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `biblioteca`
--

CREATE TABLE `biblioteca` (
  `id_biblioteca` int(11) NOT NULL,
  `nom_biblioteca` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `biblioteca`
--

INSERT INTO `biblioteca` (`id_biblioteca`, `nom_biblioteca`) VALUES
(1, 'Derecho'),
(2, 'Ingeniería'),
(3, 'Contaduría'),
(4, 'Economía'),
(5, 'Arquitectura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clasi`
--

CREATE TABLE `clasi` (
  `id_clasificacion` int(11) NOT NULL,
  `nom_clasi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clasi`
--

INSERT INTO `clasi` (`id_clasificacion`, `nom_clasi`) VALUES
(1, 'Matematicas'),
(2, 'Historia'),
(3, 'Derecho'),
(4, 'Economia'),
(5, 'Artes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editorial`
--

CREATE TABLE `editorial` (
  `id_editorial` int(11) NOT NULL,
  `nom_editorial` varchar(50) NOT NULL,
  `vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `editorial`
--

INSERT INTO `editorial` (`id_editorial`, `nom_editorial`, `vigencia`) VALUES
(1, ' McGraw-Hill', 0),
(2, ' CECSA', 0),
(3, ' Prentice Hall', 0),
(4, ' Grupo Editorial Norma', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `nom_empleado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nom_empleado`) VALUES
(1, 'Xavier'),
(2, 'Diego');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro`
--

CREATE TABLE `libro` (
  `id_libro` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `ISBN` int(11) NOT NULL,
  `id_clasificacion` int(11) NOT NULL,
  `id_editorial` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `libro`
--

INSERT INTO `libro` (`id_libro`, `titulo`, `ISBN`, `id_clasificacion`, `id_editorial`) VALUES
(1, 'Administración Financiera', 231231, 5, 2),
(2, 'Código sin errores', 98765, 1, 1),
(3, 'Administración de Operaciones', 1235343, 4, 1),
(4, 'Investigación de Operaciones ', 54562121, 1, 1),
(5, 'Ingeniería de Control Moderna ', 58965, 4, 3),
(6, 'Reingeniería', 54547878, 1, 3),
(7, 'matematicas 1', 5643, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libro_biblioteca`
--

CREATE TABLE `libro_biblioteca` (
  `num_inv` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL,
  `id_biblioteca` int(11) NOT NULL,
  `prestado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `libro_biblioteca`
--

INSERT INTO `libro_biblioteca` (`num_inv`, `id_libro`, `id_biblioteca`, `prestado`) VALUES
(2, 1, 1, 0),
(3, 1, 1, 1),
(4, 1, 2, 0),
(5, 1, 2, 0),
(6, 1, 3, 0),
(7, 1, 4, 0),
(8, 2, 2, 0),
(9, 2, 2, 0),
(10, 2, 3, 0),
(11, 2, 4, 0),
(12, 3, 2, 0),
(13, 3, 2, 0),
(14, 3, 3, 0),
(15, 3, 3, 0),
(16, 3, 4, 0),
(17, 3, 4, 0),
(18, 3, 5, 0),
(19, 4, 2, 0),
(20, 4, 2, 0),
(21, 4, 3, 0),
(22, 4, 3, 0),
(23, 4, 4, 0),
(24, 4, 5, 0),
(25, 4, 5, 0),
(26, 7, 1, 0),
(27, 7, 1, 0),
(8985, 5, 2, 1),
(12313, 5, 2, 1),
(123543, 5, 5, 0),
(567745, 5, 3, 0),
(567746, 5, 2, 1),
(567747, 5, 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id_empleado` int(11) NOT NULL,
  `id_prestamo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `num_inve` int(11) NOT NULL,
  `fecha_prest` date NOT NULL,
  `fecha_dev` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`id_empleado`, `id_prestamo`, `id_usuario`, `num_inve`, `fecha_prest`, `fecha_dev`) VALUES
(2, 1, 1, 2, '2018-05-08', '2018-05-11'),
(1, 2, 2, 10, '2018-05-14', '2018-05-21'),
(2, 3, 1, 27, '2018-05-08', '2018-05-18'),
(2, 11, 2, 2, '2018-06-17', '2018-06-12');

--
-- Disparadores `prestamo`
--
DELIMITER $$
CREATE TRIGGER `quitaPrestamo` BEFORE DELETE ON `prestamo` FOR EACH ROW UPDATE libro_biblioteca SET libro_biblioteca.prestado =0 WHERE old.num_inve = libro_biblioteca.num_inv
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `setPrestamo` AFTER INSERT ON `prestamo` FOR EACH ROW UPDATE libro_biblioteca SET libro_biblioteca.prestado =1 WHERE libro_biblioteca.num_inv = new.num_inve
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `id_tema` int(11) NOT NULL,
  `nom_tema` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id_tema`, `nom_tema`) VALUES
(1, 'Administración'),
(2, 'Planeación'),
(3, 'Finanzas'),
(4, 'Organización'),
(5, 'Sistemas'),
(6, 'Programación'),
(7, ' Procesos'),
(8, ' Programación lineal'),
(9, 'Teoría de Juegos'),
(10, ' Sistemas de Control'),
(11, 'Transformadas'),
(12, 'Matrices'),
(13, 'Optimización'),
(14, 'reingeniería');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema_libro`
--

CREATE TABLE `tema_libro` (
  `id_libro` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tema_libro`
--

INSERT INTO `tema_libro` (`id_libro`, `id_tema`) VALUES
(3, 1),
(3, 7),
(3, 2),
(4, 8),
(3, 9),
(4, 5),
(5, 10),
(5, 11),
(5, 12),
(5, 13),
(6, 7),
(6, 14),
(6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nom_usuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nom_usuario`) VALUES
(1, 'Sam'),
(2, 'Narvi :3');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id_autor`);

--
-- Indices de la tabla `autor_libro`
--
ALTER TABLE `autor_libro`
  ADD KEY `id_autor` (`id_autor`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  ADD PRIMARY KEY (`id_biblioteca`);

--
-- Indices de la tabla `clasi`
--
ALTER TABLE `clasi`
  ADD PRIMARY KEY (`id_clasificacion`);

--
-- Indices de la tabla `editorial`
--
ALTER TABLE `editorial`
  ADD PRIMARY KEY (`id_editorial`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `libro`
--
ALTER TABLE `libro`
  ADD PRIMARY KEY (`id_libro`),
  ADD KEY `id_editorial` (`id_editorial`),
  ADD KEY `id_clasificacion` (`id_clasificacion`);

--
-- Indices de la tabla `libro_biblioteca`
--
ALTER TABLE `libro_biblioteca`
  ADD PRIMARY KEY (`num_inv`),
  ADD KEY `id_biblioteca` (`id_biblioteca`),
  ADD KEY `id_libro` (`id_libro`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `num_inve` (`num_inve`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indices de la tabla `tema_libro`
--
ALTER TABLE `tema_libro`
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_tema` (`id_tema`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id_autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `biblioteca`
--
ALTER TABLE `biblioteca`
  MODIFY `id_biblioteca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clasi`
--
ALTER TABLE `clasi`
  MODIFY `id_clasificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `editorial`
--
ALTER TABLE `editorial`
  MODIFY `id_editorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `libro`
--
ALTER TABLE `libro`
  MODIFY `id_libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `libro_biblioteca`
--
ALTER TABLE `libro_biblioteca`
  MODIFY `num_inv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=567748;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id_prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `autor_libro`
--
ALTER TABLE `autor_libro`
  ADD CONSTRAINT `autor_libro_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id_autor`),
  ADD CONSTRAINT `autor_libro_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`);

--
-- Filtros para la tabla `libro`
--
ALTER TABLE `libro`
  ADD CONSTRAINT `libro_ibfk_1` FOREIGN KEY (`id_editorial`) REFERENCES `editorial` (`id_editorial`),
  ADD CONSTRAINT `libro_ibfk_2` FOREIGN KEY (`id_clasificacion`) REFERENCES `clasi` (`id_clasificacion`);

--
-- Filtros para la tabla `libro_biblioteca`
--
ALTER TABLE `libro_biblioteca`
  ADD CONSTRAINT `libro_biblioteca_ibfk_1` FOREIGN KEY (`id_biblioteca`) REFERENCES `biblioteca` (`id_biblioteca`),
  ADD CONSTRAINT `libro_biblioteca_ibfk_2` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`);

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `prestamo_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `prestamo_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `prestamo_ibfk_3` FOREIGN KEY (`num_inve`) REFERENCES `libro_biblioteca` (`num_inv`);

--
-- Filtros para la tabla `tema_libro`
--
ALTER TABLE `tema_libro`
  ADD CONSTRAINT `tema_libro_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`),
  ADD CONSTRAINT `tema_libro_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `tema` (`id_tema`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
