<?php

require_once(__DIR__ . "/../config/utils.php");
require_once(__DIR__ . "/../models/Usuario.php");


class SessionController{
    private $sessao;
    private $userLogin;



    public function __construct($userLogin, $sessao) {
        $this->sessao = $sessao;
        $this->userLogin = $userLogin;
    }

    


    public function cadastrar($parametros) {
        if(Usuario::exists($this->userLogin)) output(400, "Esse login de usuario já esta em uso!", "ERRO");
        if(strlen($this->userLogin) > 40) output(400,"O login do usuario ultrapassa o tamanho máximo de caracteres!", "ERRO");
        $parametrosPost = parametrosJson() + parametrosPost();
        if(!parametrosValidos($parametrosPost, ["nome", "senha"])) output(400, "Os parametros obrigatorios nao foram passados", "ERRO");
        $userLogin = $this->userLogin->cadastrar($parametrosPost["nome"], $parametrosPost["senha"]);
        if(!$userLogin) output(400, "Houve algum problema no cadastro de alimento", "ERRO");
        output(200, "usuário cadastrada", "OK", $userLogin);
    }

    public function editar($parametros){ 
        $userLogin = $this->userLogin->listar($parametros["userLogin"]);
        if(!$userLogin)
            output(404, "Não há usuária cadastrado com o login fornecido!", "ERRO");
        if(!Usuario::exists($_SESSION["id"]))
            output(401, "Essa ação é permitada apenas para usuários logados!", "ERRO");   
        if($parametros["userLogin"] != Session::getUser($_SESSION["id"]))
            output(400, "Não é possível editar um usuário caso vocÊ não esteja logado na respectiva conta", "ERRO");
        $parametrosPost = parametrosJson() + parametrosPost();
        if(!parametrosValidos($parametros, ["userLogin", "senha", "newUserLogin"]))
            output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
        
        $user = $this->userLogin->editar($parametros["userLogin"], $parametrosPost["senha"], $parametrosPost["newUserLogin"]);
        if(!$user)
            output(500, "Houve algum problema ao editar usuário", "ERRO");
        output(200, "Usuário Editada", "OK", $user);
    }

    public function deletar($parametros){
        $userLogin = $this->userLogin->listar($parametros["userLogin"]);
        if(!$userLogin)
            output(404, "Não há usuária cadastrado com o login fornecido!", "ERRO");
        if(!Usuario::exists($_SESSION["id"]))
            output(401, "Essa ação é permitada apenas para usuários logados!", "ERRO"); 
        if($parametros["userLogin"] != Session::getUser($_SESSION["id"]))
            output(400, "Não é possível editar um usuário caso vocÊ não esteja logado na respectiva conta", "ERRO");
        if(!parametrosValidos($parametros, ["userLogin"]))
            output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
        $this->sessao->deletar($_SESSION["id"]);
        session_destroy();
        $usuário = $this->userLogin->deletar($parametros["userLogin"]);
        output(200, "Usuário deletada. Você não esta mais logado em nenhuma conta.", "OK", $usuário);
    }
    
}


?>