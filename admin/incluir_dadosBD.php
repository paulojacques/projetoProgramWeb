<?php
include 'includes/conectar.php';

// Verificar se o formulário para criar uma nova tabela foi enviado
if (isset($_POST['nome_tabela'])) {
    // Acessar os dados do formulário
    $nomeTabela = $_POST['nome_tabela'];
    $coluna1 = $_POST['coluna1'];
    $coluna2 = $_POST['coluna2'];

    // Conectar ao banco de dados
    $conexao = conectarBanco();

    // Criar a tabela
    $queryCriarTabela = "CREATE TABLE IF NOT EXISTS $nomeTabela (
        id SERIAL PRIMARY KEY,
        $coluna1 VARCHAR(255),
        $coluna2 VARCHAR(255)
        -- Adicione mais linhas conforme necessário para o número de colunas desejado
    )";

    $resultCriarTabela = pg_query($conexao, $queryCriarTabela);

    if (!$resultCriarTabela) {
        die("Erro ao criar a tabela: " . pg_last_error());
    }

    echo "Tabela criada com sucesso!";
}

// Verificar se o formulário para inserir dados em uma tabela existente foi enviado
if (isset($_POST['tabela_existente'])) {
    // Acessar os dados do formulário
    $tabelaExistente = $_POST['tabela_existente'];
    $dadoColuna1 = $_POST['dado_coluna1'];
    $dadoColuna2 = $_POST['dado_coluna2'];

    // Conectar ao banco de dados
    $conexao = conectarBanco();

    // Inserir dados na tabela existente
    $queryInserirDados = "INSERT INTO $tabelaExistente ($coluna1, $coluna2)
                         VALUES ('$dadoColuna1', '$dadoColuna2')";

    $resultInserirDados = pg_query($conexao, $queryInserirDados);

    if (!$resultInserirDados) {
        die("Erro ao inserir dados na tabela: " . pg_last_error());
    }

    echo "Dados inseridos com sucesso!";
}

// Fechar a conexão
pg_close($conexao);
?>
