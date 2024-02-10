<?php

$host = 'localhost';
$porta = '5432';
$usuario = 'postgres';
$senha = '123';
$banco = 'projetoProgramWeb';

try {
    $conexao = pg_connect("host='$host' port='$porta' dbname='$banco' user='$usuario' password='$senha'");

    if (!$conexao) {
        throw new Exception("Não foi possível se conectar ao banco de dados.");
    }

} catch (Exception $e) {
    // Exibir mensagem de erro em ambiente de produção
    echo "Erro: " . $e->getMessage();
   
    // echo "Não foi possível se conectar ao banco de dados.";
}

?>
