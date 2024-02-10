<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - PyQuiz</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="box">
            <img src="../img/cad.png" alt="logo">
            <h1>Cadastro</h1>
            <p>Cadastre-se para entrar.</p>
            <form action="cadastro.php" method="post">
                <!-- Inclua campos de entrada para o nome de usuário e senha -->
                <div class="nome">
                    <input type="text" id="nome" name="nome" placeholder="nome" required>
                </div>
                <div class="email">
                    <input type="email" id="email" name="email" placeholder="e-mail" required>
                </div>
                <div class="senha">
                    <input type="password" id="senha" name="senha" placeholder="senha" required>
                </div>
                <div class="sexo">
                    <input type="radio" name="sexo"  value="F" required><span>Feminino</span>
                    <input type="radio" name="sexo"  value="M" required><span>Masculino</span>
                </div>
                <div class="submit">
                    <p>Já tem uma conta? <a href="login.php">Entre aqui.</a></p>
                    <input type="submit" id="sub" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>


    <?php
    $registerError = ""; // Inicializar a variável de erro
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include_once('../includes/conectar.php');
    
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sexo = $_POST['sexo'];
    
        // Modificação 1: Verificar se o e-mail já existe antes de inserir
        $query_verificar_email = "SELECT email FROM usuarios WHERE email = $1";
        $result_verificar_email = pg_prepare($conexao, "verificar_email", $query_verificar_email);
        $result_verificar_email = pg_execute($conexao, "verificar_email", array($email));
    
        if (pg_num_rows($result_verificar_email) > 0) {
            // E-mail já existe
            $registerError = "Este e-mail já está cadastrado.";
        } else {
            // Modificação 2: Tentar a inserção
            $query_inserir = "INSERT INTO usuarios(nome, email, senha, sexo) VALUES ($1, $2, $3, $4)";
            $result_inserir = pg_prepare($conexao, "inserir_usuario", $query_inserir);
            $result_inserir = pg_execute($conexao, "inserir_usuario", array($nome, $email, $senha, $sexo));
    
            // Tratar erro após a tentativa de inserção
            if (!$result_inserir) {
                $erro = pg_last_error($conexao);
                if (strpos($erro, 'usuarios_email_key') !== false) {
                    // O erro é devido à restrição de unicidade do e-mail
                    $registerError = "Este e-mail já está cadastrado.";
                } else {
                    // Algum outro erro ocorreu
                    $registerError = "Erro ao cadastrar usuário: $erro";
                }
            } else {
                // Inserção bem-sucedida
                header("Location: login.php");
                exit();
            }
        }
    }
    
    // Exibir popup apenas se houver um erro
    if (!empty($registerError)) {
        echo "<script>
                alert('$registerError');
              </script>";
    }
    ?>
    
    </body>
    </html>
    