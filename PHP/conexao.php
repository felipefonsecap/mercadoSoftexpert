<?php
    $user = 'postgres';
    $pass = '123456';
    
    try {
        $conn = new PDO('pgsql:host=localhost;dbname=postgres;port=5432', $user, $pass);
        $conn->exec('SET search_path TO accountschema, public');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>
