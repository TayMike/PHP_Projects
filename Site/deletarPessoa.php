<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locadora</title>
    <?php require_once(__DIR__ . "/parts/headerLink.php"); ?>
</head>

<body>
    <?php
    require_once(__DIR__ . "/config/utils.php");
    require_once(__DIR__ . "/model/Pessoa.php");
    require_once(__DIR__ . "/model/Carro.php");

    try {
        if (!parametrosValidos($_GET, ["id"])) {
            throw new Exception(msgBD("ID não foi enviado"));
        }
        if (!Pessoa::exists($_GET["id"])) {
            throw new Exception(msgBD("Esta pessoa não existe!"));
        }
        if (isMetodo("POST")) {
            $qtde = Carro::deleteFK($_GET["id"]);
            $res = Pessoa::delete($_GET["id"]);
            if (!$res) {
                throw new Exception(msgBD("Erro ao deletar a pessoa!"));
            }
            msgBD("Pessoa deletada com sucesso!");
            die;
        }
        $pessoa = Pessoa::getOne($_GET["id"]);
    } catch (Exception $e) {
        echo "<p>" . $e->getMessage() . "</p>";
        die;
    }
    ?>
    <div class="container">
        <div class="box has-text-centered">
            <h2 class="title">Deletar <?= $pessoa[0]["nome"] ?></h2>
            <form method="POST" action="deletarPessoa.php?id=<?= $pessoa[0]["id"] ?>">
                <div class="field">
                    <p>Você tem certeza que quer deletar <?= $pessoa[0]["nome"] ?>?</p>
                    <p>Isso irá deletar todos os carros alugados por essa pessoa!</p>
                </div>
                <button class="button is-danger">Deletar</button>
                <a class="button is-link is-light" href=pessoas.php>Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>