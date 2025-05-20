<?php
    class Database{
        private $host = 'localhost';
        private $db_name = 'dbwebapi';
        private $username = 'aluno';
        private $password = 'etec@147';
        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);

                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Erro de conexão";
            }
            return $this->conn;
        }
    };
?>