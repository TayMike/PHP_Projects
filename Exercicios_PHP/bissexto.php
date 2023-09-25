<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Ano Bissexto</title>
    <style>
        li {
            width: 50px;
        }
        li:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    </head>
    <body>
        <?php
            $i = 0;
            echo "<ul>";
            for($i=1582; $i<=2100; $i++){
                if($i % 4 == 0) {
                    if($i % 100 != 0) {
                        if($i % 400 == 0) {
                            echo "<li>$i</li>";
                        }
                    }
                    if($i % 100 === 0 && $i % 400 === 0) { 
                        echo "<li>$i</li>";
                    }
                }
            }
            echo "</ul>";
        ?>
    </body>
</html>