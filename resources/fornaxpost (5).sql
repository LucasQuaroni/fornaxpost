-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2023 a las 14:54:27
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

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
  `garantia` enum('S','N') DEFAULT NULL,
  `vendedor` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `artefactos`
--

INSERT INTO `artefactos` (`serial`, `modelo`, `garantia`, `vendedor`) VALUES
('777777', 'FORNAX FIT 50', 'S', 'Garbarino');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`dni`, `nombreYapellido`, `domicilio`, `telefono`, `email`, `provincia`, `localidad`, `codpostal`, `obs`) VALUES
('44765283', 'Lucas Quaroni', 'Alvear 12', '3416956364', 'lucas.quaroni@gmail.com', 'Santa Fe', 'Rosario', '2000', 'Casa compartida, tocar timbre primer piso.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idestado` varchar(10) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `descripcion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idestado`, `nombre`, `descripcion`) VALUES
('CAN', 'Z - Cancelado', 'Reclamo cancelado'),
('COCINS', 'A - Cocina inservible', 'El admin debe contactarse con el dueño de la cocina, para informarle que no sirve mas'),
('COCLIS', 'A - Cocina lista', 'La cocina esta lista para devolver, el tecnico la pudo reparar'),
('ENFAB', 'A - En fabrica', 'La cocina se encuentra en fabrica, esperando ser reparada'),
('ENVIMP', 'A - Envio imposible', 'El admin debe revisar el reclamo ya que no pudo llegar la cocina a destino'),
('ENVPEN', 'C - Envio pendiente', 'El chofer tiene un envio pendiente a su nombre'),
('FIN', 'Z - Finalizado', 'Reclamo finalizado y solucionado con exito'),
('PEN', 'A - Pendiente', 'El reclamo es creado, y se encuentra pendiente de asignación de responsable'),
('REPPEN', 'T - Reparacion pendiente', 'El técnico tiene una reparación pendiente, asignada a su nombre'),
('RETIMP', 'A - Retiro imposible', 'El admin debe revisar el reclamo ya que no pudo retirarse la cocina '),
('RETPEN', 'C - Retiro pendiente', 'El chofer tiene un retiro pendiente, asignado a su nombre'),
('REVPEN', 'A - Revision pendiente', 'El admin debe revisar el reclamo, ya que el tecnico indico problemas o detalles'),
('VISPEN', 'T - Visita pendiente', 'El tecnico tiene una visita pendiente, asignada a su nombre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fletes`
--

CREATE TABLE `fletes` (
  `idflete` int(11) NOT NULL,
  `idchofer` int(11) NOT NULL,
  `tipo` enum('R','D') DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `estado` enum('1-asignada','2-pendiente','3-completada','4-cancelada') DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `idreclamo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fletes`
--

INSERT INTO `fletes` (`idflete`, `idchofer`, `tipo`, `direccion`, `estado`, `descripcion`, `idreclamo`) VALUES
(20, 3, 'R', 'Alvear 12', '2-pendiente', 'En rpoces. Viaje sale a las 12hs.', 91),
(21, 4, 'D', 'Alvear 12', '4-cancelada', 'No se encontro el domicilio', 91);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reclamos`
--

CREATE TABLE `reclamos` (
  `id` int(11) NOT NULL,
  `dni` varchar(8) NOT NULL,
  `fecha` date NOT NULL,
  `serial` varchar(15) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `idestado` varchar(10) DEFAULT NULL,
  `responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reclamos`
--

INSERT INTO `reclamos` (`id`, `dni`, `fecha`, `serial`, `descripcion`, `idestado`, `responsable`) VALUES
(91, '44765283', '2023-11-08', '777777', 'La cocina perdió las perillas, se descascararon y desintegraron.', 'COCLIS', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `idserviciotecnico` int(11) NOT NULL,
  `idtecnico` int(11) NOT NULL,
  `tipo` enum('F','D') DEFAULT NULL,
  `direccion` varchar(40) DEFAULT NULL,
  `estado` enum('1-asignada','2-pendiente','3-completada','4-cancelada') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `idreclamo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`idserviciotecnico`, `idtecnico`, `tipo`, `direccion`, `estado`, `descripcion`, `idreclamo`) VALUES
(9, 5, 'F', '', '3-completada', 'Cocina reparada', 91);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `contra`, `nombreYapellido`, `rol`) VALUES
(1, 'admin', 'admin', 'Lucas Quaroni', 'A'),
(2, 'tecnico', 'tecnico', 'Marcelo Benitez', 'T'),
(3, 'chofer', 'chofer', 'Mateo Bodini', 'C'),
(4, 'chofercito', 'chofercito', 'Guido Cardarelli', 'C'),
(5, 'tecniquito', 'tecniquito', 'Joaquin Vesco', 'T');

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
  ADD KEY `serial` (`serial`),
  ADD KEY `responsable` (`responsable`),
  ADD KEY `idestado` (`idestado`);

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
  MODIFY `idflete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `reclamos`
--
ALTER TABLE `reclamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idserviciotecnico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `reclamos_ibfk_4` FOREIGN KEY (`responsable`) REFERENCES `usuarios` (`idusuario`),
  ADD CONSTRAINT `reclamos_ibfk_5` FOREIGN KEY (`idestado`) REFERENCES `estados` (`idestado`);

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
