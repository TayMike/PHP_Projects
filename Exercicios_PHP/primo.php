<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Números Primos</title>
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
    $i = 1;
    $numero = 2;
    $total = 0;
        echo ' 
            <table>
                <thead>
                    <tr>
                        <th>Posição</th>
                        <th>Número</th>
                    </tr>
                </thead>';
                while ($i <= 1000) {
                    for($index = 2; $index < $numero; $index++){
                        if ($numero % $index === 0) {
                            $total++;
                            break;
                        }
                    }
                    if ($total === 0) {
                        echo '
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$numero.'</td>
                            </tr>
                        ';
                        $i++;
                    }
                    $total = 0;
                    $numero++;
                }
        echo '</table>';
    ?>
</body>
</html>