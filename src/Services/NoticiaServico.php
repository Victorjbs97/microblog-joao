<?php 
// src/Services/NoticiaServico.php

class NoticiaServico {
    private PDO $conexao;

    public function __construct() {
        $this->conexao = Conecta::getConexao();        
    }

    public function buscar(string $tipoUsuario, int $idUsuario):array {
        
        if($tipoUsuario === 'admin'){
            $sql = "SELECT  
                        noticias.id,
                        noticias.titulo,
                        noticias.data,
                        usuarios.nome AS autor
                    FROM noticias JOIN usuarios
                    ON noticias.usuario_id = usuarios.id                
                    ORDER BY data DESC";
        } else {
            $sql = "SELECT id, titulo, data FROM noticias
                    WHERE usuario_id = :usuario_id
                    ORDER BY data DESC";
        }

        $consulta = $this->conexao->prepare($sql);
        
        if($tipoUsuario !== 'admin'){
            $consulta->bindValue(":usuario_id", $idUsuario);
        }
        
        $consulta->execute();
        return $consulta->fetchAll();
    }
    public function inserir(Noticia $dadosNoticia):void {
        $sql = "INSERT INTO noticias(
                    titulo, texto, resumo, imagem, usuario_id
                ) VALUES(
                    :titulo, :texto, :resumo, :imagem, :usuario_id
                )";
        
        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(":titulo", $dadosNoticia->getTitulo());
        $consulta->bindValue(":texto", $dadosNoticia->getTexto());
        $consulta->bindValue(":resumo", $dadosNoticia->getResumo());
        $consulta->bindValue(":imagem", $dadosNoticia->getImagem());
        $consulta->bindValue(":usuario_id", $dadosNoticia->getUsuarioId());

        $consulta->execute();
    }

    public function buscarPorId( 
        int $idNoticia, string $tipoUsuario, int $idUsuario ): ?array {

        /* Se for um admin... */
        if($tipoUsuario === 'admin'){
            /* Pode buscar/exibir qualquer notícia, bastando saber o id da noticia */
            $sql = "SELECT * FROM noticias WHERE id = :id";
        } else {
            /* Senão, pode buscar/exibir qualquer notícia desde que seja dele/dela própria */
            $sql = "SELECT * FROM noticias WHERE id = :id AND usuario_id = :usuario_id";
        }

        $consulta = $this->conexao->prepare($sql);
        $consulta->bindValue(":id", $idNoticia); // fica fora do if pq é usado nos 2 sql

        if($tipoUsuario !== 'admin'){
            // Fica dentro do if pq é usado apenas no sql do editor
            $consulta->bindValue(":usuario_id", $idUsuario);
        }

        $consulta->execute();
        return $consulta->fetch() ?: null;
    }

    public function atualizar(Noticia $noticia, string $tipoUsuario):void{
        if($tipoUsuario === 'admin'){
            $sql = "UPDATE noticias SET
                        titulo = :titulo,
                        texto = :texto,
                        resumo = :resumo,
                        imagem = :imagem
                    WHERE id = :id";
        }else{
            $sql = "UPDATE noticias SET
                        titulo = :titulo,
                        texto = :texto,
                        resumo = :resumo,
                        imagem = :imagem
                    WHERE id = :id AND usuario_id = :usuario_id";

        }

        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(":titulo", $noticia->getTitulo());
        $consulta->bindValue(":texto", $noticia->getTexto());
        $consulta->bindValue(":resumo", $noticia->getResumo());
        $consulta->bindValue(":imagem", $noticia->getImagem());
        $consulta->bindValue(":id", $noticia->getId());
        
        if($tipoUsuario !== 'admin'){
            $consulta->bindValue(":usuario_id", $noticia->getUsuarioId());
        }
        
        $consulta->execute();
    }
    // admin/noticias-excluir.php
    public function excluir(int $idNoticia, int $idUsuario, string $tipoUsuario):void{
        if($tipoUsuario ==='admin'){
            $sql = "DELETE FROM noticias WHERE id = :id";
        }else{
            $sql = "DELETE FROM noticias WHERE id = :id AND usuario_id = :usuario_id";
        }

        $consulta = $this->conexao->prepare($sql);

        $consulta->bindValue(":id", $idNoticia);

        if($tipoUsuario !== 'admin'){
            $consulta->bindValue(":usuario_id", $idUsuario);
        }

        $consulta->execute();
    }

    /* Métodos para a área pública do site. */

    public function buscarNoticiasParaAreaPublica():array{
        $sql = "SELECT id,titulo, resumo, imagem FROM noticias ORDER BY data DESC";

        $consulta = $this->conexao->query($sql);
        return $consulta->fetchAll();
    }
}