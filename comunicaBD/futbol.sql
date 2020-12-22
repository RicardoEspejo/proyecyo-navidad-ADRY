SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


DROP DATABASE IF EXISTS Futbol;
CREATE DATABASE IF NOT EXISTS Futbol DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE Futbol;


CREATE TABLE `Equipo` (
    `id_Equipo` int(3) NOT NULL,
    `nombre_Equipo` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `foto_Equipo` varchar(200),
    `puntos` int(3),
    `partidos_Jugados` int(2),
    `victorias` int(2),
    `empates` int(2),
    `derrotas` int(2),
    `goles_Favor` int(3),
    `goles_Contra` int(3),
    `diferencia_Goles` int(3)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Usuario` (
    `id_Usuario` int(3) NOT NULL,
    `identificador` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `contrasenna` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `apellidos` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Arbitro` (
    `id_Arbitro` int(2) NOT NULL,
    `identificador` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `contrasenna` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `apellidos` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `Arbitro` (`id_arbitro`, `identificador`, `contrasenna`, `nombre`, `apellidos`) VALUES
    (1, 'mggonzalez', 'abcd', 'Mario', 'Gil Gonzalez'),
    (2, 'emperez', '1234', 'Eric', 'Marquez Perez');

CREATE TABLE `Partido` (
    `id_Partido` int(3) NOT NULL,
    `id_Equipo_Local` int(3) NOT NULL,
    `id_Equipo_Visitante` int(3) NOT NULL,
    `fecha` timestamp NOT NULL,
    `id_Arbitro_Principal` int(2) NOT NULL,
    `gol_Local` int(2),
    `gol_Visitante` int(2),
    `ganador` varchar(45)
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
    MODIFY `id_Partido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `Arbitro`
    MODIFY `id_Arbitro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `Partido`
    ADD CONSTRAINT `fk_equipo_localId` FOREIGN KEY (`id_Equipo_Local`) REFERENCES `Equipo` (`id_Equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_equipo_visitanteId` FOREIGN KEY (`id_Equipo_Visitante`) REFERENCES `Equipo` (`id_Equipo`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_arbitro_principalId` FOREIGN KEY (`id_Arbitro_Principal`) REFERENCES `Arbitro` (`id_Arbitro`) ON DELETE CASCADE ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;