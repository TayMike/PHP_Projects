<?php

function msgBD($mensagem) {
    echo "<div class='container'>";
    echo "<div class='box has-text-centered'>";
    echo "<div class='field'>";
    echo "<p>" . $mensagem . "</p>";
    echo "</div>";
    echo "<a class='button is-link' href=index.php>Voltar</a>";
    echo "</div>";
    echo "</div>";
}

function parametrosValidos($metodo, $lista)
{
    $obtidos = array_keys($metodo);
    $nao_encontrados = array_diff($lista, $obtidos);
    if (empty($nao_encontrados)) {
        foreach ($lista as $p) {
            if (empty(trim($metodo[$p]))) {
                return false;
            }
        }
        return true;
    }
    return false;
}


function isMetodo($metodo)
{
    if (!strcasecmp($_SERVER['REQUEST_METHOD'], $metodo)) {
        return true;
    }
    return false;
}


function output($codigo, $msg)
{
    http_response_code($codigo);
    echo json_encode($msg);
    exit;
}
