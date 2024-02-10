<?php
include '../includes/conectar.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['senha'];

    // Modificação: Usar pg_prepare para consulta preparada
    $query = "SELECT id, nome, senha FROM usuarios WHERE email = $1";
    $stmt = pg_prepare($conexao, "login_query", $query);
    $result = pg_execute($conexao, "login_query", array($email));

    $user = pg_fetch_assoc($result);

    if ($user && password_verify($password, $user['senha'])) {
        // Login bem-sucedido
        // Você pode redirecionar para a página de quiz ou outra página de sua escolha
        header("Location: qtd_perguntas.html");
        exit();
    } else {
        // Login falhou
        $loginError = "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PyQuiz</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="box">
            <img class="login" src="../img/login.png" alt="logo">
            <h1>Login</h1>
            <p class="p">Seja bem-vindo novamente. Faça login para entrar.</p>

            <form action="login.php" method="post">
                <!-- Inclua campos de entrada para o nome de usuário e senha -->
                <div class="email">
                    <input type="email" id="email" name="email" placeholder="e-mail" required>
                </div>
                <div class="senha">
                    <input type="password" id="senha" name="senha" placeholder="senha" required>
                </div>
                <div class="submit">
                    <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se aqui.</a></p>
                    <input type="submit" value="Entrar">
                </div>
            </form>
        </div>
    </div>

    
<?php
if (isset($loginError)) {
    echo "<p>$loginError</p>";
}
?>

</body>
</html>