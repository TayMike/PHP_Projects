<?php
    require_once(__DIR__ . "/../config/utils.php");
    require_once(__DIR__ . "/../models/Plantacao.php");

    class AlimentoController{
        private $alimento;
        private $plantacao;
    
        public function __construct($alimento) {
            $this->alimento = $alimento;
            $this->plantacao = New Plantacao();
        }

        public function listartodos(){
            $alimentos = $this->alimento->listartodos();
            if(!$alimentos) output(404, "Sem retorno para alimentos", "ERRO");
            output(200, "alimentos encontrados", "OK", $alimentos);
        }
    
        public function listar($parametros) {
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $alimento = $this->alimento->listar($parametros["id"]);
            if(!$alimento) output(404, "Sem retorno para esse ID", "ERRO");
            output(200, "alimento encontrado", "OK", $alimento);
        }

        public function cadastrar($parametros) {
            $parametrosPost = parametrosJson() + parametrosPost();
            if(!parametrosValidos($parametrosPost, ["nome", "dataColheita"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $alimento = $this->alimento->cadastrar($parametrosPost["nome"], $parametrosPost["dataColheita"]);
            if(!$alimento) output(404, "Houve algum problema no cadastro de alimento", "ERRO");
            output(200, "alimento cadastrado", "OK", $alimento);
        }

        public function editar($parametros){        
            $parametrosPost = parametrosJson() + parametrosPost();
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $alimento = $this->alimento->listar($parametros["id"]);
            if(!$alimento) output(404, "Sem retorno para esse ID", "ERRO");
            
            if(!parametrosValidos($parametrosPost, ["nome", "dataColheita"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            
            $alimento = $this->alimento->editar($parametros["id"], $parametrosPost["nome"], $parametrosPost["dataColheita"]);
            if(!$alimento) output(500, "Houve algum problema ao editar alimento", "ERRO");
            output(200, "alimento editado", "OK", $alimento);
        }

        public function deletar($parametros){
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $alimento = $this->alimento->listar($parametros["id"]);
            if(!$alimento) output(404, "Sem retorno para esse ID", "ERRO");
            $plantacao = $this->plantacao->deletarAlimento($parametros["id"]);
            $this->alimento->deletar($parametros["id"]);
            output(200, "alimento deletado", "OK", $alimento);
        }
        
    }

?>