<?php
/*
 * Método de conexão sem padrões
 */

class Connection
{
    private $bancoDeDados = "olyra";
    private $username = "root";
    private $password = "";

    public function execConnection()
    {
        $conn = "";
        try {
            $conn = new PDO('mysql:host=localhost;dbname=' . $this->bancoDeDados, $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
        return $conn;
    }
}
