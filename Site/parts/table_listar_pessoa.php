<?php
require_once(__DIR__ . "/../model/Pessoa.php");
require_once(__DIR__ . "/../parts/headerLink.php");

$listaPessoas = Pessoa::getAll();
?>

<h2 class="title">Pessoas cadastradas</h2>
<table class="table is-striped is-fullwidth">
    <thead>
        <tr>
            <th class='has-text-centered'>ID</th>
            <th class='has-text-centered'>Nome</th>
            <th class='has-text-centered'>Data de Nascimento</th>
            <th class='has-text-centered'>Editar</th>
            <th class='has-text-centered'>Deletar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($listaPessoas as $pessoa) {
            echo "<tr>";
            echo "<td class='has-text-centered'>" . $pessoa["id"] . "</td>";
            echo "<td class='has-text-centered'>" . $pessoa["nome"] . "</td>";
            echo "<td class='has-text-centered'>" . date_format(date_create($pessoa["dataNascimento"]), 'd/m/Y') . "</td>";
            echo "<td class='has-text-centered'><a href='editarPessoa.php?id=" . $pessoa["id"] . "'>
            <span class='icon'>
            <svg xmlns='http://www.w3.org/2000/svg' height='1.25em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z'/></svg>
            </span>
            </a></td>";
            echo "<td class='has-text-centered'><a href='deletarPessoa.php?id=" . $pessoa["id"] . "'>
            <span class='icon'>
            <svg xmlns='http://www.w3.org/2000/svg' height='1.25em' viewBox='0 0 576 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M290.7 57.4L57.4 290.7c-25 25-25 65.5 0 90.5l80 80c12 12 28.3 18.7 45.3 18.7H288h9.4H512c17.7 0 32-14.3 32-32s-14.3-32-32-32H387.9L518.6 285.3c25-25 25-65.5 0-90.5L381.3 57.4c-25-25-65.5-25-90.5 0zM297.4 416H288l-105.4 0-80-80L227.3 211.3 364.7 348.7 297.4 416z'/></svg>
            </span>
            </a></td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>