<?php
session_start();
include '../includes/conectar.php';

// Se o formulário de escolha do número de perguntas foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero_perguntas']) && is_numeric($_POST['numero_perguntas'])) {
    $numeroPerguntasDesejado = (int)$_POST['numero_perguntas'];

    // Validar o número desejado de perguntas
    if ($numeroPerguntasDesejado < 5) {
        $numeroPerguntasDesejado = 5;
    } elseif ($numeroPerguntasDesejado > 20) {
        $numeroPerguntasDesejado = 20;
    }

    // Armazenar o número desejado de perguntas e reiniciar a contagem
    $_SESSION['numero_perguntas_desejado'] = $numeroPerguntasDesejado;
    $_SESSION['numero_pergunta'] = 1;
    $_SESSION['pontuacao'] = 0;

    // Redirecionar para o Quiz
    header("Location: quiz.php");
    exit;
}

// Restante do código para recuperar perguntas do banco de dados
$numeroPerguntaAtual = $_SESSION['numero_pergunta'];
$numeroTotalPerguntasDesejado = $_SESSION['numero_perguntas_desejado'];

$queryTotal = "SELECT COUNT(*) as total FROM perguntas";
$resultTotal = pg_query($conexao, $queryTotal);
$rowTotal = pg_fetch_assoc($resultTotal);
$numeroTotalPerguntasBanco = $rowTotal['total'];

// Verificar se há mais perguntas para exibir
if ($numeroPerguntaAtual <= $numeroTotalPerguntasDesejado) {
    // Processar resposta submetida pelo formulário
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['resposta'])) {
            $respostaSelecionada = $_POST['resposta'];
            // Incrementar pontuação se a resposta estiver correta
            if ($respostaSelecionada === $_SESSION['resposta_correta']) {
                $_SESSION['pontuacao'] += 10;
            }
        }

        // Incrementar o número da pergunta
        $_SESSION['numero_pergunta']++;

        // Verificar se o número da pergunta ultrapassou o total
        if ($_SESSION['numero_pergunta'] > $numeroTotalPerguntasDesejado) {
            // Redirecionar para a tela de resultado se não houver mais perguntas
            header("Location: resultado.php");
            exit;
        }

        // Atualizar o número da pergunta exibido
        $numeroPerguntaAtual = $_SESSION['numero_pergunta'];
    }

    // Calcular a pontuação total
    $pontuacaoTotal = $_SESSION['pontuacao'];

    
    
    // Recuperar pergunta aleatória do banco de dados
    $query = "SELECT texto_pergunta, opcao1, opcao2, opcao3, opcao4, resposta FROM perguntas ORDER BY RANDOM() LIMIT 1";
    $result = pg_query($conexao, $query);

    if (!$result) {
        die("Erro na consulta ao banco de dados.");
    }

    $row = pg_fetch_assoc($result);

    if (!$row) {
        die("Erro: Não foi possível recuperar uma pergunta do banco de dados.");
    }

    $_SESSION['resposta_correta'] = $row['resposta'];  // Adicionar esta linha para armazenar a resposta correta
    $texto_pergunta = $row['texto_pergunta'];
    $opcao1 = $row['opcao1'];
    $opcao2 = $row['opcao2'];
    $opcao3 = $row['opcao3'];
    $opcao4 = $row['opcao4'];
    $resposta_correta = $_SESSION['resposta_correta'];  // Modificar aqui para usar a variável armazenada

    // Inicializar pontuação se não estiver definida
    if (!isset($_SESSION['pontuacao'])) {
        $_SESSION['pontuacao'] = 0;
    }
} else {
    // Redirecionar para a tela de resultado se não houver mais perguntas
    header("Location: resultado.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz - PyQuiz</title>
    <link rel="stylesheet" href="../css/stylo.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="container">
        <div class="box">
            <img src="../img/quiz..png" alt="quiz">
            <h1>QUIZ</h1>
            <p>Desafie-se agora!!</p>
            <form action="quiz.php" method="post" id="quizForm">
            <?php
            // Exibir número atual da pergunta e total desejado
            echo "<h2>Pergunta $numeroPerguntaAtual de $numeroTotalPerguntasDesejado</h2>";
            
            // Exibir a pontuação total
            echo "<p>Pontuação Total: $pontuacaoTotal</p>";
            ?>
                <!-- Conteúdo do formulário e pergunta -->
                <h3><?php echo $texto_pergunta; ?></h3>
                <input class="q" type="radio" name="resposta" value="<?php echo $opcao1; ?>" onchange="habilitarBotao()"> <?php echo $opcao1; ?><br>
                <input class="q" type="radio" name="resposta" value="<?php echo $opcao2; ?>" onchange="habilitarBotao()"> <?php echo $opcao2; ?><br>
                <input class="q" type="radio" name="resposta" value="<?php echo $opcao3; ?>" onchange="habilitarBotao()"> <?php echo $opcao3; ?><br>
                <input class="q" type="radio" name="resposta" value="<?php echo $opcao4; ?>" onchange="habilitarBotao()"> <?php echo $opcao4; ?><br><br>
                <input type="hidden" id="respostaCorreta" value="<?php echo $resposta_correta; ?>">
                <button type="submit" id="proximoBtn" disabled>Próxima</button>
            </form>
        </div>
    </div>
    <script>
        // Função para habilitar o botão após uma resposta ser selecionada
        function habilitarBotao() {
            var respostaSelecionada = document.querySelector('input[name="resposta"]:checked');
            document.getElementById("proximoBtn").disabled = !respostaSelecionada;
        }
    </script>
</body>
</html>
