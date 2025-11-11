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


        /* Ao chamar o método verificarSenha, passamos pra ele
        a senha digitada no formulário e a senha existente no banco. */
        public static function verificarSenha(string $senhaDigitadaNoFornulario, string $senhaArmazenadaNoBanco): string{
             /* Usamos o password_verify para COMPARAR as duas senhas. */
            if(password_verify($senhaDigitadaNoFornulario,$senhaArmazenadaNoBanco)){
                // São iguais? Então retorne a mesma senha já existente no banco
                return $senhaArmazenadaNoBanco;
            }else{
                 // São diferentes? Então pega a senha digitada e faça um novo hash
                return self::codificaSenha($senhaDigitadaNoFornulario);
            }
        }

        public static function mostrarVardump(mixed $novoUsuario): void{
            echo '<pre>';
             print_r($novoUsuario);
            echo '</pre>';
            
        }

        public static function redirecionarPara(string $caminho):void{
            header("location:".$caminho);
            exit;
        }
    }

?>