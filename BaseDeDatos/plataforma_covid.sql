-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-12-2021 a las 15:33:52
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plataforma_covid`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idAdministrador` int(10) NOT NULL,
  `AdminDNI` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminNombre` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminApellidoPaterno` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminApellidoMaterno` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminTelefono` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `AdminDescripcion` varchar(256) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `AdminGenero` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `AdminVigencia` int(11) NOT NULL,
  `AdminDireccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`idAdministrador`, `AdminDNI`, `AdminNombre`, `AdminApellidoPaterno`, `AdminApellidoMaterno`, `AdminTelefono`, `AdminDescripcion`, `AdminGenero`, `AdminVigencia`, `AdminDireccion`, `CuentaCodigo`) VALUES
(1, '72350319', 'Edu Avelino', 'Cespedes', 'Ordinola', '945211561', 'Administrador y desarrollador de la plataforma web.', 'Masculino', 1, 'Ucayali #185 Ferreñafe', 'UNPRG34062945281'),
(2, '76010148', 'Carmen Rosa', 'Martinez', 'Rodriguez', '', 'Adminsitradora General', 'Femenino', 1, 'Chiclayo - Los Pinos', 'UNPRG34250108324');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencion`
--

CREATE TABLE `atencion` (
  `idAtencion` int(11) NOT NULL,
  `AtencionFecha` date NOT NULL,
  `AtencionDescripcion` varchar(550) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idEspecialista` int(11) NOT NULL,
  `AtencionEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `atencion`
--

INSERT INTO `atencion` (`idAtencion`, `AtencionFecha`, `AtencionDescripcion`, `idUsuario`, `idEspecialista`, `AtencionEstado`) VALUES
(1, '2020-11-03', 'Hola, mi nombre es Edu Cespedes y sufro abuso por parte de mis amigos, me explotan para que realize sus tareas y no me dejan tiempo para mi y para mi vida social, llegando al punto de saturarme y querer suicidarme.\r\nEspero comprenda mi situación y pueda darme algunos consejos de como sobre llevar este abuso y poder superarme.', 1, 7, 1),
(2, '2020-11-03', 'Hola, mis amigos me siguen explotanco y nose como sobre llevarlo, quisiera algún consejo que me permita salir de esto, de antemano gracias y un saludo', 1, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(10) NOT NULL,
  `BitacoraCodigo` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraFecha` date NOT NULL,
  `BitacoraHoraInicio` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraHoraFinal` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraTipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `BitacoraYear` int(4) NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `BitacoraCodigo`, `BitacoraFecha`, `BitacoraHoraInicio`, `BitacoraHoraFinal`, `BitacoraTipo`, `BitacoraYear`, `CuentaCodigo`) VALUES
(1, 'CB055976471', '2021-12-14', '09:30:19 am', '09:31:19 am', 'Administrador', 2021, 'UNPRG34062945281'),
(2, 'CB269261912', '2021-12-14', '09:31:28 am', 'Sin registro', 'Usuario', 2021, 'UNPRG46076026212');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `CategoriaDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `CategoriaIcono` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `CategoriaVigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `CategoriaDescripcion`, `CategoriaIcono`, `CategoriaVigencia`) VALUES
(1, 'Locales', '<i class=\"fas fa-street-view\"></i>', 1),
(2, 'Nacionales', '<i class=\"far fa-flag\"></i>', 1),
(3, 'Internacionales', '<i class=\"fas fa-globe-americas\"></i>', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `idComentario` int(11) NOT NULL,
  `idNoticia` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `ComentarioDescripcion` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ComentarioFecha` date NOT NULL,
  `ComentarioVigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conferencia`
--

CREATE TABLE `conferencia` (
  `idConferencia` int(11) NOT NULL,
  `ConferenciaTitulo` varchar(256) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ConferenciaDescripcion` varchar(1600) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ConferenciaFecha` date NOT NULL,
  `ConferenciaEnlace` varchar(1200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ConferenciaTema` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ConferenciaImagen` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ConferenciaVisitas` int(11) NOT NULL,
  `ConferenciaVigencia` int(11) NOT NULL,
  `idPonente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `conferencia`
--

INSERT INTO `conferencia` (`idConferencia`, `ConferenciaTitulo`, `ConferenciaDescripcion`, `ConferenciaFecha`, `ConferenciaEnlace`, `ConferenciaTema`, `ConferenciaImagen`, `ConferenciaVisitas`, `ConferenciaVigencia`, `idPonente`) VALUES
(1, '“¿Cómo sobrellevar la cuarentena con motivación?”', 'Ante el encierro en nuestras casas al que nos obliga la emergencia nacional por la propagación del covid-19, en esta conferencia se le brindará recomendaciones para cuidar la salud mental y evitar situaciones de conflicto en la familia.', '2020-09-25', 'https://meet.google.com/opt-jzko-wdc', 'Motivación personal', 'CF09468896591-WhatsApp Image 2020-11-02 at 11.16.48 PM.jpeg', 0, 1, 8),
(2, '“La Buena Salud empieza con la Salud Mental”', 'La salud mental es esencial para la salud y el bien estar de una persona y su comunidad y para que puedan funcionar efectivamente. También ayuda a determinar cómo manejamos el estrés, nos relacionamos con los demás y tomamos decisiones. La salud mental es importante en todas las etapas de la vida, desde la niñez y la adolescencia hasta la adultez y la vejez.', '2020-12-12', 'https://meet.google.com/moi-evcb-vmz', 'Bienestar psicológico', 'CF94334703292-WhatsApp Image 2020-11-02 at 11.17.22 PM.jpeg', 0, 1, 9),
(3, '“La Salud Emocional: La sanación de las crisis y heridas emocionales en terapia”', 'La salud emocional, es el equilibrio donde nos sentimos bien con nosotros mismos y con los demás. Es el complemento para una vida activa y sana. Consiste en aprender a reconocer nuestras emociones y desarrollar un comportamiento que permita expresarlas. Ser emocionalmente saludable no significa que sea feliz todo el tiempo. Significa que es consciente de sus emociones. Puede lidiar con ellas, ya sean positivas o negativas.', '2020-11-10', 'https://meet.google.com/sba-ixuo-zqk', 'Heridas emocionales', 'CF55381872193-WhatsApp Image 2020-11-02 at 11.23.08 PM.jpeg', 0, 1, 10),
(4, '“¿Cómo afrontar el duelo cuando fallece un ser querido?”', 'Durante el tiempo de aflicción y durante todo el proceso de duelo, una persona afligida necesita mucho apoyo emocional. La búsqueda de fuentes de apoyo puede ser la clave para la recuperación y aceptación de la pérdida para esta persona. Los familiares, amigos, grupos de apoyo, organizaciones comunitarias o profesionales de la salud mental (psicoterapeutas) pueden todos ser una ayuda.', '2020-11-15', 'https://meet.google.com/ggh-vnim-ptp', 'Bienestar emocional', 'CF09092619454-WhatsApp Image 2020-11-02 at 11.23.53 PM.jpeg', 0, 1, 11),
(6, '“Como afrontar el estrés y el miedo durante la crisis de la Covid-19”', 'La propagación del coronavirus ha desatado una crisis sin precedentes en la que a muchos emprendedores les está costando ver la luz al final del túnel. Pero adoptando las medidas adecuadas, muchas start up no sólo conseguirán superar los obstáculos, sino que podrán salir reforzadas. \"No hay que dejarse llevar por el desánimo, esto va a pasar.', '2020-10-24', 'https://meet.google.com/fwi-mbqj-ctw', 'Bienestar psicológico.', 'CF79183741535-WhatsApp Image 2020-11-02 at 11.28.35 PM.jpeg', 0, 1, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consejo`
--

CREATE TABLE `consejo` (
  `idConsejo` int(11) NOT NULL,
  `ConsejoTitulo` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ConsejoDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ConsejoImagen` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idTema` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `consejo`
--

INSERT INTO `consejo` (`idConsejo`, `ConsejoTitulo`, `ConsejoDescripcion`, `ConsejoImagen`, `idTema`) VALUES
(1, 'Céntrate en las necesidades básicas', 'Si te sientes sobrepasado, céntrate en tus necesidades básicas y las de tus hijos: dormir bien, comer sano y practicar a', 'CONSEJO81375869911-WhatsApp Image 2020-11-02 at 11.39.54 PM.jpeg', 3),
(2, 'Tómate descansos breves', 'Para poder cuidar a tu hijo, es importante que tú también te cuides. Hacer breves descansos durante el día, aunque solo ', 'CONSEJO46924087162-WhatsApp Image 2020-11-02 at 11.40.15 PM.jpeg', 3),
(3, 'Pide ayuda', 'No hay nada malo en pedir ayuda a tu comunidad o red de contención. Los profesores de tu hijo, tu comunidad espiritual o', 'CONSEJO39764787473-WhatsApp Image 2020-11-02 at 11.40.34 PM.jpeg', 3),
(4, 'Cuida tu cuerpo y tu mente', 'Si estás teniendo un mal día, imagina que tienes a tu lado a un buen amigo, a tu pareja o a tus padres, que te apoyan y ', 'CONSEJO78293208034-WhatsApp Image 2020-11-02 at 11.41.04 PM.jpeg', 3),
(5, 'Mantente conectado', 'Cuando se intenta buscar el equilibrio entre trabajo y paternidad, resulta difícil hacerse tiempo para conectarse con la', 'CONSEJO36261257695-WhatsApp Image 2020-11-02 at 11.42.13 PM.jpeg', 3),
(6, 'Mantente en contacto con tus amigos', 'Habla con tus amigos y familiares para escuchar una voz conocida y sentirte en compañía mientras mantienes distancia.', 'CONSEJO35393478986-WhatsApp Image 2020-11-02 at 11.43.08 PM.jpeg', 1),
(7, 'Toma decisiones saludables', 'Hacer ejercicio, alimentarse de forma saludable y dormir bien contribuyen a tener un buen estado de salud.', 'CONSEJO79050864997-WhatsApp Image 2020-11-02 at 11.43.24 PM.jpeg', 1),
(8, 'Hazte tiempo para relajarte', 'Realiza actividades saludables que te gusten para liberar el estrés y la ansiedad.', 'CONSEJO58148561138-WhatsApp Image 2020-11-02 at 11.43.43 PM.jpeg', 1),
(9, 'Crea un plan', 'Ponte objetivos con una rutina diaria o semanal.', 'CONSEJO48205829269-WhatsApp Image 2020-11-02 at 11.44.00 PM.jpeg', 1),
(10, 'Conéctate con tus compañeros de trabajo', 'No estás solo en esta situación. Es probable que tus compañeros de trabajo se sientan como tú y puedan apoyarse mutuamen', 'CONSEJO882256946510-WhatsApp Image 2020-11-02 at 11.44.40 PM.jpeg', 2),
(11, 'Valora tu trabajo', 'El trabajo que realizas cada día es valioso e importante. Tómate tiempo para valorar tu servicio y céntrate en las cosas', 'CONSEJO145903014211-WhatsApp Image 2020-11-02 at 11.45.01 PM.jpeg', 2),
(12, 'Reconoce los síntomas del estrés', 'Es normal sentir estrés o ansiedad. Presta atención a los síntomas de estrés para saber cuándo necesitas ayuda adicional', 'CONSEJO769880187912-WhatsApp Image 2020-11-02 at 11.45.20 PM.jpeg', 2),
(13, 'Recuerda a tus seres queridos', 'La pérdida de alguien que te importa puede provocar sentimientos de angustia, tristeza y enojo. Cuando lo sientas oportu', 'CONSEJO960674532313-WhatsApp Image 2020-11-02 at 11.48.13 PM.jpeg', 4),
(14, 'Pide ayuda si la necesitas', 'Es normal sentir angustia y tristeza en momentos de cambios o ante una pérdida. No dudes en pedir ayuda si te sientes de', 'CONSEJO007657626814-WhatsApp Image 2020-11-02 at 11.48.37 PM.jpeg', 4),
(15, 'Habla sobre lo que te está pasando', 'Si perdiste a un ser querido o estás atravesando cambios, busca personas con las que puedas hablar sobre tus sentimiento', 'CONSEJO900509942315-WhatsApp Image 2020-11-02 at 11.48.57 PM.jpeg', 4),
(16, 'Realiza actividades que te gusten', 'Las actividades de todos los días pueden parecer inalcanzables cuando se atraviesa un duelo. Modifica tu rutina y enfóca', 'CONSEJO112713206016-WhatsApp Image 2020-11-02 at 11.49.17 PM.jpeg', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(10) NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPrivilegio` int(1) NOT NULL,
  `CuentaCorreo` varchar(120) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaClave` varchar(535) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaVigencia` int(11) NOT NULL,
  `CuentaTipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaAvatar` varchar(535) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`id`, `CuentaCodigo`, `CuentaPrivilegio`, `CuentaCorreo`, `CuentaClave`, `CuentaVigencia`, `CuentaTipo`, `CuentaAvatar`) VALUES
(1, 'UNPRG34062945281', 1, 'educespedes1998@gmail.com', 'aEhiWkN0NUwvQjNvV2pkcTNtblBodz09', 1, 'Administrador', 'adminMasculino.png'),
(2, 'UNPRG46076026212', 3, 'ecespedeso@unprg.edu.pe', 'aEhiWkN0NUwvQjNvV2pkcTNtblBodz09', 1, 'Usuario', 'userMasculino.png'),
(3, 'UNPRG88369501773', 3, 'cmartinezr@unprg.edu.pe', 'ZzU2RHlMNkhsNEpDcy9IczdORDZvZz09', 1, 'Usuario', 'userFemenino.png'),
(4, 'UNPRG34250108324', 1, 'carmen1996@gmail.com', 'ZzU2RHlMNkhsNEpDcy9IczdORDZvZz09', 1, 'Administrador', 'adminFemenino.png'),
(5, 'UNPRG60211486205', 2, 'adelysa_7@gmail.com', 'ZzU2RHlMNkhsNEpDcy9IczdORDZvZz09', 1, 'Especialista', 'especialista.png'),
(6, 'UNPRG89541168396', 2, 'cmateod@gmail.com', 'ZzU2RHlMNkhsNEpDcy9IczdORDZvZz09', 1, 'Especialista', 'especialista.png'),
(7, 'UNPRG45219348597', 2, 'santiago20_03@gmail.com', 'ZzU2RHlMNkhsNEpDcy9IczdORDZvZz09', 1, 'Especialista', 'especialista.png'),
(8, 'UNPRG70343991188', 2, 'maria_castaneda24@gmail.com', 'ZzU2RHlMNkhsNEpDcy9IczdORDZvZz09', 1, 'Especialista', 'especialista.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL,
  `DepartamentoDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`idDepartamento`, `DepartamentoDescripcion`) VALUES
(1, 'AMAZONAS'),
(2, 'ANCASH'),
(3, 'APURIMAC'),
(4, 'AREQUIPA'),
(5, 'AYACUCHO'),
(6, 'CAJAMARCA'),
(7, 'CALLAO'),
(8, 'CUSCO'),
(9, 'HUANCAVELICA'),
(10, 'HUANUCO'),
(11, 'ICA'),
(12, 'JUNIN'),
(13, 'LA LIBERTAD'),
(14, 'LAMBAYEQUE'),
(15, 'LIMA'),
(16, 'LORETO'),
(17, 'MADRE DE DIOS'),
(18, 'MOQUEGUA'),
(19, 'PASCO'),
(20, 'PIURA'),
(21, 'PUNO'),
(22, 'SAN MARTIN'),
(23, 'TACNA'),
(24, 'TUMBES'),
(25, 'UCAYALI');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_conferencia`
--

CREATE TABLE `detalle_conferencia` (
  `idDetalleConferencia` int(11) NOT NULL,
  `FechaDetalle` date NOT NULL,
  `idConferencia` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `detalle_conferencia`
--

INSERT INTO `detalle_conferencia` (`idDetalleConferencia`, `FechaDetalle`, `idConferencia`, `idUsuario`) VALUES
(1, '2020-11-03', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico`
--

CREATE TABLE `diagnostico` (
  `idDiagnostico` int(11) NOT NULL,
  `idAtencion` int(11) NOT NULL,
  `DiagnosticoDescripcion` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `DiagnosticoEstado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `diagnostico`
--

INSERT INTO `diagnostico` (`idDiagnostico`, `idAtencion`, `DiagnosticoDescripcion`, `DiagnosticoEstado`) VALUES
(1, 1, 'Hola Edú, leí tu problema, y te aconsejo que cambies  de amistades porque ellos no te te llevarán a nada bueno. Dedicate tiempo para ti mismo, y juntate con personas productivas que te ayuden a mejorar como persona y como estudiante. Eres importante y mereces cosas muy buenas en la vida.\r\nSigue estando en contacto conmigo si necesitas que alguien te escuche, acá siempre estaré para decirte lo lindo e importante que eres. Cuidate mucho.', 1),
(2, 2, 'Eres muy inteligente y guapo, sigue adelante, vas a llegar muy lejos.', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `idDistrito` int(11) NOT NULL,
  `DistritoDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idProvincia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`idDistrito`, `DistritoDescripcion`, `idProvincia`) VALUES
(1, 'CHACHAPOYAS', 1),
(2, 'ASUNCION', 1),
(3, 'BALSAS', 1),
(4, 'CHETO', 1),
(5, 'CHILIQUIN', 1),
(6, 'CHUQUIBAMBA', 1),
(7, 'GRANADA', 1),
(8, 'HUANCAS', 1),
(9, 'LA JALCA', 1),
(10, 'LEIMEBAMBA', 1),
(11, 'LEVANTO', 1),
(12, 'MAGDALENA', 1),
(13, 'MARISCAL CASTILLA', 1),
(14, 'MOLINOPAMPA', 1),
(15, 'MONTEVIDEO', 1),
(16, 'OLLEROS', 1),
(17, 'QUINJALCA', 1),
(18, 'SAN FRANCISCO DE DAGUAS', 1),
(19, 'SAN ISIDRO DE MAINO', 1),
(20, 'SOLOCO', 1),
(21, 'SONCHE', 1),
(22, 'LA PECA', 2),
(23, 'ARAMANGO', 2),
(24, 'COPALLIN', 2),
(25, 'EL PARCO', 2),
(26, 'IMAZA', 2),
(27, 'JUMBILLA', 3),
(28, 'CHISQUILLA', 3),
(29, 'CHURUJA', 3),
(30, 'COROSHA', 3),
(31, 'CUISPES', 3),
(32, 'FLORIDA', 3),
(33, 'JAZAN', 3),
(34, 'RECTA', 3),
(35, 'SAN CARLOS', 3),
(36, 'SHIPASBAMBA', 3),
(37, 'VALERA', 3),
(38, 'YAMBRASBAMBA', 3),
(39, 'NIEVA', 4),
(40, 'EL CENEPA', 4),
(41, 'RIO SANTIAGO', 4),
(42, 'LAMUD', 5),
(43, 'CAMPORREDONDO', 5),
(44, 'COCABAMBA', 5),
(45, 'COLCAMAR', 5),
(46, 'CONILA', 5),
(47, 'INGUILPATA', 5),
(48, 'LONGUITA', 5),
(49, 'LONYA CHICO', 5),
(50, 'LUYA', 5),
(51, 'LUYA VIEJO', 5),
(52, 'MARIA', 5),
(53, 'OCALLI', 5),
(54, 'OCUMAL', 5),
(55, 'PISUQUIA', 5),
(56, 'PROVIDENCIA', 5),
(57, 'SAN CRISTOBAL', 5),
(58, 'SAN FRANCISCO DEL YESO', 5),
(59, 'SAN JERONIMO', 5),
(60, 'SAN JUAN DE LOPECANCHA', 5),
(61, 'SANTA CATALINA', 5),
(62, 'SANTO TOMAS', 5),
(63, 'TINGO', 5),
(64, 'TRITA', 5),
(65, 'SAN NICOLAS', 6),
(66, 'CHIRIMOTO', 6),
(67, 'COCHAMAL', 6),
(68, 'HUAMBO', 6),
(69, 'LIMABAMBA', 6),
(70, 'LONGAR', 6),
(71, 'MARISCAL BENAVIDES', 6),
(72, 'MILPUC', 6),
(73, 'OMIA', 6),
(74, 'SANTA ROSA', 6),
(75, 'TOTORA', 6),
(76, 'VISTA ALEGRE', 6),
(77, 'BAGUA GRANDE', 7),
(78, 'CAJARURO', 7),
(79, 'CUMBA', 7),
(80, 'EL MILAGRO', 7),
(81, 'JAMALCA', 7),
(82, 'LONYA GRANDE', 7),
(83, 'YAMON', 7),
(84, 'HUARAZ', 8),
(85, 'COCHABAMBA', 8),
(86, 'COLCABAMBA', 8),
(87, 'HUANCHAY', 8),
(88, 'INDEPENDENCIA', 8),
(89, 'JANGAS', 8),
(90, 'LA LIBERTAD', 8),
(91, 'OLLEROS', 8),
(92, 'PAMPAS', 8),
(93, 'PARIACOTO', 8),
(94, 'PIRA', 8),
(95, 'TARICA', 8),
(96, 'AIJA', 9),
(97, 'CORIS', 9),
(98, 'HUACLLAN', 9),
(99, 'LA MERCED', 9),
(100, 'SUCCHA', 9),
(101, 'LLAMELLIN', 10),
(102, 'ACZO', 10),
(103, 'CHACCHO', 10),
(104, 'CHINGAS', 10),
(105, 'MIRGAS', 10),
(106, 'SAN JUAN DE RONTOY', 10),
(107, 'CHACAS', 11),
(108, 'ACOCHACA', 11),
(109, 'CHIQUIAN', 12),
(110, 'ABELARDO PARDO LEZAMETA', 12),
(111, 'ANTONIO RAYMONDI', 12),
(112, 'AQUIA', 12),
(113, 'CAJACAY', 12),
(114, 'CANIS', 12),
(115, 'COLQUIOC', 12),
(116, 'HUALLANCA', 12),
(117, 'HUASTA', 12),
(118, 'HUAYLLACAYAN', 12),
(119, 'LA PRIMAVERA', 12),
(120, 'MANGAS', 12),
(121, 'PACLLON', 12),
(122, 'SAN MIGUEL DE CORPANQUI', 12),
(123, 'TICLLOS', 12),
(124, 'CARHUAZ', 13),
(125, 'ACOPAMPA', 13),
(126, 'AMASHCA', 13),
(127, 'ANTA', 13),
(128, 'ATAQUERO', 13),
(129, 'MARCARA', 13),
(130, 'PARIAHUANCA', 13),
(131, 'SAN MIGUEL DE ACO', 13),
(132, 'SHILLA', 13),
(133, 'TINCO', 13),
(134, 'YUNGAR', 13),
(135, 'SAN LUIS', 14),
(136, 'SAN NICOLAS', 14),
(137, 'YAUYA', 14),
(138, 'CASMA', 15),
(139, 'BUENA VISTA ALTA', 15),
(140, 'COMANDANTE NOEL', 15),
(141, 'YAUTAN', 15),
(142, 'CORONGO', 16),
(143, 'ACO', 16),
(144, 'BAMBAS', 16),
(145, 'CUSCA', 16),
(146, 'LA PAMPA', 16),
(147, 'YANAC', 16),
(148, 'YUPAN', 16),
(149, 'HUARI', 17),
(150, 'ANRA', 17),
(151, 'CAJAY', 17),
(152, 'CHAVIN DE HUANTAR', 17),
(153, 'HUACACHI', 17),
(154, 'HUACCHIS', 17),
(155, 'HUACHIS', 17),
(156, 'HUANTAR', 17),
(157, 'MASIN', 17),
(158, 'PAUCAS', 17),
(159, 'PONTO', 17),
(160, 'RAHUAPAMPA', 17),
(161, 'RAPAYAN', 17),
(162, 'SAN MARCOS', 17),
(163, 'SAN PEDRO DE CHANA', 17),
(164, 'UCO', 17),
(165, 'HUARMEY', 18),
(166, 'COCHAPETI', 18),
(167, 'CULEBRAS', 18),
(168, 'HUAYAN', 18),
(169, 'MALVAS', 18),
(170, 'CARAZ', 26),
(171, 'HUALLANCA', 26),
(172, 'HUATA', 26),
(173, 'HUAYLAS', 26),
(174, 'MATO', 26),
(175, 'PAMPAROMAS', 26),
(176, 'PUEBLO LIBRE', 26),
(177, 'SANTA CRUZ', 26),
(178, 'SANTO TORIBIO', 26),
(179, 'YURACMARCA', 26),
(180, 'PISCOBAMBA', 27),
(181, 'CASCA', 27),
(182, 'ELEAZAR GUZMAN BARRON', 27),
(183, 'FIDEL OLIVAS ESCUDERO', 27),
(184, 'LLAMA', 27),
(185, 'LLUMPA', 27),
(186, 'LUCMA', 27),
(187, 'MUSGA', 27),
(188, 'OCROS', 21),
(189, 'ACAS', 21),
(190, 'CAJAMARQUILLA', 21),
(191, 'CARHUAPAMPA', 21),
(192, 'COCHAS', 21),
(193, 'CONGAS', 21),
(194, 'LLIPA', 21),
(195, 'SAN CRISTOBAL DE RAJAN', 21),
(196, 'SAN PEDRO', 21),
(197, 'SANTIAGO DE CHILCAS', 21),
(198, 'CABANA', 22),
(199, 'BOLOGNESI', 22),
(200, 'CONCHUCOS', 22),
(201, 'HUACASCHUQUE', 22),
(202, 'HUANDOVAL', 22),
(203, 'LACABAMBA', 22),
(204, 'LLAPO', 22),
(205, 'PALLASCA', 22),
(206, 'PAMPAS', 22),
(207, 'SANTA ROSA', 22),
(208, 'TAUCA', 22),
(209, 'POMABAMBA', 23),
(210, 'HUAYLLAN', 23),
(211, 'PAROBAMBA', 23),
(212, 'QUINUABAMBA', 23),
(213, 'RECUAY', 24),
(214, 'CATAC', 24),
(215, 'COTAPARACO', 24),
(216, 'HUAYLLAPAMPA', 24),
(217, 'LLACLLIN', 24),
(218, 'MARCA', 24),
(219, 'PAMPAS CHICO', 24),
(220, 'PARARIN', 24),
(221, 'TAPACOCHA', 24),
(222, 'TICAPAMPA', 24),
(223, 'CHIMBOTE', 25),
(224, 'CACERES DEL PERU', 25),
(225, 'COISHCO', 25),
(226, 'MACATE', 25),
(227, 'MORO', 25),
(228, 'NEPE&Ntilde;A', 25),
(229, 'SAMANCO', 25),
(230, 'SANTA', 25),
(231, 'NUEVO CHIMBOTE', 25),
(232, 'SIHUAS', 26),
(233, 'ACOBAMBA', 26),
(234, 'ALFONSO UGARTE', 26),
(235, 'CASHAPAMPA', 26),
(236, 'CHINGALPO', 26),
(237, 'HUAYLLABAMBA', 26),
(238, 'QUICHES', 26),
(239, 'RAGASH', 26),
(240, 'SAN JUAN', 26),
(241, 'SICSIBAMBA', 26),
(242, 'YUNGAY', 27),
(243, 'CASCAPARA', 27),
(244, 'MANCOS', 27),
(245, 'MATACOTO', 27),
(246, 'QUILLO', 27),
(247, 'RANRAHIRCA', 27),
(248, 'SHUPLUY', 27),
(249, 'YANAMA', 27),
(250, 'ABANCAY', 28),
(251, 'CHACOCHE', 28),
(252, 'CIRCA', 28),
(253, 'CURAHUASI', 28),
(254, 'HUANIPACA', 28),
(255, 'LAMBRAMA', 28),
(256, 'PICHIRHUA', 28),
(257, 'SAN PEDRO DE CACHORA', 28),
(258, 'TAMBURCO', 28),
(259, 'ANDAHUAYLAS', 29),
(260, 'ANDARAPA', 29),
(261, 'CHIARA', 29),
(262, 'HUANCARAMA', 29),
(263, 'HUANCARAY', 29),
(264, 'HUAYANA', 29),
(265, 'KISHUARA', 29),
(266, 'PACOBAMBA', 29),
(267, 'PACUCHA', 29),
(268, 'PAMPACHIRI', 29),
(269, 'POMACOCHA', 29),
(270, 'SAN ANTONIO DE CACHI', 29),
(271, 'SAN JERONIMO', 29),
(272, 'SAN MIGUEL DE CHACCRAMPA', 29),
(273, 'SANTA MARIA DE CHICMO', 29),
(274, 'TALAVERA', 29),
(275, 'TUMAY HUARACA', 29),
(276, 'TURPO', 29),
(277, 'KAQUIABAMBA', 29),
(278, 'ANTABAMBA', 30),
(279, 'EL ORO', 30),
(280, 'HUAQUIRCA', 30),
(281, 'JUAN ESPINOZA MEDRANO', 30),
(282, 'OROPESA', 30),
(283, 'PACHACONAS', 30),
(284, 'SABAINO', 30),
(285, 'CHALHUANCA', 31),
(286, 'CAPAYA', 31),
(287, 'CARAYBAMBA', 31),
(288, 'CHAPIMARCA', 31),
(289, 'COLCABAMBA', 31),
(290, 'COTARUSE', 31),
(291, 'HUAYLLO', 31),
(292, 'JUSTO APU SAHUARAURA', 31),
(293, 'LUCRE', 31),
(294, 'POCOHUANCA', 31),
(295, 'SAN JUAN DE CHAC&Ntilde;A', 31),
(296, 'SA&Ntilde;AYCA', 31),
(297, 'SORAYA', 31),
(298, 'TAPAIRIHUA', 31),
(299, 'TINTAY', 31),
(300, 'TORAYA', 31),
(301, 'YANACA', 31),
(302, 'TAMBOBAMBA', 32),
(303, 'COTABAMBAS', 32),
(304, 'COYLLURQUI', 32),
(305, 'HAQUIRA', 32),
(306, 'MARA', 32),
(307, 'CHALLHUAHUACHO', 32),
(308, 'CHINCHEROS', 33),
(309, 'ANCO-HUALLO', 33),
(310, 'COCHARCAS', 33),
(311, 'HUACCANA', 33),
(312, 'OCOBAMBA', 33),
(313, 'ONGOY', 33),
(314, 'URANMARCA', 33),
(315, 'RANRACANCHA', 33),
(316, 'CHUQUIBAMBILLA', 34),
(317, 'CURPAHUASI', 34),
(318, 'GAMARRA', 34),
(319, 'HUAYLLATI', 34),
(320, 'MAMARA', 34),
(321, 'MICAELA BASTIDAS', 34),
(322, 'PATAYPAMPA', 34),
(323, 'PROGRESO', 34),
(324, 'SAN ANTONIO', 34),
(325, 'SANTA ROSA', 34),
(326, 'TURPAY', 34),
(327, 'VILCABAMBA', 34),
(328, 'VIRUNDO', 34),
(329, 'CURASCO', 34),
(330, 'AREQUIPA', 35),
(331, 'ALTO SELVA ALEGRE', 35),
(332, 'CAYMA', 35),
(333, 'CERRO COLORADO', 35),
(334, 'CHARACATO', 35),
(335, 'CHIGUATA', 35),
(336, 'JACOBO HUNTER', 35),
(337, 'LA JOYA', 35),
(338, 'MARIANO MELGAR', 35),
(339, 'MIRAFLORES', 35),
(340, 'MOLLEBAYA', 35),
(341, 'PAUCARPATA', 35),
(342, 'POCSI', 35),
(343, 'POLOBAYA', 35),
(344, 'QUEQUE&Ntilde;A', 35),
(345, 'SABANDIA', 35),
(346, 'SACHACA', 35),
(347, 'SAN JUAN DE SIGUAS', 35),
(348, 'SAN JUAN DE TARUCANI', 35),
(349, 'SANTA ISABEL DE SIGUAS', 35),
(350, 'SANTA RITA DE SIGUAS', 35),
(351, 'SOCABAYA', 35),
(352, 'TIABAYA', 35),
(353, 'UCHUMAYO', 35),
(354, 'VITOR', 35),
(355, 'YANAHUARA', 35),
(356, 'YARABAMBA', 35),
(357, 'YURA', 35),
(358, 'JOSE LUIS BUSTAMANTE Y RIVERO', 35),
(359, 'CAMANA', 36),
(360, 'JOSE MARIA QUIMPER', 36),
(361, 'MARIANO NICOLAS VALCARCEL', 36),
(362, 'MARISCAL CACERES', 36),
(363, 'NICOLAS DE PIEROLA', 36),
(364, 'OCO&Ntilde;A', 36),
(365, 'QUILCA', 36),
(366, 'SAMUEL PASTOR', 36),
(367, 'CARAVELI', 37),
(368, 'ACARI', 37),
(369, 'ATICO', 37),
(370, 'ATIQUIPA', 37),
(371, 'BELLA UNION', 37),
(372, 'CAHUACHO', 37),
(373, 'CHALA', 37),
(374, 'CHAPARRA', 37),
(375, 'HUANUHUANU', 37),
(376, 'JAQUI', 37),
(377, 'LOMAS', 37),
(378, 'QUICACHA', 37),
(379, 'YAUCA', 37),
(380, 'APLAO', 38),
(381, 'ANDAGUA', 38),
(382, 'AYO', 38),
(383, 'CHACHAS', 38),
(384, 'CHILCAYMARCA', 38),
(385, 'CHOCO', 38),
(386, 'HUANCARQUI', 38),
(387, 'MACHAGUAY', 38),
(388, 'ORCOPAMPA', 38),
(389, 'PAMPACOLCA', 38),
(390, 'TIPAN', 38),
(391, 'U&Ntilde;ON', 38),
(392, 'URACA', 38),
(393, 'VIRACO', 38),
(394, 'CHIVAY', 39),
(395, 'ACHOMA', 39),
(396, 'CABANACONDE', 39),
(397, 'CALLALLI', 39),
(398, 'CAYLLOMA', 39),
(399, 'COPORAQUE', 39),
(400, 'HUAMBO', 39),
(401, 'HUANCA', 39),
(402, 'ICHUPAMPA', 39),
(403, 'LARI', 39),
(404, 'LLUTA', 39),
(405, 'MACA', 39),
(406, 'MADRIGAL', 39),
(407, 'SAN ANTONIO DE CHUCA', 39),
(408, 'SIBAYO', 39),
(409, 'TAPAY', 39),
(410, 'TISCO', 39),
(411, 'TUTI', 39),
(412, 'YANQUE', 39),
(413, 'MAJES', 39),
(414, 'CHUQUIBAMBA', 40),
(415, 'ANDARAY', 40),
(416, 'CAYARANI', 40),
(417, 'CHICHAS', 40),
(418, 'IRAY', 40),
(419, 'RIO GRANDE', 40),
(420, 'SALAMANCA', 40),
(421, 'YANAQUIHUA', 40),
(422, 'MOLLENDO', 41),
(423, 'COCACHACRA', 41),
(424, 'DEAN VALDIVIA', 41),
(425, 'ISLAY', 41),
(426, 'MEJIA', 41),
(427, 'PUNTA DE BOMBON', 41),
(428, 'COTAHUASI', 42),
(429, 'ALCA', 42),
(430, 'CHARCANA', 42),
(431, 'HUAYNACOTAS', 42),
(432, 'PAMPAMARCA', 42),
(433, 'PUYCA', 42),
(434, 'QUECHUALLA', 42),
(435, 'SAYLA', 42),
(436, 'TAURIA', 42),
(437, 'TOMEPAMPA', 42),
(438, 'TORO', 42),
(439, 'AYACUCHO', 43),
(440, 'ACOCRO', 43),
(441, 'ACOS VINCHOS', 43),
(442, 'CARMEN ALTO', 43),
(443, 'CHIARA', 43),
(444, 'OCROS', 43),
(445, 'PACAYCASA', 43),
(446, 'QUINUA', 43),
(447, 'SAN JOSE DE TICLLAS', 43),
(448, 'SAN JUAN BAUTISTA', 43),
(449, 'SANTIAGO DE PISCHA', 43),
(450, 'SOCOS', 43),
(451, 'TAMBILLO', 43),
(452, 'VINCHOS', 43),
(453, 'JESUS NAZARENO', 43),
(454, 'CANGALLO', 44),
(455, 'CHUSCHI', 44),
(456, 'LOS MOROCHUCOS', 44),
(457, 'MARIA PARADO DE BELLIDO', 44),
(458, 'PARAS', 44),
(459, 'TOTOS', 44),
(460, 'SANCOS', 45),
(461, 'CARAPO', 45),
(462, 'SACSAMARCA', 45),
(463, 'SANTIAGO DE LUCANAMARCA', 45),
(464, 'HUANTA', 46),
(465, 'AYAHUANCO', 46),
(466, 'HUAMANGUILLA', 46),
(467, 'IGUAIN', 46),
(468, 'LURICOCHA', 46),
(469, 'SANTILLANA', 46),
(470, 'SIVIA', 46),
(471, 'LLOCHEGUA', 46),
(472, 'SAN MIGUEL', 47),
(473, 'ANCO', 47),
(474, 'AYNA', 47),
(475, 'CHILCAS', 47),
(476, 'CHUNGUI', 47),
(477, 'LUIS CARRANZA', 47),
(478, 'SANTA ROSA', 47),
(479, 'TAMBO', 47),
(480, 'PUQUIO', 48),
(481, 'AUCARA', 48),
(482, 'CABANA', 48),
(483, 'CARMEN SALCEDO', 48),
(484, 'CHAVI&Ntilde;A', 48),
(485, 'CHIPAO', 48),
(486, 'HUAC-HUAS', 48),
(487, 'LARAMATE', 48),
(488, 'LEONCIO PRADO', 48),
(489, 'LLAUTA', 48),
(490, 'LUCANAS', 48),
(491, 'OCA&Ntilde;A', 48),
(492, 'OTOCA', 48),
(493, 'SAISA', 48),
(494, 'SAN CRISTOBAL', 48),
(495, 'SAN JUAN', 48),
(496, 'SAN PEDRO', 48),
(497, 'SAN PEDRO DE PALCO', 48),
(498, 'SANCOS', 48),
(499, 'SANTA ANA DE HUAYCAHUACHO', 48),
(500, 'SANTA LUCIA', 48),
(501, 'CORACORA', 49),
(502, 'CHUMPI', 49),
(503, 'CORONEL CASTA&Ntilde;EDA', 49),
(504, 'PACAPAUSA', 49),
(505, 'PULLO', 49),
(506, 'PUYUSCA', 49),
(507, 'SAN FRANCISCO DE RAVACAYCO', 49),
(508, 'UPAHUACHO', 49),
(509, 'PAUSA', 50),
(510, 'COLTA', 50),
(511, 'CORCULLA', 50),
(512, 'LAMPA', 50),
(513, 'MARCABAMBA', 50),
(514, 'OYOLO', 50),
(515, 'PARARCA', 50),
(516, 'SAN JAVIER DE ALPABAMBA', 50),
(517, 'SAN JOSE DE USHUA', 50),
(518, 'SARA SARA', 50),
(519, 'QUEROBAMBA', 51),
(520, 'BELEN', 51),
(521, 'CHALCOS', 51),
(522, 'CHILCAYOC', 51),
(523, 'HUACA&Ntilde;A', 51),
(524, 'MORCOLLA', 51),
(525, 'PAICO', 51),
(526, 'SAN PEDRO DE LARCAY', 51),
(527, 'SAN SALVADOR DE QUIJE', 51),
(528, 'SANTIAGO DE PAUCARAY', 51),
(529, 'SORAS', 51),
(530, 'HUANCAPI', 52),
(531, 'ALCAMENCA', 52),
(532, 'APONGO', 52),
(533, 'ASQUIPATA', 52),
(534, 'CANARIA', 52),
(535, 'CAYARA', 52),
(536, 'COLCA', 52),
(537, 'HUAMANQUIQUIA', 52),
(538, 'HUANCARAYLLA', 52),
(539, 'HUAYA', 52),
(540, 'SARHUA', 52),
(541, 'VILCANCHOS', 52),
(542, 'VILCAS HUAMAN', 53),
(543, 'ACCOMARCA', 53),
(544, 'CARHUANCA', 53),
(545, 'CONCEPCION', 53),
(546, 'HUAMBALPA', 53),
(547, 'INDEPENDENCIA', 53),
(548, 'SAURAMA', 53),
(549, 'VISCHONGO', 53),
(550, 'CAJAMARCA', 54),
(551, 'CAJAMARCA', 54),
(552, 'ASUNCION', 54),
(553, 'CHETILLA', 54),
(554, 'COSPAN', 54),
(555, 'ENCA&Ntilde;ADA', 54),
(556, 'JESUS', 54),
(557, 'LLACANORA', 54),
(558, 'LOS BA&Ntilde;OS DEL INCA', 54),
(559, 'MAGDALENA', 54),
(560, 'MATARA', 54),
(561, 'NAMORA', 54),
(562, 'SAN JUAN', 54),
(563, 'CAJABAMBA', 55),
(564, 'CACHACHI', 55),
(565, 'CONDEBAMBA', 55),
(566, 'SITACOCHA', 55),
(567, 'CELENDIN', 56),
(568, 'CHUMUCH', 56),
(569, 'CORTEGANA', 56),
(570, 'HUASMIN', 56),
(571, 'JORGE CHAVEZ', 56),
(572, 'JOSE GALVEZ', 56),
(573, 'MIGUEL IGLESIAS', 56),
(574, 'OXAMARCA', 56),
(575, 'SOROCHUCO', 56),
(576, 'SUCRE', 56),
(577, 'UTCO', 56),
(578, 'LA LIBERTAD DE PALLAN', 56),
(579, 'CHOTA', 57),
(580, 'ANGUIA', 57),
(581, 'CHADIN', 57),
(582, 'CHIGUIRIP', 57),
(583, 'CHIMBAN', 57),
(584, 'CHOROPAMPA', 57),
(585, 'COCHABAMBA', 57),
(586, 'CONCHAN', 57),
(587, 'HUAMBOS', 57),
(588, 'LAJAS', 57),
(589, 'LLAMA', 57),
(590, 'MIRACOSTA', 57),
(591, 'PACCHA', 57),
(592, 'PION', 57),
(593, 'QUEROCOTO', 57),
(594, 'SAN JUAN DE LICUPIS', 57),
(595, 'TACABAMBA', 57),
(596, 'TOCMOCHE', 57),
(597, 'CHALAMARCA', 57),
(598, 'CONTUMAZA', 58),
(599, 'CHILETE', 58),
(600, 'CUPISNIQUE', 58),
(601, 'GUZMANGO', 58),
(602, 'SAN BENITO', 58),
(603, 'SANTA CRUZ DE TOLED', 58),
(604, 'TANTARICA', 58),
(605, 'YONAN', 58),
(606, 'CUTERVO', 59),
(607, 'CALLAYUC', 59),
(608, 'CHOROS', 59),
(609, 'CUJILLO', 59),
(610, 'LA RAMADA', 59),
(611, 'PIMPINGOS', 59),
(612, 'QUEROCOTILLO', 59),
(613, 'SAN ANDRES DE CUTERVO', 59),
(614, 'SAN JUAN DE CUTERVO', 59),
(615, 'SAN LUIS DE LUCMA', 59),
(616, 'SANTA CRUZ', 59),
(617, 'SANTO DOMINGO DE LA CAPILLA', 59),
(618, 'SANTO TOMAS', 59),
(619, 'SOCOTA', 59),
(620, 'TORIBIO CASANOVA', 59),
(621, 'BAMBAMARCA', 60),
(622, 'CHUGUR', 60),
(623, 'HUALGAYOC', 60),
(624, 'JAEN', 61),
(625, 'BELLAVISTA', 61),
(626, 'CHONTALI', 61),
(627, 'COLASAY', 61),
(628, 'HUABAL', 61),
(629, 'LAS PIRIAS', 61),
(630, 'POMAHUACA', 61),
(631, 'PUCARA', 61),
(632, 'SALLIQUE', 61),
(633, 'SAN FELIPE', 61),
(634, 'SAN JOSE DEL ALTO', 61),
(635, 'SANTA ROSA', 61),
(636, 'SAN IGNACIO', 62),
(637, 'CHIRINOS', 62),
(638, 'HUARANGO', 62),
(639, 'LA COIPA', 62),
(640, 'NAMBALLE', 62),
(641, 'SAN JOSE DE LOURDES', 62),
(642, 'TABACONAS', 62),
(643, 'PEDRO GALVEZ', 63),
(644, 'CHANCAY', 63),
(645, 'EDUARDO VILLANUEVA', 63),
(646, 'GREGORIO PITA', 63),
(647, 'ICHOCAN', 63),
(648, 'JOSE MANUEL QUIROZ', 63),
(649, 'JOSE SABOGAL', 63),
(650, 'SAN MIGUEL', 64),
(651, 'SAN MIGUEL', 64),
(652, 'BOLIVAR', 64),
(653, 'CALQUIS', 64),
(654, 'CATILLUC', 64),
(655, 'EL PRADO', 64),
(656, 'LA FLORIDA', 64),
(657, 'LLAPA', 64),
(658, 'NANCHOC', 64),
(659, 'NIEPOS', 64),
(660, 'SAN GREGORIO', 64),
(661, 'SAN SILVESTRE DE COCHAN', 64),
(662, 'TONGOD', 64),
(663, 'UNION AGUA BLANCA', 64),
(664, 'SAN PABLO', 65),
(665, 'SAN BERNARDINO', 65),
(666, 'SAN LUIS', 65),
(667, 'TUMBADEN', 65),
(668, 'SANTA CRUZ', 66),
(669, 'ANDABAMBA', 66),
(670, 'CATACHE', 66),
(671, 'CHANCAYBA&Ntilde;OS', 66),
(672, 'LA ESPERANZA', 66),
(673, 'NINABAMBA', 66),
(674, 'PULAN', 66),
(675, 'SAUCEPAMPA', 66),
(676, 'SEXI', 66),
(677, 'UTICYACU', 66),
(678, 'YAUYUCAN', 66),
(679, 'CALLAO', 67),
(680, 'BELLAVISTA', 67),
(681, 'CARMEN DE LA LEGUA REYNOSO', 67),
(682, 'LA PERLA', 67),
(683, 'LA PUNTA', 67),
(684, 'VENTANILLA', 67),
(685, 'CUSCO', 67),
(686, 'CCORCA', 67),
(687, 'POROY', 67),
(688, 'SAN JERONIMO', 67),
(689, 'SAN SEBASTIAN', 67),
(690, 'SANTIAGO', 67),
(691, 'SAYLLA', 67),
(692, 'WANCHAQ', 67),
(693, 'ACOMAYO', 68),
(694, 'ACOPIA', 68),
(695, 'ACOS', 68),
(696, 'MOSOC LLACTA', 68),
(697, 'POMACANCHI', 68),
(698, 'RONDOCAN', 68),
(699, 'SANGARARA', 68),
(700, 'ANTA', 69),
(701, 'ANCAHUASI', 69),
(702, 'CACHIMAYO', 69),
(703, 'CHINCHAYPUJIO', 69),
(704, 'HUAROCONDO', 69),
(705, 'LIMATAMBO', 69),
(706, 'MOLLEPATA', 69),
(707, 'PUCYURA', 69),
(708, 'ZURITE', 69),
(709, 'CALCA', 70),
(710, 'COYA', 70),
(711, 'LAMAY', 70),
(712, 'LARES', 70),
(713, 'PISAC', 70),
(714, 'SAN SALVADOR', 70),
(715, 'TARAY', 70),
(716, 'YANATILE', 70),
(717, 'YANAOCA', 71),
(718, 'CHECCA', 71),
(719, 'KUNTURKANKI', 71),
(720, 'LANGUI', 71),
(721, 'LAYO', 71),
(722, 'PAMPAMARCA', 71),
(723, 'QUEHUE', 71),
(724, 'TUPAC AMARU', 71),
(725, 'SICUANI', 72),
(726, 'CHECACUPE', 72),
(727, 'COMBAPATA', 72),
(728, 'MARANGANI', 72),
(729, 'PITUMARCA', 72),
(730, 'SAN PABLO', 72),
(731, 'SAN PEDRO', 72),
(732, 'TINTA', 72),
(733, 'SANTO TOMAS', 73),
(734, 'CAPACMARCA', 73),
(735, 'CHAMACA', 73),
(736, 'COLQUEMARCA', 73),
(737, 'LIVITACA', 73),
(738, 'LLUSCO', 73),
(739, 'QUI&Ntilde;OTA', 73),
(740, 'VELILLE', 73),
(741, 'ESPINAR', 74),
(742, 'CONDOROMA', 74),
(743, 'COPORAQUE', 74),
(744, 'OCORURO', 74),
(745, 'PALLPATA', 74),
(746, 'PICHIGUA', 74),
(747, 'SUYCKUTAMBO', 74),
(748, 'ALTO PICHIGUA', 74),
(749, 'SANTA ANA', 75),
(750, 'ECHARATE', 75),
(751, 'HUAYOPATA', 75),
(752, 'MARANURA', 75),
(753, 'OCOBAMBA', 75),
(754, 'QUELLOUNO', 75),
(755, 'KIMBIRI', 75),
(756, 'SANTA TERESA', 75),
(757, 'VILCABAMBA', 75),
(758, 'PICHARI', 75),
(759, 'PARURO', 76),
(760, 'ACCHA', 76),
(761, 'CCAPI', 76),
(762, 'COLCHA', 76),
(763, 'HUANOQUITE', 76),
(764, 'OMACHA', 76),
(765, 'PACCARITAMBO', 76),
(766, 'PILLPINTO', 76),
(767, 'YAURISQUE', 76),
(768, 'PAUCARTAMBO', 77),
(769, 'CAICAY', 77),
(770, 'CHALLABAMBA', 77),
(771, 'COLQUEPATA', 77),
(772, 'HUANCARANI', 77),
(773, 'KOS&Ntilde;IPATA', 77),
(774, 'URCOS', 78),
(775, 'ANDAHUAYLILLAS', 78),
(776, 'CAMANTI', 78),
(777, 'CCARHUAYO', 78),
(778, 'CCATCA', 78),
(779, 'CUSIPATA', 78),
(780, 'HUARO', 78),
(781, 'LUCRE', 78),
(782, 'MARCAPATA', 78),
(783, 'OCONGATE', 78),
(784, 'OROPESA', 78),
(785, 'QUIQUIJANA', 78),
(786, 'URUBAMBA', 79),
(787, 'CHINCHERO', 79),
(788, 'HUAYLLABAMBA', 79),
(789, 'MACHUPICCHU', 79),
(790, 'MARAS', 79),
(791, 'OLLANTAYTAMBO', 79),
(792, 'YUCAY', 79),
(793, 'HUANCAVELICA', 80),
(794, 'ACOBAMBILLA', 80),
(795, 'ACORIA', 80),
(796, 'CONAYCA', 80),
(797, 'CUENCA', 80),
(798, 'HUACHOCOLPA', 80),
(799, 'HUAYLLAHUARA', 80),
(800, 'IZCUCHACA', 80),
(801, 'LARIA', 80),
(802, 'MANTA', 80),
(803, 'MARISCAL CACERES', 80),
(804, 'MOYA', 80),
(805, 'NUEVO OCCORO', 80),
(806, 'PALCA', 80),
(807, 'PILCHACA', 80),
(808, 'VILCA', 80),
(809, 'YAULI', 80),
(810, 'ASCENSION', 80),
(811, 'HUANDO', 80),
(812, 'ACOBAMBA', 81),
(813, 'ANDABAMBA', 81),
(814, 'ANTA', 81),
(815, 'CAJA', 81),
(816, 'MARCAS', 81),
(817, 'PAUCARA', 81),
(818, 'POMACOCHA', 81),
(819, 'ROSARIO', 81),
(820, 'LIRCAY', 82),
(821, 'ANCHONGA', 82),
(822, 'CALLANMARCA', 82),
(823, 'CCOCHACCASA', 82),
(824, 'CHINCHO', 82),
(825, 'CONGALLA', 82),
(826, 'HUANCA-HUANCA', 82),
(827, 'HUAYLLAY GRANDE', 82),
(828, 'JULCAMARCA', 82),
(829, 'SAN ANTONIO DE ANTAPARCO', 82),
(830, 'SANTO TOMAS DE PATA', 82),
(831, 'SECCLLA', 82),
(832, 'CASTROVIRREYNA', 83),
(833, 'ARMA', 83),
(834, 'AURAHUA', 83),
(835, 'CAPILLAS', 83),
(836, 'CHUPAMARCA', 83),
(837, 'COCAS', 83),
(838, 'HUACHOS', 83),
(839, 'HUAMATAMBO', 83),
(840, 'MOLLEPAMPA', 83),
(841, 'SAN JUAN', 83),
(842, 'SANTA ANA', 83),
(843, 'TANTARA', 83),
(844, 'TICRAPO', 83),
(845, 'CHURCAMPA', 84),
(846, 'ANCO', 84),
(847, 'CHINCHIHUASI', 84),
(848, 'EL CARMEN', 84),
(849, 'LA MERCED', 84),
(850, 'LOCROJA', 84),
(851, 'PAUCARBAMBA', 84),
(852, 'SAN MIGUEL DE MAYOCC', 84),
(853, 'SAN PEDRO DE CORIS', 84),
(854, 'PACHAMARCA', 84),
(855, 'HUAYTARA', 85),
(856, 'AYAVI', 85),
(857, 'CORDOVA', 85),
(858, 'HUAYACUNDO ARMA', 85),
(859, 'LARAMARCA', 85),
(860, 'OCOYO', 85),
(861, 'PILPICHACA', 85),
(862, 'QUERCO', 85),
(863, 'QUITO-ARMA', 85),
(864, 'SAN ANTONIO DE CUSICANCHA', 85),
(865, 'SAN FRANCISCO DE SANGAYAICO', 85),
(866, 'SAN ISIDRO', 85),
(867, 'SANTIAGO DE CHOCORVOS', 85),
(868, 'SANTIAGO DE QUIRAHUARA', 85),
(869, 'SANTO DOMINGO DE CAPILLAS', 85),
(870, 'TAMBO', 85),
(871, 'PAMPAS', 86),
(872, 'ACOSTAMBO', 86),
(873, 'ACRAQUIA', 86),
(874, 'AHUAYCHA', 86),
(875, 'COLCABAMBA', 86),
(876, 'DANIEL HERNANDEZ', 86),
(877, 'HUACHOCOLPA', 86),
(878, 'HUARIBAMBA', 86),
(879, '&Ntilde;AHUIMPUQUIO', 86),
(880, 'PAZOS', 86),
(881, 'QUISHUAR', 86),
(882, 'SALCABAMBA', 86),
(883, 'SALCAHUASI', 86),
(884, 'SAN MARCOS DE ROCCHAC', 86),
(885, 'SURCUBAMBA', 86),
(886, 'TINTAY PUNCU', 86),
(887, 'HUANUCO', 87),
(888, 'AMARILIS', 87),
(889, 'CHINCHAO', 87),
(890, 'CHURUBAMBA', 87),
(891, 'MARGOS', 87),
(892, 'QUISQUI', 87),
(893, 'SAN FRANCISCO DE CAYRAN', 87),
(894, 'SAN PEDRO DE CHAULAN', 87),
(895, 'SANTA MARIA DEL VALLE', 87),
(896, 'YARUMAYO', 87),
(897, 'PILLCO MARCA', 87),
(898, 'AMBO', 88),
(899, 'CAYNA', 88),
(900, 'COLPAS', 88),
(901, 'CONCHAMARCA', 88),
(902, 'HUACAR', 88),
(903, 'SAN FRANCISCO', 88),
(904, 'SAN RAFAEL', 88),
(905, 'TOMAY KICHWA', 88),
(906, 'LA UNION', 89),
(907, 'CHUQUIS', 89),
(908, 'MARIAS', 89),
(909, 'PACHAS', 89),
(910, 'QUIVILLA', 89),
(911, 'RIPAN', 89),
(912, 'SHUNQUI', 89),
(913, 'SILLAPATA', 89),
(914, 'YANAS', 89),
(915, 'HUACAYBAMBA', 90),
(916, 'CANCHABAMBA', 90),
(917, 'COCHABAMBA', 90),
(918, 'PINRA', 90),
(919, 'LLATA', 91),
(920, 'ARANCAY', 91),
(921, 'CHAVIN DE PARIARCA', 91),
(922, 'JACAS GRANDE', 91),
(923, 'JIRCAN', 91),
(924, 'MIRAFLORES', 91),
(925, 'MONZON', 91),
(926, 'PUNCHAO', 91),
(927, 'PU&Ntilde;OS', 91),
(928, 'SINGA', 91),
(929, 'TANTAMAYO', 91),
(930, 'RUPA-RUPA', 92),
(931, 'DANIEL ALOMIA ROBLES', 92),
(932, 'HERMILIO VALDIZAN', 92),
(933, 'JOSE CRESPO Y CASTILLO', 92),
(934, 'LUYANDO', 92),
(935, 'MARIANO DAMASO BERAUN', 92),
(936, 'HUACRACHUCO', 93),
(937, 'CHOLON', 93),
(938, 'SAN BUENAVENTURA', 93),
(939, 'PANAO', 94),
(940, 'CHAGLLA', 94),
(941, 'MOLINO', 94),
(942, 'UMARI', 94),
(943, 'PUERTO INCA', 95),
(944, 'CODO DEL POZUZO', 95),
(945, 'HONORIA', 95),
(946, 'TOURNAVISTA', 95),
(947, 'YUYAPICHIS', 95),
(948, 'JESUS', 96),
(949, 'BA&Ntilde;OS', 96),
(950, 'JIVIA', 96),
(951, 'QUEROPALCA', 96),
(952, 'RONDOS', 96),
(953, 'SAN FRANCISCO DE ASIS', 96),
(954, 'SAN MIGUEL DE CAURI', 96),
(955, 'CHAVINILLO', 97),
(956, 'CAHUAC', 97),
(957, 'CHACABAMBA', 97),
(958, 'APARICIO POMARES', 97),
(959, 'JACAS CHICO', 97),
(960, 'OBAS', 97),
(961, 'PAMPAMARCA', 97),
(962, 'CHORAS', 97),
(963, 'ICA', 98),
(964, 'LA TINGUI&Ntilde;A', 98),
(965, 'LOS AQUIJES', 98),
(966, 'OCUCAJE', 98),
(967, 'PACHACUTEC', 98),
(968, 'PARCONA', 98),
(969, 'PUEBLO NUEVO', 98),
(970, 'SALAS', 98),
(971, 'SAN JOSE DE LOS MOLINOS', 98),
(972, 'SAN JUAN BAUTISTA', 98),
(973, 'SANTIAGO', 98),
(974, 'SUBTANJALLA', 98),
(975, 'TATE', 98),
(976, 'YAUCA DEL ROSARIO', 98),
(977, 'CHINCHA ALTA', 99),
(978, 'ALTO LARAN', 99),
(979, 'CHAVIN', 99),
(980, 'CHINCHA BAJA', 99),
(981, 'EL CARMEN', 99),
(982, 'GROCIO PRADO', 99),
(983, 'PUEBLO NUEVO', 99),
(984, 'SAN JUAN DE YANAC', 99),
(985, 'SAN PEDRO DE HUACARPANA', 99),
(986, 'SUNAMPE', 99),
(987, 'TAMBO DE MORA', 99),
(988, 'NAZCA', 100),
(989, 'CHANGUILLO', 100),
(990, 'EL INGENIO', 100),
(991, 'MARCONA', 100),
(992, 'VISTA ALEGRE', 100),
(993, 'PALPA', 101),
(994, 'LLIPATA', 101),
(995, 'RIO GRANDE', 101),
(996, 'SANTA CRUZ', 101),
(997, 'TIBILLO', 101),
(998, 'PISCO', 102),
(999, 'HUANCANO', 102),
(1000, 'HUMAY', 102),
(1001, 'INDEPENDENCIA', 102),
(1002, 'PARACAS', 102),
(1003, 'SAN ANDRES', 102),
(1004, 'SAN CLEMENTE', 102),
(1005, 'TUPAC AMARU INCA', 102),
(1006, 'HUANCAYO', 103),
(1007, 'CARHUACALLANGA', 103),
(1008, 'CHACAPAMPA', 103),
(1009, 'CHICCHE', 103),
(1010, 'CHILCA', 103),
(1011, 'CHONGOS ALTO', 103),
(1012, 'CHUPURO', 103),
(1013, 'COLCA', 103),
(1014, 'CULLHUAS', 103),
(1015, 'EL TAMBO', 103),
(1016, 'HUACRAPUQUIO', 103),
(1017, 'HUALHUAS', 103),
(1018, 'HUANCAN', 103),
(1019, 'HUASICANCHA', 103),
(1020, 'HUAYUCACHI', 103),
(1021, 'INGENIO', 103),
(1022, 'PARIAHUANCA', 103),
(1023, 'PILCOMAYO', 103),
(1024, 'PUCARA', 103),
(1025, 'QUICHUAY', 103),
(1026, 'QUILCAS', 103),
(1027, 'SAN AGUSTIN', 103),
(1028, 'SAN JERONIMO DE TUNAN', 103),
(1029, 'SA&Ntilde;O', 103),
(1030, 'SAPALLANGA', 103),
(1031, 'SICAYA', 103),
(1032, 'SANTO DOMINGO DE ACOBAMBA', 103),
(1033, 'VIQUES', 103),
(1034, 'CONCEPCION', 104),
(1035, 'ACO', 104),
(1036, 'ANDAMARCA', 104),
(1037, 'CHAMBARA', 104),
(1038, 'COCHAS', 104),
(1039, 'COMAS', 104),
(1040, 'HEROINAS TOLEDO', 104),
(1041, 'MANZANARES', 104),
(1042, 'MARISCAL CASTILLA', 104),
(1043, 'MATAHUASI', 104),
(1044, 'MITO', 104),
(1045, 'NUEVE DE JULIO', 104),
(1046, 'ORCOTUNA', 104),
(1047, 'SAN JOSE DE QUERO', 104),
(1048, 'SANTA ROSA DE OCOPA', 104),
(1049, 'CHANCHAMAYO', 105),
(1050, 'PERENE', 105),
(1051, 'PICHANAQUI', 105),
(1052, 'SAN LUIS DE SHUARO', 105),
(1053, 'SAN RAMON', 105),
(1054, 'VITOC', 105),
(1055, 'JAUJA', 106),
(1056, 'ACOLLA', 106),
(1057, 'APATA', 106),
(1058, 'ATAURA', 106),
(1059, 'CANCHAYLLO', 106),
(1060, 'CURICACA', 106),
(1061, 'EL MANTARO', 106),
(1062, 'HUAMALI', 106),
(1063, 'HUARIPAMPA', 106),
(1064, 'HUERTAS', 106),
(1065, 'JANJAILLO', 106),
(1066, 'JULCAN', 106),
(1067, 'LEONOR ORDO&Ntilde;EZ', 106),
(1068, 'LLOCLLAPAMPA', 106),
(1069, 'MARCO', 106),
(1070, 'MASMA', 106),
(1071, 'MASMA CHICCHE', 106),
(1072, 'MOLINOS', 106),
(1073, 'MONOBAMBA', 106),
(1074, 'MUQUI', 106),
(1075, 'MUQUIYAUYO', 106),
(1076, 'PACA', 106),
(1077, 'PACCHA', 106),
(1078, 'PANCAN', 106),
(1079, 'PARCO', 106),
(1080, 'POMACANCHA', 106),
(1081, 'RICRAN', 106),
(1082, 'SAN LORENZO', 106),
(1083, 'SAN PEDRO DE CHUNAN', 106),
(1084, 'SAUSA', 106),
(1085, 'SINCOS', 106),
(1086, 'TUNAN MARCA', 106),
(1087, 'YAULI', 106),
(1088, 'YAUYOS', 106),
(1089, 'JUNIN', 107),
(1090, 'CARHUAMAYO', 107),
(1091, 'ONDORES', 107),
(1092, 'ULCUMAYO', 107),
(1093, 'SATIPO', 108),
(1094, 'COVIRIALI', 108),
(1095, 'LLAYLLA', 108),
(1096, 'MAZAMARI', 108),
(1097, 'PAMPA HERMOSA', 108),
(1098, 'PANGOA', 108),
(1099, 'RIO NEGRO', 108),
(1100, 'RIO TAMBO', 108),
(1101, 'TARMA', 109),
(1102, 'ACOBAMBA', 109),
(1103, 'HUARICOLCA', 109),
(1104, 'HUASAHUASI', 109),
(1105, 'LA UNION', 109),
(1106, 'PALCA', 109),
(1107, 'PALCAMAYO', 109),
(1108, 'SAN PEDRO DE CAJAS', 109),
(1109, 'TAPO', 109),
(1110, 'LA OROYA', 110),
(1111, 'CHACAPALPA', 110),
(1112, 'HUAY-HUAY', 110),
(1113, 'MARCAPOMACOCHA', 110),
(1114, 'MOROCOCHA', 110),
(1115, 'PACCHA', 110),
(1116, 'SANTA BARBARA DE CARHUACAYAN', 110),
(1117, 'SANTA ROSA DE SACCO', 110),
(1118, 'SUITUCANCHA', 110),
(1119, 'YAULI', 110),
(1120, 'CHUPACA', 111),
(1121, 'AHUAC', 111),
(1122, 'CHONGOS BAJO', 111),
(1123, 'HUACHAC', 111),
(1124, 'HUAMANCACA CHICO', 111),
(1125, 'SAN JUAN DE ISCOS', 111),
(1126, 'SAN JUAN DE JARPA', 111),
(1127, 'TRES DE DICIEMBRE', 111),
(1128, 'YANACANCHA', 111),
(1129, 'TRUJILLO', 112),
(1130, 'EL PORVENIR', 112),
(1131, 'FLORENCIA DE MORA', 112),
(1132, 'HUANCHACO', 112),
(1133, 'LA ESPERANZA', 112),
(1134, 'LAREDO', 112),
(1135, 'MOCHE', 112),
(1136, 'POROTO', 112),
(1137, 'SALAVERRY', 112),
(1138, 'SIMBAL', 112),
(1139, 'VICTOR LARCO HERRERA', 112),
(1140, 'ASCOPE', 113),
(1141, 'CHICAMA', 113),
(1142, 'CHOCOPE', 113),
(1143, 'MAGDALENA DE CAO', 113),
(1144, 'PAIJAN', 113),
(1145, 'RAZURI', 113),
(1146, 'SANTIAGO DE CAO', 113),
(1147, 'CASA GRANDE', 113),
(1148, 'BOLIVAR', 114),
(1149, 'BAMBAMARCA', 114),
(1150, 'CONDORMARCA', 114),
(1151, 'LONGOTEA', 114),
(1152, 'UCHUMARCA', 114),
(1153, 'UCUNCHA', 114),
(1154, 'CHEPEN', 115),
(1155, 'PACANGA', 115),
(1156, 'PUEBLO NUEVO', 115),
(1157, 'JULCAN', 116),
(1158, 'CALAMARCA', 116),
(1159, 'CARABAMBA', 116),
(1160, 'HUASO', 116),
(1161, 'OTUZCO', 117),
(1162, 'AGALLPAMPA', 117),
(1163, 'CHARAT', 117),
(1164, 'HUARANCHAL', 117),
(1165, 'LA CUESTA', 117),
(1166, 'MACHE', 117),
(1167, 'PARANDAY', 117),
(1168, 'SALPO', 117),
(1169, 'SINSICAP', 117),
(1170, 'USQUIL', 117),
(1171, 'SAN PEDRO DE LLOC', 118),
(1172, 'GUADALUPE', 118),
(1173, 'JEQUETEPEQUE', 118),
(1174, 'PACASMAYO', 118),
(1175, 'SAN JOSE', 118),
(1176, 'TAYABAMBA', 119),
(1177, 'BULDIBUYO', 119),
(1178, 'CHILLIA', 119),
(1179, 'HUANCASPATA', 119),
(1180, 'HUAYLILLAS', 119),
(1181, 'HUAYO', 119),
(1182, 'ONGON', 119),
(1183, 'PARCOY', 119),
(1184, 'PATAZ', 119),
(1185, 'PIAS', 119),
(1186, 'SANTIAGO DE CHALLAS', 119),
(1187, 'TAURIJA', 119),
(1188, 'URPAY', 119),
(1189, 'HUAMACHUCO', 120),
(1190, 'CHUGAY', 120),
(1191, 'COCHORCO', 120),
(1192, 'CURGOS', 120),
(1193, 'MARCABAL', 120),
(1194, 'SANAGORAN', 120),
(1195, 'SARIN', 120),
(1196, 'SARTIMBAMBA', 120),
(1197, 'SANTIAGO DE CHUCO', 121),
(1198, 'ANGASMARCA', 121),
(1199, 'CACHICADAN', 121),
(1200, 'MOLLEBAMBA', 121),
(1201, 'MOLLEPATA', 121),
(1202, 'QUIRUVILCA', 121),
(1203, 'SANTA CRUZ DE CHUCA', 121),
(1204, 'SITABAMBA', 121),
(1205, 'GRAN CHIMU', 122),
(1206, 'CASCAS', 122),
(1207, 'LUCMA', 122),
(1208, 'MARMOT', 122),
(1209, 'SAYAPULLO', 122),
(1210, 'VIRU', 123),
(1211, 'CHAO', 123),
(1212, 'GUADALUPITO', 123),
(1213, 'CHICLAYO', 124),
(1214, 'CHONGOYAPE', 124),
(1215, 'ETEN', 124),
(1216, 'ETEN PUERTO', 124),
(1217, 'JOSE LEONARDO ORTIZ', 124),
(1218, 'LA VICTORIA', 124),
(1219, 'LAGUNAS', 124),
(1220, 'MONSEFU', 124),
(1221, 'NUEVA ARICA', 124),
(1222, 'OYOTUN', 124),
(1223, 'PICSI', 124),
(1224, 'PIMENTEL', 124),
(1225, 'REQUE', 124),
(1226, 'SANTA ROSA', 124),
(1227, 'SA&Ntilde;A', 124),
(1228, 'CAYALTI', 124),
(1229, 'PATAPO', 124),
(1230, 'POMALCA', 124),
(1231, 'PUCALA', 124),
(1232, 'TUMAN', 124),
(1233, 'FERRE&Ntilde;AFE', 125),
(1234, 'CA&Ntilde;ARIS', 125),
(1235, 'INCAHUASI', 125),
(1236, 'MANUEL ANTONIO MESONES MURO', 125),
(1237, 'PITIPO', 125),
(1238, 'PUEBLO NUEVO', 125),
(1239, 'LAMBAYEQUE', 126),
(1240, 'CHOCHOPE', 126),
(1241, 'ILLIMO', 126),
(1242, 'JAYANCA', 126),
(1243, 'MOCHUMI', 126),
(1244, 'MORROPE', 126),
(1245, 'MOTUPE', 126),
(1246, 'OLMOS', 126),
(1247, 'PACORA', 126),
(1248, 'SALAS', 126),
(1249, 'SAN JOSE', 126),
(1250, 'TUCUME', 126),
(1251, 'LIMA', 127),
(1252, 'ANCON', 127),
(1253, 'ATE', 127),
(1254, 'BARRANCO', 127),
(1255, 'BRE&Ntilde;A', 127),
(1256, 'CARABAYLLO', 127),
(1257, 'CHACLACAYO', 127),
(1258, 'CHORRILLOS', 127),
(1259, 'CIENEGUILLA', 127),
(1260, 'COMAS', 127),
(1261, 'EL AGUSTINO', 127),
(1262, 'INDEPENDENCIA', 127),
(1263, 'JESUS MARIA', 127),
(1264, 'LA MOLINA', 127),
(1265, 'LA VICTORIA', 127),
(1266, 'LINCE', 127),
(1267, 'LOS OLIVOS', 127),
(1268, 'LURIGANCHO', 127),
(1269, 'LURIN', 127),
(1270, 'MAGDALENA DEL MAR', 127),
(1271, 'MAGDALENA VIEJA', 127),
(1272, 'MIRAFLORES', 127),
(1273, 'PACHACAMAC', 127),
(1274, 'PUCUSANA', 127),
(1275, 'PUENTE PIEDRA', 127),
(1276, 'PUNTA HERMOSA', 127),
(1277, 'PUNTA NEGRA', 127),
(1278, 'RIMAC', 127),
(1279, 'SAN BARTOLO', 127),
(1280, 'SAN BORJA', 127),
(1281, 'SAN ISIDRO', 127),
(1282, 'SAN JUAN DE LURIGANCHO', 127),
(1283, 'SAN JUAN DE MIRAFLORES', 127),
(1284, 'SAN LUIS', 127),
(1285, 'SAN MARTIN DE PORRES', 127),
(1286, 'SAN MIGUEL', 127),
(1287, 'SANTA ANITA', 127),
(1288, 'SANTA MARIA DEL MAR', 127),
(1289, 'SANTA ROSA', 127),
(1290, 'SANTIAGO DE SURCO', 127),
(1291, 'SURQUILLO', 127),
(1292, 'VILLA EL SALVADOR', 127),
(1293, 'VILLA MARIA DEL TRIUNFO', 127),
(1294, 'BARRANCA', 128),
(1295, 'PARAMONGA', 128),
(1296, 'PATIVILCA', 128),
(1297, 'SUPE', 128),
(1298, 'SUPE PUERTO', 128),
(1299, 'CAJATAMBO', 129),
(1300, 'COPA', 129),
(1301, 'GORGOR', 129),
(1302, 'HUANCAPON', 129),
(1303, 'MANAS', 129),
(1304, 'CANTA', 130),
(1305, 'ARAHUAY', 130),
(1306, 'HUAMANTANGA', 130),
(1307, 'HUAROS', 130),
(1308, 'LACHAQUI', 130),
(1309, 'SAN BUENAVENTURA', 130),
(1310, 'SANTA ROSA DE QUIVES', 130),
(1311, 'SAN VICENTE DE CA&Ntilde;ETE', 131),
(1312, 'ASIA', 131),
(1313, 'CALANGO', 131),
(1314, 'CERRO AZUL', 131),
(1315, 'CHILCA', 131),
(1316, 'COAYLLO', 131),
(1317, 'IMPERIAL', 131),
(1318, 'LUNAHUANA', 131),
(1319, 'MALA', 131),
(1320, 'NUEVO IMPERIAL', 131),
(1321, 'PACARAN', 131),
(1322, 'QUILMANA', 131),
(1323, 'SAN ANTONIO', 131),
(1324, 'SAN LUIS', 131),
(1325, 'SANTA CRUZ DE FLORES', 131),
(1326, 'ZU&Ntilde;IGA', 131),
(1327, 'HUARAL', 132),
(1328, 'ATAVILLOS ALTO', 132),
(1329, 'ATAVILLOS BAJO', 132),
(1330, 'AUCALLAMA', 132),
(1331, 'CHANCAY', 132),
(1332, 'IHUARI', 132),
(1333, 'LAMPIAN', 132),
(1334, 'PACARAOS', 132),
(1335, 'SAN MIGUEL DE ACOS', 132),
(1336, 'SANTA CRUZ DE ANDAMARCA', 132),
(1337, 'SUMBILCA', 132),
(1338, 'VEINTISIETE DE NOVIEMBRE', 132),
(1339, 'MATUCANA', 133),
(1340, 'ANTIOQUIA', 133),
(1341, 'CALLAHUANCA', 133),
(1342, 'CARAMPOMA', 133),
(1343, 'CHICLA', 133),
(1344, 'CUENCA', 133),
(1345, 'HUACHUPAMPA', 133),
(1346, 'HUANZA', 133),
(1347, 'HUAROCHIRI', 133),
(1348, 'LAHUAYTAMBO', 133),
(1349, 'LANGA', 133),
(1350, 'LARAOS', 133),
(1351, 'MARIATANA', 133),
(1352, 'RICARDO PALMA', 133),
(1353, 'SAN ANDRES DE TUPICOCHA', 133),
(1354, 'SAN ANTONIO', 133),
(1355, 'SAN BARTOLOME', 133),
(1356, 'SAN DAMIAN', 133),
(1357, 'SAN JUAN DE IRIS', 133),
(1358, 'SAN JUAN DE TANTARANCHE', 133),
(1359, 'SAN LORENZO DE QUINTI', 133),
(1360, 'SAN MATEO', 133),
(1361, 'SAN MATEO DE OTAO', 133),
(1362, 'SAN PEDRO DE CASTA', 133),
(1363, 'SAN PEDRO DE HUANCAYRE', 133),
(1364, 'SANGALLAYA', 133),
(1365, 'SANTA CRUZ DE COCACHACRA', 133),
(1366, 'SANTA EULALIA', 133),
(1367, 'SANTIAGO DE ANCHUCAYA', 133),
(1368, 'SANTIAGO DE TUNA', 133),
(1369, 'SANTO DOMINGO DE LOS OLLEROS', 133),
(1370, 'SURCO', 133),
(1371, 'HUACHO', 134),
(1372, 'AMBAR', 134),
(1373, 'CALETA DE CARQUIN', 134),
(1374, 'CHECRAS', 134),
(1375, 'HUALMAY', 134),
(1376, 'HUAURA', 134),
(1377, 'LEONCIO PRADO', 134),
(1378, 'PACCHO', 134),
(1379, 'SANTA LEONOR', 134),
(1380, 'SANTA MARIA', 134),
(1381, 'SAYAN', 134),
(1382, 'VEGUETA', 134),
(1383, 'OYON', 135),
(1384, 'ANDAJES', 135),
(1385, 'CAUJUL', 135),
(1386, 'COCHAMARCA', 135),
(1387, 'NAVAN', 135),
(1388, 'PACHANGARA', 135),
(1389, 'YAUYOS', 136),
(1390, 'ALIS', 136),
(1391, 'AYAUCA', 136),
(1392, 'AYAVIRI', 136),
(1393, 'AZANGARO', 136),
(1394, 'CACRA', 136),
(1395, 'CARANIA', 136),
(1396, 'CATAHUASI', 136),
(1397, 'CHOCOS', 136),
(1398, 'COCHAS', 136),
(1399, 'COLONIA', 136),
(1400, 'HONGOS', 136),
(1401, 'HUAMPARA', 136),
(1402, 'HUANCAYA', 136),
(1403, 'HUANGASCAR', 136),
(1404, 'HUANTAN', 136),
(1405, 'HUA&Ntilde;EC', 136),
(1406, 'LARAOS', 136),
(1407, 'LINCHA', 136),
(1408, 'MADEAN', 136),
(1409, 'MIRAFLORES', 136),
(1410, 'OMAS', 136),
(1411, 'PUTINZA', 136),
(1412, 'QUINCHES', 136),
(1413, 'QUINOCAY', 136),
(1414, 'SAN JOAQUIN', 136),
(1415, 'SAN PEDRO DE PILAS', 136),
(1416, 'TANTA', 136),
(1417, 'TAURIPAMPA', 136),
(1418, 'TOMAS', 136),
(1419, 'TUPE', 136),
(1420, 'VI&Ntilde;AC', 136),
(1421, 'VITIS', 136),
(1422, 'IQUITOS', 137),
(1423, 'ALTO NANAY', 137),
(1424, 'FERNANDO LORES', 137),
(1425, 'INDIANA', 137),
(1426, 'LAS AMAZONAS', 137),
(1427, 'MAZAN', 137),
(1428, 'NAPO', 137),
(1429, 'PUNCHANA', 137),
(1430, 'PUTUMAYO', 137),
(1431, 'TORRES CAUSANA', 137),
(1432, 'BELEN', 137),
(1433, 'SAN JUAN BAUTISTA', 137),
(1434, 'YURIMAGUAS', 138),
(1435, 'BALSAPUERTO', 138),
(1436, 'BARRANCA', 138),
(1437, 'CAHUAPANAS', 138),
(1438, 'JEBEROS', 138),
(1439, 'LAGUNAS', 138),
(1440, 'MANSERICHE', 138),
(1441, 'MORONA', 138),
(1442, 'PASTAZA', 138),
(1443, 'SANTA CRUZ', 138),
(1444, 'TENIENTE CESAR LOPEZ ROJAS', 138),
(1445, 'NAUTA', 139),
(1446, 'PARINARI', 139),
(1447, 'TIGRE', 139),
(1448, 'TROMPETEROS', 139),
(1449, 'URARINAS', 139),
(1450, 'RAMON CASTILLA', 140),
(1451, 'PEBAS', 140),
(1452, 'YAVARI', 140),
(1453, 'SAN PABLO', 140),
(1454, 'REQUENA', 141),
(1455, 'ALTO TAPICHE', 141),
(1456, 'CAPELO', 141),
(1457, 'EMILIO SAN MARTIN', 141),
(1458, 'MAQUIA', 141),
(1459, 'PUINAHUA', 141),
(1460, 'SAQUENA', 141),
(1461, 'SOPLIN', 141),
(1462, 'TAPICHE', 141),
(1463, 'JENARO HERRERA', 141),
(1464, 'YAQUERANA', 141),
(1465, 'CONTAMANA', 142),
(1466, 'INAHUAYA', 142),
(1467, 'PADRE MARQUEZ', 142),
(1468, 'PAMPA HERMOSA', 142),
(1469, 'SARAYACU', 142),
(1470, 'VARGAS GUERRA', 142),
(1471, 'TAMBOPATA', 143),
(1472, 'INAMBARI', 143),
(1473, 'LAS PIEDRAS', 143),
(1474, 'LABERINTO', 143),
(1475, 'MANU', 144),
(1476, 'FITZCARRALD', 144),
(1477, 'MADRE DE DIOS', 144),
(1478, 'HUEPETUHE', 144),
(1479, 'I&Ntilde;APARI', 145),
(1480, 'IBERIA', 145),
(1481, 'TAHUAMANU', 145),
(1482, 'MOQUEGUA', 146),
(1483, 'CARUMAS', 146),
(1484, 'CUCHUMBAYA', 146),
(1485, 'SAMEGUA', 146),
(1486, 'SAN CRISTOBAL', 146),
(1487, 'TORATA', 146),
(1488, 'OMATE', 147),
(1489, 'CHOJATA', 147),
(1490, 'COALAQUE', 147),
(1491, 'ICHU&Ntilde;A', 147),
(1492, 'LA CAPILLA', 147),
(1493, 'LLOQUE', 147),
(1494, 'MATALAQUE', 147),
(1495, 'PUQUINA', 147),
(1496, 'QUINISTAQUILLAS', 147),
(1497, 'UBINAS', 147),
(1498, 'YUNGA', 147),
(1499, 'ILO', 148),
(1500, 'EL ALGARROBAL', 148),
(1501, 'PACOCHA', 148),
(1502, 'CHAUPIMARCA', 149),
(1503, 'HUACHON', 149),
(1504, 'HUARIACA', 149),
(1505, 'HUAYLLAY', 149),
(1506, 'NINACACA', 149),
(1507, 'PALLANCHACRA', 149),
(1508, 'PAUCARTAMBO', 149),
(1509, 'SAN FCO.DE ASIS DE YARUSYACAN', 149),
(1510, 'SIMON BOLIVAR', 149),
(1511, 'TICLACAYAN', 149),
(1512, 'TINYAHUARCO', 149),
(1513, 'VICCO', 149),
(1514, 'YANACANCHA', 149),
(1515, 'YANAHUANCA', 150),
(1516, 'CHACAYAN', 150),
(1517, 'GOYLLARISQUIZGA', 150),
(1518, 'PAUCAR', 150),
(1519, 'SAN PEDRO DE PILLAO', 150),
(1520, 'SANTA ANA DE TUSI', 150),
(1521, 'TAPUC', 150),
(1522, 'VILCABAMBA', 150),
(1523, 'OXAPAMPA', 151),
(1524, 'CHONTABAMBA', 151),
(1525, 'HUANCABAMBA', 151),
(1526, 'PALCAZU', 151),
(1527, 'POZUZO', 151),
(1528, 'PUERTO BERMUDEZ', 151),
(1529, 'VILLA RICA', 151),
(1530, 'PIURA', 152),
(1531, 'CASTILLA', 152),
(1532, 'CATACAOS', 152),
(1533, 'CURA MORI', 152),
(1534, 'EL TALLAN', 152),
(1535, 'LA ARENA', 152),
(1536, 'LA UNION', 152),
(1537, 'LAS LOMAS', 152),
(1538, 'TAMBO GRANDE', 152),
(1539, 'AYABACA', 153),
(1540, 'FRIAS', 153),
(1541, 'JILILI', 153),
(1542, 'LAGUNAS', 153),
(1543, 'MONTERO', 153),
(1544, 'PACAIPAMPA', 153),
(1545, 'PAIMAS', 153),
(1546, 'SAPILLICA', 153),
(1547, 'SICCHEZ', 153),
(1548, 'SUYO', 153),
(1549, 'HUANCABAMBA', 154),
(1550, 'CANCHAQUE', 154),
(1551, 'EL CARMEN DE LA FRONTERA', 154),
(1552, 'HUARMACA', 154),
(1553, 'LALAQUIZ', 154),
(1554, 'SAN MIGUEL DE EL FAIQUE', 154),
(1555, 'SONDOR', 154),
(1556, 'SONDORILLO', 154),
(1557, 'CHULUCANAS', 155),
(1558, 'BUENOS AIRES', 155),
(1559, 'CHALACO', 155),
(1560, 'LA MATANZA', 155),
(1561, 'MORROPON', 155),
(1562, 'SALITRAL', 155),
(1563, 'SAN JUAN DE BIGOTE', 155),
(1564, 'SANTA CATALINA DE MOSSA', 155),
(1565, 'SANTO DOMINGO', 155),
(1566, 'YAMANGO', 155),
(1567, 'PAITA', 156),
(1568, 'AMOTAPE', 156),
(1569, 'ARENAL', 156),
(1570, 'COLAN', 156),
(1571, 'LA HUACA', 156),
(1572, 'TAMARINDO', 156),
(1573, 'VICHAYAL', 156),
(1574, 'SULLANA', 157),
(1575, 'BELLAVISTA', 157),
(1576, 'IGNACIO ESCUDERO', 157),
(1577, 'LANCONES', 157),
(1578, 'MARCAVELICA', 157),
(1579, 'MIGUEL CHECA', 157),
(1580, 'QUERECOTILLO', 157),
(1581, 'SALITRAL', 157),
(1582, 'PARI&Ntilde;AS', 158),
(1583, 'EL ALTO', 158),
(1584, 'LA BREA', 158),
(1585, 'LOBITOS', 158),
(1586, 'LOS ORGANOS', 158),
(1587, 'MANCORA', 158),
(1588, 'SECHURA', 159),
(1589, 'BELLAVISTA DE LA UNION', 159),
(1590, 'BERNAL', 159),
(1591, 'CRISTO NOS VALGA', 159),
(1592, 'VICE', 159),
(1593, 'RINCONADA LLICUAR', 159),
(1594, 'PUNO', 160),
(1595, 'ACORA', 160),
(1596, 'AMANTANI', 160),
(1597, 'ATUNCOLLA', 160),
(1598, 'CAPACHICA', 160),
(1599, 'CHUCUITO', 160),
(1600, 'COATA', 160),
(1601, 'HUATA', 160),
(1602, 'MA&Ntilde;AZO', 160),
(1603, 'PAUCARCOLLA', 160),
(1604, 'PICHACANI', 160),
(1605, 'PLATERIA', 160),
(1606, 'SAN ANTONIO', 160),
(1607, 'TIQUILLACA', 160),
(1608, 'VILQUE', 160),
(1609, 'AZANGARO', 161),
(1610, 'ACHAYA', 161),
(1611, 'ARAPA', 161),
(1612, 'ASILLO', 161),
(1613, 'CAMINACA', 161),
(1614, 'CHUPA', 161),
(1615, 'JOSE DOMINGO CHOQUEHUANCA', 161),
(1616, 'MU&Ntilde;ANI', 161),
(1617, 'POTONI', 161),
(1618, 'SAMAN', 161),
(1619, 'SAN ANTON', 161),
(1620, 'SAN JOSE', 161),
(1621, 'SAN JUAN DE SALINAS', 161),
(1622, 'SANTIAGO DE PUPUJA', 161),
(1623, 'TIRAPATA', 161),
(1624, 'MACUSANI', 162),
(1625, 'AJOYANI', 162),
(1626, 'AYAPATA', 162),
(1627, 'COASA', 162),
(1628, 'CORANI', 162),
(1629, 'CRUCERO', 162),
(1630, 'ITUATA', 162),
(1631, 'OLLACHEA', 162),
(1632, 'SAN GABAN', 162),
(1633, 'USICAYOS', 162),
(1634, 'JULI', 163),
(1635, 'DESAGUADERO', 163),
(1636, 'HUACULLANI', 163),
(1637, 'KELLUYO', 163),
(1638, 'PISACOMA', 163),
(1639, 'POMATA', 163),
(1640, 'ZEPITA', 163),
(1641, 'ILAVE', 164),
(1642, 'CAPAZO', 164),
(1643, 'PILCUYO', 164),
(1644, 'SANTA ROSA', 164),
(1645, 'CONDURIRI', 164),
(1646, 'HUANCANE', 165),
(1647, 'COJATA', 165),
(1648, 'HUATASANI', 165),
(1649, 'INCHUPALLA', 165),
(1650, 'PUSI', 165),
(1651, 'ROSASPATA', 165),
(1652, 'TARACO', 165),
(1653, 'VILQUE CHICO', 165),
(1654, 'LAMPA', 166),
(1655, 'CABANILLA', 166),
(1656, 'CALAPUJA', 166),
(1657, 'NICASIO', 166),
(1658, 'OCUVIRI', 166),
(1659, 'PALCA', 166),
(1660, 'PARATIA', 166),
(1661, 'PUCARA', 166),
(1662, 'SANTA LUCIA', 166),
(1663, 'VILAVILA', 166),
(1664, 'AYAVIRI', 167),
(1665, 'ANTAUTA', 167),
(1666, 'CUPI', 167),
(1667, 'LLALLI', 167),
(1668, 'MACARI', 167),
(1669, 'NU&Ntilde;OA', 167),
(1670, 'ORURILLO', 167),
(1671, 'SANTA ROSA', 167),
(1672, 'UMACHIRI', 167),
(1673, 'MOHO', 168),
(1674, 'CONIMA', 168),
(1675, 'HUAYRAPATA', 168),
(1676, 'TILALI', 168),
(1677, 'PUTINA', 169),
(1678, 'ANANEA', 169),
(1679, 'PEDRO VILCA APAZA', 169),
(1680, 'QUILCAPUNCU', 169),
(1681, 'SINA', 169),
(1682, 'JULIACA', 170),
(1683, 'CABANA', 170),
(1684, 'CABANILLAS', 170),
(1685, 'CARACOTO', 170),
(1686, 'SANDIA', 171),
(1687, 'CUYOCUYO', 171),
(1688, 'LIMBANI', 171),
(1689, 'PATAMBUCO', 171),
(1690, 'PHARA', 171),
(1691, 'QUIACA', 171),
(1692, 'SAN JUAN DEL ORO', 171),
(1693, 'YANAHUAYA', 171),
(1694, 'ALTO INAMBARI', 171),
(1695, 'YUNGUYO', 172),
(1696, 'ANAPIA', 172),
(1697, 'COPANI', 172),
(1698, 'CUTURAPI', 172),
(1699, 'OLLARAYA', 172),
(1700, 'TINICACHI', 172),
(1701, 'UNICACHI', 172),
(1702, 'MOYOBAMBA', 173),
(1703, 'CALZADA', 173),
(1704, 'HABANA', 173),
(1705, 'JEPELACIO', 173),
(1706, 'SORITOR', 173),
(1707, 'YANTALO', 173),
(1708, 'BELLAVISTA', 174),
(1709, 'ALTO BIAVO', 174),
(1710, 'BAJO BIAVO', 174),
(1711, 'HUALLAGA', 174),
(1712, 'SAN PABLO', 174),
(1713, 'SAN RAFAEL', 174),
(1714, 'SAN JOSE DE SISA', 175),
(1715, 'AGUA BLANCA', 175),
(1716, 'SAN MARTIN', 175),
(1717, 'SANTA ROSA', 175),
(1718, 'SHATOJA', 175),
(1719, 'SAPOSOA', 176),
(1720, 'ALTO SAPOSOA', 176),
(1721, 'EL ESLABON', 176),
(1722, 'PISCOYACU', 176),
(1723, 'SACANCHE', 176),
(1724, 'TINGO DE SAPOSOA', 176),
(1725, 'LAMAS', 177),
(1726, 'ALONSO DE ALVARADO', 177),
(1727, 'BARRANQUITA', 177),
(1728, 'CAYNARACHI', 177),
(1729, 'CU&Ntilde;UMBUQUI', 177),
(1730, 'PINTO RECODO', 177),
(1731, 'RUMISAPA', 177),
(1732, 'SAN ROQUE DE CUMBAZA', 177),
(1733, 'SHANAO', 177),
(1734, 'TABALOSOS', 177),
(1735, 'ZAPATERO', 177),
(1736, 'JUANJUI', 178),
(1737, 'CAMPANILLA', 178),
(1738, 'HUICUNGO', 178),
(1739, 'PACHIZA', 178),
(1740, 'PAJARILLO', 178),
(1741, 'PICOTA', 179),
(1742, 'BUENOS AIRES', 179),
(1743, 'CASPISAPA', 179),
(1744, 'PILLUANA', 179),
(1745, 'PUCACACA', 179),
(1746, 'SAN CRISTOBAL', 179),
(1747, 'SAN HILARION', 179),
(1748, 'SHAMBOYACU', 179),
(1749, 'TINGO DE PONASA', 179),
(1750, 'TRES UNIDOS', 179),
(1751, 'RIOJA', 180),
(1752, 'AWAJUN', 180),
(1753, 'ELIAS SOPLIN VARGAS', 180),
(1754, 'NUEVA CAJAMARCA', 180),
(1755, 'PARDO MIGUEL', 180),
(1756, 'POSIC', 180),
(1757, 'SAN FERNANDO', 180),
(1758, 'YORONGOS', 180),
(1759, 'YURACYACU', 180),
(1760, 'TARAPOTO', 181),
(1761, 'ALBERTO LEVEAU', 181),
(1762, 'CACATACHI', 181),
(1763, 'CHAZUTA', 181),
(1764, 'CHIPURANA', 181),
(1765, 'EL PORVENIR', 181),
(1766, 'HUIMBAYOC', 181),
(1767, 'JUAN GUERRA', 181),
(1768, 'LA BANDA DE SHILCAYO', 181),
(1769, 'MORALES', 181),
(1770, 'PAPAPLAYA', 181),
(1771, 'SAN ANTONIO', 181),
(1772, 'SAUCE', 181),
(1773, 'SHAPAJA', 181),
(1774, 'TOCACHE', 182),
(1775, 'NUEVO PROGRESO', 182),
(1776, 'POLVORA', 182),
(1777, 'SHUNTE', 182),
(1778, 'UCHIZA', 182),
(1779, 'TACNA', 183),
(1780, 'ALTO DE LA ALIANZA', 183),
(1781, 'CALANA', 183),
(1782, 'CIUDAD NUEVA', 183),
(1783, 'INCLAN', 183),
(1784, 'PACHIA', 183),
(1785, 'PALCA', 183),
(1786, 'POCOLLAY', 183),
(1787, 'SAMA', 183),
(1788, 'CORONEL GREGORIO ALBARRACIN LANCHIPA', 183),
(1789, 'CANDARAVE', 184),
(1790, 'CAIRANI', 184),
(1791, 'CAMILACA', 184),
(1792, 'CURIBAYA', 184),
(1793, 'HUANUARA', 184),
(1794, 'QUILAHUANI', 184),
(1795, 'LOCUMBA', 185),
(1796, 'ILABAYA', 185),
(1797, 'ITE', 185),
(1798, 'TARATA', 186),
(1799, 'CHUCATAMANI', 186),
(1800, 'ESTIQUE', 186),
(1801, 'ESTIQUE-PAMPA', 186),
(1802, 'SITAJARA', 186),
(1803, 'SUSAPAYA', 186),
(1804, 'TARUCACHI', 186),
(1805, 'TICACO', 186),
(1806, 'TUMBES', 187),
(1807, 'CORRALES', 187),
(1808, 'LA CRUZ', 187),
(1809, 'PAMPAS DE HOSPITAL', 187),
(1810, 'SAN JACINTO', 187),
(1811, 'SAN JUAN DE LA VIRGEN', 187),
(1812, 'ZORRITOS', 188),
(1813, 'CASITAS', 188),
(1814, 'ZARUMILLA', 189),
(1815, 'AGUAS VERDES', 189),
(1816, 'MATAPALO', 189),
(1817, 'PAPAYAL', 189),
(1818, 'CALLERIA', 190),
(1819, 'CAMPOVERDE', 190),
(1820, 'IPARIA', 190),
(1821, 'MASISEA', 190),
(1822, 'YARINACOCHA', 190),
(1823, 'NUEVA REQUENA', 190),
(1824, 'RAYMONDI', 191),
(1825, 'SEPAHUA', 191),
(1826, 'TAHUANIA', 191),
(1827, 'YURUA', 191),
(1828, 'PADRE ABAD', 192),
(1829, 'IRAZOLA', 192),
(1830, 'CURIMANA', 192),
(1831, 'PURUS', 193);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escuela`
--

CREATE TABLE `escuela` (
  `idEscuela` int(11) NOT NULL,
  `EscuelaDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EscuelaVigencia` int(11) NOT NULL,
  `idFacultad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `escuela`
--

INSERT INTO `escuela` (`idEscuela`, `EscuelaDescripcion`, `EscuelaVigencia`, `idFacultad`) VALUES
(1, 'Agronomía', 1, 7),
(2, 'Biología', 1, 8),
(3, 'Contabilidad', 1, 1),
(4, 'Economía', 1, 1),
(5, 'Administración', 1, 1),
(6, 'Comercio y Negocios Internacionales', 1, 1),
(7, 'Física', 1, 6),
(8, 'Matemáticas', 1, 6),
(9, 'Estadística', 1, 6),
(10, 'Ingeniería de Computación e Informática', 1, 6),
(11, 'Ingeniería Electrónica', 1, 6),
(12, 'Educación', 1, 2),
(13, 'Sociología', 1, 2),
(14, 'Ciencias de la Comunicación', 1, 2),
(15, 'Psicología', 1, 2),
(16, 'Arte', 1, 2),
(17, 'Arqueología', 1, 2),
(18, 'Derecho', 1, 9),
(19, 'Ciencia Política', 1, 9),
(20, 'Enfermería', 1, 10),
(21, 'Ingeniería Agrícola', 1, 5),
(22, 'Ingeniería Civil', 1, 4),
(23, 'Arquitectura', 1, 4),
(24, 'Ingeniería de Sistemas', 1, 4),
(25, 'Ingeniería Mecánica y Eléctrica', 1, 11),
(26, 'Medicina Humana', 1, 12),
(27, 'Medicina Veterinaria', 1, 13),
(28, 'Ingeniería Química', 1, 3),
(29, 'Ingeniería en Industrias Alimentarias', 1, 3),
(30, 'Zootecnia', 1, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad`
--

CREATE TABLE `especialidad` (
  `idEspecialidad` int(11) NOT NULL,
  `EspecialidadDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialidadVigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `especialidad`
--

INSERT INTO `especialidad` (`idEspecialidad`, `EspecialidadDescripcion`, `EspecialidadVigencia`) VALUES
(1, 'Psicología Clínica', 1),
(2, 'Medicina General', 1),
(3, 'Medicina Clínica', 1),
(4, 'Psicología cognitiva', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialista`
--

CREATE TABLE `especialista` (
  `idEspecialista` int(11) NOT NULL,
  `EspecialistaNombres` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaApellidos` varchar(80) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaDescripcion` varchar(1200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaExperiencia` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaFoto` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaCV` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaCertificado` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaLink` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaCorreo` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `EspecialistaCelular` varchar(10) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `idEspecialidad` int(11) NOT NULL,
  `EspecialistaCentro` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `CuentaCodigo` varchar(70) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `especialista`
--

INSERT INTO `especialista` (`idEspecialista`, `EspecialistaNombres`, `EspecialistaApellidos`, `EspecialistaDescripcion`, `EspecialistaExperiencia`, `EspecialistaFoto`, `EspecialistaCV`, `EspecialistaCertificado`, `EspecialistaLink`, `EspecialistaCorreo`, `EspecialistaCelular`, `idDepartamento`, `idEspecialidad`, `EspecialistaCentro`, `CuentaCodigo`) VALUES
(4, 'ADELY SABRINA', 'TICONA MIÑOPE', 'Tengo experiencia en Terapia cognitivo-conductual, también en la administración y calificación de pruebas psicológicas como en la elaboración de Informes.', 'Terapeuta cognitivo conductual', 'ESPEC53641220501-WhatsApp Image 2020-11-02 at 10.25.41 PM.jpeg', 'ESPEC53641220501-cv-especialista1.docx', 'ESPEC53641220501-WhatsApp Image 2020-11-02 at 10.28.46 PM.jpeg', 'https://www.facebook.com/estrella.crisantonamuche', 'adelysa_7@gmail.com', '948576305', 14, 1, 'Grupo Luria S.A - Huancayo', 'UNPRG60211486205'),
(5, 'MATEO ABEL', 'CASTILLO DÍAZ', 'Soy Doctor en Medicina General y realizo acciones destinadas a contribuir con la salud. \r\nDiagnostico, trato y ayudo a prevenir las dolencias. Me considero amable, capaz de calmar y tranquilizar a los pacientes, de trabajar en equipo y sobre tengo la aptitud para tomar decisiones.', 'Doctor de Medicina', 'ESPEC47157307192-WhatsApp Image 2020-11-02 at 10.30.44 PM.jpeg', 'ESPEC47157307192-cv-especialista2.docx', 'ESPEC47157307192-WhatsApp Image 2020-11-02 at 10.31.03 PM.jpeg', 'https://www.facebook.com/elias.chacon.5', 'cmateod@gmail.com', '99045722', 14, 2, 'Hospital Regional Lambayeque – Lambayeque', 'UNPRG89541168396'),
(6, 'SANTIAGO BENJAMIN', 'IBARRA CHAVEZ', 'Me considero una persona con una clara orientación humanística. Abordo los procesos asociados a las rehabilitaciones física y mental y al desarrollo de un soporte social y cultural adecuado.', 'Médico Clínico', 'ESPEC35260501133-WhatsApp Image 2020-11-02 at 10.33.50 PM.jpeg', 'ESPEC35260501133-cv-especialista3.docx', 'ESPEC35260501133-WhatsApp Image 2020-11-02 at 10.34.16 PM.jpeg', 'https://www.facebook.com/fernando.ticonatap', 'santiago20_03@gmail.com', '962831414', 14, 3, 'Hospital Luis Heysen Incháustegui - Lambayeque', 'UNPRG45219348597'),
(7, 'LUISA MARIA', 'CASTAÑEDA FLORES', 'Soy psicóloga y realizo acciones destinadas a contribuir con la salud. \r\nDiagnostico y trato problemas de salud mental. Me considero amable, empática, y siempre lista para ayudar.', 'Psicóloga', 'ESPEC17579222354-WhatsApp Image 2020-11-02 at 10.37.08 PM.jpeg', 'ESPEC17579222354-cv-especialista4.docx', 'ESPEC17579222354-WhatsApp Image 2020-11-02 at 10.37.46 PM.jpeg', 'https://www.facebook.com/jhanet.martinez.20', 'maria_castaneda24@gmail.com', '98596214', 14, 4, 'Hospital Guillermo Almenara Irigoyen - Lima', 'UNPRG70343991188');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultad`
--

CREATE TABLE `facultad` (
  `idFacultad` int(11) NOT NULL,
  `FacultadDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `FacultadSiglas` varchar(20) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `FacultadVigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `facultad`
--

INSERT INTO `facultad` (`idFacultad`, `FacultadDescripcion`, `FacultadSiglas`, `FacultadVigencia`) VALUES
(1, 'Facultad de Ciencias Económicas Administrativas y Contables', 'FACEAC', 1),
(2, 'Facultad de Ciencias Histórico Sociales y Educación', 'FACHSE', 1),
(3, 'Facultad de Ingeniería Química e Industrias Alimentarias', 'FIQUIA', 1),
(4, 'Facultad de Ingeniería Civil Sistemas y Arquitectura', 'FICSA', 1),
(5, 'Facultad de Ingeniería Agrícola', 'FIA', 1),
(6, 'Facultad de Ciencia Físicas y Matemáticas', 'FACFYM', 1),
(7, 'Facultad de Agronomía', 'FAG', 1),
(8, 'Facultad de Ciencias Biológicas', 'FCCBB', 1),
(9, 'Facultad de Derecho y Ciencias Políticas', 'FDCCPP', 1),
(10, 'Facultad de Enfermería', 'FE', 1),
(11, 'Facultad de Ingeniería Mecánica y Eléctrica', 'FIME', 1),
(12, 'Facultad de Medicina Humana', 'FMH', 1),
(13, 'Facultad de Medicina Veterinaria', 'FMV', 1),
(14, 'Facultad de Zootecnia', 'FIZ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grabacion`
--

CREATE TABLE `grabacion` (
  `idGrabacion` int(11) NOT NULL,
  `GrabacionEnlace` varchar(256) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `GrabacionDescripcion` varchar(256) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idConferencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `grabacion`
--

INSERT INTO `grabacion` (`idGrabacion`, `GrabacionEnlace`, `GrabacionDescripcion`, `idConferencia`) VALUES
(1, 'https://drive.google.com/file/d/1wINOkU1M1vT58OL7xQzh-KY27WYxBVXa/view?usp=sharing', 'Conferencia entretenida y muy dinámica.', 1),
(2, 'https://drive.google.com/file/d/1WRC2R_aovj9kI58tgSyonC9Cimk1AZIo/view?usp=sharing', 'Conferencia Didáctica y entretenida que deja muy buenos consejos.', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `idNoticia` int(11) NOT NULL,
  `NoticiaTitulo` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `NoticiaFecha` date NOT NULL,
  `NoticiaLink` varchar(550) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `NoticiaImagen` varchar(500) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `NoticiaDescripcion` varchar(3000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `NoticiaDescripcion2` varchar(3000) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `NoticiaVigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`idNoticia`, `NoticiaTitulo`, `NoticiaFecha`, `NoticiaLink`, `NoticiaImagen`, `NoticiaDescripcion`, `NoticiaDescripcion2`, `idCategoria`, `NoticiaVigencia`) VALUES
(1, 'UNIVERSIDAD DE OXFORD DESARROLLA TEST DE COVID-19 QUE DA RESULTADOS EN 5 MINUTOS', '2020-10-15', 'https://www.tvperu.gob.pe/noticias/internacionales/universidad-de-oxford-desarrolla-test-de-covid-19-que-da-resultados-en-5-minutos', 'NT83520068461-WhatsApp Image 2020-11-02 at 10.45.12 PM.jpeg', 'Científicos esperan comenzar el desarrollo del dispositivo de prueba a principios de 2021 para tenerlo aprobado y disponible 6 meses después.\r\nUna prueba rápida de COVID-19 capaz de identificar el virus del nuevo coronavirus en menos de 5 minutos fue desarrollada por científicos de la universidad de Oxford que sería usado en forma masiva en aeropuertos y empresas.', 'Los investigadores de la universidad británica dijeron que esperaban comenzar el desarrollo del dispositivo de prueba a principios de 2021 para tenerlo aprobado y disponible seis meses después.\r\nEl método es capaz de diferenciar con alta precisión el virus responsable de COVID-19, de muestras clínicas negativas, así como de otros patógenos respiratorios comunes como la influenza y la gripe estacional.', 3, 1),
(2, 'RUSIA REGISTRA UNA SEGUNDA VACUNA CONTRA EL CORONAVIRUS', '2020-10-14', 'https://www.tvperu.gob.pe/noticias/internacionales/rusia-registra-una-segunda-vacuna-contra-el-coronavirus', 'NT51396802032-WhatsApp Image 2020-11-02 at 10.45.45 PM.jpeg', 'El laboratorio Vektor en Siberia, \"ha registrado la segunda vacuna contra el coronavirus hoy, llamada EpiVacCorona\", dijo Putin en una reunión ministerial en videoconferencia.\r\nRusia registró su segunda vacuna contra el coronavirus, un paso previo en el país antes de la fase final de los ensayos clínicos, anunció el presidente Vladimir Putin, cuando el número de infecciones diarias bate un nuevo récord. ', 'El laboratorio Vektor en Siberia, \"ha registrado la segunda vacuna contra el coronavirus hoy, llamada EpiVacCorona\", dijo Putin en una reunión ministerial en videoconferencia.\r\nLa vacuna tiene un \"nivel de seguridad suficientemente alto\", declaró la viceprimera ministra rusa encargada de la salud, Tatiana Gólikova, en esta reunión. La vacuna pasará ahora a la fase final de los ensayos, que implicará a 40.000 voluntarios, añadió.  ', 3, 1),
(3, 'APPLE Y GOOGLE INFORMARÁN EXPOSICIÓN AL COVID-19 PARA SMARTPHONES', '2020-09-25', 'https://www.marca.com/claro-mx/trending/2020/09/03/5f507e4946163fa4558b45c4.html', 'NT96736598983-WhatsApp Image 2020-11-02 at 10.46.03 PM.jpeg', 'Apple y Google han dado un paso importante en el rastreo tecnológico del coronavirus Covid-19. Las compañías unieron fuerzas para presentar el sistema de notificaciones \'Exposure Notifications Express\'.A través de este sistema las autoridades sanitarias de cada país podrán enviar archivos a Apple y Google para informar a sus usuarios sobre riesgos de contagio. ', 'Mediante Bluetooth, la persona podrá detectar si ha estado cerca de algún caso positivo por coronavirus.', 3, 1),
(4, 'CIERRE DE PLAYAS: ESTAS SON LAS RESTRICCIONES EN LOS BALNEARIOS DEL NORTE DEL PAÍS PARA EVITAR LA COVID-19', '2020-10-16', 'https://rpp.pe/peru/actualidad/cierre-de-playas-estas-son-las-restricciones-en-los-balnearios-del-norte-del-pais-para-evitar-la-covid-19-noticia-12989', 'NT75271112274-WhatsApp Image 2020-11-02 at 10.51.25 PM.jpeg', 'Autoridades de Lambayeque evalúan cierre de playas para fiestas de fin de año\r\nEl cierre de las playas de Lambayeque durante la festividad de Navidad y Año Nuevo es una propuesta que se encuentra en evaluación dentro de los municipios, informó la prefecta regional, Ana Ubillús Ticlla.\r\nLa funcionaria realizó esta propuesta a fin de prohibir el ingreso de personas a los balnearios de Pimentel, Puerto Eten y San José durante el 25 de diciembre y el 1 de enero, a fin de evitar aglomeraciones que puedan ocasionar la propagación de la COVID-19.Para cumplir con esta medida, Ubillús pidió a los alcaldes de estos distritos elaborar ordenanzas municipales para establecer un cuadro de multas para quienes ingresen a la playa a realizar reuniones sociales.', 'Consultado por RPP Noticias, el epidemiólogo de EsSalud, Cristian Díaz Vélez, señaló que los nuevos puntos de contagio podrían ocurrir en los distritos del circuito de playas donde apenas el 20% de la población se habría contagiado, por lo que se debería regular la afluencia de público. En el caso de la playa de Pimentel, las autoridades están elaborando el Plan Verano 2021 el cual podría contemplar el cierre de la playa, mas no del malecón y el muelle o de la zona de restaurantes.\r\nTambién se evalúa colocar tranqueras en los puntos de acceso para controlar el ingreso de vehículos; sin embargo, esperan el pronunciamiento del Gobierno Central para definir esos temas. Por ahora, solo realizan operativos con la Policía y las Fuerzas Armadas los fines de semana para vigilar que las personas no consuman bebidas alcohólicas, usen mascarilla y respeten el distanciamiento social. El muelle permanece abierto, pero con un aforo del 33%.', 1, 1),
(5, 'LAMBAYEQUE: AMPLIARÁN CAPACIDAD DE OXÍGENO CON INSTALACIÓN DE MÁQUINAS EN HOSPITAL TEMPORAL', '2020-10-04', 'https://elcomercio.pe/peru/lambayeque-ampliaran-capacidad-de-oxigeno-con-instalacion-de-maquinas-en-hospital-temporal-nnpp-noticia/?ref=ecr', 'NT45843990835-WhatsApp Image 2020-11-02 at 10.50.47 PM.jpeg', 'Con ello se potenciará el abastecimiento a 50 camas de hospitalización y 25 camas de la Unidad de Vigilancia Intensiva\r\nInstalan máquinas para ampliar capacidad de oxígeno en hospital temporal (Foto: Gore Lambayeque).', 'El último viernes, la Autoridad para la Reconstrucción con Cambios dio inicio a la instalación de la segunda línea de máquinas con el objetivo de ampliar la capacidad de la planta de oxígeno medicinal ubicada en el área de hospitalización del centro de atención y aislamiento temporal Carlos Augusto Salaverry, en el distrito de La Victoria, provincia de Chiclayo (Lambayeque).\r\nAsí lo informó el Gobierno Regional de Lambayeque mediante su red social donde destacó que con dicha implementación se potenciará el abastecimiento de oxígeno medicinal para las 50 camas de hospitalización y 25 camas de la Unidad de Vigilancia Intensiva con una capacidad de hasta 48 metros cúbicos por hora.', 1, 1),
(6, 'LAMBAYEQUE: CONOCE LOS MUSEOS Y SITIOS ARQUEOLÓGICOS QUE REABRIRÁN SUS PUERTAS A PARTIR DEL 15 DE OCTUBRE', '2020-10-01', 'https://elcomercio.pe/peru/lambayeque/lambayeque-conoce-los-museos-y-sitios-arqueologicos-que-reabriran-sus-puertas-a-partir-del-15-de-octubre-nnpp-no', 'NT94452129336-WhatsApp Image 2020-11-02 at 10.51.12 PM.jpeg', 'Entre ellos están el museo Túcume, el complejo Huaca Rajada y Ventarrón, según informó el Ministerio de Cultura.\r\nComo parte de la fase cuatro de la reactivación económica del país, algunos museos y complejos arqueológicos de la región Lambayeque reabrirán sus puertas al público de manera progresiva desde el próximo 15 de octubre.\r\nEsto fue confirmado por el ministro de Cultura, Alejandro Neyra, quien aseguró que este proceso se realizará considerando las disposiciones del Gobierno central y teniendo en cuenta la información de las alertas epidemiológicas del Ministerio de Salud (Minsa).', 'En ese sentido, se tiene previsto el museo de Túcume, en Lambayeque, así como los complejos arqueológicos Huaca Rajada y Ventarrón, en Chiclayo, reabran sus puertas desde la fecha mencionada.\r\nPrecisó que el acceso a estos museos y complejos arqueológicos será gratuito hasta el 15 de noviembre y se respetará el aforo de un 50% de su capacidad y en grupos de 5 personas como máximo.', 1, 1),
(7, 'ESSALUD OBTENDRÁ RESULTADOS DE PRUEBAS MOLECULARES PARA DIAGNÓSTICOS DE COVID-19 EN MENOS DE DOS HORAS', '2020-10-23', 'https://www.tvperu.gob.pe/noticias/nacionales/essalud-obtendra-resultados-de-pruebas-moleculares-para-diagnosticos-de-covid-19-en-menos-de-dos-horas', 'NT29210259497-WhatsApp Image 2020-11-02 at 10.54.38 PM.jpeg', 'Moderno laboratorio molecular del Hospital Nacional Edgardo Rebagliati obtiene certificación del Instituto Nacional de Salud que le permitirá procesar muestras.', 'El Seguro Social de Salud (EsSalud) iniciará el procesamiento de pruebas moleculares para COVID-19, con resultados en menos de dos horas y con capacidad para procesar las muestras diarias requeridas.\r\nAsí lo informó la presidenta ejecutiva de EsSalud, Fiorella Molinelli Aristondo, luego de recibir la certificación del Instituto Nacional de Salud (INS) para el funcionamiento del laboratorio de biología molecular en el Hospital Nacional Edgardo Rebagliati Martins, especializado y exclusivo para la detección del virus del SARS-CoV-2.\r\nParticiparon de esta ceremonia el gerente de la Red Prestacional Rebagliati, Juan Santillana y el Gerente General de EsSalud, Alfredo Barredo.', 2, 1),
(8, 'GOBIERNO LANZA CAMPAÑA “NUESTRO PLANETA NO ES DE UN SOLO USO”', '2020-10-21', 'https://www.tvperu.gob.pe/noticias/nacionales/gobierno-lanza-campana-nuestro-planeta-no-es-de-un-solo-uso', 'NT21667966758-WhatsApp Image 2020-11-02 at 10.55.02 PM.jpeg', 'La ministra del Ambiente, Kirla Echegaray, pidió a la ciudadanía utilizar productos biodegradables, compostables y reutilizables.\r\nHoy al iniciarse la sesión del Consejo de Ministros llamó la atención ver al presidente de la República, Martín Vizcarra, y a todos los ministros de Estado luciendo una mascarilla con un mensaje: “Nuestro planeta no es de un solo uso”.', 'Según la ministra del Ambiente, Kirla Echegaray, esta campaña es un llamado de atención a la ciudadanía respecto al cuidado del planeta, sobre todo en tiempos de pandemia en donde se ha elevado el uso de las mascarillas, guantes e implementos de bioseguridad.\r\n“Actualmente, lo que ha pasado es que estamos utilizando en muchos casos mascarillas que son descartables, la usamos y luego la botamos y eso está contaminando nuestro medio ambiente”, explicó la ministra.\r\nAsimismo, informó que las mascarillas desechables demoran 400 años en degradarse. “Este es un llamado a todos los peruanos a efecto de que podamos utilizar el tipo de mascarillas que son biodegradables, compostables y reutilizables”.', 2, 1),
(9, 'MINEM ENTREGA EQUIPOS DE PROTECCIÓN PARA FORTALECER LUCHA CONTRA EL COVID-19 EN ÁNCASH', '2020-10-10', 'https://www.radionacional.com.pe/noticias/nacional/minem-entrega-equipos-de-proteccion-para-fortalecer-lucha-contra-el-covid-19-en-ancash', 'NT64103430439-WhatsApp Image 2020-11-02 at 10.55.23 PM.jpeg', 'El ministro de Energía y Minas, Miguel Incháustegui Zevallos, visito hoy la ciudad de Huaraz para hacer entrega de una importante cantidad de material médico proporcionado por el Ministerio de Salud (Minsa). El objetivo es seguir fortaleciendo la lucha contra el covid-19 en esa región\r\nEn esta oportunidad se ha gestionado la entrega de 1,000 pantalones descartables, 1,000 protectores faciales con visor, 1,000 lentes de protección de policarbonato, 1,000 chaquetas descartables, 2,000 mascarillas descartables de diversos tipos, entre otros implementos, que permitirá mejorar el trabajo de los profesionales de la salud en el descarte y tratamiento de los casos de covid-19 que se presenten.', 'Cabe precisar que, a fines de agosto pasado, el Minem entregó a la región 10,000 pruebas serológicas (rápidas), 1,800 kilos de equipos de protección e implementos médicos (trajes, guantes, mascarillas, entre otros) y 133 balones de oxígeno para la atención oportuna los casos más graves de covid-19.', 2, 1),
(10, 'COMUNIDAD ANDINA APORTARÁ 500,000 DÓLARES A OPS PARA VACUNAS CONTRA COVID-19', '2020-09-14', 'https://www.marca.com/claro-mx/trending/2020/09/03/5f507e4946163fa4558b45c4.html', 'NT212716410710-WhatsApp Image 2020-11-02 at 11.59.12 PM.jpeg', 'Grandes noticias desde Sudamérica, toda vez que la Comunidad Andina (CAN), el organismo de integración internacional formado por Bolivia, Colombia, Ecuador y Perú, hará una aportación de 500.000 dólares a la Organización Panamericana de la Salud (OPS) para facilitar la vacunación contra la Covid-19 de comunidades vulnerables.', 'La donación partirá del Gobierno de Colombia, que hará este aporte a nombre de la CAN como parte de su presidencia temporal del organismo, según anunció su canciller, Claudia Blum, durante la vigésima reunión extraordinaria del Consejo Andino de Ministros de Relaciones Exteriores.', 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ponente`
--

CREATE TABLE `ponente` (
  `idPonente` int(11) NOT NULL,
  `PonenteNombres` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `PonenteDescripcion` varchar(140) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `PonenteCodigo` varchar(70) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ponente`
--

INSERT INTO `ponente` (`idPonente`, `PonenteNombres`, `PonenteDescripcion`, `PonenteCodigo`) VALUES
(8, 'Carlos Ordinola', 'Psicólogo, experta en temas de salud mental y emocional.', 'PONE17327321571'),
(9, 'Miguel Inga', 'Experto en temas de salud mental y emocional.', 'PONE54787414002'),
(10, 'Fernanda Cueva', 'Psicóloga, con una maestría en España en temas de Salud Mental Emocional.', 'PONE49117030313'),
(11, 'Manuel Gonzales', 'Profesional en el área de psicología, con amplia experiencia en el ámbito de la salud emocional y mental.', 'PONE72882461514'),
(13, 'Kristal Ayala', 'Psicóloga, esperta en temas de salud mental y emocional.', 'PONE18105063815');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `idProvincia` int(11) NOT NULL,
  `ProvinciaDescripcion` varchar(120) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idDepartamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`idProvincia`, `ProvinciaDescripcion`, `idDepartamento`) VALUES
(1, 'CHACHAPOYAS ', 1),
(2, 'BAGUA', 1),
(3, 'BONGARA', 1),
(4, 'CONDORCANQUI', 1),
(5, 'LUYA', 1),
(6, 'RODRIGUEZ DE MENDOZA', 1),
(7, 'UTCUBAMBA', 1),
(8, 'HUARAZ', 2),
(9, 'AIJA', 2),
(10, 'ANTONIO RAYMONDI', 2),
(11, 'ASUNCION', 2),
(12, 'BOLOGNESI', 2),
(13, 'CARHUAZ', 2),
(14, 'CARLOS FERMIN FITZCARRALD', 2),
(15, 'CASMA', 2),
(16, 'CORONGO', 2),
(17, 'HUARI', 2),
(18, 'HUARMEY', 2),
(19, 'HUAYLAS', 2),
(20, 'MARISCAL LUZURIAGA', 2),
(21, 'OCROS', 2),
(22, 'PALLASCA', 2),
(23, 'POMABAMBA', 2),
(24, 'RECUAY', 2),
(25, 'SANTA', 2),
(26, 'SIHUAS', 2),
(27, 'YUNGAY', 2),
(28, 'ABANCAY', 3),
(29, 'ANDAHUAYLAS', 3),
(30, 'ANTABAMBA', 3),
(31, 'AYMARAES', 3),
(32, 'COTABAMBAS', 3),
(33, 'CHINCHEROS', 3),
(34, 'GRAU', 3),
(35, 'AREQUIPA', 4),
(36, 'CAMANA', 4),
(37, 'CARAVELI', 4),
(38, 'CASTILLA', 4),
(39, 'CAYLLOMA', 4),
(40, 'CONDESUYOS', 4),
(41, 'ISLAY', 4),
(42, 'LA UNION', 4),
(43, 'HUAMANGA', 5),
(44, 'CANGALLO', 5),
(45, 'HUANCA SANCOS', 5),
(46, 'HUANTA', 5),
(47, 'LA MAR', 5),
(48, 'LUCANAS', 5),
(49, 'PARINACOCHAS', 5),
(50, 'PAUCAR DEL SARA SARA', 5),
(51, 'SUCRE', 5),
(52, 'VICTOR FAJARDO', 5),
(53, 'VILCAS HUAMAN', 5),
(54, 'CAJAMARCA', 6),
(55, 'CAJABAMBA', 6),
(56, 'CELENDIN', 6),
(57, 'CHOTA ', 6),
(58, 'CONTUMAZA', 6),
(59, 'CUTERVO', 6),
(60, 'HUALGAYOC', 6),
(61, 'JAEN', 6),
(62, 'SAN IGNACIO', 6),
(63, 'SAN MARCOS', 6),
(64, 'SAN PABLO', 6),
(65, 'SANTA CRUZ', 6),
(66, 'CALLAO', 7),
(67, 'CUSCO', 8),
(68, 'ACOMAYO', 8),
(69, 'ANTA', 8),
(70, 'CALCA', 8),
(71, 'CANAS', 8),
(72, 'CANCHIS', 8),
(73, 'CHUMBIVILCAS', 8),
(74, 'ESPINAR', 8),
(75, 'LA CONVENCION', 8),
(76, 'PARURO', 8),
(77, 'PAUCARTAMBO', 8),
(78, 'QUISPICANCHI', 8),
(79, 'URUBAMBA', 8),
(80, 'HUANCAVELICA', 9),
(81, 'ACOBAMBA', 9),
(82, 'ANGARAES', 9),
(83, 'CASTROVIRREYNA', 9),
(84, 'CHURCAMPA', 9),
(85, 'HUAYTARA', 9),
(86, 'TAYACAJA', 9),
(87, 'HUANUCO', 10),
(88, 'AMBO', 10),
(89, 'DOS DE MAYO', 10),
(90, 'HUACAYBAMBA', 10),
(91, 'HUAMALIES', 10),
(92, 'LEONCIO PRADO', 10),
(93, 'MARA&Ntilde;ON', 10),
(94, 'PACHITEA', 10),
(95, 'PUERTO INCA', 10),
(96, 'LAURICOCHA', 10),
(97, 'YAROWILCA', 10),
(98, 'ICA', 11),
(99, 'CHINCHA', 11),
(100, 'NAZCA', 11),
(101, 'PALPA', 11),
(102, 'PISCO', 11),
(103, 'HUANCAYO', 12),
(104, 'CONCEPCION', 12),
(105, 'CHANCHAMAYO', 12),
(106, 'JAUJA', 12),
(107, 'JUNIN', 12),
(108, 'SATIPO', 12),
(109, 'TARMA', 12),
(110, 'YAULI', 12),
(111, 'CHUPACA', 12),
(112, 'TRUJILLO', 13),
(113, 'ASCOPE', 13),
(114, 'BOLIVAR', 13),
(115, 'CHEPEN', 13),
(116, 'JULCAN', 13),
(117, 'OTUZCO', 13),
(118, 'PACASMAYO', 13),
(119, 'PATAZ', 13),
(120, 'SANCHEZ CARRION', 13),
(121, 'SANTIAGO DE CHUCO', 13),
(122, 'GRAN CHIMU', 13),
(123, 'VIRU', 13),
(124, 'CHICLAYO', 14),
(125, 'FERRE&Ntilde;AFE', 14),
(126, 'LAMBAYEQUE', 14),
(127, 'LIMA', 15),
(128, 'BARRANCA', 15),
(129, 'CAJATAMBO', 15),
(130, 'CANTA', 15),
(131, 'CA&Ntilde;ETE', 15),
(132, 'HUARAL', 15),
(133, 'HUAROCHIRI', 15),
(134, 'HUAURA', 15),
(135, 'OYON', 15),
(136, 'YAUYOS', 15),
(137, 'MAYNAS', 16),
(138, 'ALTO AMAZONAS', 16),
(139, 'LORETO', 16),
(140, 'MARISCAL RAMON CASTILLA', 16),
(141, 'REQUENA', 16),
(142, 'UCAYALI', 16),
(143, 'TAMBOPATA', 17),
(144, 'MANU', 17),
(145, 'TAHUAMANU', 17),
(146, 'MARISCAL NIETO', 18),
(147, 'GENERAL SANCHEZ CERRO', 18),
(148, 'ILO', 18),
(149, 'PASCO', 19),
(150, 'DANIEL ALCIDES CARRION', 19),
(151, 'OXAPAMPA', 19),
(152, 'PIURA', 20),
(153, 'AYABACA', 20),
(154, 'HUANCABAMBA', 20),
(155, 'MORROPON', 20),
(156, 'PAITA', 20),
(157, 'SULLANA', 20),
(158, 'TALARA', 20),
(159, 'SECHURA', 20),
(160, 'PUNO', 21),
(161, 'AZANGARO', 21),
(162, 'CARABAYA', 21),
(163, 'CHUCUITO', 21),
(164, 'EL COLLAO', 21),
(165, 'HUANCANE', 21),
(166, 'LAMPA', 21),
(167, 'MELGAR', 21),
(168, 'MOHO', 21),
(169, 'SAN ANTONIO DE PUTINA', 21),
(170, 'SAN ROMAN', 21),
(171, 'SANDIA', 21),
(172, 'YUNGUYO', 21),
(173, 'MOYOBAMBA', 22),
(174, 'BELLAVISTA', 22),
(175, 'EL DORADO', 22),
(176, 'HUALLAGA', 22),
(177, 'LAMAS', 22),
(178, 'MARISCAL CACERES', 22),
(179, 'PICOTA', 22),
(180, 'RIOJA', 22),
(181, 'SAN MARTIN', 22),
(182, 'TOCACHE', 22),
(183, 'TACNA', 23),
(184, 'CANDARAVE', 23),
(185, 'JORGE BASADRE', 23),
(186, 'TARATA', 23),
(187, 'TUMBES', 24),
(188, 'CONTRALMIRANTE VILLAR', 24),
(189, 'ZARUMILLA', 24),
(190, 'CORONEL PORTILLO', 25),
(191, 'ATALAYA', 25),
(192, 'PADRE ABAD', 25),
(193, 'PURUS', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `queja`
--

CREATE TABLE `queja` (
  `idQueja` int(11) NOT NULL,
  `idEspecialista` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `QuejaDescripcion` varchar(256) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `QuejaFecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `idTema` int(11) NOT NULL,
  `TemaTitulo` varchar(256) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `TemaImagen` varchar(520) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`idTema`, `TemaTitulo`, `TemaImagen`) VALUES
(1, 'Cuidado de la salud Emocional', 'TEMA34398147421-WhatsApp Image 2020-11-02 at 11.37.03 PM.jpeg'),
(2, 'Trabajos esenciales', 'TEMA81217398782-WhatsApp Image 2020-11-02 at 11.37.04 PM.jpeg'),
(3, 'Autocuidado parental', 'TEMA63432872363-WhatsApp Image 2020-11-02 at 11.37.05 PM.jpeg'),
(4, 'Duelo y pérdida', 'TEMA86747303304-WhatsApp Image 2020-11-02 at 11.37.06 PM.jpeg'),
(5, 'Estrés Financiero', 'TEMA66827293085-WhatsApp Image 2020-11-02 at 11.37.07 PM.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `idTestimonio` int(11) NOT NULL,
  `TestimonioDescripcion` varchar(256) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `TestimonioFecha` date NOT NULL,
  `TestimonioVisibilidad` int(11) NOT NULL,
  `idEspecialista` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`idTestimonio`, `TestimonioDescripcion`, `TestimonioFecha`, `TestimonioVisibilidad`, `idEspecialista`, `idUsuario`) VALUES
(1, 'Exelente consejera emocional, me ayudo a sobrellevar mis problema de abuso estudiantil.', '2020-11-03', 1, 7, 1),
(2, 'Muy buena atencion! Me ayudaste mucho a sobrellevar mi problema.', '2020-11-03', 1, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(10) NOT NULL,
  `UsuarioNombres` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `UsuarioApellidoPaterno` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `UsuarioApellidoMaterno` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `UsuarioTelefono` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `UsuarioDescripcion` varchar(256) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `UsuarioDireccion` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `UsuarioFoto` varchar(500) COLLATE utf8_spanish2_ci NOT NULL,
  `UsuarioNacimiento` date NOT NULL,
  `UsuarioGenero` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `UsuarioTipo` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaCodigo` varchar(70) COLLATE utf8_spanish2_ci NOT NULL,
  `idEscuela` int(11) NOT NULL,
  `idDistrito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `UsuarioNombres`, `UsuarioApellidoPaterno`, `UsuarioApellidoMaterno`, `UsuarioTelefono`, `UsuarioDescripcion`, `UsuarioDireccion`, `UsuarioFoto`, `UsuarioNacimiento`, `UsuarioGenero`, `UsuarioTipo`, `CuentaCodigo`, `idEscuela`, `idDistrito`) VALUES
(1, 'Edu Avelino', 'Cespedes', 'Ordinola', '962348653', 'Hola, bievenido a mi perfil.', 'Ucayali #185', 'UNPRG46076026212-91493303_3597019450324594_1241615641580929024_o.jpg', '1998-06-03', 'Masculino', 'Alumno', 'UNPRG46076026212', 10, 1233),
(2, 'Carmen Rosa', 'Martinez', 'Rodriguez', '968909999', 'Bienvenido a mi Perfil', 'Emiliano Niño #354', 'nulo', '1996-09-11', 'Femenino', 'Alumno', 'UNPRG88369501773', 10, 1213);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdministrador`),
  ADD KEY `CuentaCodigo` (`CuentaCodigo`);

--
-- Indices de la tabla `atencion`
--
ALTER TABLE `atencion`
  ADD PRIMARY KEY (`idAtencion`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idEspecialista` (`idEspecialista`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CuentaCodigo` (`CuentaCodigo`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`idComentario`),
  ADD KEY `idNoticia` (`idNoticia`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `conferencia`
--
ALTER TABLE `conferencia`
  ADD PRIMARY KEY (`idConferencia`),
  ADD KEY `idPonente` (`idPonente`);

--
-- Indices de la tabla `consejo`
--
ALTER TABLE `consejo`
  ADD PRIMARY KEY (`idConsejo`),
  ADD KEY `idTema` (`idTema`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CuentaCodigo` (`CuentaCodigo`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`);

--
-- Indices de la tabla `detalle_conferencia`
--
ALTER TABLE `detalle_conferencia`
  ADD PRIMARY KEY (`idDetalleConferencia`),
  ADD KEY `idConferencia` (`idConferencia`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD PRIMARY KEY (`idDiagnostico`),
  ADD KEY `idAtencion` (`idAtencion`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`idDistrito`),
  ADD KEY `idProvincia` (`idProvincia`);

--
-- Indices de la tabla `escuela`
--
ALTER TABLE `escuela`
  ADD PRIMARY KEY (`idEscuela`),
  ADD KEY `escuela_ibfk_1` (`idFacultad`);

--
-- Indices de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`idEspecialidad`);

--
-- Indices de la tabla `especialista`
--
ALTER TABLE `especialista`
  ADD PRIMARY KEY (`idEspecialista`),
  ADD UNIQUE KEY `CuentaCodigo` (`CuentaCodigo`),
  ADD KEY `idEspecialidad` (`idEspecialidad`),
  ADD KEY `idDepartamento` (`idDepartamento`);

--
-- Indices de la tabla `facultad`
--
ALTER TABLE `facultad`
  ADD PRIMARY KEY (`idFacultad`);

--
-- Indices de la tabla `grabacion`
--
ALTER TABLE `grabacion`
  ADD PRIMARY KEY (`idGrabacion`),
  ADD UNIQUE KEY `idConferencia` (`idConferencia`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`idNoticia`),
  ADD KEY `idCategoria` (`idCategoria`);

--
-- Indices de la tabla `ponente`
--
ALTER TABLE `ponente`
  ADD PRIMARY KEY (`idPonente`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`idProvincia`),
  ADD KEY `idDepartamento` (`idDepartamento`);

--
-- Indices de la tabla `queja`
--
ALTER TABLE `queja`
  ADD PRIMARY KEY (`idQueja`),
  ADD KEY `idEspecialista` (`idEspecialista`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`idTema`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`idTestimonio`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idEspecialista` (`idEspecialista`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `CuentaCodigo` (`CuentaCodigo`),
  ADD KEY `idEscuela` (`idEscuela`),
  ADD KEY `idDistrito` (`idDistrito`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdministrador` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `atencion`
--
ALTER TABLE `atencion`
  MODIFY `idAtencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `idComentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `conferencia`
--
ALTER TABLE `conferencia`
  MODIFY `idConferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `consejo`
--
ALTER TABLE `consejo`
  MODIFY `idConsejo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `detalle_conferencia`
--
ALTER TABLE `detalle_conferencia`
  MODIFY `idDetalleConferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `diagnostico`
--
ALTER TABLE `diagnostico`
  MODIFY `idDiagnostico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `distrito`
--
ALTER TABLE `distrito`
  MODIFY `idDistrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1832;

--
-- AUTO_INCREMENT de la tabla `escuela`
--
ALTER TABLE `escuela`
  MODIFY `idEscuela` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `idEspecialidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `especialista`
--
ALTER TABLE `especialista`
  MODIFY `idEspecialista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `facultad`
--
ALTER TABLE `facultad`
  MODIFY `idFacultad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `grabacion`
--
ALTER TABLE `grabacion`
  MODIFY `idGrabacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ponente`
--
ALTER TABLE `ponente`
  MODIFY `idPonente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `idProvincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;

--
-- AUTO_INCREMENT de la tabla `queja`
--
ALTER TABLE `queja`
  MODIFY `idQueja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `idTema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `idTestimonio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD CONSTRAINT `administrador_ibfk_1` FOREIGN KEY (`CuentaCodigo`) REFERENCES `cuenta` (`CuentaCodigo`);

--
-- Filtros para la tabla `atencion`
--
ALTER TABLE `atencion`
  ADD CONSTRAINT `atencion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `atencion_ibfk_2` FOREIGN KEY (`idEspecialista`) REFERENCES `especialista` (`idEspecialista`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `bitacora_ibfk_1` FOREIGN KEY (`CuentaCodigo`) REFERENCES `cuenta` (`CuentaCodigo`);

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`idNoticia`) REFERENCES `noticia` (`idNoticia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `conferencia`
--
ALTER TABLE `conferencia`
  ADD CONSTRAINT `conferencia_ibfk_1` FOREIGN KEY (`idPonente`) REFERENCES `ponente` (`idPonente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `consejo`
--
ALTER TABLE `consejo`
  ADD CONSTRAINT `consejo_ibfk_1` FOREIGN KEY (`idTema`) REFERENCES `tema` (`idTema`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_conferencia`
--
ALTER TABLE `detalle_conferencia`
  ADD CONSTRAINT `detalle_conferencia_ibfk_1` FOREIGN KEY (`idConferencia`) REFERENCES `conferencia` (`idConferencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_conferencia_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `diagnostico`
--
ALTER TABLE `diagnostico`
  ADD CONSTRAINT `diagnostico_ibfk_1` FOREIGN KEY (`idAtencion`) REFERENCES `atencion` (`idAtencion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD CONSTRAINT `distrito_ibfk_1` FOREIGN KEY (`idProvincia`) REFERENCES `provincia` (`idProvincia`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `escuela`
--
ALTER TABLE `escuela`
  ADD CONSTRAINT `escuela_ibfk_1` FOREIGN KEY (`idFacultad`) REFERENCES `facultad` (`idFacultad`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `especialista`
--
ALTER TABLE `especialista`
  ADD CONSTRAINT `especialista_ibfk_1` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `especialista_ibfk_2` FOREIGN KEY (`idEspecialidad`) REFERENCES `especialidad` (`idEspecialidad`) ON UPDATE CASCADE,
  ADD CONSTRAINT `especialista_ibfk_3` FOREIGN KEY (`CuentaCodigo`) REFERENCES `cuenta` (`CuentaCodigo`);

--
-- Filtros para la tabla `grabacion`
--
ALTER TABLE `grabacion`
  ADD CONSTRAINT `grabacion_ibfk_1` FOREIGN KEY (`idConferencia`) REFERENCES `conferencia` (`idConferencia`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD CONSTRAINT `noticia_ibfk_1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `provincia_ibfk_1` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `queja`
--
ALTER TABLE `queja`
  ADD CONSTRAINT `queja_ibfk_1` FOREIGN KEY (`idEspecialista`) REFERENCES `especialista` (`idEspecialista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `queja_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `testimonio_ibfk_1` FOREIGN KEY (`idEspecialista`) REFERENCES `especialista` (`idEspecialista`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `testimonio_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`CuentaCodigo`) REFERENCES `cuenta` (`CuentaCodigo`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`idDistrito`) REFERENCES `distrito` (`idDistrito`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
