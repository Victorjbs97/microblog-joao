<?php 
    //  src/Services/UsuarioServico.php

    class UsuarioServico{
        private PDO $conexao;

        public function __construct(){
            /* Toda vez que criamors um objeto baseada na classe de serviços, esse objeto 
            fará a chamada com ométodo de conexão com a classe Conecta. */
            $this->conexao = Conecta::getConexao();
        }

        public function inserir(Usuario $dadosDoUsuario):void{
            $sql = "INSERT INTO usuarios(nome,email,tipo,senha) VALUES(:nome,:email,:tipo,:senha) ";

            $consulta = $this->conexao->prepare($sql);

            $consulta->bindValue(":nome",$dadosDoUsuario->getNome());
            $consulta->bindValue(":email",$dadosDoUsuario->getEmail());
            $consulta->bindValue(":tipo",$dadosDoUsuario->getTipo());
            $consulta->bindValue(":senha",$dadosDoUsuario->getSenha());

            $consulta->execute();
        }

        public function buscar():array{
            $sql = "SELECT * FROM usuarios ORDER BY nome";
            $consulta = $this->conexao->query($sql);
            return $consulta->fetchAll();
        }
        
    }

?>