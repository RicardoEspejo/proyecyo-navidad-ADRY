<?php

//Metodo para redireccionar los archivos
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

//genera una cadena aleatoria para las cookies

function generarCadenaAleatoria(int $longitud): string
{
    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1; $i != $longitud; $x = rand(0, $z), $s .= $a[$x], $i++);
    return $s;
}
