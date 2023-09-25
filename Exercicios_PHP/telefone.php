<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telefones</title>
    <style>
        table, th, td {
            border: 1px solid;
            border-collapse: collapse;
        }
        thead {
            background-color: gray;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
        th {
            padding: 5px 20px 5px 20px;
        }
        td {
            padding:  5px 20px 5px 20px;
        }
    </style>
</head>

<body>
    <?php
    $telefone = '1632611234';
    echo ' 
    <table>
        <thead>
            <tr>
                <th>Número</th>
                <th>Saída Esperada</th>
            </tr>
        </thead>';
    $validador1 = preg_match('/^169[0-9]{8}+$/', $telefone);
    $validador2 = preg_match('/^163[0-9]{7}+$/', $telefone);
    if($validador1 || $validador2){
        echo '
            <tr>
                <td>'.$telefone.'</td>
                <td><p>'.'Número válido!'.'</p></td>
            </tr>
        ';
    } else {
        echo '
            <tr>
                <td>'.$telefone.'</td>
                <td><p>'.'Número inválido!'.'</p></td>
            </tr>
        ';
    }
    echo '</table>';
    ?>
</body>
</html>