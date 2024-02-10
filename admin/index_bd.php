<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Tabela e Inserir Dados</title>
</head>
<body>

    <form action="processar.php" method="post">
        <label for="nome_tabela">Nome da Tabela:</label>
        <input type="text" id="nome_tabela" name="nome_tabela" required>

        <label for="coluna1">Nome da Coluna 1:</label>
        <input type="text" id="coluna1" name="coluna1" required>

        <label for="coluna2">Nome da Coluna 2:</label>
        <input type="text" id="coluna2" name="coluna2" required>

        <!-- Adicione mais campos conforme necessário para o número desejado de colunas -->

        <button type="submit">Criar Tabela</button>
    </form>

    <form action="processar.php" method="post">
        <label for="tabela_existente">Tabela Existente:</label>
        <select id="tabela_existente" name="tabela_existente" required>
            <!-- Lista de tabelas existentes, você pode preenchê-la dinamicamente a partir do banco de dados -->
            <option value="tabela1">Tabela 1</option>
            <option value="tabela2">Tabela 2</option>
            <option value="tabela3">Tabela 3</option>
        </select>

        <label for="dado_coluna1">Dado para Coluna 1:</label>
        <input type="text" id="dado_coluna1" name="dado_coluna1" required>

        <label for="dado_coluna2">Dado para Coluna 2:</label>
        <input type="text" id="dado_coluna2" name="dado_coluna2" required>

        <!-- Adicione mais campos conforme necessário para o número desejado de colunas -->

        <button type="submit">Inserir Dados</button>
    </form>

</body>
</html>
