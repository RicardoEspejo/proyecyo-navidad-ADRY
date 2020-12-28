<?php

require_once "varios.php";
require_once "clases.php";
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
    private static function equipoCrearDesdeRs(array $rs): Equipo
    {
        return new Equipo($rs["id_Equipo"], $rs["nombre"], $rs["escudo"]);
    }

    private static function equipoCrear (String $nombre, String $escudo): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO Equipo (nombre, escudo, puntos, partidos_jugados, victorias, empates, derrotas, goles_Favor, goles_Contra, diferencia_Goles) VALUES(?,?,?,?,?,?,?,?,?,?)",
            [$nombre, $escudo, 0, 0, 0, 0, 0, 0, 0, 0]
        );
    }

    private static function equipoObtenerPorID (int $id): ?Equipo
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

    public static function equipoObtenerTodos(): array // Clasificación 
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Equipo ORDER BY puntos",
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
    public static function equipoFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
	    if ($nuevaEntrada) {
            $equipoNombre = "<introduzca nombre>";
            $escudo= "";
            $puntos = 0;
            $partidosJugados = 0;
            $victoias = 0;
            $empates = 0;
            $derrotas = 0;
            $golesFavor = 0;
            $golesContra = 0;
            $diferenciaGoles = 0;
	    } else {
            $rs= self::ejecutarConsulta(
                "SELECT * FROM Equipo WHERE id_Equipo=?",
                [$id]
            );
            $equipoNombre = $rs[0]["nombre"];
            $escudo = $rs[0]["escudo"];
            $puntos = $rs[0]["puntos"];
            $partidosJugados = $rs[0]["partidos_Jugados"];
            $victoias = $rs[0]["victorias"];
            $empates = $rs[0]["empates"];
            $derrotas = $rs[0]["derrotas"];
            $golesFavor = $rs[0]["goles_Favor"];
            $golesContra = $rs[0]["goles_Contra"];
            $diferenciaGoles = $rs[0]["diferencia_Goles"];
	    }
        
        return [$nuevaEntrada, $equipoNombre, $puntos, $partidosJugados, $victoias, $empates, $derrotas, $golesFavor, $golesContra, $diferenciaGoles, $escudo];
    }
                        ////////////// Arbitro//////////
    private static function arbitroCrearDesdeRs(array $rs): Arbitro
    {
        return new Arbitro($rs["id_Arbitro"], $rs["nombre"], $rs["apellidos"]);
    }
   public static function arbitroCrear(string $nombre, string $apellidos):bool
   {
    return self::ejecutarActualizacion(
        "INSERT INTO Arbitro (nombre,apellidos) VALUES(?,?)",
        [$nombre, $apellidos]
    );
   }
   
   public static function arbitroObtenerTodos(): array // Clasificación 
   {
       $datos = [];
       $rs = self::ejecutarConsulta(
           "SELECT * FROM Arbitro",
           []
       );
       foreach ($rs as $arbitro) {
           $arbitros = self::arbitroCrearDesdeRs($arbitro);
           array_push($datos, $arbitros);
       }
       return $datos;
   }
}
