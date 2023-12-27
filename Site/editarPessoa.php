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

    try {
        if (!parametrosValidos($_GET, ["id"])) {
            throw new Exception(msgBD("ID não foi enviado!"));
        }
        if (!Pessoa::exists($_GET["id"])) {
            throw new Exception(msgBD("Esta pessoa não existe!"));
        }
        if (isMetodo("POST")) {
            if (!parametrosValidos($_POST, ["nome", "data"])) {
                throw new Exception(msgBD("Parâmetros inválidos"));
            }

            $res = Pessoa::edit($_GET["id"], $_POST["nome"], $_POST["data"]);
            if (!$res) {
                throw new Exception(msgBD("Erro ao editar a pessoa!"));
            }
            msgBD("Pessoa editada com sucesso!");
        }
        $pessoa = Pessoa::getOne($_GET["id"]);
    } catch (Exception $e) {
        echo "<p>" . $e->getMessage() . "</p>";
        die;
    }
    ?>
    <div class="container">
        <div class="box has-text-centered">
            <h2 class="title">Editar <?= $pessoa[0]["nome"] ?></h2>
            <form method="POST" action="editarPessoa.php?id=<?= $pessoa[0]["id"] ?>">
                <div class="field">
                    <p>Digite seu nome:</p>
                    <input class="input is-info has-text-centered" type="text" name="nome" value="<?= $pessoa[0]["nome"] ?>" required placeholder="Digite seu nome">
                </div>
                <div class="field">
                    <p>Selecione sua data de nascimento:</p>
                    <input class="input is-info has-text-centered" type="date" name="data" value="<?= $pessoa[0]["dataNascimento"] ?>" required>
                </div>
                <button class="button is-info">Editar</button>
                <a class="button is-link is-light" href=pessoas.php>Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>