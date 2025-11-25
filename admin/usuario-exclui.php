<?php

	require_once "../src/Database/Conecta.php";
	require_once "../src/Services/UsuarioServico.php";
	require_once "../src/Helpers/Utils.php";
	require_once "../src/Services/autenticacaoServicos.php";

    AutenticacaoServicos::exigirLogin();
	AutenticacaoServicos::exigirAdmin();
	$erro = null;
	$mensagem = null;
	$usuarioServico = new UsuarioServico();
	$dadosDoUsuario = [];

	$id = Utils::sanitizar($_GET['id'],'inteiro');

	if(!$id) Utils::redirecionarPara("usuarios.php");
	//$usuarioServico['nome']
	

	if( $id === $_SESSION['id'] ){
		// Neste caso, não vamos possibilitar a exclusão e vamos avisar o usuário
		$erro = "Você não pode excluir seu próprio usuário!";
	} else {
		// Caso contrário, siga em frente (carregue os dados e exclua)
		try {
			$dadosDoUsuario = $usuarioServico->buscarPorId($id);

			// Executar o método de excluir passando o id de quem será excluído
			$usuarioServico->excluirUsuario($id);
		} catch (Throwable $e) {
			// Deu ruim/erro? Dispare um erro e monte uma mensagem com os detalhes
			$erro = "Erro ao excluir usuário. <br>".$e->getMessage();
		}
	}
		




	require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">
		<h2 class="text-center">
			Excluir usuário
		</h2>
		<?php if($erro):?>
			<p class="alert alert-danger text-center"><?=$erro?></p>
		<?php endif;?>

		<?php if($mensagem):?>
			<p class="alert alert-success text-center"><?=$mensagem?></p>
		<?php endif;?>

		<div class="d-grid gap-2 d-md-block text-center">
			<a href="usuarios.php" class="btn btn-light btn-lg">Voltar</a>
		</div>


			

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>