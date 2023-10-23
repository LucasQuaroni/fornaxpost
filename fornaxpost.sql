-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2023 a las 04:38:48
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
('12321', NULL, NULL),
('12989898', 'FORNAX FIT 50', 'S'),
('2123132', 'asd', 'S'),
('23132132131', 'FORNAX FIT 50', 'S'),
('2313213999', NULL, NULL),
('434', 'modelo_artefacto', ''),
('4344', 'asd prueba 1', 'S'),
('44442', NULL, NULL),
('444422131', NULL, NULL),
('444422131323', NULL, NULL);

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
('1', 'yo', 'asd', 'asd', 'asda@gmail.com', 'sda', 'asd', 'ads', 'asdada'),
('22223', 'marvo', 'asd', 'asd', 'asd@gmail.com', 'asd', '|asd', 'ads', 'asdsa'),
('34243', 'Lucas Quaroni', 'Alvear 12', '3416956364', 'lucas.quaroni@gmail.com', 'Santa Fe', 'Rosario', '2000', 'Cliente nuevo'),
('44232238', 'Marcelo Benitez', 'Balbo 4156', '3415690470', 'marcebenitez0607@gmail.com', 'Santa Fe', 'Rosario', '2000', 'Marcelo el nene'),
('44523085', 'Emma Procaccini', 'Avenida del huerto 1223', '3415690470', 'emmaproca@icloud.com', 'Santa Fe', 'Rosario', '2000', 'Emma nueva cliente top'),
('44765222', 'asd', 'asd', 'asd', 'asda@gmail.com', 'asntasda', 'dsa', 'dsa', 'dsasda'),
('44765283', 'Lucas Quaroni', 'Alvear 12', '3416956364', 'lucas.quaroni@gmail.com', 'Santa Fe', 'Rosario', '2000', 'Nada que observar'),
('888', 'Maria', 'adad', '232213', 'dsadsa@gmail.com', 'dsadsa', 'dadqs', 'dadwa', 'dsadwa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idestado` varchar(3) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(5, '44765283', '2023-10-14', '23132132131', NULL, 'prueba', NULL),
(6, '44765283', '2023-10-14', '12989898', NULL, 'prueba', NULL),
(7, '44765283', '2023-10-14', '12989898', NULL, 'prueba', NULL),
(8, '44765283', '2023-10-14', '12989898', NULL, 'prueba', NULL),
(9, '44765283', '2023-10-14', '12989898', NULL, 'prueba', NULL),
(10, '44765283', '2023-10-14', '12989898', NULL, 'prueba dos', NULL),
(11, '44765283', '2023-10-14', '12989898', NULL, 'prueba dos', NULL),
(12, '44765283', '2023-10-14', '12989898', NULL, 'prueba 3', NULL),
(13, '44765283', '2023-10-14', '12989898', NULL, 'prueba 15', NULL),
(14, '44765283', '2023-10-14', '12989898', NULL, 'prueba 16', NULL),
(15, '44765283', '2023-10-14', '12989898', NULL, 'prueba 12', NULL),
(16, '44765283', '2023-10-14', '12989898', NULL, 'prueba 114', NULL),
(17, '44765283', '2023-10-14', '12989898', NULL, 'prueba 20', NULL),
(18, '44765283', '2023-10-14', '12989898', NULL, 'sdadsadsa', NULL),
(19, '44765283', '2023-10-14', '12321', NULL, 'prueba definitiva', NULL),
(20, '44765283', '2023-10-15', '12989898', NULL, 'Prueba nueva, numero 20', NULL),
(21, '44765283', '2023-10-15', '12989898', NULL, 'se me revento la puerta', NULL),
(22, '44765283', '2023-10-15', '12321', NULL, 'no anda', NULL),
(23, '44765283', '2023-10-15', '12989898', NULL, 'jhonathan', NULL),
(24, '44765283', '2023-10-15', '12321', NULL, 'revento la puerta', NULL),
(25, '44765283', '2023-10-16', '23132132131', NULL, 'prueba numero nose cuanto, 16/10', NULL),
(26, '44765283', '2023-10-16', '12989898', NULL, 'aliexpress', NULL),
(27, '44765283', '2023-10-16', '23132132131', NULL, 'prueba', NULL),
(28, '44765283', '2023-10-16', '23132132131', NULL, 'revento', NULL),
(29, '44765283', '2023-10-16', '12989898', NULL, 'nada, es una prueba', NULL),
(30, '34243', '2023-10-16', '12989898', NULL, 'ensimismada', NULL),
(31, '44765222', '2023-10-16', '2313213999', NULL, 'dsadsadas', NULL),
(32, '44765222', '2023-10-16', '2313213999', NULL, 'dsadsadas', NULL),
(33, '1', '2023-10-16', '44442', NULL, 'se rompio la chaveta', NULL),
(34, '1', '2023-10-16', '444422131', NULL, 'se rompio la chaveta', NULL),
(35, '1', '2023-10-16', '444422131', NULL, 'se rompio la chaveta', NULL),
(36, '1', '2023-10-16', '444422131323', NULL, 'se rompio la chaveta', NULL),
(37, '1', '2023-10-16', '434', NULL, 'a ver si carga bien la cocina', NULL),
(38, '1', '2023-10-16', '4344', NULL, 'a ver si carga bien la cocina', NULL),
(39, '44765283', '2023-10-17', '44442', NULL, 'prueba final antes del marvo', NULL),
(40, '44765283', '2023-10-18', '2123132', NULL, 'asd', NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
