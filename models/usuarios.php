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
        function readOne() {
            $query = "select id, nome, email, ra, celular from $this->table_name where id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id',$this->id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FECH_ASSOC);
            
            $this->name = $row['nome'];
            $this->email = $row['email'];
            $this->ra = $row['ra'];
            $this->celular = $row['celular'];
        }
        function create(){
            $retorno = false;
            $query = "insert into $this->table_name (nome, email, ra, senha, celular) values (:nome, :email, :ra, :senha, :celular)";
            $stmt = $this->conn->prepare($query);
            $this->senha = password_hash($this->senha, PASSWORD_BCRYPT);
            $this->bindParam(":nome", $this->name);
            $this->bindParam(":email", $this->email);
            $this->bindParam(":ra", $this->ra);
            $this->bindParam(":senha", $this->senha);
            $this->bindParam(":celular", $this->celular);
            if($stmt->execute()){
                $retorno = true;
            }
            return $retorno;
        }
        function update(){
            $query="update $this->table_name set nome=:nome, email=:email, ra=:ra, celular=:celular where id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":nome", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":ra", $this->ra);
            $stmt->bindParam(":celular", $this->celular);
            return $stmt->execute();
        }
    }
?>