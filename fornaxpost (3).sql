-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2023 a las 03:22:34
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
  `garantia` enum('S','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `artefactos`
--

INSERT INTO `artefactos` (`serial`, `modelo`, `garantia`) VALUES
('12989898', 'FORNAX FIT 50', 'S'),
('43322236', 'FREIDORA FRIT FRIT', 'N'),
('55443', 'freidora voladora', 'S'),
('777777', 'FREIDORA NUEVA', 'N'),
('98882234', 'FORNAX RISTORANTE', 'S');

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
('44232238', 'Marcelo Benitez', 'Balbo 4156', '3415690470', 'marcebenitez2@gmail.com', 'Santa Fe', 'Rosario', '2000', 'casa negra'),
('44765283', 'Lucas Quaroni', 'Alvear 12', '3416956364', 'lucas.quaroni@gmail.com', 'Santa Fe', 'Rosario', '2000', 'Casa portón negro, frente a la estación de servicio GNC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idestado` varchar(10) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idestado`, `nombre`, `descripcion`) VALUES
('CAN', 'CANCELADO', 'Reclamo cancelado'),
('COCINS', 'Cocina inservib', 'El admin debe contactarse con el dueño de la cocin'),
('COCLIS', 'Cocina lista', 'La cocina esta lista para devolver, el tecnico la '),
('ENFAB', 'En fabrica', 'La cocina se encuentra en fabrica, esperando que s'),
('ENVIMP', 'Envio imposible', 'El admin debe revisar el reclamo ya que no pudo ll'),
('ENVPEN', 'Envio pendiente', 'El chofer tiene un envio pendiente a su nombre'),
('FIN', 'FINALIZADO', 'Reclamo finalizado y solucionado con exito'),
('PEN', 'Pendiente', 'El reclamo es creado, y se encuentra pendiente de '),
('REPPEN', 'Reparacion pend', 'El tecnico teiene una reparaciòn pendiente, asigna'),
('RETIMP', 'Retiro imposibl', 'El admin debe revisar el reclamo ya que no pudo ll'),
('RETPEN', 'Retiro pendient', 'El chofer tiene un retiro pendiente, asignado a su'),
('REVPEN', 'Revision pendie', 'El admin debe revisar el reclamo, ya que el tecnic'),
('VISPEN', 'Visita pendient', 'El tecnico tiene una visita pendiente, asignada a ');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `fletes`
--

INSERT INTO `fletes` (`idflete`, `idchofer`, `tipo`, `direccion`, `estado`, `descripcion`, `idreclamo`) VALUES
(1, 3, 'R', 'alvear 21', 'asignada', 'llevar por el medidia', 86),
(2, 4, 'D', 'Segui 300', 'asignada', 'llevar en todo el dia', 87);

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
  `idestado` varchar(3) DEFAULT NULL,
  `responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reclamos`
--

INSERT INTO `reclamos` (`id`, `dni`, `fecha`, `serial`, `descripcion`, `idestado`, `responsable`) VALUES
(86, '44765283', '2023-11-02', '777777', 'consume mucho aceite', 'PEN', 1),
(87, '44232238', '2023-11-02', '55443', 'no vuela', 'PEN', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(4, 'chofercito', 'chofercito', 'Guido Cardarelli', 'C');

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
  ADD KEY `responsable` (`responsable`);

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
  MODIFY `idflete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reclamos`
--
ALTER TABLE `reclamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `idserviciotecnico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `reclamos_ibfk_4` FOREIGN KEY (`responsable`) REFERENCES `usuarios` (`idusuario`);

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
