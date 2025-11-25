<?php 
    class AutenticacaoServicos{

        public static function iniciarSessao():void{

            if(session_status()!==PHP_SESSION_ACTIVE){
                session_start();
            }
        }

        public static function exigirLogin():void{
            //Verificando se tem sesssão 
            self::iniciarSessao();
            if(!isset($_SESSION['id'])){
                Utils::redirecionarPara("../login.php?acesso_proibido");
            }
        }

        public static function login(int $valorId, string $valorNome, string $valorTipo){
            self::iniciarSessao();

            //Criando variáveis de sessão com os dados informados

            $_SESSION['id'] = $valorId;
            $_SESSION['nome'] = $valorNome;
            $_SESSION['tipo'] = $valorTipo;

            Utils::redirecionarPara("admin/");
        }

        public static function logout():void {
            self::iniciarSessao();
            session_destroy();
            Utils::redirecionarPara("../login.php?saiu");
        }
        public static function exigirAdmin():void {
            self::iniciarSessao();

            if($_SESSION['tipo'] !== 'admin'){
                Utils::redirecionarPara("nao-autorizado.php");
            }
    }

    }



?>