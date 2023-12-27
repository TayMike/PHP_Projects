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
    require_once(__DIR__ . "/model/Carro.php");

    try {
        if (!parametrosValidos($_GET, ["id"])) {
            throw new Exception(msgBD("ID não foi enviado!"));
        }
        if (!Carro::exists($_GET["id"])) {
            throw new Exception(msgBD("Este carro não existe!"));
        }
        if (isMetodo("POST")) {
            $res = Carro::delete($_GET["id"]);
            if (!$res) {
                throw new Exception(msgBD("Erro ao deletar o carro!"));
            }
            msgBD("Carro deletado com sucesso!");
            die;
        }
        $carro = Carro::getOne($_GET["id"]);
    } catch (Exception $e) {
        echo "<p>" . $e->getMessage() . "</p>";
        die;
    }
    ?>
    <div class="container">
        <div class="box has-text-centered">
            <h2 class="title">Deletar <?= $carro[0]["nome"] ?></h2>
            <form method="POST" action="deletarCarro.php?id=<?= $carro[0]["id"] ?>">
                <div class="field">
                    <p>Você tem certeza que quer deletar <?= $carro[0]["nome"] ?>?</p>
                </div>
                <button class="button is-danger">Deletar</button>
                <a class="button is-link is-light" href=carros.php>Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>