<?php

function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}