<?php
    require_once(__DIR__ . "/config/header.php");
    require_once(__DIR__ . "/config/utils.php");
    require_once(__DIR__ . "/model/Carro.php");
    require_once(__DIR__ . "/model/Pessoa.php");
    require_once(__DIR__ . "/config/verbs.php");

    if (array_key_exists("id", $_GET)) {
        // Método GET
        if (isMetodo("GET")) {
            $url = explode('/', $_GET['id']);
            switch($url[0]) {
                case "Carros":
                    count($url) == 1 ? $listaGET = Carro::getAll() : $listaGET = Carro::getOne($url[1]);
                    break;
                case "Pessoas":
                    count($url) == 1 ? $listaGET = Pessoa::getAll() : $listaGET = Pessoa::getOne($url[1]);
                    break;
                default:
                    output(404, "Not Found");
            }
            if(count($url) > 1 && count($listaGET) == 0)
                output(404, "Not Found");
            echo json_encode($listaGET);
        // Método POST
        } elseif (isMetodo("POST")) {
            $url = explode('/', $_GET['id']);
            if(count($_POST) == 4) {
                switch($url[0]) {
                    case "Carros":
                        if(check("idPessoa", $_POST, true) &&
                            check("nome", $_POST) &&
                            check("marca", $_POST) &&
                            check("ano", $_POST, true)) {
                            if(Pessoa::exists($_POST["idPessoa"]) == 1) {
                                $linhaPOST = Carro::add($_POST["nome"], $_POST["marca"], $_POST["ano"], $_POST["idPessoa"]);
                                if($linhaPOST == 1) {
                                    $listaPOST = Carro::getAll();
                                    echo json_encode($listaPOST[count($listaPOST) - 1]);
                                    exit;
                                } else {
                                    output(400, "Bad Request");
                                }
                            }
                        }
                        output(406, "Not Acceptable");
                        break;
                    case "Pessoas":
                        if(check("nome") &&
                            check("dia", $_POST, true) &&
                            check("mes", $_POST, true) &&
                            check("ano", $_POST, true)) {
                            if(checkdate($_POST["mes"], $_POST["dia"], $_POST["ano"])) {
                                $linhaPOST = Pessoa::add($_POST["nome"], $_POST["ano"] . "-" . $_POST["mes"] . "/" . $_POST["dia"]);
                                if($linhaPOST == 1) {
                                    $listaPOST = Pessoa::getAll();
                                    echo json_encode($listaPOST[count($listaPOST) - 1]);
                                    exit;
                                } else {
                                    output(400, "Bad Request");
                                }
                            }
                        }
                        output(406, "Not Acceptable");
                        break;
                }
            } else
                output(406, "Not Acceptable");
        // Método PUT
        } elseif (isMetodo("PUT")) {
            $url = explode('/', $_GET['id']);
            if(count($url) == 2) {
                switch($url[0]) {
                    case "Carros":
                        $listaEDITAR = Carro::getOne($url[1]);
                        if(check("nome", $_PUT))
                            $nome = $_PUT["nome"];
                        else
                            $nome = $listaEDITAR[0]["nome"];
                        if(check("marca", $_PUT))
                            $marca = $_PUT["marca"];
                        else
                            $marca = $listaEDITAR[0]["marca"];
                        if(check("ano", $_PUT, true))
                            $ano = $_PUT["ano"];
                        else
                            $ano = $listaEDITAR[0]["ano"];
                        if(check("idPessoa", $_PUT, true))
                            if(Pessoa::exists($_PUT["idPessoa"]))
                                $idPessoa = $_PUT["idPessoa"];
                            else
                                output(406, "Not Acceptable");
                        else
                            $idPessoa = $listaEDITAR[0]["idPessoa"];
                        $linhaEDITAR = Carro::edit($url[1], $nome, $marca, $ano, $idPessoa);
                        if($linhaEDITAR == 1) {
                            $listaEDITAR = Carro::getOne($url[1]);
                            echo json_encode($listaEDITAR[0]);
                        } else {
                            output(400, "Bad Request");
                        }
                        break;
                    case "Pessoas":
                        $listaEDITAR = Pessoa::getOne($url[1]);
                        if(check("nome", $_PUT))
                            $nome = $_PUT["nome"];
                        else
                            $nome = $listaEDITAR[0]["nome"];
                        if(check("dia", $_PUT, true))
                            $dia = $_PUT["dia"];
                        else
                            $dia = date_parse($listaEDITAR[0]["dataNascimento"])['day'];
                        if(check("mes", $_PUT, true))
                            $mes = $_PUT["mes"];
                        else
                            $mes = date_parse($listaEDITAR[0]["dataNascimento"])['month'];
                        if(check("ano", $_PUT, true))
                            $ano = $_PUT["ano"];
                        else
                            $ano = date_parse($listaEDITAR[0]["dataNascimento"])['year'];
                        if(checkdate($mes, $dia, $ano)) {
                            $linhaEDITAR = Pessoa::edit($url[1], $nome, $ano . "-" . $mes . "/" . $dia);
                            if($linhaEDITAR == 1) {
                                $listaEDITAR = Pessoa::getOne($url[1]);
                                echo json_encode($listaEDITAR[0]);
                            } else {
                                output(400, "Bad Request");
                            }
                        } else
                            output(406, "Not Acceptable");
                        break;
                }
            } else {
                output(406, "Not Acceptable");
            }
        // Método DELETE
        } elseif (isMetodo("DELETE")) {
            $url = explode('/', $_GET['id']);
            if(count($url) == 2) {
                switch($url[0]) {
                    case "Carros":
                        $listaDELETE = Carro::getOne($url[1]);
                        $linhaDELETE = Carro::delete($url[1]);
                        if($linhaDELETE == 1) {
                            output(200, "OK");
                        } else {
                            output(400, "Bad Request");
                        }
                        break;
                    case "Pessoas":
                        if(Carro::ForeignKey($url[1]))
                            output(409, "Conflict");
                        $linhaDELETE = Pessoa::delete($url[1]);
                        if($linhaDELETE == 1) {
                            output(200, "OK");
                        } else {
                            output(400, "Bad Request");
                        }
                        break;
                }
            } else {
                output(406, "Not Acceptable");
            }
        } else
            output(405, "Method Not Allowed");
    }
?>