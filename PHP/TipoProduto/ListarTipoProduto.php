<?php

    include '../conexao.php';
    
    $stmt = $conn->query( 'SELECT * from "comercioSoftexpert".tipo_produto');

    $result = $stmt->fetchAll();
    
    echo json_encode($result);
?>