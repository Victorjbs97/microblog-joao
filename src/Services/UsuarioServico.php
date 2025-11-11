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

        public function buscarPorId(int $valorId):?array{
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id",$valorId);
            $consulta->execute();


            /* Sobre o ?: conhecido como "Elvis Operator" 
            É uma condicional simplificada/abreviada em que, 
            se a condição/expressão for válida (ou seja, tem dados),
            ela mesma é retornada. Caso contrário, é retornado null */
            return $consulta->fetch() ?: null; 
        }

        public function atualizar(Usuario $dadosDoUsuario):void{
            $sql = "UPDATE usuarios SET
            nome = :nome, 
            email = :email,
            tipo = :tipo,
            senha = :senha
            WHERE id = :id";
        
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":nome", $dadosDoUsuario->getNome());
            $consulta->bindValue(":email", $dadosDoUsuario->getEmail());
            $consulta->bindValue(":tipo", $dadosDoUsuario->getTipo());
            $consulta->bindValue(":senha", $dadosDoUsuario->getSenha());
            $consulta->bindValue(":id", $dadosDoUsuario->getId());

            $consulta->execute();
        }

        public function excluirUsuario(int $idUsuario):void{
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $consulta = $this->conexao->prepare($sql);
            $consulta->bindValue(":id",$idUsuario, PDO::PARAM_INT);
            $consulta->execute();

        }
        
    }

?>