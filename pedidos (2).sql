-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-05-2024 a las 23:04:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
  `historial` int(5) NOT NULL,
  `descuento` int(2) NOT NULL,
  `impuesto` int(2) NOT NULL,
  `proveedor` varchar(155) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `obra_id`, `usuario`, `producto`, `precio`, `cantidad`, `unidad`, `fecha_pedido`, `estado`, `historial`, `descuento`, `impuesto`, `proveedor`) VALUES
(1, 1, 'taylor', 'Cemento', 1000, 5, 'litro', '2024-04-07 21:37:33', 0, 0, 0, 19, 'azul'),
(2, 1, 'taylor', 'pintura', 0, 457, 'galon', '2024-04-07 21:37:33', 0, 0, 0, 0, ''),
(3, 1, 'taylor', 'Tornillos', 540, 567, 'tr', '2024-04-07 21:37:33', 0, 0, 0, 0, ''),
(4, 1, 'taylor', 'arena', 55, 7, 'bultos', '2024-04-16 18:13:30', 1, 0, 5, 5, ''),
(5, 1, 'taylor', 'Cemento', 1000, 8, 'bultos', '2024-04-16 18:13:30', 1, 0, 0, 19, 'azul'),
(6, 1, 'taylor', 'pintura', 0, 3, 'litros', '2024-04-16 18:13:30', 1, 0, 0, 0, ''),
(7, 1, 'taylor', 'Tornillos', 540, 4, 'cajas', '2024-04-16 18:13:30', 1, 0, 0, 0, ''),
(8, 2, 'yaya', '5', 0, 1, 'unidad', '2024-04-19 23:25:50', 1, 0, 0, 0, ''),
(9, 2, 'yaya', '8', 0, 1, 'unidad', '2024-04-19 23:25:50', 1, 0, 0, 0, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
