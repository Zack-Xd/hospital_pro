<?php

require_once __DIR__ . "\..\conexion.php";

class SQLmodel extends db{

    protected $pdo;

    public function __construct()
    {
        $this->pdo = $this->conexion();
    }

    public function consultaSimple($sql, $params){
        if(!$sql){
            throw new Exception("Consulta de base de datos no puede estar vacía");
        } 
        if(!$this->pdo){
            throw new Exception("No se pudo establecer conexión a la base de datos");
        }
        if($params && is_array($params)){
            $stmt = $this->pdo->prepare("CALL " . $sql);
            $i = 1;
            foreach($params as $param){
                $stmt->bindValue($i, $param['value'], $param['type']);
                $i++;
            }
        } else {
            $stmt = $this->pdo->prepare("CALL " . $sql);
        }

        try {
            $stmt->execute();
            $data = [];
            if ($stmt->columnCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            return $data;
            } else {
                return true;
            }

        } catch (PDOException $e) {
            error_log("Error en consulta SQL: " . $e->getMessage());
            throw new Exception("Error al ejecutar consulta SQL");
        }
    }
}