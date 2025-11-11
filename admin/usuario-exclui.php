<?php

	require_once "../src/Services/UsuarioServico.php";
	require_once "../src/Database/Conecta.php";
	$erro = null;
	$mensagem = null;
	$id=$_GET['id'];
	$usuarioServico = new UsuarioServico();

	
	try{
		$usuarioServico->excluirUsuario($id);
		
		$mensagem = "Usuário excluido com sucesso!";
	}catch(Throwable $e){
		$erro = "Erro ao excluir usuário. <br>". $e->getMessage();
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