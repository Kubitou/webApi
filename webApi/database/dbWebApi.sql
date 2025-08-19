CREATE database dbwebapi;

CREATE TABLE usuarios{
    id int auto_increment primary key
    nome varchar(50),
    email varchar(100),
    ra varchar(20),
    senha varchar(100),
    celular varchar(20)
};
