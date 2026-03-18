<?php

function login($pdo, $username, $password){
    $stmt = $pdo->prepare('CALL sp_login(?, ?)');
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->bindParam(2, $password, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log('Error en sp_login: ' . $e->getMessage());
        return false;
    }
}

