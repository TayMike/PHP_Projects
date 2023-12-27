<?php

function parametrosValidos($valores, $lista)
{
    $obtidos = array_keys($valores);
    $nao_encontrados = array_diff($lista, $obtidos);
    if (empty($nao_encontrados)) {
        foreach ($lista as $p) {
            if (empty(trim($valores[$p]))) {
                return false;
            }
        }
        return true;
    }
    return false;
}

function parametrosJson() {
    $postData = json_decode(file_get_contents('php://input'), true);
    print_r("\n\n\nfile_get_contents");
    print_r(file_get_contents('php://input'));
    print_r("\n\n\n\npostData");
    print_r($postData);
    return !empty($postData) ? $postData : [];
}

function parametrosGet() {
    return $_GET;
}

function parametrosPost() {
    print_r("\n\n\n\_POST");
    print_r($_POST);
    return $_POST;
}

function output($codigo, $msg, $status, $resultado = null,)
{
    http_response_code($codigo);
    echo json_encode([
        "status" => $status,
        "msg" => $msg,
        "resultado" => $resultado
    ]);
    exit;
}
