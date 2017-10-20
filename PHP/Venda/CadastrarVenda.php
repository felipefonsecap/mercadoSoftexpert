<?php

    include '../conexao.php';
    
    $lista = $_POST['lista'];
    
    $stmt = $conn->prepare(
        'INSERT INTO "comercioSoftexpert".vendas default values'
    );
    
    $stmt->execute();
    $stmt = $conn->prepare( 'SELECT max(id) as id from "comercioSoftexpert".vendas');
    $stmt->execute();
    $result = $stmt->fetchAll();
    $idVenda = $result[0]['id'];
    
    foreach ($lista as $key => $item) {
        $stmt = $conn->prepare(
            'INSERT INTO "comercioSoftexpert".item_vendas '
                . '(produto_id, '
                . 'tipo_produto_id, '
                . 'quantidade, '
                . 'valor_unitario, '
                . 'imposto_unitario, '
                . 'venda_id) '
                . 'VALUES ('
                . ':produto_id,'
                . ':tipo_produto_id,'
                . ':quantidade,'
                . ':valor_unitario,'
                . ':imposto_unitario,'
                . ':venda_id'
                . ')'
        );


        $produtoId = $item['produto_id'];
        $tipoProdutoId = $item['tipo_produto_id'];
        $quantidade = $item['quantidade'];
        $valorUnitario = $item['valor_unitario'];
        $impostoUnitario = $item['imposto_unitario'];

        $stmt->bindValue(':produto_id', $produtoId);
        $stmt->bindValue(':tipo_produto_id', $tipoProdutoId);
        $stmt->bindValue(':quantidade', $quantidade);
        $stmt->bindValue(':valor_unitario', $valorUnitario);
        $stmt->bindValue(':imposto_unitario', $impostoUnitario);
        $stmt->bindValue(':venda_id', $idVenda);
        $stmt->execute();
    }
    
    if (empty($conn->errorInfo()[2])) {
        echo "sucesso";
    } else {
        echo $conn->errorInfo()[2];
    }
?>
