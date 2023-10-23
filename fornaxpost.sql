-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2023 a las 19:41:49
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fornaxpost`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artefactos`
--

CREATE TABLE `artefactos` (
  `serial` varchar(15) NOT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `garantia` enum('S','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `artefactos`
--

INSERT INTO `artefactos` (`serial`, `modelo`, `garantia`) VALUES
('123456', 'FORNAX FIT 50', 'N'),
('456789', 'FORNAX RISTORANTE', 'N'),
('888888', 'FORNAX FREIDORA', 'N'),
('999999', 'FORNAX CLASSIC', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `dni` varchar(8) NOT NULL,
  `nombreYapellido` varchar(60) NOT NULL,
  `domicilio` varchar(30) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `provincia` varchar(30) NOT NULL,
  `localidad` varchar(30) NOT NULL,
  `codpostal` varchar(15) NOT NULL,
  `obs` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`dni`, `nombreYapellido`, `domicilio`, `telefono`, `email`, `provincia`, `localidad`, `codpostal`, `obs`) VALUES
('44232238', 'Marcelo Benitez', 'Balbo 4156', '3415690470', 'marcebenitez0607@gmail.com', 'Santa Fe', 'Rosario', '2000', 'cortada entre garibaldi y chuquisaca'),
('44765283', 'Lucas Quaroni', 'Alvear 12', '3416956364', 'lucas.quaroni@gmail.com', 'Santa Fe', 'Rosario', '2000', 'Casa de portón negro, frente a la estación de servicio.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idestado` varchar(3) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idestado`, `nombre`, `descripcion`) VALUES
('ASI', 'asignado', 'reclamo asignado a un responsable'),
('PEN', 'pendiente', 'reclamo pendiente de asignación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fletes`
--

CREATE TABLE `fletes` (
  `idflete` int(11) NOT NULL,
  `idchofer` int(11) NOT NULL,
  `tipo` enum('R','D') DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `estado` enum('asignada','pendiente','completada','cancelada') DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `idreclamo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reclamos`
--

CREATE TABLE `reclamos` (
  `id` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `fecha` date NOT NULL,
  `serial` varchar(15) NOT NULL,
  `idadmin` int(11) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `idestado` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reclamos`
--

INSERT INTO `reclamos` (`id`, `dni`, `fecha`, `serial`, `idadmin`, `descripcion`, `idestado`) VALUES
(75, '44765283', '2023-10-23', '123456', 3, 'Se me revento la puerta del horno', 'PEN'),
(76, '44232238', '2023-10-23', '456789', 2, 'Las hornallas se me fundieron', 'ASI'),
(77, '44765283', '2023-10-23', '123456', 1, 'Se me termino la garantía, puedo extenderla?', 'PEN'),
(78, '44765283', '2023-10-23', '888888', 1, 'Pierde aceite', 'PEN'),
(79, '44232238', '2023-10-23', '999999', 1, 'Las perillas se me descascaran', 'PEN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `idserviciotecnico` int(11) NOT NULL,
  `idtecnico` int(11) NOT NULL,
  `tipo` enum('F','D') DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `estado` enum('asignada','pendiente','completada','cancelada') DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `idreclamo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(15) DEFAULT NULL,
  `contra` varchar(30) DEFAULT NULL,
  `nombreYapellido` varchar(60) DEFAULT NULL,
  `rol` enum('A','C','T') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `contra`, `nombreYapellido`, `rol`) VALUES
(1, 'admin', 'admin', 'Lucas Quaroni', 'A'),
(2, 'chofer', 'chofer', 'Marcelo Benitez', 'C'),
(3, 'tecnico', 'tecnico', 'Mateo Bodini', 'T');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artefactos`
--
ALTER TABLE `artefactos`
  ADD PRIMARY KEY (`serial`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`idestado`);

--
-- Indices de la tabla `fletes`
--
ALTER TABLE `fletes`
  ADD PRIMARY KEY (`idflete`),
  ADD KEY `idreclamo` (`idreclamo`),
  ADD KEY `idchofer` (`idchofer`);

--
-- Indices de la tabla `reclamos`
--
ALTER TABLE `reclamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dni` (`dni`),
  ADD KEY `idestado` (`idestado`),
  ADD KEY `serial` (`serial`),
  ADD KEY `idadmin` (`idadmin`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`idserviciotecnico`),
  ADD KEY `idreclamo` (`idreclamo`),
  ADD KEY `idtecnico` (`idtecnico`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `fletes`
--
ALTER TABLE `fletes`
  MODIFY `idflete` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reclamos`
--
ALTER TABLE `reclamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idserviciotecnico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `fletes`
--
ALTER TABLE `fletes`
  ADD CONSTRAINT `fletes_ibfk_1` FOREIGN KEY (`idreclamo`) REFERENCES `reclamos` (`id`),
  ADD CONSTRAINT `fletes_ibfk_2` FOREIGN KEY (`idchofer`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `reclamos`
--
ALTER TABLE `reclamos`
  ADD CONSTRAINT `reclamos_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `clientes` (`dni`),
  ADD CONSTRAINT `reclamos_ibfk_2` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`),
  ADD CONSTRAINT `reclamos_ibfk_3` FOREIGN KEY (`serial`) REFERENCES `artefactos` (`serial`),
  ADD CONSTRAINT `reclamos_ibfk_4` FOREIGN KEY (`idadmin`) REFERENCES `usuarios` (`idusuario`);

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`idreclamo`) REFERENCES `reclamos` (`id`),
  ADD CONSTRAINT `servicios_ibfk_2` FOREIGN KEY (`idtecnico`) REFERENCES `usuarios` (`idusuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
