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
    <div class="container">
        <section class="section">
            <div class="box has-text-centered">
                <div class="field">
                    <p>Seja bem-vindo à locadora de veículos mais badalada de São Paulo!</p>
                    <p>Por favor, escolha a opção que deseja visualizar:</p>
                </div>
                <a class="button is-link" href=pessoas.php>Pessoas</a>
                <a class="button is-link" href=carros.php>Carros</a>
            </div>
        </section>
    </div>
    <?php require_once(__DIR__ . "/parts/footer.php"); ?>
</body>

</html>