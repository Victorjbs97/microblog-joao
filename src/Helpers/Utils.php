<?php 
    class Utils{
        public static function sanitizar(mixed $valor, string $tipoSanitizacao = 'texto'):mixed{
            
            switch($tipoSanitizacao){
                case 'inteiro':
                    return (int) filter_var($valor, FILTER_SANITIZE_NUMBER_INT);
                case 'email':
                    return trim(filter_var($valor, FILTER_SANITIZE_EMAIL));
                default:
                    return trim(filter_var($valor,FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            }
        }

        public static function codificaSenha(string $valorSenhha): string{
            
            return password_hash($valorSenhha, PASSWORD_DEFAULT);

        }

        public static function mostrarVardump(mixed $novoUsuario): void{
            echo '<pre>';
             print_r($novoUsuario);
            echo '</pre>';
            
        }
    }

?>