-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-07-2018 a las 18:14:48
-- Versión del servidor: 5.7.22-0ubuntu0.16.04.1
-- Versión de PHP: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion-foysi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nif` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domicilio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdpostal` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `movil` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nif`, `nombre`, `apellidos`, `domicilio`, `cdpostal`, `movil`, `email`) VALUES
(3, '50430076T', 'CLIENTE', 'GENÉRICO PARA ENCARGOS SIN FACTURA', 'C/HOLANDA, 2 LOCAL 13', '28943', '652583537', 'joseluis.serrano@foysi.es'),
(4, NULL, 'Manuela', NULL, NULL, NULL, NULL, NULL),
(6, NULL, 'Pollera', NULL, NULL, NULL, NULL, NULL),
(8, NULL, 'Soledad', NULL, NULL, NULL, NULL, NULL),
(9, NULL, 'boda', NULL, NULL, NULL, NULL, NULL),
(10, NULL, 'PRUEBAS', NULL, NULL, NULL, NULL, NULL),
(11, NULL, 'Daniel', NULL, NULL, NULL, NULL, NULL),
(12, NULL, 'Marta', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conexion`
--

CREATE TABLE `conexion` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `IP` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `conexion`
--

INSERT INTO `conexion` (`id`, `descripcion`, `usuario_id`, `fecha`, `IP`) VALUES
(39, 'Inicio Conexión', 1, '2018-06-05 18:26:30', NULL),
(40, 'Inicio Conexión', 1, '2018-06-05 18:26:43', NULL),
(41, 'Inicio Conexión', 1, '2018-06-06 04:52:58', NULL),
(42, 'Inicio Conexión', 1, '2018-06-06 05:43:51', NULL),
(43, 'Inicio Conexión', 1, '2018-06-06 16:41:27', NULL),
(44, 'Inicio Conexión', 1, '2018-06-08 17:44:56', NULL),
(45, 'Inicio Conexión', 1, '2018-06-12 18:02:09', NULL),
(46, 'Inicio Conexión', 1, '2018-06-13 16:33:42', NULL),
(47, 'Inicio Conexión', 1, '2018-06-14 17:24:59', NULL),
(48, 'Inicio Conexión', 1, '2018-06-15 11:15:19', NULL),
(49, 'Inicio Conexión', 1, '2018-06-22 16:03:24', NULL),
(50, 'Inicio Conexión', 1, '2018-06-26 16:27:02', NULL),
(51, 'Inicio Conexión', 1, '2018-06-27 16:40:14', NULL),
(52, 'Inicio Conexión', 1, '2018-06-30 10:58:52', NULL),
(53, 'Inicio Conexión', 1, '2018-07-02 17:40:31', NULL),
(54, 'Inicio Conexión', 1, '2018-07-04 17:36:51', NULL),
(55, 'Inicio Conexión', 1, '2018-07-10 16:27:47', NULL),
(56, 'Inicio Conexión', 1, '2018-07-11 15:47:10', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuentos`
--

CREATE TABLE `descuentos` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `porcentaje` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `descuentos`
--

INSERT INTO `descuentos` (`id`, `descripcion`, `porcentaje`) VALUES
(1, '5%', 5),
(2, '10%', 10),
(3, '15%', 15),
(4, '20%', 20),
(5, '50%', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_pedido`
--

CREATE TABLE `estado_pedido` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `estado_pedido`
--

INSERT INTO `estado_pedido` (`id`, `descripcion`) VALUES
(1, 'Pendiente'),
(2, 'Pagado'),
(3, 'Pendiente de Pago'),
(4, 'En Elaboración'),
(5, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_usuario`
--

CREATE TABLE `estado_usuario` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `estado_usuario`
--

INSERT INTO `estado_usuario` (`id`, `descripcion`) VALUES
(1, 'ACTIVO'),
(2, 'BLOQUEADO'),
(3, 'Cambio de Password'),
(4, 'Primera Entrada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `ejercicio` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineas_pedido`
--

CREATE TABLE `lineas_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `sevicio_id` int(11) DEFAULT NULL,
  `unidades` int(11) NOT NULL,
  `fechaSesion` datetime DEFAULT NULL,
  `numeroFoto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `importeUnitario` double DEFAULT NULL,
  `baseImponible` double DEFAULT NULL,
  `cuotaIVA` double DEFAULT NULL,
  `totalLinea` double DEFAULT NULL,
  `totalservicio` double DEFAULT NULL,
  `descuento` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lineas_pedido`
--

INSERT INTO `lineas_pedido` (`id`, `pedido_id`, `sevicio_id`, `unidades`, `fechaSesion`, `numeroFoto`, `observaciones`, `importeUnitario`, `baseImponible`, `cuotaIVA`, `totalLinea`, `totalservicio`, `descuento`) VALUES
(2, 1, 1, 1, '2018-05-12 00:00:00', NULL, NULL, 33.06, 33.06, 6.9426, 40.0026, 33.06, 0),
(5, 1, 3, 2, NULL, '14799, 14781', NULL, 1.24, 2.48, 0.5208, 3.0008, 2.48, 0),
(6, 1, 4, 2, NULL, '14778, 14802', NULL, 0.83, 1.66, 0.3486, 2.0086, 1.66, 0),
(17, 6, 4, 61, NULL, NULL, NULL, 0.83, 25.315, 5.31615, 30.63115, 50.63, 25.315),
(19, 8, 3, 3, NULL, '14781(2)-14799(1)', NULL, 1.24, 3.72, 0.7812, 4.5012, 3.72, 0),
(20, 8, 4, 1, NULL, '14809', NULL, 0.83, 0.83, 0.1743, 1.0043, 0.83, 0),
(21, 9, 11, 1, '2018-05-22 00:00:00', NULL, NULL, 4.14, 4.14, 0.8694, 5.0094, 4.14, 0),
(22, 10, 13, 1, '2018-05-24 00:00:00', NULL, NULL, 5, 4, 0.84, 4.84, 5, 1),
(23, 10, 3, 3, NULL, NULL, NULL, 1.24, 2.976, 0.62496, 3.60096, 3.72, 0.744),
(24, 10, 4, 3, NULL, NULL, NULL, 0.83, 1.992, 0.41832, 2.41032, 2.49, 0.498),
(25, 11, 11, 1, '2018-05-28 00:00:00', NULL, NULL, 4.14, 4.14, 0.8694, 5.0094, 4.14, 0),
(26, 13, 11, 1, '2018-05-30 00:00:00', NULL, NULL, 4.14, 4.14, 0.8694, 5.0094, 4.14, 0),
(27, 14, 14, 1, '2018-06-05 00:00:00', NULL, NULL, 4.14, 4.14, 0.8694, 5.0094, 4.14, 0),
(28, 15, 11, 2, NULL, NULL, NULL, 4.14, 8.28, 1.7388, 10.0188, 8.28, 0),
(29, 16, 3, 7, NULL, '15054', '50 copias 7x4,5', 1.24, 8.68, 1.8228, 10.5028, 8.68, 0),
(30, 16, 4, 12, NULL, '15054, 15071', NULL, 0.83, 9.96, 2.0916, 12.0516, 9.96, 0),
(31, 16, 11, 1, NULL, NULL, NULL, 4.14, 4.14, 0.8694, 5.0094, 4.14, 0),
(32, 17, 11, 2, '2018-06-18 00:00:00', NULL, NULL, 4.14, 8.28, 1.7388, 10.0188, 8.28, 0),
(35, 20, 1, 1, '2018-06-27 00:00:00', NULL, NULL, 33.06, 26.448, 5.55408, 32.00208, 33.06, 6.612),
(36, 21, 11, 1, '2018-06-30 00:00:00', NULL, NULL, 4.14, 4.14, 0.8694, 5.0094, 4.14, 0),
(37, 22, 11, 1, '2018-07-04 00:00:00', NULL, NULL, 4.14, 4.14, 0.8694, 5.0094, 4.14, 0),
(38, 24, 9, 1, '2018-05-10 00:00:00', NULL, NULL, 60, 60, 12.6, 72.6, 60, 0),
(39, 25, 10, 1, NULL, NULL, NULL, 100, 100, 21, 121, 100, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `estado_pedido_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descuento_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `estado_pedido_id`, `fecha`, `observaciones`, `descuento_id`) VALUES
(1, 4, 1, '2018-05-12 00:00:00', 'Sesión de Estudio', NULL),
(6, 6, 1, '2018-05-22 00:00:00', 'Copias', 5),
(8, 4, 1, '2018-05-23 00:00:00', 'Copias', NULL),
(9, 8, 1, '2018-05-22 00:00:00', 'Foto Carnet 4+1', NULL),
(10, 9, 1, '2018-05-24 00:00:00', 'Escaneado de Fotos y copias', 4),
(11, 3, 1, '2018-05-28 00:00:00', 'Foto Carnet 4+1', NULL),
(13, 3, 1, '2018-05-30 00:00:00', 'Foto Carnet 4+1', NULL),
(14, 3, 1, '2018-06-06 00:00:00', 'Composición para Cumpleaños', NULL),
(15, 3, 1, '2018-06-08 00:00:00', 'Foto Carnet 4+1', NULL),
(16, 3, 1, '2018-06-12 00:00:00', 'Retrato y copias', NULL),
(17, 3, 1, '2018-06-18 00:00:00', '2 fotos de Carnet', NULL),
(20, 11, 1, '2018-06-27 00:00:00', 'Sesión Estudio', 4),
(21, 12, 1, '2018-06-30 00:00:00', 'Foto Carnet 4 +1', NULL),
(22, 3, 1, '2018-07-04 00:00:00', 'Foto Carnet 8', NULL),
(24, 3, 1, '2018-05-10 00:00:00', 'Taller Basico', NULL),
(25, 3, 1, '2018-06-30 00:00:00', 'Taller Basico', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `cif` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `razonSocial` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domicilio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cdpostal` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `movil` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `cif`, `nombre`, `razonSocial`, `domicilio`, `cdpostal`, `movil`, `email`) VALUES
(1, 'B85049435', '1and1', '1&1 Internet España S.L.U.', 'Avenida de La Vega, 1 - Edificio Veganova (Edif.3 planta 5º puerta C)', '28018', '912789435', 'facturacion@1and1.es');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibos`
--

CREATE TABLE `recibos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ejercicio` int(11) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `recibos`
--

INSERT INTO `recibos` (`id`, `pedido_id`, `fecha`, `observaciones`, `ejercicio`, `numero`) VALUES
(2, 1, '2018-05-12 00:00:00', NULL, 2018, 101),
(3, 6, '2018-05-22 00:00:00', NULL, 2018, 102),
(4, 8, '2018-05-23 00:00:00', NULL, 2018, 103),
(5, 9, '2018-05-22 00:00:00', NULL, 2018, 104),
(6, 10, '2018-05-24 00:00:00', NULL, 2018, 105),
(7, 11, '2018-05-28 00:00:00', NULL, 2018, 106),
(8, 13, '2018-05-30 00:00:00', NULL, 2018, 107),
(9, 14, '2018-06-06 00:00:00', NULL, 2018, 108),
(10, 15, '2018-06-08 00:00:00', NULL, 2018, 109),
(12, 16, '2018-06-12 00:00:00', NULL, 2018, 110),
(13, 17, '2018-06-18 00:00:00', NULL, 2018, 111),
(17, 21, '2018-06-30 00:00:00', NULL, 2018, 112),
(18, 20, '2018-06-27 00:00:00', NULL, 2018, 113),
(20, 24, '2018-05-10 00:00:00', NULL, 2018, 100),
(22, 25, '2018-06-30 00:00:00', NULL, 2018, 114),
(23, 22, '2018-07-04 00:00:00', NULL, 2018, 115);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `importeUnitario` double NOT NULL,
  `importeIVA` double NOT NULL,
  `cuotaIVA` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `descripcion`, `importeUnitario`, `importeIVA`, `cuotaIVA`) VALUES
(1, 'Sesión Fotografica', 33.06, 40, 6.94),
(2, 'Copia Digital Tamaño A3', 2.48, 3, 0.52),
(3, 'Copia Digital Tamaño A4', 1.24, 1.5, 0.26),
(4, 'Copia Digital Tamaño 13x18', 0.83, 1, 0.17),
(5, 'Revelado Carrete en Blanco y Negro', 4.14, 5, 0.96),
(6, 'Copia Analógica Papel RC tamaño 13x18', 0.83, 1, 0.17),
(7, 'Copia Analógica Papel RC Tamaño 18x24', 1.24, 1.5, 0.26),
(8, 'Copia Analógica Papel RC tamaño 20x25', 2.48, 3, 0.52),
(9, 'Taller Fotografía Básico Grupo', 60, 60, 0),
(10, 'Taller Fotografía Básico Individual', 100, 100, 0),
(11, 'Foto Carnet', 4.14, 5, 0.96),
(12, 'Reportaje Digital', 289.26, 350, 60.74),
(13, 'Servicio de Escaner', 5, 6.05, 1.05),
(14, 'Composición Fotografíca', 4.14, 5, 0.86);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `estado_usuario_id` int(11) DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellidos` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `perfil` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `estado_usuario_id`, `codigo`, `nombre`, `apellidos`, `perfil`, `email`, `password`) VALUES
(1, 1, 'jluis', 'José Luis', 'Serrano Barrera', 'ROLE_ADMIN', 'joseluis.serrano@foysi.es', '$2a$04$6hrOySfXa0nxb3AHBqJ8i.9uIOk1GmkfXcyv/.nDfyyC7wvfs62Ma');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nif_uk` (`nif`);

--
-- Indices de la tabla `conexion`
--
ALTER TABLE `conexion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`usuario_id`) USING BTREE;

--
-- Indices de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_622B9C0F4854653A` (`pedido_id`);

--
-- Indices de la tabla `lineas_pedido`
--
ALTER TABLE `lineas_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D2DE2C134854653A` (`pedido_id`),
  ADD KEY `IDX_D2DE2C137C169098` (`sevicio_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6716CCAADE734E51` (`cliente_id`),
  ADD KEY `IDX_6716CCAA961E0D4C` (`estado_pedido_id`),
  ADD KEY `idx_pedidos_descuento_id` (`descuento_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cif_uk` (`cif`);

--
-- Indices de la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_46247D214854653A` (`pedido_id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EF687F26280DDFF` (`estado_usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `conexion`
--
ALTER TABLE `conexion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT de la tabla `descuentos`
--
ALTER TABLE `descuentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `estado_pedido`
--
ALTER TABLE `estado_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `estado_usuario`
--
ALTER TABLE `estado_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `lineas_pedido`
--
ALTER TABLE `lineas_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `recibos`
--
ALTER TABLE `recibos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `conexion`
--
ALTER TABLE `conexion`
  ADD CONSTRAINT `FK_847691C1DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `FK_622B9C0F4854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `lineas_pedido`
--
ALTER TABLE `lineas_pedido`
  ADD CONSTRAINT `FK_D2DE2C134854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D2DE2C137C169098` FOREIGN KEY (`sevicio_id`) REFERENCES `servicios` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `FK_6716CCAA961E0D4C` FOREIGN KEY (`estado_pedido_id`) REFERENCES `estado_pedido` (`id`),
  ADD CONSTRAINT `FK_6716CCAADE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_pedidos_descuentos` FOREIGN KEY (`descuento_id`) REFERENCES `descuentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recibos`
--
ALTER TABLE `recibos`
  ADD CONSTRAINT `FK_46247D214854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_EF687F26280DDFF` FOREIGN KEY (`estado_usuario_id`) REFERENCES `estado_usuario` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
