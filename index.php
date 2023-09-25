<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
</head>
<body class="vsc-initialized">
    <header class="header has-text-centered my-6">
        <h1 class="title is-1">Atividade de formulário PHP</h1>
    </header>
    <main>
        <div class="columns">
            <form class="column is-offset-1 is-3" method="POST" action="index.php">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Nome">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Idade</label>
                    <div class="control">
                        <input class="input" type="number" placeholder="Idade" name="idade">
                    </div>
                </div>

                <div class="field">
                    <label class="label">E-mail</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="Intencionalmente, o tipo está como 'text'" name="email">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Estado civil</label>
                    <div class="control">
                        <div class="select">
                            <select name="estado">
                                <option value="">---</option>
                                <option value="0">Solteiro</option>
                                <option value="1">Casado</option>
                                <option value="2">Viúvo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">O que você gostaria de comer hoje?</label>
                    <div class="control">
                        <label class="checkbox">
                            <input type="checkbox" name="comida[]" value="0"> Peito de frango
                        </label>
                        <br>
                        <label class="checkbox">
                            <input type="checkbox" name="comida[]" value="1"> Bife de alcatra
                        </label>
                        <br>
                        <label class="checkbox">
                            <input type="checkbox" name="comida[]" value="2"> Purê de batatas
                        </label>
                        <br>
                        <label class="checkbox">
                            <input type="checkbox" name="comida[]" value="3"> Arroz
                        </label>
                        <br>
                        <label class="checkbox">
                            <input type="checkbox" name="comida[]" value="4"> Batata-frita
                        </label>
                        <br>
                        <label class="checkbox">
                            <input type="checkbox" name="comida[]" value="5"> Salada verde
                        </label>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="label">Forma de entrega?</label>
                        <label class="radio">
                            <input type="radio" name="forma" value="0">
                            Entrega
                        </label>
                        <br>
                        <label class="radio">
                            <input type="radio" name="forma" value="1">
                            Buscar
                        </label>
                    </div>
                </div>

                <div class="field is-grouped has-text-centered is-center">
                    <div class="control">
                        <button class="button is-link">Enviar</button>
                    </div>
                    <div class="control">
                        <button type="reset" class="button is-link is-light">Limpar</button>
                    </div>
                </div>
            </form>
            <div class="column is-4 content">
                <p>Regras do formulário:</p>
                <ul>
                    <li>O nome deve ser enviado e ter de 4 a até 10 caracteres no máximo!</li>
                    <li>A idade deve ser enviado e ser maior ou igual a 18 anos, e menor ou igual a 60 anos.</li>
                    <li>O email deve ser válido</li>
                    <li>O estado civil deve ser enviado e não pode ser "vazio". Só pode aceitar valores 0, 1 e 2.</li>
                    <li>A lista de comida deve receber exatamente 3 itens selecionados. Os valores recebidos devem ser números de 0 a 5.</li>
                    <li>Uma forma de entrega deve ser selecionada. Apenas números 0 e 1 são aceitos.</li>
                </ul>
            </div>

            <div class="column is-3 content">
                
                <?php

                    function Message($erro, $message, $css = "danger", $msg = "de", $titulo = "Erro!") {
                        echo 
                        "<article class=\"message is-$css\"> 
                            <div class=\"message-header\">
                                <p>$titulo</p>
                            </div>
                            <div class=\"message-body\">
                                <p>O valor $msg <b>$erro</b> <i>$message</i>
                            </div>
                        </article>";
                    }
                    
                    // Vetor com o nome dos campos para facilitar na adição ou remoção de novos campos
                    $campos = array("nome", "idade", "email", "estado", "comida", "forma");
                    // Validação se o usuário enviou as infos, porém a array veio como null
                    $validadorArray = false;
                    const ESTADO = 2;
                    const COMIDA = 5;
                    const FORMA = 1;

                    foreach($campos as $campo) {
                        if(isset($_POST[$campo])){
                            if(!$validadorArray) {
                                $validadorArray = true;
                            }
                            $verificar = $_POST[$campo];
                            if(!is_array($verificar)){
                                if(empty($verificar) && $verificar != "0") {
                                    Message($campo, "está vazio!");
                                    continue;
                                }
                                // Verificação do campo NOME
                                if(strlen($verificar) < 4 && $campo == "nome"){
                                    Message($campo, "está com o tamanho abaixo de 4 caracteres!");
                                    continue;
                                }
                                if(strlen($verificar) > 10 && $campo == "nome"){
                                    Message($campo, "está com o tamanho acima de 10 caracteres!");
                                    continue;
                                }
                                // Verificação do campo IDADE
                                if($verificar < 18 && $campo == "idade"){
                                    Message($campo, "está com valor inferior a 18!");
                                    continue;
                                }
                                if($verificar > 60 && $campo == "idade"){
                                    Message($campo, "está com valor acima de 60!");
                                    continue;
                                }
                                // Verificação do campo EMAIL
                                if(!filter_var($verificar, FILTER_VALIDATE_EMAIL) && $campo == "email"){
                                    Message($campo, "não é um e-mail válido!");
                                    continue;
                                }
                                // Verificação do campo ESTADO
                                if($verificar < 0 || $verificar > ESTADO && $campo == "estado"){
                                    Message($campo, "não está com um valor válido!");
                                    continue;
                                }
                                // Verificação do campo FORMA
                                if($verificar < 0 || $verificar > FORMA && $campo == "forma"){
                                    Message($campo, "não está com um valor válido!");
                                    continue;
                                }
                            } else {
                                // Verificação do campo COMIDA
                                $validacaoComida = true;
                                if($campo == "comida") {
                                    if(count($verificar) != 3){
                                        Message($campo, "não possui exatamente 3 itens!");
                                        continue;
                                    }
                                    foreach($verificar as $valorUnico){
                                       if($valorUnico < 0 || $valorUnico > COMIDA){
                                            Message($campo, "possui um dos itens com valor inválido!");
                                            $validacaoComida = false;
                                            break;
                                       }
                                    }
                                    if(!$validacaoComida){
                                        continue;
                                    }
                                }
                            }
                            // Deu tudo certo!
                            Message($campo, "está OK!", "success", "", "OK!");
                        } else {
                            if($validadorArray == true){
                                Message($campo, "não foi enviado!");
                            }
                        }
                    }

                ?>

            </div>
        </div>
    
</body>
</html>
