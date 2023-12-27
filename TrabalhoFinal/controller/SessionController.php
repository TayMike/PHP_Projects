<?php

require_once(__DIR__ . "/../config/utils.php");
require_once(__DIR__ . "/../models/Sessao.php");


class SessionController{
    private $sessao;
    private $userLogin;



    public function __construct($userLogin, $sessao) {
        $this->sessao = $sessao;
    }

    


    public function login($parametros) {
        if(isset($_SESSION["id"]))
            output(400, "Você está em logado em uma conta!","ERRO");
        if(!parametrosValidos($parametros, ["userLogin", "senha"]))
            output(400, "Não foi enviado todos os parametros necessários.","ERRO");
        if(!Usuario::exists($parametros["userLogin"])){
            $login = $parametros["userLogin"];
            output(400, "Não existe usuário com login ","ERRO");
        }
        $userId = Usuario::getUserId($parametros["userLogin"]);
        if(Session::isUserLoggedIn($userId))
            output(400, "Este usuário já está logando","ERRO");
        $hash = Usuario::VerificarLogin($parametros["userLogin"]);
        if(!password_verify($parametros["senha"], $hash)) {
            output(400, "Senha inválida!" , "ERRO");
        }
        else {
            Session::createSession(Usuario::listar($parametros["userLogin"])[0]['id']);
            output(200, "Usuário logado!" , "SUCESSO");
        }
    }

    public function logout($parametros){
        if(!isset($_SESSION["id"]))
            output(404, "Você não está logado em nenhuma conta","ERRO");
        if(Usuario::exists($parametros["userLogin"]))
            Session::logout($_SESSION["id"]);
        session_destroy();
        output(200, "Usuário desconectado com sucesso!", "SUCESSO");
    }
    
}


?>