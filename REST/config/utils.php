<?php

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

    function check($variavel, $metodo, $numero = false) {
        if(!array_key_exists($variavel, $metodo))
            return false;
        if(is_null($metodo[$variavel]))
            return false;
        if(empty(trim($metodo[$variavel])))
            return false;
        if($numero) {
            if((int) $metodo[$variavel])
                return true;
            else
                return false; 
        }
        return true;
    }

?>