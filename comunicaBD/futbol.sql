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

INSERT INTO `Equipo` (`id_Equipo`, `nombre_Equipo`, `foto_Equipo`, `puntos`, 
                    `partidos_Jugados`, `victorias`, `empates`, `derrotas`, `goles_Favor`, `goles_Contra`, `diferencia_Goles`) VALUES
(1, 'Rayo Vayecano', 'rayoVallecano.jpg', 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Ateltico de Madrid', 'atm.jpg', 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Illescas', 'illescas.jpg', 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'Getafe', 'getafe.jpg', 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'Alcobendas', 'alcobendas.jpg', 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'Brunete', 'brunete.jpg', 0, 0, 0, 0, 0, 0, 0, 0),
(7, 'Carabanchel', 'carabanchel.png', 0, 0, 0, 0, 0, 0, 0, 0),
(8, 'Moratalaz', 'moratalaz.png', 0, 0, 0, 0, 0, 0, 0, 0);


CREATE TABLE `Usuario` (
    `id_Usuario` int(3) NOT NULL,
    `nombre_Usuario` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `apellidos_Usuario` varchar(80) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
    `equipoId` int(3) NOT NULL,
    `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `Usuario` (`id_Usuario`, `nombre_Usuario`, `apellidos_Usuario`, `equipoId`, `estado`) VALUES
(1, 'Pedro', 'Garcia Sanchez', 1, 'jugador'),
(2, 'Luis', 'Fernandez Gutierrez', 2, 'jugador'),
(3, 'Mario', 'Alonso Fernandez', 3, 'jugador'),
(4, 'Pepe', 'Moreno Garcia', 4, 'jugador'),
(5, 'Jesus', 'Gutierrez Prado', 5, 'jugador'),
(6, 'Adrian', 'Sanchez Garcia', 6, 'jugador'),
(7, 'David', 'Medina Hernandez', 7, 'jugador'),
(8, 'Xavi', 'Lopez GOnzalez', 8, 'jugador');


CREATE TABLE `Partido` (
    `id_Partido` int(3) NOT NULL,
    `id_Equipo_Local` int(3) NOT NULL,
    `id_Equipo_Visitante` int(3) NOT NULL,
    `fecha` timestamp,
    `gol_Local` int(2),
    `gol_Visitante` int(2),
    `ganador` varchar(45)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `Equipo`
    ADD PRIMARY KEY (`id_Equipo`);


ALTER TABLE `Usuario`
    ADD PRIMARY KEY (`id_Usuario`);
    /*ADD KEY `fk_equipoIdIdx` (`equipoId`);*/


ALTER TABLE `Equipo`
    MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;


ALTER TABLE `Usuario`
    MODIFY `id_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `Partido`
    ADD CONSTRAINT `fk_equipo_localId` FOREIGN KEY (`id_Equipo_Local`) REFERENCES `Equipo` (`id_Equipo`),
    ADD CONSTRAINT `fk_equipoI_visitanted` FOREIGN KEY (`id_Equipo_Visitante`) REFERENCES `Equipo` (`id_Equipo`);


ALTER TABLE `Usuario`
    ADD CONSTRAINT `fk_equipoId` FOREIGN KEY (`equipoId`) REFERENCES `Equipo` (`id_Equipo`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;