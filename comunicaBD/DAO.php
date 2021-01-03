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

    /////////////////EQUIPO///////////////////////
    public static function equipoCrearDesdeRs(array $rs): Equipo
    {
        return new Equipo($rs["id_Equipo"], $rs["nombre"], $rs["escudo"]);
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
    public static function equipoEliminarPorID(int $id): bool
    {
        return self::ejecutarActualizacion(
            "DELETE FROM Equipo WHERE id_Equipo=?",
            [$id]
        );
    }
    public static function equipoActualizarPorID(int $id, string $nombre, string $escudo): bool
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
                redireccionar("arbitroFicha.php?creacionCorrecta&id_Arbitro=$id");
            } else {
                redireccionar("arbitroFicha.php?creacionIncorrecta&id_Arbitro=$id");
            }
        } else {
            $rs = self::arbitroActualizarPorID($id, $nombre, $apellidos);
            if ($rs) {
                redireccionar("arbitroFicha.php?modificacionCorrecta&id_Arbitro=$id");
            } else {
                redireccionar("arbitroFicha.php?modificacionIncorrecta&id_Arbitro=$id");
            }
        }
        return $rs;
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
                        [$idEquipo, $i, "2000-01-01 00:00:00", rand($numero, $arbitroElegido), 0, 0, 0]
                    );
                }
            }
        }
    }
    public static function partidoCrear(
        $id_Equipo_Local,
        $id_Equipo_Visitante,
        $fecha,
        $id_Arbitro
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
            $fecha = "2000-01-01 00:00:00";
            $id_Arbitro = "Introduce el árbitro";
            $gol_Local = 0;
            $gol_Visitante = 0;
            $ganador = 0;
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
        }
        $nombreLocal = self::equipoObtenerNombre($id_Equipo_Local);
        $nombreVisitante = self::equipoObtenerNombre($id_Equipo_Visitante);
        $nombreArbitro = self::arbitroObtenerNombre($id_Arbitro);
        return [$nuevaEntrada, $nombreLocal, $nombreVisitante, $fecha, $nombreArbitro, $gol_Local, $gol_Visitante, $ganador];
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

    public static function partidoActualizarPorID(
        int $id,
        int $id_Equipo_Local,
        int $id_Equipo_Visitante,
        string $fecha,
        int $id_Arbitro,
        int $gol_Local,
        int $gol_Visitante,
        int $ganador
    ): bool {
        return self::ejecutarActualizacion(
            "UPDATE Partido SET id_Equipo_Local=?, id_Equipo_Visitante=?, fecha=?,
             id_Arbitro=?, gol_Local=?, gol_Visitante=?, ganador=? WHERE id_Partido=?",
            [
                $id_Equipo_Local, $id_Equipo_Visitante, $fecha, $id_Arbitro, $gol_Local,
                $gol_Visitante, $ganador, $id_Partido
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
        $arbitroNombre = $nombre ." " .$apellidos;
        return $arbitroNombre;
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


    /////////////USUARIO///////////////////////////////////////////

    //Esta consulta es especialmente para el inicio de sesion
    private static function ejecutarConsultaUsuario(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetch(PDO::FETCH_ASSOC); //Aqui esta la diferencia a las demás

        return $rs;
    }


    public static function usuarioCrearDesdeRs(array $rs): Usuario
    {
        return new Usuario($rs["id_Usuario"], $rs["identificador"], $rs["contrasenna"], $rs["tipo"]);
    }

    public static function usuarioCrear(String $identificador, String $contrasenna, bool $tipo): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO usuario (identificador, contrasenna, tipo) VALUES(?,?,?)",
            [$identificador, $contrasenna, $tipo]
        );
    }

    public static function iniciarSesionUsuario(String $identificador): array
    {
        $datos = [];
        $rs = self::ejecutarConsultaUsuario(
            "SELECT * FROM usuario WHERE identificador=?",
            [$identificador]
        );
        $datos = array($rs["id_Usuario"], $rs["identificador"], $rs["contrasenna"], $rs["tipo"]);
        return $datos;
    }

    // public static function usuarioGuardarCodigoCookie(string $identificador, string $codigoCookie = null)
    // {
    //     if ($codigoCookie != null) {
    //         self::ejecutarActualizacion("UPDATE usuario SET codigoCookie=? WHERE identificador=?", [$codigoCookie, $identificador]);
    //     } else {
    //         self::ejecutarActualizacion("UPDATE usuario SET codigoCookie=NULL WHERE identificador=?", [$identificador]);
    //     }
    // }

    // public static function usuarioObtenerPorIdentificadorYCodigoCookie($identificador, $codigoCookie): ?Usuario
    // {
    //     $rs = self::ejecutarConsulta(
    //         "SELECT * FROM usuario WHERE identificador=? AND BINARY codigoCookie=?",
    //         [$identificador, $codigoCookie]
    //     );
    //     if ($rs) {
    //         return self::usuarioCrearDesdeRs($rs);
    //     } else {
    //         return null;
    //     }
    // }

    // public static function usuarioObtenerPorIdentificadorYcontrasenna($identificador, $contrasenna): ?Usuario
    // {
    //     $rs = Self::ejecutarConsulta(
    //         "SELECT * FROM usuario WHERE identificador=? AND BINARY contrasenna=?",
    //         [$identificador, $contrasenna]
    //     );
    //     if ($rs) {
    //         return self::usuarioCrearDesdeRs($rs);
    //     } else {
    //         return null;
    //     }
    // }
}
