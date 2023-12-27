<?php

require_once("./config/header.php");
require_once("./config/utils.php");
require_once("./config/Conexao.php");
require_once("./models/Session.php");
require_once("./models/Usuario.php");


class Rotas {
    
    private $classes;
    private $rotas;

    public function __construct($rotas, $classes) {
        $this->classes = $classes;
        $this->rotas = $rotas;
    }

    public function getNomesParametros($rota) {
        $pattern = '#^' . preg_replace('/:([\w-]+)/', '(.*)', $rota) . '$#';
        preg_match($pattern, $rota, $matches);
        $nomesParametros = [];
        for ($i = 1; $i < count($matches); $i++) {
            $nomesParametros[] = str_replace(':', '', $matches[$i]);
        }
    
        return $nomesParametros;
    }

    public function verifiplantacaota($url) {
        $parametros = [];
        $metodo = $_SERVER['REQUEST_METHOD'];

        foreach ($this->rotas as $rota => $conteudoRota) {
            $pattern = "#^" . preg_replace("/:([\w-]+)/", "([\\w-]+)", $rota) . "$#";
            preg_match($pattern, $url, $matches);
            if ($matches) {
                if(count($matches) > 1) {
                    $nomesParametros = $this->getNomesParametros($rota);
                    for($x=1; $x<count($matches); $x++) {
                        $parametros[$nomesParametros[$x-1]] = $matches[$x];
                    }
                    return [$rota, $parametros, $metodo];
                }
                return [$rota, $parametros, $metodo];
            }
        }
        
        output(404, "Rota nao encontrada", "ERRO");
    }
    
    public function chamarAcao($rota, $parametros, $metodo) {
        $entidade = explode('/', $rota)[0];
        $nomeArquivoController = $this->classes[$entidade]["controller"] . ".php";
        $nomeArquivoClasse = $this->classes[$entidade]["classe"] . ".php";
        
        if (!isset($this->rotas[$rota])) {
            output(404, "Rota não encontrada", "ERRO");
            
            return;
        }
        
        if (!isset($this->rotas[$rota]["rotas"][$metodo])) {
            output(405, "Metodo nao permitido para essa rota", "ERRO");
            return;
        }
    
        $nomeArquivoController = $this->classes[$entidade]["controller"] . ".php";
        if (!file_exists("./controller/{$nomeArquivoController}")) {
            output(500, "Erro interno do servidor", "ERRO");
            return;
        }
    
        $nomeArquivoClasse = $this->classes[$entidade]["classe"] . ".php";
        if (!file_exists("./models/{$nomeArquivoClasse}")) {
            output(500, "Erro interno do servidor", "ERRO");
            return;
        }

        try {

            require_once("./controller/{$nomeArquivoController}");
            require_once("./models/{$nomeArquivoClasse}");

            $acao = $this->rotas[$rota]["rotas"][$metodo];
            $classe = new $this->classes[$entidade]["classe"]();
            $controller = new $this->classes[$entidade]["controller"]($classe);
            $controller->$acao($parametros);
            
        } catch (Exception $e) {
            output(500, $e->getMessage(), "ERRO");
        }
    }
}

$classes = [
    "fazendeiro" => [
        "classe" => "Fazendeiro",
        "controller" => "FazendeiroController",
    ],
    "alimento" => [
        "classe" => "Alimento",
        "controller" => "AlimentoController",
    ],
    "plantacao" => [
        "classe" => "Plantacao",
        "controller" => "PlantacaoController",
    ],

];

$rotas = [
    "session" => [
        "rotas" => [
            "POST" => "login",
            "DELETE" => "logout",
        ],
    ],
    "fazendeiro" => [
        "rotas" => [
            "POST" => "cadastrar",
            "GET" => "listartodos",
        ],
    ],
    "fazendeiro/:id" => [
        "rotas" => [
            "GET" => "listar",
            "POST" => "editar",
            "DELETE" => "deletar"
        ],
    ],
    "alimento" => [
        "rotas" => [
            "POST" => "cadastrar",
            "GET" => "listartodos",
        ],
    ],
    "alimento/:id" => [
        "rotas" => [
            "GET" => "listar",
            "POST" => "editar",
            "DELETE" => "deletar"
        ],
    ],

    "plantacao" => [
        "rotas" => [
            "POST" => "cadastrar",
            "GET" => "listartodos",
        ],
    ],


    "plantacao/:id" => [
        "rotas" => [
            "GET" => "listar",
            "POST" => "editar",
            "DELETE" => "deletar"
        ]
    ]

];


$rotasApp = new Rotas($rotas, $classes);
$uri = $_GET['url'];
list($rota, $parametros, $metodo) = $rotasApp->verifiplantacaota($uri);
try {
    session_start();
    if ($metodo != "GET") {
        if ($rota == "session") {
            if (parametrosValidos($_POST, ['user', 'password'])) {
                $nome = $_POST["user"];
                $senha = $_POST["password"];
                if(!Usuario::exists($nome)) {
                    Usuario::cadastrar($nome, $senha);
                }
                $hash = Usuario::VerificarLogin($nome);
                if(!password_verify($senha, $hash)) {
                    output(404, "Senha inválida!" , "ERRO");
                }
                else {
                    Session::createSession(Usuario::listar($nome)[0]['id']);
                    output(200, "Usuário logado!" , "SUCESSO");
                }
            } else {
                if (isset($_SESSION["id"])) {
                    Session::logout($_SESSION["id"]);
                    unset($_SESSION["id"]);
                    output(200, "Usuário deslogado!" , "SUCESSO");
                }
            }
        }
        else {
            if(!isset($_SESSION["id"])) {
                output(400, "Necessário login!" , "ERRO");
            }
            else{
                $resultado = Session::getUser($_SESSION["id"]);
                if($resultado)
                    $rotasApp->chamarAcao($rota, $parametros, $metodo);
                else
                    output(400, "Querendo burlar o sistema, né. Não no meu turno." , "ERRO");
            }
        }
    } else
        $rotasApp->chamarAcao($rota, $parametros, $metodo);
} catch (Exception $e) {
    output(500, $e->getMessage(), "ERRO");
}

?>