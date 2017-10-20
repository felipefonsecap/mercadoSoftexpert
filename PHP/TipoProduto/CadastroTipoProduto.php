<?php

    include '../conexao.php';
    
    //$sql = $conn->query('INSERT INTO "comercioSoftexpert".tipo_produto (id, nome, imposto) VALUES (3, \'teste\', 10.5)');
    $stmt = $conn->prepare(
        'INSERT INTO "comercioSoftexpert".tipo_produto (nome, imposto) VALUES (:nome, :imposto)'
    );

   
    $nome = $_POST['nome'];
    $imposto = $_POST['imposto'];

    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':imposto', $imposto);
    $stmt->execute();
    
    if (empty($conn->errorInfo()[2])) {
        echo "sucesso";
    } else {
        echo $conn->errorInfo()[2];
    }
?>