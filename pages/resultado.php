<!--<?php
session_start();

// Verificar se a pontuação está definida na sessão
if (!isset($_SESSION['pontuacao'])) {
    header("Location: quiz.php");
    exit;
}

$pontuacaoTotal = $_SESSION['pontuacao'];

// Lógica para decidir a mensagem com base na pontuação
if ($pontuacaoTotal >= 5) {
    $mensagem = "Parabéns! Você fez muito bem!";
} else {
    $mensagem = "Lamentamos, sua pontuação não foi tão alta. Continue praticando!";
}

// Limpar as variáveis de sessão
unset($_SESSION['numero_pergunta']);
unset($_SESSION['pontuacao']);
?>
-->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado do Quiz</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="container">
        <div class="box">
            <img src="../img/resul.png" alt="quiz">
            <h1>Resultado do Quiz</h1>
            <p><?php echo $mensagem; ?></p>
            <p class="pontos">Sua pontuação total: <?php echo $pontuacaoTotal; ?></p>

            <div class="button">
                <a href="../index.html" class="b">Sair</a>
                <a href="qtd_perguntas.html" class="b">Reiniciar</a><br><br>
            </div>
        </div>
    </div>

</body>
</html>