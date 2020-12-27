<?php

require_once "varios.php";
class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "futbol"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }

    //EQUIPO
    private static function equipoCrearDesdeRs(array $rs): Categoria
    {
        return new Equipo($rs["id"], $rs["nombre"], $rs["escudo"], $rs["puntos"], $rs["patidos_Jugados"], $rs["victorias"], $rs["empates"], $rs["derrotas"], $rs["goles_Favor"], $rs["goles_Contra"], $rs["diferencia_Goles"]);
    }

    private static function equipoCrear (String $nombre, String $escudo): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO Equipo (nombre, escudo, puntos, partidos_jugados, victorias, empates, derrotas, goles_Favor, goles_Contra, diferencia_Goles) VALUES(?,?,?,?,?,?,?,?,?,?)",
            [$nombre, $escudo, 0, 0, 0, 0, 0, 0, 0, 0]
        );
    }

    private static function equipoObtenerPorID (int $ id): ?Equipo
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Equipo WHERE id_Equipo=?",
            [$id]
        );
        if ($rs) 
            return self::equipoCrearDesdeRs($rs[0]);
        else 
            return null;
    }

    private static function equipoObtenerTodos(): array // Clasificación 
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Equipo ORDER BY nombre",
            []
        );
        foreach ($rs as $fila) {
            $equipo = self::equipoCrearDesdeRs($fila);
            array_push($datos, $equipo);
        }
        return $datos;
    }
    private static function equipoEliminarPorID (int $id): bool
    {
        return self::ejecutarActualizacion(
            "DELETE FROM Equipo WHERE id_Equipo=?", 
            [$id]
        );
    }
    private static function equipoActualizarPorID (int $id, string $nombre, string $escudo): bool
    {
        return self::ejecutarActualizacion(
            "UPDATE Equipo SET nombre=?, escudo=? WHERE id_Equipo=?",
            [$nombre, $escudo, $id]
        );
    }

}
