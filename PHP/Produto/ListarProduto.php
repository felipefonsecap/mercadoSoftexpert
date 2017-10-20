<?php
    include '../conexao.php';
    
    $stmt = $conn->query( 'SELECT P.nome, P.id, P.valor, TP.nome as tipo from "comercioSoftexpert".produto P '
            . '             INNER JOIN "comercioSoftexpert".tipo_produto TP ON TP.id = P.tipo_produto_id');

    $result = $stmt->fetchAll();
    
    echo json_encode($result);
?>