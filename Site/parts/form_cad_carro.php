<div class="container">
    <div class="box has-text-centered">
        <h2 class="title">Cadastro de carro</h2>
        <form method="POST">
            <div class="field">
                <p>Digite o nome do carro:</p>
                <input class="input is-link has-text-centered" type="text" name="nome" required placeholder="Digite o nome do carro">
            </div>
            <div class="field">
                <p>Digite a marca do carro:</p>
                <input class="input is-link has-text-centered" type="text" name="marca" required placeholder="Digite a marca do carro">
            </div>
            <div class="field">
                <p>Digite o ano do carro:</p>
                <input class="input is-link has-text-centered" type="number" name="ano" required min="1900" max="2023">
            </div>
            <div class="field">
                <p><label for="idPessoa">Escolha uma pessoa:</label></p>
                <div class="select is-link">
                    <select name="idPessoa" id="idPessoa">
                    <?php
                        require_once(__DIR__ . "/../model/Pessoa.php");
                        $listaPessoas = Pessoa::getAll();
                        foreach ($listaPessoas as $pessoa) {
                            echo "<option value='" . $pessoa["id"] . "'>" . $pessoa["nome"] . "</option>";
                        }
                    ?>
                    </select>
                </div>
            </div>
            <button class="button is-link">Cadastrar</button>
        </form>
    </div>
</div>