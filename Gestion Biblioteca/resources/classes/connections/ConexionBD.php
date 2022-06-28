<?php
/* ***************************************************************** Dependencias ***************************************************************** */
include_once $_SERVER['DOCUMENT_ROOT'] . "/Gestion Biblioteca/config.php";
require_once INTERFACES . "/IEjecutarSQL.php";
/* ************************************************************************************************************************************************ */

class ConexionBD implements IEjecutarSQL
{
    private $host = "localhost";
    private $bd_name = "bd_biblioteca";
    private $username = "root";
    private $password = "admin";
    private static $instancia = null;
    private  $pdo;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->bd_name", $this->username, $this->password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
            if ($this->pdo instanceof PDO) {
                return $this->pdo;
            } else {
                throw new Exception("Database not found");
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public static function getInstance(){
        if(IS_NULL(self::$instancia)){
            self::$instancia = new self();
        }
        return self::$instancia;
    }
    public function getconexion(){
        return $this->pdo;
    }
    function ejecutaSQL($sql)
    {
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}