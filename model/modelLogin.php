<?php

require_once __DIR__ . "../../conexion.php";

$db = new db();
$pdo = $db->conexion();

function login($pdo, $username, $password){
    $stmt = $pdo->prepare('CALL sp_login(?, ?)');
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->bindParam(2, $password, PDO::PARAM_STR);

    try {
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        error_log('Error, no se encontro el usuario: ' . $e->getMessage());
        return false;
    }
}

function validarCrsf($token){
    $csrf_token = $_SESSION['csrf_token'];

    if(!empty($token) && !empty($csrf_token)){

        if(hash_equals($csrf_token, $token)){
            return $token;
        } else {
            return false;
        }
    } 
}

function limpiarCampos($data){
    return htmlentities(trim($data), ENT_QUOTES, 'UTF-8');
}
