<?php

    include '../conexao.php';
    
    //$sql = $conn->query('INSERT INTO "comercioSoftexpert".tipo_produto (id, nome, imposto) VALUES (3, \'teste\', 10.5)');
    $stmt = $conn->prepare(
        'INSERT INTO "comercioSoftexpert".produto (nome, tipo_produto_id, valor) VALUES (:nome, :tipo_produto_id, :valor)'
    );

   
    $nome = $_POST['nome'];
    $tipoProdutoId = $_POST['tipoProdutoId'];
    $valor = $_POST['valor'];

    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':tipo_produto_id', $tipoProdutoId);
    $stmt->bindValue(':valor', $valor);
    $stmt->execute();
    
    if (empty($conn->errorInfo()[2])) {
        echo "sucesso";
    } else {
        echo $conn->errorInfo()[2];
    }
?>