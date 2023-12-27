<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locadora</title>
    <?php require_once(__DIR__ . "/parts/headerLink.php"); ?>
</head>

<body>
    <?php require_once(__DIR__ . "/parts/navbar.php"); ?>
    <div class="columns">
        <div class="column">
            <section class="section">
                <?php
                require_once(__DIR__ . "/config/utils.php");
                require_once(__DIR__ . "/model/Pessoa.php");

                if (isMetodo("POST")) {
                    if (parametrosValidos($_POST, ["nome", "data"])) {
                        try {
                            $nome = $_POST["nome"];
                            $data = $_POST["data"];

                            $resultado = Pessoa::add($nome, $data);
                            if (!$resultado) {
                                throw new Exception("Erro ao cadastrar pessoa");
                            }
                            echo "<script>alert('Pessoa cadastrada com sucesso!')</script>";
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                require_once(__DIR__ . "/parts/form_cad_pessoa.php");
                ?>
            </section>
            <section class="section">
                <?php
                require_once(__DIR__ . "/parts/table_listar_pessoa.php");
                echo "<p class='content has-text-centered'>Existem " . Pessoa::getNumber() . " pessoas cadastradas no sistema</p>";
                ?>
            </section>
        </div>
    </div>
    <?php require_once(__DIR__ . "/parts/footer.php"); ?>
</body>

</html>