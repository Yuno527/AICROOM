-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2025 a las 23:57:09
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aicroom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_historial`
--

CREATE TABLE `tbl_historial` (
  `Id_historial` bigint(20) NOT NULL,
  `Id_UsuarioFK` bigint(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `estado` enum('Completado','Cancelado','Abandonado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_historial`
--

INSERT INTO `tbl_historial` (`Id_historial`, `Id_UsuarioFK`, `fecha`, `estado`) VALUES
(1, 1, '2025-07-18', 'Completado'),
(2, 1, '2025-07-21', 'Completado'),
(3, 1, '2025-07-21', 'Completado'),
(4, 1, '2025-07-22', 'Completado'),
(5, 1, '2025-07-22', 'Completado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_respuestas`
--

CREATE TABLE `tbl_respuestas` (
  `Id_respuesta` bigint(20) NOT NULL,
  `Id_historial` bigint(20) DEFAULT NULL,
  `pregunta` text DEFAULT NULL,
  `respuesta` text DEFAULT NULL,
  `puntaje` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_resultados`
--

CREATE TABLE `tbl_resultados` (
  `Id_resultado` bigint(20) NOT NULL,
  `Id_historiaLFK` bigint(20) DEFAULT NULL,
  `puntaje_total` int(100) DEFAULT NULL,
  `resultado_final` text DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `Id_Usuario` bigint(20) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `contraseña` varchar(50) DEFAULT NULL,
  `correo` varchar(50) DEFAULT NULL,
  `empresa_donde_labora` varchar(100) DEFAULT NULL,
  `puesto` varchar(100) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `rol` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`Id_Usuario`, `nombre`, `contraseña`, `correo`, `empresa_donde_labora`, `puesto`, `fecha_registro`, `rol`) VALUES
(1, 'Breiner', 'breiner2025', 'breiner@aicroom.com', NULL, NULL, '2025-07-18', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  ADD PRIMARY KEY (`Id_historial`),
  ADD KEY `Id_UsuarioFK` (`Id_UsuarioFK`);

--
-- Indices de la tabla `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  ADD PRIMARY KEY (`Id_respuesta`),
  ADD KEY `Id_historial` (`Id_historial`);

--
-- Indices de la tabla `tbl_resultados`
--
ALTER TABLE `tbl_resultados`
  ADD PRIMARY KEY (`Id_resultado`),
  ADD KEY `Id_historiaLFK` (`Id_historiaLFK`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`Id_Usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  MODIFY `Id_historial` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  MODIFY `Id_respuesta` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_resultados`
--
ALTER TABLE `tbl_resultados`
  MODIFY `Id_resultado` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `Id_Usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_historial`
--
ALTER TABLE `tbl_historial`
  ADD CONSTRAINT `tbl_historial_ibfk_1` FOREIGN KEY (`Id_UsuarioFK`) REFERENCES `tbl_usuario` (`Id_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_respuestas`
--
ALTER TABLE `tbl_respuestas`
  ADD CONSTRAINT `tbl_respuestas_ibfk_1` FOREIGN KEY (`Id_historial`) REFERENCES `tbl_historial` (`Id_historial`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_resultados`
--
ALTER TABLE `tbl_resultados`
  ADD CONSTRAINT `tbl_resultados_ibfk_1` FOREIGN KEY (`Id_historiaLFK`) REFERENCES `tbl_historial` (`Id_historial`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
