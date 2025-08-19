<?php
    class Database{
        private $host = 'carmine';
        private $db_name = '3dsa_webapi';
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