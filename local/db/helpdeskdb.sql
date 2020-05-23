-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-02-2020 a las 19:53:49
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `helpdeskdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `_id` int(11) NOT NULL,
  `_id_provider` int(11) NOT NULL,
  `_id_type` int(11) NOT NULL,
  `name` char(128) NOT NULL,
  `description` text DEFAULT NULL,
  `barcode` char(24) NOT NULL,
  `units` int(11) DEFAULT 0,
  `cost` decimal(10,2) DEFAULT NULL,
  `pvp` decimal(10,2) DEFAULT NULL,
  `image` char(128) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`_id`, `_id_provider`, `_id_type`, `name`, `description`, `barcode`, `units`, `cost`, `pvp`, `image`, `created`) VALUES
(18, 3, 5, 'Surepos100', 'TPV de IMB', '123456789', 7, '11.22', '11.23', '5e4bd08fddee6descarga (4).webp', '2020-01-12 19:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles_borrowed_point_of_sales`
--

CREATE TABLE `articles_borrowed_point_of_sales` (
  `_id` int(11) NOT NULL,
  `_id_article_only` int(11) NOT NULL,
  `_id_incidence` int(11) NOT NULL,
  `_id_pto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articles_borrowed_point_of_sales`
--

INSERT INTO `articles_borrowed_point_of_sales` (`_id`, `_id_article_only`, `_id_incidence`, `_id_pto`) VALUES
(39, 5, 3, 1),
(31, 10, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles_only`
--

CREATE TABLE `articles_only` (
  `_id` int(11) NOT NULL,
  `serial` char(32) DEFAULT NULL,
  `code` char(64) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `_id_article` int(11) NOT NULL,
  `_id_borrowed_status` int(11) NOT NULL DEFAULT 1,
  `_id_status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articles_only`
--

INSERT INTO `articles_only` (`_id`, `serial`, `code`, `observations`, `_id_article`, `_id_borrowed_status`, `_id_status`, `created`) VALUES
(2, '100100100100', 'abc-110', 'esquina estropeada', 18, 1, 1, '2020-01-13 11:25:30'),
(5, '11111111111111', '1222', 'das', 18, 1, 1, '2020-01-17 14:39:23'),
(6, '22222222', NULL, 'dasdsa', 18, 1, 1, '2020-01-18 08:44:59'),
(7, '200100200', NULL, 'dsads', 18, 1, 2, '2020-01-18 08:48:27'),
(8, '30003000', NULL, NULL, 18, 1, 1, '2020-01-20 07:28:55'),
(9, '200200200', NULL, NULL, 18, 1, 1, '2020-01-20 07:28:57'),
(10, '90090900', NULL, NULL, 18, 2, 1, '2020-01-20 07:35:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles_point_of_sales`
--

CREATE TABLE `articles_point_of_sales` (
  `_id` int(11) NOT NULL,
  `_id_pto` int(11) NOT NULL,
  `serial` char(24) DEFAULT NULL,
  `barcode` char(24) DEFAULT NULL,
  `name` char(128) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `_id_type` int(11) NOT NULL,
  `code` char(32) DEFAULT NULL,
  `_id_incidence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articles_point_of_sales`
--

INSERT INTO `articles_point_of_sales` (`_id`, `_id_pto`, `serial`, `barcode`, `name`, `observations`, `_id_type`, `code`, `_id_incidence`) VALUES
(1, 1, NULL, '8400000000001', 'Cajón tpv generico', 'Rotura por un lado', 5, NULL, 3),
(16, 1, '000', '0000000000000', 'Skorpio', 'Esquina rota', 2, NULL, 2),
(18, 1, NULL, 'fsdds', 'hola', NULL, 1, NULL, 2),
(19, 1, NULL, NULL, 'art', NULL, 1, NULL, 2),
(20, 1, NULL, NULL, 'skorpio mano', 'esta es una clara observación......', 2, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `art_borrowed_status`
--

CREATE TABLE `art_borrowed_status` (
  `_id` int(11) NOT NULL,
  `status` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `art_borrowed_status`
--

INSERT INTO `art_borrowed_status` (`_id`, `status`) VALUES
(1, 'En almacén'),
(2, 'En prestamo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `art_status`
--

CREATE TABLE `art_status` (
  `_id` int(11) NOT NULL,
  `status` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `art_status`
--

INSERT INTO `art_status` (`_id`, `status`) VALUES
(1, 'Disponible'),
(2, 'Roto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `art_types`
--

CREATE TABLE `art_types` (
  `_id` int(11) NOT NULL,
  `type` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `art_types`
--

INSERT INTO `art_types` (`_id`, `type`) VALUES
(1, 'Monitor'),
(2, 'Escáner'),
(3, 'Ratón'),
(4, 'Teclado'),
(5, 'TPV'),
(6, 'Portátil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `companies`
--

CREATE TABLE `companies` (
  `_id` int(11) NOT NULL,
  `tradename` char(64) NOT NULL,
  `business_name` char(64) NOT NULL,
  `cif` char(32) NOT NULL,
  `_id_status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `companies`
--

INSERT INTO `companies` (`_id`, `tradename`, `business_name`, `cif`, `_id_status`, `created`) VALUES
(3, 'Spar', 'Cencosu, S. L', 'A47163348', 1, '2019-12-23 07:19:38'),
(5, 'Carrefour', 'Carrefour, S.A', 'A54163300', 2, '2020-01-02 15:58:57'),
(6, 'Mercadona', 'Mercadona S.A', 'A54163348', 1, '2020-01-09 22:00:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comp_status`
--

CREATE TABLE `comp_status` (
  `_id` int(11) NOT NULL,
  `status` char(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comp_status`
--

INSERT INTO `comp_status` (`_id`, `status`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `_id` int(11) NOT NULL,
  `iso` char(2) DEFAULT NULL,
  `name` char(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`_id`, `iso`, `name`) VALUES
(1, 'AF', 'Afganistán'),
(2, 'AX', 'Islas Gland'),
(3, 'AL', 'Albania'),
(4, 'DE', 'Alemania'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antártida'),
(9, 'AG', 'Antigua y Barbuda'),
(10, 'AN', 'Antillas Holandesas'),
(11, 'SA', 'Arabia Saudí'),
(12, 'DZ', 'Argelia'),
(13, 'AR', 'Argentina'),
(14, 'AM', 'Armenia'),
(15, 'AW', 'Aruba'),
(16, 'AU', 'Australia'),
(17, 'AT', 'Austria'),
(18, 'AZ', 'Azerbaiyán'),
(19, 'BS', 'Bahamas'),
(20, 'BH', 'Bahréin'),
(21, 'BD', 'Bangladesh'),
(22, 'BB', 'Barbados'),
(23, 'BY', 'Bielorrusia'),
(24, 'BE', 'Bélgica'),
(25, 'BZ', 'Belice'),
(26, 'BJ', 'Benin'),
(27, 'BM', 'Bermudas'),
(28, 'BT', 'Bhután'),
(29, 'BO', 'Bolivia'),
(30, 'BA', 'Bosnia y Herzegovina'),
(31, 'BW', 'Botsuana'),
(32, 'BV', 'Isla Bouvet'),
(33, 'BR', 'Brasil'),
(34, 'BN', 'Brunéi'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'CV', 'Cabo Verde'),
(39, 'KY', 'Islas Caimán'),
(40, 'KH', 'Camboya'),
(41, 'CM', 'Camerún'),
(42, 'CA', 'Canadá'),
(43, 'CF', 'República Centroafricana'),
(44, 'TD', 'Chad'),
(45, 'CZ', 'República Checa'),
(46, 'CL', 'Chile'),
(47, 'CN', 'China'),
(48, 'CY', 'Chipre'),
(49, 'CX', 'Isla de Navidad'),
(50, 'VA', 'Ciudad del Vaticano'),
(51, 'CC', 'Islas Cocos'),
(52, 'CO', 'Colombia'),
(53, 'KM', 'Comoras'),
(54, 'CD', 'República Democrática del Congo'),
(55, 'CG', 'Congo'),
(56, 'CK', 'Islas Cook'),
(57, 'KP', 'Corea del Norte'),
(58, 'KR', 'Corea del Sur'),
(59, 'CI', 'Costa de Marfil'),
(60, 'CR', 'Costa Rica'),
(61, 'HR', 'Croacia'),
(62, 'CU', 'Cuba'),
(63, 'DK', 'Dinamarca'),
(64, 'DM', 'Dominica'),
(65, 'DO', 'República Dominicana'),
(66, 'EC', 'Ecuador'),
(67, 'EG', 'Egipto'),
(68, 'SV', 'El Salvador'),
(69, 'AE', 'Emiratos Árabes Unidos'),
(70, 'ER', 'Eritrea'),
(71, 'SK', 'Eslovaquia'),
(72, 'SI', 'Eslovenia'),
(73, 'ES', 'España'),
(74, 'UM', 'Islas ultramarinas de Estados Unidos'),
(75, 'US', 'Estados Unidos'),
(76, 'EE', 'Estonia'),
(77, 'ET', 'Etiopía'),
(78, 'FO', 'Islas Feroe'),
(79, 'PH', 'Filipinas'),
(80, 'FI', 'Finlandia'),
(81, 'FJ', 'Fiyi'),
(82, 'FR', 'Francia'),
(83, 'GA', 'Gabón'),
(84, 'GM', 'Gambia'),
(85, 'GE', 'Georgia'),
(86, 'GS', 'Islas Georgias del Sur y Sandwich del Sur'),
(87, 'GH', 'Ghana'),
(88, 'GI', 'Gibraltar'),
(89, 'GD', 'Granada'),
(90, 'GR', 'Grecia'),
(91, 'GL', 'Groenlandia'),
(92, 'GP', 'Guadalupe'),
(93, 'GU', 'Guam'),
(94, 'GT', 'Guatemala'),
(95, 'GF', 'Guayana Francesa'),
(96, 'GN', 'Guinea'),
(97, 'GQ', 'Guinea Ecuatorial'),
(98, 'GW', 'Guinea-Bissau'),
(99, 'GY', 'Guyana'),
(100, 'HT', 'Haití'),
(101, 'HM', 'Islas Heard y McDonald'),
(102, 'HN', 'Honduras'),
(103, 'HK', 'Hong Kong'),
(104, 'HU', 'Hungría'),
(105, 'IN', 'India'),
(106, 'ID', 'Indonesia'),
(107, 'IR', 'Irán'),
(108, 'IQ', 'Iraq'),
(109, 'IE', 'Irlanda'),
(110, 'IS', 'Islandia'),
(111, 'IL', 'Israel'),
(112, 'IT', 'Italia'),
(113, 'JM', 'Jamaica'),
(114, 'JP', 'Japón'),
(115, 'JO', 'Jordania'),
(116, 'KZ', 'Kazajstán'),
(117, 'KE', 'Kenia'),
(118, 'KG', 'Kirguistán'),
(119, 'KI', 'Kiribati'),
(120, 'KW', 'Kuwait'),
(121, 'LA', 'Laos'),
(122, 'LS', 'Lesotho'),
(123, 'LV', 'Letonia'),
(124, 'LB', 'Líbano'),
(125, 'LR', 'Liberia'),
(126, 'LY', 'Libia'),
(127, 'LI', 'Liechtenstein'),
(128, 'LT', 'Lituania'),
(129, 'LU', 'Luxemburgo'),
(130, 'MO', 'Macao'),
(131, 'MK', 'ARY Macedonia'),
(132, 'MG', 'Madagascar'),
(133, 'MY', 'Malasia'),
(134, 'MW', 'Malawi'),
(135, 'MV', 'Maldivas'),
(136, 'ML', 'Malí'),
(137, 'MT', 'Malta'),
(138, 'FK', 'Islas Malvinas'),
(139, 'MP', 'Islas Marianas del Norte'),
(140, 'MA', 'Marruecos'),
(141, 'MH', 'Islas Marshall'),
(142, 'MQ', 'Martinica'),
(143, 'MU', 'Mauricio'),
(144, 'MR', 'Mauritania'),
(145, 'YT', 'Mayotte'),
(146, 'MX', 'México'),
(147, 'FM', 'Micronesia'),
(148, 'MD', 'Moldavia'),
(149, 'MC', 'Mónaco'),
(150, 'MN', 'Mongolia'),
(151, 'MS', 'Montserrat'),
(152, 'MZ', 'Mozambique'),
(153, 'MM', 'Myanmar'),
(154, 'NA', 'Namibia'),
(155, 'NR', 'Nauru'),
(156, 'NP', 'Nepal'),
(157, 'NI', 'Nicaragua'),
(158, 'NE', 'Níger'),
(159, 'NG', 'Nigeria'),
(160, 'NU', 'Niue'),
(161, 'NF', 'Isla Norfolk'),
(162, 'NO', 'Noruega'),
(163, 'NC', 'Nueva Caledonia'),
(164, 'NZ', 'Nueva Zelanda'),
(165, 'OM', 'Omán'),
(166, 'NL', 'Países Bajos'),
(167, 'PK', 'Pakistán'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestina'),
(170, 'PA', 'Panamá'),
(171, 'PG', 'Papúa Nueva Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Perú'),
(174, 'PN', 'Islas Pitcairn'),
(175, 'PF', 'Polinesia Francesa'),
(176, 'PL', 'Polonia'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'GB', 'Reino Unido'),
(181, 'RE', 'Reunión'),
(182, 'RW', 'Ruanda'),
(183, 'RO', 'Rumania'),
(184, 'RU', 'Rusia'),
(185, 'EH', 'Sahara Occidental'),
(186, 'SB', 'Islas Salomón'),
(187, 'WS', 'Samoa'),
(188, 'AS', 'Samoa Americana'),
(189, 'KN', 'San Cristóbal y Nevis'),
(190, 'SM', 'San Marino'),
(191, 'PM', 'San Pedro y Miquelón'),
(192, 'VC', 'San Vicente y las Granadinas'),
(193, 'SH', 'Santa Helena'),
(194, 'LC', 'Santa Lucía'),
(195, 'ST', 'Santo Tomé y Príncipe'),
(196, 'SN', 'Senegal'),
(197, 'CS', 'Serbia y Montenegro'),
(198, 'SC', 'Seychelles'),
(199, 'SL', 'Sierra Leona'),
(200, 'SG', 'Singapur'),
(201, 'SY', 'Siria'),
(202, 'SO', 'Somalia'),
(203, 'LK', 'Sri Lanka'),
(204, 'SZ', 'Suazilandia'),
(205, 'ZA', 'Sudáfrica'),
(206, 'SD', 'Sudán'),
(207, 'SE', 'Suecia'),
(208, 'CH', 'Suiza'),
(209, 'SR', 'Surinam'),
(210, 'SJ', 'Svalbard y Jan Mayen'),
(211, 'TH', 'Tailandia'),
(212, 'TW', 'Taiwán'),
(213, 'TZ', 'Tanzania'),
(214, 'TJ', 'Tayikistán'),
(215, 'IO', 'Territorio Británico del Océano Índico'),
(216, 'TF', 'Territorios Australes Franceses'),
(217, 'TL', 'Timor Oriental'),
(218, 'TG', 'Togo'),
(219, 'TK', 'Tokelau'),
(220, 'TO', 'Tonga'),
(221, 'TT', 'Trinidad y Tobago'),
(222, 'TN', 'Túnez'),
(223, 'TC', 'Islas Turcas y Caicos'),
(224, 'TM', 'Turkmenistán'),
(225, 'TR', 'Turquía'),
(226, 'TV', 'Tuvalu'),
(227, 'UA', 'Ucrania'),
(228, 'UG', 'Uganda'),
(229, 'UY', 'Uruguay'),
(230, 'UZ', 'Uzbekistán'),
(231, 'VU', 'Vanuatu'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Islas Vírgenes Británicas'),
(235, 'VI', 'Islas Vírgenes de los Estados Unidos'),
(236, 'WF', 'Wallis y Futuna'),
(237, 'YE', 'Yemen'),
(238, 'DJ', 'Yibuti'),
(239, 'ZM', 'Zambia'),
(240, 'ZW', 'Zimbabue');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidences`
--

CREATE TABLE `incidences` (
  `_id` int(11) NOT NULL,
  `subject` char(128) NOT NULL,
  `description` text DEFAULT NULL,
  `_id_pto_of_sales` int(11) NOT NULL,
  `_id_user_created` int(11) NOT NULL,
  `_id_attended` int(11) NOT NULL,
  `_id_priority` int(11) NOT NULL,
  `_id_status` int(11) NOT NULL,
  `_id_type` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `finish_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `incidences`
--

INSERT INTO `incidences` (`_id`, `subject`, `description`, `_id_pto_of_sales`, `_id_user_created`, `_id_attended`, `_id_priority`, `_id_status`, `_id_type`, `created`, `finish_date`) VALUES
(2, 'Skorpio estropeado', 'ta roto', 1, 60, 60, 1, 1, 1, '2020-01-20 09:05:05', NULL),
(3, 'Cajón de tpv no cierra', 'tirador dañado, recambio de pieza.', 1, 60, 61, 1, 1, 1, '2020-01-20 09:05:31', NULL),
(4, 'Skorpio estropeado', 'Esquina rota, al parecer dejó de funcionar.', 1, 60, 60, 2, 6, 2, '2020-01-20 09:05:31', '2020-02-03 11:05:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inc_priorities`
--

CREATE TABLE `inc_priorities` (
  `_id` int(11) NOT NULL,
  `priority` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inc_priorities`
--

INSERT INTO `inc_priorities` (`_id`, `priority`) VALUES
(1, 'Baja'),
(2, 'Normal'),
(3, 'Alta'),
(4, 'Urgente'),
(5, 'Petición');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inc_status`
--

CREATE TABLE `inc_status` (
  `_id` int(11) NOT NULL,
  `status` char(128) NOT NULL,
  `_id_family` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inc_status`
--

INSERT INTO `inc_status` (`_id`, `status`, `_id_family`) VALUES
(1, 'En ruta', 1),
(2, 'En curso', 1),
(3, 'Finalizada', 1),
(4, 'Seguimiento', 1),
(5, 'Anulada', 1),
(6, 'Llevar a proveedor', 1),
(7, 'Pendiente de facturar', 2),
(8, 'Pasan a recogerlo', 4),
(9, 'Pendiente de firmar', 3),
(10, 'Pendiente material proveedor', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inc_status_family`
--

CREATE TABLE `inc_status_family` (
  `_id` int(11) NOT NULL,
  `name` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inc_status_family`
--

INSERT INTO `inc_status_family` (`_id`, `name`) VALUES
(1, 'Miscelea'),
(2, 'Facturación'),
(3, 'Presupuesto'),
(4, 'Taller');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inc_types_incidences`
--

CREATE TABLE `inc_types_incidences` (
  `_id` int(11) NOT NULL,
  `type` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inc_types_incidences`
--

INSERT INTO `inc_types_incidences` (`_id`, `type`) VALUES
(1, 'Recambio\r\n'),
(2, 'Mantenimiento'),
(3, 'Reparación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `points_of_sales`
--

CREATE TABLE `points_of_sales` (
  `_id` int(11) NOT NULL,
  `_id_company` int(11) NOT NULL,
  `_id_status` int(11) NOT NULL,
  `name` char(32) NOT NULL,
  `company_code` char(32) DEFAULT NULL,
  `_id_country` int(11) DEFAULT NULL,
  `province` char(32) DEFAULT NULL,
  `locality` char(32) DEFAULT NULL,
  `postal_code` char(5) DEFAULT NULL,
  `address` char(64) DEFAULT NULL,
  `coordinate_x` float DEFAULT NULL,
  `coordinate_y` float DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `points_of_sales`
--

INSERT INTO `points_of_sales` (`_id`, `_id_company`, `_id_status`, `name`, `company_code`, `_id_country`, `province`, `locality`, `postal_code`, `address`, `coordinate_x`, `coordinate_y`, `created`) VALUES
(1, 3, 1, 'Spar Ingenio', '2220', 73, 'Las Palmas', 'Ingenio', '35250', 'Avenida Gran Canaria, Ingenio, España', NULL, NULL, '2019-12-23 13:03:04'),
(2, 3, 1, 'Spar La Garita', '11100', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-01-03 15:05:21'),
(3, 6, 2, 'Mercadona Cruce de Melenara', '0001', 73, 'Las Palmas', 'Playa de Melenara', '35214', 'Melenara, España', NULL, NULL, '2020-01-10 10:49:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pto_contacts`
--

CREATE TABLE `pto_contacts` (
  `_id` int(11) NOT NULL,
  `name` char(32) NOT NULL,
  `phone` int(9) DEFAULT NULL,
  `email` char(128) DEFAULT NULL,
  `_id_pto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pto_contacts`
--

INSERT INTO `pto_contacts` (`_id`, `name`, `phone`, `email`, `_id_pto`) VALUES
(47, 'adasdsa', 600600600, 'prov@gmail.com', 3),
(49, 'jonas', 900900900, 'j@gmail.com', 3),
(65, 'admin', NULL, 'admin@gmail.com', 1),
(66, 'dsa', 600600600, 'spargc@gmail.com', 1),
(73, 'das', 600600600, 'spargc@gmail.com', 1),
(74, 'dasds', NULL, 'spargc@gmail.com', 1),
(80, 'kkkk', NULL, 'jose@gmail.com', 2),
(81, 'cristian', NULL, 'lu@gmail.com', 3),
(82, '11d', 11, 'spargc@gmail.com', 3),
(83, 'asss', 600600600, 'spargc@gmail.com', 3),
(84, 'asss', 600600600, 'spargc@gmail.com', 3),
(85, 'aww', 600600600, 'spargc@gmail.com', 3),
(86, 'sads', 600600600, 'spargc@gmail.com', 3),
(87, 'nueve', 600600600, 'spargc@gmail.com', 3),
(88, '100', 600600600, 'spargc@gmail.com', 3),
(90, 'jonas', 11, 'spargc@gmail.com', 3),
(91, 'pepe', NULL, 'ad@gmail.com', 3),
(95, 'luis', 1212, 'prov@gmail.com', 3),
(98, 'jonas', 0, 'jonas.fa@gmail.com', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pto_status`
--

CREATE TABLE `pto_status` (
  `_id` int(11) NOT NULL,
  `status` char(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pto_status`
--

INSERT INTO `pto_status` (`_id`, `status`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE `suppliers` (
  `_id` int(11) NOT NULL,
  `tradename` char(64) NOT NULL,
  `business_name` char(64) NOT NULL,
  `cif` char(64) NOT NULL,
  `_id_country` int(11) DEFAULT NULL,
  `province` char(32) DEFAULT NULL,
  `locality` char(32) DEFAULT NULL,
  `postal_code` int(5) DEFAULT NULL,
  `address` char(64) DEFAULT NULL,
  `phone` int(9) DEFAULT NULL,
  `email` char(64) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`_id`, `tradename`, `business_name`, `cif`, `_id_country`, `province`, `locality`, `postal_code`, `address`, `phone`, `email`, `created`) VALUES
(3, 'Güajira', 'MegaStore, S.L', 'A-400300', NULL, 'Las Palmas', 'Telde', 35200, 'Paseo Juagarzo nº3', 600600600, 'spargc@gmail.com', '2019-12-23 06:22:01'),
(4, 'proveedor0111', 'Cencosu, S.L', 'ddadasda23', NULL, 'Las Palmas', 'Telde', 35200, 'Paseo Juagarzo nº3', 600600600, 'prov@gmail.com', '2020-01-10 12:36:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `_id` int(11) NOT NULL,
  `name` char(32) NOT NULL,
  `lastname` char(32) NOT NULL,
  `email` char(64) NOT NULL,
  `password` char(60) NOT NULL,
  `_id_rol` int(11) NOT NULL,
  `_id_status` int(11) NOT NULL,
  `image` char(128) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`_id`, `name`, `lastname`, `email`, `password`, `_id_rol`, `_id_status`, `image`, `created`) VALUES
(60, 'Jonás', 'Damher', 'jonas.damher@gmail.com', '$2y$10$nj2RC5Qw1ijrjgK2.ewFvuNO5IQQCvQHkeJnM/Ox6uLUXvTDf7PR2', 1, 1, '5e3ad4593b8fbdescarga.webp', '2019-12-24 14:25:56'),
(61, 'Cristina', 'Rodriguez Monagas', 'cris@gmail.com', '$2y$10$zUGpLV8fAZjxg676LcWMv.4u9lgHtarJC8COpFDj6jI/jBs8fniVe', 2, 1, '5e0e27004358a10-tacticas-para-ser-mas-simpatico-a-tus-clientes-y-venderles-mas.webp', '2019-12-26 13:42:26'),
(62, 'Pepe', 'Rojas Hernández', 'pepe@gmail.com', '$2y$10$Nh1QII86ySTVg.R6XCtheu0eZ.iPuHsLkX//1Vv1AqnAh/puRED7m', 1, 2, NULL, '2020-01-09 20:41:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usr_rol`
--

CREATE TABLE `usr_rol` (
  `_id` int(11) NOT NULL,
  `rol` char(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usr_rol`
--

INSERT INTO `usr_rol` (`_id`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Operario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usr_status`
--

CREATE TABLE `usr_status` (
  `_id` int(11) NOT NULL,
  `status` char(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usr_status`
--

INSERT INTO `usr_status` (`_id`, `status`) VALUES
(1, 'Activo'),
(2, 'Bloqueado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_type` (`_id_type`,`_id_provider`),
  ADD KEY `_id_provider` (`_id_provider`);

--
-- Indices de la tabla `articles_borrowed_point_of_sales`
--
ALTER TABLE `articles_borrowed_point_of_sales`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_article_only` (`_id_article_only`,`_id_incidence`,`_id_pto`),
  ADD KEY `_id_incidence` (`_id_incidence`),
  ADD KEY `_id_pto` (`_id_pto`);

--
-- Indices de la tabla `articles_only`
--
ALTER TABLE `articles_only`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_article` (`_id_article`,`_id_status`,`_id_borrowed_status`),
  ADD KEY `_id_borrowed_status` (`_id_borrowed_status`),
  ADD KEY `_id_status` (`_id_status`);

--
-- Indices de la tabla `articles_point_of_sales`
--
ALTER TABLE `articles_point_of_sales`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_pto` (`_id_pto`,`_id_type`),
  ADD KEY `_id_type` (`_id_type`),
  ADD KEY `_id_incidence` (`_id_incidence`);

--
-- Indices de la tabla `art_borrowed_status`
--
ALTER TABLE `art_borrowed_status`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `art_status`
--
ALTER TABLE `art_status`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `art_types`
--
ALTER TABLE `art_types`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_status` (`_id_status`);

--
-- Indices de la tabla `comp_status`
--
ALTER TABLE `comp_status`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `incidences`
--
ALTER TABLE `incidences`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_pto_of_sales` (`_id_pto_of_sales`,`_id_user_created`,`_id_attended`,`_id_priority`,`_id_status`,`_id_type`),
  ADD KEY `_id_priority` (`_id_priority`),
  ADD KEY `_id_type` (`_id_type`),
  ADD KEY `_id_status` (`_id_status`),
  ADD KEY `_id_user_created` (`_id_user_created`),
  ADD KEY `_id_attended` (`_id_attended`);

--
-- Indices de la tabla `inc_priorities`
--
ALTER TABLE `inc_priorities`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `inc_status`
--
ALTER TABLE `inc_status`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_family` (`_id_family`);

--
-- Indices de la tabla `inc_status_family`
--
ALTER TABLE `inc_status_family`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `inc_types_incidences`
--
ALTER TABLE `inc_types_incidences`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `points_of_sales`
--
ALTER TABLE `points_of_sales`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_status` (`_id_status`),
  ADD KEY `_id_company` (`_id_company`),
  ADD KEY `country` (`_id_country`);

--
-- Indices de la tabla `pto_contacts`
--
ALTER TABLE `pto_contacts`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `_id_pto` (`_id_pto`);

--
-- Indices de la tabla `pto_status`
--
ALTER TABLE `pto_status`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `country` (`_id_country`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `id_rol` (`_id_rol`,`_id_status`),
  ADD KEY `users_ibfk_1` (`_id_status`);

--
-- Indices de la tabla `usr_rol`
--
ALTER TABLE `usr_rol`
  ADD PRIMARY KEY (`_id`);

--
-- Indices de la tabla `usr_status`
--
ALTER TABLE `usr_status`
  ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `articles_borrowed_point_of_sales`
--
ALTER TABLE `articles_borrowed_point_of_sales`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `articles_only`
--
ALTER TABLE `articles_only`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `articles_point_of_sales`
--
ALTER TABLE `articles_point_of_sales`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `art_borrowed_status`
--
ALTER TABLE `art_borrowed_status`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `art_status`
--
ALTER TABLE `art_status`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `art_types`
--
ALTER TABLE `art_types`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `companies`
--
ALTER TABLE `companies`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `comp_status`
--
ALTER TABLE `comp_status`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT de la tabla `incidences`
--
ALTER TABLE `incidences`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inc_priorities`
--
ALTER TABLE `inc_priorities`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `inc_status`
--
ALTER TABLE `inc_status`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `inc_status_family`
--
ALTER TABLE `inc_status_family`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inc_types_incidences`
--
ALTER TABLE `inc_types_incidences`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `points_of_sales`
--
ALTER TABLE `points_of_sales`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pto_contacts`
--
ALTER TABLE `pto_contacts`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de la tabla `pto_status`
--
ALTER TABLE `pto_status`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `usr_rol`
--
ALTER TABLE `usr_rol`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usr_status`
--
ALTER TABLE `usr_status`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`_id_provider`) REFERENCES `suppliers` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`_id_type`) REFERENCES `art_types` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `articles_borrowed_point_of_sales`
--
ALTER TABLE `articles_borrowed_point_of_sales`
  ADD CONSTRAINT `articles_borrowed_point_of_sales_ibfk_1` FOREIGN KEY (`_id_incidence`) REFERENCES `incidences` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_borrowed_point_of_sales_ibfk_2` FOREIGN KEY (`_id_pto`) REFERENCES `articles_point_of_sales` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_borrowed_point_of_sales_ibfk_3` FOREIGN KEY (`_id_article_only`) REFERENCES `articles_only` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `articles_only`
--
ALTER TABLE `articles_only`
  ADD CONSTRAINT `articles_only_ibfk_1` FOREIGN KEY (`_id_article`) REFERENCES `articles` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_only_ibfk_2` FOREIGN KEY (`_id_borrowed_status`) REFERENCES `art_borrowed_status` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_only_ibfk_3` FOREIGN KEY (`_id_status`) REFERENCES `art_status` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `articles_point_of_sales`
--
ALTER TABLE `articles_point_of_sales`
  ADD CONSTRAINT `articles_point_of_sales_ibfk_1` FOREIGN KEY (`_id_type`) REFERENCES `art_types` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_point_of_sales_ibfk_2` FOREIGN KEY (`_id_incidence`) REFERENCES `incidences` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_point_of_sales_ibfk_3` FOREIGN KEY (`_id_pto`) REFERENCES `points_of_sales` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`_id_status`) REFERENCES `comp_status` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `incidences`
--
ALTER TABLE `incidences`
  ADD CONSTRAINT `incidences_ibfk_1` FOREIGN KEY (`_id_priority`) REFERENCES `inc_priorities` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incidences_ibfk_2` FOREIGN KEY (`_id_type`) REFERENCES `inc_types_incidences` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incidences_ibfk_3` FOREIGN KEY (`_id_status`) REFERENCES `inc_status` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incidences_ibfk_4` FOREIGN KEY (`_id_pto_of_sales`) REFERENCES `points_of_sales` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incidences_ibfk_5` FOREIGN KEY (`_id_user_created`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `incidences_ibfk_6` FOREIGN KEY (`_id_attended`) REFERENCES `users` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inc_status`
--
ALTER TABLE `inc_status`
  ADD CONSTRAINT `inc_status_ibfk_1` FOREIGN KEY (`_id_family`) REFERENCES `inc_status_family` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `points_of_sales`
--
ALTER TABLE `points_of_sales`
  ADD CONSTRAINT `points_of_sales_ibfk_1` FOREIGN KEY (`_id_status`) REFERENCES `pto_status` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `points_of_sales_ibfk_2` FOREIGN KEY (`_id_company`) REFERENCES `companies` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `points_of_sales_ibfk_3` FOREIGN KEY (`_id_country`) REFERENCES `countries` (`_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `pto_contacts`
--
ALTER TABLE `pto_contacts`
  ADD CONSTRAINT `pto_contacts_ibfk_1` FOREIGN KEY (`_id_pto`) REFERENCES `points_of_sales` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`_id_country`) REFERENCES `countries` (`_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`_id_status`) REFERENCES `usr_status` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`_id_rol`) REFERENCES `usr_rol` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
