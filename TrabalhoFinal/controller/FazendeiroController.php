<?php
    require_once(__DIR__ . "/../config/utils.php");
    require_once(__DIR__ . "/../models/Plantacao.php");

    class FazendeiroController{
        private $fazendeiro;
        private $plantacao;
    
        public function __construct($fazendeiro) {
            $this->fazendeiro = $fazendeiro;
            $this->plantacao = New Plantacao();
        }

        public function listartodos(){
            $fazendeiros = $this->fazendeiro->listartodos();
            if(!$fazendeiros) output(404, "Sem retorno para fazendeiros", "ERRO");
            output(200, "fazendeiros encontrados", "OK", $fazendeiros);
        }
    
        public function listar($parametros) {
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $fazendeiro = $this->fazendeiro->listar($parametros["id"]);
            if(!$fazendeiro) output(404, "Sem retorno para esse ID", "ERRO");
            output(200, "fazendeiro encontrado", "OK", $fazendeiro);
        }

        public function cadastrar($parametros) {
            $parametrosPost = parametrosJson() + parametrosPost();
            if(!parametrosValidos($parametrosPost, ["nome", "dataCadastro"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $fazendeiro = $this->fazendeiro->cadastrar($parametrosPost["nome"], $parametrosPost["dataCadastro"]);
            if(!$fazendeiro) output(404, "Houve algum problema no cadastro de fazendeiro", "ERRO");
            output(200, "fazendeiro cadastrado", "OK", $fazendeiro);
        }

        public function editar($parametros){          
            $parametrosPost = parametrosJson() + parametrosPost();
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $fazendeiro = $this->fazendeiro->listar($parametros["id"]);
            if(!$fazendeiro) output(404, "Sem retorno para esse ID", "ERRO");
            if(!parametrosValidos($parametrosPost, ["nome", "dataCadastro"])) output(404, "1 Os parametros obrigatorios nao foram passados", "ERRO");
            
            $fazendeiro = $this->fazendeiro->editar($parametros["id"], $parametrosPost["nome"], $parametrosPost["dataCadastro"]);
            if(!$fazendeiro) output(500, "Houve algum problema ao editar fazendeiro", "ERRO");
            output(200, "fazendeiro editado", "OK", $fazendeiro);
        }

        public function deletar($parametros){ 
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $fazendeiro = $this->fazendeiro->listar($parametros["id"]);
            if(!$fazendeiro) output(404, "Sem retorno para esse ID", "ERRO");
            $plantacao = $this->plantacao->deletarFazendeiro($parametros["id"]);
            $this->fazendeiro->deletar($parametros["id"]);
            output(200, "fazendeiro deletado", "OK", $fazendeiro);
        }
        
    }

?>