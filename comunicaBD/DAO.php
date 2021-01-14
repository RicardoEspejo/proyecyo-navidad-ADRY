<?php

require_once "varios.php";
require_once "clases.php";
session_start();
class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "ADRYGOL"; // Schema
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

    /////////////////EQUIPO///////////////////////
    public static function equipoCrearDesdeRs(array $rs): Equipo
    {
        $diferenciaGoles = $rs["goles_Favor"] - $rs["goles_Contra"];
        self::equipoActualizarPorId($rs["id_Equipo"], $rs["nombre"], $rs["escudo"], $rs["puntos"], $rs["partidos_Jugados"], $rs["victorias"], $rs["empates"], $rs["derrotas"], $rs["goles_Favor"], $rs["goles_Contra"], $diferenciaGoles);
        return new Equipo($rs["id_Equipo"], $rs["nombre"], $rs["escudo"], $rs["puntos"], $rs["partidos_Jugados"], $rs["victorias"], $rs["empates"], $rs["derrotas"], $rs["goles_Favor"], $rs["goles_Contra"], $diferenciaGoles);
    }

    public static function equipoCrear(String $nombre, String $escudo): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO Equipo (nombre, escudo, puntos, partidos_jugados, victorias, empates, derrotas, goles_Favor, goles_Contra, diferencia_Goles) VALUES(?,?,?,?,?,?,?,?,?,?)",
            [$nombre, $escudo, 0, 0, 0, 0, 0, 0, 0, 0]
        );
    }

    public static function equipoObtenerPorID(int $id): ?Equipo
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

    public static function equipoObtenerTodos(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Equipo",
            []
        );
        foreach ($rs as $fila) {
            $equipo = self::equipoCrearDesdeRs($fila);
            array_push($datos, $equipo);
        }
        return $datos;
    }
    public static function ClasificacionObtener(): array
    {
        $clasificacion = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Equipo ORDER BY puntos DESC, diferencia_Goles DESC",
            []
        );
        foreach ($rs as $fila) {
            $equipo = self::equipoCrearDesdeRs($fila);
            array_push($clasificacion, $equipo);
        }
        return $clasificacion;
    }
    public static function equipoEliminarPorID(int $id): bool
    {
        return self::ejecutarActualizacion(
            "DELETE FROM Equipo WHERE id_Equipo=?",
            [$id]
        );
    }
    public static function equipoActualizarPorId(
        int $id,
        string $nombre,
        string $escudo,
        int $puntos,
        int $partidos_Jugados,
        int $victorias,
        int $empates,
        int $derrotas,
        int $goles_Favor,
        int $goles_Contra,
        int $diferencia_Goles
    ): bool {
        return self::ejecutarActualizacion(
            "UPDATE Equipo SET nombre=?, escudo=?, puntos=?, partidos_Jugados=?, victorias=?, empates=?, derrotas=?, 
            goles_Favor=?, goles_Contra=?, diferencia_Goles=? WHERE id_Equipo=?",
            [
                $nombre, $escudo, $puntos, $partidos_Jugados, $victorias, $empates, $derrotas, $goles_Favor, $goles_Contra,
                $diferencia_Goles, $id
            ]
        );
    }
    public static function equipoFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
        if ($nuevaEntrada) {
            $equipoNombre = "<introduzca nombre>";
            $escudo = "";
            $puntos = 0;
            $partidosJugados = 0;
            $victorias = 0;
            $empates = 0;
            $derrotas = 0;
            $golesFavor = 0;
            $golesContra = 0;
            $diferenciaGoles = 0;
        } else {
            $rs = self::ejecutarConsulta(
                "SELECT * FROM Equipo WHERE id_Equipo=?",
                [$id]
            );
            $equipoNombre = $rs[0]["nombre"];
            $escudo = $rs[0]["escudo"];
            $puntos = $rs[0]["puntos"];
            $partidosJugados = $rs[0]["partidos_Jugados"];
            $victorias = $rs[0]["victorias"];
            $empates = $rs[0]["empates"];
            $derrotas = $rs[0]["derrotas"];
            $golesFavor = $rs[0]["goles_Favor"];
            $golesContra = $rs[0]["goles_Contra"];
            $diferenciaGoles = $rs[0]["diferencia_Goles"];
        }

        return [$nuevaEntrada, $equipoNombre, $puntos, $partidosJugados, $victorias, $empates, $derrotas, $golesFavor, $golesContra, $diferenciaGoles, $escudo];
    }

    /////////////////ÁRBITRO///////////////////////
    private static function arbitroCrearDesdeRs(array $rs): Arbitro
    {
        return new Arbitro($rs["id_Arbitro"], $rs["nombre"], $rs["apellidos"]);
    }
    public static function arbitroCrear(string $nombre, string $apellidos): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO Arbitro (nombre,apellidos) VALUES(?,?)",
            [$nombre, $apellidos]
        );
    }
    private static function arbitroActualizarPorID(int $id, string $nombre, string $apellidos): bool
    {
        return self::ejecutarActualizacion(
            "UPDATE Arbitro SET nombre=?, apellidos=? WHERE id_Arbitro=?",
            [$nombre, $apellidos, $id]
        );
    }
    public static function arbitroObtenerTodos(): array
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
    public static function arbitroNuevaEntrada(int $id): bool
    {
        return $id == -1;
    }

    public static function arbitroFicha($id): Arbitro
    {
        $nuevaEntrada = self::arbitroNuevaEntrada($id);
        if ($nuevaEntrada) {
            $nombreArbitros = "<introduzca el nombre>";
            $apellidosArbitro = "<introduzca los apellidos>";
        } else {
            $rs = self::ejecutarConsulta("SELECT * FROM Arbitro WHERE id_Arbitro=?", [$id]);
            $nombreArbitros = $rs[0]["nombre"];
            $apellidosArbitro = $rs[0]["apellidos"];
        }
        return new Arbitro($id, $nombreArbitros, $apellidosArbitro);
    }

    public static function arbitrosGuardar(int $id, string $nombre, string $apellidos): bool
    {
        $nuevaEntrada = self::arbitroNuevaEntrada($id);

        if ($nuevaEntrada) {
            $rs = self::arbitroCrear($nombre, $apellidos);
            if ($rs) {
                redireccionar("arbitroListado.php?creacionCorrecta");
            } else {
                redireccionar("arbitroListado.php?creacionIncorrecta");
            }
            return $rs;
        } else {
            $rs = self::arbitroActualizarPorID($id, $nombre, $apellidos);
            if ($rs) {
                redireccionar("arbitroFicha.php?modificacionCorrecta&id_Arbitro=$id");
            } else {
                redireccionar("arbitroFicha.php?modificacionIncorrecta&id_Arbitro=$id");
            }
            return $rs;
        }
    }
    public static function arbitrosEliminarPorID(int $id)
    {
        $rs = self::ejecutarActualizacion(
            "DELETE FROM Arbitro WHERE id_Arbitro=?",
            [$id]
        );
        if ($rs) {
            redireccionar("arbitroListado.php?eliminacionCorrecta");
        } else {
            redireccionar("arbitroListado.php?eliminacionIncorrecta");
        }
    }

    /////////////////PARTIDO///////////////////////
    public static function sorteo()
    {
        $arbitro = self::arbitroObtenerTodos();
        $equipo = self::equipoObtenerTodos();
        $numEquipos = count($equipo);
        $numero = 1;
        foreach ($equipo as $equipos) {
            $idEquipo = $equipos->getId();
            foreach ($arbitro as $arbitros) {
                $arbitroElegido = $arbitros->getId();
            }
            for ($i = 11; $i < ($numEquipos + 11); $i++) {
                if ($idEquipo != $i) {
                    DAO::ejecutarActualizacion(
                        "INSERT INTO Partido (id_Equipo_Local, id_Equipo_Visitante, fecha, id_Arbitro, gol_Local, gol_Visitante, ganador) VALUES(?,?,?,?,?,?,?)",
                        [$idEquipo, $i, "2000-01-01", rand($numero, $arbitroElegido), 0, 0, -1]
                    );
                }
            }
        }
    }
    public static function partidoCrear(
        $id_Equipo_Local,
        $id_Equipo_Visitante,
        $fecha,
        $id_Arbitro,
        $gol_Local,
        $gol_Visitante,
        $ganador
    ): bool {
        return self::ejecutarActualizacion(
            "INSERT INTO Partido (id_Equipo_Local, id_Equipo_Visitante, fecha, id_Arbitro,
            gol_Local, gol_Visitante, ganador) VALUES(?,?,?,?,?,?,?)",
            [
                $id_Equipo_Local, $id_Equipo_Visitante, $fecha, $id_Arbitro, $gol_Local,
                $gol_Visitante, $ganador
            ]
        );
    }
    private static function partidoCrearDesdeRs(array $rs): Partido
    {
        return new Partido(
            $rs["id_Partido"],
            $rs["id_Equipo_Local"],
            $rs["id_Equipo_Visitante"],
            $rs["fecha"],
            $rs["id_Arbitro"],
            $rs["gol_Local"],
            $rs["gol_Visitante"],
            $rs["ganador"]
        );
    }
    public static function partidoFicha($id): array
    {
        $nuevaEntrada = ($id == -1);
        if ($nuevaEntrada) {
            $id_Equipo_Local = "Introduce el equipo local";
            $id_Equipo_Visitante = "Introduce el equipo visitante";
            $fecha = "2000-01-01";
            $id_Arbitro = "Introduce el árbitro";
            $gol_Local = 0;
            $gol_Visitante = 0;
            $ganador = 0;
            return [
                $nuevaEntrada, $id_Equipo_Local, $id_Equipo_Visitante, $fecha,
                $id_Arbitro, $gol_Local, $gol_Visitante, $ganador
            ];
        } else {
            $rs = self::ejecutarConsulta(
                "SELECT * FROM Partido WHERE id_Partido=?",
                [$id]
            );
            $id_Equipo_Local = $rs[0]["id_Equipo_Local"];
            $id_Equipo_Visitante = $rs[0]["id_Equipo_Visitante"];
            $fecha = $rs[0]["fecha"];
            $id_Arbitro = $rs[0]["id_Arbitro"];
            $gol_Local = $rs[0]["gol_Local"];
            $gol_Visitante = $rs[0]["gol_Visitante"];
            $ganador = $rs[0]["ganador"];
            return [
                $nuevaEntrada, $id_Equipo_Local, $id_Equipo_Visitante, $fecha,
                $id_Arbitro, $gol_Local, $gol_Visitante, $ganador
            ];
        }
    }
    public static function partidoObtenerTodos(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Partido",
            []
        );
        foreach ($rs as $partido) {
            $partidos = self::partidoCrearDesdeRs($partido);
            array_push($datos, $partidos);
        }
        return $datos;
    }

    public static function partidoEliminarPorID(int $id): bool
    {
        return self::ejecutarActualizacion(
            "DELETE FROM Partido WHERE id_Partido=?",
            [$id]
        );
    }

    public static function partidoActualizarGanador($ganador, $id_Partido)
    {
        self::ejecutarActualizacion("UPDATE Partido SET ganador=? WHERE id_Partido=? ", [$ganador, $id_Partido]);
    }

    public static function partidoActualizarPorID(
        int $id_Partido,
        int $id_Equipo_Local,
        int $id_Equipo_Visitante,
        string $fecha,
        int $id_Arbitro,
        int $gol_Local,
        int $gol_Visitante
    ): bool {
        return self::ejecutarActualizacion(
            "UPDATE Partido SET id_Equipo_Local=?, id_Equipo_Visitante=?, fecha=?,
             id_Arbitro=?, gol_Local=?, gol_Visitante=? WHERE id_Partido=?",
            [
                $id_Equipo_Local, $id_Equipo_Visitante, $fecha, $id_Arbitro, $gol_Local,
                $gol_Visitante, $id_Partido
            ]
        );
    }

    public static function equipoObtenerNombre(int $id)
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Equipo WHERE id_Equipo=?",
            [$id]
        );
        $equipoNombre = $rs[0]["nombre"];
        return $equipoNombre;
    }

    public static function arbitroObtenerNombre(int $id)
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Arbitro WHERE id_Arbitro=?",
            [$id]
        );
        $nombre = $rs[0]["nombre"];
        $apellidos = $rs[0]["apellidos"];
        $arbitroNombre = $nombre . " " . $apellidos;
        return $arbitroNombre;
    }

    public static function partidoSelectEquipos(): array
    {
        $rs = self::ejecutarConsulta(
            "SELECT id_Equipo, nombre FROM Equipo order by nombre",
            []
        );
        return $rs;
    }

    public static function partidoSelectArbitros(): array
    {
        $rs = self::ejecutarConsulta(
            "SELECT id_Arbitro, nombre, apellidos FROM Arbitro order by nombre",
            []
        );
        return $rs;
    }

    public static function establecerVictoriaLocal(int $id, int $gol_Local, int $gol_Visitante, int $id_Partido)
    {
        $equipo = self::equipoObtenerPorID($id);
        $partido = self::partidoFicha($id_Partido);
        $ganador = $partido[7];

        $id = $equipo->getId();
        $nombre = $equipo->getNombre();
        $escudo = $equipo->getEscudo();
        
        //Como el partido no se habia jugado se suman 3 puntos, 1 partido jugado y los goles
        if($ganador == -1) {
            $puntos = (int) $equipo->getPuntos() + 3;
            $partidos_Jugados = (int) $equipo->getPartidosJugados() + 1;
            $victorias = (int) $equipo->getVictorias() + 1;
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }
        if($ganador == 0) { //Se habia jugado, era un empate por lo que hay que sumar solo 2 puntos, se suma 1 victoria y se resta un empate
            $puntos = (int) $equipo->getPuntos() + 2;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() + 1;
            $empates = $equipo->getEmpates() - 1;
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 1) { //Habia ganado el local, entonces solo se suman los goles
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 2) { //Habia ganado el visitante, entonces se le suman 3 puntos, se le suma una victoria y se le resta un empate
            $puntos = (int) $equipo->getPuntos() + 3;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() + 1;
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas() - 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }

        self::equipoActualizarPorId(
            $id,
            $nombre,
            $escudo,
            $puntos,
            $partidos_Jugados,
            $victorias,
            $empates,
            $derrotas,
            $goles_Favor,
            $goles_Contra,
            $diferencia_Goles
        );
        
    }
        
    public static function establecerVictoriaVisitante(int $id, int $gol_Local, int $gol_Visitante, int $id_Partido)
    {
        $equipo = self::equipoObtenerPorId($id);
        $partido = self::partidoFicha($id_Partido);
        $ganador = $ganador = $partido[7];

        $id = $equipo->getId();
        $nombre = $equipo->getNombre();
        $escudo = $equipo->getEscudo();
        if($ganador == -1) { //No se habia jugado asique se suman 3 puntos, el partido jugado y la vistoria
            $puntos = (int) $equipo->getPuntos() + 3;
            $partidos_Jugados = (int) $equipo->getPartidosJugados() + 1;
            $victorias = (int) $equipo->getVictorias() + 1;
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 0) { //era empate, asique se suman los 2 puntos que faltan, se suma una victoria y se resta un empate
            $puntos = (int) $equipo->getPuntos() + 2;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() + 1;
            $empates = $equipo->getEmpates() - 1;
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 1) { //habia ganado el visitante, por lo que hay que sumar 3 puntos y una victoria, y quitar una derrota
            $puntos = (int) $equipo->getPuntos() + 3;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() + 1;
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas() - 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 2) { //Habia ganado el visitante por lo que solo hay que sumar los goles
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }
        
        self::equipoActualizarPorId(
            $id,
            $nombre,
            $escudo,
            $puntos,
            $partidos_Jugados,
            $victorias,
            $empates,
            $derrotas,
            $goles_Favor,
            $goles_Contra,
            $diferencia_Goles
        );
    }

    public static function establecerEmpateLocal(int $id, int $gol_Local, int $gol_Visitante, int $id_Partido)
    {
        $equipo = self::equipoObtenerPorID($id);
        $partido = self::partidoFicha($id_Partido);
        $ganador = $ganador = $partido[7];

        $id = $equipo->getId();
        $nombre = $equipo->getNombre();
        $escudo = $equipo->getEscudo();
        if($ganador == 0) {
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 1) {
            $puntos = (int) $equipo->getPuntos() - 2;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() - 1;
            $empates = $equipo->getEmpates() + 1;
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 2) {
            $puntos = (int) $equipo->getPuntos() + 1;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates() + 1;
            $derrotas = $equipo->getDerrotas() - 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == -1) {
            $puntos = (int) $equipo->getPuntos() + 1;
            $partidos_Jugados = (int) $equipo->getPartidosJugados() + 1;
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates() + 1;
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }
        self::equipoActualizarPorId(
            $id,
            $nombre,
            $escudo,
            $puntos,
            $partidos_Jugados,
            $victorias,
            $empates,
            $derrotas,
            $goles_Favor,
            $goles_Contra,
            $diferencia_Goles
        );
        
    }

    public static function establecerEmpateVisitante(int $id, int $gol_Local, int $gol_Visitante, int $id_Partido)
    {
        $equipo = self::equipoObtenerPorID($id);
        $partido = self::partidoFicha($id_Partido);
        $ganador = $ganador = $partido[7];

        $id = $equipo->getId();
        $nombre = $equipo->getNombre();
        $escudo = $equipo->getEscudo();
        if($ganador == 0) {
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 1) {
            $puntos = (int) $equipo->getPuntos() + 1;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates() + 1;
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 2) {
            $puntos = (int) $equipo->getPuntos() - 2;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() - 1;
            $empates = $equipo->getEmpates() + 1;
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == -1) {
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados() + 1;
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates() + 1;
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }

        self::equipoActualizarPorId(
            $id,
            $nombre,
            $escudo,
            $puntos,
            $partidos_Jugados,
            $victorias,
            $empates,
            $derrotas,
            $goles_Favor,
            $goles_Contra,
            $diferencia_Goles
        );
        
    }

    public static function establecerDerrotaLocal(int $id, int $gol_Local, int $gol_Visitante, int $id_Partido)
    {
        $equipo = self::equipoObtenerPorID($id);
        $partido = self::partidoFicha($id_Partido);
        $ganador = $ganador = $partido[7];

        $id = $equipo->getId();
        $nombre = $equipo->getNombre();
        $escudo = $equipo->getEscudo();
        if($ganador == 0) {
            $puntos = (int) $equipo->getPuntos() - 1;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates() - 1;
            $derrotas = $equipo->getDerrotas() + 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 1) {
            $puntos = (int) $equipo->getPuntos() - 3;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() - 1;
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas() + 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 2) {
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == -1) {
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados() + 1;
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas() + 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Local;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Visitante;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }
        self::equipoActualizarPorId(
            $id,
            $nombre,
            $escudo,
            $puntos,
            $partidos_Jugados,
            $victorias,
            $empates,
            $derrotas,
            $goles_Favor,
            $goles_Contra,
            $diferencia_Goles
        );
        
    }

    public static function establecerDerrotaVisitante(int $id, int $gol_Local, int $gol_Visitante, int $id_Partido)
    {
        $equipo = self::equipoObtenerPorID($id);
        $partido = self::partidoFicha($id_Partido);
        $ganador = $ganador = $partido[7];

        $id = $equipo->getId();
        $nombre = $equipo->getNombre();
        $escudo = $equipo->getEscudo();
        if($ganador == 0) {
            $puntos = (int) $equipo->getPuntos() - 1;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates() - 1;
            $derrotas = $equipo->getDerrotas() + 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 1) {
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas();
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == 2) {
            $puntos = (int) $equipo->getPuntos() - 3;
            $partidos_Jugados = (int) $equipo->getPartidosJugados();
            $victorias = (int) $equipo->getVictorias() - 1;
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas() + 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }elseif($ganador == -1) {
            $puntos = (int) $equipo->getPuntos();
            $partidos_Jugados = (int) $equipo->getPartidosJugados() + 1;
            $victorias = (int) $equipo->getVictorias();
            $empates = $equipo->getEmpates();
            $derrotas = $equipo->getDerrotas() + 1;
            $goles_Favor = (int) $equipo->getGolesFavor() + $gol_Visitante;
            $goles_Contra = (int) $equipo->getGolesContra() + $gol_Local;
            $diferencia_Goles = $equipo->getDiferenciaGoles();
        }
        self::equipoActualizarPorId(
            $id,
            $nombre,
            $escudo,
            $puntos,
            $partidos_Jugados,
            $victorias,
            $empates,
            $derrotas,
            $goles_Favor,
            $goles_Contra,
            $diferencia_Goles
        );
    }

    /////////////////BUSCAR ÁRBITROS///////////////////////
    public static function buscarArbitros(string $palabra, int $numPalabras): array
    {
        $datos = [];
        if (!empty($palabra)) {
            if ($numPalabras == 1) {
                $rs = self::ejecutarConsulta("SELECT * FROM Arbitro WHERE nombre LIKE '%$palabra%' OR apellidos LIKE '%$palabra%'", []);
                foreach ($rs as $arbitro) {
                    $arbitros = self::arbitroCrearDesdeRs($arbitro);
                    array_push($datos, $arbitros);
                }
            } else {
                $rs = self::ejecutarConsulta("SELECT * , MATCH (nombre,apellidos) AGAINST ('$palabra') FROM Arbitro WHERE MATCH (nombre, apellidos) AGAINST ('$palabra')", []);
                foreach ($rs as $arbitro) {
                    $arbitros = self::arbitroCrearDesdeRs($arbitro);
                    array_push($datos, $arbitros);
                }
            }
        } else {
            redireccionar("ArbitroListado.php");
        }
        return $datos;
    }

    public static function buscarEquipos(string $palabra): array
    {
        $datos = [];
            $rs = self::ejecutarConsulta("SELECT * FROM Equipo WHERE nombre LIKE '%$palabra%' OR escudo LIKE '%$palabra%' OR puntos LIKE '%$palabra%' OR partidos_Jugados LIKE '%$palabra%' OR victorias LIKE '%$palabra%' OR empates LIKE '%$palabra%' OR derrotas LIKE '%$palabra%' OR goles_Favor LIKE '%$palabra%' OR goles_Contra LIKE '%$palabra%' OR diferencia_Goles LIKE '%$palabra%'", []);
            foreach ($rs as $equipo) {
                $equipos = self::EquipoCrearDesdeRs($equipo);
                array_push($datos, $equipos);
            }
        
        return $datos;
    }

    public static function buscarPartidos(string $palabra): array
    {
        $datos = [];
        if (!empty($palabra)) {
            $rs = self::ejecutarConsulta("SELECT q.id_Equipo,q.nombre,a.id_Arbitro ,a.nombre ,a.apellidos ,p.id_Equipo_Local ,p.id_Equipo_Visitante ,p.id_Arbitro ,p.fecha ,p.ganador,p.id_Partido,p.gol_Local,p.gol_Visitante,q2.id_Equipo,q2.nombre
            FROM Partido AS p 
                INNER JOIN Equipo AS q ON p.id_Equipo_Local = q.id_Equipo
                INNER JOIN Equipo AS q2 ON p.id_Equipo_Visitante = q2.id_Equipo
                INNER JOIN Arbitro AS a ON p.id_Arbitro = a.id_Arbitro
            WHERE q.nombre LIKE '%$palabra%' OR a.nombre LIKE '%$palabra%' OR a.apellidos LIKE '%$palabra%' OR p.fecha LIKE '%$palabra%' OR p.ganador LIKE '%$palabra%' OR q2.nombre LIKE '%$palabra%'", []);
            foreach ($rs as $partido) {
                $partidos = self::partidoCrearDesdeRs($partido);
                array_push($datos, $partidos);
            }
        } else {
            redireccionar("partidoListado.php");
        }
        return $datos;
    }

    /////////////USUARIO///////////////////////////////////////////

    //Esta consulta es especialmente para el inicio de sesion de usuarios
    private static function ejecutarConsultaUsuario(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetch(PDO::FETCH_ASSOC); //Aqui esta la diferencia a las demás
        if(!$rs) {
            $resultado= [];
        } else {
            $resultado= $rs;
        }
        return $resultado;
    }

    //Creamos el objeto Usuario
    public static function usuarioCrearDesdeRs(array $rs): Usuario
    {
        return new Usuario($rs["id_Usuario"], $rs["identificador"], $rs["contrasenna"], $rs["tipo"]);
    }

    //Creamos el usuario y lo almacenamos en la base de datos
    public static function usuarioCrear(String $identificador, String $contrasenna, bool $tipo): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO usuario (identificador, contrasenna, tipo) VALUES(?,?,?)",
            [$identificador, $contrasenna, $tipo]
        );

        // los parametros que obtenemos son los qeu almacenamos en la base de datos
    }

    public static function iniciarSesionUsuario(String $identificador): array
    {
        $datos = [];

        //obtenemos al usaurio desde identificador
        $rs = self::ejecutarConsultaUsuario(
            "SELECT * FROM usuario WHERE identificador=?",
            [$identificador]
        );

        //comprobamos que existe el usuario
        if($rs) {
            //almacenamos al usaurio en el array datos
            $datos = array($rs["id_Usuario"], $rs["identificador"], $rs["contrasenna"], $rs["tipo"]);
            //comprobamos el tipo de usuario 
            if ($datos[3] == 1) {
                // si es 1 va a ser administrador
                $_SESSION["tipo"] = 1;
            } else {
                // si es 0 va a ser usuario
                $_SESSION["tipo"] = 0;
            }
        } else
            $datos= [];
        
        // devolvemos el usuario en array
        return $datos;
    }

    public static function ObtenerSesionIniciada($id): array
    {
        // Aqui obtenemos la sesion y comprobamos que esta iniciada desde el id_usuario que reciboimos
        $datos = [];
        $rs = self::ejecutarConsultaUsuario(
            "SELECT * FROM usuario WHERE id_Usuario=?",
            [$id]
        );
        $datos = array($rs["id_Usuario"], $rs["identificador"], $rs["contrasenna"], $rs["tipo"]);
        // devolvemos el usuario en array
        return $datos;
    }

    public static function CerrarSesion()
    {
        // funcion que elimina sesion iniciada
        session_start();
        session_unset();
        session_destroy();
    }

    ///Modo Claro o Oscuro
    public static function modoClaroOscuro(string $modo)
    {
        if ($modo == "oscuro") {
            $_SESSION["tema"] = "oscuro";
        } else {
            $_SESSION["tema"] = "claro";
        }
    }
}
