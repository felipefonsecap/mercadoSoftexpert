<?php
    include '../conexao.php';
    $tipo = $_GET['tipo'];
    
    $stmt = $conn->prepare( 'SELECT nome, id, valor from "comercioSoftexpert".produto where tipo_produto_id = :tipo');
    $stmt->bindParam(':tipo', $tipo);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    echo json_encode($result);
?>
