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

    public function __construct(int $id, string $nombre, string $escudo)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setEscudo($escudo);
        $this->setPuntos(0);
        $this->setPartidosJugados(0);
        $this->setVictorias(0);
        $this->setEmpates(0);
        $this->setDerrotas(0);
        $this->setGolesFavor(0);
        $this->setGolesContra(0);
        $this->setDiferenciaGoles(0);
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