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
                require_once(__DIR__ . "/model/Carro.php");

                if (isMetodo("POST")) {
                    if (parametrosValidos($_POST, ["nome", "marca", "ano", "idPessoa"])) {
                        try {
                            $nome = $_POST["nome"];
                            $marca = $_POST["marca"];
                            $ano = $_POST["ano"];
                            $idPessoa = $_POST["idPessoa"];
                            if (!Pessoa::exists($idPessoa)) {
                                throw new Exception("Erro ao cadastrar carro");
                            }
                            $resultado = Carro::add($nome, $marca, $ano, $idPessoa);
                            if (!$resultado) {
                                throw new Exception("Erro ao cadastrar carro");
                            }
                            echo "<script>alert('Carro cadastrado com sucesso!')</script>";
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                require_once(__DIR__ . "/parts/form_cad_carro.php");
                ?>
            </section>
            <section class="section">
                <?php
                require_once(__DIR__ . "/parts/table_listar_carro.php");
                echo "<p class='content has-text-centered'>Existem " . Carro::getNumber() . " carros cadastrados no sistema</p>";
                ?>
            </section>
        </div>
    </div>
    <?php require_once(__DIR__ . "/parts/footer.php"); ?>
</body>

</html>