SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


DROP DATABASE IF EXISTS Futbol;
CREATE DATABASE IF NOT EXISTS Futbol DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE Futbol;


CREATE TABLE `Equipo` (
    `id_Equipo` int(3) NOT NULL,
    `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `escudo` varchar(200) NOT NULL,
    `puntos` int(3) NOT NULL,
    `partidos_Jugados` int(2) NOT NULL,
    `victorias` int(2) NOT NULL,
    `empates` int(2) NOT NULL,
    `derrotas` int(2) NOT NULL,
    `goles_Favor` int(3) NOT NULL,
    `goles_Contra` int(3) NOT NULL,
    `diferencia_Goles` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Arbitro` (
    `id_Arbitro` int(3) NOT NULL,
    `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `apellidos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Arbitro` (`id_Arbitro`, `nombre`, `apellidos`) VALUES
    (1, 'Mario', 'Gil Gonzalez'),
    (2, 'Eric', 'Marquez Perez');

CREATE TABLE `Usuario` (
    `id_Usuario` int(3) NOT NULL,
    `identificador` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `contrasenna` varchar(255) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `tipo` tinyint(1) NOT NULL DEFAULT 0,
    `codigoCookie` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Usuario` (`id_Usuario`, `identificador`, `contrasenna`, `tipo`, `codigoCookie`) VALUES
    (1, 'mggonzalez', 'abcd1',  1, NULL),
    (2, 'emperez', 'abcd2',  1, NULL),
    (3, 'pmgarcia', 'abcd1',  0, NULL),
    (4, 'mpgimenez', '1234a', 0, NULL);

CREATE TABLE `Partido` (
    `id_Partido` int(3) NOT NULL,
    `id_Equipo_Local` int(3) NOT NULL,
    `id_Equipo_Visitante` int(3) NOT NULL,
    `fecha` timestamp NOT NULL,
    `id_Arbitro` int(3) NOT NULL,
    `gol_Local` int(2),
    `gol_Visitante` int(2),
    `ganador` int(1)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Equipo`
    ADD PRIMARY KEY (`id_Equipo`);

ALTER TABLE `Usuario`
    ADD PRIMARY KEY (`id_Usuario`);

ALTER TABLE `Partido`
    ADD PRIMARY KEY (`id_Partido`);

ALTER TABLE `Arbitro`
    ADD PRIMARY KEY (`id_Arbitro`);

ALTER TABLE `Equipo`
    MODIFY `id_Equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `Usuario`
    MODIFY `id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `Partido`
    MODIFY `id_Partido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `Arbitro`
    MODIFY `id_Arbitro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `Arbitro` ADD FULLTEXT(`nombre`, `apellidos`);
ALTER TABLE `Equipo` ADD FULLTEXT(`nombre`);


ALTER TABLE `Partido`
    ADD CONSTRAINT `fk_equipo_localId` FOREIGN KEY (`id_Equipo_Local`) REFERENCES `Equipo` (`id_Equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_equipo_visitanteId` FOREIGN KEY (`id_Equipo_Visitante`) REFERENCES `Equipo` (`id_Equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_arbitroId` FOREIGN KEY (`id_Arbitro`) REFERENCES `Arbitro` (`id_Arbitro`) ON DELETE CASCADE ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS=0;
COMMIT;