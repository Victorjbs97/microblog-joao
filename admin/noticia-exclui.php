<?php
    require_once "../src/Database/Conecta.php";
    require_once "../src/Services/NoticiaServico.php";
    require_once "../src/Helpers/Utils.php";
    require_once "../src/Services/autenticacaoServicos.php";
	
    AutenticacaoServicos::exigirLogin();

	$erro = null;
	$noticiaServicos = new NoticiaServico();
	$id = Utils::sanitizar($_GET['id'],'inteiro');

	if(!$id) Utils::redirecionarPara("noticias.php");

	try{
		$noticiaServicos->excluir($id,$_SESSION['id'],$_SESSION['tipo']);
	}catch( Throwable $e){
		$erro = "Erro ao excluir notícia.<br>".$e->getMessage();
	}

	require_once "../includes/cabecalho-admin.php";
?>


<div class="row">
	<article class="col-12 bg-white rounded shadow my-1 py-4">

		<h2 class="text-center">
			Excluir notícia
		</h2>
		<?php if($erro):?>
			<p class="alert alert-danger text-center"><?=$erro?></p>
		<?php else:?>
			<p class="alert alert-success text-center">A notícia foi excluida com sucesso!</p>
		<?php endif;?>

		<div class="d-grid gap-2 d-md-block text-center">
			<a href="noticias.php" class="btn btn-light btn-lg">Voltar</a>
		</div>
		

	</article>
</div>


<?php
require_once "../includes/rodape-admin.php";
?>