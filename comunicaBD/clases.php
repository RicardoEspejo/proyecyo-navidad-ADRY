<?php

abstract class Dato
{
}

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

class Equipo extends Dato
{
    use Identificable;

    private string $nombre;
    private string $escudo;
    private int $puntos;
    private int $partidos_Jugados;
    private int $victorias;
    private int $empates;
    private int $derrotas;
    private int $goles_Favor;
    private int $goles_Contra;
    private int $diferencia_Goles;

    public function __construct(int $id2, string $nombre2, string $escudo2, int $puntos2, int $partidosJugados2, int $victorias2, int $empates2, int $derrotas2, int $golesFavor2, int $golesContra2, int $diferenciaGoles2)
    {
        $this->setId($id2);
        $this->setNombre($nombre2);
        $this->setEscudo($escudo2);
        $this->setPuntos($puntos2);
        $this->setPartidosJugados($partidosJugados2);
        $this->setVictorias($victorias2);
        $this->setEmpates($empates2);
        $this->setDerrotas($derrotas2);
        $this->setGolesFavor($golesFavor2);
        $this->setGolesContra($golesContra2);
        $this->setDiferenciaGoles($diferenciaGoles2);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getEscudo(): string
    {
        return $this->escudo;
    }

    public function setEscudo(string $escudo)
    {
        $this->escudo = $escudo;
    }

    public function getPuntos(): int
    {
        return $this->puntos;
    }

    public function setPuntos(int $puntos)
    {
        $this->puntos = $puntos;
    }

    public function getPartidosJugados(): int
    {
        return $this->partidos_Jugados;
    }

    public function setPartidosJugados(int $partidosJugados)
    {
        $this->partidos_Jugados = $partidosJugados;
    }

    public function getVictorias(): int
    {
        return $this->victorias;
    }

    public function setVictorias(int $victorias)
    {
        $this->victorias = $victorias;
    }

    public function getEmpates(): int
    {
        return $this->empates;
    }

    public function setEmpates(int $empates)
    {
        $this->empates = $empates;
    }

    public function getDerrotas(): int
    {
        return $this->derrotas;
    }

    public function setDerrotas(int $derrotas)
    {
        $this->derrotas = $derrotas;
    }

    public function getGolesFavor(): int
    {
        return $this->goles_Favor;
    }

    public function setGolesFavor(int $golesFavor)
    {
        $this->goles_Favor = $golesFavor;
    }

    public function getGolesContra(): int
    {
        return $this->goles_Contra;
    }

    public function setGolesContra(int $golesContra)
    {
        $this->goles_Contra = $golesContra;
    }

    public function getDiferenciaGoles(): int
    {
        return $this->diferencia_Goles;
    }

    public function setDiferenciaGoles(int $diferenciaGoles)
    {
        $this->diferencia_Goles = $diferenciaGoles;
    }

}
class Arbitro extends Dato
{
    use Identificable;

    private string $nombre;
    private string $apellidos;
    

    public function __construct(int $id, string $nombre, string $apellidos)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

}
class Partido extends Dato
{
    use Identificable;
    
    private int $id_Equipo_Local;
    private int $id_Equipo_Visitante;
    private string $fecha;
    private int $id_Arbitro;
    private int $gol_Local;
    private int $gol_Visitante;
    private int $ganador;

    public function __construct(int $id, int $id_Equipo_Local, int $id_Equipo_Visitante, string $fecha, int $id_Arbitro, int $gol_Local, int $gol_Visitante, int $ganador)
    {
        $this->setId($id);
        $this->setEquipoLocal($id_Equipo_Local);
        $this->setEquipoVisitante($id_Equipo_Visitante);
        $this->setFecha($fecha);
        $this->setArbitro($id_Arbitro);
        $this->setGolLocal($gol_Local);
        $this->setGolVisitante($gol_Visitante);
        $this->setGanador($ganador);
    }

    public function getEquipoLocal(): int
    {
        return $this->id_Equipo_Local;
    }

    public function setEquipoLocal(int $id_Equipo_Local)
    {
        $this->id_Equipo_Local = $id_Equipo_Local;
    }

    public function getEquipoVisitante(): int
    {
        return $this->id_Equipo_Visitante;
    }

    public function setEquipoVisitante(int $id_Equipo_Visitante)
    {
        $this->id_Equipo_Visitante = $id_Equipo_Visitante;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha)
    {
        $this->fecha = $fecha;
    }

    public function getArbitro(): int
    {
        return $this->id_Arbitro;
    }

    public function setArbitro(int $id_Arbitro)
    {
        $this->id_Arbitro = $id_Arbitro;
    }

    public function getGolLocal(): int
    {
        return $this->gol_Local;
    }

    public function setGolLocal(int $gol_Local)
    {
        $this->gol_Local = $gol_Local;
    }
    
    public function getGolVisitante(): int
    {
        return $this->gol_Visitante;
    }

    public function setGolVisitante(int $gol_Visitante)
    {
        $this->gol_Visitante = $gol_Visitante;
    }

    public function getGanador(): int
    {
        return $this->ganador;
    }

    public function setGanador(int $ganador)
    {
        $this->ganador = $ganador;
    }
}

class Usuario extends Dato
{
    use Identificable;

    private string $identificador;
    private string $contrasenna;
    private bool $tipo;
    // private  $codigoCookie;


    public function __construct(int $id, string $identificador, string $contrasenna, bool $tipo)
    {
        $this->setId($id);
        $this->setIdentificador($identificador); //nombreUsuario
        $this->setContrasenna($contrasenna);
        $this->setTipo($tipo);
        // $this->setCodigoCookie($codigoCookie);
    }

    public function getIdentificador(): string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador)
    {
        $this->identificador = $identificador;
    }

    public function getContrasenna(): string
    {
        return $this->contrasenna;
    }

    public function setContrasenna(string $contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }

    public function getTipo(): bool
    {
        return $this->tipo;
    }

    public function setTipo(bool $tipo)
    {
        $this->tipo = $tipo;
    }

    // public function getCodigoCookie()
    // {
    //     return $this->codigoCookie;
    // }

    // public function setCodigoCookie($codigoCookie)
    // {
    //     $this->codigoCookie = $codigoCookie;
    // }

}
