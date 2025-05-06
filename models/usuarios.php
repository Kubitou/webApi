<?php
    class Usuario{
        private $conn;
        private $table_name = "usuarios";

        public $id;
        public $name;
        public $email;
        public $ra;
        public $senha;
        public $celular;

        public function __construct($db){
            $this->conn = $db;
        }
        function read(){
            $query = "select id, nome, email, ra, celular from $this->table_name order by nome asc";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
    }
?>