-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-04-2024 a las 19:09:34
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
-- Base de datos: `apes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agregar_materiales`
--

CREATE TABLE `agregar_materiales` (
  `id` int(255) NOT NULL,
  `material` varchar(550) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `agregar_materiales`
--

INSERT INTO `agregar_materiales` (`id`, `material`, `unidad`, `descripcion`) VALUES
(1, 'Tornillos', 'Caja', 'Instrumento con que se mantienen sujetas las piezas que se están trabajando'),
(2, 'Cemento', 'bulto', 'para pegar cosas'),
(6, 'arena', 'bulto', 'm'),
(7, 'pintura', 'litros', 'para pintar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` int(11) NOT NULL,
  `producto` varchar(550) NOT NULL,
  `descripcion` varchar(800) NOT NULL,
  `unidad` varchar(30) NOT NULL,
  `precio` int(8) NOT NULL,
  `proveedor` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `producto`, `descripcion`, `unidad`, `precio`, `proveedor`) VALUES
(1, 'Cemento', 'Para pegar ladrillos', '', 1000, 'azul'),
(2, 'cemento', 'para pegar ladillos', '', 8000, 'verde'),
(3, 'Cemento', 'Para pegar ladrillos', '', 800, 'amarillo'),
(4, 'Tornillos', '', 'caja', 540, 'Azul'),
(5, 'Cemento', '', 'bulto', 850, 'Amarilo'),
(6, 'Cemento', 'para pegar', 'bulto', 850, 'Amarilo'),
(7, 'arena', 'arena', 'bulto', 700, 'verde');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `obras`
--

CREATE TABLE `obras` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `presupuesto` decimal(10,2) NOT NULL,
  `director_de_obra` varchar(250) NOT NULL,
  `residente` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `obras`
--

INSERT INTO `obras` (`id`, `nombre`, `descripcion`, `fecha_inicio`, `presupuesto`, `director_de_obra`, `residente`) VALUES
(1, 'copacabana', 'cabañás bonitas', '2024-03-03', 1800.56, 'juan', 'taylor'),
(2, 'argentina', 'monumento bonito', '2024-03-09', 5678.90, 'sofia\r\n', 'sebas'),
(4, 'coveñás', 'hotel', '2024-03-13', 3456.00, 'Oscar\r\n', 'taylor'),
(5, 'parques del ríó', 'retoque de obra', '2024-03-26', 3456000.00, 'Andres', 'sebas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `obra_id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `producto` varchar(100) NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad` varchar(50) NOT NULL,
  `fecha_pedido` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(2) NOT NULL,
  `historial` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `obra_id`, `usuario`, `producto`, `precio`, `cantidad`, `unidad`, `fecha_pedido`, `estado`, `historial`) VALUES
(1, 2, 'ocho', 'cemento', 0, 22, 'bulto', '2024-03-15 20:20:50', 11, 3),
(2, 2, 'ocho', 'varillas', 0, 25, 'metro', '2024-03-15 20:20:50', 11, 0),
(3, 1, 'ocho', 'arroz', 1000, 10, 'bulto', '2024-03-15 20:20:50', 11, 0),
(4, 1, 'ocho', 'lentejas', 500, 10, 'bulto', '2024-03-15 20:20:50', 11, 0),
(5, 4, 'ocho', 'arroz', 0, 10, 'bulto', '2024-03-15 20:20:50', 11, 0),
(6, 5, 'ocho', 'chokocrispi', 2000, 10, 'bulto', '2024-03-15 20:20:50', 11, 0),
(7, 5, 'ocho', 'frutloops', 7000, 10, 'bulto', '2024-03-15 20:20:50', 11, 0),
(36, 1, 'SOLI1', 'arena', 0, 10, 'bulto', '2024-04-03 03:33:33', 12, 0),
(39, 4, 'SOLI3', 'Tornillos', 0, 3, 'cajas', '2024-04-03 03:34:28', 0, 0),
(40, 5, 'UR1', 'Cemento', 0, 55, 'bulto', '2024-04-03 03:34:46', 9, 0),
(41, 2, 'UR2', 'pintura', 0, 6, 'lata', '2024-04-03 03:37:16', 10, 0),
(42, 2, 'UR2', 'Cemento', 0, 5, 'bulto', '2024-04-03 03:37:16', 10, 0),
(43, 2, 'UR3', 'Tornillos', 0, 5, 'cajas', '2024-04-03 03:37:32', 10, 0),
(45, 1, 'SOLI2', 'Tornillos', 0, 5, 'cajas', '2024-04-03 03:42:46', 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(255) NOT NULL,
  `proveedor` varchar(550) NOT NULL,
  `nit` char(10) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `telefono` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `proveedor`, `nit`, `correo`, `telefono`) VALUES
(1, 'Azul', '123', 'azul@azul', 321),
(2, 'Amarilo', '432', 'amarillo@amarillo', 456),
(3, 'verde', '5657', 'verde@verde.com', 657);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `identificacion` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `identificacion`, `nombre`, `email`, `contrasena`, `rol`) VALUES
(1, 11, 'vale', 'vale@vale', '11', 1),
(2, 12, 'salem', 'salem@salem', '12', 2),
(3, 15, 'yaya', 'yaya@salem', '15', 3),
(4, 14, 'elkin', 'elkin@salem', '14', 4),
(5, 13, 'taylor', 'test3@gmail.com', '13', 5);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agregar_materiales`
--
ALTER TABLE `agregar_materiales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `material` (`material`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `obras`
--
ALTER TABLE `obras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obra_id` (`obra_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `proveedor` (`proveedor`),
  ADD UNIQUE KEY `nit` (`nit`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agregar_materiales`
--
ALTER TABLE `agregar_materiales`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `obras`
--
ALTER TABLE `obras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`obra_id`) REFERENCES `obras` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
