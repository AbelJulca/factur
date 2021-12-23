CREATE TABLE `ACCESO_ALMACEN` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idalmacen` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `ALMACEN` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `condicion` varchar(15) DEFAULT NULL COMMENT '1 existente/2 virtual',
  `idsucursal` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `ARTICULO` (
  `codigo` int(11) NOT NULL,
  `nombre_comercial` varchar(100) DEFAULT NULL,
  `nombre_generico` varchar(100) DEFAULT NULL,
  `idcategoria` int(11) DEFAULT NULL,
  `sku` varchar(45) DEFAULT NULL,
  `idlaboratorio` int(11) DEFAULT NULL,
  `idtipoarticulo` int(11) DEFAULT NULL,
  `idafectacion` char(2) DEFAULT NULL,
  `porcentaje_ganancia` decimal(11,2) DEFAULT NULL,
  `idunidad` varchar(3) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);


CREATE TABLE `BARRAS_PERFIL` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `padre` varchar(2) DEFAULT NULL,
  `ruta` varchar(150) DEFAULT NULL,
  `idperfil` int(11) DEFAULT NULL,
  `icono` varchar(255) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `CAJA` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `idacceso_almacen` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `monto_apertura` decimal(11,2) DEFAULT NULL,
  `factura` decimal(11,2) DEFAULT NULL,
  `boleta` decimal(11,2) DEFAULT NULL,
  `ticket` decimal(11,2) DEFAULT NULL,
  `monto_cierre` decimal(11,2) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);


CREATE TABLE `CATEGORIA` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);

CREATE TABLE `CATEGORIA_COMPROBANTE` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);

CREATE TABLE `CLIENTE` (
  `codigo` int(11) NOT NULL,
  `iddocumento` char(1) DEFAULT NULL,
  `nrodocu` varchar(15) DEFAULT NULL,
  `razon_social` varchar(1000) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `idpais` char(2) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `COMPRAS` (
  `codigo` int(11) NOT NULL,
  `idtipocomp` char(2) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_registro` datetime DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_icbper` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `idmoneda` varchar(4) DEFAULT NULL,
  `idformapago` int(11) DEFAULT NULL,
  `idcomprobante` char(2) DEFAULT NULL,
  `ingreso_almacen` varchar(2) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idalmacen` int(11) DEFAULT NULL,
  `idproveedor` int(11) DEFAULT NULL,
  `glosa` varchar(150) DEFAULT NULL,
  `serie_ref` char(4) DEFAULT NULL,
  `correlativo_ref` int(11) DEFAULT NULL,
  `guia_remision` varchar(15) DEFAULT NULL,
  `flete` decimal(11,2) DEFAULT NULL,
  `idperiodo` int(11) DEFAULT NULL,
  `tipo_cambio` decimal(11,3) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);


CREATE TABLE `CUOTA` (
  `codigo` int(11) NOT NULL,
  `idventa` int(11) DEFAULT NULL,
  `item` varchar(8) DEFAULT NULL,
  `fecha_limite` date DEFAULT NULL,
  `idmoneda` varchar(4) DEFAULT NULL,
  `monto` decimal(11,2) DEFAULT NULL,
  `fecha_pago` decimal(8,2) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL
);

CREATE TABLE `DETALLE_ARTICULO` (
  `codigo` int(11) NOT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `idalmacen` int(11) DEFAULT NULL
);

CREATE TABLE `DETALLE_COMPRAS` (
  `codigo` int(11) NOT NULL,
  `idcompras` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idexistencia_lote` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `cant_icbper` int(11) DEFAULT NULL,
  `imps_icbper` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL
);

CREATE TABLE `DETALLE_MOVIMIENTO` (
  `codigo` int(11) NOT NULL,
  `idexistencia_lote` int(11) DEFAULT NULL,
  `idmovimiento` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
);

CREATE TABLE `DETALLE_ORDEN_COMRAS` (
  `codigo` int(11) NOT NULL,
  `idordencompra` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `cant_icbper` int(11) DEFAULT NULL,
  `imps_icbper` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `DETALLE_PAGO` (
  `codigo` int(11) NOT NULL,
  `idcaja` int(11) DEFAULT NULL,
  `idventa` int(11) DEFAULT NULL,
  `monto_efectivo` decimal(11,2) DEFAULT NULL,
  `monto_visa` decimal(11,2) DEFAULT NULL,
  `descripcion_visa` varchar(45) DEFAULT NULL,
  `num_operacion_visa` varchar(45) DEFAULT NULL,
  `pago_con` decimal(11,2) DEFAULT NULL,
  `vuelto` decimal(11,2) DEFAULT NULL
);

CREATE TABLE `DETALLE_SERIE` (
  `codigo` int(11) NOT NULL,
  `idsucursal` int(11) DEFAULT NULL,
  `idserie` int(11) DEFAULT NULL
);

CREATE TABLE `DETALLE_VENTA` (
  `codigo` int(11) NOT NULL,
  `idventa` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `idexistencia_lotes` int(11) DEFAULT NULL,
  `cantidad` varchar(45) DEFAULT NULL,
  `precio_compra` decimal(11,2) DEFAULT NULL,
  `valor_unitario` decimal(11,2) DEFAULT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `cant_icbper` int(11) DEFAULT NULL,
  `imps_icbper` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `porcentaje_igv` decimal(11,2) DEFAULT NULL,
  `valor_total` decimal(11,2) DEFAULT NULL,
  `importe_total` decimal(11,2) DEFAULT NULL
);

CREATE TABLE `EJERCICIO` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `actual` int(11) DEFAULT NULL
);

CREATE TABLE `EMPRESA` (
  `codigo` int(11) NOT NULL,
  `tipodoc` char(1) DEFAULT NULL,
  `ruc` varchar(15) DEFAULT NULL,
  `razon_social` varchar(1000) DEFAULT NULL,
  `nombre_comercial` varchar(1000) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `idpais` char(2) DEFAULT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  `provincia` varchar(100) DEFAULT NULL,
  `distrito` varchar(100) DEFAULT NULL,
  `ubigeo` char(6) DEFAULT NULL,
  `usuario_sol_sec` varchar(45) DEFAULT NULL,
  `clave_sol_sec` varchar(45) DEFAULT NULL,
  `modo_ft_notas` varchar(45) DEFAULT NULL,
  `modo_guias` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `EXISTENCIA_LOTES` (
  `codigo` int(11) NOT NULL,
  `codigo_lote` varchar(45) DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `barras` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `idalmacen` int(11) DEFAULT NULL,
  `precio_referencial` decimal(11,2) DEFAULT NULL
);

CREATE TABLE `FORMA_PAGO` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(30) DEFAULT NULL,
  `codigo_sunat` char(1) DEFAULT NULL,
  `glosa_sunat` varchar(45) DEFAULT NULL,
  `cantidad_dias` int(11) DEFAULT NULL
);


CREATE TABLE `GUIA_DETALLE` (
  `codigo` int(11) NOT NULL,
  `idguiaremision` int(11) DEFAULT NULL,
  `idarticulo` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL
);

CREATE TABLE `GUIA_REMISION` (
  `codigo` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idperiodo` int(11) DEFAULT NULL,
  `idtipocomp` char(2) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `fecha_envio` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `peso` decimal(8,2) DEFAULT NULL,
  `cant_peso` int(11) DEFAULT NULL,
  `idtransporte` char(2) DEFAULT NULL,
  `idmotivo` char(2) DEFAULT NULL,
  `xml` varchar(1000) DEFAULT NULL,
  `cdr` varchar(1000) DEFAULT NULL,
  `hash` varchar(150) DEFAULT NULL,
  `codsunat` varchar(45) DEFAULT NULL,
  `status_sunat` varchar(300) DEFAULT NULL,
  `codsunat_baja` varchar(45) DEFAULT NULL,
  `status_sunat_baja` varchar(300) DEFAULT NULL,
  `ubigeo_llegada` char(6) DEFAULT NULL,
  `direccion_llegada` varchar(255) DEFAULT NULL,
  `ruc_empresa_trans` varchar(11) DEFAULT NULL,
  `rz_empresa_trans` varchar(350) DEFAULT NULL,
  `dni_chofer` varchar(11) DEFAULT NULL,
  `placa` varchar(45) DEFAULT NULL,
  `ubigeo_partida` varchar(45) DEFAULT NULL,
  `direccion_partida` varchar(255) DEFAULT NULL,
  `codpuerto` varchar(45) DEFAULT NULL,
  `num_contenedor` varchar(45) DEFAULT NULL,
  `idtransportista` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `LABORATORIO` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `personal_contacto` varchar(200) DEFAULT NULL,
  `telefono_contacto` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);


CREATE TABLE `MONEDA` (
  `codigo` varchar(4) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);



CREATE TABLE `MOTIVO` (
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
);

CREATE TABLE `MOVIMIENTO` (
  `codigo` int(11) NOT NULL,
  `fecha_registro` datetime DEFAULT NULL COMMENT 'entrada / salida',
  `terminal` varchar(500) DEFAULT NULL,
  `almacen_destino` int(11) DEFAULT NULL,
  `almacen_origen` int(11) DEFAULT NULL,
  `idtipocomp` char(2) DEFAULT NULL,
  `serie_ref` char(4) DEFAULT NULL,
  `correlativo_ref` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idtipo_movimienito` int(11) DEFAULT NULL
);

CREATE TABLE `MOVIMIENTO_CAJA` (
  `codigo` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `usuario_participante` varchar(45) DEFAULT NULL,
  `monto` decimal(11,2) DEFAULT NULL,
  `glosa` varchar(300) DEFAULT NULL,
  `idcaja` int(11) DEFAULT NULL
);

CREATE TABLE `ORDEN_COMPRAS` (
  `codigo` int(11) NOT NULL,
  `idtipocomp` char(2) DEFAULT NULL,
  `serie` varchar(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idalmacen` int(11) DEFAULT NULL,
  `idproveedor` int(11) DEFAULT NULL,
  `idmoneda` varchar(4) DEFAULT NULL,
  `tipo_cambio` decimal(11,3) DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_icbper` decimal(11,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `PADRE_PERFIL` (
  `codigo` int(11) NOT NULL,
  `padre` varchar(2) DEFAULT NULL,
  `idperfil` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `PAIS` (
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);

CREATE TABLE `PERFIL` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL
);

CREATE TABLE `PERIODO` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `f_inicio` date DEFAULT NULL,
  `f_fin` date DEFAULT NULL,
  `idejercicio` int(11) DEFAULT NULL
);

CREATE TABLE `PROVEEDOR` (
  `codigo` int(11) NOT NULL,
  `idtipodoc` char(1) DEFAULT NULL,
  `nrodoc` varchar(15) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `personacontacto` varchar(150) DEFAULT NULL,
  `telefonocontacto` varchar(15) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `SERIE` (
  `codigo` int(11) NOT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `serie` varchar(8) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `referencia` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `SUCURSAL` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL,
  `ubigeo` char(6) DEFAULT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  `provincia` varchar(45) DEFAULT NULL,
  `distrito` varchar(45) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `idempresa` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `TABLA_PARAMETRICA` (
  `codigo` varchar(5) NOT NULL,
  `tipo` char(1) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);


CREATE TABLE `TIPO_AFECTACION` (
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `codigo_afectacion` char(4) DEFAULT NULL,
  `nombre_afectacion` char(6) DEFAULT NULL,
  `tipo_afectacion` char(3) DEFAULT NULL
);

CREATE TABLE `TIPO_ARTICULO` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);

CREATE TABLE `TIPO_COMPROBANTE` (
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `idcategoria` int(11) DEFAULT NULL
);

CREATE TABLE `TIPO_DOCUMENTO` (
  `codigo` char(1) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);


CREATE TABLE `TIPO_MOVIMIENTO` (
  `codigo` int(11) NOT NULL,
  `descripcion` varchar(18) DEFAULT NULL
);

CREATE TABLE `TRANSPORTE` (
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(150) DEFAULT NULL
);

CREATE TABLE `TRANSPORTISTA` (
  `codigo` int(11) NOT NULL,
  `iddocumento` char(1) DEFAULT NULL,
  `nrodoc` varchar(45) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `placa` varchar(45) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `UBIGEO` (
  `codigo_departamento` char(2) NOT NULL,
  `codigo_provincia` char(2) NOT NULL,
  `codigo_distrito` char(2) NOT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  `provincia` varchar(45) DEFAULT NULL,
  `distrito` varchar(45) DEFAULT NULL
);

CREATE TABLE `UNIDAD` (
  `codigo` varchar(3) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL
);

CREATE TABLE `USUARIO` (
  `codigo` int(11) NOT NULL,
  `dni` char(8) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apep` varchar(45) DEFAULT NULL,
  `apem` varchar(45) DEFAULT NULL,
  `ruta_foto` varchar(1000) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `direccion` varchar(1000) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `clave` varchar(45) DEFAULT NULL,
  `idperfil` int(11) DEFAULT NULL,
  `almacen_actual` int(11) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL
);

CREATE TABLE `VENTA` (
  `codigo` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idtipocomp` char(2) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `idperiodo` int(11) DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `idmoneda` varchar(4) DEFAULT NULL,
  `op_gravadas` decimal(11,2) DEFAULT NULL,
  `op_exoneradas` decimal(11,2) DEFAULT NULL,
  `op_inafectas` decimal(11,2) DEFAULT NULL,
  `op_icbper` decimal(8,2) DEFAULT NULL,
  `igv` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `idformapago` int(11) DEFAULT NULL,
  `direccion` varchar(800) DEFAULT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` varchar(255) DEFAULT NULL,
  `mensajesunat` varchar(1000) DEFAULT NULL,
  `tipo_doc_modificar` varchar(5) DEFAULT NULL,
  `numero_referencia` varchar(45) DEFAULT NULL,
  `numero_resumen_baja` varchar(45) DEFAULT NULL,
  `motivo_baja` varchar(5) DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `ticket_resumen_doc` varchar(45) DEFAULT NULL,
  `ticket_resumen_baja` varchar(45) DEFAULT NULL,
  `ruta_xml` varchar(1000) DEFAULT NULL,
  `ruta_cdr` varchar(1000) DEFAULT NULL,
  `rutaxml_baja` varchar(1000) DEFAULT NULL,
  `rutacdr_baja` varchar(1000) DEFAULT NULL,
  `codsunat` varchar(45) DEFAULT NULL,
  `status_sunat` varchar(1000) DEFAULT NULL,
  `fecha_enviosunat` date DEFAULT NULL,
  `codsunat_baja` varchar(45) DEFAULT NULL,
  `statussunat_baja` varchar(1000) DEFAULT NULL,
  `hash` varchar(150) DEFAULT NULL,
  `estado_nc_nd` varchar(45) DEFAULT NULL,
  `estado` bit(1) DEFAULT NULL,
  `baja` varchar(2) DEFAULT NULL
);

-- KEY PRIMARY AND FOREIGN


--
-- Indices de la tabla `acceso_almacen`
--
ALTER TABLE `ACCESO_ALMACEN`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `acceso_almacen_usuario_idx` (`idusuario`),
  ADD KEY `acceso_almacen_almacen_idx` (`idalmacen`);

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `ALMACEN`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `almacen_sucursal_idx` (`idsucursal`);

--
-- Indices de la tabla `articulo`
--
ALTER TABLE `ARTICULO`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `articulo_categoria_idx` (`idcategoria`),
  ADD KEY `articulo_afectacion_idx` (`idafectacion`),
  ADD KEY `articulo_tipo_articulo_idx` (`idtipoarticulo`),
  ADD KEY `articulo_unidad_idx` (`idunidad`),
  ADD KEY `articulo_laboratorio` (`idlaboratorio`);

--
-- Indices de la tabla `barras_perfil`
--
ALTER TABLE `BARRAS_PERFIL`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `barras_perfil_perfil_idx` (`idperfil`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `CAJA`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `caja_acceso_almacen_idx` (`idacceso_almacen`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `CATEGORIA`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `categoria_comprobante`
--
ALTER TABLE `CATEGORIA_COMPROBANTE`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `CLIENTE`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cliente_documento_idx` (`iddocumento`),
  ADD KEY `cliente_pais_idx` (`idpais`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `COMPRAS`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `compras_forma_pago_idx` (`idformapago`),
  ADD KEY `compras_periodo_idx` (`idperiodo`),
  ADD KEY `compras_proveedor_idx` (`idproveedor`),
  ADD KEY `compras_moneda_idx` (`idmoneda`),
  ADD KEY `compras_usuario_idx` (`idusuario`),
  ADD KEY `compras_tipo_comp_idx` (`idtipocomp`);

--
-- Indices de la tabla `cuota`
--
ALTER TABLE `CUOTA`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cuota_venta_idx` (`idventa`);

--
-- Indices de la tabla `detalle_articulo`
--
ALTER TABLE `DETALLE_ARTICULO`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `detalle_articulo_articulo_idx` (`idarticulo`),
  ADD KEY `detalle_articulo_almacen_idx` (`idalmacen`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `DETALLE_COMPRAS`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `detalle_compras_comras_idx` (`idcompras`),
  ADD KEY `detalle_compras_existencia_lote_idx` (`idexistencia_lote`);

--
-- Indices de la tabla `detalle_movimiento`
--
ALTER TABLE `DETALLE_MOVIMIENTO`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `detalle_movimiento_movimiento_idx` (`idmovimiento`),
  ADD KEY `detalle_movimiento_existencia_lotes_idx` (`idexistencia_lote`);

--
-- Indices de la tabla `detalle_orden_comras`
--
ALTER TABLE `DETALLE_ORDEN_COMRAS`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `detalle_orden_compras_idx` (`idordencompra`);

--
-- Indices de la tabla `detalle_pago`
--
ALTER TABLE `DETALLE_PAGO`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `detalle_pago_idx` (`idcaja`),
  ADD KEY `detalle_pago_venta_idx` (`idventa`);

--
-- Indices de la tabla `detalle_serie`
--
ALTER TABLE `DETALLE_SERIE`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `detalle_serie_sucursal_idx` (`idsucursal`),
  ADD KEY `detalle_serie_serie_idx` (`idserie`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `DETALLE_VENTA`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `detalle_venta_venta_idx` (`idventa`),
  ADD KEY `detalle_venta_existencia_lotes_idx` (`idexistencia_lotes`);

--
-- Indices de la tabla `ejercicio`
--
ALTER TABLE `EJERCICIO`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `EMPRESA`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `empresa_pais_idx` (`idpais`);

--
-- Indices de la tabla `existencia_lotes`
--
ALTER TABLE `EXISTENCIA_LOTES`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `lote_articulo_idx` (`idarticulo`),
  ADD KEY `lote_almacen_idx` (`idalmacen`);

--
-- Indices de la tabla `forma_pago`
--
ALTER TABLE `FORMA_PAGO`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `guia_detalle`
--
ALTER TABLE `GUIA_DETALLE`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `guia_detalle_guia_idx` (`idguiaremision`),
  ADD KEY `guia_detalle_articulo_idx` (`idarticulo`);

--
-- Indices de la tabla `guia_remision`
--
ALTER TABLE `GUIA_REMISION`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `guia_remision_transportista_idx` (`idtransportista`),
  ADD KEY `guia_remision_periodo_idx` (`idperiodo`),
  ADD KEY `guia_remision_usuario_idx` (`idusuario`),
  ADD KEY `guia_remision_tipo_comprobante_idx` (`idtipocomp`),
  ADD KEY `guia_remision_cliente_idx` (`idcliente`),
  ADD KEY `guia_remision_motivo_idx` (`idmotivo`),
  ADD KEY `guia_remision_transporte_idx` (`idtransporte`);

--
-- Indices de la tabla `laboratorio`
--
ALTER TABLE `LABORATORIO`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `MONEDA`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `motivo`
--
ALTER TABLE `MOTIVO`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `movimiento`
--
ALTER TABLE `MOVIMIENTO`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `movimiento_almacen_idx` (`almacen_origen`),
  ADD KEY `movimiento_tipo_movimiento_idx` (`idtipo_movimienito`);

--
-- Indices de la tabla `movimiento_caja`
--
ALTER TABLE `MOVIMIENTO_CAJA`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `movimiento_caja_caja_idx` (`idcaja`);

--
-- Indices de la tabla `orden_compras`
--
ALTER TABLE `ORDEN_COMPRAS`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `orden_compras_usuario_idx` (`idusuario`),
  ADD KEY `orden_compras_almacen_idx` (`idalmacen`);

--
-- Indices de la tabla `padre_perfil`
--
ALTER TABLE `PADRE_PERFIL`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `padre_perfil` (`idperfil`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `PAIS`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `PERFIL`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `periodo`
--
ALTER TABLE `PERIODO`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `periodo_ejercicio_idx` (`idejercicio`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `PROVEEDOR`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `proveedor_tipo_documento_idx` (`idtipodoc`);

--
-- Indices de la tabla `serie`
--
ALTER TABLE `SERIE`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `SUCURSAL`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `sucursal_empresa_idx` (`idempresa`);

--
-- Indices de la tabla `tabla_parametrica`
--
ALTER TABLE `TABLA_PARAMETRICA`
  ADD PRIMARY KEY (`codigo`,`tipo`);

--
-- Indices de la tabla `tipo_afectacion`
--
ALTER TABLE `TIPO_AFECTACION`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tipo_articulo`
--
ALTER TABLE `TIPO_ARTICULO`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tipo_comprobante`
--
ALTER TABLE `TIPO_COMPROBANTE`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `tipo_comprobante_categoria_idx` (`idcategoria`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `TIPO_DOCUMENTO`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tipo_movimiento`
--
ALTER TABLE `TIPO_MOVIMIENTO`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `transporte`
--
ALTER TABLE `TRANSPORTE`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `transportista`
--
ALTER TABLE `TRANSPORTISTA`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `transoortista_tipo_documento_idx` (`iddocumento`);

--
-- Indices de la tabla `ubigeo`
--
ALTER TABLE `UBIGEO`
  ADD PRIMARY KEY (`codigo_departamento`,`codigo_provincia`,`codigo_distrito`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `UNIDAD`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `usuario_perfil_idx` (`idperfil`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `VENTA`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `venta_usuario_idx` (`idusuario`),
  ADD KEY `venta_cliente_idx` (`idcliente`),
  ADD KEY `venta_tipo_comprobante_idx` (`idtipocomp`),
  ADD KEY `venta_moneda_idx` (`idmoneda`),
  ADD KEY `venta_formapago_idx` (`idformapago`),
  ADD KEY `venta_periodo_idx` (`idperiodo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acceso_almacen`
--
ALTER TABLE `ACCESO_ALMACEN`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `ALMACEN`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `articulo`
--
ALTER TABLE `ARTICULO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `barras_perfil`
--
ALTER TABLE `BARRAS_PERFIL`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `CAJA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `CATEGORIA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_comprobante`
--
ALTER TABLE `CATEGORIA_COMPROBANTE`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `CLIENTE`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `COMPRAS`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuota`
--
ALTER TABLE `CUOTA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_articulo`
--
ALTER TABLE `DETALLE_ARTICULO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `DETALLE_COMPRAS`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_movimiento`
--
ALTER TABLE `DETALLE_MOVIMIENTO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_comras`
--
ALTER TABLE `DETALLE_ORDEN_COMRAS`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pago`
--
ALTER TABLE `DETALLE_PAGO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_serie`
--
ALTER TABLE `DETALLE_SERIE`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `DETALLE_VENTA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejercicio`
--
ALTER TABLE `EJERCICIO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `EMPRESA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `existencia_lotes`
--
ALTER TABLE `EXISTENCIA_LOTES`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `forma_pago`
--
ALTER TABLE `FORMA_PAGO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guia_detalle`
--
ALTER TABLE `GUIA_DETALLE`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `guia_remision`
--
ALTER TABLE `GUIA_REMISION`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `laboratorio`
--
ALTER TABLE `LABORATORIO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento`
--
ALTER TABLE `MOVIMIENTO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimiento_caja`
--
ALTER TABLE `MOVIMIENTO_CAJA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden_compras`
--
ALTER TABLE `ORDEN_COMPRAS`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `padre_perfil`
--
ALTER TABLE `PADRE_PERFIL`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `PERFIL`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `periodo`
--
ALTER TABLE `PERIODO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `PROVEEDOR`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `serie`
--
ALTER TABLE `SERIE`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `SUCURSAL`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_articulo`
--
ALTER TABLE `TIPO_ARTICULO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_movimiento`
--
ALTER TABLE `TIPO_MOVIMIENTO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transportista`
--
ALTER TABLE `TRANSPORTISTA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `USUARIO`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `VENTA`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acceso_almacen`
--
ALTER TABLE `ACCESO_ALMACEN`
  ADD CONSTRAINT `acceso_almacen_almacen` FOREIGN KEY (`idalmacen`) REFERENCES `almacen` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `acceso_almacen_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `ALMACEN`
  ADD CONSTRAINT `almacen_sucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `articulo`
--
ALTER TABLE `ARTICULO`
  ADD CONSTRAINT `articulo_afectacion` FOREIGN KEY (`idafectacion`) REFERENCES `tipo_afectacion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `articulo_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `articulo_laboratorio` FOREIGN KEY (`idlaboratorio`) REFERENCES `laboratorio` (`codigo`),
  ADD CONSTRAINT `articulo_tipo_articulo` FOREIGN KEY (`idtipoarticulo`) REFERENCES `tipo_articulo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `articulo_unidad` FOREIGN KEY (`idunidad`) REFERENCES `unidad` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `barras_perfil`
--
ALTER TABLE `BARRAS_PERFIL`
  ADD CONSTRAINT `barras_perfil_perfil` FOREIGN KEY (`idperfil`) REFERENCES `perfil` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `CAJA`
  ADD CONSTRAINT `caja_acceso_almacen` FOREIGN KEY (`idacceso_almacen`) REFERENCES `acceso_almacen` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `CLIENTE`
  ADD CONSTRAINT `cliente_documento` FOREIGN KEY (`iddocumento`) REFERENCES `tipo_documento` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `cliente_pais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `COMPRAS`
  ADD CONSTRAINT `compras_forma_pago` FOREIGN KEY (`idformapago`) REFERENCES `forma_pago` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `compras_moneda` FOREIGN KEY (`idmoneda`) REFERENCES `moneda` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `compras_periodo` FOREIGN KEY (`idperiodo`) REFERENCES `periodo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `compras_proveedor` FOREIGN KEY (`idproveedor`) REFERENCES `proveedor` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `compras_tipo_comp` FOREIGN KEY (`idtipocomp`) REFERENCES `tipo_comprobante` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `compras_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cuota`
--
ALTER TABLE `CUOTA`
  ADD CONSTRAINT `cuota_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_articulo`
--
ALTER TABLE `DETALLE_ARTICULO`
  ADD CONSTRAINT `detalle_articulo_almacen` FOREIGN KEY (`idalmacen`) REFERENCES `almacen` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_articulo_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `DETALLE_COMPRAS`
  ADD CONSTRAINT `detalle_compras_compras` FOREIGN KEY (`idcompras`) REFERENCES `compras` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_compras_existencia_lote` FOREIGN KEY (`idexistencia_lote`) REFERENCES `existencia_lotes` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_movimiento`
--
ALTER TABLE `DETALLE_MOVIMIENTO`
  ADD CONSTRAINT `detalle_movimiento_existencia_lotes` FOREIGN KEY (`idexistencia_lote`) REFERENCES `existencia_lotes` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_movimiento_movimiento` FOREIGN KEY (`idmovimiento`) REFERENCES `movimiento` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_orden_comras`
--
ALTER TABLE `DETALLE_ORDEN_COMRAS`
  ADD CONSTRAINT `detalle_orden_compras` FOREIGN KEY (`idordencompra`) REFERENCES `orden_compras` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_pago`
--
ALTER TABLE `DETALLE_PAGO`
  ADD CONSTRAINT `detalle_pago_caja` FOREIGN KEY (`idcaja`) REFERENCES `caja` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_pago_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_serie`
--
ALTER TABLE `DETALLE_SERIE`
  ADD CONSTRAINT `detalle_serie_serie` FOREIGN KEY (`idserie`) REFERENCES `serie` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_serie_sucursal` FOREIGN KEY (`idsucursal`) REFERENCES `sucursal` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `DETALLE_VENTA`
  ADD CONSTRAINT `detalle_venta_existencia_lotes` FOREIGN KEY (`idexistencia_lotes`) REFERENCES `existencia_lotes` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `detalle_venta_venta` FOREIGN KEY (`idventa`) REFERENCES `venta` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `EMPRESA`
  ADD CONSTRAINT `empresa_pais` FOREIGN KEY (`idpais`) REFERENCES `pais` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `existencia_lotes`
--
ALTER TABLE `EXISTENCIA_LOTES`
  ADD CONSTRAINT `lote_almacen` FOREIGN KEY (`idalmacen`) REFERENCES `almacen` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `lote_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `guia_detalle`
--
ALTER TABLE `GUIA_DETALLE`
  ADD CONSTRAINT `guia_detalle_articulo` FOREIGN KEY (`idarticulo`) REFERENCES `articulo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `guia_detalle_guia` FOREIGN KEY (`idguiaremision`) REFERENCES `guia_remision` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `guia_remision`
--
ALTER TABLE `GUIA_REMISION`
  ADD CONSTRAINT `guia_remision_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `guia_remision_motivo` FOREIGN KEY (`idmotivo`) REFERENCES `motivo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `guia_remision_periodo` FOREIGN KEY (`idperiodo`) REFERENCES `periodo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `guia_remision_tipo_comprobante` FOREIGN KEY (`idtipocomp`) REFERENCES `tipo_comprobante` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `guia_remision_transporte` FOREIGN KEY (`idtransporte`) REFERENCES `transporte` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `guia_remision_transportista` FOREIGN KEY (`idtransportista`) REFERENCES `transportista` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `guia_remision_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `movimiento`
--
ALTER TABLE `MOVIMIENTO`
  ADD CONSTRAINT `movimiento_almacen` FOREIGN KEY (`almacen_origen`) REFERENCES `almacen` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `movimiento_tipo_movimiento` FOREIGN KEY (`idtipo_movimienito`) REFERENCES `tipo_movimiento` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `movimiento_caja`
--
ALTER TABLE `MOVIMIENTO_CAJA`
  ADD CONSTRAINT `movimiento_caja_caja` FOREIGN KEY (`idcaja`) REFERENCES `caja` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `orden_compras`
--
ALTER TABLE `ORDEN_COMPRAS`
  ADD CONSTRAINT `orden_compras_almacen` FOREIGN KEY (`idalmacen`) REFERENCES `almacen` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `orden_compras_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `padre_perfil`
--
ALTER TABLE `PADRE_PERFIL`
  ADD CONSTRAINT `padre_perfil` FOREIGN KEY (`idperfil`) REFERENCES `perfil` (`codigo`);

--
-- Filtros para la tabla `periodo`
--
ALTER TABLE `PERIODO`
  ADD CONSTRAINT `periodo_ejercicio` FOREIGN KEY (`idejercicio`) REFERENCES `ejercicio` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `PROVEEDOR`
  ADD CONSTRAINT `proveedor_tipo_documento` FOREIGN KEY (`idtipodoc`) REFERENCES `tipo_documento` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sucursal`
--
ALTER TABLE `SUCURSAL`
  ADD CONSTRAINT `sucursal_empresa` FOREIGN KEY (`idempresa`) REFERENCES `empresa` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tipo_comprobante`
--
ALTER TABLE `TIPO_COMPROBANTE`
  ADD CONSTRAINT `tipo_comprobante_categoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria_comprobante` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `transportista`
--
ALTER TABLE `TRANSPORTISTA`
  ADD CONSTRAINT `transoortista_tipo_documento` FOREIGN KEY (`iddocumento`) REFERENCES `tipo_documento` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `USUARIO`
  ADD CONSTRAINT `usuario_perfil` FOREIGN KEY (`idperfil`) REFERENCES `perfil` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `VENTA`
  ADD CONSTRAINT `venta_cliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `venta_formapago` FOREIGN KEY (`idformapago`) REFERENCES `forma_pago` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `venta_moneda` FOREIGN KEY (`idmoneda`) REFERENCES `moneda` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `venta_periodo` FOREIGN KEY (`idperiodo`) REFERENCES `periodo` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `venta_tipo_comprobante` FOREIGN KEY (`idtipocomp`) REFERENCES `tipo_comprobante` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `venta_usuario` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;


