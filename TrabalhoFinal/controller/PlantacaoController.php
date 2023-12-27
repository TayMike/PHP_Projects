<?php
    require_once(__DIR__ . "/../config/utils.php");
    require_once(__DIR__ . "/../models/Fazendeiro.php");
    require_once(__DIR__ . "/../models/Alimento.php");
    require_once(__DIR__ . "/../models/Session.php");

    class PlantacaoController{
        private $plantacao;
        private $fazendeiro;
        private $alimento;
    
        public function __construct($plantacao) {
            $this->plantacao = $plantacao;
            $this->fazendeiro = New Fazendeiro();
            $this->alimento = New Alimento();
        }

        public function existeFazendeiro($fazendeiro){
            if(!parametrosValidos($fazendeiro, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $fazendeiro = $this->fazendeiro->listar($fazendeiro["id"]);
            
            if(!$fazendeiro) output(404, "Sem retorno para esse ID", "ERRO");
            return $fazendeiro; 
        }
        
        public function existeAlimento($alimento){
            if(!parametrosValidos($alimento, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $alimento = $this->alimento->listar($alimento["id"]);
            
            if(!$alimento) output(404, "Sem retorno para esse ID", "ERRO");
            return $alimento; 
        }
            

        public function listartodos(){
            $plantacaos = $this->plantacao->listartodos();
            if(!$plantacaos) output(404, "Sem retorno para plantacaos", "ERRO");
            output(200, "plantacaos encontradas", "OK", $plantacaos);
        }
    
        public function listar($parametros) {
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $plantacao = $this->plantacao->listar($parametros["id"]);
            if(!$plantacao) output(404, "Sem retorno para esse ID", "ERRO");
            output(200, "plantacao encontrada", "OK", $plantacao);
        }

        public function cadastrar($parametros) {    
            $parametrosPost = parametrosJson() + parametrosPost();
            if(!parametrosValidos($parametrosPost, ["idAlimento", "idFazendeiro", "dataPlantacao"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $fazendeiro = $this->fazendeiro->listar($parametrosPost["idFazendeiro"]);
            $alimento = $this->alimento->listar($parametrosPost["idAlimento"]);

            if((!$fazendeiro) and (!$alimento)) output(404, "O id da fazendeiro nao foi encontrado", "ERRO");
            $plantacao = $this->plantacao->cadastrar($parametrosPost["idAlimento"], $parametrosPost["idFazendeiro"],$parametrosPost["dataPlantacao"]);
            if(!$plantacao) output(404, "Houve algum problema no cadastro de plantacao", "ERRO");
            
            output(200, "plantacao cadastrada", "OK", $plantacao);
            
        }

        public function editar($parametros){    
            $parametrosPost = parametrosJson() + parametrosPost();
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $plantacao = $this->plantacao->listar($parametros["id"]);
            if(!$plantacao) output(404, "Sem retorno para esse ID", "ERRO");
            if(!parametrosValidos($parametrosPost, ["idAlimento", "idFazendeiro", "dataPlantacao"])) output(404, "11111 Os parametros obrigatorios nao foram passados", "ERRO");
    
            $plantacao = $this->plantacao->editar($parametros["id"], $parametrosPost["idAlimento"], $parametrosPost["idFazendeiro"], $parametrosPost["dataPlantacao"]);
            if(!$plantacao) output(500, "Houve algum problema ao editar plantacao", "ERRO");
            output(200, "plantacao editada", "OK", $plantacao);
        }

        public function deletar($parametros){  
            if(!parametrosValidos($parametros, ["id"])) output(404, "Os parametros obrigatorios nao foram passados", "ERRO");
            $plantacao = $this->plantacao->listar($parametros["id"]);
            if(!$plantacao) output(404, "Sem retorno para esse ID", "ERRO");
            $this->plantacao->deletar($parametros["id"]);
            output(200, "plantacao deletada", "OK", $plantacao);
        }
        
    }

?>