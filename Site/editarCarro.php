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
            throw new Exception(msgBD("Este carro não existe"));
        }
        if (isMetodo("POST")) {
            if (!parametrosValidos($_POST, ["nome", "marca", "ano", "idPessoa"])) {
                throw new Exception(msgBD("Parâmetros inválidos"));
            }

            $res = Carro::edit($_GET["id"], $_POST["nome"], $_POST["marca"], $_POST["ano"], $_POST["idPessoa"]);
            if (!$res) {
                throw new Exception(msgBD("Erro ao editar o carro!"));
            }
            msgBD("Carro editado com sucesso!");
        }
        $carro = Carro::getOne($_GET["id"]);
    } catch (Exception $e) {
        echo "<p>" . $e->getMessage() . "</p>";
        die;
    }
    ?>
    <div class="container">
        <div class="box has-text-centered">
            <h2 class="title">Editar <?= $carro[0]["nome"] ?></h2>
            <form method="POST" action="editarCarro.php?id=<?= $carro[0]["id"] ?>">
                <div class="field">
                    <p>Digite o nome do carro:</p>
                    <input class="input is-info has-text-centered" type="text" name="nome" value="<?= $carro[0]["nome"] ?>" required placeholder="Digite o nome do carro">
                </div>
                <div class="field">
                    <p>Digite a marca do carro:</p>
                    <input class="input is-info has-text-centered" type="text" name="marca" value="<?= $carro[0]["marca"] ?>" required placeholder="Digite a marca do carro">
                </div>
                <div class="field">
                    <p>Digite o ano do carro:</p>
                    <input class="input is-info has-text-centered" type="number" name="ano" value="<?= $carro[0]["ano"] ?>" required min="1900" max="2023">
                </div>
                <div class="field">
                    <p><label for="idPessoa">Escolha uma pessoa:</label></p>
                    <div class="select is-info">
                        <select name="idPessoa" id="idPessoa">
                        <?php
                            require_once(__DIR__ . "/model/Pessoa.php");
                            $listaPessoas = Pessoa::getAll();
                            foreach ($listaPessoas as $pessoa) {
                                if($carro[0]["idPessoa"] != $pessoa["id"])
                                    echo "<option value='" . $pessoa["id"] . "'>" . $pessoa["nome"] . "</option>";
                                else
                                    echo "<option value='" . $pessoa["id"] . "'selected>" . $pessoa["nome"] . "</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <button class="button is-info">Editar</button>
                <a class="button is-link is-light" href=carros.php>Voltar</a>
            </form>
        </div>
    </div>
</body>

</html>