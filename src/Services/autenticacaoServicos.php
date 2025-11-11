<?php 
    class autenticacaoServicos{

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


    }



?>